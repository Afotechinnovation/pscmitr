<?php

namespace App\Admin\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class RoleController extends Controller
{
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $query = Role::query()->withCount('permissions');

            return DataTables::of($query)
                ->filter(function (\Illuminate\Database\Eloquent\Builder $query) {
                    if (request()->filled('filter.search')) {
                        $query->where('name', 'like', '%' . request()->input('filter.search') . '%');
                    }

                })
                ->addColumn('action', function ($role){
                    return view('admin::pages.roles.action', compact('role'));
                })
                ->rawColumns(['action', 'count'])
                ->make(true);
        }

        $html = $builder->columns([
            ['data' => 'name', 'name' => 'name', 'title' => 'Name', 'searchable' => true],
            ['data' => 'permissions_count', 'name' => 'permissions_count', 'title' => 'Total Permission', 'searchable' => true],
        ])->addAction(
            ['title' => '', 'class' => 'text-right p-3', 'width' => 70]
        )->parameters([
            'ordering' => false,
        ]);

        return view('admin::pages.roles.index', compact('html'));
    }

    public function create()
    {
        $permissions = Permission::all();

        return view('admin::pages.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {

        $validated = $this->validate($request, [
            'name' => 'required|max:191|unique:roles',
            'permissions' => 'required|array',
        ]);

        $role = new Role();
        $role->name = $request->input('name');
        $role->guard_name = 'admin';
        $role->save();
        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('admin.roles.index')->with('success', "Role created");
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $permissions = Permission::all();

        return view('admin::pages.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);


        $validated = $this->validate($request, [
            'name' => 'required|max:191|unique:roles,name,'.$role->id,
            'permissions' => 'required|array',
        ]);

        $role->name = $validated['name'];
        $role->guard_name = 'admin';
        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('admin.roles.index')->with('success', "Role updated");
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        $role->delete();

        $role->permissions()->where('id', $id)->wherePivot('role_id', $id)->detach();


    }
}
