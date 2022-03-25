<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\TestResult
 *
 * @property int $id
 * @property int $user_id
 * @property int $test_id
 * @property int|null $attempt
 * @property string|null $started_at
 * @property string|null $ended_at
 * @property int|null $total_marks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TestResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|TestResult whereAttempt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestResult whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestResult whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestResult whereTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestResult whereTotalMarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestResult whereUserId($value)
 * @mixin \Eloquent
 * @property int $package_id
 * @method static \Illuminate\Database\Eloquent\Builder|TestResult wherePackageId($value)
 * @property float|null $total_correct_answers
 * @property float|null $total_wrong_answers
 * @property-read mixed $test_end_time
 * @method static \Illuminate\Database\Eloquent\Builder|TestResult whereTotalCorrectAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestResult whereTotalWrongAnswers($value)
 */
class TestResult extends Model
{
    use HasFactory;

    protected $appends = [
        'test_end_time',
        'test_duration'
    ];

    public function getTestEndTimeAttribute() {

        $test = Test::findOrFail($this->test_id);

        $testStarted = Carbon::parse($this->started_at);

        $testEndsAt = $testStarted->addSeconds($test->total_time_in_sec);

        $totalTimeLeft = strtotime($testEndsAt) - strtotime(Carbon::now()) ;

        return $totalTimeLeft;
    }

    public function getRanking(){

//        $collection = collect(TestResult::orderBy('total_marks', 'DESC')->orderBy('')->get());
//        $data       = $collection->where('id', $this->id);
//        $value      = $data->keys()->first() + 1;
//        return $value;
    }

    public function getTestDurationAttribute() {

        $testStarted = Carbon::parse($this->started_at);

        $testEndTime = Carbon::parse($this->ended_at);

        $totalDuration = strtotime($testEndTime) - strtotime($testStarted) ;

        return round(($totalDuration/60),2);
    }

    public static function getTestResult($testId, $packageId)
    {

        $query =  TestResult::where('test_id', $testId)
            //->where('package_id', $packageId)
//            ->whereNull('ended_at')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'DESC')
            ->first();

        return $query;
    }

    public static function getCompletedTestResult($testId, $packageId)
    {
        $query =  TestResult::where('test_id', $testId)
            ->where('package_id', $packageId)
//            ->whereNotNull('ended_at')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'DESC')
            ->first();

        return $query;
    }


    public function scopeOfPackage($query, $packages)
    {
        if(!$packages) {
            return $query;
        }
        return $query->with('package')
            ->whereHas('package', function ( $package ) use( $packages ){
                $package->whereIn('name', $packages);
            });
    }


    public function test() {
        return $this->belongsTo(Test::class);
    }
    public function package() {
        return $this->belongsTo(Package::class)->withTrashed();
    }
    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function test_ratings() {
        return $this->hasMany(TestRating::class);
    }
    public function student_answers() {

        return $this->hasMany(StudentAnswer::class);
    }

    public function scopeOfSearch($query, $search)
    {
        if(!$search) {
            return $query;
        }

        return $query->where('attempt', 'LIKE', '%'. $search .'%')
            ->orwhere('total_marks', 'LIKE', '%'. $search. '%' )
            ->orWhereHas('course', function( $course ) use( $search ) {
                $course->where('name', 'LIKE', '%'. $search .'%');
            })
            ->orWhereHas('package', function( $package ) use( $search ) {
                $package->where('name', 'LIKE', '%'. $search .'%');
            })
            ->orWhereHas('test', function( $test ) use( $search ) {
                $test->where('display_name', 'LIKE', '%'. $search .'%');
                $test->orwhere('name', 'LIKE', '%'. $search .'%');
            })
            ->orWhereHas('user', function( $user ) use( $search ) {
                $user->where('name', 'LIKE', '%'. $search .'%');
                $user->orwhere('mobile', 'LIKE', '%'. $search .'%');
                $user->orwhere('email', 'LIKE', '%'. $search .'%');
            });
    }



    public function scopeOfType($query, $type)
    {
        if($type == 'all'){
            return $query;
        }
        if($type == 'completed'){
            return $query->whereNotNull('ended_at');
        }
        if($type == 'ongoing'){
            return $query->whereNull('ended_at');
        }
        if($type == 'favourite'){
            $userFavouriteTests = UserFavouriteTest::where('user_id', Auth::user()->id)->pluck('test_id')->toArray();
            return $query->whereIn('test_id', $userFavouriteTests);
        }
    }

    public static function getFilteredCourseTests(
        $currentTabCourseId,
        $type,
        $search

    ) {

        $query = TestResult::where('user_id', Auth::user()->id)
            ->where('course_id', $currentTabCourseId)
            ->ofType($type)
            ->ofSearch($search)
            ->get();

        return $query;
    }



}
