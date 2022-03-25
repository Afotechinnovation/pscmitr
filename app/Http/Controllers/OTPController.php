<?php

namespace App\Http\Controllers;

use App\Models\OTP;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OTPController extends Controller
{
   public function send(Request $request){
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
           $otp->save();
       }

//       $verify_existing_user = User::where('mobile', $request->mobile)->first();

//       return response()->json($verify_existing_user);

       return $this->success('Verification code successfully send', $otp->getToken());
   }

    public function verify(Request $request){

        $this->validate($request, [
            'mobile' => 'required|numeric|digits:10|regex:/^[0-9]+$/u',
            'otp' => 'required',
            'otp_token' => 'required',

        ]);

        $user = User::where('mobile', $request->mobile)->first();

        $is_otp_verified = Otp::verify($request->otp_token, $request->otp);

        if(!$user){
            DB::beginTransaction();
            $user = new User();
            $user->mobile = $request->mobile;
            $user->role = User::ROLE_STUDENT;
            $user->last_login_at = Carbon::now();
            $user->save();

            $student =  new Student();
            $student->user_id = $user->id;
            $student->name = $user->name;
            $student->mobile = $user->mobile;
            $student->save();
            DB::commit();
        }

        if($is_otp_verified){
            Auth::login($user);

            $user = User::findOrFail(Auth::id());
            $user->last_login_at = Carbon::now();
            $user->save();
            $previousUrl = url()->previous();

            return redirect( $previousUrl );
        }

        return redirect('/')->with('error','Error');

    }

}
