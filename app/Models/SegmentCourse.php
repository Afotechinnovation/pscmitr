<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegmentCourse extends Model
{
    use HasFactory;
    public function segment_course() {

        return $this->belongsTo(UserSegment::class,'course_id', 'id');
    }
}
