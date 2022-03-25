<?php

namespace App\Admin\Http\Controllers;

use App\Models\TestQuestion;
use App\Models\TestResult;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Course;
use App\Services\SubjectService;
use App\Http\Requests\StoreSubjectRequest;

use App\Models\Subject;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class SubjectController extends Controller
{
    var $subjectService;

    public function __construct(SubjectService $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    public function index(Builder $builder)
    {
        $this->authorize('viewAny', Subject::class);

        if (request()->ajax()) {
            $query = Subject::query()->with('course');
            return DataTables::of($query)
                ->filter(function (\Illuminate\Database\Eloquent\Builder $query) {
                    if (request()->filled('filter.search')) {
                        $query->where('name', 'like', '%' . request()->input('filter.search') . '%');
                        $query->orWhereHas('course', function( $course)  {
                            $course->where('name', 'like', '%'. request('filter.search') . '%');
                        });
                    }

                })
                ->editColumn('course_id', function ($subject) {
                    return $subject->course->name;
                })
                ->addColumn('action', function ($subject){

                    $attendedTests = TestResult::with('test')
                        ->groupBy('test_id')
                        ->pluck('test_id')->toArray();

                    $testSubjectIDs = TestQuestion::whereIn('test_id', $attendedTests)
                        ->groupBy('subject_id')
                        ->pluck('subject_id')->toArray();

                    return view('admin::pages.subjects.action', compact('subject','testSubjectIDs'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $table = $builder->columns([
            ['name' => 'name', 'data' => 'name', 'title' => 'Name'],
            ['name' => 'course_id', 'data' => 'course_id', 'title' => 'Course'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3']
        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        return view('admin::pages.subjects.index', compact('table'));
    }

    public function create()
    {
        $this->authorize('create', Subject::class);

        return view('admin::pages.subjects.create');
    }

    public function store(StoreSubjectRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('create', Subject::class);

        $attributes = $request->validated();

        $this->subjectService->store($attributes);

        return redirect()->route('admin.subjects.index')->with('success', 'Subject successfully created');
    }

    public function edit(Subject $subject)
    {
        $this->authorize('update', $subject);

        return view('admin::pages.subjects.edit', compact('subject'));
    }

    public function update(Subject $subject, UpdateSubjectRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('update', $subject);

        $attributes = $request->validated();

        $this->subjectService->update($subject, $attributes);

        return redirect()->route('admin.subjects.index')->with('success', 'Subject successfully updated');
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);

        $this->authorize('delete', $subject);

        $subject->delete();

        return response()->json(true, 200);
    }
}
