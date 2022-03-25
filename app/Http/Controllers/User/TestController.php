<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\MarkForReviewQuestions;
use App\Models\Package;
use App\Models\PackageTest;
use App\Models\Question;
use App\Models\TestCategory;
use App\Models\TestSection;
use App\Models\Section;
use App\Models\StudentAnswer;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestResult;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserFavouriteQuestion;
use App\Models\UserFavouriteTest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use function Composer\Autoload\includeFile;

class TestController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        $userPurchasedPackages = $user->purchased_packages;
        $purchased_package_tests = PackageTest::whereIn('package_id', $userPurchasedPackages)
            ->get();

        $favouriteTests = UserFavouriteTest::where('user_id', Auth::user()->id)->pluck('test_id')->toArray();

        ////////// Test filter  /////////////////////
        $testResultExist = TestResult::where('user_id', Auth::user()->id)
            ->get();

        if($testResultExist->count() > 0 ) {
            $courses = Course::with('test_results')
                ->whereHas('test_results')
                ->get();

            $tab = $request->filled('tab') ? $request->input('tab') : $courses->first()->name;
            $type = $request->filled('type') ? $request->input('type') : 'all';

            $currentTabCourseId = Course::where('name', $tab)->first()->id;

            $testResults = TestResult::getFilteredCourseTests(
                $currentTabCourseId,
                $type,
                $request->input('search')
            );

        }else{
            $courses = Course::all();
            $tab = $request->filled('tab') ? $request->input('tab') : $courses->first()->name;
            $currentTabCourseId = null;
            $testResults = null;
        }

        $completedTestResults =  TestResult::whereNotNull('ended_at')
            ->where('user_id', Auth::user()->id)
            ->with('test')
            ->get();

        $completedTestResultCount = count($completedTestResults);

        $activePackages =  Transaction::where('user_id', Auth::user()->id)
                            ->where('package_expiry_date', '>=', Carbon::today()->format('Y-m-d'))
                            ->pluck('package_id')->toArray();

        return view('pages.user.tests.index', compact('purchased_package_tests','activePackages','completedTestResultCount','testResults','favouriteTests','tab','courses','testResultExist'));
    }

    public function show(Request $request, $testId)
    {
        $questionNumber = $request->question ?? 1;
        $packageId = $request->package;
       // $testResultId = $request->testResultId;
        $confirmation = $request->confirmation;

        $test = Test::with('test_questions.options')->findOrFail($testId);

//        $testResult = TestResult::getTestResult( $testId, $packageId );

        $testResult = TestResult::where('test_id', $testId)
            //->where('id', $request->testresultId)
//            ->whereNull('ended_at')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'DESC')
            ->first();

        $studentAttempts = StudentAnswer::where('test_id', $testId)
           // ->where('package_id', $packageId)
            ->where('test_result_id', $testResult->id)
            ->get();

        $reviewQuestionWithoutOptions = MarkForReviewQuestions::where('test_id', $testId)
          //  ->where('package_id', $packageId)
            ->whereNull('is_true')
            ->whereNull('option_id')
            ->where('test_result_id', $testResult->id)
            ->where('user_id', Auth::user()->id)
            ->get();

        $totalMarkedForReviewQuestions = MarkForReviewQuestions::where('test_id', $testId)
            ->where('test_result_id', $testResult->id)
            ->where('user_id', Auth::user()->id)
            ->get();

//        $reviewQuestions = StudentAnswer::where('test_id', $testId)
//            ->where('is_marked_for_review', true)
//            ->where('test_result_id', $testResult->id)
//            ->where('user_id', Auth::user()->id)
//            ->get();

//        return $reviewQuestions;

        $studentAttemptsArray = $studentAttempts->where('is_marked_for_review', false)->pluck('question_id')->toArray();

        $markedForReviewArray = $reviewQuestionWithoutOptions->pluck('question_id')->toArray();

        $reviewQuestionWithOptionArray = $studentAttempts->where('is_marked_for_review', true)->pluck('question_id')->toArray();

//        return $reviewQuestionWithOptionArray;

        $totalQuestionsCount = $test->total_questions_added;

        $totalQuestionsAttended = $studentAttempts->count();

        $totalQuestionsNotAttended = $totalQuestionsCount - $studentAttempts->count();

        $totalQuestionsMarkedForReview =  $totalMarkedForReviewQuestions->count();

        if(!$testResult || $testResult->test_end_time < 1){
            return redirect()->route('user.tests.index')->with('success', 'You have attended the test!');
        }

        if(!$confirmation){
            if(!is_numeric($questionNumber)){
                return redirect()->route('packages.show', $packageId);
            }
        }

        $test_sections = TestSection::whereHas('test_questions', function ($test_questions) use ( $testId) {
            $test_questions->where('test_id',$testId);
        })
        ->get();

        $allQuestions = TestQuestion::with('question.options')
            ->where('test_id', $testId)
            ->orderBy('order')
            ->orderBy('id', 'ASC');

        $totalTestQuestions = $allQuestions->get();

        if( $test_sections->count() ) {

            $tab = $request->filled('tab') ? $request->input('tab') : $test_sections->first()->name_slug;
            $current_test_section = TestSection::where('name_slug', $tab)
                                        ->where('test_id',$testId)
                                        ->pluck('id');
            $testQuestions = $allQuestions->where('section_id', $current_test_section)->get();

            $testSection = TestSection::with('test_questions')
                ->where('test_id', $testId)
                ->where('id', $current_test_section)
                ->first();
//            $totalTestSectionQuestions = $allQuestions->where('section_id', $current_test_section)->get();

            $testSectionCount = $testSection->test_questions->count();
            //return $testSectionCount;
            $test_section_names = $test_sections->pluck('name_slug')->toArray();
            $current_section_key =  array_search($tab, $test_section_names);
            $array_count = count($test_section_names);

               if($array_count == ($current_section_key + 1)) {
                    $next_tab = $test_section_names[$current_section_key];

                } else {

                    $next_tab = $test_section_names[$current_section_key+1];
                }

                if($questionNumber > $testSectionCount)  {
                    $questionNumber = 1;
                    $testQuestion = $testQuestions->get($questionNumber-1);
                    $question = $testQuestion->question;
                    $tab = $next_tab;
                }else {
                    $testQuestion = $testQuestions->get($questionNumber-1);
                    $question = $testQuestion->question;

                    $questionNumber = $questionNumber + 1;

                }
        }
        else {

            $tab = null;
            $testSectionCount = null;
            $testQuestions = $allQuestions->get();

            if ($questionNumber > $totalQuestionsCount) {

                $questionNumber = 1;
                $testQuestion = $testQuestions->get($questionNumber - 1);
                $question = $testQuestion->question;

            } else {

                $testQuestion = $testQuestions->get($questionNumber - 1);
                $question = $testQuestion->question;
              //  return $testQuestion;

            }
        }

//        return $question;

            $studentTestAnswer = StudentAnswer::where('user_id', Auth::id())
                ->where('test_id', $testId)
//                ->where('is_marked_for_review', false)
                ->where('question_id', $question->id)
                ->where('test_result_id', $testResult->id)
                ->orderBy('id', 'desc')
                ->first();

//        if(!$studentTestAnswer) {
//
//            $studentTestAnswer = MarkForReviewQuestions::where('user_id', Auth::id())
//                ->where('test_id', $testId)
//                ->where('question_id', $question->id)
//                ->where('test_result_id', $testResult->id)
//                ->first();
//        }

            $userFavouriteQuestion = UserFavouriteQuestion::where('user_id', Auth::id())
                ->where('test_id', $testId)
                ->where('question_id', $question->id)
                ->where('test_result_id', $testResult->id)
                ->first();
            //return  $userFavouriteQuestion;

            $userFavouriteTest = UserFavouriteTest::where('user_id', Auth::id())
                ->where('test_id', $testId)
                ->where('test_result_id', $testResult->id)
                ->first();
            if(!$userFavouriteTest) {
                $userFavouriteTest = null;
            }

            $testQuestion = null;
            $subjectName = null;
            $testSubjects = null;

        return view('pages.user.tests.show', compact('test', 'testQuestion','testQuestions','testResult',
            'question', 'packageId','testSubjects', 'subjectName', 'studentTestAnswer','totalQuestionsCount', 'confirmation',
            'totalQuestionsNotAttended','studentAttemptsArray','markedForReviewArray','totalQuestionsMarkedForReview','totalQuestionsAttended','userFavouriteQuestion','userFavouriteTest',
            'tab','test_sections','questionNumber','testSectionCount','totalTestQuestions','reviewQuestionWithOptionArray'));
    }

    public function testDetails(Request $request) {

        $test = Test::where('id', $request->testId)->first();

        return response()->json($test);

    }

}
