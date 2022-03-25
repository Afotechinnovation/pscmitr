<?php

namespace App\Admin\Http\Controllers;

use App\Exports\SegmentExport;
use App\Models\Course;
use App\Models\SegmentCourse;
use App\Models\SegmentTest;
use App\Models\Student;
use App\Models\Test;
use App\Models\User;
use App\Models\UserSegment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class UserSegmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {

        $courses = Course::with('packages')->get();
        $tests = Test::with('test_results')->get();


        if (request()->ajax()) {
            $query = UserSegment::query();

            return DataTables::of( $query )

                ->addColumn('action', function ( $segment ){
                    return view('admin::pages.segments.action', compact('segment'));
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

        return view('admin::pages.segments.index', compact('table','courses','tests'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,UserSegment $userSegment)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'age_from' => 'numeric|nullable|min:0|lt:'.$request->age_to,
            'mark_from' => 'numeric|nullable|min:0|lt:'.$request->mark_to,
        ]);

        DB::beginTransaction();

        $userSegment->name = $request->name;
        $userSegment->age_from = $request->age_from;
        $userSegment->age_to = $request->age_to;
        $genderValue = $request->gender;

        if($genderValue == 'male'){
            $userSegment->gender = 1;

        }else if($genderValue == 'female') {
            $userSegment->gender = 0;

        }else{
            $userSegment->gender = NULL;

        }
        $userSegment->rating = $request->rating;

        $mark_condition = $request->mark_condition;

        if($mark_condition == '='){
            $userSegment->marks_is_equal = $mark_condition ? true: false;

        }elseif ( $mark_condition == '<=' ) {
            $userSegment->marks_less_than = $mark_condition ? true: false;

        }elseif ( $mark_condition == '>=' ) {
            $userSegment->marks_greater_than = $mark_condition ? true: false;

        }else {
            $userSegment->marks_in_between = $mark_condition ? true: false;
            $userSegment->mark_to = $request->mark_to;

        }
        $userSegment->mark_from = $request->mark_from;

        $userSegment->save();

        if( $request->courses ){
          $courses =  $request->courses;

            foreach( $request->courses as $course ){
                $userSegment->segmentCourses()->attach($userSegment->id, ['segment_id' => $userSegment->id, 'course_id' => $course]);
            }
        }
        if( $request->tests ){
            $courses =  $request->tests;

            foreach( $request->tests as $test ){
                $userSegment->segmentTests()->attach($userSegment->id, ['segment_id' => $userSegment->id, 'test_id' => $test]);
            }
        }

        DB::commit();

        return redirect()->route('admin.user-segments.index')->with('success', 'Segment successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Builder $builder,$id)
    {

        $user_segment = UserSegment::findOrFail($id);

        $condition = null;
        $condition1 = null;
        $condition2 = null;

        $gender = $user_segment->gender;
        $age_from = $user_segment->age_from;
        $age_to = $user_segment->age_to;
        $dob_from = Carbon::now()->subYear($age_from)->format('Y-m-d');
        $dob_to = Carbon::now()->subYear($age_to)->format('Y-m-d');
        $rating = $user_segment->rating;
        $mark_from = $user_segment->mark_from;
        $mark_to = $user_segment->mark_to;

        if( $user_segment->marks_less_than ) {
            $condition = '<=';
        }
        if ( $user_segment->marks_greater_than ) {
            $condition = '>=';
        }
        if ( $user_segment->marks_is_equal ) {
            $condition = '=';
        }
        if($user_segment->marks_in_between) {
            $condition1 = '>=';
            $condition2 = '<=';
        }

        $courses =  SegmentCourse::where('segment_id',$id)
                    ->pluck('course_id');
        $tests =  SegmentTest::where('segment_id',$id)
            ->pluck('test_id');

        if (request()->ajax()) {
            $query = User::with('students','package_rating','test_rating','test_results','transactions')
            ->whereHas('students',function ( $student ) use( $gender, $dob_from, $dob_to ){
                        $student->whereDate('date_of_birth','>=', $dob_to)
                            ->whereDate('date_of_birth','<=', $dob_from)
                            ->orWhere('gender', $gender);

                })
                ->orWhereHas('package_rating',function ( $package_rating ) use( $rating ) {
                    $package_rating->where('rating', $rating);
                })
                ->orWhereHas('test_rating',function ( $test_rating) use( $rating ) {
                    $test_rating->where('rating', $rating);
                })
                ->orWhereHas('test_results',function ( $test_results ) use( $mark_from, $mark_to, $condition, $condition1, $condition2, $tests ) {
                           $test_results->where('mark_percentage', $condition1, $mark_from)
                                    ->where('mark_percentage', $condition2, $mark_to)
                                    ->orWhere('mark_percentage', $condition, $mark_from)
                                    ->orWhereIn('test_id', $tests);

                })
               ->orWhereHas('transactions',function ( $transactions ) use( $courses ) {
                    $transactions->WhereIn('course_id', $courses);
                })
                ->orderBy('id','DESC')
                ->get();

            return DataTables::of( $query)
//                ->rawColumns(['action'])
                    ->make(true);
        }

        $table = $builder->columns([
            ['name' => 'name', 'data' => 'name', 'title' => 'Name'],
            ['name' => 'mobile', 'data' => 'mobile', 'title' => 'Mobile'],
//            ['name' => 'email', 'data' => 'email', 'title' => 'Email'],
//            ['name' => 'gender', 'data' => 'gender', 'title' => 'Mobile'],
//            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3']
        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        return view('admin::pages.segments.show', compact('user_segment','table'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function Pdfdownload( $id ){

        $segmentId = $id;

        return Excel::download(new SegmentExport($segmentId), 'SEGMENTS' . time() . '.xlsx');

//        $pdf =  PDF::loadView('admin::pages.segments.segment_pdf_download', compact('segments'));
//
//        return $pdf->download('segments.pdf');


    }
}
