<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamNotification extends Model
{
    use HasFactory, SoftDeletes;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

   /* public function getLastDateAttribute($value)
    {
        return  date('Y F d', strtotime($value));
    }*/

    public function getFileAttribute($file) {

        if(!$file){
            return;
        }
        return url('storage/exam_document/'.$file);
    }

    public function exam_category()
    {
        return $this->belongsTo(ExamCategory::class);
    }
    public function scopeOfPublished($query)
    {

        if(!$query->is_published){
            return $query;
        }

        return $query->where('is_published', 1);
    }

    public function scopeOfCategory($query, $categoryId)
    {
        if (! $categoryId) {
            return $query;
        }

        return $query->where('exam_category_id', $categoryId);

    }
    public function getParsedDescriptionAttribute() {

        if(!$this->body){
            return null;
        }
        $parsed_body = json_decode($this->body,true);

        if(!$parsed_body['blocks']){
            return null;
        }
        $body = $parsed_body['blocks'][0]['data']['text'];

        $limit_string =  \Illuminate\Support\Str::limit($body, 80, $end='...');

        return $limit_string;

    }

    public static function getFilteredNotifications($category = null, $page = null, $limit = null, $is_published = null)
    {
        $page = $page ?: 1;
        $limit = $limit ?: 9;

        $query =  ExamNotification::with('exam_category')
            ->ofCategory($category)
            ->where('is_published', true)
            ->orderBy('title', 'asc')
            ->paginate($limit, ['*'], 'page', $page);

        return $query;
    }

    public function relatedExamNotifications()
    {
        return $this->belongsToMany(ExamNotification::class,'related_exam_notifications','exam_notification_id','related_exam_notification_id');
    }

    public function relatedNotification()
    {
        return $this->hasMany(RelatedExamNotification::class);
    }
}
