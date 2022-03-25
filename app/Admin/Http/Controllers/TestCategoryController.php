<?php

namespace App\Admin\Http\Controllers;

use App\Models\TestCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class TestCategoryController extends Controller
{
    public function index(Builder $builder)
    {
        $this->authorize('viewAny', TestCategory::class);

        if (request()->ajax()) {
            $query = TestCategory::query();

            return DataTables::of($query)
                ->filter(function (\Illuminate\Database\Eloquent\Builder $query) {
                    if (request()->filled('filter.search')) {
                        $query->where('name', 'like', '%' . request()->input('filter.search') . '%');
                    }
                })
                ->addColumn('action', function ($category) {
                    return view('admin::pages.tests.categories.action', compact('category'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $tableTestCategory = $builder->columns([
            ['name' => 'name', 'data' => 'name', 'title' => 'Name'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3']
        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        return view('admin::pages.tests.categories.index', compact('tableTestCategory'));
    }

    public function create()
    {
        $this->authorize('create', TestCategory::class);

        return view('admin::pages.tests.categories.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', TestCategory::class);

        $this->validate($request, [
            'name'           => 'required|unique:test_categories',
        ]);

        $testCategory = new TestCategory();
        $testCategory->name = $request->name;
        $testCategory->save();

        return redirect()->route('admin.test-categories.index')->with('success', 'Test  category successfully created');
    }

    public function show(Builder $builder, $testId)
    {
        abort(404);
    }

    public function edit($id)
    {
        $testCategory = TestCategory::findOrFail($id);

        $this->authorize('update', $testCategory);

        return view('admin::pages.tests.categories.edit', compact('testCategory'));
    }

    public function update(Request $request, $id)
    {
        $testCategory = TestCategory::findOrFail($id);

        $this->authorize('update', $testCategory);

        $this->validate($request, [
            'name' => 'required|unique:test_categories,name,'.$id,
        ]);

        $testCategory->name = $request->name;
        $testCategory->save();

        return redirect()->route('admin.test-categories.index')->with('success', 'Test  category successfully updated');

    }

    public function destroy($id)
    {
        $testCategory = TestCategory::findOrFail($id);

//        $this->authorize('delete', $testCategory);

        $testCategory->delete();

        return response()->json(true, 200);
    }

}

