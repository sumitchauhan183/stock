<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CompaniesSetting;
use App\Models\Companies;
use App\Models\CompanyDetail;
use App\Classes\Intrinio;

class CronController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $key;
    private $size = 1000;
    public function __construct()
    {
       $this->key = env('CRON_API_KEY');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return "Wrong page";
    }

    public function saveCompanies($key){

        if($key==$this->key):
            $settings = CompaniesSetting::get()->first();
            if($settings):
                $companies = Intrinio::getAllCompanies($this->size,$settings->next_page_id);
                $count = $settings->total_companies_added+$this->saveCompanyDetails($companies->companies);
                if($companies->next_page):
                    $this->saveCompanySettings($count,$settings->next_page_id,$companies->next_page);
                endif;
            else:
               $companies = Intrinio::getAllCompanies($this->size,'');
               $count = $this->saveCompanyDetails($companies->companies);
               $this->saveCompanySettings($count,'',$companies->next_page);
            endif;
        else:
            dd("Please provide valid API key");
        endif;

    }

    public function saveEPV($key){

        if($key==$this->key):
        $date = date('Y-m-d H:i:s',strtotime('-24 hours'));
        $ndate = date('Y-m-d H:i:s');
        $companies = Companies::where('EPV_last_updated','<',"$date")
                                ->orderBy('company_id','ASC')
                                ->take('25')
                                ->get()
                                ->toArray();
        foreach ($companies as $c):
            $epv = $this->calculateEPV($c['id']);
            Companies::where('company_id',$c['company_id'])->update(
                [
                    "EPV" => $epv,
                    "EPV_last_updated" => $ndate
                ]
            );
        endforeach;

        else:
            dd("Please provide valid API key");
        endif;

    }

    public function saveFCF($key){

        if($key==$this->key):
            $date = date('Y-m-d H:i:s',strtotime('-150 hours'));
            $ndate = date('Y-m-d H:i:s');
            $companies = Companies::where('FCF_last_updated','>',"$date")
                ->orderBy('company_id','ASC')
                ->take('25')
                ->get()
                ->toArray();
            foreach ($companies as $c):
                $fcf = $this->calculateFCF($c['id']);
                Companies::where('company_id',$c['company_id'])->update(
                    [
                        "FCF" => $fcf,
                        "FCF_last_updated" => $ndate
                    ]
                );
            endforeach;

        else:
            dd("Please provide valid API key");
        endif;

    }

    public function saveCompanyDetail($key){

        if($key==$this->key):
            $companies = Companies::where('details_saved',0)
                ->orderBy('company_id','ASC')
                ->take('100')
                ->get()
                ->toArray();
            foreach($companies as $c):
                $detail = Intrinio::companDetail($c['id']);
                $this->addUpdateCompanyDetail($c['company_id'],$detail);
            endforeach;
        else:
            dd("Please provide valid API key");
        endif;

    }

    private function addUpdateCompanyDetail($id,$detail){
        $check = CompanyDetail::where('company_id',$id)
            ->get()
            ->count();
        if($check==0):
            $detail->company_id = $id;
            $save = CompanyDetail::create((array)$detail);
            if($save):
                Companies::where('company_id',$id)->update(['details_saved'=>1]);
            endif;
        endif;
    }

    private function calculateEPV($id){
        $avgOperatingmargin         = Intrinio::avgFiveYearOperatingMargin($id);
        $avgRevenue                 = Intrinio::avgSustainableRevenue($id)/1000000;
        $avgSGA                     = Intrinio::avgFiveYearSGA($id)/1000000;
        $avgtaxRate                 = Intrinio::avgFiveYearTaxRate($id);
        $avgDDA                     = (Intrinio::avgFiveYearDDA($id)/1000000)*4;
        $excessDepriciation         = $avgDDA * 0.5 * $avgtaxRate;
        $revenue                    = Intrinio::revenueArray($id);
        $CAPEX                      = Intrinio::CAPEXArray($id);
        $netppe                     = Intrinio::netppeArray($id);
        $capitalLeaseObligation     = Intrinio::capitalLeaseObligation($id)/1000000;
        $dilutedSharesOutstanding   = isset(Intrinio::data_tag($id,'weightedavedilutedsharesos')[0])?Intrinio::data_tag($id,'weightedavedilutedsharesos')[0]->value/1000000:0;
        $longTermDebt               = isset(Intrinio::data_tag($id,'longtermdebt')[0])?Intrinio::data_tag($id,'longtermdebt')[0]->value/1000000:0;
        $shortTermDebt              = isset(Intrinio::data_tag($id,'shorttermdebt')[0])?Intrinio::data_tag($id,'shorttermdebt')[0]->value/1000000:0;
        $intBearDebt                = $longTermDebt + $shortTermDebt + $capitalLeaseObligation;
        $cashandequi                = isset(Intrinio::data_tag($id,'cashandequivalents')[0])?Intrinio::data_tag($id,'cashandequivalents')[0]->value/1000000:0;
        $wacc                       = 0.09;

        $c = (object) [];
        $c->CAPEXpos               =  $this->capexpositive($CAPEX);
        $c->revenueChange          =  $this->changeInRevenue($revenue);
        $c->revenueTTM             =  $this->revenueTTM($revenue);
        $c->ppeToRevenueTTM        =  $this->ppetorevenuettm($netppe,$c->revenueTTM);
        $c->maintainanceCAPEXnoCon =  $this->maintainanceCapexnocon($c);
        $maintainanceCAPEX         =  $this->maintainanceCapex($c);
        $avgmaintainanceCAPEX      =  $this->avgmaintainanceCapex($maintainanceCAPEX);

        $normalizedEbit             = ($avgRevenue*$avgOperatingmargin)+$avgSGA;
        $normalizedEbitAfterTax     = $normalizedEbit * (1-$avgtaxRate);
        $normalizedEarnings         = $normalizedEbitAfterTax + $excessDepriciation;


        if($dilutedSharesOutstanding!=0):
            $EPV =  ((($normalizedEarnings-$avgmaintainanceCAPEX) / $wacc) + $cashandequi - $intBearDebt ) / $dilutedSharesOutstanding;
            return $EPV;
        endif;
        return 0;
    }

    private function ppetorevenuettm($ppe,$revttm){
        $x = count($ppe);
        $data = [];
        $d = $revttm;
        foreach($d as $r):
            $x--;
            if($x>=0):
                if($r==0):
                    $cal = 0;
                else:
                    $cal = $ppe[$x]->value/$r;
                endif;
                array_push($data,$cal);
            endif;
        endforeach;
        return $data;
    }

    private function maintainanceCapexnocon($c){

        $w = count($c->revenueChange);
        $x = count($c->ppeToRevenueTTM);
        $y = count($c->CAPEXpos);

        $revChx = count($c->revenueChange)-1;
        $revttx = count($c->ppeToRevenueTTM)-1;
        $caposx = count($c->CAPEXpos)-1;


        $data = [];
        $d = $c->ppeToRevenueTTM;
        foreach($d as $r):
            $w--;
            $x--;
            $y--;
            if(($caposx-$y)<count($c->CAPEXpos) && ($revttx-$x) < count($c->ppeToRevenueTTM) && ($revChx-$w)<count($c->revenueChange)):
                $cal = $c->CAPEXpos[$caposx-$y]-$c->ppeToRevenueTTM[$revttx-$x]*$c->revenueChange[$revChx-$w];
                array_push($data,$cal);
            endif;
        endforeach;
        //dd($data);
        return $data;
    }

    private function revenueTTM($revenue){
        //dd($revenue);
        $x = count($revenue);
        $top1 = count($revenue)-1;
        $top2 = count($revenue)-2;
        $data = [];
        $d = $revenue;
        foreach($d as $r):
            $x--;
            if($x==$top1):
                $cal = $d[$x]->value + $d[$x-1]->value;
                array_push($data,$cal);
            elseif($x==$top2 && $top2 > 1):
                $cal = $d[$x]->value + $d[$x-1]->value + $d[$x-2]->value;
                array_push($data,$cal);
            elseif($x>1):
                $cal = $d[$x+2]->value + $d[$x+1]->value + $d[$x]->value + $d[$x-1]->value;
                array_push($data,$cal);
            elseif($x<1 && ($x+3) < count($revenue) ):
                $cal = $d[$x+3]->value + $d[$x+2]->value + $d[$x+1]->value + $d[$x]->value;
                array_push($data,$cal);
            endif;
        endforeach;
        return $data;
    }

    private function capexpositive($capex){
        $x = count($capex);
        $data = [];
        $d = $capex;
        foreach($d as $r):
            $x--;
            $cal = 0;
            if($r->value >= 0):
                $cal = $r->value;
            endif;
            //$data[$x] = $cal;
            array_push($data,$cal);
        endforeach;
        $arr = [];
        for($i=count($data)-1;$i>=0;$i--):
            array_push($arr,$data[$i]);
        endfor;
        return $arr;
    }

    private function changeInRevenue($revenue){
        $x = count($revenue);
        $data = [];
        $d = $revenue;
        foreach($d as $r):
            $x--;
            if($x>0):
                $cal = $d[$x-1]->value - $d[$x]->value;
                array_push($data,$cal);
            endif;
        endforeach;
        return $data;
    }

    private function maintainanceCapex($c){

        $x = 0;
        $data = [];
        $d = $c->revenueChange;
        foreach($d as $r):
            if(isset($c->maintainanceCAPEXnoCon[$x]) && isset($c->CAPEXpos[$x])):
                if($c->revenueChange[$x] <= 0):
                    $cal = $c->CAPEXpos[$x];
                else:
                    if($c->revenueTTM[$x]==0):
                        $cal = $c->CAPEXpos[$x];
                    else:

                        if($c->maintainanceCAPEXnoCon[$x]<=0):
                            $cal = $c->CAPEXpos[$x];
                        else:
                            $cal = $c->maintainanceCAPEXnoCon[$x];
                        endif;
                    endif;
                endif;
                array_push($data,$cal);
            endif;
            $x++;
        endforeach;
        return $data;
    }

    private function avgmaintainanceCapex($c){
        if(count($c)>0):
            $x = 0;
            $data = 0;
            foreach($c as $r):
                if($r>0){
                    $x++;
                    $data = $data+$r;
                }
            endforeach;
            //echo ($data/$x)*4;die();
            return (($data/$x)*4)/1000000;
        endif;
        return 0;
    }

    private function saveCompanySettings($count,$last,$next){
        CompaniesSetting::truncate();
        CompaniesSetting::create([
            "total_companies_added"=>$count,
            "last_page_id"=>$last,
            "next_page_id"=>$next
        ]);
    }

    private function saveCompanyDetails($companies){
        $count = 0;
        foreach ($companies as $c):
            $check = Companies::where('id',$c->id)->get()->count();
            if(!$check):
                Companies::create(
                    [
                        "id"     => $c->id,
                        "ticker" => $c->ticker,
                        "name"   => $c->name,
                        "lei"    => $c->lei,
                        "cik"    => $c->cik
                    ]
                );
                $count++;
            endif;
        endforeach;
        return $count;
    }


}
