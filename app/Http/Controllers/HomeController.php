<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(session()->get('user')):
            return redirect()->route('user.dashboard');
        else:
            return view('home',[
                'title' => 'Home',
                'url' => ''
            ]);
        endif;
        
    }

    public function verifyEmail($token)
    {
        $user_id = base64_decode($token);
        $user = User::where('user_id',$user_id)
                      ->where('email_verified','NO')
                      ->get()->count();
        if($user):
            User::where('user_id',$user_id)->update(['email_verified'=>'YES']);
            return view('user.verify_success',['url'=>'']);
        else:
            return view('user.verify_failure',['url'=>'']);
        endif;
        
    }

    public function noaccess()
    {
        return view('noaccess',[
            'title' => 'Not Authorised'
        ]);
    }

    public function pageNotFound()
    {
        return view('pagenotfound',[
            'title' => 'Not Authorised'
        ]);
    }

    
}
