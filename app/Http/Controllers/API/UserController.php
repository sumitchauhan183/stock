<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tools;
use Illuminate\Support\Facades\Hash;
use App\Classes\Email;

class UserController extends Controller
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
        return "Wrong page";
    }

    public function checkEmail(Request $request)
    {
        $input = $request->all();
        if(isset($input['email'])):
            $check = User::where('email',$input['email'])->count();
            if($check>0):
                return json_encode([
                    'error'=>true,
                    'message'=>'Email id is already exist'
                ]);
            else:
                return json_encode([
                    'error'=>false
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>'Email id is required'
            ]);
        endif;
    }

    public function checkUserid(Request $request)
    {
        $input = $request->all();
        if(isset($input['userid'])):
            $check = User::where('username',$input['userid'])->count();
            if($check>0):
                return json_encode([
                    'error'=>true,
                    'message'=>'Userid is already exist'
                ]);
            else:
                return json_encode([
                    'error'=>false
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>'User id is required'
            ]);
        endif;
    }

    public function registerUser(Request $request)
    {
        $input = $request->all();
        $email  = User::where('email',$input['email'])->count();
        $userid = User::where('username',$input['userid'])->count();
        if($userid>0):
            return json_encode([
                'error'=>true,
                'message'=>'Userid is already exist'
            ]);
        endif;
        if($email>0):
            return json_encode([
                'error'=>true,
                'message'=>'Email id is already exist'
            ]);
        endif;
        $user = [
             'first_name' =>$input['first_name'],
             'last_name'  =>$input['last_name'],
             'country'=>$input['country'],
             'city'=>$input['city'],
             'state'=>$input['state'],
             'zipcode'=>$input['zipcode'],
             'email'=>$input['email'],
             'username'=>$input['userid'],
             'password'=>Hash::make($input['password']),
             'status'=>'unpaid',
             'email_verified'=>'NO',
             'login_token'=> ''
        ];
        User::Create($user);
        $create =  User::where('email',$input['email'])->get()->first()->toArray();
        $user_id = $create['user_id'];
        $this->sendWelcomeMail($user_id);
        $this->sendVerifyMail($user_id);
        Tools::create([
                  'tool'    => $input['tool'],
                  'user_id' => $user_id
        ]);

        return json_encode([
            'error'=>false,
            'message'=>'Rgistration Successful',
            'user_id'=> $user_id
        ]);
    }

    public function loginUser(Request $request)
    {
        $input = $request->all();
        $email  = User::where('email',$input['email'])->count();
        if($email<1):
            return json_encode([
                'error'=>true,
                'message'=>'Email id not exist'
            ]);
        endif;
        $check = User::where('email',$input['email'])
                ->get()->first()->toArray();
        if(Hash::check($input['password'], $check['password'])):
            $user_id = $check['user_id'];
            $tool = Tools::where('user_id',$user_id)
                          ->where('expiry_date',NULL)
                          ->get()
                          ->toArray();
            $token = $this->generateToken($user_id);
            User::where('user_id',$user_id)->update(['login_token'=>$token]);
            $user = User::where('user_id',$user_id)
                ->get()->first()->toArray();
            session()->put('user',[
                "type"=>'user',
                "data"=>$user,
                "token" => $token
            ]);
            
            if(count($tool)):
                return json_encode([
                    'error'=>false,
                    'message'=>'Login Successful',
                    'user_id'=> $user_id,
                    'payment'=> false
                ]);
            else:
                return json_encode([
                    'error'=>false,
                    'message'=>'Login Successful',
                    'user_id'=> $user_id,
                    'payment'=> true
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>'Please check your password'
            ]); 
        endif;  
    }

    public function sendWelcomeMail($user_id){
        $user    = User::where('user_id',$user_id)->get()->first()->toArray();

        Email::sendWelcomeMail(
            $user['first_name'].' '.$user['last_name'],
            $user['email'],
            "Welcome To Analyst",
            $user['first_name'].' '.$user['last_name'],
            "You are Successfully registerd with us."
        );

    }

    public function sendVerifyMail($user_id){
        $user    = User::where('user_id',$user_id)->get()->first()->toArray();

        Email::sendVerificationMail(
            $user['first_name'].' '.$user['last_name'],
            $user['email'],
            "Analystkit: Verify your mail",
            $user['first_name'].' '.$user['last_name'],
            "Click on below link to verify your email",
            env('APP_URL').'user/verify/mail/'.base64_encode($user_id)
        );

    }

    private function generateToken($user_id)
    {
        $token = md5($user_id.time());
        User::where('user_id',$user_id)
                ->update(['login_token'=>$token]);
        return $token;
    }

    
}
