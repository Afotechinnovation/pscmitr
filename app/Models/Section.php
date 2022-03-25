<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function test_questions()
    {
        return $this->hasMany(TestQuestion::class);
    }

    public function student_answers()
    {
        return $this->hasManyThrough(
            StudentAnswer::class,
            Question::class,
            'section_id', // Foreign key on the questions table...
            'question_id', // Foreign key on the student_answers table...
            'id', // Local key on the section table...
            'id' // Local key on the question table...
        );
    }
    public function student_correct_answers()
    {
        return $this->hasManyThrough(
            StudentAnswer::class,
            Question::class,
            'section_id', // Foreign key on the questions table...
            'question_id', // Foreign key on the student_answers table...
            'id', // Local key on the section table...
            'id' // Local key on the question table...
        )->where('is_correct', true);
    }
    public function student_wrong_answers()
    {
        return $this->hasManyThrough(
            StudentAnswer::class,
            Question::class,
            'section_id', // Foreign key on the questions table...
            'question_id', // Foreign key on the student_answers table...
            'id', // Local key on the section table...
            'id' // Local key on the question table...
        )->where('is_correct', false);
    }
}
