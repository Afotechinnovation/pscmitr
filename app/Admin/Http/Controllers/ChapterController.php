<?php

namespace App\Admin\Http\Controllers;


use App\Models\TestQuestion;
use App\Models\TestResult;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Chapter;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class ChapterController extends Controller
{

    public function index(Builder $builder)
    {
        $this->authorize('viewAny', Chapter::class);

        if (request()->ajax()) {
            $query = Chapter::with('course', 'subject');

            return DataTables::of($query)
                ->filter(function (\Illuminate\Database\Eloquent\Builder $query) {
                    if (request()->filled('filter.search')) {
                        $query->where('name', 'like', '%' . request()->input('filter.search') . '%');
                        $query->orWhereHas('course', function( $course)  {
                            $course->where('name', 'like', '%'. request('filter.search') . '%');
                        });
                        $query->orWhereHas('subject', function( $subject)  {
                            $subject->where('name', 'like', '%'. request('filter.search') . '%');
                        });
                    }

                })
                ->editColumn('course_id', function ($chapter) {
                    return $chapter->course->name;
                })
                ->editColumn('created_at', function ($test) {
                    return Carbon::parse($test->created_at)->format('d M Y');
                })
                ->addColumn('time', function ($test) {
                    return Carbon::parse($test->created_at)->toTimeString();
                })
                ->addColumn('action', function ($chapter){

                    $attendedTests = TestResult::with('test')
                        ->groupBy('test_id')
                        ->pluck('test_id')->toArray();

                    $testChapterIDs = TestQuestion::whereIn('test_id', $attendedTests)
                        ->groupBy('chapter_id')
                        ->pluck('chapter_id')->toArray();

                    return view('admin::pages.chapters.action', compact('chapter','testChapterIDs'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $table = $builder->columns([
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'course_id', 'name' => 'course_id', 'title' => 'Course'],
            ['data' => 'subject.name', 'name' => 'subject.name', 'title' => 'Subject'],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created Date'],
            ['name' => 'time', 'data' => 'time', 'title' => 'Created Time'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3']
        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        return view('admin::pages.chapters.index', compact('table'));
    }

    public function create()
    {
        $this->authorize('create', Chapter::class);

        $chapters = Chapter::all();

        return view('admin::pages.chapters.create');
    }

    public function store(Request $request,Chapter  $chapter): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('create', Chapter::class);

        $request->validate([
            'name' => 'required',
            'course_id' => 'required',
            'subject_id' => 'required',

        ]);

        $chapter->name = $request->input('name');
        $chapter->course_id = $request->input('course_id');
        $chapter->subject_id = $request->input('subject_id');

        $chapter->save();

        return redirect()->route('admin.chapters.index')->with('success', 'Chapter successfully created');
    }

    public function edit($id)
    {
        $chapter = Chapter::findOrFail($id);

        $this->authorize('update', $chapter);

        return view('admin::pages.chapters.edit', compact('chapter'));
    }

    public function update(Request $request, $id)
    {

        $chapter = Chapter::findOrFail($id);

        $this->authorize('update', $chapter);

        $request->validate([
            'name' => 'required',
            'course_id' => 'required',
            'subject_id' => 'required',

        ]);

        $chapter->name = $request->input('name');
        $chapter->course_id = $request->input('course_id');
        $chapter->subject_id = $request->input('subject_id');

        $chapter->update();

        return redirect()->route('admin.chapters.index')->with('success', 'Chapter successfully updated');
    }

    public function destroy($id)
    {
        $chapter = Chapter::findOrFail($id);

        $this->authorize('delete', $chapter);

        $chapter->delete();

        return response()->json(true, 200);
    }
}
