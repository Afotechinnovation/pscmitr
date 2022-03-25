<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function store(?array $attributes): void
    {
        $category = new Category();
        $category->name = $attributes['name'];

        $category->save();
    }

    public function update(Category $category, ?array $attributes): void
    {
        $category->name = $attributes['name'];

        $category->save();
    }
}
