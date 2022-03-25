<?php

namespace App\Admin\Http\Controllers;


use App\Exports\QuestionExport;
use App\Models\Admin;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\DescriptiveQuestionKeyword;
use App\Models\Option;
use App\Models\Question;
use App\Models\Section;
use App\Models\StudentAnswer;
use App\Models\Subject;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestResult;
use Carbon\Carbon;
use http\QueryString;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class QuestionController extends Controller
{
    public function index(Builder $builder)
    {

        $questionCreaters = Admin::with('questions')
            ->whereHas('questions')
            ->get();

        $this->authorize('viewAny', Question::class);

        if (request()->ajax()) {

            $questions = Question::query()->with('course','subject','chapter','admin','admin_created_by');



            $questions->orderBy('id','desc');

            return DataTables::of($questions)
                ->filter(function (\Illuminate\Database\Eloquent\Builder $questions) {
                    if (request()->filled('filter.search')) {
                        $questions->where('question', 'like', '%' . request()->input('filter.search') . '%');
                    }
                    if(request()->filled('filter.type') && request('filter.type') != 'all') {
                        $questions->where('type','=', request('filter.type'));
                    }
                   if(request()->filled('filter.course') && request('filter.course') != 'all') {
                       $questions->whereHas('course', function( $course)  {
                            $course->where('course_id','=', request('filter.course'));
                        });
                    }
                    if(request()->filled('filter.subject') ) {
                        $questions->whereHas('subject', function( $subject)  {
                            $subject->where('subject_id','=', request('filter.subject'));
                        });
                    }
                    if(request()->filled('filter.chapter') ) {
                        $questions->whereHas('chapter', function( $chapter)  {
                            $chapter->where('chapter_id','=', request('filter.chapter'));
                        });
                    }
                    if(request()->filled('filter.created_by') ) {
                        $questions->whereHas('admin_created_by', function( $admin_created_by)  {
                            $admin_created_by->where('created_by','=', request('filter.created_by'));
                        });
                    }
                    if (request()->filled('filter.date')) {
                        $questions->where( function ( $date ) {
                            $date->whereDate('created_at', Carbon::parse(request('filter.date')));
                        });
                    }
                })
                ->editColumn('last_updated_by', function ($question) {
                    if(!$question->admin) {
                        return '';
                    }
                    return $question->admin->name;
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
                ->editColumn('created_by', function ($question) {
                    if(!$question->admin_created_by) {
                        return '';
                    }
                    return $question->admin_created_by->name;
                })

                ->editColumn('created_at', function ($question) {
                    return Carbon::parse($question->created_at)->format('d M Y');
                })
                ->addColumn('time', function ($question) {
                    return Carbon::parse($question->created_at)->toTimeString();
                })
                ->addColumn('action', function ($question ){

                    $attendedTests = TestResult::with('test')
                        ->groupBy('test_id')
                        ->pluck('test_id')->toArray();

                    $testQuestionIDs = TestQuestion::whereIn('test_id', $attendedTests)
                        ->groupBy('question_id')
                        ->pluck('question_id')->toArray();

                    return view('admin::pages.questions.action', compact('question','testQuestionIDs'));
                })
                ->addColumn('question', function ($question ){

                    return view('admin::pages.questions.question', compact('question'));
                })

                ->rawColumns(['action','time','question','last_updated_by'])
                ->addIndexColumn()
                ->make(true);
        }

        $tableQuestions = $builder->columns([
            ['name' => 'DT_RowIndex', 'data' => 'DT_RowIndex', 'title' => 'S.No', 'orderable' =>  false, 'searchable' => false],
            ['name' => 'question', 'data' => 'question', 'title' => 'Question'],
            ['name' => 'last_updated_by', 'data' => 'last_updated_by', 'title' => 'Last Updated By'],
            ['name' => 'type', 'data' => 'type', 'title' => 'Type'],
            ['name' => 'difficulty_level', 'data' => 'difficulty_level', 'title' => 'Difficulty Level'],
            ['name' => 'course_id', 'data' => 'course_id', 'title' => 'Course'],
            ['name' => 'subject_id', 'data' => 'subject_id', 'title' => 'Subject'],
            ['name' => 'chapter_id', 'data' => 'chapter_id', 'title' => 'Chapter'],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created Date'],
            ['name' => 'created_by', 'data' => 'created_by', 'title' => 'Created By'],
            ['name' => 'time', 'data' => 'time', 'title' => 'Created Time'],

            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3']

        ])->parameters([
            'lengthChange' => false,
            'searching' => false,

        ]);

        return view('admin::pages.questions.index', compact('tableQuestions','questionCreaters'));
    }

    public function create(Request $request)
    {
//        $this->authorize('create', Question::class);

//        return $request->course;

        $courseId = $request->course ?? null;
        $subjectId = $request->subject ?? null;
        $chapterId = $request->chapter ?? null;
        $type = $request->type ?? null;
        $level = $request->level ?? null;
        $course = null;
        $subject = null;
        $chapter = null;

        if($courseId){
            $course = Course::findOrFail($courseId);
        }
        if($subjectId){
            $subject = Subject::findOrFail($subjectId);
        }
        if($chapterId){
            $chapter = Chapter::findOrFail($chapterId);
        }

        return view('admin::pages.questions.create', compact(
            'course', 'subject', 'chapter', 'level', 'type'));
    }

    public function store(Request $request)
    {
        $question_type = $request->question_type;

        if( $question_type == 1 ){
            $this->validate($request, [
                    'question_type' => 'required',
//                    "options.*" => 'required|min:3',
//                    'question' => 'required',
//                    'options.0' => 'required',
//                    'options.1' => 'required',
//                    'options.2' => 'required',
//                    'options.3' => 'required',
//                    'question' => 'required',
                    'correct_option' => 'required',
                    'difficulty_level' => 'required',
                    'chapter_id' => 'required',
                    'subject_id' => 'required'
                ],
                [
//                    'options.0.required'=> 'This field is required.',
//                    'options.1.required'=> 'This field is required.',
//                    'options.2.required'=> 'This field is required.',
//                    'options.3.required'=> 'This field is required.',
                    'correct_option.required'=> 'Please select an option.',
                ]
            );
        }
        if( $question_type == 2 ){
            $this->validate($request, [
                'question_type' => 'required',
//                'question' => 'required',
                'is_true' => 'required',
                'difficulty_level' => 'required',
                'chapter_id' => 'required',
                'subject_id' => 'required'
            ]);
        }
        else{
            $this->validate($request, [
                'question_type' => 'required',
//                'question' => 'required',
                'difficulty_level' => 'required',
                'chapter_id' => 'required',
                'subject_id' => 'required'
            ]);
        }

        $this->authorize('create', Question::class);


        if($request->create_and_new == 1)
        {
            $course = $request->course_id;
            $subject = $request->subject_id;
            $chapter = $request->chapter_id;
            $type = $question_type;
           // info("subject".$subject);
            $difficultyLevel = $request->difficulty_level;

            DB::beginTransaction();

            $question = new Question();
            $question->type = $question_type;
            $question->difficulty_level = $request->difficulty_level;
            $question->course_id = $request->course_id;
            $question->subject_id = $request->subject_id;
            $question->chapter_id = $request->chapter_id;
            $question->question = $request->question;
            $question->explanation = $request->explanation;
            $question->created_by = Auth::user()->id;

            if ($request->hasFile('image')) {
                $photo = $request->file('image');
                $file_extension =  $photo->getClientOriginalExtension();
                $filename = time() . '.' . $file_extension;
                $filePath = $request->file('image')->storeAs('questions/image', $filename, 'public');
                $question->image  = $filename;
            }

            $question->save();

            if($question_type == 1){
                $options = $request->options;
                $images = $request->images;

                // filter array to avoid null options

                $objectiveOptions = array_filter($options, function($key){
                    return !is_null($key) && $key !== '';
                });

                $count = count($objectiveOptions);

                for($i= 0; $i< $count; $i++){
                    $option = new Option();
                    $option->question_id = $question->id;
                    $option->option = $objectiveOptions[$i];
                    $option->is_correct = $i+1 == $request->correct_option ? true : false;

                    if (!empty($request->images[$i])) {

                        $photo = $request->images[$i];
                        $file_extension =  $photo->getClientOriginalExtension();
                        $filename = time() . '.' . $file_extension;
                        $filePath = $photo->storeAs('questions/options/image', $filename, 'public');
                        $option->image  = $filename;
                    }

                    $option->save();

                }
            }
            elseif($question_type == 2){

                $option = new Option();
                $option->question_id = $question->id;
                $option->is_correct = $request->is_true ? true : false;

                if ($request->hasFile('image')) {
                    $photo = $request->file('image');
                    $file_extension =  $photo->getClientOriginalExtension();
                    $filename = time() . '.' . $file_extension;
                    $filePath = $request->file('image')->storeAs('questions/options/image', $filename, 'public');
                    $option->image  = $filename;
                }

                $option->save();
            }

            DB::commit();

            return redirect()->route('admin.questions.create',
                'course='.$course.'&subject='.$subject.'&chapter='.$chapter.'&type='.$type.'&level='.$difficultyLevel)
                ->with('success', 'Question successfully created');
        }

        DB::beginTransaction();

        $question = new Question();
        $question->type = $question_type;
        $question->difficulty_level = $request->difficulty_level;
        $question->course_id = $request->course_id;
        $question->subject_id = $request->subject_id;
        $question->chapter_id = $request->chapter_id;
        $question->question = $request->question;
        $question->explanation = $request->explanation;
        $question->created_by = Auth::user()->id;
        $question->last_updated_by = Auth::user()->id;

        if ($request->hasFile('file')) {
            $photo = $request->file('file');
            $file_extension =  $photo->getClientOriginalExtension();
            $filename = time() . '.' . $file_extension;
            $filePath = $request->file('file')->storeAs('questions/image', $filename, 'public');
            $question->image  = $filename;
        }

        $question->save();

        if($question_type == 1){

            $options = $request->options;
            $images = $request->images;

            $objectiveOptions = array_filter($options, function($key){
                return !is_null($key) && $key !== '';
            });

            $count = count($objectiveOptions);

            for($i= 0; $i< $count; $i++){
                    $option = new Option();
                    $option->question_id = $question->id;
                    $option->option = $objectiveOptions[$i];
                    $option->is_correct = $i+1 == $request->correct_option ? true : false;

                if (!empty($request->images[$i])) {

                    $photo = $request->images[$i];
                    $file_extension =  $photo->getClientOriginalExtension();
                    $filename = time() . '.' . $file_extension;
                    $filePath = $photo->storeAs('questions/options/image', $filename, 'public');
                    $option->image  = $filename;

                }

                $option->save();

            }
        }
        elseif($question_type == 2){
            $option = new Option();
            $option->question_id = $question->id;
            $option->is_correct = $request->is_true ? true : false;

            if ($request->hasFile('image')) {
                $photo = $request->file('image');
                $file_extension =  $photo->getClientOriginalExtension();
                $filename = time() . '.' . $file_extension;
                $filePath = $request->file('image')->storeAs('questions/options/image', $filename, 'public');
                $option->image  = $filename;
            }

            $option->save();
        }

        DB::commit();
        return redirect()->route('admin.questions.edit', $question->id)->with('success', 'Question successfully created');
    }

    public function show(Request $request, $id)
    {

    }

    public function edit($id)
    {

        $question = Question::findOrFail($id);

        $this->authorize('update', $question);

        $type = $question->type;

        $trueOrFalseOption = Option::where('question_id', $id)->first();

        $trueOrFalseOptionImage = Option::where('question_id', $id)
                        ->where('option', null)->first();

//        return $objectiveOptions;

        $lastRow = Question::orderBy('id','DESC')->first();
        $firstRow = Question::orderBy('id','ASC')->first();

        $nextQuestionId = Question::where('id', '>', $question->id)->min('id');

        $previousQuestionId = Question::where('id', '<', $question->id)->max('id');

        return view('admin::pages.questions.edit', compact('question', 'firstRow','trueOrFalseOption','trueOrFalseOptionImage','nextQuestionId','lastRow','previousQuestionId'));
    }

    public function update(Request $request, $id)
    {
        $flags = $request->option_flag;
        $question_type = $request->question_type;

        if( $question_type == 1 ){
            $this->validate($request, [
                'question_type' => 'required',
              //  'question' => 'required',
               // 'options'    => 'required|array|size:4',
//                'options.1' => 'required',
//                'options.2' => 'required',
//                'options.3' => 'required',
//                'options.4' => 'required',
                'correct_option' => 'required',
                'difficulty_level' => 'required',

            ],
                [
                  //  'options.required' => 'Minimum four option required',
//                    'options.1.required'=> 'This field is required.',
//                    'options.2.required'=> 'This field is required.',
//                    'options.3.required'=> 'This field is required.',
//                    'options.4.required'=> 'This field is required.',
                    'correct_option.required'=> 'Please select an option.',
                ]
            );
        }
        if( $question_type == 2 ){
            $this->validate($request, [
                'question_type' => 'required',
                'is_true' => 'required',
                'difficulty_level' => 'required',
            ]);
        }
        else{
            $this->validate($request, [
                'question_type' => 'required',
                'difficulty_level' => 'required',
            ]);
        }

        $question = Question::findOrFail($id);
        $this->authorize('update', $question);

        DB::beginTransaction();

        $question->type = $question_type;
        $question->difficulty_level = $request->difficulty_level;
        $question->question = $request->question;
        $question->course_id = $request->course_id;
        $question->subject_id = $request->subject_id;
        $question->chapter_id = $request->chapter_id;
        $question->explanation = $request->explanation;
        $question->last_updated_by = Auth::user()->id;

        if ($request->hasFile('file')) {
            $photo = $request->file('file');
            $file_extension =  $photo->getClientOriginalExtension();
            $filename = time() . '.' . $file_extension;
            $filePath = $request->file('file')->storeAs('questions/image', $filename, 'public');
            $question->image  = $filename;
        }

        $question->save();

        if($question_type == 1){

            $optionIds = $request->optionIds;

            $options = $request->options;
            $images = $request->images;
            $objectiveOptions = array_filter( $options, function( $key ){
                return !is_null( $key ) && $key !== '';
            });

            if( $optionIds ) {
                $optionCount = count( $optionIds );
                for($i = 0; $i< $optionCount; $i++){

                    $option = Option::findOrFail( $optionIds[$i] );
                    $option->question_id = $question->id;
                    $option->option = $objectiveOptions[$i+1];
                    $option->is_correct = $i+1 == $request->correct_option ? true : false;
                    if($flags[$i] == 1){
                        if( $request->images ){
                            $photo = $request->images[$i];
                            if($photo) {
                                $file_extension =  $photo->getClientOriginalExtension();
                                $filename = time() . '.' . $file_extension;
                                $filePath = $photo->storeAs('questions/options/image', $filename, 'public');
                                $option->image  = $filename;
                            }
                        }
                    }
                    $option->save();
                }
            }else {

                // true or false question changing to objective
                $count = count($objectiveOptions);
                Option::where('question_id',$id)->delete();

                for( $i= 0; $i< $count; $i++ ) {

                    $option = new Option();
                    $option->question_id = $question->id;
                    $option->option = $objectiveOptions[$i];
                    $option->is_correct = $i+1 == $request->correct_option ? true : false;

                    if( !empty($request->images[$i]) ) {

                        $photo = $request->images[$i];
                        $file_extension = $photo->getClientOriginalExtension();
                        $filename = time() . '.' . $file_extension;
                        $filePath = $photo->storeAs('questions/options/image', $filename, 'public');
                        $option->image = $filename;

                    }
                    $option->save();

                }

            }

        }
        elseif($question_type == 2){
            $option = Option::where('question_id', $id)
                ->where('option', null)
                ->first();

            if( !$option ) {
                Option::where('question_id',$id)->delete();
                $option = new Option();
            }

            $option->question_id = $question->id;
            $option->is_correct = $request->is_true ? true : false;
            if ($request->hasFile('image')) {
                $photo = $request->file('image');
                $file_extension =  $photo->getClientOriginalExtension();
                $filename = time() . '.' . $file_extension;
                $filePath = $request->file('image')->storeAs('questions/options/image', $filename, 'public');
                $option->image  = $filename;
            }
            $option->save();
        }

        DB::commit();
        return redirect()->back()->with('success', 'Question successfully updated');
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        $this->authorize('delete', $question);

        DB::beginTransaction();

        $options = Option::with('question')
            ->whereHas('question')
            ->get();

        $testQuestions = TestQuestion::with('question')
            ->whereHas('question')
            ->get();
        $testIDs = TestQuestion::where('question_id', $id)->groupBy('test_id')->pluck('test_id');

        foreach($testIDs as $testID) {
            $test = Test::findOrFail($testID);
            $test->is_published = false;

            $test->save();
        }

        if($testQuestions) {
            TestQuestion::where('question_id', $id)->delete();
        }


        if($options) {
            Option::where('question_id', $id)->delete();
        }

        $question->delete();

        DB::commit();

        return response()->json(true, 200);
    }

    public function imageStore() {

        if (request()->hasFile('image')) {
            $image = request()->file('image');

            $fileName = 'IMAGE_' . time() . '.' .$image->getClientOriginalExtension();
            $image->storeAs('public/question_images/', $fileName);

            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => url('storage/question_images') .'/' . $fileName
                ]
            ]);
        }

        return response()->json([
            'success' => 0
        ]);
    }

    public function upload(Request $request) {

        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('questions/explanations'), $fileName);

            $url = url('../questions/explanations/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);


        }
    }

    public function exportToExcel(Request $request) {

        $searchType = $request->input('type') ?? '';
        $search = $request->input('search') ?? '';
        $course = $request->input('course') ?? '';
        $subject = $request->input('subject') ?? '';
        $chapter = $request->input('chapter') ?? '';
        $created_by = $request->input('created_by') ?? '';
        $date = $request->input('date') ?? '';


        return Excel::download(new QuestionExport($searchType, $search, $course, $subject, $chapter, $created_by, $date), 'QUESTIONS' . time() . '.xlsx',);
    }
}
