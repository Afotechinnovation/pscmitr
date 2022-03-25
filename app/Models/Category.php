<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

    public function blogs() {

        return $this->hasMany(Blog::class);
    }

    public function blogCategories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {

        return $this->hasMany(BlogCategory::class);
    }

    public function scopeOfSearch(Builder $query, string $search = null): Builder
    {
        if (! $search) {
            return $query;
        }

        return $query->where('name', 'like', '%' . $search . '%');
    }
}
