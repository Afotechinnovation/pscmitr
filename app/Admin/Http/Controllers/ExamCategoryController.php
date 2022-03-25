<?php

namespace App\Admin\Http\Controllers;

use App\Http\Requests\StoreExamCategoryRequest;
use App\Http\Requests\UpdateExamCategoryRequest;
use App\Models\ExamCategory;
use App\Services\ExamCategoryService;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class ExamCategoryController extends Controller
{
    public function __construct(ExamCategoryService $examCategoryService)
    {
        $this->examCategoryService = $examCategoryService;
    }

    public function index(Builder $builder)
    {
        $this->authorize('viewAny', ExamCategory::class);

        if (request()->ajax()) {
            $query = ExamCategory::query();
            return DataTables::of($query)
                ->orderColumn('id', 'id $1')
                ->filter(function ($query) {
                    if (request()->filled('filter.search')) {
                        $query->where(function ($query) {
                            $query->where('name', 'like', '%'. request('filter.search') . '%')
                                ->orWhere('order', 'like', '%'. request('filter.search') . '%');
                        });
                    }

                })
                ->editColumn('order', function($query) {
                    return '<div class="order">' . $query->order . '<input type="hidden" class="exam_category-id" value="' . $query->id . '"></div>';
                })
                ->addColumn('action', function ($examCategory){
                    return view('admin::pages.exam_categories.action', compact('examCategory'));
                })
                ->rawColumns(['action', 'order'])
                ->make(true);
        }

        $table = $builder->columns([
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'order', 'name' => 'order', 'title' => 'Order'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3']
        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        return view('admin::pages.exam_categories.index', compact('table'));
    }

    public function create()
    {
        $this->authorize('create', ExamCategory::class);

        return view('admin::pages.exam_categories.create');
    }

    public function store(StoreExamCategoryRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('create', ExamCategory::class);

        $attributes = $request->validated();

        $this->examCategoryService->store($attributes);

        return redirect()->route('admin.exam-categories.index')->with('success', 'Exam Category successfully created');
    }

    public function edit(ExamCategory $exam_category)
    {
        $this->authorize('update', $exam_category);

        return view('admin::pages.exam_categories.edit', compact('exam_category'));
    }

    public function update(ExamCategory $exam_category, UpdateExamCategoryRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('update', $exam_category);

        $attributes = $request->validated();

        $this->examCategoryService->update($exam_category, $attributes);

        return redirect()->route('admin.exam-categories.index')->with('success', 'Exam Category successfully updated');
    }

    public function destroy($id)
    {
        $exam_category = ExamCategory::findOrFail($id);

        $this->authorize('delete', $exam_category);

        $exam_category->delete();

        return response()->json(true, 200);
    }

    public function changeOrder()
    {
        $examCategoryIDs = request()->input('exam-categories');

        if ($examCategoryIDs) {
            $index = 1;

            foreach ($examCategoryIDs as $examCategoryID) {
                $exam_category = ExamCategory::find($examCategoryID);

                if ($exam_category) {
                    $exam_category->order = $index;
                    $exam_category->save();
                }

                $index++;
            }
        }
    }
}
