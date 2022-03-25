<?php

namespace App\Admin\Http\Controllers;
use App\Models\PackageCategory;
use App\Models\PackageStudyMaterial;
use App\Models\PackageVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PackageStudyMaterialController extends Controller
{
    public function index(Builder $builder, $id)
    {
        $this->authorize('viewAny', PackageStudyMaterial::class);

        if (request()->ajax()) {

            $package_study_materials = PackageStudyMaterial::wherePackageId($id)
                ->with('package','package_category','document')
                ->whereHas('package')
                ->whereHas('package_category')
                ->whereHas('document')
                ->get();


            return DataTables::of($package_study_materials)
                ->addColumn('action', function ($package_study_material){
                    return view('admin::pages.packages.documents.action', compact('package_study_material'));
                })
                ->rawColumns(['document.name', 'action'])
                ->make(true);
        }
    }


    public function store(Request $request, $package_id)
    {
        $this->authorize('create', PackageStudyMaterial::class);

        $this->validate($request, [
            'document_package_category_id' => 'required',
            'documents' => 'required',
            'title'     => 'required',
            'body'      => 'required|max:200'
        ]);

        $documents = $request->input('documents');

        foreach ($documents as $document){
            if($document != null){
                $document_files =  explode(',', $document);
                foreach ($document_files as $document_file){
                    $package_document = new PackageStudyMaterial();
                    $package_document->package_id = $package_id;
                    $package_document->category_id = $request->document_package_category_id;
                    $package_document->title = $request->title;
                    $package_document->body = $request->body;
                    $package_document->document_id = $document_file;
                    $package_document->save();
                }
            }
        }

        return redirect()->route('admin.packages.show', $package_id)->with('success', 'Study material successfully created');
    }

    public function destroy($packageId, $documentId)
    {
        $package_study_material = PackageStudyMaterial::wherePackageId($packageId)
            ->where('document_id', $documentId)
            ->first();

        $this->authorize('delete', $package_study_material);

        $category_id = $package_study_material->category_id;

        $package_category_study_materials = PackageStudyMaterial::where('category_id', $category_id)->get();

        DB::beginTransaction();
        if($package_category_study_materials->count() > 1) {

            $package_study_material->delete();

        }else {

            //DELETE THE PACKAGE-CATEGORY
            $package_category = PackageCategory::findOrFail($category_id);

            $package_category->delete();

             //delete videos under the category too
            $package_category_videos = PackageVideo::where('category_id', $category_id)->get();
            if($package_category_videos) {
                PackageVideo::where('category_id', $category_id)->delete();
            }

            $package_study_material->delete();
        }
        DB::commit();

        return response()->json(true, 200);
    }

}
