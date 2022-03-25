<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSegment extends Model
{
    use HasFactory;

    public function segmentCourses()
    {
        return $this->belongsToMany(UserSegment::class,'segment_courses','segment_id','course_id');
    }
    public function segmentTests()
    {
        return $this->belongsToMany(UserSegment::class,'segment_tests','segment_id','test_id');
    }
}
