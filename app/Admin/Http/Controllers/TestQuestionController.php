<?php

namespace App\Admin\Http\Controllers;

use App\Models\PackageTest;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestResult;
use App\Models\TestSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use function Symfony\Component\Translation\t;

class TestQuestionController extends Controller
{

    public function index(Builder $builder, $testId)
    {
        if (request()->ajax()) {

            $test_questions = TestQuestion::with('question')
                ->where('test_id', $testId)
                ->get();

            return DataTables::of( $test_questions )
                ->filter(function ( $test_questions ) {
                    if (request()->filled('filter.search')) {
                        $test_questions->whereHas('question', function ( $question ){
                            $question->where('question', 'like', '%' . request()->input('filter.search') . '%');
                        });
                    }
                    if(request()->filled('filter.type') && request('filter.type') != 'all') {
                        $test_questions->whereHas('question', function ( $question ){
                            $question->where('type','=', request('filter.type'));
                        });
                    }
                    if(request()->filled('filter.course') && request('filter.course') != 'all') {
                        $test_questions->whereHas('question', function ( $question ){
                            $question->whereHas('course', function( $course)  {
                                $course->where('id','=', request('filter.course'));
                            });
                        });
                    }
                    if(request()->filled('filter.subject') ) {
                        $test_questions->whereHas('question', function ( $question ){
                            $question->whereHas('subject', function( $subject)  {
                                $subject->where('id','=', request('filter.subject'));
                            });
                        });
                    }
                    if(request()->filled('filter.chapter') ) {
                        $test_questions->whereHas('question', function ( $question ){
                            $question->whereHas('chapter', function( $chapter)  {
                                $chapter->where('id','=', request('filter.chapter'));
                            });
                        });
                    }
                })
                ->editColumn('question.type', function ( $test_questions ) {
                    if( !$test_questions->question){
                        return '';
                    }
                    if( $test_questions->question->type == 1 ){
                        return 'Objective';
                    }
                    elseif( $test_questions->question->type == 2 ){
                        return 'True or False';
                    }
                    else{
                        return 'Descriptive';
                    }
                })
                ->addColumn('question.question', function ( $test_questions ) {

                    return view('admin::pages.tests.test_questions.question', compact('test_questions'));
                })
                ->editColumn('course_id', function ( $test_questions ) {
                    if( !$test_questions->question->course){
                        return '';
                    }
                    return $test_questions->question->course->name;
                })
                ->editColumn('subject_id', function ( $test_questions) {
                    if( !$test_questions->question->subject){
                        return '';
                    }
                    return $test_questions->question->subject->name;
                })
                ->editColumn('chapter_id', function ( $test_questions) {
                    if( !$test_questions->question->chapter){
                        return '';
                    }
                    return $test_questions->question->chapter->name;
                })
                ->editColumn('chapter_id', function ( $test_questions) {
                    if( !$test_questions->question->chapter){
                        return '';
                    }
                    return $test_questions->question->chapter->name;
                })
                ->editColumn('order', function( $test_questions ) {
                    return '<div class="order">' . $test_questions->order . '<input type="hidden" class="test-question-id" value="' . $test_questions->id . '"></div>';
                })
                ->addColumn('action', function ( $test_questions ) {
                    $question = $test_questions->question;
                    return view('admin::pages.tests.options.action', compact('question'));
                })
                ->addColumn('delete', function ( $test_questions ) {
                    if( !$test_questions){
                        return '';
                    }
                    $attendedTests = TestResult::with('test')
                        ->groupBy('test_id')
                        ->pluck('test_id')->toArray();

                    $testQuestionIDs = TestQuestion::whereIn('test_id', $attendedTests)
                        ->pluck('id')->toArray();

                    return view('admin::pages.tests.test_questions.action', compact('test_questions', 'testQuestionIDs'));
                })

//                ->addColumn('question', function ( $test_questions ) {
//                    $question = $test_questions->question;
//
//                    return view('admin::pages.tests.test_questions.question', compact('question'));
//                })
                ->rawColumns(['action', 'order','delete','question.question'])
                ->make(true);
        }

    }

    public function create(Builder $builder, $id)
    {

        $this->authorize('create', TestQuestion::class);

        $test = Test::findOrFail($id);

        if (request()->ajax()) {

            $questions = Question::query()->with('course','subject','chapter','test_questions.test_section');

            return DataTables::of($questions)
                ->filter(function (\Illuminate\Database\Eloquent\Builder $questions) {
                    if (request()->filled('filter.search')) {
                        $questions->where('question', 'like', '%' . request()->input('filter.search') . '%');
                    }
//                    if(request()->filled('filter.type') && request('filter.type') != 'all') {
//                        $questions->where('type','=', request('filter.type'));
//                    }
                    if(request()->filled('filter.course') && request('filter.course') != 'all') {
                        $questions->orWhereHas('course', function( $course)  {
                            $course->where('id','=', request('filter.course'));
                        });
                    }
                    if(request()->filled('filter.subject') ) {
                        $questions->WhereHas('subject', function( $subject)  {
                            $subject->where('id','=', request('filter.subject'));
                        });
                    }
                    if(request()->filled('filter.chapter') ) {
                        $questions->WhereHas('chapter', function( $chapter)  {
                            $chapter->where('id','=', request('filter.chapter'));
                        });
                    }
                })
                ->editColumn('type', function ($question) {
                    if( $question->type == 1 ){
                        return 'Objective';
                    }
                    elseif( $question->type == 2 ){
                        return 'True or False';
                    }
                    else{
                        return 'Descriptive';
                    }
                })
                ->editColumn('course_id', function ( $question ) {
                    if( !$question->course ){
                        return '';
                    }
                    return $question->course->name;
                })
                ->editColumn('subject_id', function ( $question ) {
                    if( !$question->subject ){
                        return '';
                    }
                    return $question->subject->name;
                })
                ->editColumn('chapter_id', function ( $question ) {
                    if( !$question->chapter ){
                        return '';
                    }
                    return $question->chapter->name;
                })
                ->addColumn('section_id', function ( $question ) use ($id){
                    if($question->test_questions) {
                            $section = [];
                            foreach ($question->test_questions as $data) {
                                if ($data->test_id == $id) {
                                    if ($data->test_section) {
                                        $section[] = $data->test_section->name;
                                    }
                                }
                            }
                            $sections = collect($section)->all();
                            $section_names = implode(', ', $sections);
                            return '<span class="badge badge-success">' . $section_names . '</span>';

                        }
                    return '';
                })
//
                ->setRowClass(function ($question ) use( $id ){
                    if($question->test_questions) {
                        foreach ($question->test_questions as $test_question) {
                            if ($test_question->test_id == $id) {
                                return 'bg-info';
                            }
                        }
                    }
                })
                ->addColumn('action', function ( $question ) {
                    return view('admin::pages.tests.options.action', compact('question'));
                })

                ->rawColumns(['select','action','section_id','question'])
                ->make(true);
        }

        $checkbox = '<input class="select-all" name="select_all" type="checkbox">';

        $tableQuestions = $builder->columns([
            ['name' => 'question', 'data' => 'question', 'title' => 'Question'],
            ['name' => 'type', 'data' => 'type', 'title' => 'Type'],
            ['name' => 'course_id', 'data' => 'course_id', 'title' => 'Course'],
            ['name' => 'subject_id', 'data' => 'subject_id', 'title' => 'Subject'],
            ['name' => 'section_id', 'data' => 'section_id', 'title' => 'Section'],
            ['name' => 'chapter_id', 'data' => 'chapter_id', 'title' => 'Chapter'],
            ['name' => 'total_times_used', 'data' => 'total_times_used', 'title' => 'Total Times Used'],
            ['name' => 'last_used_date', 'data' => 'last_used_date', 'title' => 'Last Used Date'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3'],
            ['name' => 'select','data' => 'id', 'title' => $checkbox,
                'render' => ' renderCheckbox(data)', 'searchable' => false, 'orderable' => false, 'width' => '50px' ],
        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        $selectedQuestionIDs = [];

        foreach($test->test_questions as $question){
            $selectedQuestionIDs[] = $question->pivot->question_id;
        }

        $testSections = TestSection::where('test_id', $id)
                    ->get();

        $testQuestionSections = TestQuestion::where('test_id', $id)
                            ->whereNotNull('section_id')
                        ->get();
        $testQuestions = TestQuestion::where('test_id', $id)
                        ->get();

        return view('admin::pages.tests.questions.create', compact('tableQuestions','test', 'selectedQuestionIDs','testSections','testQuestionSections','testQuestions'));
    }

    public function store(Request $request, $package_id)
    {

    }

    public function show($id)
    {
        $package_test =  Test::findOrFail($id);

        $this->authorize('view', $package_test);

        $test_questions = TestQuestion::with('test','question.options')
            ->whereHas('test', function ($test) use($id) {
                $test->where('test_id', $id);
            })->get();

        return view('admin::pages.packages.tests.show', compact('package_test','test_questions'));
    }

    public function edit($package_id, $id)
    {

    }

    public function update(Request $request, $testId)
    {
        $test = Test::findOrFail($testId);

        $totalSelectedQuestions = $request->selected_questions ? count($request->selected_questions) : 0;
      //  $totalRemovedQuestions  = $request->removed_questions ? count($request->removed_questions) : 0;

        $testQuestionAssignedCount = TestQuestion::where('test_id', $testId)
        ->count();

        $totalQuestions = $totalSelectedQuestions + $testQuestionAssignedCount;

        if( $totalQuestions > $test->total_questions){
            return redirect()->route('admin.tests.questions.create', $testId)->with('error', 'You can only add Maximum '. $test->total_questions. ' Questions!You are Exceeding the limit');
        }

        DB::beginTransaction();
        if($request->selected_questions){
            foreach ($request->selected_questions as $test_question) {
                $question = Question::findOrFail($test_question);

                $subject_id = $question->subject_id;
                $chapter_id = $question->chapter_id;

                $test_question = TestQuestion::updateOrCreate( ['test_id' => $testId, 'question_id' => $test_question, 'section_id' => $request->test_section_id,
                    'subject_id' => $subject_id, 'chapter_id' => $chapter_id] );
                $test_question->save();
            }
        }

        if($request->removed_questions) {
            $removed_questions = $request->removed_questions;
          //  $test->test_questions()->detach( $removed_questions );
            TestQuestion::whereIn('question_id',$removed_questions)->delete();
        }
        DB::commit();

        return redirect()->route('admin.tests.questions.create', $testId)->with('success', 'Test questions successfully updated');
    }

    public function testQuestiondestroy($id)
    {
        $test_question = TestQuestion::findOrFail($id);

        $test_question->delete();
//        $total_qusetions =   $test_question->total_questions;
//


        return response()->json(true, 200);
    }

    public function changeOrder(){

        $testQuestionIDs = request()->input('test_questions');

        if ($testQuestionIDs) {
            $index = 1;

            foreach ($testQuestionIDs as $testQuestionID) {
                $testQuestion = TestQuestion::find($testQuestionID);

                if ($testQuestion) {
                    $testQuestion->order = $index;
                    $testQuestion->save();
                }

                $index++;
            }
        }

        return response()->json(true, 200);
    }

    public function showOptions(Request $request) {

        $question = Question::with('options')
            ->whereHas('options')
            ->where('id',$request->id)
            ->first();

        return response()->json($question);

    }

}
