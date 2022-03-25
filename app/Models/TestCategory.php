<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestCategory extends Model
{
    use HasFactory;

    public function package_tests()
    {
        return $this->hasManyThrough(
            PackageTest::class,
            Test::class,
            'category_id', // Foreign key on the environments table...
            'test_id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'id' // Local key on the environments table...
        );
    }

    public function packageTests()
    {
        return $this->belongsToMany(Package::class, 'package_tests', 'package_id');
    }

    public function tests()
    {
        return $this->hasMany(Test::class, 'category_id');
    }

}
