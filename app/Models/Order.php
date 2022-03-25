<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $user_id
 * @property int $transaction_id
 * @property float $price
 * @property float $net_total
 * @property string $status
 * @property string|null $transaction_response
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNetTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTransactionResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @mixin \Eloquent
 * @property int $package_id
 * @property string|null $razorpay_payment_id
 * @property string|null $razorpay_signature
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRazorpayPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRazorpaySignature($value)
 * @property float $gst_percentage
 * @property float $gst_amount
 * @property string|null $razorpay_order_id
 * @property-read \App\Models\Package $package
 * @property-read \App\Models\PackageRating $package_ratings
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereGstAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereGstPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRazorpayOrderId($value)
 */
class Order extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'PENDING';
    const STATUS_SUCCESS = 'SUCCESS';
    const STATUS_FAILED = 'FAILED';

    public function package_ratings()
    {
        return $this->belongsTo(PackageRating::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
