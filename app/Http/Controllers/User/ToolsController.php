<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Tools;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ToolsController extends Controller
{
   
    private $userId;
    private $tools;
    public function __construct(Request $request)
    {
        if(session()->get('user')):
            if(session()->get('user')['type']!='user'):
                 redirect()->route('notauthorised');
            endif;
            if(!$this->checkToken()):
                $this->logout();
            endif;
            $this->tools = session()->get('user')['tools'];
        else:    
            $this->logout();
        endif;

        $this->userId = session()->get('user')['data']['user_id'];
    }

    public function index(){
        return view('user.tools.view',[
            'title' => 'Tools',
            'url'   => 'tools',
            'tools' => $this->tools
        ]);
    }
    private function logout()
    {
        echo "<script>window.location.href = '".env('APP_URL')."user/login';</script>";
    }

    private function checkToken(){
        
       return User::where('user_id',session()->get('user')['data']['user_id'])
              ->where('login_token',session()->get('user')['token'])
              ->count();
    }
}