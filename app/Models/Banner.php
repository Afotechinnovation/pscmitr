<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Banner
 *
 * @property int $id
 * @property string $image
 * @property string|null $title
 * @property string|null $link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $status enabled
 * @method static \Illuminate\Database\Eloquent\Builder|Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner query()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $order
 * @property int $created_by
 * @method static \Illuminate\Database\Query\Builder|Banner onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|Banner withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Banner withoutTrashed()
 */
class Banner extends Model
{
    use HasFactory, SoftDeletes;

    public const ENABLED = 1;
    public const DISABLED = 0;

    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'image' => 'string',
//        'status' => 'boolean',
    ];

    public function getImageAttribute($image) {

        if(!$image){
            return;
        }
        return url('storage/banners/'.$image);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
}
