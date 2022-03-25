<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\MarkForReviewQuestions;
use App\Models\Package;
use App\Models\Question;
use App\Models\Section;
use App\Models\StudentAnswer;
use App\Models\Subject;
use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\TestQuestion;
use App\Models\TestResult;
use App\Models\TestSection;
use App\Models\Transaction;
use App\Models\UserFavouriteQuestion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestResultController extends Controller
{

    public function index($testId, $testresultId)
    {

        $test = Test::findOrFail($testId);

//        $completedTests = TestResult::getCompletedTestResult( $testId, $packageId);

        $completedTestResult = TestResult::findOrFail($testresultId);

        $totalQuestions = $test->test_questions->count();

        $totalQuestionsAttempted = StudentAnswer::where('test_id', $testId)
            ->where('test_result_id', $completedTestResult->id)
            ->where('user_id', Auth::id())
            ->count();

         //$totalWrongAnswers = $completedTestResult->total_wrong_answers;
         //$totalCorrectAnswers = $completedTestResult->total_correct_answers;
         //return $totalWrongAnswers;

        $totalWrongAnswers = StudentAnswer::where('test_id', $testId)
            ->where('test_result_id', $completedTestResult->id)
            ->where('user_id', Auth::id())
            ->where('is_correct', false)
            ->count();
        $totalCorrectAnswers = StudentAnswer::where('test_id', $testId)
            ->where('test_result_id', $completedTestResult->id)
            ->where('user_id', Auth::id())
            ->where('is_correct', true)
            ->count();

       // return $totalCorrectAnswers;

        $totalUnattempted = $totalQuestions - $totalQuestionsAttempted;

        $testPercentageMarks = round( ($completedTestResult->total_marks/$test->total_marks) * 100);

        if($testPercentageMarks < 0) {

            $percentageMarks = 0;
        }else {
            $percentageMarks = $testPercentageMarks;
        }

        $totalNegativeMarks = $totalWrongAnswers * $test->negative_marks;

        $test_sections = TestSection::with('test_questions')
                            ->whereHas('test_questions')
                            ->pluck('name');

        $test_rank =  TestResult::where('test_id', $testId)
            ->whereNotNull('ended_at')
            ->groupBy('user_id')
            ->orderBy('mark_percentage','DESC')
            ->pluck( 'user_id')
            ->toArray();

        $user_id = Auth::id();
        $userRankKey = array_search ($user_id, $test_rank);
        $userRank = $userRankKey + 1;

        // section wise graph

        $sections = TestSection::with('test_questions')
            ->whereHas('test_questions', function ($test_questions) use( $testId){
                $test_questions->where('test_id', $testId);
            })
            ->pluck('name');

        $sectionWiseAnswers = TestSection::with('test_questions')
            ->whereHas('test_questions', function ($test_questions) use( $testId ){
                $test_questions->where('test_id', $testId);
            })
            ->get();

        $section_wise_correct_answers = [];
        $section_wise_wrong_answers = [];

        foreach($sectionWiseAnswers as $sectionWiseAnswer){
            $section_wise_correct_answers[] = $sectionWiseAnswer->student_answers->where('is_correct', true)
                ->where('test_result_id', $testresultId)
                ->count();
            $section_wise_wrong_answers[] =  $sectionWiseAnswer->student_answers->where('is_correct', false)
                ->where('test_result_id', $testresultId)
                ->count();

        }

        $section_wise_attended_questions = [];
        foreach($section_wise_correct_answers as $key => $value) {
            $section_wise_attended_questions[$key] = $value + ($section_wise_wrong_answers[$key] ?? 0);
        }

        $sectionWiseTotalQuestions = TestSection::withCount('test_questions')
            ->whereHas('test_questions', function ( $test_questions ) use ( $testId ){
                $test_questions->where('test_id', $testId);
            })
            ->get();

        $section_wise_total_questions = [];

        foreach($sectionWiseTotalQuestions as $sectionWiseTotalQuestion){
            $section_wise_total_questions[] =  $sectionWiseTotalQuestion->test_questions_count;

        }

        $section_wise_unattempted_questions = [];
        foreach($section_wise_total_questions as $key => $value) {
            $section_wise_unattempted_questions[$key] = $value - ($section_wise_attended_questions[$key] ?? 0);

        }

        $activePackages = Transaction::where('user_id', Auth::user()->id)
                            ->where('package_expiry_date', '>=', Carbon::today()->format('Y-m-d'))
                            ->pluck('package_id')->toArray();

        if($section_wise_total_questions) {
            $maxMark = max($section_wise_total_questions);
        }else{
            $maxMark = NULL;
        }


        return view('pages.user.tests.result', compact('test','completedTestResult','percentageMarks',
            'totalQuestionsAttempted','totalNegativeMarks','test_sections','totalUnattempted','totalWrongAnswers','totalCorrectAnswers','userRank','sections','section_wise_correct_answers',
            'section_wise_wrong_answers','section_wise_unattempted_questions','activePackages','testresultId','maxMark'));
    }

    public function store(Request $request, $testId){

        $test = Test::findOrfail($testId);

        if($request->package) {
            $package = Package::withTrashed()->findOrFail($request->packageId);

            $testAttempts = TestResult::where('test_id', $testId)
                ->where('user_id', Auth::id())
                ->where('package_id', $request->packageId)
                ->max('attempt');

            $previousTestAttempts = TestResult::where('test_id', $testId)
                ->where('user_id', Auth::id())
                ->where('package_id', $request->packageId)
                ->pluck('id');

            $markedForReviewQuestions = MarkForReviewQuestions::where('test_id', $testId)
                ->where('user_id', Auth::id())
                ->where('package_id', $request->packageId)
                ->pluck('id');

            $userFavouriteQuestions = UserFavouriteQuestion::where('test_id', $testId)
                ->where('user_id', Auth::id())
                ->where('package_id', $request->packageId)
                ->pluck('id');

        }else {
            $testAttempts = TestResult::where('test_id', $testId)
                ->where('user_id', Auth::id())
                ->max('attempt');

            $previousTestAttempts = TestResult::where('test_id', $testId)
                ->where('user_id', Auth::id())
                ->pluck('id');

            $markedForReviewQuestions = MarkForReviewQuestions::where('test_id', $testId)
                ->where('user_id', Auth::id())
                ->pluck('id');

            $userFavouriteQuestions = UserFavouriteQuestion::where('test_id', $testId)
                ->where('user_id', Auth::id())
                ->pluck('id');
        }

        TestResult::whereIn('id', $previousTestAttempts)->delete();

        UserFavouriteQuestion::whereIn('id', $userFavouriteQuestions)->delete();

        MarkForReviewQuestions::whereIn('id', $markedForReviewQuestions)->delete();

        $testResult = new TestResult();
        $testResult->user_id = Auth::id();
        $testResult->test_id = $testId;
        $testResult->package_id = $request->packageId ?? null;
        $testResult->course_id = $test->course_id;
        $testResult->attempt = $testAttempts + 1;
        $testResult->started_at = Carbon::now();
        $testResult->save();

        $testAttempt = new TestAttempt();
        $testAttempt->user_id = Auth::id();
        $testAttempt->test_id = $testId;
        $testAttempt->package_id = $request->packageId ?? null;
        $testAttempt->test_result_id = $testResult->id;
        $testAttempt->attempts = $testAttempts + 1;
        $testAttempt->save();

        return response()->json(true, 200);

    }

    public function submitTest(Request  $request){

        info("Oktest submitted");
        $test = Test::findOrFail($request->testId);

//        $testResult = TestResult::getTestResult( $request->testId,  $request->packageId );

        $testResult = TestResult::findOrFail($request->testResultId);


        $totalCorrectAnswers =  StudentAnswer::where('test_id', $request->testId)
           // ->where('package_id', $request->packageId)
            ->where('test_result_id', $request->testResultId)
            ->where('user_id', Auth::id())
            ->where('is_correct', true)
            ->count();

        $totalWrongAnswers =  StudentAnswer::where('test_id', $request->testId)
         //   ->where('package_id', $request->packageId)
            ->where('test_result_id', $request->testResultId)
            ->where('user_id', Auth::id())
            ->where('is_correct', false)
            ->count();

        $totalCorrectAnswerMarks = $totalCorrectAnswers * $test->correct_answer_marks;
        $totalWrongAnswerMarks   = $totalWrongAnswers * $test->negative_marks;
        $totalMarksObtained      = $totalCorrectAnswerMarks - $totalWrongAnswerMarks;

        $now = Carbon::now();
        $testStarted = Carbon::parse($testResult->started_at);
        $testEndTime = $now;

        $totalDuration = strtotime($testEndTime) - strtotime($testStarted) ;

        $totalTestDuration =  round(($totalDuration/60),2);

        $testResult->ended_at = $now;
        $testResult->total_correct_answers = $totalCorrectAnswers;
        $testResult->total_wrong_answers = $totalWrongAnswers;
        $testResult->total_marks = $totalMarksObtained;
        $test_marks = $totalMarksObtained;
        $total_test_mark = $test->total_marks;
        $testResult->total_duration = $totalTestDuration;
        $mark_percentile = ($test_marks/$total_test_mark) * 100;

        if($mark_percentile < 0) {

            $testResult->mark_percentage = 0;
        }else {
            $testResult->mark_percentage = $mark_percentile;
        }

        $testResult->save();

        $test_attempts =  TestAttempt::where('test_result_id', $request->testResultId)->first();

        $test_attempts->total_mark = $totalMarksObtained;

       // user rank

        $test_rank =  TestResult::where('test_id', $request->testId)
          //  ->where('package_id', $request->packageId)
            ->whereNotNull('ended_at')
            ->groupBy('user_id')
            ->orderBy('mark_percentage','DESC')
            ->pluck( 'user_id')
            ->toArray();

        $user_id = Auth::id();
        $userRankKey = array_search ($user_id, $test_rank);
        $userRank = $userRankKey + 1;
        $test_attempts->rank = $userRank;

        if($mark_percentile < 0) {

            $test_attempts->percentile = 0;
        }else {
            $test_attempts->percentile = $mark_percentile;
        }

        $testAttempt = TestAttempt::where('test_id', $request->testId)
            ->where('test_result_id', $request->testResultId)
            ->where('attempts', 1)
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc');

        $lastAttempt = TestAttempt::where('test_id', $request->testId)
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc');

        $packageId = $test_attempts->package_id ?? null;

        // get last  and first test attempt to get previous attemptmark

        if($packageId) {

            $firstAttempt = $testAttempt->where('package_id', $packageId)
                ->first();

            $lastTestAttempt = $lastAttempt->where('package_id', $packageId)
                ->first();

            $previousAttemptNumber = $lastTestAttempt->attempts - 1;

        }else{

            $firstAttempt = $testAttempt->first();
            $lastTestAttempt = $lastAttempt->first();

            $previousAttemptNumber = $lastTestAttempt->attempts - 1;

        }

        $previousAttempt = TestAttempt::where('test_id', $request->testId)
            ->where('user_id', Auth::id())
            ->where('attempts', $previousAttemptNumber)
            ->first();

        if(!$firstAttempt) {

            $previousAttemptPercentage = $previousAttempt->percentile;

            if($previousAttemptPercentage == 0 && $mark_percentile > 0) {
                $test_attempts->progress =  $mark_percentile;

            } else{

                $test_progress =  ($mark_percentile - $previousAttemptPercentage);
                if($test_progress < 0 ) {
                    $test_attempts->progress = 0;
                }else{
                    $test_attempts->progress = $test_progress;
                }
            }

        }else{
            $test_attempts->progress = "Nill";
        }

        // check if it is first attempt or not

        $test_attempts->save();

        return response()->json(true, 200);

    }

    public function confirmation(){

        return view('pages.user.tests.confirmation');
    }

    public function solution(Request $request, $testId, $testresultId){

        $questionNumber = $request->question ?? 1;

        $totalTestQuestions = TestQuestion::where('test_id', $testId)
            ->get();

        $test = Test::findOrFail($testId);
        $completedTestResult = TestResult::findOrFail($testresultId);

        $tab = $request->filled('tab') ? $request->input('tab') : 'all-questions';

        $question = $request->filled('question') ? $request->input('question') : '1';

        $questionType = $tab;

        $testQuestions = TestQuestion::getFilteredTestQuestions(
            $questionType,
            $completedTestResult,

        )->get();


        if($testQuestions->count() > 0) {


            $testQuestionCount = $testQuestions->count();

            if ($questionNumber > $testQuestionCount) {

                $questionNumber = 1;
                $testQuestion = $testQuestions->get($questionNumber - 1);
                $question = $testQuestion->question;

            } else {

                $testQuestion = $testQuestions->get($questionNumber - 1);
                $question = $testQuestion->question;

            }

            $questionID = $question->id;

        }else {
            $questionID = null;
            $testQuestion = null;
        }

        $favouriteQuestions = UserFavouriteQuestion::where('user_id', Auth::user()->id)
                        ->where('test_result_id', $testresultId)
                        ->pluck('question_id')->toArray();

        $studentCorrectAnswers = StudentAnswer::where('test_id', $testId)
                            ->where('test_result_id', $testresultId)
                            ->where('is_correct', true)
                            ->pluck('question_id')->toArray();
        $studentWrongAnswers = StudentAnswer::where('test_id', $testId)
            ->where('test_result_id', $testresultId)
            ->where('is_correct', false)
            ->pluck('question_id')->toArray();

//        return $testQuestion;

        $studentQuestion =  $testQuestion;
        if($testQuestion) {
            $userFavouriteQuestion = UserFavouriteQuestion::where('user_id', Auth::id())
                ->where('test_id', $testId)
                ->where('question_id', $question->id)
                ->where('test_result_id',$testresultId)
                ->first();
        }else{
            $userFavouriteQuestion = NULL;
        }


        return view('pages.user.tests.solution', compact('test','question','tab', 'questionID', 'testQuestion','userFavouriteQuestion',
            'testresultId','favouriteQuestions','questionNumber','totalTestQuestions','studentCorrectAnswers','studentWrongAnswers','studentQuestion'));
    }

    public function solutionSaveNext(Request $request)
    {

        $questionNumber = $request->questionNumber ?? 1;

        $test = Test::findOrFail($request->testId);

        $completedTestResult = TestResult::findOrFail($request->testResultId);

        $tab = $request->filled('tab') ? $request->tab : 'all-questions';

        $question = $request->filled('question') ? $request->input('question') : '1';

        $questionType = $tab;

        $testQuestions = TestQuestion::getFilteredTestQuestions(
            $questionType,
            $completedTestResult,

        )->get();


        $favouriteQuestionCount = UserFavouriteQuestion::where('user_id', Auth::user()->id)
            ->where('test_result_id',$request->testResultId)
            ->count();


        $testQuestionCount = $testQuestions->count();

        if ($questionNumber >= $testQuestionCount) {

            $tabs =  array("0"=>"all-questions","1"=>"correct","2"=>"wrong", "3" => "unattempted", "4" => "favourite");

            $currentSectionKey =  array_search($tab, $tabs);

            if($currentSectionKey == 4  && $questionNumber >= $favouriteQuestionCount ) {

                $tab = $tabs[0];
                $questionType = $tab;
            }else {
                $tab = $tabs[ $currentSectionKey + 1 ];

                $questionType = $tab;
            }


            $testQuestions = TestQuestion::getFilteredTestQuestions(
                $questionType,
                $completedTestResult,

            )->get();

            $url = url('user/tests/'.$request->testId.'/test_result/'.$request->testResultId.'/solution').'?tab='.$tab.'&question=1';

        }
        else{

            $questionNumber = $questionNumber + 1;

            $url = url('user/tests/'.$request->testId.'/test_result/'.$request->testResultId.'/solution').'?tab='.$tab.'&question='.$questionNumber;

        }

        return response()->json($url, 200);

    }

    public function attempts(Request $request, $testId, $testresultId){

        $test = Test::FindOrFail($testId);

        if($request->package) {

            $attepmts = TestAttempt::where('user_id', Auth::id())
                ->where('test_id', $testId)
                ->where('package_id', $request->package)
                ->orderBy('id', 'asc')
                ->get();
        }else {

            $attepmts = TestAttempt::where('user_id', Auth::id())
                ->where('test_id', $testId)
                ->orderBy('id', 'asc')
                ->get();
        }

        $activePackages =  Transaction::where('user_id', Auth::user()->id)
                            ->where('package_expiry_date', '>=', Carbon::today()->format('Y-m-d'))
                            ->pluck('package_id')->toArray();


        return view('pages.user.tests.attempts', compact('attepmts','test','activePackages','testresultId'));
    }
    public function graphical_analysis(Request $request){

        $maxMark = Test::max('total_marks');

        if($request->created_at) {

            $dates = explode(' - ',$request->created_at);

            $start_date = Carbon::parse(date('Y-m-d', strtotime($dates[0])).' 00:00:00');
            $end_date = Carbon::parse(date('Y-m-d', strtotime($dates[1])).' 00:00:00');


            $testNames = TestResult::with('test')
                ->where('user_id', Auth::user()->id)
                ->whereBetween('created_at', array($start_date, $end_date))
                ->whereNotNull('ended_at')
                ->get()
                ->pluck('test.name');

            $packageNames = TestResult::with('package')
                ->where('user_id', Auth::user()->id)
                ->whereBetween('created_at', array($start_date, $end_date))
                ->whereNotNull('ended_at')
                ->get()
                ->pluck('package.name');

            $completedTestResults =  TestResult::whereNotNull('ended_at')
                ->where('user_id', Auth::user()->id)
                ->whereBetween('created_at', array($start_date, $end_date))
                ->with('test')
                ->get();

        }else {

            $testNames = TestResult::with('test')
                ->where('user_id', Auth::user()->id)
                ->whereNotNull('ended_at')
                ->orderBy('id', 'DESC')
                ->take('4')
                ->get()
                ->pluck('test.name');

            $packageNames = TestResult::with('package')
                ->where('user_id', Auth::user()->id)
                ->whereNotNull('ended_at')
                ->orderBy('id', 'DESC')
                ->take('4')
                ->get()
                ->pluck('package.name');

            $completedTestResults =  TestResult::whereNotNull('ended_at')
                ->where('user_id', Auth::user()->id)
                ->orderBy('id', 'DESC')
                ->take('4')
                ->with('test')
                ->get();
        }

//        return $completedTestResults;

        $tests = [];
        foreach ($testNames as $testName) {
            $name = Str::limit($testName, 19);
            array_push($tests, $name);
        }

        $packages = [];
        foreach ($packageNames as $packageName) {
            $name = Str::limit($packageName, 19);
            array_push($packages, $name);
        }

        $testPackages = [];

        foreach ($tests as $key => $test) {
            $item = $test . ':-' . $packages[$key];
            array_push($testPackages, $item);
        }


        $completedTestIds = $completedTestResults->pluck('test_id');

//        return $completedTestResults;

        $testQuestionCount = TestQuestion::whereIn('test_id', $completedTestIds)
            ->count();


        $total_questions = [];

        foreach ($completedTestResults as $completedTestResult) {
            $total_questions[] = $completedTestResult->test->total_questions;

        }

        $correct_answers = [];
        foreach ($completedTestResults as $completedTestResult) {
            $correct_answers[] = $completedTestResult->total_correct_answers;
        }

        $wrong_answers = [];
        foreach ($completedTestResults as $completedTestResult) {
            $wrong_answers[] = $completedTestResult->total_wrong_answers;

        }

        $attended_questions = [];
        foreach ($correct_answers as $key => $value) {
            $attended_questions[$key] = $value + ($wrong_answers[$key] ?? 0);
        }

        $unattempted_questions = [];
        foreach ($total_questions as $key => $value) {
            $unattempted_questions[$key] = $value - ($attended_questions[$key] ?? 0);
        }

        $totalCorrectAnswers = array_sum($correct_answers);
        $totalWrongAnswers = array_sum($wrong_answers);
        $totalUnattemptedQuestions = array_sum($unattempted_questions);

        if($completedTestResults->count() > 0) {


        $totalCorrectAnswersPercentage = round(($totalCorrectAnswers / $testQuestionCount) * 100);
        $totalWrongAnswersPercentage = round(($totalWrongAnswers / $testQuestionCount) * 100);
        $totalUnattemptedQuestionsPercentage = round(($totalUnattemptedQuestions / $testQuestionCount) * 100);

        }else{

            $totalCorrectAnswersPercentage = 0;
            $totalWrongAnswersPercentage = 0;
            $totalUnattemptedQuestionsPercentage = 0;

         }

        return view('pages.user.tests.graphical_analysis', compact('testPackages','completedTestResults','packages','correct_answers','wrong_answers','unattempted_questions'
                ,'totalUnattemptedQuestions','totalCorrectAnswers','totalWrongAnswers','testQuestionCount','totalCorrectAnswersPercentage','totalWrongAnswersPercentage'
            ,'totalUnattemptedQuestionsPercentage','maxMark' ));
    }

    public function testResultGraphs($testId, $testresultId) {

        $test = Test::findorFail($testId);
        $test_positive_mark = $test->correct_answer_marks;
        $test_negative_mark = $test->negative_marks;
        $total_questions = $test->total_questions;
        $testMark = $test->total_marks;

        $testResult = TestResult::findorFail($testresultId);

        ///////////////////////// Section wise ///////////////////////////

        $sections = TestSection::with('test_questions')
            ->whereHas('test_questions', function ($test_questions) use( $testId){
                $test_questions->where('test_id', $testId);
            })
            ->pluck('name');

        $sectionWiseAnswers = TestSection::with('test_questions')
                    ->whereHas('test_questions', function ($test_questions) use( $testId ){
                        $test_questions->where('test_id', $testId);
                    })
                   ->get();

        $section_wise_correct_answers = [];
        $section_wise_positive_marks = [];
        $section_wise_wrong_answers = [];
        $section_wise_negative_marks = [];
        $section_wise_correct_answer_percentages = [];
        $section_wise_wrong_answer_percentages = [];

        foreach($sectionWiseAnswers as $sectionWiseAnswer){
            $section_wise_correct_answers[] = $sectionWiseAnswer->student_answers->where('is_correct', true)
                    ->where('test_result_id', $testresultId)
                    ->count();
            $section_wise_wrong_answers[] =  $sectionWiseAnswer->student_answers->where('is_correct', false)
                    ->where('test_result_id', $testresultId)
                    ->count();
            $section_wise_positive_marks[] =  $sectionWiseAnswer->student_answers->where('is_correct', true)
                    ->where('test_result_id', $testresultId)
                    ->count() * $test_positive_mark;
            $section_wise_negative_marks[] =  $sectionWiseAnswer->student_answers->where('is_correct', false)
                     ->where('test_result_id', $testresultId)->count() * $test_negative_mark;
            $section_wise_correct_answer_percentages[] =  round((($sectionWiseAnswer->student_answers->where('is_correct', true)
                      ->where('test_result_id', $testresultId)
                      ->count())/($sectionWiseAnswer->test_questions->count())) * 100);
            $section_wise_wrong_answer_percentages[] =  round((($sectionWiseAnswer->student_answers->where('is_correct', false)
                      ->where('test_result_id', $testresultId)
                      ->count() )/($sectionWiseAnswer->test_questions->count())) * 100);

        }

        $section_wise_attended_questions = [];
        foreach($section_wise_correct_answers as $key => $value) {
            $section_wise_attended_questions[$key] = $value + ($section_wise_wrong_answers[$key] ?? 0);
        }

        $section_wise_attended_question_percentages = [];
        foreach($section_wise_correct_answer_percentages as $key => $value) {
            $section_wise_attended_question_percentages[$key] = $value + ($section_wise_wrong_answer_percentages[$key] ?? 0);

        }

        $sectionWiseTotalQuestions = TestSection::withCount('test_questions')
            ->whereHas('test_questions', function ( $test_questions ) use ( $testId ){
                $test_questions->where('test_id', $testId);
            })
            ->get();


        $section_wise_total_questions = [];
        $section_wise_total_questions_percentage = [];
        foreach($sectionWiseTotalQuestions as $sectionWiseTotalQuestion){
            $section_wise_total_questions[] =  $sectionWiseTotalQuestion->test_questions_count;
            $section_wise_total_questions_percentage[] = round (($sectionWiseTotalQuestion->test_questions_count / $sectionWiseTotalQuestion->test_questions_count)* 100);

        }

        $section_wise_unattempted_questions = [];
        foreach($section_wise_total_questions as $key => $value) {
            $section_wise_unattempted_questions[$key] = $value - ($section_wise_attended_questions[$key] ?? 0);

        }

        $section_wise_unattempted_question_percentages = [];
        foreach($section_wise_total_questions_percentage as $key => $value) {
            $section_wise_unattempted_question_percentages[$key] = $value - ($section_wise_attended_question_percentages[$key] ?? 0);

        }

        $section_wise_total_marks = [];
        foreach($section_wise_positive_marks as $key => $value) {
            $section_wise_total_marks[$key] = $value - ($section_wise_negative_marks[$key] ?? 0);
        }

        ///////////////////////// Subject wise ///////////////////////////

        $subjects = Subject::with('test_questions')
            ->whereHas('test_questions', function ($test_questions) use( $testId){
                $test_questions->where('test_id', $testId);
            })
            ->pluck('name');

//        return $subjects;

        $subjectWiseAnswers = Subject::with('test_questions')
            ->whereHas('test_questions', function ($test_questions) use( $testId ) {
                $test_questions->where('test_id', $testId);
            })
            ->get();

        $subject_wise_correct_answers = [];
        $subject_wise_wrong_answers = [];
        $subject_wise_positive_marks = [];
        $subject_wise_negative_marks = [];
        $subject_wise_correct_answer_percentages = [];
        $subject_wise_wrong_answer_percentages = [];

        foreach($subjectWiseAnswers as $subjectWiseAnswer){
            $subject_wise_correct_answers[] = $subjectWiseAnswer->student_answers->where('is_correct', true)
                ->where('test_result_id', $testresultId)
                ->count();
            $subject_wise_wrong_answers[] =  $subjectWiseAnswer->student_answers->where('is_correct', false)
                ->where('test_result_id', $testresultId)
                ->count();
            $subject_wise_positive_marks[] =  $subjectWiseAnswer->student_answers->where('is_correct', true)
                    ->where('test_result_id', $testresultId)
                    ->count() * $test_positive_mark;
            $subject_wise_negative_marks[] =  $subjectWiseAnswer->student_answers->where('is_correct', false)
                    ->where('test_result_id', $testresultId)->count() * $test_negative_mark;
            $subject_wise_correct_answer_percentages[] =  round((($subjectWiseAnswer->student_answers->where('is_correct', true)
                        ->where('test_result_id', $testresultId)
                        ->count())/($subjectWiseAnswer->test_questions->where('test_id', $testId)->count())) * 100);
            $subject_wise_wrong_answer_percentages[] =  round((($subjectWiseAnswer->student_answers->where('is_correct', false)
                        ->where('test_result_id', $testresultId)
                        ->count() )/($subjectWiseAnswer->test_questions->where('test_id', $testId)->count())) * 100);

        }

        $subject_wise_attended_questions = [];
        foreach($subject_wise_correct_answers as $key => $value) {
            $subject_wise_attended_questions[$key] = $value + ($subject_wise_wrong_answers[$key] ?? 0);
        }

        $subjectWiseTotalQuestions = Subject::whereHas('test_questions', function ($query) use ($testId) {
            $query->where('test_id', $testId);
        })->with(['test_questions' => function ($query) use ($testId) {
            $query->where('test_id', $testId);
        }])->get();

        $subject_wise_total_questions = [];
        $subject_wise_total_questions_percentage = [];
        foreach($subjectWiseTotalQuestions as $subjectWiseTotalQuestion){
            $subject_wise_total_questions[] =  $subjectWiseTotalQuestion->test_questions->count();
            $subject_wise_total_questions_percentage[] = round (($subjectWiseTotalQuestion->test_questions->count() / $subjectWiseTotalQuestion->test_questions->count())* 100);

        }

        $subject_wise_unattempted_questions = [];
        foreach($subject_wise_total_questions as $key => $value) {
            $subject_wise_unattempted_questions[$key] = $value - ($subject_wise_attended_questions[$key] ?? 0);
        }


        $subject_wise_total_marks = [];
        foreach($subject_wise_positive_marks as $key => $value) {
            $subject_wise_total_marks[$key] = $value - ($subject_wise_negative_marks[$key] ?? 0);
        }

        $subject_wise_attended_question_percentages = [];
        foreach($subject_wise_correct_answer_percentages as $key => $value) {
            $subject_wise_attended_question_percentages[$key] = $value + ($subject_wise_wrong_answer_percentages[$key] ?? 0);

        }

        $subject_wise_unattempted_question_percentages = [];
        foreach($subject_wise_total_questions_percentage as $key => $value) {
            $subject_wise_unattempted_question_percentages[$key] = $value - ($subject_wise_attended_question_percentages[$key] ?? 0);

        }

        ////////////////////////////////// Chapter Wise ////////////////////////////////////

           $chapters = Chapter::with('test_questions')
                    ->whereHas('test_questions', function ($test_questions) use( $testId){
                        $test_questions->where('test_id', $testId);
                    })
                    ->pluck('name');


           $chapterWiseAnswers = Chapter::with('test_questions')
                    ->whereHas('test_questions', function ($test_questions) use( $testId ) {
                        $test_questions->where('test_id', $testId);
                    })
                    ->get();

        $chapter_wise_correct_answers = [];
        $chapter_wise_positive_marks = [];
        $chapter_wise_wrong_answers = [];
        $chapter_wise_negative_marks = [];
        $chapter_wise_correct_answer_percentages = [];
        $chapter_wise_wrong_answer_percentages = [];

        foreach($chapterWiseAnswers as $chapterWiseAnswer){
            $chapter_wise_correct_answers[] = $chapterWiseAnswer->student_answers->where('is_correct', true)
                ->where('test_result_id', $testresultId)
                ->count();
            $chapter_wise_wrong_answers[] =  $chapterWiseAnswer->student_answers->where('is_correct', false)
                ->where('test_result_id', $testresultId)
                ->count();
            $chapter_wise_positive_marks[] =  $chapterWiseAnswer->student_answers->where('is_correct', true)
                    ->where('test_result_id', $testresultId)
                    ->count() * $test_positive_mark;
            $chapter_wise_negative_marks[] =  $chapterWiseAnswer->student_answers->where('is_correct', false)
                    ->where('test_result_id', $testresultId)->count() * $test_negative_mark;
            $chapter_wise_correct_answer_percentages[] =  round((($chapterWiseAnswer->student_answers->where('is_correct', true)
                        ->where('test_result_id', $testresultId)
                        ->count())/($chapterWiseAnswer->test_questions->where('test_id', $testId)->count())) * 100);
            $chapter_wise_wrong_answer_percentages[] =  round((($chapterWiseAnswer->student_answers->where('is_correct', false)
                        ->where('test_result_id', $testresultId)
                        ->count() )/($chapterWiseAnswer->test_questions->where('test_id', $testId)->count())) * 100);

        }

        $chapter_wise_attended_questions = [];
        foreach($chapter_wise_correct_answers as $key => $value) {
            $chapter_wise_attended_questions[$key] = $value + ($chapter_wise_wrong_answers[$key] ?? 0);
        }

        $chapterWiseTotalQuestions = Chapter::whereHas('test_questions', function ($query) use ($testId) {
                $query->where('test_id', $testId);
            })->with(['test_questions' => function ($query) use ($testId) {
                $query->where('test_id', $testId);
            }])
            ->get();


       $chapter_wise_total_questions = [];
       $chapter_wise_total_questions_percentage = [];

       foreach($chapterWiseTotalQuestions as $chapterWiseTotalQuestion){
           $chapter_wise_total_questions[] =  $chapterWiseTotalQuestion->test_questions->count();
           $chapter_wise_total_questions_percentage[] = round (($chapterWiseTotalQuestion->test_questions->count()/ $chapterWiseTotalQuestion->test_questions->count())* 100);

       }
        $chapter_wise_unattempted_questions = [];
        foreach($chapter_wise_total_questions as $key => $value) {
            $chapter_wise_unattempted_questions[$key] = $value - ($chapter_wise_attended_questions[$key] ?? 0);

        }

        $chapter_wise_attended_question_percentages = [];
        foreach($chapter_wise_correct_answer_percentages as $key => $value) {
            $chapter_wise_attended_question_percentages[$key] = $value + ($chapter_wise_wrong_answer_percentages[$key] ?? 0);

        }

        $chapter_wise_unattempted_question_percentages = [];
        foreach($chapter_wise_total_questions_percentage as $key => $value) {
            $chapter_wise_unattempted_question_percentages[$key] = $value - ($chapter_wise_attended_question_percentages[$key] ?? 0);

        }

        $chapter_wise_total_marks = [];
        foreach($chapter_wise_positive_marks as $key => $value) {
            $chapter_wise_total_marks[$key] = $value - ($chapter_wise_negative_marks[$key] ?? 0);
        }

        return view('pages.user.tests.test_result_graph', compact('testResult','sections','section_wise_correct_answers','section_wise_wrong_answers','section_wise_unattempted_questions',
             'section_wise_positive_marks','section_wise_negative_marks','section_wise_total_marks','section_wise_wrong_answer_percentages','section_wise_correct_answer_percentages'
             ,'section_wise_unattempted_question_percentages','subjects','subject_wise_correct_answers','subject_wise_wrong_answers','subject_wise_unattempted_questions','subject_wise_positive_marks',
             'subject_wise_negative_marks','subject_wise_total_marks','subject_wise_correct_answer_percentages','subject_wise_wrong_answer_percentages','subject_wise_unattempted_question_percentages',
             'chapters','chapter_wise_correct_answers','chapter_wise_wrong_answers','chapter_wise_unattempted_questions','chapter_wise_positive_marks','chapter_wise_negative_marks',
             'chapter_wise_total_marks','chapter_wise_correct_answer_percentages','chapter_wise_wrong_answer_percentages','chapter_wise_unattempted_question_percentages','testMark'
        ));

    }
}
