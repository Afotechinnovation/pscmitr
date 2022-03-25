<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property int $user_id
 * @property int $package_id
 * @property int $order_id
 * @property float $price
 * @property float $net_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereNetTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUserId($value)
 * @mixin \Eloquent
 * @property float $gst_percentage
 * @property float $gst_amount
 * @property-read \App\Models\Package $package
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereGstAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereGstPercentage($value)
 * @property string $package_expiry_date
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction ofSearch($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePackageExpiryDate($value)
 * @property int $course_id
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCourseId($value)
 */
class Transaction extends Model
{
    use HasFactory;

    public function user() {

        return $this->belongsTo(User::class);
    }
    public function course() {

        return $this->belongsTo(Course::class);
    }

    public function package() {

        return $this->belongsTo(Package::class)->withTrashed();
    }

    public function scopeOfSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where('price', 'LIKE', '%' . $search . '%')
            ->orWhere('net_total', 'LIKE', '%' . $search . '%')
            ->orWhere('created_at', 'LIKE', '%' . $search . '%')
            ->orWhere('gst_amount', 'LIKE', '%' . $search . '%')
            ->orWhereHas('user', function( $user ) use( $search ) {
                $user->where('mobile', 'LIKE', '%'. $search .'%');
            })

            ->orWhereHas('package', function( $package ) use( $search ) {
                $package->where('name', 'LIKE', '%'. $search .'%');
        });

    }



}
