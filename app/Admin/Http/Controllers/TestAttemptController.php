<?php

namespace App\Admin\Http\Controllers;

use App\Models\Test;
use App\Models\TestRating;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;

class TestAttemptController extends Controller
{

    public function index(Builder $builder)
    {

        $this->authorize('viewAny', Test::class);

        $tests = Test::with('test_results')
            ->get();

        if (request()->ajax()) {
            $testResults =  TestResult::with('test.test_ratings')
                ->whereHas('test.test_ratings')
                ->groupBy('test_id')
                ->get();

            return DataTables::of( $testResults )
//                ->filter(function ( $testResults ) {
//                    if (request()->filled('filter.search')) {
//                    $testResults->where('test', function ($testResults) {
//                        $testResults->where('name', 'like', '%' . request('filter.search') . '%');
//                    });
//
//                    }
//                })
                ->addColumn('test_ratings', function( $testResults ) {
                    return $testResults->test->test_ratings->count();
                })
                ->addColumn('action', function ($testResult) {
                    return view('admin::pages.tests.attempts.action', compact('testResult'));
                })
                ->rawColumns(['action', 'rating'])
                ->make(true);
        }

        $table = $builder->columns([
            ['name' => 'test.name', 'data' => 'test.name', 'title' => 'Test'],
            ['name' => 'test_ratings', 'data' => 'test_ratings', 'title' => 'Total no.of ratings'],
            ['data' => 'action', 'name' => 'action', 'title' => '','orderable' => false]


        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        return view('admin::pages.tests.attempts.index', compact('table'));
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

        $testResult = TestRating::where('test_id',$id)->first();

        $test_rating_five  = TestRating::where('test_id',$id)
            ->where('rating', 5)
            ->count();
        $test_rating_four  = TestRating::where('test_id',$id)
            ->where('rating', 4)
            ->count();
        $test_rating_three  = TestRating::where('test_id',$id)
            ->where('rating', 3)
            ->count();
        $test_rating_two  = TestRating::where('test_id',$id)
            ->where('rating', 2)
            ->count();
        $test_rating_one  = TestRating::where('test_id',$id)
            ->where('rating', 1)
            ->count();

        return view('admin::pages.tests.attempts.show', compact('testResult','test_rating_one','test_rating_two',
        'test_rating_three','test_rating_four','test_rating_five'));
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
