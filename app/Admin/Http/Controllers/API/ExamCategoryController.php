<?php

namespace App\Admin\Http\Controllers\API;

use App\Models\ExamCategory;

class ExamCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        $query = ExamCategory::query();

        if (request()->filled('q')) {
            $query->ofSearch(request()->get('q'));
        }

        $exam_categories = $query->simplePaginate();

        return response()->json(['data' => $exam_categories]);
    }
}
