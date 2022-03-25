<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'test_id',
        'order',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class,'test_id','id');
    }

    public function todays_tests()
    {
        $current_time = Carbon::now()->format('H:i:s');

        return $this->hasMany(Test::class, 'category_id')->whereDate('date_time', Carbon::today())
            ->where('is_live_test_end_time', '>=', $current_time)
            ->where('is_live_test_start_time', '<=', $current_time);

    }
}
