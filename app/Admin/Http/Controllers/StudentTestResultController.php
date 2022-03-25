<?php

namespace App\Admin\Http\Controllers;

use App\Models\Student;
use App\Models\Test;
use App\Models\TestResult;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class StudentTestResultController extends Controller
{
    public function index(Builder $builder, $id)
    {

        $this->authorize('viewAny', Test::class);

        if (request()->ajax()) {
            $student = Student::findOrFail($id);

            $testResults =  TestResult::where('ended_at','!=', null)
                ->where('user_id', $student->user_id)
                ->with('test.package');

            return DataTables::of( $testResults )

                ->editColumn('test_id', function ( $testResults ){
                    return $testResults->test->name;
                })
                ->editColumn('package_id', function ( $testResults ){
                    if(!$testResults->package) {
                        return '';
                    }
                    return $testResults->package->name;
                })
                ->addColumn('action', function ($testResults){
                    return view('admin::pages.students.tests.action', compact('testResults'));
                })
                ->rawColumns(['action'])
                ->make(true);

        }

    }
}
