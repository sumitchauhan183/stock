<?php

namespace App\Http\Controllers\Admin\Auth;


use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    

    public function __construct()
    {
         if(Session()->get('admin')):
            return redirect('admin/dashboard');
         elseif(Session()->get('user')):   
            return redirect('user/dashboard');
         endif;
    }

    /**
     * Show the login form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        
        return view('admin.auth.login',[
            'title' => 'Admin Login',
            'url' => 'login'
        ]);
    }
}
