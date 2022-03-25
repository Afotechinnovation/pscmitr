<?php

namespace App\Admin\Http\Controllers;

use App\DataTables\TestResultDataTable;
use App\Exports\TestResultExport;
use App\Models\Test;
use App\Models\Testimonial;
use App\Models\TestResult;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Maatwebsite\Excel\Facades\Excel;

class TestResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder,Request $request)
    {
        $this->authorize('viewAny', Test::class);

        if (request()->ajax()) {
            $testResults =  TestResult::where('ended_at', '!=', null)
            ->with('test.package')->orderBy('id','DESC');

            return DataTables::of( $testResults )
                    ->filter(function ( $testResults ) {
                        if (request()->filled('filter.search')) {
                            $testResults->where(function ($testResults) {

                                $testResults->where('total_marks', 'like', '%'. request('filter.search') . '%');
//                                $testResults->orWhereHas('user', function( $user )  {
//                                    $user->where('mobile', 'like', '%'. request('filter.search') . '%')
//                                         ->orWhere('name', 'like', '%'. request('filter.search') . '%')
//                                        ->orWhere('email', 'like', '%'. request('filter.search') . '%');
//                                });
//                                $testResults->orWhereHas('package', function( $package)  {
//                                    $package->where('name', 'like', '%'. request('filter.search') . '%');
//                                });
//                                $testResults->orWhereHas('test', function( $test)  {
//                                    $test->where('name', 'like', '%'. request('filter.search') . '%');
//                                });
                            });
                        }

                        if(request()->filled('filter.date') ) {

                            $dateRange = request('filter.date');
                            $dates = explode(' - ',$dateRange);

                            $start_date = Carbon::parse(date('Y-m-d', strtotime($dates[0])).' 00:00:00');
                            $end_date = Carbon::parse(date('Y-m-d', strtotime($dates[1])).' 00:00:00');

                            $testResults->where(function ($testResults) use ($start_date, $end_date) {
                                $testResults->whereDate('created_at', '>=', $start_date)
                                            ->whereDate('created_at', '<=', $end_date);
                            });
                        }

                    })
                ->editColumn('test_id', function ( $testResults ){
                    return $testResults->test->name;
                })
                ->editColumn('user_id', function ( $testResults ){
                    return $testResults->user->name;
                })
                ->editColumn('created_at', function ($testResults) {
                    return Carbon::parse($testResults->created_at)->format('d M Y');
                })
                ->AddColumn('mobile', function ( $testResults ){
                    return $testResults->user->student->mobile;
                })
                ->AddColumn('email', function ( $testResults ){
                    return $testResults->user->student->email;
                })
                ->AddColumn('unattempted', function ( $testResults ){
                    $correct = $testResults->total_correct_answers;
                    $wrong = $testResults->total_wrong_answers;
                    $totalQuestions = $testResults->test->total_questions;
                    $total_attempted  = $correct + $wrong;
                    return $totalQuestions - $total_attempted;
                })

                ->editColumn('package_id', function ( $testResults ){
                    if(!$testResults->package) {
                        return '';
                    }
                    return $testResults->package->name;
                })
//                ->addColumn('action', function ($testResults){
//                    return view('admin::pages.tests.results.action', compact('testResults'));
//                })
                ->rawColumns(['email','mobile'])
                ->make(true);
        }

        $table = $builder->columns([
            ['name' => 'user_id', 'data' => 'user_id', 'title' => 'Name'],
            ['name' => 'mobile', 'data' => 'mobile', 'title' => 'Mobile'],
            ['name' => 'email', 'data' => 'email', 'title' => 'Email'],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Exam Date'],
            ['name' => 'test_id', 'data' => 'test_id', 'title' => 'Test'],
            ['name' => 'package_id', 'data' => 'package_id', 'title' => 'Package'],
            ['name' => 'total_correct_answers', 'data' => 'total_correct_answers', 'title' => 'Correct Answers'],
            ['name' => 'total_wrong_answers', 'data' => 'total_wrong_answers', 'title' => 'Wrong Answers'],
            ['name' => 'unattempted', 'data' => 'unattempted', 'title' => 'UnAttempted'],
            ['name' => 'total_marks', 'data' => 'total_marks', 'title' => 'Total Marks'],
        //    ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3']

        ])
            ->parameters([
            'lengthChange' => false,
            'searching' => false,

            ]);

        return view('admin::pages.tests.results.index', compact('table'));
    }


    public function create()
    {
        //
    }

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
        $testResult = TestResult::findOrFail($id);
        $testResult->delete();

        return response()->json(true, 200);
    }

    public function downloadPdf(Request $request)
    {

        $searchDate = request()->input('date') ?? '';
        $search = $request->input('search') ?? '';
        //info("search". $search);
      //  info("date". $searchDate);

        return Excel::download(new TestResultExport($searchDate, $search), 'TESTRESULTS_' . time() . '.xlsx');

    }
}
