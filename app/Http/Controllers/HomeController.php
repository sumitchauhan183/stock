<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home',[
            'title' => 'Dashboard'
        ]);
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
