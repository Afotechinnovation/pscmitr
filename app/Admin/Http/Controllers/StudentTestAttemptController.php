<?php

namespace App\Admin\Http\Controllers;

use App\Models\Student;
use App\Models\TestAttempt;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;

class StudentTestAttemptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request, $student_id, $test_id)
    {
        if (request()->ajax()) {

            $student = Student::findOrFail($student_id);
            if($request->package_id) {
                $testAttempts =  TestAttempt::where('test_id', $test_id)
                    ->where('user_id', $student->user_id)
                    ->where('package_id', $request->package_id)
                    ->with('test.package');
            }else {
                $testAttempts =  TestAttempt::where('test_id', $test_id)
                    ->where('user_id', $student->user_id)
                    ->with('test.package');
            }

            return DataTables::of( $testAttempts )

                ->editColumn('percentile', function ( $testAttempts ){
                    return round($testAttempts->percentile). ' %';
                })
                ->editColumn('progress', function ( $testAttempts ){
                    return round($testAttempts->progress). ' %';
                })
                ->make(true);

        }

        $table = $builder->columns([
            ['name' => 'attempts', 'data' => 'attempts', 'title' => 'No: of Attempt'],
            ['name' => 'percentile', 'data' => 'percentile', 'title' => 'Percentage'],
            ['name' => 'progress', 'data' => 'progress', 'title' => 'Progress'],
            ['name' => 'total_mark', 'data' => 'total_mark', 'title' => 'Total Mark'],

        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);
        return view('admin::pages.students.attempts.index', compact('table'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
