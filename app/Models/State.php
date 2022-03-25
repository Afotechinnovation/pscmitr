<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    public function scopeOfCountry(Builder $query, int $countryID = null): Builder
    {
        if (! $countryID) {
            return $query;
        }

        return $query->where('country_id', $countryID);
    }

    public function scopeOfSearch(Builder $query, string $search = null): Builder
    {
        if (! $search) {
            return $query;
        }

        return $query->where('name', 'like', '%' . $search . '%');
    }
}
