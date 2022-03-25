<?php

namespace App\Services;

use App\Models\Subject;


class SubjectService
{
    public function store(?array $attributes): void
    {
        $subject = new Subject();
        $subject->name = $attributes['name'];
        $subject->course_id = $attributes['course_id'];
        $subject->save();
    }

    public function update(Subject $subject, ?array $attributes): void
    {
        $subject->name = $attributes['name'];
        $subject->course_id = $attributes['course_id'];
        $subject->save();
    }
}
