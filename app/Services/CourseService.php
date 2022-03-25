<?php

namespace App\Services;

use App\Models\Course;

class CourseService
{
    public function store(?array $attributes): void
    {
        $course = new Course();
        $course->name = $attributes['name'];
        $course->save();
    }

    public function update(Course $course, ?array $attributes): void
    {
        $course->name = $attributes['name'];
        $course->save();
    }
}
