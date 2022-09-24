<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Payment;
use App\Models\User;
use App\Models\CompanyDetail;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private $admin_id;
    public function __construct(Request $request)
    {
        //dd(route('admin.login'));
        if(session()->get('admin')):
            if(session()->get('admin')['type']!='admin'):
                echo "<script> window.location.href = '".route('notauthorised')."'; </script>";
                die();
            endif;
        else:
            echo "<script> window.location.href = '".route('admin.login')."'; </script>";
            die();
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
        $companies = CompanyDetail::get()->count();
        $stransactions = Payment::select(DB::raw("SUM(transaction_amount) as total"))->where('transaction_status','success')->get()->first();


        $data = [
                    'todaysMoney' => $todayMoney,
                    'users'=> $users,
                    'verified-users'=> $vusers,
                    'expire-tool-users'=>$eusers,
                    'companies' => $companies,
                    's_transactions' => $stransactions->total
        ];
        return view('admin.dashboard',
        [
            'page'=>'dashboard',
            'url'=>'dashboard',
            'surl' => 'dashboard',
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
