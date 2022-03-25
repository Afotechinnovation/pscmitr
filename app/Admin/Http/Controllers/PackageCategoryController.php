<?php

namespace App\Admin\Http\Controllers;
use App\Models\PackageCategory;
use App\Models\PackageStudyMaterial;
use App\Models\PackageVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PackageCategoryController extends Controller
{
    public function index(Builder $builder, $id)
    {
        $this->authorize('viewAny', PackageCategory::class);

        $package_categories = PackageCategory::query()
            ->wherePackageId($id)
            ->with('package')
            ->get();

        if (request()->ajax()) {

            return DataTables::of($package_categories)
                ->addColumn('action', function ($package_categories) {
                    return view('admin::pages.packages.categories.action', compact('package_categories'));
                })
                ->rawColumns(['name', 'action'])
                ->make(true);
        }
    }


    public function store(Request  $request, $package_id)
    {
        $this->validate($request, [

            'category_name' => [
                'required',
                Rule::unique('package_categories','name')->where(function ($query) use($package_id) {
                    $query->where('package_id', $package_id)
                        ->where('deleted_at', ! null);
                }),
            ],

        ]);

        $package_category = new PackageCategory();
        $package_category->package_id = $package_id;
        $package_category->name = $request->category_name;
        $package_category->save();

        return redirect()->route('admin.packages.show', $package_id)->with('success', 'Package category created');

    }

    public function destroy($package_id, $id)
    {
        $package_categories = PackageCategory::wherePackageId($package_id)
            ->where('id', $id)
            ->first();

        $this->authorize('delete', $package_categories);

        DB::beginTransaction();

        $package_study_materials = PackageStudyMaterial::where('category_id', $id)->get();
        if($package_study_materials){

            PackageStudyMaterial::where('category_id', $id)->delete();
        }

        $package_videos = PackageVideo::where('category_id', $id)->get();
        if($package_videos) {

            PackageVideo::where('category_id', $id)->delete();
        }

        $package_categories->delete();

        DB::commit();

        return response()->json(true, 200);
    }

}
