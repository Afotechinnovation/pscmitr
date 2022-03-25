<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use HasFactory, softDeletes;

    public function scopeOfSearch(Builder $query, string $search = null): Builder
    {
        if (! $search) {
            return $query;
        }

        return $query->where('name', 'like', '%' . $search . '%');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function test_questions()
    {
        return $this->hasMany(TestQuestion::class, 'chapter_id');
    }
    public function student_answers()
    {
        return $this->hasMany(StudentAnswer::class,'chapter_id', 'id');
    }
}
