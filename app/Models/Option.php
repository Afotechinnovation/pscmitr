<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Option
 *
 * @property int $id
 * @property int $question_id
 * @property string|null $option
 * @property int|null $is_correct
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Option newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Option newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Option query()
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereIsCorrect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereOption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Option extends Model
{
    use HasFactory;

    public function question() {

      return $this->belongsTo(Question::class);
    }
    public function getImageAttribute($image) {

        if(!$image){
            return;
        }
        return url('storage/questions/options/image/'.$image);
    }
}
