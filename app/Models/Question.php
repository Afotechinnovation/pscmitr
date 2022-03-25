<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property int $type
 * @property string $question
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Question extends Model
{
    use HasFactory, SoftDeletes;

    static $questionTypes = [
        1 => ['name' => 'Objective', 'value' => 1],
        2 => ['name' => 'True or False', 'value' => 2],
       // 3 => ['name' => 'Descriptive', 'value' => 3],
    ];

    const QUESTION_TYPE_OBJECTIVE = 1;
    const QUESTION_TYPE_TRUE_OR_FALSE = 2;
    const QUESTION_TYPE_DESCRIPTIVE = 3;


    public static $difficultyLevels = [
        1 => ['name' => 'Easy', 'value' => 'Easy'],
        2 => ['name' => 'Normal', 'value' => 'Normal'],
        3 => ['name' => 'Difficult', 'value' => 'Difficult'],
    ];

    protected $appends = [
        'total_times_used',
        'last_used_date',
    ];

//    public function getImageAttribute($image) {
//
//        if(!$image){
//            return;
//        }
//        return url('storage/questions/image/'.$image);
//    }


    public function options()
    {
        return $this->hasMany(Option::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class,'last_updated_by');
    }
    public function admin_created_by()
    {
        return $this->belongsTo(Admin::class,'created_by');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function user_doubts()
    {
        return $this->hasMany(UserDoubt::class);
    }

    public function test_questions() {

        return $this->hasMany(TestQuestion::class,'question_id');
    }

//    public function getQuestionSectionsNameAttribute() {
//
//        if(!$this->test_questions){
//            return [];
//        }
//
//        $section_names = [];
//        foreach ($this->test_questions as $test_question) {
//            $section_names[] = $test_question->test_section->name;
//            info($section_names);
//        }
//
//
////        $test_question_section_names = collect($section_names)->all();
////        info($section_names);
////        return implode(', ',  $test_question_section_names);
//
//    }
    public function getTotalTimesUsedAttribute() {

        $total_times_used = TestQuestion::where('question_id', $this->id)->count();

        if(!$total_times_used){
            return 0;
        }
        return $total_times_used;

    }

//    public function scopeOfSearch($query, $search)
//    {
//
//        if(!$search) {
//            return $query;
//        }
//
//        return $query->where('question', 'LIKE', '%'. $search .'%')
//
//            ->orWhereHas('options', function( $options ) use( $search ) {
//                $options->where('option', 'LIKE', '%'. $search .'%');
//            });
//
//    }

    public function getLastUsedDateAttribute() {

        $last_used_test_question = TestQuestion::where('question_id', $this->id)
            ->orderBy('id','desc')
            ->first();

        if(!$last_used_test_question){
            return '';
        }
        return Carbon::parse($last_used_test_question->created_at)->format('d M Y');

    }



}
