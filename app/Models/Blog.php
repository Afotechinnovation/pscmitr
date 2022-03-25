<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Blog
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $author
 * @property int $category_id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $image
 * @property string $cover_pic
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BlogCategory[] $blogCategories
 * @property-read int|null $blog_categories_count
 * @property-read \App\Models\Category $category
 * @property-read mixed $parsed_description
 * @method static Builder|Blog newModelQuery()
 * @method static Builder|Blog newQuery()
 * @method static Builder|Blog ofCategory(?int $categoryID = null)
 * @method static Builder|Blog ofSearch(?string $search = null)
 * @method static \Illuminate\Database\Query\Builder|Blog onlyTrashed()
 * @method static Builder|Blog query()
 * @method static Builder|Blog whereAuthor($value)
 * @method static Builder|Blog whereBody($value)
 * @method static Builder|Blog whereCategoryId($value)
 * @method static Builder|Blog whereCoverPic($value)
 * @method static Builder|Blog whereCreatedAt($value)
 * @method static Builder|Blog whereDeletedAt($value)
 * @method static Builder|Blog whereId($value)
 * @method static Builder|Blog whereImage($value)
 * @method static Builder|Blog whereTitle($value)
 * @method static Builder|Blog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Blog withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Blog withoutTrashed()
 * @mixin \Eloquent
 */
class Blog extends Model
{
    use HasFactory, softDeletes;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

    const BLOG_TYPE_ARTICLE = 'article';
    const BLOG_TYPE_VIDEO  = 'video';

     static $blogTypes = [
         'article' => 'ARTICLE',
         'video' => 'VIDEO'
     ];


    protected $appends = [
        'parsed_description','thumbnail','video_src'
    ];
    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function getAuthorAttribute($author) {

        if(!$author){
            return;
        }
        return ucfirst($author);
    }

    public function getImageAttribute($image) {

        if(!$image){
            return;
        }
        return url('storage/blog_image/'.$image);
    }

    public function getCoverPicAttribute($image) {

        if(!$image){
            return;
        }
        return url('storage/blog_cover_pic/'.$image);
    }

    public function getThumbnailAttribute($thumbnail) {

        if(!$thumbnail){
            return;
        }
        return url('storage/videos/'.$thumbnail);
    }

    public function getVideoSrcAttribute() {

        if(!($this->video && $this->video->vimeo_video_json)){
            return null;
        }

        $json_encode_response = json_decode($this->video->vimeo_video_json,true);
        $link = str_replace("videos","video",$json_encode_response['body']['uri']);

        return 'https://player.vimeo.com'. $link ;

    }


//    public function getCreatedAtAttribute($value)
//    {
//        if(!$value){
//            return '';
//        }
//        return date('Y F d', strtotime($value));
//
//    }

    public function getParsedDescriptionAttribute() {

      if(!$this->body){
          return null;
        }
       $parsed_body = json_decode($this->body,true);

      if(!$parsed_body['blocks']){
          return null;
      }

       $body = $parsed_body['blocks'][0]['data']['text'] ?? null;

       $limit_string =  \Illuminate\Support\Str::limit($body, 30, $end='...');

       return $limit_string;

    }

    public function category() {

        return $this->belongsTo(Category::class);
    }

    public function blogCategories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BlogCategory::class);
    }
    public function relatedBlogs()
    {
        return $this->belongsToMany(Blog::class,'related_blogs','blog_id','related_blog_id');
    }

    public function relatedArticles()
    {
        return $this->hasMany(RelatedBlog::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function scopeOfCategory($query, $categoryId)
    {
        if (! $categoryId) {
            return $query;
        }

        return $query->where('category_id', $categoryId);
    }
    public function scopeOfPublished($query)
    {

        if(!$query->is_published){
            return $query;
        }

        return $query->where('is_published', 1);
    }

    public function scopeOfSearch(Builder $query, string $search = null): Builder
    {
        if (! $search) {
            return $query;
        }

        return $query->where('title', 'like', '%' . $search . '%');
    }

    public static function getFilteredBlogs($categoryId = null, $page = null, $limit = null, $is_published = null)
    {
        $page = $page ?: 1;
        $limit = $limit ?: 9;

        $query =  Blog::with('category')
            ->ofCategory($categoryId)
            ->where('is_published', true)
            ->orderBy('title', 'asc')
            ->paginate($limit, ['*'], 'page', $page);

        return $query;
    }
}
