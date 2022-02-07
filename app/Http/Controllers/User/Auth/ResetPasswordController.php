<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    private $url;
    

    public function __construct()
    {
        $url = url()->current();
        $url = explode('/',$url);
        $this->url = $url[count($url)-1];
         if(Session('user')):
            return redirect('user/dashboard');
         endif;
    }

    
    public function email(){
        return view('user.auth.passwords.email',[
            'title' => 'Confirm Email',
            'url' => $this->url
        ]);
    }

    public function reset(Request $request){
        $input = $request->all();
        return view('user.auth.passwords.reset',[
            'title' => 'Reset Password',
            'url' => $this->url,
            'user_id'=> $input['user_id']
        ]);
    }

    public function confirm(){
        return view('user.auth.passwords.confirm',[
            'title' => 'Confirm Reset Password',
            'url' => $this->url
        ]);
    }
}
