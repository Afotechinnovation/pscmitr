<?php

namespace App\Admin\Http\Controllers;

use App\Models\PackageTest;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestCategory;
use App\Models\TestQuestion;
use App\Models\TestResult;
use App\Models\TestSection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\True_;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class TestController extends Controller
{
    public function index(Builder $builder)
    {

        $this->authorize('viewAny', Test::class);
        if (request()->ajax()) {

            $tests = Test::query()->with('course','subject','chapter')
               ->orderBy('id','desc');

            return DataTables::of($tests)
               ->filter(function (\Illuminate\Database\Eloquent\Builder $tests) {
                    if (request()->filled('filter.search')) {
                        $tests->where('name', 'like', '%' . request()->input('filter.search') . '%')
                              ->orWhere('total_questions', '=', request()->input('filter.search'))
                              ->orWhere('total_time', '=', request()->input('filter.search'))
                              ->orWhere('total_marks', '=', request()->input('filter.search'))
                              ->orWhere('correct_answer_marks', '=', request()->input('filter.search'))
                              ->orWhere('negative_marks', '=', request()->input('filter.search'));
                    }
                    if(request()->filled('filter.course') ) {
                        $tests->WhereHas('course', function( $course)  {
                            $course->where('id','=', request('filter.course'));
                        });
                    }
                })
                ->editColumn('category_id', function ( $test ) {
                    if( !$test->category){
                        return '';
                    }
                    return $test->category->name;

                })
                ->editColumn('course_id', function ( $test ) {
                    if( !$test->course){
                        return '';
                    }
                    return $test->course->name;
                })
                ->editColumn('created_by', function ($test) {
                    if(!$test->admin) {
                        return '';
                    }
                    return $test->admin->name;
                })
                ->editColumn('image', function ( $test ) {
                    return '<div><img width="50" height="50" src="'.$test->image.'"></div>';
                })
                ->editColumn('is_published', function ( $test ) {
                    if( $test->is_published ){

                        return '<span class="badge badge-info">published</span>';

                    }
                    return '<span class="badge badge-warning">Unpublished</span>';
                })
                ->editColumn('is_live_test', function ( $test ) {
                    if( $test->is_live_test == 1){
                        return '<span class="badge badge-success">live test</span>';
                    }
                    return '';
                })
                ->editColumn('total_questions', function ( $test ) {
                   return $test->total_questions_added .'/'. $test->total_questions;
                })
                ->editColumn('created_at', function ($test) {
                    return Carbon::parse($test->created_at)->format('d M Y');
                })
                ->addColumn('time', function ($test) {
                    return Carbon::parse($test->created_at)->toTimeString();
                })
                ->addColumn('action', function ( $test ){

                    $isUserAttemptedTest = TestResult::with('test')
                        ->groupBy('test_id')
                        ->pluck('test_id')->toArray();

                    return view('admin::pages.tests.action', compact('test','isUserAttemptedTest'));
                })
                ->rawColumns(['action','image','is_published','is_live_test','today_test_date','time'])
                ->make(true);
        }

        $tableTests = $builder->columns([
            ['name' => 'name', 'data' => 'name', 'title' => 'Name'],
            ['name' => 'display_name', 'data' => 'display_name', 'title' => 'Display Name'],
            ['name' => 'category_id', 'data' => 'category_id', 'title' => 'Category'],
            ['name' => 'course_id', 'data' => 'course_id', 'title' => 'Course'],
            ['name' => 'total_questions', 'data' => 'total_questions', 'title' => ' Questions'],
            ['name' => 'created_by', 'data' => 'created_by', 'title' => 'Created By'],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created Date'],
            ['name' => 'time', 'data' => 'time', 'title' => 'Created Time'],
            ['name' => 'is_published', 'data' => 'is_published', 'title' => 'Is Published'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3', 'ordering' => false]
        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        return view('admin::pages.tests.index', compact('tableTests'));
    }

    public function create()
    {
        $this->authorize('create', Test::class);

        $testCategories = TestCategory::all();

        return view('admin::pages.tests.create', compact('testCategories'));
    }

    public function store(Request $request)
    {

//        return $request->all();

        $this->authorize('create', Test::class);

        $this->validate($request, [
            'course_id'           => 'required',
            'category'            => 'required',
            'name'                => 'required|max:191',
            'total_questions'     => 'required|numeric',
            'total_marks'         => 'required|numeric|min:1',
            'total_time'          => 'required',
            'correct_answer_marks'=> 'required|numeric',
            'negative_marks'      => 'required|numeric',
            'description'         => 'required|max:350',
            'image'               => 'required',
            'display_name'        => 'required|max:100',
        ]);

        $test = new Test();
        $test->name                 = $request->name;
        $test->name_slug            = Str::of($request->name)->slug('-');
        $test->course_id            = $request->course_id;
        $test->category_id          = $request->category;
        $test->total_questions      = $request->total_questions;
        $test->total_marks          = $request->total_marks;
        $test->total_time           = $request->total_time;
        $test->correct_answer_marks = $request->correct_answer_marks;
        $test->negative_marks       = $request->negative_marks;
        $test->description          = $request->description;
        $test->display_name         = $request->display_name;
        $test->cut_off_marks        = $request->cut_off_marks;
        $test->today_test_date      = $request->today_test_date;
        $test->created_by           = Auth::user()->id;
        $test->is_today_test        = $request->is_today_test;
        $test->live_test_date_time  = $request->live_test_date_time;
        $test->live_test_duration   = $request->live_test_duration;
        $test->is_live_test         = $request->is_live_test;


        if($request->image){
            $data = $request->image;
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name= Carbon::now()->timestamp. rand(1,9999) .'.png';

            Storage::disk('public')->put("test_image/$image_name", $data);
            $test->image = $image_name;
        }

        $test->save();

        return redirect()->route('admin.tests.index')->with('success', 'Test successfully created');
    }

    public function show(Builder $builder, $testId)
    {
        $test = Test::findOrFail($testId);

        if($test->test_sections->count()){
            foreach ($test->test_sections as $data)
            {
                $section[] = $data->name;
            }

            $sections = collect($section)->all();
            $newSection = implode(', ', $sections);
        }else {
            $newSection = '';
        }

        $this->authorize('view', $test);

        $tableQuestions = $builder->columns([
            ['name' => 'question.question', 'data' => 'question.question',  'title' => 'Question'],
            ['name' => 'question.type', 'data' => 'question.type', 'title' => 'Type'],
            ['data' => 'order', 'name' => 'order', 'title' => 'Order'],
            ['name' => 'course_id', 'data' => 'course_id', 'title' => 'Course'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3'],
            ['name' => 'delete', 'data' => 'delete', 'title' => '', 'class' => 'text-right p-3'],
        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ])->ajax(route('admin.tests.questions.index', $testId))
          ->setTableId('table-test-questions');

        // test sections

        $tableTestSections = app(Builder::class)->columns([
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
//          ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3','searchable' => false, 'orderable' => false]
        ])->addAction(
            ['title' => '', 'class' => 'text-right p-3', 'width' => 70]
        )->parameters([
            'searching' => true,
            'ordering' => false,
            'lengthChange' => true,
            'bInfo' => false
        ])->ajax(route('admin.tests.sections.index', $testId))
            ->setTableId('table-test-sections')
            ->orderBy(0, 'desc');


        $selectedQuestionIDs = [];
        foreach($test->test_questions as $question){
            $selectedQuestionIDs[] = $question->pivot->question_id;
        }

        $isUserAttemptedTest = TestResult::with('test')
            ->groupBy('test_id')
            ->pluck('test_id')->toArray();

        return view('admin::pages.tests.show', compact('test', 'newSection', 'tableQuestions', 'selectedQuestionIDs','tableTestSections',
            'isUserAttemptedTest'));
    }

    public function edit($id)
    {
        $test = Test::findOrFail($id);

        $this->authorize('update', $test);

        $testCategories = TestCategory::all();

        $selectedQuestionIDs = [];
        foreach($test->test_questions as $question){
            $selectedQuestionIDs[] = $question->pivot->question_id;
        }


        return view('admin::pages.tests.edit', compact('test', 'selectedQuestionIDs', 'testCategories'));
    }

    public function update(Request $request, $id)
    {
        $test = Test::findOrFail($id);
//        return  $request->all();

        $this->authorize('update', $test);

        $this->validate($request, [
            'name' => 'required|max:191',
            'category' => 'required',
            'total_questions' => 'required',
            'total_marks' => 'required',
            'total_time' => 'required',
            'correct_answer_marks' => 'required',
            'negative_marks' => 'required',
            'course_id' => 'required',
            'description' => 'required|max:350',
            'display_name' => 'required|max:100',
        ]);

        $test->name             = $request->name;
        $test->name_slug        = Str::of($request->name)->slug('-');
        $test->category_id      = $request->category;
        $test->course_id        = $request->course_id;
        $test->total_questions  = $request->total_questions;
        $test->total_marks      = $request->total_marks;
        $test->total_time       = $request->total_time;
        $test->correct_answer_marks = $request->correct_answer_marks;
        $test->negative_marks   = $request->negative_marks;
        $test->description      = $request->description;
        $test->display_name     = $request->display_name;
        $test->cut_off_marks    = $request->cut_off_marks;
        $test->today_test_date  = $request->today_test_date;
        $test->is_today_test    = $request->is_today_test ? true: false;
        $test->live_test_date_time  = $request->live_test_date_time;
        $test->live_test_duration   = $request->live_test_duration;
        $test->is_live_test         = $request->is_live_test ? true: false;

        $test->created_by = Auth::user()->id;
        if ($test->total_questions_added == $request->total_questions) {
            $test->is_published = true;
        } else {
            $test->is_published = false;
        }

        if ($request->image) {
            $data = $request->image;
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $image_name = Carbon::now()->timestamp . rand(1, 9999) . '.png';

            Storage::disk('public')->put("test_image/$image_name", $data);
            $test->image = $image_name;
        }

        $test->update();

        return redirect()->route('admin.tests.index')->with('success', 'Test successfully updated');

    }

    public function destroy($id)
    {
        $test = Test::findOrFail($id);

        $this->authorize('delete', $test);

        DB::beginTransaction();

        $package_test = PackageTest::with('test')
        ->whereHas('test')
        ->get();

        if($package_test) {
            PackageTest::where('test_id', $id)->delete();
        }

        $test->delete();

        DB::commit();

        return response()->json(true, 200);
    }

    public function showOptions(Request $request) {

        $question = Question::with('options')
            ->whereHas('options')
            ->where('id',$request->id)
            ->first();

        return response()->json($question);

    }

    public function publish(Request $request, $testId) {

        $test = Test::findOrFail($testId);

        $this->authorize('update', $test);

        $total_questions =  $test->total_questions;

        $assigned_test_questions = TestQuestion::with('test')
            ->whereHas('test')
            ->where('test_id',$testId)->count();

        $publish = $request->publish;

        if( $publish == 1) {
            if($total_questions == $assigned_test_questions ) {
                $test->is_published = $publish;
                $test->save();
                return response()->json($test, 200);
            }
        }else {

            $test->is_published = $request->publish;
            $test->save();
            return response()->json($test, 200);
        }

    }

    public function todayTest(Request $request, $testId) {

       $test = Test::findOrFail($request->testId);

       $test->today_test_date = $request->today_test_date;
       $test->is_today_test = $request->is_today_test ? true: false;
       $test->save();

       return redirect()->route('admin.tests.index')->with('success', 'Test successfully Added to Today Tests.');

    }
    public function liveTest(Request $request, $testId) {

        $test = Test::findOrFail($request->testId);

        $test->live_test_duration = $request->live_test_duration;
        $test->live_test_date_time = $request->live_test_date_time;
        $test->is_live_test = $request->is_live_test ? true: false;
        $test->save();

        return redirect()->route('admin.tests.index')->with('success', 'Test successfully Added to Live Tests.');

    }
}

