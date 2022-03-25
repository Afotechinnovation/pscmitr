<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Testimonial
 *
 * @property int $id
 * @property string $name
 * @property string $designation
 * @property string $image
 * @property int $rating
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $parsed_description
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial ofSearch($search)
 * @method static \Illuminate\Database\Query\Builder|Testimonial onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial query()
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Testimonial withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Testimonial withoutTrashed()
 * @mixin \Eloquent
 */
class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    public function getNameAttribute($name) {

        if(!$name){
            return;
        }
        return ucfirst($name);
    }

    public function getDesignationAttribute($designation) {

        if(!$designation){
            return;
        }
        return ucwords($designation);
    }


    public function getImageAttribute($image) {

        if(!$image){
            return;
        }
        return url('storage/testimonials/'.$image);
    }

//    public function getParsedDescriptionAttribute() {
//
//        if(!$this->body){
//            return null;
//        }
//        $parsed_body = json_decode($this->body,true);
//
//        if(!$parsed_body['blocks']){
//            return null;
//        }
//        $body = $parsed_body['blocks'][0]['data']['text'];
//
//        $limit_string =  \Illuminate\Support\Str::limit($body, 200, $end='...');
//
//        return $limit_string;
//
//    }
    public function scopeOfSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('designation', 'LIKE', '%' . $search . '%')
            ->orWhere('rating', 'LIKE', '%' . $search . '%');

    }

}
