<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MarkForReviewQuestions;
use App\Models\Option;
use App\Models\Question;
use App\Models\StudentAnswer;
use App\Models\TestQuestion;
use App\Models\TestResult;
use App\Models\TestSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestAnswerController extends Controller
{

    public function store(Request $request)
    {

        $testId =  $request->test_id;
//        $packageId = $request->package_id;

        $isMarkedForReview = $request->is_marked_for_review;

        // to get without package id
        $testResult = TestResult::where('test_id', $request->test_id)
            ->where('user_id', Auth::user()->id)
            ->orderBy('id','DESC')
            ->first();

       $testResultId = $testResult->id;

        $test_sections = TestSection::whereHas('test_questions', function ($test_questions) use ( $testId ) {
            $test_questions->where('test_id',$testId);
        })->get();

        $allQuestions = TestQuestion::with('question.options')
            ->where('test_id', $testId)
            ->orderBy('order')
            ->orderBy('section_id', 'ASC');

        $totalTestQuestions = $allQuestions->get();

        $questionNumber = $request->question ?? 1;

        if( $test_sections->count() < 1) {
            $tab = null;
            $totalTestQuestionCount = $totalTestQuestions->count();

            if ($questionNumber >= $totalTestQuestionCount) {
                $url = route('user.tests.show',$testId).'?test_result='.$testResultId.'&confirmation=true';
            }
            else{

                $questionNumber = $questionNumber + 1;
               // $url = route('user.tests.show',$testId).'?test_result='.$testResultId.'&question='.$questionNumber;
                $url = route('user.tests.show',$testId).'?test_result='.$testResultId.'&question='.$questionNumber;

            }

        }
        else {
            $tab = $request->filled('tab') ? $request->input('tab') : $test_sections->first()->name_slug;

            $currentSectionId = TestSection::where('name_slug', $tab)
                ->where('test_id',$testId)
                ->pluck('id');

            $testSection = TestSection::with('test_questions')
                ->where('id', $currentSectionId)
                ->first();

            $testSectionQuestionCount = $testSection->test_questions->count();

            $testSectionNames = $test_sections->pluck('name_slug')->toArray();
            $currentSectionKey =  array_search($tab, $testSectionNames);
            $array_count = count($testSectionNames);

            if($array_count == ($currentSectionKey + 1)) {

                $next_tab = $testSectionNames[ $currentSectionKey ];
                $last_section_id = TestSection::where('name_slug', $next_tab)
                    ->first();
                $lastSectionQuestionCount  = TestQuestion::with('test_section')
                ->where('section_id', $last_section_id->id )
                ->count();
               if($questionNumber == $lastSectionQuestionCount) {
                   $next_tab = $testSectionNames[0];
               }

            } else {
                $next_tab = $testSectionNames[ $currentSectionKey+1 ];
            }

            if($questionNumber >= $testSectionQuestionCount)  {
                $questionNumber = 1;
                $tab = $next_tab;
            }else {
                $questionNumber = $questionNumber + 1;
            }

            $url = route('user.tests.show',$testId).'?test_result='.$testResultId.'&question='.$questionNumber.'&tab='.$tab;
        }

        //User can skip the question So when no option selected return to next question
        if(!( $request->option_radio || $request->test_description)){
            return redirect($url);
        }

        $question = Question::findOrFail($request->question_id);

        /*When user starts the test, data is saved to test results table with start time, test_id, package_id, user_id
        and when that current test ends the end time and total marks are saved to the test_results table */

//        $testResult = TestResult::getTestResult( $request->test_id, $request->package_id );

        //Option details are fetched to check whether user answer is correct or not
        if( $question->type == Question::QUESTION_TYPE_OBJECTIVE ) {
            $option = Option::findOrFail($request->option_radio);
        }
        elseif( $question->type == Question::QUESTION_TYPE_TRUE_OR_FALSE ){
            $option = $question->options->first();
        }

        $previousTestAnswers = StudentAnswer::where('test_id', $request->test_id)
            ->where('user_id', Auth::id())
           // ->where('package_id', $request->package_id)
            ->where('test_result_id','!=', $testResult->id)
            ->pluck('id');


        StudentAnswer::whereIn('id', $previousTestAnswers)->delete();

        //Fetch the student answer for corresponding question
        $studentAnswer = StudentAnswer::where('test_id', $request->test_id)
           ->where('question_id', $request->question_id)
           ->where('test_result_id', $testResult->id)
           ->where('user_id', Auth::id())
           ->first();

        //If user has answered update the user answer when user changes the option otherwise save as new answer
        if(!$studentAnswer){
            $studentAnswer = new StudentAnswer();
        }

        $studentAnswer->user_id =  Auth::id();
        $studentAnswer->test_id = $request->test_id;
        $studentAnswer->package_id = $testResult->package_id ?? null;
        $studentAnswer->test_result_id = $testResult->id;
        $studentAnswer->question_id = $request->question_id;
        $studentAnswer->question_type = $question->type;
        $studentAnswer->subject_id = $question->subject_id;
        $studentAnswer->chapter_id = $question->chapter_id;

        if( $test_sections->count() < 1) {
            $studentAnswer->section_id = null;

        }else{

            $tab = $request->filled('tab') ? $request->input('tab') : $test_sections->first()->name_slug;
            $currentSectionId = TestSection::where('name_slug', $tab)
                ->where('test_id',$testId)
                ->first();

           $studentAnswer->section_id = $currentSectionId->id;
        }

       if($question->type == Question::QUESTION_TYPE_OBJECTIVE ){

           $studentAnswer->option_id = $request->option_radio;

           $studentAnswer->is_correct = $option->is_correct ? true : false;

       }
       elseif( $question->type == Question::QUESTION_TYPE_TRUE_OR_FALSE ){

           $is_true = $request->option_radio == 'true' ? true : false;
           $studentAnswer->is_true = $is_true;
           $studentAnswer->is_correct = ($is_true == $option->is_correct) ? true : false;
       }
       else{
           $studentAnswer->descriptive_answer = $request->test_description;
       }
//
//        if($isMarkedForReview == 1) {
//           $studentAnswer->is_marked_for_review = true;
//       }else if($isMarkedForReview == 2 ){
//
//            $studentAnswer->is_marked_for_review = false;
//        }

        $studentAnswer->save();
       return redirect($url);

    }

    public function clearResponse(Request $request){

       // $testResult = TestResult::getTestResult( $request->testId, $request->packageId );

        $studentAnswer = StudentAnswer::where('test_id', $request->testId)
            ->where('question_id', $request->questionId)
            ->where('user_id', Auth::id())
            ->where('test_result_id', $request->testResultId)
            ->first();


        /* Check whether user has answered that particular question and delete it from student answer */
        if($studentAnswer){
           $studentAnswer->delete();
        }

        return response()->json(true, 200);

    }

    public function markForReview(Request $request)
    {

        $question = Question::findOrFail($request->question_id);

        $testResult = TestResult::findOrFail($request->test_result_id);

        $tab = $request->tab;

        if($tab) {
            $currentSection = TestSection::where('name', $tab)
                ->where('test_id',  $request->test_id)
                ->first();

        }

        $studentAnswer = StudentAnswer::where('test_result_id', $request->test_result_id)
                        ->where('question_id', $request->question_id)
                        ->where('user_id', Auth::id())
                        ->where('test_id', $request->test_id)
                        ->first();

        if(!$studentAnswer) {
            $studentAnswer = new StudentAnswer();
        }

        $markedForReview = MarkForReviewQuestions::where('question_id', $request->question_id)
            ->where('test_result_id', $request->test_result_id)
            ->where('test_id', $request->test_id)
            ->where('user_id', Auth::id())
            ->first();

        if(!$markedForReview) {
            $markedForReview = new MarkForReviewQuestions();
        }

        $markedForReview->user_id =  Auth::id();
        $markedForReview->test_id = $request->test_id;
        $markedForReview->package_id = $testResult->package_id ?? null;
        $markedForReview->question_id = $request->question_id;
        $markedForReview->test_result_id = $request->test_result_id;


        if($question->type == Question::QUESTION_TYPE_OBJECTIVE ){

            $markedForReview->option_id = $request->option_radio ?? null;

            $studentAnswer->option_id = $request->option_radio;

            if($request->option_radio) {

                $option = Option::findOrFail($request->option_radio);
                $studentAnswer->is_correct = $option->is_correct ? true : false;

            }

            //  $studentAnswer->is_correct = $option->is_correct ? true : false;

        }
        else{
            // if user not select an option store is_true as null in mark for review table

          if($request->option_radio == 'true') {
              $markedForReview->is_true = true;

          }else if($request->option_radio == 'false') {

              $markedForReview->is_true = false;

          }else{
              $markedForReview->is_true = null;
          }

        $is_true = $request->option_radio == 'true' ? true : false;
        $studentAnswer->is_true = $is_true;

        if($request->option_radio) {

            $option = $question->options->first();
            $studentAnswer->is_correct = ($is_true == $option->is_correct) ? true : false;

        }

           // $studentAnswer->is_correct = ($is_true == $option->is_correct) ? true : false;

        }

        $markedForReview->save();

        if($request->option_radio) {

            $studentAnswer->user_id =  Auth::id();
            $studentAnswer->test_id = $request->test_id;
            $studentAnswer->package_id = $testResult->package_id ?? null;
            $studentAnswer->test_result_id = $request->test_result_id;
            $studentAnswer->question_id = $request->question_id;
            $studentAnswer->section_id = $currentSection->id ?? null;
            $studentAnswer->question_type = $question->type;
            $studentAnswer->subject_id = $question->subject_id;
            $studentAnswer->chapter_id = $question->chapter_id;
            $studentAnswer->is_marked_for_review = true;

            $studentAnswer->save();

        }



        return response()->json(true, 200);


    }

}
