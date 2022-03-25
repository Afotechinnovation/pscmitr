<?php

namespace App\Services;

use App\Models\Blog;

class BlogService
{
    public function store(?array $attributes): void
    {
        $blog = new Blog();
        $blog->title = $attributes['title'];
        $blog->category_id = $attributes['category_id'];
        $blog->body = $attributes['body'];

       

        $blog->save();
    }

    public function update(Blog $blog, ?array $attributes): void
    {
        $blog->title = $attributes['title'];
        $blog->category_id = $attributes['category_id'];
        $blog->body = $attributes['body'];

        $blog->save();
    }
}
