<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    public function __construct(Request $request)
    {
        
       
        if(session()->get('user')):
            if(session()->get('user')['type']!='user'):
                return redirect()->route('notauthorised');
            endif;
        else:    
            return redirect()->route('user.login');
        endif;
    }

    
    /**
     * Show Admin Dashboard.
     * 
     * @return \Illuminate\Http\Response
     */
    

    public function dashboard(){
        return view('user.home');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('user.login');
    }
}