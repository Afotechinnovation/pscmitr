<?php

namespace App\Admin\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class CategoryController extends Controller
{
    var $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Builder $builder)
    {
        $this->authorize('viewAny', Category::class);

        if (request()->ajax()) {
            $query = Category::query();

            return DataTables::of($query)
                ->filter(function (\Illuminate\Database\Eloquent\Builder $query) {
                    if (request()->filled('filter.search')) {
                        $query->where('name', 'like', '%' . request()->input('filter.search') . '%');
                    }
                })
                ->addColumn('action', function ($category) {
                    return view('admin::pages.categories.action', compact('category'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $table = $builder->columns([
            ['name' => 'name', 'data' => 'name', 'title' => 'Name'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3']
        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        return view('admin::pages.categories.index', compact('table'));
    }

    public function create(): \illuminate\view\View
    {
        $this->authorize('create', Category::class);

         return view('admin::pages.categories.create');
    }

    public function store(StoreCategoryRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('create', Category::class);

        $attributes = $request->validated();

        $this->categoryService->store($attributes);

        return redirect()->route('admin.categories.index')->with('success', 'Category successfully created');

    }

    public function edit(Category  $category): \illuminate\view\View
    {
        $this->authorize('update', $category);

        return view('admin::pages.categories.edit', compact('category'));
    }

    public function update(Category $category, UpdateCategoryRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('update', $category);

        $attributes = $request->validated();

        $this->categoryService->update($category, $attributes);

        return redirect()->route('admin.categories.index')->with('success', 'Category successfully updated');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $this->authorize('delete', $category);

        $category->delete();

        return response()->json(true, 200);
    }
}
