<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\Category;
use App\Models\RelatedBlog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index(Request $request)
    {
        $blog_categories = Category::with(['blogs' => function ($blogs) {
            $blogs->where('is_published', true)
                ->take(6);
            }])
            ->whereHas('blogs', function ( $blogs) {
                $blogs->where('is_published', true);
            })
            ->orderBy('name', 'asc')
            ->take(5)
            ->get();


       $first_category = $blog_categories->first()->id ?? null;

       $category = $request->input('category') ? $request->input('category') : $first_category;

       $blogs = Blog::getFilteredBlogs(
            $category,
            $request->input( 'page'),
            $request->input('limit'),
       );

       return view('pages.blogs.index', compact('blog_categories', 'blogs', 'category'));
    }

    public function show($id)
    {

        $blog = Blog::where('name_Slug', $id)->first();

        $related_blogs = RelatedBlog::with('blog')
            ->whereHas('blog', function ($blog){
                $blog->where('is_published', true);
            })
            ->where('blog_id', $blog->id)
            ->take(3)
            ->get();

        $blog_comments = BlogComment::orderBy('id', 'desc')
            ->get();

        $body = json_decode($blog['body'], true);
        $blocks = $body['blocks'];

        $blog['body'] = collect($blocks)->map(function ($block) {
            switch ($block['type']) {
                case 'header':
                    $level = $block['data']['level'] ?? 1;
                    return '<h'.$level.'>'.$block['data']['text'].'</h'.$level.'>';
                case 'paragraph':
                    return '<p>'.$block['data']['text'].'</p>';
                case 'image':
                    $classes = [
                        'border' => $block['data']['withBorder'],
                        'bg-light' => $block['data']['withBackground'],
                        'justify-content-center' => $block['data']['withBackground'],
                        'p-2' => $block['data']['withBackground'],
                    ];

                    $classes = collect($classes)->filter()->keys()->join(' ');

                    $img_Classes = [
                        'w-100' => $block['data']['stretched'],
                    ];

                    $img_Classes = collect($img_Classes)->filter()->keys()->join(' ');

                    $caption = $block['data']['caption'];

                    $html = '';

                    if ($block['data']['file']) {
                        if ($caption) {
                            $html =  '<div class="d-flex '.$classes.'"><img class="img-fluid '.$img_Classes.'" src="'.$block['data']['file']['url'].'"  alt="'.$caption.'" /></div>';
                        } else {
                            $html =  '<div class="d-flex '.$classes.'"><img class="img-fluid mb-5'.$img_Classes.'" src="'.$block['data']['file']['url'].'"  alt="'.$caption.'" /></div>';
                        }
                    }

                    if ($caption) {
                        $html .= "<small class='d-block text-center text-muted mb-5'>$caption</small>";
                    }

                    return $html;
            }
        })->join('');

        return view('pages.blogs.show', compact('blog','blog_comments', 'related_blogs'));
    }

    public function blogRatings(Request $request)
    {
        $request->validate([

            'name' => 'required|max:191',
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i',
            'comment' => 'required|max:255',
        ]);
        $blog = Blog::where('name_slug', $request->name_slug)->first();

        $blog_comment = new BlogComment();
        $blog_comment->blog_id = $blog->id;
        $blog_comment->name = $request->name;
        $blog_comment->email = $request->email;
        $blog_comment->comment = $request->comment;

        $blog_comment->save();

        return redirect()->route('blogs.show', $request->name_slug)->with('success', 'Thank you! Your comment has been successfully submitted');
    }
}
