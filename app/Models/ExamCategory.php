<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ExamCategory extends Model
{
    use HasFactory, SoftDeletes;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

    public function exam_notifications()
    {
        return $this->hasMany(ExamNotification::class);
    }

    public function exam_applications()
    {
        return $this->hasMany(ExamNotification::class);
    }

    public function scopeOfSearch(Builder $query, string $search = null): Builder
    {
        if (! $search) {
            return $query;
        }

        return $query->where('name', 'like', '%' . $search . '%');
    }
}
