<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class TestQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'test_id',
        'question_id',
        'section_id',
        'subject_id',
        'chapter_id',
        'order',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function studentAnswer()
    {
        return $this->hasOne(StudentAnswer::class,'question_id', 'question_id')
                    ->where('test_id', $this->test_id)
                    ->where('user_id', Auth::id());
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function test_section()
    {
        return $this->belongsTo(TestSection::class,'section_id');
    }

    public function scopeOfQuestionType($query, $questionType,  $completedTestResult)
    {
        if($questionType == 'all-questions'){
            return $query;
        }

        $studentAnswers = StudentAnswer::where('user_id', Auth::id())
            ->where('test_result_id', $completedTestResult->id)
            ->orderBy('id', 'desc');

        if($questionType == 'correct') {
            $correctStudentAnswers = $studentAnswers->where('is_correct', true)
                ->pluck('question_id');

            if (!$correctStudentAnswers) {
                return $query;
            }

            return $query->whereIn('question_id', $correctStudentAnswers);

        }

        if($questionType == 'wrong') {
            $wrongStudentAnswers = $studentAnswers->where('is_correct', false)
                ->pluck('question_id');

            if (!$wrongStudentAnswers) {
                return $query;
            }
            return $query->whereIn('question_id', $wrongStudentAnswers);
        }

        if($questionType == 'unattempted') {

        $studentAnsweredQuestions   =  $studentAnswers->pluck('question_id');

            $unattemptedQuestions = TestQuestion::where('test_id', $completedTestResult->test_id)
                ->whereNotIn('question_id', $studentAnsweredQuestions)
                ->pluck('question_id');

           if(!$unattemptedQuestions){
               return $query;
           }
            return $query->whereIn('question_id', $unattemptedQuestions);

        }

        if($questionType == 'favourite') {

            $userFavoriteQuestions = UserFavouriteQuestion::where('user_id', Auth::id())
                ->where('test_id', $completedTestResult->test_id)
                ->where('test_result_id', $completedTestResult->id)
                ->pluck('question_id');

            if(!$userFavoriteQuestions){
                return $query;
            }
            return $query->whereIn('question_id', $userFavoriteQuestions);
        }

    }


    public static function getFilteredTestQuestions(
        $type,
        $completedTestResult

    )
    {
        $query =  TestQuestion::with('question.options')
            ->where('test_id', $completedTestResult->test_id)
            ->ofQuestionType($type , $completedTestResult);

        return $query;

    }

}
