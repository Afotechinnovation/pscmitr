<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedExamNotification extends Model
{
    use HasFactory;

    public function exam_notification() {

        return $this->belongsTo(ExamNotification::class,'related_exam_notification_id', 'id');
    }
}
