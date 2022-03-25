<?php

namespace App\Admin\Http\Controllers;

use App\Models\Admin;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Builder $builder
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $this->authorize('viewAny', Admin::class);

        if(request()->ajax()) {
            $query = Admin::query()->with('role');

            return DataTables::of($query)
                ->filter(function (\Illuminate\Database\Eloquent\Builder $query) {
                    if (request()->filled('filter.search')) {
                        $query->where(function ($query) {
                            $query
                                ->where('name', 'like', "%" . request('filter.search') . "%")
                                ->orWhere('mobile', 'like', "%" . request('filter.search') . "%")
                                ->orWhere('email', 'like', "%" . request('filter.search') . "%");
                        });
                    }
                    if(request()->filled('filter.status') && request('filter.status') != 'all') {
                        $query->where('active','=', request('filter.status'));
                    }
                })

                ->addColumn('active', function (Admin $admin) {
                    if($admin->active) {
                        return '<span class="badge badge-success">Active</span>';
                    }

                    return '<span class="badge badge-danger">Inactive</span>';
                })
                ->addColumn('action', function ($admin){
                    return view('admin::pages.admins.action', compact('admin'));
                })
                ->rawColumns(['active', 'action'])
                ->make(true);
        }

        $html = $builder->columns([
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'mobile', 'name' => 'mobile', 'title' => 'Mobile'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'role.name', 'name' => 'role.name', 'title' => 'Role'],
            ['data' => 'active', 'name' => 'active', 'title' => 'Status', 'width' => 80],
        ])->addAction(['title' => '', 'class' => 'text-right p-3', 'width' => 70]);

        return view('admin::pages.admins.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Admin::class);

        $roles = Role::all();

        return view('admin::pages.admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // info($request->all());
        $this->authorize('create', Admin::class);

        $this->validate($request, [
            'name' => 'required|max:191',
            'mobile' => 'required',
            'email' => 'required|max:191|unique:admins',
            'role_id' => 'required',
        ]);

        DB::beginTransaction();

        $password = Str::random(8);
        $admin = new Admin();
        $admin->name =  $request->name;
        $admin->mobile =  $request->mobile;
        $admin->email =  $request->email;
        $admin->role_id =  $request->role_id;
        $admin->password =   Hash::make($password);
        $admin->active =   true;
        $admin->save();

//        try{

            $admin->send( $admin,$password );

//        } catch(\Exception $e) {
//
//        return response($e->getMessage(), 422);
//        }

        $roleUser = Role::findOrFail($request->role_id);

        $admin->assignRole($roleUser->name);

        DB::commit();

        return redirect()->route('admin.admins.index')->with('success', "Admin created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /** @var Admin $admin */
        $admin = Admin::findOrFail($id);
        $roles = Role::all();

        $this->authorize('update', $admin);

        return view('admin::pages.admins.edit', compact('admin','roles'));
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
        /** @var Admin $admin */
        $admin = Admin::findOrFail($id);

        $this->authorize('update', $admin);

        $this->validate($request, [
            'name' => 'required|max:191',
            'email' => 'required|max:191|unique:admins,email,'.$id,
            'role_id' => 'required',
        ]);

        $admin->name =  $request->name;
        $admin->email =  $request->email;
        $admin->role_id = $request->role_id;
        $admin->active = $request->is_active ? true : false;
        $admin->save();

        $roleUser = Role::findOrFail($request->role_id);
        $admin->syncRoles($roleUser->name);

        if ($admin->id == auth()->id() && !$admin->hasPermissionTo("admin.viewAny")) {
            return redirect()->route('admin.home')->with('success', "Admin updated");
        }

        return redirect()->route('admin.admins.index')->with('success', "Admin updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /** @var Admin $admin */
        $admin = Admin::findOrFail($id);

        $this->authorize('delete', $admin);

        $admin->delete();

//        return redirect()->route('admins.index')->with('success', "Admin deleted");
        return response()->json(['success' => "Admin deleted"], 200);
    }

    public function check_email_unique(Request $request)
    {
        $admin = Admin::where('email', $request->email)->first();
        if ($admin)
        {
            return response()->json(false);

        }else
        {
            return response()->json(true);

        }

    }
}
