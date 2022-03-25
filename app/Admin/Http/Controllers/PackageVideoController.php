<?php

namespace App\Admin\Http\Controllers;
use App\Models\Node;
use App\Models\PackageCategory;
use App\Models\PackageStudyMaterial;
use App\Models\PackageVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PackageVideoController extends Controller
{
    public function index(Builder $builder, $id)
    {
        $this->authorize('viewAny', PackageVideo::class);

        if (request()->ajax()) {

            $package_videos = PackageVideo::with('package_category')
                ->whereHas('package_category')
                ->whereHas('video')
                ->where('package_id', $id)
                ->get();

            return DataTables::of($package_videos)
                ->editColumn('video.name', function ($package_video) {
                    if(!$package_video->video){
                        return '';
                    }
                   return '<a href="#">'.$package_video->video->name.'</a>';
                })
                ->editColumn('video.title', function ($package_video) {
                    if(!$package_video->video){
                        return '';
                    }
                    return '<a href="#">'.$package_video->video->title.'</a>';
                })
                ->editColumn('category_id', function ($package_video) {
                    if(!$package_video->package_category){
                        return '';
                    }
                    return $package_video->package_category->name;
                })
                ->editColumn('is_demo', function ($package_video) {
                    if(!$package_video->is_demo){
                        return '';
                    }
                    return '<span class="badge badge-info">Demo</span>';
                })
                ->editColumn('thumbnail', function ($package_video) {

                    return '<div><img width="50" height="50" src="'.$package_video->thumbnail.'"></div>';
                })
                ->addColumn('action', function ($package_video) {
                    return view('admin::pages.packages.videos.action',compact('package_video'));
                })
                ->rawColumns(['thumbnail','video.name','video.title','action', 'is_demo'])
                ->make(true);
        }
    }

    public function store(Request $request, $package_id)
    {
        $this->authorize('create', PackageVideo::class);


        $this->validate($request, [
            'package_category_id' => 'required',
            'videos' => 'required',
            'thumbnail' => 'required|dimensions:max_width=700,max_height=500'
        ]);

        $videos = $request->input('videos');

        foreach ($videos as $video){
            if($video != null){
                $video_files =  explode(',', $video);
                foreach ($video_files as $video_file){
                    $package_video = new PackageVideo();
                    $package_video->package_id = $package_id;
                    $package_video->category_id = $request->package_category_id;
                    $package_video->video_id = Node::findOrFail($video_file)->video->id;
                    $package_video->is_demo = $request->is_demo ? true : false;

                    if ($request->hasFile('thumbnail')) {
                        $photo = $request->file('thumbnail');
                        $file_extension =  $photo->getClientOriginalExtension();
                        $filename = time() . '.' . $file_extension;
                        $filePath = $request->file('thumbnail')->storeAs('package_video_thumbnails', $filename, 'public');
                        $package_video->thumbnail  = $filename;
                    }

                    $package_video->save();
                }
            }
        }

        return redirect()->route('admin.packages.show', $package_id)->with('success', 'Package video successfully created');
    }

    public function destroy($packageId, $videoId)
    {
        $package_video = PackageVideo::wherePackageId($packageId)
            ->where('video_id', $videoId)
            ->first();
        $category_id  = $package_video->category_id;

        $package_category_videos = PackageVideo::where('category_id', $category_id)->get();

        $this->authorize('delete', $package_video);

        DB::beginTransaction();

        if($package_category_videos->count() > 1){

            $package_video->delete();
        }else{

            // Delete Category

            $package_category = PackageCategory::findOrFail($category_id);
            $package_category->delete();

            // delete study materials under category

            $package_category_study_materials = PackageStudyMaterial::where('category_id', $category_id)->get();
            if($package_category_study_materials) {
                PackageStudyMaterial::where('category_id', $category_id)->delete();
            }

            $package_video->delete();
        }
        DB::commit();

        return response()->json(true, 200);
    }

    public function edit(Request $request, $package_id, $id)
    {
        $package_video = PackageVideo::findOrFail($id);
        $package_categories = PackageCategory::where('package_id', $package_id)->get();

      //  $this->authorize('update', $package_video);
        return view('admin::pages.packages.videos.edit', compact('package_video','package_categories'));

    }


    public function update(Request $request, $package_id, $id) {

        $package_video = PackageVideo::findOrFail($id);

      //  $this->authorize('update', $package_video);
        $request->validate([

            'category_id' => 'required',
            'thumbnail' => 'dimensions:max_width=700,max_height=500'

        ]);


        $package_video->category_id = $request->category_id;
        $package_video->is_demo = $request->is_demo ? true : false;

        if ($request->hasFile('thumbnail')) {

            $photo = $request->file('thumbnail');
            $file_extension =  $photo->getClientOriginalExtension();
            $filename = time() . '.' . $file_extension;
            $filePath = $request->file('thumbnail')->storeAs('package_video_thumbnails', $filename, 'public');
            $package_video->thumbnail  = $filename;

        }
        $package_video->save();

        return redirect()->route('admin.packages.show', $package_id)->with('success', 'Package video successfully updated');
    }
}
