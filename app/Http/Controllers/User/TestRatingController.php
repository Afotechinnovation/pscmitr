<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PackageTest;
use App\Models\Test;
use App\Models\TestRating;
use App\Models\TestResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestRatingController extends Controller
{

    public function index($testId, $testresultId)
    {
        $test = Test::findOrFail($testId);

        return view('pages.user.tests.rating', compact('test','testresultId'));
    }

    public function store(Request $request, $testId){

        $testResult = TestResult::findOrFail($request->testResultId);
        if(!$testResult->package_id) {
            $testRating = TestRating::where('test_id', $testId)
                ->where('user_id', Auth::id())
                ->orderBy('id','DESC')
                ->first();
        }else {
            $testRating = TestRating::where('test_id', $testId)
                ->where('package_id', $testResult->package_id)
                ->where('user_id', Auth::id())
                ->orderBy('id','DESC')
                ->first();
        }

        if(!$testRating){
            $testRating = new TestRating();
        }

        $testRating->package_id =  $testResult->package_id ?? null;
        $testRating->test_result_id = $request->testResultId;
        $testRating->test_id =  $testId;
        $testRating->user_id =  Auth::id();
        $testRating->rating = $request->rating;
        $testRating->save();

        return response()->json(true, 200);

    }

}
