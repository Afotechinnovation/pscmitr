<?php

namespace App\Http\Controllers;

use App\Models\OTP;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
   public function send(Request $request){

       $this->validate($request, [
           'mobile' => 'required|numeric|digits:10|regex:/^[0-9]+$/u',
       ]);

       $isExistingUser = User::whereMobile($request->mobile)->first();
       //Send OTP if it is a new user. Otherwise Login with PIN
       if(!$isExistingUser){
           $otp = null;

           if($request->filled('token')) {
               $otp = Otp::findByToken($request->token);
           }

           if(is_null($otp) || $otp->isExpired() || $otp->isVerified()) {
               $otp = new OTP();
               $otp->mobile = $request->mobile;
               $otp->action = $request->get('action') ?: Otp::ACTION_DEFAULT;
               $otp->save();
           }
           return $this->success('Verification code successfully send', $otp->getToken());
       }
       else{

           return response()->json(true);
       }

   }

    public function verify(Request $request){

        $this->validate($request, [
            'mobile' => 'required|numeric|digits:10|regex:/^[0-9]+$/u',
            'otp' => 'required',
            'otp_token' => 'required',
        ]);
        $is_otp_verified = Otp::verify($request->otp_token, $request->otp);

        if($is_otp_verified){

            return $this->success('Otp verified successfully.', $is_otp_verified,200);
        }
        else{
            return $this->error(404,'Otp verification failed');
        }

    }

    public function loginWithPin(Request $request){

        $this->validate($request, [
            'mobile' => 'required|numeric|digits:10|regex:/^[0-9]+$/u',
            'pin' => 'required'
        ]);

        $previousUrl = url()->previous();

        $user = User::whereMobile($request->mobile)->first();
        $loginUser = User::where('id', $user->id)->first();
        $loginUser->last_login_at = Carbon::now();
        $loginUser->save();

        if(!$user){
            return response()->json(false,404);

        }

       // info(Hash::check( $request->pin, $user->pin_number ));

        if(Hash::check($request->pin, $user->pin_number)){

            Auth::login($user);

            $userPackageCount = Transaction::where('user_id', $user->id)->count();
//            info("count". $isPackagePurchased);

            return $this->success('PIN verified successfully.', $previousUrl, 200);

        }
    }

    public function forgot_pin_otp_send(Request $request){

        $this->validate($request, [
            'mobile' => 'required|numeric|digits:10|regex:/^[0-9]+$/u',
        ]);

        $otp = null;

        if($request->filled('token')) {
            $otp = Otp::findByToken($request->token);
        }

        if(is_null($otp) || $otp->isExpired() || $otp->isVerified()) {
            $otp = new OTP();
            $otp->mobile = $request->mobile;
            $otp->action = $request->get('action') ?: Otp::ACTION_DEFAULT;
            $otpNumber = mt_rand(1000, 9999);
            $otp->code = $otpNumber;

//          Message details
            $userMobile = '91'.$request->mobile;
            $apiKey = urlencode(config('services.sms.api_key'));

            $numbers = array($userMobile);
            $sender = urlencode(config('services.sms.sender_name'));
            $message = rawurlencode($otpNumber." is your OTP to join pscmitr.com family. Enjoy learning our quality content.\nThanks - Pscmitr.com Team");
            $numbers = implode(',', $numbers);

            // Prepare data for POST request
            $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

            // Send the POST request with cURL
            $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            $otp->save();
        }

        return $this->success('Verification code successfully send', $otp->getToken());

    }

    public function forget_pin_otp_verify(Request $request){

        $this->validate($request, [
            'mobile' => 'required|numeric|digits:10|regex:/^[0-9]+$/u',
            'otp' => 'required',
            'otp_token' => 'required',
        ]);

        $is_otp_verified = Otp::verify($request->otp_token, $request->otp);

        if($is_otp_verified){
            return $this->success('Otp verified successfully.', $is_otp_verified,200);
        }
        else{
            return $this->error(404,'Otp verification failed');
        }

    }

    public function forgot_pin_number(Request $request) {
//
//        $this->validate($request, [
//            'mobile_number' => 'required|numeric|digits:10|regex:/^[0-9]+$/u',
//            'new_pin_number' => 'required',
//            'confirm_new_pin_number' => 'required',
//        ]);

      // info($request->mobile_number);
        $user = User::where('mobile', $request->mobile_number)->first();

        $user->pin_number =  Hash::make($request->new_pin_number);

        $user->update();

        $previousUrl = url()->previous();

        $is_pin_updated = "You have successfully Updated Your pin!";
        return redirect( $previousUrl )->with('is_pin_updated',$is_pin_updated);



    }

}
