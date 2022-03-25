<?php

namespace App\Admin\Http\Controllers;

use App\Models\Package;
use App\Models\PackageTest;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestQuestion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PackageTestController extends Controller
{

    public function index(Builder $builder, $id)
    {
        if (request()->ajax()) {

            $this->authorize('viewAny', PackageTest::class);

            $package_tests = PackageTest::query()
                ->wherePackageId($id)
                ->with('package','test')
                ->whereHas('package')
                ->whereHas('test');

            $package_tests->orderBy('order');

            return DataTables::of( $package_tests )
                ->addColumn('action', function ( $package_test ){
                    return view('admin::pages.packages.tests.action', compact('package_test'));
                })
                ->editColumn('course_id', function ( $package_test ){
                    if(! $package_test->test->course){
                        return '';
                    }
                    return $package_test->test->course->name;
                })
                ->editColumn('subject_id', function ( $package_test ){
                    if(! $package_test->test->subject){
                        return '';
                    }
                    return $package_test->test->course->name;
                })
                ->editColumn('chapter_id', function ( $package_test ){
                    if(! $package_test->test->chapter){
                        return '';
                    }
                    return $package_test->test->chapter->name;
                })
                ->editColumn('category_id', function ( $package_test ) {
                    if( ! $package_test->test->category){
                        return '';
                    }
                    return $package_test->test->category->name;
                })
                ->editColumn('order', function( $package_test ) {
                    return '<div class="order">' . $package_test->order . '<input type="hidden" class="package-test-id" value="' . $package_test->id . '"></div>';
                })
                ->rawColumns([ 'name', 'order' ])
                ->make(true);
        }
    }

    public function create(Builder $builder, $id)
    {
        $this->authorize('create', Test::class);

        $package = Package::findOrFail($id);

        if (request()->ajax()) {

            $tests =  $tests = Test::query()->with('course','subject','chapter')
                ->where('is_published', true);

            return DataTables::of($tests)
                ->filter(function (\Illuminate\Database\Eloquent\Builder $tests) {
                    if (request()->filled('filter.search')) {
                        $tests->where('name', 'like', '%' . request()->input('filter.search') . '%')
                            ->orWhere('total_questions', '=', request()->input('filter.search'))
                            ->orWhere('total_time', '=', request()->input('filter.search'))
                            ->orWhere('total_marks', '=', request()->input('filter.search'))
                            ->orWhere('correct_answer_marks', '=', request()->input('filter.search'))
                            ->orWhere('negative_marks', '=', request()->input('filter.search'));
                    }
                    if(request()->filled('filter.course') ) {
                        $tests->whereHas('course', function( $course)  {
                            $course->where('id','=', request('filter.course'));
                        });
                    }
                })
                ->editColumn('category_id', function ( $test ) {
                    if( ! $test->category){
                        return '';
                    }
                    return $test->category->name;
                })
                ->editColumn('course_id', function ( $test ) {
                    if( !$test->course){
                        return '';
                    }
                    return $test->course->name;
                })
                ->rawColumns(['action','order'])
                ->make(true);
        }

        $checkbox = '<input class="select-all" name="select_all" type="checkbox">';

        $tableTests = $builder->columns([
            ['name' => 'name', 'data' => 'name', 'title' => 'Name'],
            ['name' => 'display_name', 'data' => 'display_name', 'title' => 'Display Name'],
            ['name' => 'category_id', 'data' => 'category_id', 'title' => 'Category'],
            ['name' => 'course_id', 'data' => 'course_id', 'title' => 'Course'],
            ['name' => 'total_questions', 'data' => 'total_questions', 'title' => 'Total Questions'],
            ['data' => 'total_marks', 'name' => 'total_marks', 'title' => 'Total Marks'],
            ['data' => 'total_time', 'name' => 'total_time', 'title' => 'Total Time'],
            ['data' => 'correct_answer_marks', 'name' => 'correct_answer_marks', 'title' => 'Correct Answer Mark'],
            ['data' => 'negative_marks', 'name' => 'negative_marks', 'title' => 'Negative Mark'],
            ['name' => 'select','data' => 'id', 'title' => $checkbox,
                'render' => ' renderCheckbox(data)', 'searchable' => false, 'orderable' => false, 'width' => '50px' ],
        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        $selectedTestIDs = [];
        foreach($package->package_tests as $test){
            $selectedTestIDs[] = $test->pivot->test_id;
        }

        return view('admin::pages.packages.tests.create', compact('package','tableTests','selectedTestIDs'));
    }

    public function store(Request $request, $package_id)
    {

    }

    public function show($id)
    {
        $package_test =  Test::findOrFail($id);

        $this->authorize('view', $package_test);

        $test_questions = TestQuestion::with('test','question.options')
            ->whereHas('test', function ($test) use($id) {
                $test->where('test_id', $id);
            })->get();

        return view('admin::pages.packages.tests.show', compact('package_test','test_questions'));
    }

    public function edit($package_id, $id)
    {

    }

    public function update(Request $request, $packageId)
    {
        $package = Package::findOrFail($packageId);

        DB::beginTransaction();
        if($request->selected_tests){
            foreach ($request->selected_tests as $package_test) {
                $package_test = PackageTest::updateOrCreate(['package_id' => $packageId, 'test_id' => $package_test]);
                $package_test->save();
            }
        }

        if($request->removed_tests) {
            $removed_tests = $request->removed_tests;
            $package->package_tests()->detach($removed_tests);
        }

        DB::commit();
        return redirect()->route('admin.packages.show', $packageId)->with('success', 'Package Tests successfully updated');
    }


    public function destroy($packageId, $testId)
    {
        $package_tests = PackageTest::where('package_id', $packageId)
            ->where('test_id', $testId)
            ->first();

        $this->authorize('delete', $package_tests);

        $package_tests->delete();

        return response()->json(true, 200);
    }

    public function changeOrder(){

        $packageTestIDs = request()->input('package_tests');

        if ($packageTestIDs) {
            $index = 1;

            foreach ($packageTestIDs as $packageTestID) {
                $packageTest = PackageTest::find($packageTestID);

                if ($packageTest) {
                    $packageTest->order = $index;
                    $packageTest->save();
                }

                $index++;
            }
        }

        return response()->json(true, 200);
    }

}
