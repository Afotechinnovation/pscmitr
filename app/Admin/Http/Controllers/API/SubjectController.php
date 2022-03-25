<?php
namespace App\Admin\Http\Controllers\API;

use App\Models\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $query = Subject::query();

        if (request()->filled('course_id')) {
            $query->ofCourse(request()->get('course_id'));
        }

        if (request()->filled('q')) {
            $query->ofSearch(request()->get('q'));
        }

        $subjects = $query->with("course")
            ->simplePaginate();
        info($subjects);

        return response()->json(['data' => $subjects]);
    }
}

