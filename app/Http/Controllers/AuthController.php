<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function index(){
        return view('pages.auth.login');
    }

    public function redirectToGoogle()
    {

        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {

            $user =   Socialite::driver('google')->stateless()->user();
            $finduser =   User::where(['email' => $user->getEmail()])->first();


            if(!$finduser) {
                DB::beginTransaction();

                $role = User::ROLE_STUDENT;

                $newUser = new User();
                $newUser->name = $user->name;
                $newUser->email = $user->email;
                $newUser->provider_id = $user->id;
                $newUser->gender = 1;
                $newUser->role = $role;
                $newUser->save();

                $student = new Student();
                $student->user_id = $newUser->id;
                $student->name = $user->name;
                $student->email = $user->email;
                $student->gender = 1;
                $student->save();

                DB::commit();

                Auth::login($newUser);
                return redirect('user/tests');


            }else{

                Auth::login($finduser);
                return redirect('user/tests');

            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }


    public function redirectToFacebook()
    {

        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback()
    {
        try {

            $user  =  Socialite::driver('facebook')->stateless()->user();
            $finduser =  User::where(['email' => $user->getEmail()])->first();

            if(!$finduser){

                DB::beginTransaction();

                $role = User::ROLE_STUDENT;

                $newUser = new User();
                $newUser->name = $user->name;
                $newUser->email = $user->email;
                $newUser->provider_id = $user->id;
                $newUser->gender = 1;
                $newUser->role = $role;
                $newUser->save();

                $student =  new Student();
                $student->user_id = $newUser->id;
                $student->name = $user->name;
                $student->email = $user->email;
                $student->gender = 1;
                //$student->image = $user->getAvatar();
                $student->save();

                DB::commit();

                Auth::login($newUser);
                return redirect('user/tests');

            }else{

                Auth::login($finduser);
                return redirect('user/tests');

            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
