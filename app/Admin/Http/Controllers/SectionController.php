<?php

namespace App\Admin\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class SectionController extends Controller
{
    public function index(Builder $builder)
    {
        $this->authorize('viewAny', Section::class);

        if (request()->ajax()) {
            $query = Section::query();

            return DataTables::of($query)
                ->filter(function (\Illuminate\Database\Eloquent\Builder $query) {
                    if (request()->filled('filter.search')) {
                        $query->where('name', 'like', '%' . request()->input('filter.search') . '%');
                    }
                })
                ->addColumn('action', function ( $section ) {
                    return view('admin::pages.sections.action', compact('section'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $table= $builder->columns([
            ['name' => 'name', 'data' => 'name', 'title' => 'Name'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3']
        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        return view('admin::pages.sections.index', compact('table'));
    }

    public function create()
    {
        $this->authorize('create', Section::class);

        return view('admin::pages.sections.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Section::class);

        $this->validate($request, [
            'name'           => 'required|unique:sections',
        ]);

        $section = new Section();
        $section->name = $request->name;
        $section->save();

        return redirect()->route('admin.sections.index')->with('success', 'Section successfully created');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $section = Section::findOrFail($id);

        $this->authorize('update', $section);

        return view('admin::pages.sections.edit', compact('section'));
    }

    public function update(Request $request, $id)
    {

        $section = Section::findOrFail($id);

        $this->authorize('update', $section);

        $this->validate($request, [
            'name' => 'required|unique:sections,name,'.$id,
        ]);

        $section->name = $request->name;
        $section->update();

        return redirect()->route('admin.sections.index')->with('success', 'Section successfully updated');

    }

    public function destroy($id)
    {
        $section = Section::findOrFail($id);

        $this->authorize('delete', $section);

        $section->delete();

        return response()->json(true, 200);
    }
}
