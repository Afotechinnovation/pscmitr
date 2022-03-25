<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Test extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = [
        'total_questions_added','total_time_in_sec','is_live_now','is_today_now'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_live_test' => 'boolean',
        'is_today_test' => 'boolean'
    ];


    public function livetest()
    {
        return $this->belongsTo(LiveTest::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function test_questions()
    {
        return $this->belongsToMany(Question::class, 'test_questions','test_id','question_id');
    }

    public function test_results()
    {
        return $this->hasMany(TestResult::class);
    }
    public function test_result()
    {
        return $this->belongsTo(TestResult::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class)->withTrashed();
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_tests')->withTrashed();
    }

    public function category()
    {
        return $this->belongsTo(TestCategory::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function test_sections()
    {
        return $this->hasMany(TestSection::class);
    }


    public function getImageAttribute($image) {

        if(!$image){
            return;
        }
        return url('storage/test_image/'.$image);
    }

    public function getTotalQuestionsAddedAttribute() {

        if(!$this->test_questions){
            return 0;
        }

        return $this->test_questions()->count();
    }

    public function getTotalTimeInSecAttribute() {

        $str_time = $this->total_time;

        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

        $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;

        return $time_seconds;
    }


    public function getIsTodayNowAttribute() {

        $date = Carbon::today()->toDateString();

        $is_today_test = $this->is_today_test;
        $today_test_date  = $this->today_test_date;

        if( $date == $today_test_date && $is_today_test == true) {
            return true;

        }else {

            return false;
        }

    }
    public function getIsLiveNowAttribute() {

        $now = Carbon::now();

        $date = Carbon::today()->toDateString();
        $is_live_test = $this->is_live_test;

        $live_test_duration  = $this->live_test_duration;

        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $live_test_duration);

        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

        $live_test_time_seconds = $hours * 3600 + $minutes * 60 + $seconds;

        $start_time = Carbon::parse($this->live_test_date_time);
        $start_date = $start_time->toDateString();

        $live_test_end_time = Carbon::parse($start_time)
            ->addSeconds($live_test_time_seconds)
            ->format('H:i:s');

        if( $date == $start_date && $is_live_test == true) {

            if( $now->between($start_time, $live_test_end_time, true )) {
                return true;

            }else {
                return false;
            }
        }else {

            return false;
        }

    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'test_results','test_id','user_id');
    }

    public  function test_ratings() {

        return $this->hasMany(TestRating::class);
    }
}
