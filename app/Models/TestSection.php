<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TestSection extends Model
{
    use HasFactory;

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function test_questions()
    {
        return $this->hasMany(TestQuestion::class,'section_id');
    }

    public function student_answers()
    {
        return $this->hasMany(StudentAnswer::class,'section_id', 'id');
    }

    public static function getFilteredTestSections(
        $testId,
        $current_test_section,
        $page = null,
        $limit = null
    )
    {
        $page = $page ? : 1;
        $limit = $limit ? : 1;

        $query =  TestQuestion::where('section_id', $current_test_section)
                    ->where('test_id', $testId);
//                    ->paginate($limit, ['*'], 'page', $page);
                     return $query;


    }
}
