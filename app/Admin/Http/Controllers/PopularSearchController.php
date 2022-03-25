<?php

namespace App\Admin\Http\Controllers;

use App\Models\PopularSearch;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PopularSearchController extends Controller
{
    public function index(Builder $builder)
    {
        $this->authorize('viewAny', PopularSearch::class);

        if (request()->ajax()) {
            $query = PopularSearch::query();

            return DataTables::of($query)
                ->filter(function (\Illuminate\Database\Eloquent\Builder $query) {
                    if (request()->filled('filter.search')) {
                        $query->where('name', 'like', '%' . request()->input('filter.search') . '%');
                    }
                    if(request()->filled('filter.status') && request('filter.status') != 'all') {
                        $query->where('status','=', request('filter.status'));
                    }
                })
                ->addColumn('action', function ($popular_search) {
                    return view('admin::pages.popular_search.action', compact('popular_search'));
                })
                ->editColumn('status',function ($package){
                    if($package->status == 1){
                        return '<span class="badge badge-success">Active</span>';
                    }
                    return '<span class="badge badge-danger">Inactive</span>';
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        $table = $builder->columns([
            ['name' => 'name', 'data' => 'name', 'title' => 'Name'],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3']
        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        return view('admin::pages.popular_search.index', compact('table'));
    }

    public function create(): \illuminate\view\View
    {
        $this->authorize('create', PopularSearch::class);

        return view('admin::pages.popular_search.create');
    }


    public function store(Request $request,PopularSearch $popular_search)
    {
        $this->authorize('create', PopularSearch::class);

        $request->validate([
            'name' => 'required','max:15',
        ]);

        $popular_search->name = $request->input('name');
        $popular_search->status = $request->input('status');

        $popular_search->save();

        return redirect()->route('admin.popular-searches.index')->with('success', 'Search Key successfully created');
    }


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
        $popular_search = PopularSearch::findOrFail($id);

        $this->authorize('delete', $popular_search);

        $popular_search->delete();

        return response()->json(true, 200);
    }
    public function changeStatus($id)
    {
        $popular_search = PopularSearch::findOrFail($id);

        $this->authorize('update', $popular_search);

       if($popular_search->status == 1)
       {
           $popular_search->status = 0;

           $popular_search->update();

       }else {

           $popular_search->status = 1;

           $popular_search->update();
       }

        return response()->json(true, 200);
    }
}
