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
        $c->ebitmargin                  = Intrinio::ebit_margin_five_year($c->ticker);

        // STEP 2 - calculate Ebit Margin
        $c->currentOperatingRevenue     = Intrinio::currentOperatingRevenue($c->ticker);
        $c->nopat                       = Intrinio::nopat_five_year($c->ticker);
        
        $c->normalizedEbit              = $c->currentOperatingRevenue*($c->ebitmargin/100);
        $c->normalizedEbitAfterTax      = $c->normalizedEbit * $c->nopat;
        
        // STEP 3 - calculate Ebit Margin
        $efectiveTaxRate                = Intrinio::efactivetaxrate_five_year($c->ticker);
        //dd($efectiveTaxRate);
        $averageDepriciation            = Intrinio::depriciation_five_year($c->ticker);
        //dd($averageDepriciation);
        $c->adjustedDepriciation        = (0.5 * $efectiveTaxRate/100) * $averageDepriciation;
        $c->normalizedProfit            = $c->adjustedDepriciation * $c->normalizedEbit;

        // Step 4 
        $c->avgcapex                    = Intrinio::capex_five_year($c->ticker);
        $c->netincomegrowth             = Intrinio::income_growth_five_year($c->ticker);
        $c->avgMaintainanceCapex        = $c->avgcapex * (1-($c->netincomegrowth/100));

        // Step 5
        $c->adjustedEarnings            = $c->normalizedProfit - $c->avgMaintainanceCapex;
        $c->dilutedSharesOutstanding    = Intrinio::dilshros_five_year($c->ticker);
        $c->avgdebt                     = Intrinio::avgdebt_five_year($c->ticker);
        $c->interestExpenseLastYear     = Intrinio::data_tag($c->ticker,'totalinterestexpense')[0]->value;
        $c->price                       = Intrinio::data_tag($c->ticker,'open_price')[0]->value;
        $c->E                           = $c->dilutedSharesOutstanding*$c->price;
        $c->debt                        = Intrinio::data_tag($c->ticker,'debt')[0]->value;
        $c->avgLastTwoYearDebt          = Intrinio::avgdebt_two_year($c->ticker);
        $c->costOfDebt                  = $c->interestExpenseLastYear/$c->avgLastTwoYearDebt;
        $c->riskFreeRate                = Intrinio::risk_free_rate($c->ticker);
        $c->oneYearBetaInvestment       = Intrinio::one_year_beta_investment($c->ticker);
        $c->marketReturn                = Intrinio::ten_year_beta_investment($c->ticker);
        $c->costOfEquity                = ($c->riskFreeRate/100) + $c->oneYearBetaInvestment*($c->marketReturn - ($c->riskFreeRate/100));
        $c->taxRate                     = Intrinio::avg_two_year_taxrate($c->ticker);
        $c->wacc                        = $c->E/($c->E+$c->debt)*$c->costOfEquity+$c->debt/($c->E+$c->debt)*$c->costOfDebt*(1-($c->taxRate/100));
        
        $c->totalAssets                 = Intrinio::total_assets($c->ticker);
        $c->currentAssets               = Intrinio::current_assets($c->ticker);
        $c->longTermLiabilities         = Intrinio::long_term_liabilities($c->ticker);
        $c->currentLiabilities          = Intrinio::current_liabilities($c->ticker);
        $c->netAssets                   = ($c->totalAssets+$c->currentAssets)-($c->longTermLiabilities+$c->currentLiabilities);
        $c->grossEarningsPowerValue     = $c->adjustedEarnings / $c->wacc;
        $c->earningPowerValue           = $c->grossEarningsPowerValue+$c->netAssets-$c->debt;
        $c->earningPowerValuePerShare   = $c->earningPowerValue/$c->dilutedSharesOutstanding;

        dd($c);
        return view('user.stocks.sector',[
            'user'=>$user,
            'url'=>'sectorstocks',
            'tools'=> $this->tools
        ]);
     }

     public function companyDetailnew($ticker){
        
        $user                           = User::where('user_id',$this->userId)->get()->first()->toArray();
        $c                              = Intrinio::companies_search($ticker);
           
        // STEP 1 - calculate Ebit Margin
        $c->avgEbitMargin      = Intrinio::avgFiveYearEbitMargin($c->ticker);
        $c->avgOperatingRevenue     = Intrinio::avgFiveYearOperatingRevenue($c->ticker);
        $c->currentOperatingRevenue = Intrinio::currentOperatingRevenue($c->ticker);
        $c->first  = $c->currentOperatingRevenue*$c->avgEbitMargin/100;
        $c->second = $c->avgOperatingRevenue*$c->avgEbitMargin/100;

        
        /*$c->normalizedEbit     = ($c->avgTotalRevenue * ($c->avgOperatingMargin/100)) + 742;
        $c->nopat              = 1-(Intrinio::avgFiveYearTaxRate($c->ticker)/100);
        $c->normalizedEbitAfterTax   = $c->normalizedEbit * $c->nopat;
        $c->excessDepriciation = 485*0.5*($c->nopat)/100;
        $c->normalizedEarnings = $c->normalizedEbitAfterTax+$c->excessDepriciation;
        */

        dd($c);
        return view('user.stocks.sector',[
            'user'=>$user,
            'url'=>'sectorstocks',
            'tools'=> $this->tools
        ]);
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