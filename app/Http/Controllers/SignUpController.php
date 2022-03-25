<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Course;
use App\Models\Occupation;
use App\Models\OTP;
use App\Models\State;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\False_;

class SignUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::query()->cursor();
        $defaultCountry = Country::where('name', 'like', 'India')->first();
        $defaultState = State::where('country_id', $defaultCountry->id)->where('name', 'like', 'Kerala')->first();
        $occupations = Occupation::query()->cursor();

        return view('pages.auth.sign-up.index', compact('courses', 'defaultState', 'defaultCountry', 'occupations'));
    }

    public function send(Request $request)
    {

        $this->validate($request, [
            'mobile' => 'required|numeric|digits:10|regex:/^[0-9]+$/u',
        ]);

        $isExistingUser = User::where('mobile', $request->mobile)->first();

        if(!$isExistingUser){

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
                $otp->save();

                $apiKey = urlencode(config('services.sms.api_key'));
                $userMobile = '91'.$request->mobile;

//              Message details
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

            }

            return $this->success('Verification code successfully send', $otp->getToken());
        }
        else{
            return $this->error(404,'Already exists');
//            return response()->json(true);
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

    public function storePinNumber(Request $request)
    {

         $this->validate($request, [
             'pin' => 'min:4|numeric|required_with:confirm_pin|same:confirm_pin',
             'confirm_pin' => 'min:4|numeric'
         ]);

        $mobile = $request->mobile;
        $pin = $request->pin;

        $user = new User();
        $user->mobile = $mobile;
        $user->role = User::ROLE_STUDENT;
        $user->pin_number = Hash::make($pin);
        $user->is_profile_completed = false;
        $user->save();

        $student = new Student();
        $student->mobile = $mobile;
        $student->user_id = $user->id;
        $student->save();

        return $this->success('Successfully updated', null,200);
    }

    public function updateNameAndEmail(Request $request)
    {
        info('nameand email');
        $user = User::where('mobile', $request->mobile)->first();


        $this->validate($request, [
            'email' => 'required|max:191|unique:users,email,'.$user->id,
        ]);


        $name = $request->name;
        $email = $request->email;
        $phone = $request->mobile;
        $gender = $request->gender;

//        $userEmailAlreadyExist = User::where('email', $email)->exists();
//        if($userEmailAlreadyExist){
//            return $this->error(404,'Email already exist');
//        }

//        $user = User::where('mobile', $phone)->first();
        $user->name = $name;
        $user->email = $email;
        $user->gender = $gender;
        $user->save();

        $student = Student::where('mobile', $phone)->where('user_id', $user->id)->first();
        $student->name = $name;
        $student->email = $email;
        $student->gender = $request->gender;
        $student->save();

        Auth::login($user);

        return $this->success('SignUp Successfull', null,200);
    }

    public function addUserInterest(Request $request)
    {
        $mobile = $request->mobile;
        $interests = $request->interests;

        $interestArrayLength = count($interests);

        $user = User::where('mobile', $mobile)->first();
        $user->userInterests()->wherePivot('user_id', $user->id)->detach();
        for($i=0; $i<$interestArrayLength;$i++){
            $user->userInterests()->attach($user->id, ['course_id' => $interests[$i]]);
        }

        return $this->success('Successfully updated', null,200);

    }

    public function updateDOBAndGender(Request $request)
    {
        $mobile = $request->mobile;
        $dob = $request->dob;
        $gender = $request->gender;

        $user = User::where('mobile', $mobile)->first();
        $user->dob = Carbon::parse($dob);
        $user->gender = $request->gender;
        $user->save();

        $student = Student::where('mobile', $mobile)->where('user_id', $user->id)->first();
        $student->date_of_birth = Carbon::parse($dob);
        $student->gender = $request->gender;
        $student->save();

        return $this->success('Successfully updated', null,200);

    }

    public function updateStateAndCountry(Request $request)
    {
        $mobile = $request->mobile;
        $state = $request->state;
        $country = $request->country;
        $place = $request->place;

        $user = User::where('mobile', $mobile)->first();
        $student = Student::where('mobile', $mobile)->where('user_id', $user->id)->first();
        $student->state_id = $state;
        $student->country_id = $country;
        $student->place = $place;
        $student->save();

        return $this->success('Successfully updated', null,200);
    }

    public function addOccupations(Request $request)
    {
        $occupations = $request->occupations;
        $mobile = $request->mobile;

        $occupationArrayLength = count($occupations);

        $user = User::where('mobile', $mobile)->first();
        Auth::login($user);
        $user->userOccupations()->wherePivot('user_id', $user->id)->detach();
        for($i=0; $i<$occupationArrayLength; $i++){
            $user->userOccupations()->attach($user->id,['occupation_id' => $occupations[$i]]);
        }
        return $this->success('Sign Up Successfull', null,200);
    }

}
