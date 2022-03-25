<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory, SoftDeletes;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function test_questions()
    {
        return $this->hasMany(TestQuestion::class, 'subject_id');
    }
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
    public function doubts()
    {
        return $this->hasMany(UserDoubt::class, 'subject_id')->whereNotNull('answer');
    }

    public function package()
    {
        return $this->belongsToMany(Package::class, 'package_subjects','package_id','subject_id');
    }

    public function student_answers()
    {
        return $this->hasMany(StudentAnswer::class,'subject_id', 'id');
    }

    public function scopeOfCourse(Builder $query, int $courseID = null): Builder
    {
        if (! $courseID) {
            return $query;
        }

        return $query->where('course_id', $courseID);
    }

    public function scopeOfSearch(Builder $query, string $search = null): Builder
    {
        if (! $search) {
            return $query;
        }

        return $query->where('name', 'like', '%' . $search . '%');
    }

}
