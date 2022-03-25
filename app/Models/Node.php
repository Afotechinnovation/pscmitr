<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Node
 *
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property int $type
 * @property int $parent_id
 * @property int $model_id
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime $deleted_at
 * @property int|null $model 1 => Videos
 * @method static \Illuminate\Database\Eloquent\Builder|Node newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Node newQuery()
 * @method static \Illuminate\Database\Query\Builder|Node onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Node query()
 * @method static \Illuminate\Database\Eloquent\Builder|Node whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Node whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Node whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Node whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Node whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Node whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Node whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Node whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Node whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Node withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Node withoutTrashed()
 * @mixin \Eloquent
 */
class Node extends Model
{
    use HasFactory, SoftDeletes;

    const TYPE_FOLDER = 1;
    const TYPE_FILE = 2;

    public function video()
    {
        return $this->belongsTo(Video::class, 'model_id');
    }

    public function getFileAttribute($name) {

        if(!$name){
            return;
        }
        return url('storage/document/'.$name);
    }
}
