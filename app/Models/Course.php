<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * Class Course
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime $deleted_at
 */
class Course extends Model
{
    use HasFactory, SoftDeletes;
//    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;


//    protected $appends = [
//        'package_types',
//    ];

//    public function getPackageTypesAttribute() {
//
//       $package_highlights = PackageHighlight::where('course_id', $this->id)
//           ->groupBy('highlight_id')
//           ->orderBy('highlight_id')
//           ->get();
//
//       $package_types = [];
//
//       if($package_highlights->count() > 0){
//           $package_types = Highlight::whereIn('id', $package_highlights)->get();
//       }
//
//       return $package_types;
//    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
    public function tests()
    {
        return $this->hasMany(Test::class);
    }
    // for course filter in test list page
    public function test_results()
    {
        return $this->hasMany(TestResult::class)->where('user_id', Auth::user()->id);
    }
    public function packages()
    {
        return $this->hasMany(Package::class);
    }
    public function doubts()
    {
        return $this->hasMany(UserDoubt::class, 'course_id')->whereNotNull('answer');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'transactions','course_id','user_id');
    }

    public function package_highlights()
    {
        return $this->hasMany(PackageHighlight::class);
    }

    public function scopeOfSearch(Builder $query, string $search = null): Builder
    {
        if (! $search) {
            return $query;
        }

        return $query->where('name', 'like', '%' . $search . '%');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
