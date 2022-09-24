<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tools;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $admin_id;
    public function __construct(Request $request)
    {
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


    public function users(){

        $admin = Admin::where('admin_id',$this->admin_id)->get()->first();

        $users      = User::get();

        return view('admin.users',
        [
            'page'=>'Users > List',
            'url'=>'users',
            'surl' => 'userList',
            'title'=>'Users List',
            'users'=>$users,
            'admin'=>$admin
        ]);
    }

    public function details($id){

        $admin = Admin::where('admin_id',$this->admin_id)->get()->first();
        $id = base64_decode($id);
        $users      = User::where('user_id',$id)->get()->first();
        $transactions = Payment::where('user_id',$id)->get();
        $tools = Tools::where('user_id',$id)->get();

        return view('admin.user_details',
            [
                'page'=>'User > Details',
                'url'=>'users',
                'surl' => 'userDetails',
                'title'=>'Details',
                'users'=>$users,
                'transactions'=> $transactions,
                'tools'=>$tools,
                'admin'=>$admin
            ]);
    }

    public function transactionDetail($id){

        $admin = Admin::where('admin_id',$this->admin_id)->get()->first();
        $id = base64_decode($id);
        $transactions = Payment::where('transaction_id',$id)->get()->first();

        return view('admin.transaction_details',
            [
                'page'=>'Payments > Details',
                'url'=>'payments',
                'surl' => 'paymentDetails',
                'title'=>'Details',
                'transactions'=> $transactions,
                'admin'=>$admin
            ]);
    }

    public function tools(){

        $admin = Admin::where('admin_id',$this->admin_id)->get()->first();
        $tools = Tools::get();

        return view('admin.tools',
            [
                'page'=>'Tools',
                'url'=>'tools',
                'surl' => 'tools',
                'title'=>'Tools',
                'tools'=>$tools,
                'admin'=>$admin
            ]);
    }

    public function payments(){

        $admin = Admin::where('admin_id',$this->admin_id)->get()->first();
        $payments = Payment::get();

        return view('admin.payments',
            [
                'page'=>'Payments',
                'url'=>'payments',
                'surl' => 'payments',
                'title'=>'Payments',
                'payments'=>$payments,
                'admin'=>$admin
            ]);
    }

}
