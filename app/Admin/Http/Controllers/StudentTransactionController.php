<?php

namespace App\Admin\Http\Controllers;

use App\Models\PackageStudyMaterial;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Matrix\Builder;
use Yajra\DataTables\DataTables;

class StudentTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, $id)
    {

        if (request()->ajax()) {

            $student = Student::findOrFail($id);

            $student_transactions = Transaction::whereUserId($student->user_id)
                ->with('user')
                ->whereHas('user')
                ->get();

            return DataTables::of($student_transactions)
               /* ->addColumn('action', function ($student_transactions ){
                    return view('admin::pages.students.transactions.action', compact('student_transactions'));
                })*/
               ->editColumn('package_id', function ($student_transaction) {
                   return $student_transaction->package->name;
               })
                ->rawColumns(['transaction.name'])
                ->make(true);
        }
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
