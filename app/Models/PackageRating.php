<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PackageRating
 *
 * @property int $id
 * @property int $package_id
 * @property int $user_id
 * @property int $rating
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|PackageRating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageRating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageRating query()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageRating whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageRating whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageRating whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageRating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageRating wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageRating whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageRating whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageRating whereUserId($value)
 * @mixin \Eloquent
 * @property-read mixed $use_image
 * @property-read mixed $user_name
 * @property-read \App\Models\Package $package
 * @property-read \App\Models\Student $student
 */
class PackageRating extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = [
        'user_name',
    ];

    public function getCreatedAtAttribute($value)
    {
        $date =  date('Y F d', strtotime($value));
        $time =  date('H:i A', strtotime($value));

        return $date.' at '.$time;
    }

    public function getUserNameAttribute()
    {
        if(!$this->user->name){
            $number = $this->user->mobile;

            return substr($number, 0, 3) . '*****' . substr($number, -2);
        }

        return $this->user->name;
    }

    public function getUseImageAttribute()
    {
        if(!$this->user->name){
            $number = $this->user->mobile;

            return substr($number, 0, 3) . '*****' . substr($number, -2);
        }

        return $this->user->name;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id');
    }

}
