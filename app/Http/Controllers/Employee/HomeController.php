<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee;

class HomeController extends Controller
{

    public function __construct(Request $request)
    {
        
       
        if(session()->get('user')):
            if(session()->get('user')['type']!='employee'):
                return redirect()->route('notauthorised');
            endif;
        else:    
            return redirect()->route('employee.login');
        endif;
    }

    
    /**
     * Show Admin Dashboard.
     * 
     * @return \Illuminate\Http\Response
     */
    

    public function dashboard(){
        return view('employee.home');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('employee.login');
    }
}