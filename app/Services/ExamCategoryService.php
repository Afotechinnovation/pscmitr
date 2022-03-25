<?php

namespace App\Services;

use App\Models\ExamCategory;

class ExamCategoryService
{
    public function store(?array $attributes): void
    {
        $exam_category = new ExamCategory();
        $exam_category->name = $attributes['name'];
        $exam_category->order = $attributes['order'];

        $exam_category->save();
    }

    public function update(ExamCategory $exam_category, ?array $attributes): void
    {
        $exam_category->name = $attributes['name'];
        $exam_category->order = $attributes['order'];

        $exam_category->save();
    }
}
