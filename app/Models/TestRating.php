<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TestRating
 *
 * @property int $id
 * @property int $package_test_id
 * @property int $user_id
 * @property int $rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TestRating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestRating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestRating query()
 * @method static \Illuminate\Database\Eloquent\Builder|TestRating whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestRating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestRating wherePackageTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestRating whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestRating whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestRating whereUserId($value)
 * @mixin \Eloquent
 * @property int $test_result_id
 * @method static \Illuminate\Database\Eloquent\Builder|TestRating whereTestResultId($value)
 * @property int $package_id
 * @property int $test_id
 * @method static \Illuminate\Database\Eloquent\Builder|TestRating wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestRating whereTestId($value)
 */
class TestRating extends Model
{
    use HasFactory;

}
