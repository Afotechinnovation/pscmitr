<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Package
 *
 * @property int $id
 * @property int $course_id
 * @property int|null $subject_id
 * @property int|null $chapter_id
 * @property string $name
 * @property string $display_name
 * @property string|null $title
 * @property string|null $description
 * @property float $price
 * @property float|null $offer_price
 * @property string|null $package_content
 * @property string|null $requirements
 * @property string $status enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereChapterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereOfferPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePackageContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $image
 * @property-read \App\Models\Chapter|null $chapter
 * @property-read \App\Models\Course $course
 * @property-read mixed $average_package_rating
 * @property-read mixed $package_offer_percentage
 * @property-read mixed $rating_percentage
 * @property-read mixed $selling_price
 * @property-read mixed $total_package_reviews
 * @property-read mixed $total_video_duration
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PackageRating[] $package_ratings
 * @property-read int|null $package_ratings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PackageVideo[] $package_videos
 * @property-read int|null $package_videos_count
 * @property-read \App\Models\Subject|null $subject
 * @method static \Illuminate\Database\Query\Builder|Package onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|Package withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Package withoutTrashed()
 * @property string $cover_pic
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PackageCategory[] $package_categories
 * @property-read int|null $package_categories_count
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCoverPic($value)
 * @property string $visible_from_date
 * @property string $visible_to_date
 * @property int $availability
 * @property-read mixed $package_chapters_name
 * @property-read mixed $package_subjects_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Chapter[] $package_chapters
 * @property-read int|null $package_chapters_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Highlight[] $package_highlights
 * @property-read int|null $package_highlights_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PackageStudyMaterial[] $package_study_materials
 * @property-read int|null $package_study_materials_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subject[] $package_subjects
 * @property-read int|null $package_subjects_count
 * @method static \Illuminate\Database\Eloquent\Builder|Package ofCourse($courses)
 * @method static \Illuminate\Database\Eloquent\Builder|Package ofPackageType($type)
 * @method static \Illuminate\Database\Eloquent\Builder|Package ofRating($ratings)
 * @method static \Illuminate\Database\Eloquent\Builder|Package ofSearch($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Package ofType($types)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereAvailability($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereVisibleFromDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereVisibleToDate($value)
 */
class Package extends Model
{
    use HasFactory, SoftDeletes;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

    protected $appends = [
        'video_duration',
        'total_video_duration',
        'average_package_rating',
        'total_package_reviews',
        'package_offer_percentage',
        'selling_price',
        'rating_percentage',
        'package_subjects_name',
        'package_chapters_name',
        'package_visibility',
        'is_active',
        'image_url',
        'expiry_date'
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function getImageUrlAttribute() {

        if(!$this->image){
            return;
        }
        return url('storage/packages/'.$this->image);
    }

    public function getCoverPicAttribute($pic) {

        if(!$pic){
            return;
        }
        return url('storage/package_cover_pic/'. $pic);
    }

//    public function getCreatedAtAttribute($value)
//    {
//        if(!$value){
//            return '';
//        }
//        return date('d-m-Y ', strtotime($value));
//
//    }

    public function getPackageVisibilityAttribute()
    {
        if(!( $this->visible_from_date && $this->visible_to_date )){
            return '';
        }
        $from_date = date('Y F d', strtotime($this->visible_from_date));
        $to_date = date('Y F d', strtotime($this->visible_to_date));
        return $from_date. ' to '. $to_date;
    }

    public function getPackageSubjectsNameAttribute() {

        if(!$this->package_subjects){
            return [];
        }
        $subject_names = [];
        foreach ($this->package_subjects as $package_subject)
        {
            $subject_names[] = $package_subject->name;
        }
        $package_subject_names = collect($subject_names)->all();
        return implode(', ', $package_subject_names);
    }

    public function getPackageChaptersNameAttribute() {

        if(!$this->package_chapters){
            return [];
        }
        $chapter_names = [];
        foreach ($this->package_chapters as $package_chapter)
        {
            $chapter_names[] = $package_chapter->name;
        }
        $package_chapters_names = collect($chapter_names)->all();
        return implode(', ', $package_chapters_names);
    }

    public function getIsActiveAttribute(){
        if(!Auth::id()){
            return false;
        }
        $user_purchase = Transaction::where('user_id', Auth::id())
            ->where('package_id','=', $this->id)
            ->orderBy('order_id', 'DESC')
            ->first();

        if(!$user_purchase){
            return false;
        }

        return $user_purchase->package_expiry_date >= Carbon::today()->format('Y-m-d') ? true : false;
    }

    public function getExpiryDateAttribute(){
        if(!Auth::id()){
            return false;
        }
        $transaction_expiry = Transaction::where('user_id', Auth::id())
            ->where('package_id','=', $this->id)
            ->first();

        if(!$transaction_expiry) {
            return false;
        }else {

            $to = Carbon::parse($transaction_expiry->package_expiry_date)->format('Y-m-d 00:00:00');
            $from = Carbon::parse(Carbon::now())->format('Y-m-d 00:00:00');

            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $to);
            $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $from);
            if($to<$from){
                $diff_in_days = 0;
            }
            else if($to==$from){
                $diff_in_days = -1;
            }
            else{
                $diff_in_days = $to->diffInDays($from);
            }

            return $diff_in_days;
        }

    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function subject()
   {
        return $this->belongsTo(Subject::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function package_subjects()
    {
        return $this->belongsToMany(Subject::class, 'package_subjects','package_id','subject_id');
    }

    public function package_chapters()
    {
        return $this->belongsToMany(Chapter::class, 'package_chapters','package_id','chapter_id');
    }

    public function package_highlights()
    {
        return $this->belongsToMany(Highlight::class, 'package_highlights','package_id','highlight_id');
    }

    public function package_videos()
    {
        return $this->belongsToMany(Video::class,'package_videos','package_id','video_id');
    }

    public function package_categories()
    {
        return $this->hasMany(PackageCategory::class);
    }

    public function package_study_materials()
    {
        return $this->hasMany(PackageStudyMaterial::class);
    }

    public function packageDocuments()
    {
        return $this->belongsToMany(Document::class,'package_study_materials','package_id','document_id');

    }

    public function package_tests()
    {
        return $this->belongsToMany(Test::class, 'package_tests','package_id','test_id');
    }
    public function package_only_tests() {

        return $this->hasMany(PackageTest::class);

    }
    public function package_ratings()
    {
        return $this->hasMany(PackageRating::class);
    }

    public function test_results()
    {
        return $this->hasMany(TestResult::class);
    }

    public function getAveragePackageRatingAttribute()
    {
        $total_rating = $this->package_ratings()->sum('rating');
        $total_rating_count = $this->package_ratings()->count();

        if(!$total_rating_count){
            return 0;
        }

        $average_package_rating = round($total_rating/$total_rating_count);

        return $average_package_rating;
    }

    public function getTotalPackageReviewsAttribute()
    {
        return $this->package_ratings()->where('comment','!=', null)->count();


    }

    public function getPackageOfferPercentageAttribute()
    {
        $actual_price = $this->price;
        $offer_price = $this->offer_price;
        if(!$offer_price){
            return 0;
        }
        return number_format((($actual_price - $offer_price)/$actual_price)*100);
    }

    public function getSellingPriceAttribute() {

        if (! empty($this->offer_price)) {
            return $this->offer_price;
        }
        return $this->price;
    }

    public function getRatingPercentageAttribute() {

        $ratings = [];
        $total_package_ratings = $this->package_ratings()->count();

        for ($i=1;$i<=5;$i++){
            $rating_count = $this->package_ratings()->where('rating',$i)->count();
            if($total_package_ratings<1){
                $ratings[$i] = 0;
            }
            else{
                $ratings[$i] = number_format(($rating_count/$total_package_ratings)*100);
            }
        }
        return $ratings;
    }

    public function getVideoDurationAttribute() {

        $videos = $this->package_videos()->sum('duration');
        return $videos;
    }

    public function getTotalVideoDurationAttribute() {

        $durationInSeconds = $this->video_duration;
        $h = floor($durationInSeconds / 3600);
        $resetSeconds = $durationInSeconds - $h * 3600;
        $m = floor($resetSeconds / 60);
        $resetSeconds = $resetSeconds - $m * 60;
        $s = round($resetSeconds, 3);
        $h = str_pad($h, 2, '0', STR_PAD_LEFT);
        $m = str_pad($m, 2, '0', STR_PAD_LEFT);
        $s = str_pad($s, 2, '0', STR_PAD_LEFT);

        if ($h > 0) {
            $duration[] = $h;
        }

        $duration[] = $m;

        $duration[] = $s;

        return implode(':', $duration);
    }

    public function scopeOfCourse($query, $courses)
    {
        if(!$courses) {
            return $query;
        }
        return $query->with('course')
            ->whereHas('course', function ( $course ) use( $courses ){
                $course->whereIn('name', $courses);
            });
    }

    public function scopeOfType($query, $types)
    {
        if(!$types) {
            return $query;
        }
        return $query->with('package_highlights')
            ->whereHas('package_highlights', function ( $package_highlights ) use( $types ){
                $package_highlights->whereIn('highlight_id', $types);
            });
    }

    public function scopeOfPackageType($query, $type)
    {
        if(!$type) {
            return $query;
        }
        return $query->with('package_highlights')
            ->whereHas('package_highlights', function ( $package_highlights ) use( $type ){
                $package_highlights->where('highlight_id', $type);
            });
    }

    public function scopeOfRating($query, $ratings)
    {
        if(!$ratings) {
            return $query;
        }
        return $query->with('package_ratings')
            ->whereHas('package_ratings', function ( $package_ratings ) use( $ratings ){
                $package_ratings->whereIn('rating', $ratings);
            });
    }

    public function scopeOfVisible($query)
    {
        return $query->whereBetween('visible_from_date',[Carbon::today()->startOfDay(),Carbon::today()->endOfDay()])
            ->orWhereRaw('? between visible_from_date and visible_to_date', [Carbon::today()->startOfDay()])
            ->orWhereRaw('? between visible_from_date and visible_to_date', [Carbon::today()->endOfDay()]);
    }

    public function scopeOfPublished($query)
    {
        if(!$query->is_published){
            return $query;
        }

        return $query->where('is_published', 1);
    }

    public function scopeOfSearch($query, $search)
    {
        if(!$search) {
            return $query;
        }

        return $query->where('name', 'LIKE', '%'. $search .'%')
            ->orWhere('display_name', 'LIKE', '%'. $search .'%')
            ->orWhere('price', '=', $search)
            ->orWhere('offer_price', '=', $search)
            ->orWhereHas('course', function( $course ) use( $search ) {
                $course->where('name', 'LIKE', '%'. $search .'%');
            })
            ->orWhereHas('package_subjects', function( $subject ) use( $search ) {
                $subject->where('name', 'LIKE', '%'. $search .'%');
            })
            ->orWhereHas('package_chapters', function( $chapter ) use( $search ) {
                $chapter->where('name', 'LIKE', '%'. $search .'%');
            });
    }

    public static function getFilteredPackages($courses = null, $type = null, $packageType = null, $ratings = null, $search= null, $page = null, $limit = null, $is_published = null)
    {
        $page = $page ?: 1;
        $limit = $limit ?: 8;

         $query =  Package::with('course')
            ->ofCourse($courses)
            ->ofType($type)
            ->ofPackageType($packageType)
            ->ofRating($ratings)
            ->ofSearch($search)
            ->ofVisible()
            ->where('is_published', true)
            ->orderBy('display_name', 'asc')
            ->paginate($limit, ['*'], 'page', $page)->onEachSide(1);

        return $query;
    }

    public function transaction() {

        return $this->hasOne(Transaction::class);
    }

    public function transaction_expire() {

        return $this->hasOne(Transaction::class)->where('user_id', Auth::user());
    }


}
