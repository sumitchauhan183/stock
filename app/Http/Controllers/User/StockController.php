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
       $companies = Intrinio::companies();
       
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
        $asset = $input['asset'];
        $user = User::where('user_id',$this->userId)->get()->first()->toArray();
        $companies = Intrinio::companies_asset();
        foreach($asset as $s):
            $company = Intrinio::companies($s);
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
        
        $user = User::where('user_id',$this->userId)->get()->first()->toArray();
        $c = Intrinio::companies_search($ticker);
            $c->revenue            = Intrinio::data_tag($c->ticker,'totalrevenue');
            $c->pretaxincome       = Intrinio::data_tag($c->ticker,'totalpretaxincome');
            $c->netincome          = Intrinio::data_tag($c->ticker,'netincome');
            $c->netincometocommon       = Intrinio::data_tag($c->ticker,'netincometocommon');
            $c->eps                     = Intrinio::data_tag($c->ticker,'dilutedeps');
            $c->cash                    = Intrinio::data_tag($c->ticker,'cashandequivalents');
            $c->assets       = Intrinio::data_tag($c->ticker,'totalassets');
            $c->liabilities       = Intrinio::data_tag($c->ticker,'totalliabilities');



            /*$c->ebit       = Intrinio::ebit($c->ticker);
            $c->ebitmargin = Intrinio::ebit_margin($c->ticker);
            //$c->revenue    = Intrinio::revenue($c->ticker);
            $c->earningsBeforeTaxInterestDepriciationAmortization     = Intrinio::ebitda($c->ticker);
            $c->accumulatedDepriciation           = Intrinio::accumulated_depriciation($c->ticker);
            $c->totalDepreciationAmortization     = Intrinio::total_depreciation_amortization($c->ticker);*/
        dd($c);
        return view('user.stocks.sector',[
            'user'=>$user,
            'url'=>'sectorstocks',
            'tools'=> $this->tools
        ]);
     }
     public function sectorResult(Request $request){
        
        $input = $request->all();
        $sector = $input['sector'];
        $user  = User::where('user_id',$this->userId)->get()->first()->toArray();
        $companies = Intrinio::companies();
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