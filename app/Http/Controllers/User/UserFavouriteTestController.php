<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserFavouriteTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFavouriteTestController extends Controller
{

    public function store(Request $request, UserFavouriteTest $userFavouriteTest)
    {
        $userFavouriteTest->user_id =Auth::user()->id;
        $userFavouriteTest->test_result_id = $request->testResultId;
        $userFavouriteTest->test_id = $request->testId;
        $userFavouriteTest->save();
        return response()->json(true, 200);

    }

    public function destroy(Request $request)
    {

        $userFavouriteTest = UserFavouriteTest::findOrFail($request->favouriteTestId);

        $userFavouriteTest->delete();

        return response()->json(true, 200);
    }
}
