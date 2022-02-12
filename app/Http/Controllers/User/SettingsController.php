<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Classes\Email;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    private $userId;

    public function __construct(Request $request)
    {
        if(session()->get('user')):
            if(session()->get('user')['type']!='user'):
                 redirect()->route('notauthorised');
            endif;
            if(!$this->checkToken()):
                $this->logout();
            endif;
        else:    
            $this->logout();
        endif;

        $this->userId = session()->get('user')['data']['user_id'];
    }

    public function index(){
       $user = User::where('user_id',$this->userId)->get()->first()->toArray();
       
       return view('user.settings.view',[
           'title'=> 'Settings',
           'user'=>$user,
           'url'=>'settings'
       ]);
    }

    public function changePassword(){
        $user = User::where('user_id',$this->userId)->get()->first()->toArray();
        
        return view('user.settings.change_password',[
            'title' => 'change password',
            'user'  =>  $user,
            'url'   => 'change_password'
        ]);
     }

    public function sendVerificationMail(Request $request){
        $input  = $request->all();
        $userid = $input['user_id'];
        
        $send = $this->sendVerifyMail($userid);
            return json_encode([
                'error'=>false,
                'message'=>'verification mail sent successfully'
            ]);

    }

    private function sendVerifyMail($user_id){
        $user    = User::where('user_id',$user_id)->get()->first()->toArray();

        return Email::sendVerificationMail(
            $user['first_name'].' '.$user['last_name'],
            $user['email'],
            "Analystkit: Verify your mail",
            $user['first_name'].' '.$user['last_name'],
            "Click on below link to verify your email",
            env('APP_URL').'user/verify/mail/'.base64_encode($user_id)
        );

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