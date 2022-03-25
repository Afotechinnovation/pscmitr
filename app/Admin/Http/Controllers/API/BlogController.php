<?php
namespace App\Admin\Http\Controllers\API;

use App\Models\Blog;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $query = Blog::query();

        if (request()->filled('category_id')) {
            $query->ofCategory(request()->get('category_id'));
        }

        if (request()->filled('q')) {
            $query->ofSearch(request()->get('q'));
        }

        $blogs = $query->simplePaginate();

        return response()->json(['data' => $blogs]);
    }
}

