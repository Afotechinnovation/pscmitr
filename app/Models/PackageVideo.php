<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Http;


/**
 * App\Models\PackageVideo
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PackageVideo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageVideo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageVideo query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $package_id
 * @property int $category_id
 * @property int $video_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PackageVideo whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageVideo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageVideo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageVideo wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageVideo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageVideo whereVideoId($value)
 */
class PackageVideo extends Model
{
    use HasFactory;

    protected $appends = ['thumbnail','video_duration','video_cover_pic', 'video_src'];

    public function getThumbnailAttribute($thumbnail) {

        if(!$thumbnail){
            return;
        }
        return url('storage/package_video_thumbnails/'.$thumbnail);
    }

    public function getVideoCoverPicAttribute() {

        if(!($this->video && $this->video->vimeo_video_json)){
            return null;
        }

        $json_encode_response = json_decode($this->video->vimeo_video_json,true);
        return $json_encode_response['body']['embed']['html'];
    }

    public function getVideoSrcAttribute() {

        if(!($this->video && $this->video->vimeo_video_json)){
            return null;
        }

        $json_encode_response = json_decode($this->video->vimeo_video_json,true);
        $link = str_replace("videos","video",$json_encode_response['body']['uri']);

        return 'https://player.vimeo.com'. $link;

    }

    public function getVideoDurationAttribute() {

        if(!($this->video && $this->video->vimeo_video_json)){
            return null;
        }

        $json_encode_response = json_decode($this->video->vimeo_video_json,true);
        return  gmdate("H:i:s", $json_encode_response['body']['duration']);

    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function package_category()
    {
        return $this->belongsTo(PackageCategory::class,'category_id','id');
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
