<?php
namespace App\Admin\Http\Controllers\API;

use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Category::query();

        if (request()->filled('q')) {
            $query->ofSearch(request()->get('q'));
        }

        $categories = $query->simplePaginate();

        return response()->json(['data' => $categories]);
    }
}
