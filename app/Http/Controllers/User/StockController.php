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
       dd(companies);
       return view('user.stocks.all',[
           'user'=>$user,
           'url'=>'allStocks',
           'tools'=>$this->tools
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

     public function sector(){
        $user = User::where('user_id',$this->userId)->get()->first()->toArray();
        return view('user.stocks.sector',[
            'user'=>$user,
            'url'=>'sectorstocks',
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