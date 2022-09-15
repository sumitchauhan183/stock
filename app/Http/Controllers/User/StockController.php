<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Classes\Utils;
use App\Classes\Intrinio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical;

class StockController extends Controller
{
   private $userId;
   private $tools;
    public function __construct(Request $request)
    {
        if(session()->get('user')):
            if(session()->get('user')['type']!='user'):
                 redirect()->route('notauthorised');
            endif;
            if(!$this->checkToken()):
                $this->logout();
            endif;
            $this->tools = session()->get('user')['tools'];
        else:
            $this->logout();
        endif;

        $this->userId = session()->get('user')['data']['user_id'];
    }

    public function all(){
       $user = User::where('user_id',$this->userId)->get()->first()->toArray();
       $companies = Intrinio::companies_all();

       return view('user.stocks.all',[
           'user'=>$user,
           'url'=>'allStocks',
           'companies'=>$companies,
            'tools'=> $this->tools
       ]);
    }

    public function findValueStock(){
        $user = User::where('user_id',$this->userId)->get()->first()->toArray();
        return view('user.stocks.find_value_stock',[
            'user'=>$user,
            'url'=>'find-value-stock',
            'tools'=> $this->tools
        ]);
     }

     public function optimizeInvestmentMix(){
        $user = User::where('user_id',$this->userId)->get()->first()->toArray();
        return view('user.stocks.optimize_investment_mix',[
            'user'=>$user,
            'url'=>'optimize-investment-mix',
            'tools'=> $this->tools
        ]);
     }

    public function assets(){
        $user = User::where('user_id',$this->userId)->get()->first()->toArray();
        return view('user.stocks.assets',[
            'user'=>$user,
            'url'=>'assetsstocks',
            'tools'=> $this->tools
        ]);
     }

     public function assetsResult(Request $request ){
        $input = $request->all();
        if(isset($input['asset'])):
        $asset = $input['asset'];
        $user = User::where('user_id',$this->userId)->get()->first()->toArray();
        $companies = array();

        foreach($asset as $s):
            $company = Intrinio::companies_asset($s);
            if($company):
                $companies = array_merge($companies,$company);
            endif;
        endforeach;
        return view('user.stocks.asset_companies',[
            'user'=>$user,
            'url'=>'assets-result',
            'companies'=>$companies,
            'tools'=> $this->tools
        ]);
    else:
        return redirect('user/stocks/assets');
    endif;
     }

     public function sector(){
        $user = User::where('user_id',$this->userId)->get()->first()->toArray();
        return view('user.stocks.sector',[
            'user'=>$user,
            'url'=>'sectorstocks',
            'tools'=> $this->tools
        ]);
     }


     public function companyDetail($ticker){

        $user                           = User::where('user_id',$this->userId)->get()->first()->toArray();
        $c = (object)[];
        $c->ticker                       = $ticker;

        // STEP 1 - calculate Ebit Margin
        $c->revenue              = Intrinio::revenueArray($c->ticker);
        $c->netppe               =  Intrinio::netppeArray($c->ticker);
        $c->CAPEX                =  Intrinio::CAPEXArray($c->ticker);
        $c->revenueChange        =  $this->changeInRevenue($c);
        $c->revenueTTM           =  $this->revenueTTM($c);
        $c->ppeToRevenueTTM      =  $this->ppetorevenuettm($c->netppe,$c->revenueTTM);
        $c->CAPEXpos             =  $this->capexpositive($c->CAPEX);
        $c->maintainanceCAPEXnoCon    =  $this->maintainanceCapexnocon($c);
        $c->maintainanceCAPEX         =  $this->maintainanceCapex($c);
        $c->avgmaintainanceCAPEX      =  $this->avgmaintainanceCapex($c->maintainanceCAPEX);
        $c->avgSGA                    = Intrinio::avgFiveYearSGA($c->ticker)/1000000;
        $c->avgDDA                    = (Intrinio::avgFiveYearDDA($c->ticker)/1000000)*4;
        $c->avgOperatingmargin        = Intrinio::avgFiveYearOperatingMargin($c->ticker);
        $c->avgtaxRate         = Intrinio::avgFiveYearTaxRate($c->ticker);
        $c->avgEbitMargin      = Intrinio::avgFiveYearEbitMargin($c->ticker);
        $c->avgRevenue         = Intrinio::avgSustainableRevenue($c->ticker)/1000000;
        $c->avgNetPPE          = ($this->avg($c->netppe)/1000000)*4;
        $c->normalizedEbit     = ($c->avgRevenue*$c->avgOperatingmargin)+$c->avgSGA;
        $c->normalizedEbitAfterTax     = $c->normalizedEbit * (1-$c->avgtaxRate);
        $c->excessDepriciation         = $c->avgDDA * 0.5 * $c->avgtaxRate;
        $c->normalizedEarnings         = $c->normalizedEbitAfterTax + $c->excessDepriciation;
        $c->capitalLeaseObligation     = Intrinio::capitalLeaseObligation($c->ticker)/1000000;
        $c->dilutedSharesOutstanding    = Intrinio::data_tag($c->ticker,'weightedavedilutedsharesos')[0]->value/1000000;
        $c->longTermDebt               = Intrinio::data_tag($c->ticker,'longtermdebt')[0]->value/1000000;
        $c->shortTermDebt              = Intrinio::data_tag($c->ticker,'shorttermdebt')[0]->value/1000000;
        $c->intBearDebt                = $c->longTermDebt + $c->shortTermDebt + $c->capitalLeaseObligation;
        $c->cashandequi                = Intrinio::data_tag($c->ticker,'cashandequivalents')[0]->value/1000000;
        $c->wacc                       = 0.09;
        $c->EPV                        =  (( ($c->normalizedEarnings-$c->avgmaintainanceCAPEX) / $c->wacc) + $c->cashandequi - $c->intBearDebt ) / $c->dilutedSharesOutstanding;
        /*$data = array(
            "avg maintainance CAPEX" => $c->avgmaintainanceCAPEX,
            "Normalised Ebit" => $c->normalizedEbit,
            "operating revenue" => $c->avgRevenue,
            "operating margin" => $c->avgOperatingmargin,
            "SGA"  => $c->avgSGA,
            "AVG TAX" => $c->avgtaxRate,
            "A TX NRM EBIT" => $c->normalizedEbitAfterTax,
            "AVG DDA" => $c->avgDDA,
            "NORM EARN" => $c->normalizedEarnings,
            "Excess Depriciation" => $c->excessDepriciation,
            "EPV" => $c->EPV,
            "WACC" => 0.9,
            "LTD" => $c->longTermDebt,
            "STD" =>  $c->shortTermDebt,
            "INT BR DEBT" => $c->intBearDebt,
            "CASH EQUIV" => $c->cashandequi,
            "CLO" => $c->capitalLeaseObligation,
            "SHRS OUTST" => $c->dilutedSharesOutstanding
        );*/

         $c->dilutedSharesOutstanding   = Intrinio::data_tag_qtr($c->ticker,'weightedavedilutedsharesos')[0]->value/1000000;
         $c->totalEquity                = Intrinio::data_tag_qtr($c->ticker,'totalequity')[0]->value/1000000;
         $c->totalPreferedEquity        = Intrinio::data_tag_qtr($c->ticker,'totalpreferredequity')[0]->value/1000000;
         $c->intengibleAssets           = Intrinio::data_tag_qtr($c->ticker,'intangibleassets')[0]->value/1000000;
         $c->goodWill                   = Intrinio::data_tag_qtr($c->ticker,'goodwill')[0]->value/1000000;
         $c->TB                         = ($c->totalEquity - $c->totalPreferedEquity - ($c->intengibleAssets + $c->goodWill)) / $c->dilutedSharesOutstanding;

         $c->cashflowOperation   = Intrinio::data_tag_yearly($c->ticker,'netcashfromoperatingactivities')[0]->value/1000000;
         $c->capexCashFlow       = Intrinio::data_tag_yearly($c->ticker,'capex')[0]->value/1000000*(-1);
         $c->dilutedSharesCashflow       = Intrinio::data_tag_yearly($c->ticker,'weightedavedilutedsharesos')[0]->value/1000000;
         //$c->freeCashFlowPerShare  = ($c->cashflowOperation + $c->capexCashFlow) / $c->dilutedSharesCashflow;
         $c->EPS = Intrinio::data_tag($c->ticker,'adjdilutedeps')[0]->value;
         $c->GN = sqrt($c->TB * $c->EPS * 22.5);




         $c->dilsharesyearlyarr = Intrinio::data_tag_yearly($c->ticker,'weightedavedilutedsharesos');
         $c->ebityearlyarr = Intrinio::data_tag_yearly($c->ticker,'ebit');
         $c->ebitpershare = $this->ebitpershare($c);
         $c->LINEST  = $this->getLinest($c->ebitpershare);
         $c->CAGR = $this->getCagr($c->ebitpershare['z'])*100;
         $c->growthRate = (pow(10,$c->LINEST[0])-1)*100;
         $c->avgCAGR = floor(($c->growthRate+$c->CAGR)/2);
         if($c->avgCAGR<4):
             $c->g1 = 4;
         else:
             $c->g1 = $c->avgCAGR;
         endif;

         if($c->avgCAGR>20):
             $c->g1 = 20;
         endif;
         $c->fcfpershare = ((Intrinio::data_tag_yearly($c->ticker,'netcashfromoperatingactivities')[0]->value/1000000) - (Intrinio::data_tag_yearly($c->ticker,'capex')[0]->value/1000000))/(Intrinio::data_tag_yearly($c->ticker,'weightedavedilutedsharesos')[0]->value/1000000);
         $c->g2 = 3.6;
         $c->d = Intrinio::getTreasuryRate()+6;
         $c->y1 = 10;
         $c->y2 = 10;
         $c->X = (1+($c->g1/100))/(1+($c->d/100));
         $c->Y = (1+($c->g2/100))/(1+($c->d/100));
         $c->Xsum      = $this->getXsum($c->X);
         $c->Ysum      = $this->getXsum($c->Y);
         $c->Xpow10    = pow($c->X,10);
         $c->intValCal = $c->fcfpershare*(($c->Xsum)+$c->Xpow10*($c->Ysum));
         $c->growthMultiple = 8.3459 * pow(1.07, $c->g1-4);
         $c->avgFreeCashFlows = (Intrinio::data_tag_avg_yearly($c->ticker,'netcashfromoperatingactivities')-Intrinio::data_tag_avg_yearly($c->ticker,'capex'))/1000000;
         $c->totalEquity = Intrinio::data_tag_qtr($c->ticker,'totalequity')[0]->value/1000000;
         $c->FutCF = ($c->growthMultiple*$c->avgFreeCashFlows)+(0.75*$c->totalEquity);
         $c->dilShareOut = Intrinio::data_tag_avg_yearly($c->ticker,'weightedavedilutedsharesos')/1000000;
         $c->FutCF = $c->FutCF/$c->dilShareOut;
         $c->closePrice = Intrinio::stockpricedata($c->ticker)[0]->close;
         $c->marginOfSafety = ($c->intValCal-$c->closePrice)/$c->intValCal;
         $c->NRI = Intrinio::data_tag_yearly($c->ticker,'extraordinaryincome')[0]->value;
         if(!$c->NRI):
             $c->NRI = 0;
         endif;
         $c->EPS = Intrinio::data_tag_yearly($c->ticker,'adjdilutedeps')[0]->value;
         $c->PLV = 1*$c->avgCAGR*($c->EPS-$c->NRI);


         $c->ebitRating  = $this->getRatingsEbit($c->ticker);
         $c->OperatingIncomeRating = $this->getRatingsOI($c->ticker);
         $c->OPCPERCURDEBTRating = $this->getRatingsRatio($c->ticker);
         $c->quickRatioRating = $this->getRatingsquick($c->ticker);
         $c->DtoERating = $this->getRatingsDtoE($c->ticker);
         $c->freecashflowRating = $this->getRatingsfreecashflow($c->ticker);
         $c->afterWeightRating = $this->getAfterWeightRating($c);

         $d = (object)[];
         $d->FCF = $c->FutCF;
         $d->DCF = $c->dilutedSharesCashflow;
         $d->EPV = $c->EPV;
         $d->TB  = $c->TB;
         $d->GRAHAM = $c->GN;
         $d->PL  = $c->PLV;
dd($d);

         echo "<pre>";print_r($c);die();
        return view('user.stocks.sector',[
            'user'=>$user,
            'url'=>'sectorstocks',
            'tools'=> $this->tools
        ]);
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

     private function getXsum($d){
        $sum = $d;
        for($i=2;$i<=10;$i++){
            $sum = $sum+pow($d,$i);
        }
        return $sum;
     }

    private  function getCagr($d){
        /*
             CAGR is a calculation in which you take only the 2022 EBIT and the 2017 EBIT
             ( It stands for compound annual growth rate).
                the calculation is
                2022 EBIT / 2017 EBIT
            Then
            1. raise that to the exponent of the number of EBIT years you see.
                For example if there is 2017, 2018, 2019, 2020, 2021, 2022 then (2022/2017)^6
            2. Then, take the result and subtract 1 from it.

            Where there are only 5 years then raise to the 5th power.

            =(2021 EBIT / 2017 EBIT) ^(1/5)-1
         */
        //echo "<pre>";print_r($d);die();
        $count = count($d);
        $tot = $d[$count-1]/$d[0];

        $exp = pow($tot,1/($count));
        $cagr = $exp-1;
        return $cagr;
    }

     private  function getLinest($d){
         $stats = new Statistical();
         $stat = $stats->LINEST($d['x'],$d['y']);
         return $stat;
     }
     private function ebitpershare($c){
        $ebitArr = $c->ebityearlyarr;
        $shareArr = $c->dilsharesyearlyarr;
        $avg = $this->getAvg($c->dilsharesyearlyarr);
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
        return $val/$count;
}
     private function avg($data){
        $x=0;
        $dos = 0;
        foreach($data as $d):
            $x++;
            $dos += $d->value;
        endforeach;

        return $dos/$x;
     }

     private function changeInRevenue($c){
        $x = count($c->revenue);
        $data = [];
        $d = $c->revenue;
        foreach($d as $r):
            $x--;
            if($x>0):
                $cal = $d[$x-1]->value - $d[$x]->value;
               array_push($data,$cal);
            endif;
        endforeach;
        return $data;
     }

     private function revenueTTM($c){
        $x = count($c->revenue);
        $top1 = count($c->revenue)-1;
        $top2 = count($c->revenue)-2;
        $data = [];
        $d = $c->revenue;
        foreach($d as $r):
            $x--;
            if($x==$top1):
                $cal = $d[$x]->value + $d[$x-1]->value;
               array_push($data,$cal);
            elseif($x==$top2):
                $cal = $d[$x]->value + $d[$x-1]->value + $d[$x-2]->value;
               array_push($data,$cal);
            elseif($x>1):
                $cal = $d[$x+2]->value + $d[$x+1]->value + $d[$x]->value + $d[$x-1]->value;
               array_push($data,$cal);
            elseif($x<1):
                $cal = $d[$x+3]->value + $d[$x+2]->value + $d[$x+1]->value + $d[$x]->value;
                array_push($data,$cal);
            endif;
        endforeach;
        return $data;
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
                $cal = $c->CAPEXpos[$caposx-$y]-$c->ppeToRevenueTTM[$revttx-$x]*$c->revenueChange[$revChx-$w];
               // echo $c->CAPEXpos[$caposx-$y]."-".$c->ppeToRevenueTTM[$revttx-$x]."x".$c->revenueChange[$revChx-$w]."//".$cal."<br>";
               array_push($data,$cal);
        endforeach;
        return $data;
     }

     private function maintainanceCapex($c){
        // dd($c);
        //$w = count($c->revenueChange);
        //$x = count($c->revenueTTM);
        //$y = count($c->CAPEXpos);
        //$z = count($c->maintainanceCAPEXnoCon);
        $x = 0;
        $revChx = count($c->revenueChange)-1;
        $revttx = count($c->revenueTTM)-1;
        $caposx = count($c->CAPEXpos)-1;
        $capcalx = count($c->maintainanceCAPEXnoCon)-1;

        $data = [];
        $d = $c->revenueChange;
        foreach($d as $r):

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
                $x++;
        endforeach;
        return $data;
     }

     private function avgmaintainanceCapex($c){
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
     }

     public function sectorResult(Request $request){

        $input = $request->all();
        if(isset($input['sector'])):
            $sector = $input['sector'];
        $user  = User::where('user_id',$this->userId)->get()->first()->toArray();
        $companies = array();
        foreach($sector as $s):
            $company = Intrinio::companies($s);
            if($company):
                $companies = array_merge($companies,$company);
            endif;
        endforeach;
        /*$newcom = [];
        foreach($companies as $c):

            array_push($newcom,$c);
        endforeach;*/
        return view('user.stocks.sector_companies',[
            'user'=>$user,
            'url'=>'sector-result',
            'companies'=>$companies,
            'tools'=> $this->tools
        ]);
        else:
            return redirect('user/stocks/sector');
        endif;

     }

    private function logout()
    {
        echo "<script>window.location.href = '".env('APP_URL')."user/login';</script>";
    }

    private function checkToken(){

       return User::where('user_id',session()->get('user')['data']['user_id'])
              ->where('login_token',session()->get('user')['token'])
              ->count();
    }
}
