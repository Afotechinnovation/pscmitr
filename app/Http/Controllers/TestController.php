<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestCategory;
use App\Models\TestResult;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index(){
        return view('pages.quizes.index');
    }

    public function liveTest() {
        $liveTests =  Test::where('is_live_test', true)
            ->whereDate('live_test_date_time', Carbon::now())
            ->get();

        $availableLiveTestCount =  Test::with('test_results')
            ->where('is_live_test', true)
            ->whereDate('live_test_date_time', Carbon::now())
            ->count();

        if(Auth::user()) {
            $completedTests = TestResult::where('user_id', Auth::user()->id)
                    ->whereNotNull('ended_at')
                    ->pluck('test_id')->toArray();

            $liveTests =  Test::with('test_results')
                ->where('is_live_test', true)
                ->whereDate('live_test_date_time', Carbon::now())
                ->whereNotIn('id', $completedTests)
                ->get();
        }
//return $completedTests;

        return view('pages.user.tests.live_test', compact('liveTests','availableLiveTestCount'));
    }

    public function today_test() {

        $todayTests =  Test::where('is_today_test', true)
            ->whereDate('today_test_date', Carbon::today())
            ->where('is_published', true)
            ->get();

        return view('pages.user.tests.today_test',compact('todayTests'));
    }

    public function quickTest(Request $request) {

        $testId = $request->test;

        $test =  Test::where('name_slug', $testId)
            ->where('is_published', true)
            ->first();

        if(Auth::user()) {

            $isAttemptedTest = TestResult::where('user_id', Auth::user()->id)
                ->whereNotNull('ended_at')
                ->where('test_id', $test->id)
                ->get();

            $isAttemptedTestCount = $isAttemptedTest->count();

        }else{
            $isAttemptedTestCount = 0;
        }

    return view('pages.user.tests.quick_test',compact('test','isAttemptedTestCount'));
    }

}
