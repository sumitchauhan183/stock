<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Payment;
use App\Models\User;
use App\Models\Cards;
use App\Models\Tools;
use Illuminate\Support\Facades\Hash;
use App\Classes\Utils;
use Illuminate\Contracts\Session\Session;

class HomeController extends Controller
{
    private $admin_id;
    public function __construct(Request $request)
    {
        if(session()->get('admin')):
            if(session()->get('admin')['type']!='admin'):
                return redirect()->route('notauthorised');
            endif;
        else:    
            return redirect()->route('admin.login');
        endif;
        $this->admin_id = session()->get('admin')['data']['admin_id'];
    }

    
    /**
     * Show Admin Dashboard.
     * 
     * @return \Illuminate\Http\Response
     */
    

    public function dashboard(){
        
        $admin = Admin::where('admin_id',$this->admin_id)->get()->first();
        $todayMoney = Payment::where('transaction_status','success')
                             ->where('updated_at','>',date('Y-m-d', strtotime('-1 day')))
                             ->where('updated_at','<',date('Y-m-d', strtotime('+1 day')))
                             ->sum('transaction_amount');
        $users      = User::get()->count();
        $vusers     = User::where('email_verified','like','Yes')->get()->count();
        $eusers     = User::join('user_tools as ut','users.user_id','ut.user_id')
                            ->where('ut.expiry_date','<',date('Y-m-d',strtotime('+1 day')))
                            ->count();
        $data = [
                    'todaysMoney' => $todayMoney,
                    'users'=> $users,
                    'verified-users'=> $vusers,
                    'expire-tool-users'=>$eusers
        ];
        return view('admin.dashboard',
        [
            'page'=>'dashboard',
            'url'=>'dashboard',
            'title'=>'Dashboard',
            'data'=>$data,
            'admin'=>$admin
        ]);
    }

    


    public function profile(){
        return view('admin.profile',
        [
            'page'=>'profile',
            'profile' => session()->get('user')['data'],
            'url' => 'profile'
        ]
      );
    }


    public function logout()
    {
        session()->flush();
        return redirect()->route('admin.login');
    }
}