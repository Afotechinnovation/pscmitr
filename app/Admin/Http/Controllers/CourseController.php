<?php

namespace App\Admin\Http\Controllers;

use App\Http\Requests\UpdateCourseRequest;
use App\Models\Question;
use App\Models\TestQuestion;
use App\Models\TestResult;
use App\Services\CourseService;
use App\Http\Requests\StoreCourseRequest;
use App\Models\Course;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class
CourseController extends Controller
{
    var $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index(Builder $builder)
    {
        $this->authorize('viewAny', Course::class);

        if (request()->ajax()) {
            $query = Course::query();

            return DataTables::of($query)
                ->filter(function (\Illuminate\Database\Eloquent\Builder $query) {
                    if (request()->filled('filter.search')) {
                        $query->where('name', 'like', '%' . request()->input('filter.search') . '%');
                    }
                })
                ->addColumn('action', function ($course){
                    $attendedTests = TestResult::with('test')
                        ->groupBy('test_id')
                        ->pluck('test_id')->toArray();

                    $testQuestions = TestQuestion::whereIn('test_id', $attendedTests)
                        ->groupBy('question_id')
                        ->pluck('question_id')->toArray();

                   $testCourseIDs = Question::whereIn('id', $testQuestions)
                       ->groupBy('course_id')
                       ->pluck('course_id')->toArray();

                    return view('admin::pages.courses.action', compact('course','testCourseIDs'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $table = $builder->columns([
            ['name' => 'name', 'data' => 'name', 'title' => 'Name'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3']
        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        return view('admin::pages.courses.index', compact('table'));
    }

    public function create()
    {
        $this->authorize('create', Course::class);

        return view('admin::pages.courses.create');
    }

    public function store(StoreCourseRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('create', Course::class);

        $attributes = $request->validated();

        $this->courseService->store($attributes);

        return redirect()->route('admin.courses.index')->with('success', 'Course successfully created');

    }

    public function edit(Course $course)
    {
        $this->authorize('update', $course);

        return view('admin::pages.courses.edit', compact('course'));
    }

    public function update(Course $course, UpdateCourseRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('update', $course);

        $attributes = $request->validated();

        $this->courseService->update($course, $attributes);

        return redirect()->route('admin.courses.index')->with('success', 'Course successfully updated');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        $this->authorize('delete', $course);

        $course->delete();

        return response()->json(true, 200);
    }
}
