<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tools;
use Illuminate\Support\Facades\Hash;
use App\Classes\Email;
use Exception;

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
                    'message'=>'Email ID already exists.'
                ]);
            else:
                return json_encode([
                    'error'=>false
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>'Email ID is required'
            ]);
        endif;
    }

    public function checkOTP(Request $request)
    {
        $input = $request->all();
        if(isset($input['otp'])):
            $check = User::where('otp',$input['otp'])
                ->where('user_id',$input['user_id'])
                ->count();
            if($check>0):
                return json_encode([
                    'error'=>false,
                    'message'=>'One Time Password verified'
                ]);
            else:
                return json_encode([
                    'error'=>true
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>'One Time Password is required'
            ]);
        endif;
    }

    public function resetPassword(Request $request)
    {
        $input = $request->all();
        if(isset($input['user_id'])):
            if(isset($input['password'])):
                if($input['confirm'] == $input['password']):
                    $check = User::where('user_id',$input['user_id'])
                        ->update(['password'=>Hash::make($input['password'])]);
                    if($check):
                        return json_encode([
                            'error'=>false
                        ]);
                    else:
                        return json_encode([
                            'error'=>true,
                            'message'=>'Password not updated database error'
                        ]);
                    endif;
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>'confirm Password is not matched'
                    ]);
                endif;
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>'Password is required'
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>'User id is required'
            ]);
        endif;
    }

    public function changePassword(Request $request)
    {
        $input = $request->all();
        if(isset($input['user_id'])):
            if(isset($input['password'])):
                if($input['confirm'] == $input['password']):
                    $check = User::where('user_id',$input['user_id'])
                        ->update(['password'=>Hash::make($input['password'])]);
                    if($check):
                        return json_encode([
                            'error'=>false,
                            'message'=>'Password change successfully'
                        ]);
                    else:
                        return json_encode([
                            'error'=>true,
                            'message'=>'Password not updated database error'
                        ]);
                    endif;
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>'confirm Password is not matched'
                    ]);
                endif;
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>'Password is required'
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>'User id is required'
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

    public function updateProfile(Request $request)
    {
        $input = $request->all();
        $userid = User::where('user_id',$input['userid'])->count();
        if(!$userid):
            return json_encode([
                'error'=>true,
                'message'=>'Userid mismatched'
            ]);
        endif;
        $user = [
            'first_name' =>$input['first_name'],
            'last_name'  =>$input['last_name'],
            'country'=>$input['country'],
            'city'=>$input['city'],
            'state'=>$input['state'],
            'zipcode'=>$input['zipcode']
        ];
        User::where('user_id',$userid)->update($user);
        return json_encode([
            'error'=>false,
            'message'=>'Profile updated Successful'
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
                ->get()->first()
                ->toArray();
            $token = $this->generateToken($user_id);
            User::where('user_id',$user_id)->update(['login_token'=>$token]);
            $user = User::where('user_id',$user_id)
                ->get()->first()->toArray();
            session()->put('user',[
                "type"=>'user',
                "data"=>$user,
                "tools"=>$tool,
                "token" => $token
            ]);

            if(!$tool['expiry_date']):
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

        return Email::sendVerificationMail(
            $user['first_name'].' '.$user['last_name'],
            $user['email'],
            "Analystkit: Verify your mail",
            $user['first_name'].' '.$user['last_name'],
            "Click on below link to verify your email",
            env('APP_URL').'user/verify/mail/'.base64_encode($user_id)
        );

    }

    public function sendOtpMail($email){
        $user    = User::where('email',$email)->get()->first()->toArray();
        try{
            Email::sendOtpMail(
                $user['first_name'].' '.$user['last_name'],
                $user['email'],
                "Analystkit: Password Reset One time password",
                $user['first_name'].' '.$user['last_name'],
                "Please do not share your one time password: ".$this->userUpdateOtp($user['user_id'])." with any one. This is a confidential info."
            );

            return json_encode([
                'error'=>false,
                'message'=>'One Time Password sent successfully on your registerd email',
                'user_id'=> $user['user_id']
            ]);
        }
        catch(Exception $e){
            return json_encode([
                'error'=>true,
                'message'=>$e->getMessage()
            ]);
        }
    }

    public function resendOtpMail($user_id){
        $user    = User::where('user_id',$user_id)->get()->first()->toArray();
        try{
            Email::sendOtpMail(
                $user['first_name'].' '.$user['last_name'],
                $user['email'],
                "Analystkit: Password Reset OTP",
                $user['first_name'].' '.$user['last_name'],
                "Please do not share your otp: ".$this->userUpdateOtp($user['user_id'])." with any one. This is a confidential info."
            );

            return json_encode([
                'error'=>false,
                'message'=>'One Time Password sent successfully on your registerd email',
                'user_id'=> $user['user_id']
            ]);
        }
        catch(Exception $e){
            return json_encode([
                'error'=>true,
                'message'=>$e->getMessage()
            ]);
        }
    }

    private function userUpdateOtp($id){
        $otp     = random_int(100000, 999999);
        User::where('user_id',$id)->update([
            'otp'=>$otp,
            'otp_added_at'=>now()
        ]);

        return $otp;
    }

    private function generateToken($user_id)
    {
        $token = md5($user_id.time());
        User::where('user_id',$user_id)
            ->update(['login_token'=>$token]);
        return $token;
    }


}
