<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class PurchaseController extends Controller
{
    public function checkout(Request $request){

//        $package = Package::find( $request->get('package') );
        $package = Package::where('name_slug', $request->get('package'))->first();
        if(Auth::user()) {

            $user = User::findOrFail(Auth::user()->id);
            $isProfileComplete = $user->is_profile_completed;

        }else{
            $isProfileComplete = Null;
        }




        return view('pages.purchases.checkout', compact( 'package','isProfileComplete'));
    }

    public function test(){
        return view('pages.purchases.test');
    }
}
