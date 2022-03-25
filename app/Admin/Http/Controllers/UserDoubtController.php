<?php

namespace App\Admin\Http\Controllers;

use App\Models\UserDoubt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class UserDoubtController extends Controller
{

    public function index(Builder $builder)
    {
    //    $this->authorize('viewAny', UserDoubt::class);

        if (request()->ajax()) {
            $query = UserDoubt::with('test','question','user')->get();

            return DataTables::of( $query )
                ->editColumn('status', function ( $doubt ) {
                    if(!$doubt->status){
                        return '';
                    }
                    return '<span class="badge badge-info">'. $doubt->status .'</span>';
                })
                ->editColumn('user_id', function ( $doubt ) {
                    if( !$doubt->user ){
                        return '';
                    }
                    return $doubt->user->name ?? $doubt->user->mobile;
                })
                ->addColumn('action', function ( $doubt ){
                    return view('admin::pages.user_doubts.action', compact('doubt'));
                })
                ->addColumn('question.question', function ( $doubt ){
                    $question = $doubt->question;
                    return view('admin::pages.user_doubts.question', compact('question'));
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }

        $table = $builder->columns([
            ['data' => 'test.name', 'name' => 'test.name', 'title' => 'Test'],
            ['data' => 'question.question', 'name' => 'question.question', 'title' => 'Question'],
            ['data' => 'user_id', 'name' => 'user_id', 'title' => 'Student'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3']
        ])->orderBy(0, 'desc')
          ->parameters([
            'lengthChange' => false,
            'searching' => false,
            'ordering' => true,
         ]);

        return view('admin::pages.user_doubts.index', compact('table'));
    }

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
        $doubt = UserDoubt::findOrFail($id);

       // $this->authorize('view', $doubt);

        return view('admin::pages.user_doubts.show', compact('doubt'));
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
        $doubt = UserDoubt::findOrFail($id);

      //  $this->authorize('update', $doubt);

        $request->validate([
            'answer' => 'required',
        ]);
        DB::beginTransaction();

        $doubt->answer = $request->input('answer');

        $doubt->save();

        $doubt->send($doubt);
        DB::commit();


        return redirect()->route('admin.doubts.index')->with('success', 'Answer successfully updated');


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
