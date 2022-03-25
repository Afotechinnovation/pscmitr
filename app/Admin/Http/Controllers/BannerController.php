<?php

namespace App\Admin\Http\Controllers;
use App\Models\Banner;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use DB;
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $this->authorize('viewAny', Banner::class);

        $banners = Banner::query();
        $banners->orderBy('order');

        if (request()->ajax()) {
            return DataTables::of($banners)
                ->orderColumn('id', 'id $1')
                ->filter(function (\Illuminate\Database\Eloquent\Builder $banners) {
                    if (request()->filled('filter.search')) {
                        $banners->where(function ($banners) {
                            $banners
                                ->where('title', 'like', "%" . request('filter.search') . "%")
                                ->orWhere('link', 'like', "%" . request('filter.search') . "%");
                        });
                    }
                    if(request()->filled('filter.status') && request('filter.status') != 'all') {
                        $banners->where('status','=', request('filter.status'));
                    }
                })
                ->editColumn('image', function($banner) {
                    if ($banner->image) {
                        return '<span><img src="'. $banner->image . '" class="rounded-square" width="80" height="40"></span>';
                    }
                    return '';
                })
                ->editColumn('order', function($banner) {
                    return '<div class="order">' . $banner->order . '<input type="hidden" class="banner-id" value="' . $banner->id . '"></div>';
                })
                ->editColumn('link', function($banner) {
                    return '<a target="_blank" href="'. $banner->link . '">' . $banner->link . '</a>';
                })
                ->editColumn('status',function ($package){
                    if($package->status == 1){
                        return '<span class="badge badge-success">Active</span>';
                    }

                    return '<span class="badge badge-danger">Inactive</span>';
                })
                ->addColumn('action', function ($banner) {
                    return view('admin::pages.banners.action', compact('banner'));
                })
                ->rawColumns(['action','image','order','link','status'])
                ->make(true);
        }

        $bannersTable = $builder->columns([
            ['data' => 'image', 'name' => 'image', 'title' => 'Image'],
            ['data' => 'order', 'name' => 'order', 'title' => 'Order'],
            ['data' => 'title', 'name' => 'title', 'title' => 'Title'],
            ['data' => 'link', 'name' => 'link', 'title' => 'Link'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
//            ['data' => 'user.name', 'name' => 'user.name', 'title' => 'Created By'],
            ['data' => 'action', 'name' => 'action', 'title' => '','orderable' => false]
        ]);

        return view('admin::pages.banners.index', compact('bannersTable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Banner::class);

        return view('admin::pages.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->authorize('create', Banner::class);

        $this->validate($request,[
            'image' => 'required',
            'title' => 'nullable',
            'link' => 'url|nullable'
        ]);

        $count = Banner::all()->count();

        $banner =  new Banner();
        $banner->title = $request->title;
        $banner->link = $request->link;
        $banner->order = $count+1;
        if($request->status == Banner::ENABLED){

            Banner::query()->update(['status' => 0]);

            $banner->status = $request->status;
        }
        else{
            $banner->status = $request->status;
        }

        if($request->image){
            $data = $request->image;
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name= Carbon::now()->timestamp.'.png';

            Storage::disk('public')->put("banners/$image_name", $data);
            $banner->image = $image_name;
        }

        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Banner successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::find($id);

        $this->authorize('update', $banner);

        return view('admin::pages.banners.edit', compact('banner'));
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

        $banner =  Banner::find($id);

        $this->authorize('update', $banner);

        $this->validate($request,[
            'title' => 'nullable',
            'link' => 'url|nullable'
        ]);

        $banner->title = $request->title;
        $banner->link = $request->link;

        if($request->has('status')){

            Banner::query()->update(['status' => Banner::DISABLED]);

            $banner->status = Banner::ENABLED;
        }

        if($request->image){
            $data = $request->image;
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name= Carbon::now()->timestamp.'.png';

            Storage::disk('public')->put("banners/$image_name", $data);
            $banner->image = $image_name;
        }

        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        $this->authorize('delete', $banner);

        $banner->delete();

        return response()->json(true, 200);
    }

    public function changeOrder(){

        $bannerIDs = request()->input('banners');

        if ($bannerIDs) {
            $index = 1;

            foreach ($bannerIDs as $bannerID) {
                $banner = Banner::find($bannerID);

                if ($banner) {
                    $banner->order = $index;
                    $banner->save();
                }

                $index++;
            }
        }

        return response()->json(true, 200);
    }


}
