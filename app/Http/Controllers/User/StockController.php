<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Classes\Utils;
use App\Classes\Intrinio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $c                              = Intrinio::companies_search($ticker);

        // STEP 1 - calculate Ebit Margin
       /* $c->revenue      = Intrinio::revenueArray($c->ticker);
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
        $data = array(
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


        );

       $c->dilutedSharesOutstanding   = Intrinio::avgFiveYearSharesOutstanding($c->ticker)/1000000;
       $c->totalEquity                = Intrinio::avgFiveYearTotalEquity($c->ticker)/1000000;
       $c->totalPreferedEquity        = Intrinio::avgFiveYearTotalPreferedEquity($c->ticker)/1000000;
       $c->intengibleAssets           = Intrinio::avgFiveYearIntengibleAssets($c->ticker)/1000000;
       $c->TB                         = ($c->totalEquity - $c->totalPreferedEquity - $c->intengibleAssets) / $c->dilutedSharesOutstanding;

       */
         $c->dilutedSharesOutstanding   = Intrinio::avgFiveYearSharesOutstanding($c->ticker)/1000000;
         $c->totalEquity                = Intrinio::avgFiveYearTotalEquity($c->ticker)/1000000;
         $c->totalPreferedEquity        = Intrinio::avgFiveYearTotalPreferedEquity($c->ticker)/1000000;
         $c->intengibleAssets           = Intrinio::avgFiveYearIntengibleAssets($c->ticker)/1000000;
         $c->TB                         = ($c->totalEquity - $c->totalPreferedEquity - $c->intengibleAssets) / $c->dilutedSharesOutstanding;



         echo "<pre>";print_r($c);die();
        return view('user.stocks.sector',[
            'user'=>$user,
            'url'=>'sectorstocks',
            'tools'=> $this->tools
        ]);
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
