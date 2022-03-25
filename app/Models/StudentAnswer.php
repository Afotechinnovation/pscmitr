<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StudentAnswer
 *
 * @property int $id
 * @property int $user_id
 * @property int $test_id
 * @property int $group_id
 * @property int $test_question_id
 * @property int|null $option_id
 * @property string|null $descriptive_answer
 * @property int|null $is_correct
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $is_marked_for_review
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer whereDescriptiveAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer whereIsCorrect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer whereIsMarkedForReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer whereOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer whereTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer whereTestQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer whereUserId($value)
 * @mixin \Eloquent
 * @property int $question_id
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer whereQuestionId($value)
 * @property int $is_true
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer whereIsTrue($value)
 * @property int $package_id
 * @property int $test_result_id
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer whereTestResultId($value)
 * @property int $question_type 1=>Objective , 2=> TrueorFalse , 3=>Descriptive
 * @method static \Illuminate\Database\Eloquent\Builder|StudentAnswer whereQuestionType($value)
 */
class StudentAnswer extends Model
{
    use HasFactory;

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
    public function test()
    {
        return $this->belongsTo(Test::class);
    }




}
