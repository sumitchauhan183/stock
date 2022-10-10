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
    public function index(){
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
            return json_encode(["error"=>'success',"code"=>200]);
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
                if(is_nan($epv)):
                    $epv = 0;
                endif;
                Companies::where('company_id',$c['company_id'])->update(
                    [
                        "EPV" => $epv,
                        "EPV_last_updated" => $ndate
                    ]
                );
            endforeach;
            return json_encode(["error"=>'success',"code"=>200]);
        else:
            dd("Please provide valid API key");
        endif;

    }

    public function saveFCF($key){

        if($key==$this->key):
            $date = date('Y-m-d H:i:s',strtotime('-24 hours'));
            $ndate = date('Y-m-d H:i:s');
            $companies = Companies::where('FCF_last_updated','<',"$date")
                ->orderBy('company_id','ASC')
                ->take('25')
                ->get()
                ->toArray();
            foreach ($companies as $c):
                $fcf = $this->calculateFCF($c['id']);
                if(is_nan($fcf)):
                    $fcf = 0;
                endif;
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
            $date = date('Y-m-d H:i:s',strtotime('-24 hours'));
            $ndate = date('Y-m-d H:i:s');
            $companies = Companies::where('DCF_last_updated','<',"$date")
                ->orderBy('company_id','ASC')
                ->take('25')
                ->get()
                ->toArray();
            foreach ($companies as $c):
                $dcf = $this->calculateDCF($c['id']);
                if(is_nan($dcf)):
                    $dcf = 0;
                endif;
                Companies::where('company_id',$c['company_id'])->update(
                    [
                        "DCF" => $dcf,
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
            $date = date('Y-m-d H:i:s',strtotime('-24 hours'));
            $ndate = date('Y-m-d H:i:s');
            $companies = Companies::where('TB_last_updated','<',"$date")
                ->orderBy('company_id','ASC')
                ->take('25')
                ->get()
                ->toArray();
            foreach ($companies as $c):
                $tb = $this->calculateTB($c['id']);
                if(is_nan($tb)):
                    $tb = 0;
                endif;
                Companies::where('company_id',$c['company_id'])->update(
                    [
                        "TB" => $tb,
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
            $date = date('Y-m-d H:i:s',strtotime('-24 hours'));
            $ndate = date('Y-m-d H:i:s');
            $companies = Companies::where('PL_last_updated','<',"$date")
                ->orderBy('company_id','ASC')
                ->take('25')
                ->get()
                ->toArray();
            foreach ($companies as $c):
                $pl = $this->calculatePL($c['id']);
                if(is_nan($pl)):
                    $pl = 0;
                endif;
                Companies::where('company_id',$c['company_id'])->update(
                    [
                        "PL" => $pl,
                        "PL_last_updated" => $ndate
                    ]
                );
            endforeach;
            return json_encode(["error"=>'success',"code"=>200]);
        else:
            dd("Please provide valid API key");
        endif;

    }

    public function saveGRAHAM($key){

        if($key==$this->key):
            $date = date('Y-m-d H:i:s',strtotime('-24 hours'));
            $ndate = date('Y-m-d H:i:s');
            $companies = Companies::where('GRAHAM_last_updated','<',"$date")
                ->orderBy('company_id','ASC')
                ->take('25')
                ->get()
                ->toArray();
            foreach ($companies as $c):
                $GRAHAM = $this->calculateGRAHAM($c['id']);
                if(is_nan($GRAHAM)):
                    $GRAHAM = 0;
                endif;
                Companies::where('company_id',$c['company_id'])->update(
                    [
                        "GRAHAM" => $GRAHAM,
                        "GRAHAM_last_updated" => $ndate
                    ]
                );
            endforeach;
            return json_encode(["error"=>'success',"code"=>200]);
        else:
            dd("Please provide valid API key");
        endif;

    }

    public function saveFinRat($key){

        if($key==$this->key):
            $date = date('Y-m-d H:i:s',strtotime('-24 hours'));
            $ndate = date('Y-m-d H:i:s');
            $companies = Companies::where('FRating_last_updated','<',"$date")
                ->orderBy('company_id','ASC')
                ->take('25')
                ->get()
                ->toArray();
            foreach ($companies as $c):
                $FinRat = $this->calculateFinancialRating($c['id']);

                if(is_nan($FinRat->afterWeightRating['weight'])):
                    $FinRat = 0;
                endif;

                if(is_nan($FinRat->ebitRating['rating'])):
                    $ebrat = 0;
                else:
                    $ebrat = $FinRat->ebitRating['rating'];
                endif;

                if(is_nan($FinRat->OperatingIncomeRating['rating'])):
                    $oirat = 0;
                else:
                    $oirat = $FinRat->OperatingIncomeRating['rating'];
                endif;

                if(is_nan($FinRat->OPCPERCURDEBTRating['rating'])):
                    $opcplrat = 0;
                else:
                    $opcplrat = $FinRat->OPCPERCURDEBTRating['rating'];
                endif;

                if(is_nan($FinRat->quickRatioRating['rating'])):
                    $qrrat = 0;
                else:
                    $qrrat = $FinRat->quickRatioRating['rating'];
                endif;

                if(is_nan($FinRat->DtoERating['rating'])):
                    $dterat = 0;
                else:
                    $dterat = $FinRat->DtoERating['rating'];
                endif;

                if(is_nan($FinRat->freecashflowRating['rating'])):
                    $fcfrat = 0;
                else:
                    $fcfrat = $FinRat->freecashflowRating['rating'];
                endif;

                Companies::where('company_id',$c['company_id'])->update(
                    [
                        "financial_rating" => $FinRat,
                        'ebit_rating'=>$ebrat,
                        'operating_income_rating'=>$oirat,
                        'opinc_per_liab_rating'=>$opcplrat,
                        'quick_ratio_rating'=>$qrrat,
                        'DtoE_rating'=>$dterat,
                        'freecashflow_rating'=>$fcfrat,
                        "FRating_last_updated" => $ndate
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
            return json_encode(["error"=>'success',"code"=>200]);
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

    private function calculateFCF($id){

        $c = (object)[];
        $c->ticker = $id;

        $c->ebit_per_share = $this->ebitpershare($id);
        if(count($c->ebit_per_share['z'])>0):
            $c->CAGR = $this->getCagr($c->ebit_per_share['z'])*100;
        else:
            $c->CAGR = 0;
        endif;

        if(count($c->ebit_per_share["x"])>0 && count($c->ebit_per_share["y"])>0):
            $c->LINEST  = $this->getLinest($c->ebit_per_share);
            if(is_array($c->LINEST)):
                $c->growthRate = round((pow(10,$c->LINEST[0])-1)*100,2);
            else:
                $c->growthRate = 0;
            endif;
        else:
            $c->growthRate = 0;
        endif;

        if($c->CAGR != 0 || $c->growthRate != 0):
            $c->avgCAGR = round(($c->growthRate+$c->CAGR)/2,2);
        else:
            $c->avgCAGR = 0;
        endif;

        if($c->avgCAGR<=4.5):
            $c->avgCAGR = 4.5;
        elseif($c->avgCAGR>=12):
            $c->avgCAGR = 12;
        endif;

        $c->exponent_base = 6.8512;


        $c->e = 2.71828;
        $c->base = 6.9961;
        $c->e_power = pow( $c->e, $c->exponent_base*($c->avgCAGR/100));
        $c->growthMultiple = round($c->base * $c->e_power,2);

        $c->totalEquity = Intrinio::data_tag_yearly($id,'totalequity');
        if(count($c->totalEquity)>0):
            $c->totalEquity = $c->totalEquity[0]->value/1000000;
        else:
            $c->totalEquity = 0;
        endif;
        $c->dilShareOut = Intrinio::data_tag_yearly($id,'weightedavedilutedsharesos');
        if(count($c->dilShareOut)>0):
            $c->dilShareOut = $c->dilShareOut[0]->value/1000000;
        else:
            $c->dilShareOut = 0;
        endif;


        $c->freeCF = $this->freeCF($id);
        if($c->dilShareOut>0):
            $c->FCF = ($c->growthMultiple*$c->freeCF+$c->totalEquity*0.75)/$c->dilShareOut;
        else:
            $c->FCF = 0;
        endif;
        return $c->FCF;
    }

    private function calculatePL($id){

        $c = (object)[];
        $c->ticker = $id;

        $c->NRI = Intrinio::data_tag_yearly($id,'extraordinaryincome');
        if(count($c->NRI)>0):
            $c->NRI = $c->NRI[0]->value;
        else:
            $c->NRI = 0;
        endif;
        $c->eps_nri_per_share = Intrinio::data_tag_quarterly($id,'adjbasiceps');
        if(count($c->eps_nri_per_share)>0):
            $c->eps_nri_per_share = $c->eps_nri_per_share[0]->value;
        else:
            $c->eps_nri_per_share = 0;
        endif;
        $c->ebitpershare = $this->ebitpershare($id);
        if(count($c->ebitpershare["z"])>0):
            $c->CAGR = $this->getCagr($c->ebitpershare['z'])*100;
        else:
            $c->CAGR = 0;
        endif;

        if(count($c->ebitpershare["x"])>0 && count($c->ebitpershare["y"])>0):
            $c->LINEST  = $this->getLinest($c->ebitpershare);
            if(is_array($c->LINEST)):
                $c->growthRate = (pow(10,$c->LINEST[0])-1)*100;
            else:
                $c->growthRate = 0;
            endif;
        else:
            $c->growthRate = 0;
        endif;

        if($c->CAGR > 0 || $c->growthRate > 0):
            $c->avgCAGR = floor(($c->growthRate+$c->CAGR)/2);
        else:
            $c->avgCAGR = 0;
        endif;
        $c->PL = 1*$c->avgCAGR*($c->eps_nri_per_share-$c->NRI);

        return $c->PL;
    }

    private function calculateDCF($id){

        $c = (object)[];
        $c->ticker = $id;
        $c->disc_rate_d = (Intrinio::getTreasuryRate()/100)+(6/100);
        $c->growth_years_y1 = 10;
        $c->growth_rate_g1 = $this->getGrowthRate($id)/100;
        $c->term_growth_rate_g2 = 0.036;
        $c->term_year_growth_y2 = 10;
        $c->eps_nri_per_share = Intrinio::data_tag_quarterly($id,'adjbasiceps');
        if(count($c->eps_nri_per_share)>0):
            $c->eps_nri_per_share = $c->eps_nri_per_share[0]->value;
        else:
            $c->eps_nri_per_share = 0;
        endif;
        $c->X = (1+$c->growth_rate_g1)/(1+$c->disc_rate_d);
        $c->Y = (1+$c->term_growth_rate_g2)/(1+($c->disc_rate_d));
        $c->Xsum      = $this->getXsum($c->X);
        $c->Ysum      = $this->getXsum($c->Y);
        $c->Xpow10    = pow($c->X,10);
        $c->intValCal = $c->eps_nri_per_share*(($c->Xsum)+$c->Xpow10*($c->Ysum));

        return $c->intValCal;
    }

    private function calculateTB($id){

        $c = (object)[];
        $c->ticker = $id;

        $c->dilutedSharesOutstanding   = Intrinio::data_tag_quarterly($id,'weightedavedilutedsharesos');
        //dd($c->dilutedSharesOutstanding);
        if(count($c->dilutedSharesOutstanding)>0):
            $c->dilutedSharesOutstanding   = $c->dilutedSharesOutstanding[0]->value/1000000;
            $c->totalEquity                = Intrinio::data_tag_quarterly($id,'totalequity');
            if(count($c->totalEquity)>0):
                $c->totalEquity                =  $c->totalEquity[0]->value/1000000;
            else:
                $c->totalEquity                =  0;
            endif;
            $c->totalPreferedEquity        = Intrinio::data_tag_quarterly($id,'totalpreferredequity');
            if(count($c->totalPreferedEquity)>0):
                $c->totalPreferedEquity                =  $c->totalPreferedEquity[0]->value/1000000;
            else:
                $c->totalPreferedEquity                =  0;
            endif;
            $c->intengibleAssets           = Intrinio::data_tag_quarterly($id,'intangibleassets');
            if(count($c->intengibleAssets)>0):
                $c->intengibleAssets                =  $c->intengibleAssets[0]->value/1000000;
            else:
                $c->intengibleAssets                =  0;
            endif;
            $c->goodWill                   = Intrinio::data_tag_quarterly($id,'goodwill');
            if(count($c->goodWill)>0):
                $c->goodWill                =  $c->goodWill[0]->value/1000000;
            else:
                $c->goodWill                =  0;
            endif;
            if($c->dilutedSharesOutstanding > 0):
                $c->TB = ($c->totalEquity - $c->totalPreferedEquity - ($c->intengibleAssets + $c->goodWill)) / $c->dilutedSharesOutstanding;
            else:
                $c->TB = 0;
            endif;
        else:
            $c->TB = 0;
        endif;

        return $c->TB;
    }

    private function calculateGRAHAM($id){

        $c = (object)[];
        $c->ticker = $id;

        $c->eps_nri_per_share = Intrinio::data_tag_quarterly($id,'adjbasiceps');
        if(count($c->eps_nri_per_share)>0):
            $c->eps_nri_per_share = $c->eps_nri_per_share[0]->value;
        else:
            $c->eps_nri_per_share = 0;
        endif;

        $c->TB = $this->calculateTB($id);
        $c->GRAHAM = sqrt($c->TB * $c->eps_nri_per_share * 22.5);
        if(is_nan($c->GRAHAM)):
            $c->GRAHAM = 0;
        endif;

        return $c->GRAHAM;
    }

    private function calculateFinancialRating($id){
        $c = (object)[];
        $c->ebitRating  = $this->getRatingsEbit($id);
        $c->OperatingIncomeRating = $this->getRatingsOI($id);
        $c->OPCPERCURDEBTRating = $this->getRatingsRatio($id);
        $c->quickRatioRating = $this->getRatingsquick($id);
        $c->DtoERating = $this->getRatingsDtoE($id);
        $c->freecashflowRating = $this->getRatingsfreecashflow($id);
        $c->afterWeightRating = $this->getAfterWeightRating($c);

        return $c;
    }


// related private DCF functions
    private function getXsum($d){
        $sum = $d;
        for($i=2;$i<=10;$i++){
            $sum = $sum+pow($d,$i);
        }
        return $sum;
    }

    private function getGrowthRate($id){
        $ebitpershare = $this->ebitpershare($id);
        if(count($ebitpershare["z"])>0):
            $CAGR = $this->getCagr($ebitpershare['z'])*100;
        else:
            $CAGR = 0;
        endif;

        if(count($ebitpershare["x"])>0 && count($ebitpershare["y"])>0):
            $LINEST  = $this->getLinest($ebitpershare);
            if(is_array($LINEST)):
                $growthRate = (pow(10,$LINEST[0])-1)*100;
            else:
                $growthRate = 0;
            endif;
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

        return $g1;
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
            if($x==$top1 && $top1 > 0):
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

    private function freeCF($id){
        $cfop = Intrinio::data_tag_yearly($id,'netcashfromoperatingactivities');  //net cash from operating revenue
        $capex = Intrinio::data_tag_yearly($id,'capex');
        if(count($cfop)>0 && count($capex)>0):
            $diff = [];
            $total = 0;
            for($x=0; $x < count($cfop); $x++):
                $di = ($cfop[$x]->value - $capex[$x]->value)/1000000;
                $total = $total+$di;
                array_push($diff,$di);
            endfor;
            $freeCF = round($total/$x,2);
        else:
            $freeCF = 0;
        endif;

        return $freeCF;
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
            if($x > 0):
                return (($data/$x)*4)/1000000;
            else:
                return 0;
            endif;
        else:
            return 0;
        endif;

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

        $ebitArr  = Intrinio::data_tag_quarterly_new($id,'ebit');
        if(count($ebitArr)<1):
            $ebitArr  = Intrinio::data_tag_yearly($id,'ebit');
        endif;
        $shareArr = Intrinio::data_tag_quarterly_new($id,'weightedavedilutedsharesos');
        if(count($shareArr)<1):
            $shareArr = Intrinio::data_tag_yearly($id,'weightedavedilutedsharesos');
        endif;
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
            if($shareArr[$i]->value>0):
                $x->ebitpershare = abs($ebitArr[$i]->value/$shareArr[$i]->value);
            else:
                $x->ebitpershare = 0;
            endif;

            $x->log10 = log10($x->ebitpershare);

            array_push($arr['detail'],$x);
            array_push($arr['x'],$x->log10);
            array_push($arr['y'],$x->count);
            array_push($arr['z'],$x->ebitpershare);
            $y++;
        endfor;
        return $arr;
    }

    private  function getLinest($d){
        $stats = new Statistical();
        $stat = $stats->LINEST($d['x'],$d['y']);
        return $stat;
    }

    private  function getCagr($d){

        $count = count($d);
        if($count>0):
            if($d[0] > 0):
                $tot = $d[$count-1]/$d[0];
                $exp = pow($tot,1/($count));
                $cagr = $exp-1;
                return $cagr;
            else:
                return 0;
            endif;
        else:
            return 0;
        endif;

    }


    private function getAfterWeightRating($c){
        $arr['weight'] = 0;
        $arr['oiweight'] = 0.05*$c->OperatingIncomeRating['rating'];
        $arr['weight'] = $arr['weight']+$arr['oiweight'];

        $arr['ebitweight'] = 0.23*$c->ebitRating['rating'];
        $arr['weight'] = $arr['weight']+$arr['ebitweight'];

        $arr['OPCPERCweight'] = 0.23*$c->OPCPERCURDEBTRating['rating'];
        $arr['weight'] = $arr['weight']+$arr['OPCPERCweight'];

        $arr['quickWeight'] = 0.18*$c->quickRatioRating['rating'];
        $arr['weight'] = $arr['weight']+$arr['quickWeight'];

        $arr['freecfweight'] = 0.14*$c->freecashflowRating['rating'];
        $arr['weight'] = $arr['weight']+$arr['freecfweight'];

        $arr['dtoeweight'] = 0.18*$c->DtoERating['rating'];
        $arr['weight'] = $arr['weight']+$arr['dtoeweight'];


        return $arr;
    }
    private function getRatingsfreecashflow($id){
        $cyear = date('Y');
        $cmonth = date('m');
        $lday = date('t');

        $cyear1 = $cyear-1;
        $cyear2 = $cyear-2;
        $cyear3 = $cyear-3;
        $cyear4 = $cyear-4;

        $latest = Intrinio::data_tag_qtr_year_wise_avg_latest_date($id,'freecashflow',"$cyear-01-01","$cyear-$cmonth-$lday");

        $avg = array(
            // "2017" => Intrinio::data_tag_qtr_year_wise_avg($id,'ebit','2017-01-01','2017-04-30'),
            "$cyear4" => Intrinio::data_tag_qtr_year_wise_avg($id,'freecashflow',"$cyear4-01-01","$cyear4-$cmonth-$lday",$latest),
            "$cyear3" => Intrinio::data_tag_qtr_year_wise_avg($id,'freecashflow',"$cyear3-01-01","$cyear3-$cmonth-$lday",$latest),
            "$cyear2" => Intrinio::data_tag_qtr_year_wise_avg($id,'freecashflow',"$cyear2-01-01","$cyear2-$cmonth-$lday",$latest),
            "$cyear1" => Intrinio::data_tag_qtr_year_wise_avg($id,'freecashflow',"$cyear1-01-01","$cyear1-$cmonth-$lday",$latest),
            "$cyear" => Intrinio::data_tag_qtr_year_wise_avg($id,'freecashflow',"$cyear-01-01","$cyear-$cmonth-$lday",'')
        );

        $rating = 0;
        $tpositive = 0;

        foreach ($avg as $a):
            if($a>0):
                $tpositive++;
            endif;
        endforeach;
        $avg['totalPositive'] = $tpositive;
        // check for star rating 5
        if($avg[$cyear1] > 0 && $avg[$cyear] > $avg[$cyear1]):
            if($tpositive >= 3):
                $rating = 5;
            endif;
        endif;

        // check for star rating 4
        if($rating==0):
            if($avg[$cyear] > 0 && $avg[$cyear] > $avg[$cyear1]):
                if($tpositive >= 3):
                    $rating = 4;
                endif;
            endif;
        endif;

        // check for star rating 3
        if($rating==0):
            if($avg[$cyear] > 0 || $avg[$cyear1] > 0):
                if($tpositive >= 3):
                    $rating = 3;
                endif;
            endif;
        endif;

        // check for star rating 2
        if($rating==0):
            if($avg[$cyear] > 0 || $avg[$cyear1] > 0):
                if($tpositive >= 2):
                    $rating = 2;
                endif;
            endif;
        endif;

        // check for star rating 1
        if($rating==0):
            if($avg[$cyear1] > 0):
                if($avg[$cyear] > 0):
                    $rating = 1;
                else:
                    if($avg[$cyear] > $avg[$cyear1]):
                        $rating = 1;
                    endif;
                endif;
            else:
                if($avg[$cyear1] > $avg[$cyear2]):
                    $rating = 1;
                endif;
            endif;
        endif;
        $avg["rating"] = $rating;
        return $avg;
    }
    private function getRatingsDtoE($id){
        $cyear = date('Y');
        $cmonth = date('m');
        $lday = date('t');

        $latest = Intrinio::data_tag_qtr_year_wise_avg_latest_date($id,'debttoequity',"$cyear-01-01","$cyear-$cmonth-$lday");

        $avg = array(
            "$cyear" => Intrinio::data_tag_qtr_year_wise_avg_per($id,'debttoequity',"$cyear-01-01","$cyear-$cmonth-$lday",$latest)
        );

        $avg['rating'] = 0;
        // check for star rating 5
        if($avg[$cyear]<=0.8):
            $avg['rating'] = 5;
        elseif($avg[$cyear]>0.8 && $avg[$cyear]<=1.1):
            $avg['rating'] = 4;
        elseif($avg[$cyear]>1.1 && $avg[$cyear]<=1.3):
            $avg['rating'] = 3;
        elseif($avg[$cyear]>1.3 && $avg[$cyear]<=1.6):
            $avg['rating'] = 2;
        elseif($avg[$cyear]>1.6 && $avg[$cyear]<=2.2):
            $avg['rating'] = 1;
        endif;
        return $avg;
    }
    private function getRatingsquick($id){
        $cyear = date('Y');
        $cmonth = date('m');
        $lday = date('t');
        $latest = Intrinio::data_tag_qtr_year_wise_avg_latest_date($id,'quickratio',"$cyear-01-01","$cyear-$cmonth-$lday");

        $avg = array(
            "$cyear" => Intrinio::data_tag_qtr_year_wise_avg_per($id,'quickratio',"$cyear-01-01","$cyear-$cmonth-$lday",$latest)
        );

        $avg['rating'] = 0;
        // check for star rating 5
        if($avg[$cyear]>1):
            $avg['rating'] = 5;
        elseif($avg[$cyear]<1 && $avg[$cyear]>=0.8):
            $avg['rating'] = 4;
        elseif($avg[$cyear]<0.8 && $avg[$cyear]>=0.7):
            $avg['rating'] = 3;
        elseif($avg[$cyear]<0.7 && $avg[$cyear]>=0.6):
            $avg['rating'] = 2;
        elseif($avg[$cyear]<0.6):
            $avg['rating'] = 1;
        endif;
        return $avg;
    }
    private function getRatingsOI($id){
        $cyear = date('Y');
        $cmonth = date('m');
        $lday = date('t');
        //echo $lday;die();
        $cyear1 = $cyear-1;
        $cyear2 = $cyear-2;
        $cyear3 = $cyear-3;
        $cyear4 = $cyear-4;

        $latest = Intrinio::data_tag_qtr_year_wise_avg_latest_date($id,'totaloperatingincome',"$cyear-01-01","$cyear-$cmonth-$lday");
        //echo "$cyear // $cyear1 // $cyear2 // $cyear3 // $cyear4";die();
        $avg = array(
            // "2017" => Intrinio::data_tag_qtr_year_wise_avg($id,'ebit','2017-01-01','2017-04-30'),
            "$cyear4" => Intrinio::data_tag_qtr_year_wise_avg($id,'totaloperatingincome',"$cyear4-01-01","$cyear4-$cmonth-$lday",$latest),
            "$cyear3" => Intrinio::data_tag_qtr_year_wise_avg($id,'totaloperatingincome',"$cyear3-01-01","$cyear3-$cmonth-$lday",$latest),
            "$cyear2" => Intrinio::data_tag_qtr_year_wise_avg($id,'totaloperatingincome',"$cyear2-01-01","$cyear2-$cmonth-$lday",$latest),
            "$cyear1" => Intrinio::data_tag_qtr_year_wise_avg($id,'totaloperatingincome',"$cyear1-01-01","$cyear1-$cmonth-$lday",$latest),
            "$cyear" => Intrinio::data_tag_qtr_year_wise_avg($id,'totaloperatingincome',"$cyear-01-01","$cyear-$cmonth-$lday",'')
        );

        $rating = 0;
        // check for star rating 5
        if($avg[$cyear3] > 0):
            if($avg[$cyear2]>$avg[$cyear3]):
                if($avg[$cyear1]>$avg[$cyear2]):
                    if($avg[$cyear]>$avg[$cyear1]):
                        $rating = 5;
                    endif;
                endif;
            endif;
        endif;

        // check for star rating 4
        if($rating==0):
            if($avg[$cyear3] > 0 && $avg[$cyear2] > 0):
                if($avg[$cyear1]>$avg[$cyear2] && $avg[$cyear] >$avg[$cyear2]):
                    $rating = 4;
                endif;
            endif;
        endif;

        // check for star rating 3
        if($rating==0):
            if($avg[$cyear3] > 0 && $avg[$cyear2] > 0 && $avg[$cyear1] > 0):
                if($avg[$cyear]>$avg[$cyear2]):
                    $rating = 3;
                endif;
            endif;
        endif;

        // check for star rating 2
        if($rating==0):
            if($avg[$cyear]>$avg[$cyear2] && $avg[$cyear] > 0):
                $rating = 2;
            endif;
        endif;

        // check for star rating 1
        if($rating==0):
            if($avg[$cyear]>$avg[$cyear1]):
                $rating = 1;
            endif;
        endif;
        $avg["rating"] = $rating;
        return $avg;
    }
    private function getRatingsEbit($id){
        $cyear = date('Y');
        $cmonth = date('m');
        $lday = date('t');

        $cyear1 = $cyear-1;
        $cyear2 = $cyear-2;
        $cyear3 = $cyear-3;
        $cyear4 = $cyear-4;

        $latest = Intrinio::data_tag_qtr_year_wise_avg_latest_date($id,'ebit',"$cyear-01-01","$cyear-$cmonth-$lday");
        //echo "$cyear // $cyear1 // $cyear2 // $cyear3 // $cyear4";die();
        $avg = array(
            // "2017" => Intrinio::data_tag_qtr_year_wise_avg($id,'ebit','2017-01-01','2017-04-30'),
            "$cyear4" => Intrinio::data_tag_qtr_year_wise_avg($id,'ebit',"$cyear4-01-01","$cyear4-$cmonth-$lday",$latest),
            "$cyear3" => Intrinio::data_tag_qtr_year_wise_avg($id,'ebit',"$cyear3-01-01","$cyear3-$cmonth-$lday",$latest),
            "$cyear2" => Intrinio::data_tag_qtr_year_wise_avg($id,'ebit',"$cyear2-01-01","$cyear2-$cmonth-$lday",$latest),
            "$cyear1" => Intrinio::data_tag_qtr_year_wise_avg($id,'ebit',"$cyear1-01-01","$cyear1-$cmonth-$lday",$latest),
            "$cyear" => Intrinio::data_tag_qtr_year_wise_avg($id,'ebit',"$cyear-01-01","$cyear-$cmonth-$lday",'')
        );

        $rating = 0;
        // check for star rating 5
        if($avg[$cyear3] > 0):
            if($avg[$cyear2]>$avg[$cyear3]):
                if($avg[$cyear1]>$avg[$cyear2]):
                    if($avg[$cyear]>$avg[$cyear1]):
                        $rating = 5;
                    endif;
                endif;
            endif;
        endif;

        // check for star rating 4
        if($rating==0):
            if($avg[$cyear3] > 0 && $avg[$cyear2] > 0):
                if($avg[$cyear1]>$avg[$cyear2] && $avg[$cyear] >$avg[$cyear2]):
                    $rating = 4;
                endif;
            endif;
        endif;

        // check for star rating 3
        if($rating==0):
            if($avg[$cyear3] > 0 && $avg[$cyear2] > 0 && $avg[$cyear1] > 0):
                if($avg[$cyear]>$avg[$cyear2]):
                    $rating = 3;
                endif;
            endif;
        endif;

        // check for star rating 2
        if($rating==0):
            if($avg[$cyear]>$avg[$cyear2] && $avg[$cyear] > 0):
                $rating = 2;
            endif;
        endif;

        // check for star rating 1
        if($rating==0):
            if($avg[$cyear]>$avg[$cyear1]):
                $rating = 1;
            endif;
        endif;
        $avg["rating"] = $rating;
        return $avg;
    }
    private function getRatingsRatio($id){

        $cyear = date('Y');
        $cmonth = date('m');
        $lday = date('t');

        $cyear1 = $cyear-1;
        $cyear2 = $cyear-2;
        $avg = [];

        $latest1 = Intrinio::data_tag_qtr_year_wise_avg_latest_date($id,'netcashfromoperatingactivities',"$cyear-01-01","$cyear-$cmonth-$lday");
        $latest2 = Intrinio::data_tag_qtr_year_wise_avg_latest_date($id,'totalcurrentliabilities',"$cyear-01-01","$cyear-$cmonth-$lday");

        $avg['last3year']['netcashfromoperatingactivities'] = array(
            "$cyear2" => Intrinio::data_tag_qtr_year_wise_avg($id,'netcashfromoperatingactivities',"$cyear2-01-01","$cyear2-$cmonth-$lday",$latest1),
            "$cyear1" => Intrinio::data_tag_qtr_year_wise_avg($id,'netcashfromoperatingactivities',"$cyear1-01-01","$cyear1-$cmonth-$lday",$latest1),
            "$cyear" => Intrinio::data_tag_qtr_year_wise_avg($id,'netcashfromoperatingactivities',"$cyear-01-01","$cyear-$cmonth-$lday",$latest1)
        );
        $avg['last3year']['totalcurrentliabilities'] = array(
            "$cyear2" => Intrinio::data_tag_qtr_year_wise_avg($id,'totalcurrentliabilities',"$cyear2-01-01","$cyear2-$cmonth-$lday",$latest2),
            "$cyear1" => Intrinio::data_tag_qtr_year_wise_avg($id,'totalcurrentliabilities',"$cyear1-01-01","$cyear1-$cmonth-$lday",$latest2),
            "$cyear" => Intrinio::data_tag_qtr_year_wise_avg($id,'totalcurrentliabilities',"$cyear-01-01","$cyear-$cmonth-$lday",$latest2)
        );
        $r = 0;
        $r1 = 0;
        $r2 = 0;
        if($avg['last3year']['totalcurrentliabilities'][$cyear2] != 0 && $avg['last3year']['netcashfromoperatingactivities'][$cyear2]!=0):
            $r2 = $avg['last3year']['netcashfromoperatingactivities'][$cyear2]/$avg['last3year']['totalcurrentliabilities'][$cyear2];
        endif;
        if($avg['last3year']['totalcurrentliabilities'][$cyear1] != 0 && $avg['last3year']['netcashfromoperatingactivities'][$cyear1]!=0):
            $r1 = $avg['last3year']['netcashfromoperatingactivities'][$cyear1]/$avg['last3year']['totalcurrentliabilities'][$cyear1];
        endif;
        if($avg['last3year']['totalcurrentliabilities'][$cyear] != 0 && $avg['last3year']['netcashfromoperatingactivities'][$cyear]!=0):
            $r = $avg['last3year']['netcashfromoperatingactivities'][$cyear]/$avg['last3year']['totalcurrentliabilities'][$cyear];
        endif;
        $avg['last3year']['ratio'] = array(
            "$cyear2" => $r2,
            "$cyear1" => $r1,
            "$cyear" => $r,
        );

        if($avg['last3year']['netcashfromoperatingactivities'][$cyear]>0 &&
            $avg['last3year']['netcashfromoperatingactivities'][$cyear1]>0 &&
            $avg['last3year']['netcashfromoperatingactivities'][$cyear2]>0
        ):
            $avg['ratio'] = round($avg['last3year']['ratio'][$cyear],2);
        else:
            $avg['ratio'] = 0;
        endif;


        $avg['rating'] = 0;
        if($avg['ratio']>=0.70):
            if($avg['last3year']['ratio'][$cyear]>$avg['last3year']['ratio'][$cyear1]):
                if($avg['last3year']['ratio'][$cyear1]>$avg['last3year']['ratio'][$cyear2]):
                    $avg['rating'] = 5;
                endif;
            endif;
        elseif($avg['ratio']<0.70 && $avg['ratio']>=0.40):
            $avg['rating'] = 4;
        elseif($avg['ratio']<0.40 && $avg['ratio']>=0.20):
            $avg['rating'] = 3;
        elseif($avg['ratio']<0.20 && $avg['ratio']>=0.10):
            $avg['rating'] = 2;
        elseif($avg['ratio']<0.10 && $avg['ratio']>=0.01):
            $avg['rating'] = 1;
        endif;
        return $avg;
    }
}
