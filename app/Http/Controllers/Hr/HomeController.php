<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Models\Hr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    public function __construct(Request $request)
    {
        
       
        if(session()->get('user')):
            if(session()->get('user')['type']!='hr'):
                return redirect()->route('notauthorised');
            endif;
        else:    
            return redirect()->route('hr.login');
        endif;
    }

    
    /**
     * Show Admin Dashboard.
     * 
     * @return \Illuminate\Http\Response
     */
    

    public function dashboard(){
        return view('hr.home');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('hr.login');
    }
}