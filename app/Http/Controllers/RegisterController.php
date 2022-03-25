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
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function register(Request $request){

        $user = User::where('mobile', $request->mobile)->first();

        $this->validate($request, [
            'mobile' => 'required|numeric|digits:10|regex:/^[0-9]+$/u',
            'name' => 'required',
            'email' => 'required|unique:users',
            'gender' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'date_of_birth' => 'required',
            'pin_number'  =>'required|min:4,max:6',

           // 'confirm_pin_number' => 'required|confirm|min:4,max:6'
        ]);

        $previousUrl = url()->previous();

        if(!$user){
            DB::beginTransaction();
            $user = new User();
            $user->mobile = $request->mobile;
            $user->role = User::ROLE_STUDENT;
            $user->last_login_at = Carbon::now();
            $user->pin_number =  Hash::make($request->pin_number);
            $user->name = $request->name;
            $user->save();

            $student =  new Student();
            $student->user_id = $user->id;
            $student->name = $request->name;
            $student->email = $request->email;
            $student->mobile = $user->mobile;
            $student->gender = $request->gender;
            $student->date_of_birth = Carbon::parse($request->date_of_birth);
            $student->country_id = $request->country_id;
            $student->state_id = $request->state_id;
            $student->save();
            DB::commit();

            Auth::login($user);

            $is_registered = "You have successfully registered!";
            return redirect( $previousUrl )->with('is_registered',$is_registered);
        }

    }

public function check_email_unique(Request $request)
{
    $user = User::where('email', $request->email)->first();
    if ($user)
    {
        return response()->json(false);

    }else
    {
        return response()->json(true);

    }

}

}
