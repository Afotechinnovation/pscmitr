<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Video
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $vimeo_video_path
 * @property string $vimeo_video_json
 * @property string $vimeo_transcode_status
 * @property string $duration
 * @property string $name
 * @property int $folder_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Video newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video query()
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereVimeoTranscodeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereVimeoVideoJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereVimeoVideoPath($value)
 * @mixin \Eloquent
 */
class Video extends Model
{
    use HasFactory, SoftDeletes;
}
