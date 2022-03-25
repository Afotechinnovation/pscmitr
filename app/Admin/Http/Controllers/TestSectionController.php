<?php

namespace App\Admin\Http\Controllers;

use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestSection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class TestSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, $id)
    {
      //  $this->authorize('viewAny', PackageCategory::class);

        $testSections = TestSection::query()
            ->where('test_id', $id)
            ->with('test')
            ->get();

        if (request()->ajax()) {

            return DataTables::of($testSections)
                ->addColumn('action', function ($testSections) {
                    return view('admin::pages.tests.sections.action', compact('testSections'));
                })
                ->rawColumns(['name', 'action'])
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
    public function store(Request $request, $test_id)
    {
       // $this->authorize('create', Section::class);

        $test = Test::findOrFail($test_id);

        $this->validate($request, [
            'name' => [
                'required',
                Rule::unique('test_sections','name')->where(function ($query) use($test_id) {
                    $query->where('test_id', $test_id);
//                        ->where('deleted_at', ! null);
                }),
            ],

        ]);

        $testSection = new TestSection();
        $testSection->name = $request->name;
        $testSection->name_slug = Str::of($request->name)->slug('-');
        $testSection->test_id = $test_id;
        $testSection->save();

        return redirect()->back()->with('success','Test Section successfully created');
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
    public function destroy($test_id, $id)
    {

        $testSection = TestSection::findOrFail($id);

      //  DB::beginTransaction();

        $testQuestionSections = TestQuestion::where('test_id', $test_id)
            ->get();

        if($testQuestionSections){

            TestQuestion::where('section_id', $id)->delete();
        }

        $testSection->delete();

      //  DB::commit();

        return response()->json(true, 200);

    }
}
