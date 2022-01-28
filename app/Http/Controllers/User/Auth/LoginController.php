<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cards;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Session;
use Stripe;
use App\Models\Tools;


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
    private $url;
    

    public function __construct()
    {
        $url = url()->current();
        $url = explode('/',$url);
        $this->url = $url[count($url)-1];
         if(Session('user')):
            return redirect('user/dashboard');
         endif;
    }

    /**
     * Show the login form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        if(session()->get('user')):
            return redirect()->route('user.dashboard');
        else:
            return view('user.auth.login',[
                'title' => 'User Login',
                'url' => $this->url
            ]);
        endif;
        
    }

    /**
     * Show the login form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        if(session()->get('user')):
            return redirect()->route('user.dashboard');
        else:
            $input = $request->all();
        if(isset($input['tool'])):
            return view('user.register',[
                'title' => 'User Registration',
                'tool' => $input['tool'],
                'url' => $this->url
            ]);
        else:
            return redirect()->route('home');
        endif;
        endif;
        
        
    }

    /**
     * Show the login form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showPaymentForm(Request $request)
    {
        $input = $request->all();
        if(isset($input['user_id'])):
            $amount = 0;
            $item = "";
            $tool = Tools::where('user_id',$input['user_id'])->get()->first()->toArray();
            if(count($tool)):
                if($tool['expiry_date'] == null):
                    if($tool['tool']==3):
                        $amount = 345;
                        $item = "Find Value Stocks + Optimize Investment Mix";
                    elseif($tool['tool']==2):
                        $amount = 200;
                        $item = "Optimize Investment Mix";
                    else:
                        $amount = 145;
                        $item = "Find Value Stocks";
                    endif;
                    return view('user.payment',[
                        'title' => 'User Payment',
                        'user_id' => $input['user_id'],
                        'url' => $this->url,
                        'amount' => $amount,
                        'item' => $item
                    ]);
                else:
                    return redirect()->route('home');
                endif;
            else:
                return redirect()->route('home');
            endif;
        else:
            return redirect()->route('home');
        endif;
        
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * handling payment with POST
     */
    public function handlePost(Request $request)
    {
        $input = $request->all();
        if(isset($input['user_id'])):
                $amount = 0;
                $item = "";
                $tool = Tools::where('user_id',$input['user_id'])->get()->first()->toArray();
                if(count($tool)):
                    if($tool['expiry_date'] == null):
                        if($tool['tool']==3):
                            $amount = 345;
                            $item = "Find Value Stocks + Optimize Investment Mix";
                        elseif($tool['tool']==2):
                            $amount = 200;
                            $item = "Optimize Investment Mix";
                        else:
                            $amount = 145;
                            $item = "Find Value Stocks";
                        endif;
                        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                        $stripe = Stripe\Charge::create ([
                                "amount" => 100 * $amount,
                                "currency" => "inr",
                                "source" => $request->stripeToken,
                                "description" => $item 
                        ]);
                        if($stripe->status=='succeeded'):
                            Tools::where('tool_id',$tool['tool_id'])
                                  ->update([
                                      'purchase_date'=>date('Y-m-d', time()),
                                      'expiry_date'=>date('Y-m-d', strtotime('+1 year'))
                                  ]);  
                            Payment::create([
                                'user_id' => $request->user_id,
                                'order_id' => $tool['tool_id'],
                                'transaction_id' => $stripe->balance_transaction,
                                'transaction_status' => 'success',
                                'transaction_amount' =>$amount,
                                'transaction_data' => $this->getPaymentJson($stripe)
                            ]); 
                            $card = Cards::where('card_number',$request->card_number)
                                           ->where('user_id',$request->user_id)
                                           ->count();
                            if($card):
                                $card = Cards::where('card_number',$request->card_number)
                                           ->where('user_id',$request->user_id)
                                           ->first()->toArray();
                                Cards::where('card_id',$card['card_id'])
                                       ->update([
                                            'user_id' => $request->user_id,
                                            'card_number' => $request->card_number,
                                            'card_expiry' => $request->exp_mon.'/'.$request->exp_year,
                                            'card_type' => $request->card_type,
                                            'owner_name' => $request->owner_name,
                                            'status' => 'active'
                                       ]);
                            else:
                                Cards::create([
                                            'user_id' => $request->user_id,
                                            'card_number' => $request->card_number,
                                            'card_expiry' => $request->exp_mon.'/'.$request->exp_year,
                                            'card_type' => $request->card_type,
                                            'owner_name' => $request->owner_name,
                                            'status' => 'active'
                                       ]);
                            endif;
                            return redirect()->route('user.payment.success');
                        else:
                            return redirect()->route('user.payment.failure');
                        endif;
                    else:
                        return redirect()->route('home');
                    endif;
            else:
                return redirect()->route('home');
            endif;
        else:    
            return redirect()->route('home');
       endif;
    }

    /**
     * Login the admin.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paymentSuccess(Request $request)
    {
        return view('user.payment_success',[
            'title' => 'Success Payment',
            'url' => $this->url
        ]);
    }

    /**
     * Validate the form data.
     * 
     * @param \Illuminate\Http\Request $request
     * @return 
     */
    public function paymentFailure(Request $request)
    {
        return view('user.payment_failure',[
            'title' => 'Failure Payment',
            'url' => $this->url
        ]);
    }

    private function getPaymentJson($pay){

     $payment = [  
        "id"=> $pay->id,
        "object"=> $pay->object,
        "amount"=>$pay->amount,
        "amount_captured"=>$pay->captured,
        "balance_transaction"=>$pay->balance_transaction,
        "calculated_statement_descriptor"=>$pay->calculated_statement_descriptor,
        "captured"=>$pay->captured,
        "created"=>$pay->created,
        "currency"=>$pay->currency,
        "description"=>$pay->description,
        "livemode"=>$pay->livemode,
        "paid"=>$pay->paid,
        "payment_method"=>$pay->payment_method,
        "receipt_url"=>$pay->receipt_url,
        "status"=>$pay->status
     ];

     return json_encode($payment);
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
