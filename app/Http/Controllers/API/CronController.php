<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CompaniesSetting;
use App\Models\Companies;
use App\Models\CompanyDetail;
use App\Classes\Intrinio;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical;

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
            $companies = Companies::where('FCF_last_updated','<',"$date")
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
            return json_encode(["error"=>'success',"code"=>200]);
        else:
            dd("Please provide valid API key");
        endif;

    }

    public function saveDCF($key){

        if($key==$this->key):
            $date = date('Y-m-d H:i:s',strtotime('-150 hours'));
            $ndate = date('Y-m-d H:i:s');
            $companies = Companies::where('DCF_last_updated','<',"$date")
                ->orderBy('company_id','ASC')
                ->take('25')
                ->get()
                ->toArray();
            foreach ($companies as $c):
                $fcf = $this->calculateDCF($c['id']);
                Companies::where('company_id',$c['company_id'])->update(
                    [
                        "DCF" => $fcf,
                        "DCF_last_updated" => $ndate
                    ]
                );
            endforeach;
            return json_encode(["error"=>'success',"code"=>200]);
        else:
            dd("Please provide valid API key");
        endif;

    }

    public function saveTB($key){

        if($key==$this->key):
            $date = date('Y-m-d H:i:s',strtotime('-150 hours'));
            $ndate = date('Y-m-d H:i:s');
            $companies = Companies::where('TB_last_updated','<',"$date")
                ->orderBy('company_id','ASC')
                ->take('25')
                ->get()
                ->toArray();
            foreach ($companies as $c):
                $fcf = $this->calculateTB($c['id']);
                Companies::where('company_id',$c['company_id'])->update(
                    [
                        "TB" => $fcf,
                        "TB_last_updated" => $ndate
                    ]
                );
            endforeach;
            return json_encode(["error"=>'success',"code"=>200]);
        else:
            dd("Please provide valid API key");
        endif;

    }

    public function savePL($key){

        if($key==$this->key):
            $date = date('Y-m-d H:i:s',strtotime('-150 hours'));
            $ndate = date('Y-m-d H:i:s');
            $companies = Companies::where('PL_last_updated','<',"$date")
                ->orderBy('company_id','ASC')
                ->take('25')
                ->get()
                ->toArray();
            foreach ($companies as $c):
                $fcf = $this->calculatePL($c['id']);
                Companies::where('company_id',$c['company_id'])->update(
                    [
                        "PL" => $fcf,
                        "PL_last_updated" => $ndate
                    ]
                );
            endforeach;
            return json_encode(["error"=>'success',"code"=>200]);
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

    private function calculateFCF($id){

        $ebitpershare = $this->ebitpershare($id);
        if(count($ebitpershare["z"])>0):
            $CAGR = $this->getCagr($ebitpershare['z'])*100;
        else:
            $CAGR = 0;
        endif;

        if(count($ebitpershare["x"])>0 && count($ebitpershare["y"])>0):
            $LINEST  = $this->getLinest($ebitpershare);
            if(is_array($LINEST)){
                $growthRate = (pow(10,$LINEST[0])-1)*100;
            }else{
                $growthRate = 0;
            }

        else:
            $growthRate = 0;
        endif;

        if($CAGR > 0 || $growthRate > 0):
            $avgCAGR = floor(($growthRate+$CAGR)/2);
        else:
            $avgCAGR = 0;
        endif;

        if($avgCAGR<4):
            $g1 = 4;
        else:
            $g1 = $avgCAGR;
        endif;

        if($avgCAGR>20):
            $g1 = 20;
        endif;
        $avgFreeCashFlows = (Intrinio::data_tag_avg_yearly($id,'netcashfromoperatingactivities')-Intrinio::data_tag_avg_yearly($id,'capex'))/1000000;
        $growthMultiple = 8.3459 * pow(1.07, $g1-4);
        $totalEquity = Intrinio::data_tag_qtr($id,'totalequity');
        if(count($totalEquity)>0):
            $totalEquity = $totalEquity[0]->value/1000000;
        else:
            $totalEquity = 0;
        endif;
        $FutCF = ($growthMultiple*$avgFreeCashFlows)+(0.75*$totalEquity);
        $dilShareOut = Intrinio::data_tag_avg_yearly($id,'weightedavedilutedsharesos');
        if($dilShareOut>0):
            $dilShareOut = $dilShareOut /1000000;
            $FutCF = $FutCF/$dilShareOut;
        else:
            $FutCF = 0;
        endif;


        return $FutCF;
    }

    private function calculateDCF($id){

        $dilutedSharesCashflow       = Intrinio::data_tag_yearly($id,'weightedavedilutedsharesos');

        if(count($dilutedSharesCashflow)>0):
            $dilutedSharesCashflow       = $dilutedSharesCashflow[0]->value/1000000;
        else:
            $dilutedSharesCashflow       = 0;
        endif;

        return $dilutedSharesCashflow;
    }

    private function calculateTB($id){
        $dilutedSharesOutstanding   = Intrinio::data_tag_qtr($id,'weightedavedilutedsharesos')[0]->value/1000000;
        $totalEquity                = Intrinio::data_tag_qtr($id,'totalequity')[0]->value/1000000;
        $totalPreferedEquity        = Intrinio::data_tag_qtr($id,'totalpreferredequity')[0]->value/1000000;
        $intengibleAssets           = Intrinio::data_tag_qtr($id,'intangibleassets')[0]->value/1000000;
        $goodWill                   = Intrinio::data_tag_qtr($id,'goodwill')[0]->value/1000000;
        $TB = ($totalEquity - $totalPreferedEquity - ($intengibleAssets + $goodWill)) / $dilutedSharesOutstanding;

        return $TB;
    }

    private function calculatePL($id){

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




    private function ebitpershare($id){

        $ebitArr  = Intrinio::data_tag_yearly($id,'ebit');
        $shareArr = Intrinio::data_tag_yearly($id,'weightedavedilutedsharesos');
        $avg = $this->getAvg($shareArr);
        $arr = [
            'x' => [],
            'y' => [],
            'z' => [],
            'detail' => []
        ];
        $y = 0;
        $coun = count($ebitArr);
        if($coun > count($shareArr)):
            $coun = count($shareArr);
        endif;
        for($i=$coun-1;$i>=0;$i--):

            $x = (object)[];
            $x->count     = $y;
            $x->date      = $ebitArr[$i]->date;
            if($shareArr[$i]->value==0):
                $shareArr[$i]->value = $avg;
            endif;
            $x->ebitpershare = abs($ebitArr[$i]->value/$shareArr[$i]->value);
            $x->log10 = log10($x->ebitpershare);

            //echo $revArr[$i]->value."/".$shareArr[$i]->value."=".$x.'<br>';
            array_push($arr['detail'],$x);
            array_push($arr['x'],$x->log10);
            array_push($arr['y'],$x->count);
            array_push($arr['z'],$x->ebitpershare);
            $y++;
        endfor;
        return $arr;
    }

    private function getAvg($d){
        $count = 0;
        $val = 0;
        foreach($d as $a):
            $val = $val+$a->value;
            $count++;
        endforeach;
        if($count>0):
            return $val/$count;
        else:
            return 0;
        endif;
    }

    private  function getLinest($d){
        $stats = new Statistical();
        $stat = $stats->LINEST($d['x'],$d['y']);
        return $stat;
    }

    private  function getCagr($d){

        $count = count($d);
        if($count>0):
            $tot = $d[$count-1]/$d[0];

            $exp = pow($tot,1/($count));
            $cagr = $exp-1;
            return $cagr;
        else:
            return 0;
        endif;

    }
}
