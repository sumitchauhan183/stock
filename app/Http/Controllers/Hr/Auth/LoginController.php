<?php

namespace App\Http\Controllers\Hr\Auth;

use App\Http\Controllers\Controller;
use App\Models\Hr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
         if(Session('user')):
            return redirect('hr/dashboard');
         endif;
    }

    /**
     * Show the login form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        
        return view('hr.auth.login',[
            'title' => 'HR Login',
            'loginRoute' => 'hr.login',
            'forgotPasswordRoute' => 'hr.password.request',
            
        ]);
    }

    /**
     * Login the admin.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $input = $request->input();
        if($this->validator($request)):
            $hr = Hr::where([
                'email'=> $input['email']
            ])->get()->first();

            if (Hash::check($input['password'], $hr->password)):
                session()->put('user',[
                    "type"=>'hr',
                    "data"=>$hr
                ]);
                return redirect()->route('hr.dashboard');
            else:
                session()->put('error','Login failed, please try again!');
                return redirect()->route('hr.login');
            endif;
            
        endif;

        dd($this->validator($request));
    }

    /**
     * Validate the form data.
     * 
     * @param \Illuminate\Http\Request $request
     * @return 
     */
    private function validator(Request $request)
    {
      //validation rules.
            $rules = [
                'email'    => 'required|email|exists:hr|min:5|max:191',
                'password' => 'required|string|min:4|max:255',
            ];

            //custom validation error messages.
            $messages = [
                'email.exists' => 'These credentials do not match our records.',
            ];

            //validate the request.
            return $request->validate($rules,$messages);
    }

    

    /**
     * Redirect back after a failed login.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginFailed()
    {
        return redirect()
        ->back()
        ->withInput()
        ->with('error','Login failed, please try again!');
    }
}
