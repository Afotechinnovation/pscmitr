<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    public function getAbsolutePathAttribute(): string
    {
        return Storage::disk('public')->path('documents/' . $this->path);
    }
}
