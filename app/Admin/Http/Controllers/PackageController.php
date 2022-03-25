<?php

namespace App\Admin\Http\Controllers;

use App\Models\Highlight;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\PackageHighlight;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class PackageController extends Controller
{
    public function index(Builder $builder)
    {
        $this->authorize('viewAny', Package::class);

        if (request()->ajax()) {

            $query = Package::query()->with('course');

            return DataTables::of($query)
                ->orderColumn('id', '-id $1')
                ->filter(function ($query) {
                    if (request()->filled('filter.search')) {
                        $query->where(function ($query) {
                            $query->where('name', 'like', '%' . request()->input('filter.search') . '%')
                                ->orWhere('display_name', 'like', '%' . request()->input('filter.search') . '%')
                                ->orWhere('price', 'like', '%' . request()->input('filter.search') . '%')
                                ->orWhere('offer_price', 'like', '%' . request()->input('filter.search') . '%')
                                ->orWhereHas('course', function ($course) {
                                    $course->where('name', 'like', '%' . request('filter.search') . '%');
                                });
                        });
                    }
                    if(request()->filled('filter.status') ) {
                        $query->where(function ($query) {
                            $query->where('is_published', request('filter.status'));
                        });
                    }
                })
                ->editColumn('is_published',function ($package){
                    if(!$package->is_published){
                        return '<span class="badge badge-warning">Unpublished</span>';
                    }

                    return '<span class="badge badge-info">Published</span>';
                })

                ->editColumn('course_id', function ($package) {
                    return $package->course->name;
                })
                ->editColumn('total_videos', function ($package) {
                    return $package->package_videos->count();
                })
                ->editColumn('total_tests', function ($package) {
                    return $package->package_tests->count();
                })
                ->editColumn('action', function ($package) {
                    $packageVideoCount = $package->package_videos->count();
                    $packageTestCount = $package->package_tests->count();
                    $packageDocumentCount = $package->packageDocuments->count();
                    return view('admin::pages.packages.action', compact(
                        'package',
                        'packageDocumentCount',
                        'packageTestCount', 'packageVideoCount'));
                })
                ->editColumn('created_at', function ($package) {
                    return Carbon::parse($package->created_at)->format('d-m-Y');

                })
                ->editColumn('created_by', function ($package) {
                    if(!$package->admin) {
                        return '';
                    }
                    return $package->admin->name;

                })
                ->addColumn('time', function ($package) {
                    return Carbon::parse($package->created_at)->toTimeString();
                })
                ->rawColumns(['action' , 'is_published','time','created_at'])
                ->make(true);
        }

        $tablePackages = $builder->columns([
            ['name' => 'name', 'data' => 'name', 'title' => 'Name'],
            ['name' => 'display_name', 'data' => 'display_name', 'title' => 'Display Name'],
            ['name' => 'course.name', 'data' => 'course.name', 'title' => 'Course'],
            ['name' => 'price', 'data' => 'price', 'title' => 'Price'],
            ['name' => 'offer_price', 'data' => 'offer_price', 'title' => 'Offer Price'],
            ['name' => 'total_videos', 'data' => 'total_videos', 'title' => 'Total Videos'],
            ['name' => 'total_tests', 'data' => 'total_tests', 'title' => 'Total Tests'],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created Date'],
            ['name' => 'created_by', 'data' => 'created_by', 'title' => 'Created By'],
            ['name' => 'time', 'data' => 'time', 'title' => 'Created Time'],
            ['name' => 'is_published', 'data' => 'is_published', 'title' => 'Is Published'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3','searchable' => false, 'orderable' => false]
        ])
        ->orderBy(0, 'desc')
        ->parameters([
            'lengthChange' => false,
            'searching' => false,
            'ordering' => true,
        ]);

        return view('admin::pages.packages.index', compact('tablePackages'));
    }

    public function create()
    {
        $this->authorize('create', Package::class);

        $highlights = Highlight::all();

        return view('admin::pages.packages.create', compact('highlights'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Package::class);
//        return $request->all();
        $this->validate($request, [
            'course_id' => 'required',
            'subjects' => 'nullable',
            'chapters' => 'nullable',
            'name' => 'required|max:191|unique:packages',
            'display_name' => 'required|max:191|unique:packages',
            'image' => 'required',
            'cover_pic' => 'required|dimensions:width=1200,height=600',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'offer_price' => 'numeric|nullable|min:0|lt:'.$request->price,
            'visibility' => 'required',
            'expire_on' => 'required|min:0',
            'package_content' => [
                'required',
                function($attribute, $value, $fail) {
                    $package_content =  json_decode($value,true);
                    if (($package_content['blocks'])==null) {
                        return $fail('This field cannot be empty.');
                    }
                }
            ],
            'requirements' => [
                'required',
                function($attribute, $value, $fail) {
                    $requirements =  json_decode($value,true);
                    if (($requirements['blocks'])==null) {
                        return $fail('This field cannot be empty.');
                    }
                }
            ]

        ]);

        $packageVisibleDates = explode(' - ' ,$request->visibility);

        DB::beginTransaction();

        $package =  new Package();
        $package->course_id = $request->course_id;
        $package->name = $request->name;
        $package->name_slug  = Str::of($request->name)->slug('-');
        $package->display_name = $request->display_name;
        $package->description = $request->description;
        $package->price = $request->price;
        $package->offer_price = $request->offer_price;
        $package->package_content = $request->package_content;
        $package->requirements = $request->requirements;
        $package->visible_from_date = Carbon::parse($packageVisibleDates[0]);
        $package->visible_to_date = Carbon::parse($packageVisibleDates[1]);
        $package->expire_on = $request->expire_on;
        $package->created_by = Auth::user()->id;

        if($request->image){
            $data = $request->image;
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name= Carbon::now()->timestamp.'.png';

            Storage::disk('public')->put("packages/$image_name", $data);
            $package->image = $image_name;
        }

        if ($request->hasFile('cover_pic')) {
            $photo = $request->file('cover_pic');
            $file_extension =  $photo->getClientOriginalExtension();
            $filename = time() . '.' . $file_extension;
            $filePath = $request->file('cover_pic')->storeAs('package_cover_pic', $filename, 'public');
            $package->cover_pic  = $filename;
        }

        $package->save();

        if( $request->package_subjects){
            $subjects  = $request->package_subjects[0];
            $package_subjects = explode(",", $subjects);
            $package->package_subjects()->attach($package_subjects);
        }

        if($request->package_chapters){
            $chapters  = $request->package_chapters[0];
            $package_chapters = explode(",", $chapters);
            $package->package_chapters()->attach($package_chapters);
        }

        if($request->package_highlights){
            foreach($request->package_highlights as $highlight){
                $package->package_highlights()->attach($package->id, ['course_id' => $package->course_id, 'highlight_id' => $highlight]);
            }
        }

        DB::commit();

        return redirect()->route('admin.packages.show', $package->id)->with('success', 'Package successfully created');
    }

    public function show(Request $request, $id)
    {
        $package =  Package::findOrFail($id);

      //  return $package;
        $this->authorize('view', $package);

        $package_categories = PackageCategory::wherePackageId($id)->get();
        $quizes = Question::all();


        $tablePackageVideos = app(Builder::class)->columns([
            ['data' => 'thumbnail', 'name' => 'thumbnail', 'title' => 'Thumbnail','width'=>10,'height'=>100],
            ['data' => 'video.title', 'name' => 'video.title', 'title' => 'Title'],
            ['data' => 'video.name', 'name' => 'video.name', 'title' => 'Video Name'],
            ['data' => 'category_id', 'name' => 'category_id', 'title' => 'Category'],
            ['data' => 'is_demo', 'name' => 'is_demo', 'title' => 'Is Demo'],
            ['data' => 'video_duration', 'name' => 'video_duration', 'title' => 'Duration'],
//            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'p-3','searchable' => false, 'orderable' => false]
        ])->addAction(
            ['title' => '', 'class' => 'text-right p-3', 'width' => 70]
        )->parameters([
            'searching' => true,
            'ordering' => false,
            'lengthChange' => true,
            'bInfo' => false
        ])->ajax(route('admin.packages.videos.index', $id))
            ->setTableId('table-package-videos')
            ->orderBy(0, 'desc');

        $tablePackageStudyMaterials = app(Builder::class)->columns([
            ['data' => 'document.name', 'name' => 'document.name', 'title' => 'Name'],
            ['data' => 'title', 'name' => 'title', 'title' => 'Title'],
            ['data' => 'package_category.name', 'name' => 'package_category.name', 'title' => 'Category'],
//            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3','searchable' => false, 'orderable' => false]
        ])->addAction(
            ['title' => '', 'class' => 'text-right p-3', 'width' => 70]
        )->parameters([
            'searching' => true,
            'ordering' => false,
            'lengthChange' => true,
            'bInfo' => false
        ])->ajax(route('admin.packages.study-materials.index', $id))
            ->setTableId('table-package-study-materials')
            ->orderBy(0, 'desc');

        $tablePackageTests = app(Builder::class)->columns([
            ['name' => 'test.name', 'data' => 'test.name', 'title' => 'Name'],
            ['name' => 'test.display_name', 'data' => 'test.display_name', 'title' => 'Display Name'],
            ['name' => 'category_id', 'data' => 'category_id', 'title' => 'Category'],
            ['data' => 'order', 'name' => 'order', 'title' => 'Order'],
            ['data' => 'course_id', 'name' => 'course_id', 'title' => 'Course'],
            ['data' => 'subject_id', 'name' => 'course_id', 'title' => 'Subject'],
            ['data' => 'chapter_id', 'name' => 'chapter_id', 'title' => 'Chapter'],
            ['data' => 'test.total_questions', 'name' => 'test.total_questions', 'title' => 'Total Questions'],
            ['data' => 'test.total_marks', 'name' => 'test.total_marks', 'title' => 'Total Marks'],
            ['data' => 'test.total_time', 'name' => 'test.total_time', 'title' => 'Total Time'],
//           ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3','searchable' => false, 'orderable' => false]
        ])->addAction(
            ['title' => '', 'class' => 'text-right p-3', 'width' => 70],
        )->parameters([
            'searching' => true,
            'ordering' => false,
            'lengthChange' => true,
            'bInfo' => false
        ])->ajax(route('admin.packages.tests.index', $id))
            ->setTableId('table-package-tests')
            ->orderBy(0, 'desc');

        $tablePackageCategories = app(Builder::class)->columns([
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
//          ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3','searchable' => false, 'orderable' => false]
        ])->addAction(
            ['title' => '', 'class' => 'text-right p-3', 'width' => 70]
        )->parameters([
            'searching' => true,
            'ordering' => false,
            'lengthChange' => true,
            'bInfo' => false
        ])->ajax(route('admin.packages.category.index', $id))
            ->setTableId('table-package-categories')
            ->orderBy(0, 'desc');

        return view('admin::pages.packages.show', compact('package',
            'package_categories',
            'quizes',
            'tablePackageStudyMaterials',
            'tablePackageVideos',
            'tablePackageCategories',
            'tablePackageTests'));
    }

    public function edit($id)
    {
        $package =  Package::findOrFail($id);

        $this->authorize('update', $package);

        $highlights = Highlight::all();

        return view('admin::pages.packages.edit', compact('package', 'highlights'));
    }

    public function update(Request $request, $id)
    {

        $package =  Package::findOrFail($id);

        $this->authorize('update', $package);

        $this->validate($request, [
            'course_id' => 'required',
            'name' => 'required|max:191|unique:packages,name,'.$id,
            'display_name' => 'required|max:191|unique:packages,display_name,'.$id,
            'description' => 'required',
            'price' => 'required|numeric',
            'offer_price' => 'numeric|nullable|min:0|lt:'.$request->price,
            'cover_pic' => 'dimensions:min_width=1200,min_height=600',
            'visibility' => 'required',
            'expire_on' => 'required|min:0',
            'package_content' => [
                'required',
                function($attribute, $value, $fail) {
                    $package_content =  json_decode($value,true);
                    if (($package_content['blocks'])==null) {
                        return $fail('This field cannot be empty.');
                    }
                }
            ],
            'requirements' => [
                'required',
                function($attribute, $value, $fail) {
                    $requirements =  json_decode($value,true);
                    if (($requirements['blocks'])==null) {
                        return $fail('This field cannot be empty.');
                    }
                }
            ]
        ]);

        $packageVisibleDates = explode(' - ' ,$request->visibility);

        DB::beginTransaction();

        $package->course_id = $request->course_id ?? null;
        $package->name = $request->name;
        $package->name_slug  = Str::of($request->name)->slug('-');
        $package->display_name = $request->display_name;
        $package->description = $request->description;
        $package->price = $request->price;
        $package->offer_price = $request->offer_price ?? null;
        $package->package_content = $request->package_content;
        $package->requirements = $request->requirements;
        $package->visible_from_date = Carbon::parse($packageVisibleDates[0]);
        $package->visible_to_date = Carbon::parse($packageVisibleDates[1]);
        $package->expire_on = $request->expire_on;

        if($request->image){
            $data = $request->image;
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name= Carbon::now()->timestamp.'.png';

            Storage::disk('public')->put("packages/$image_name", $data);
            $package->image = $image_name;
        }

        if ($request->hasFile('cover_pic')) {
            $photo = $request->file('cover_pic');
            $file_extension =  $photo->getClientOriginalExtension();
            $filename = time() . '.' . $file_extension;
            $filePath = $request->file('cover_pic')->storeAs('package_cover_pic', $filename, 'public');
            $package->cover_pic  = $filename;
        }

        $package->save();

        $package_highlights = $request->package_highlights;

        foreach ($package_highlights as $key => $package_highlight) {
            $package_highlights[$key] = ['highlight_id' => $package_highlight, 'course_id' => $package->course_id];
        }

        $package->package_highlights()->sync($package_highlights);

        if($request->package_subjects){
            $subjects  = $request->package_subjects[0];
           if($subjects){
               $package_subjects = explode(",", $subjects);
               $package->package_subjects()->sync($package_subjects);
           }
        }

        if($request->package_chapters != null){
            $chapters  = $request->package_chapters[0];
            if($chapters) {
                $package_chapters = explode(",", $chapters);
                $package->package_chapters()->sync($package_chapters);
            }
        }

        DB::commit();
        return redirect()->route('admin.packages.index')->with('success', 'Package successfully updated');
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);

        $this->authorize('delete', $package);

        $package->delete();

        return response()->json(true, 200);
    }

    public function publish(Request $request, $packageId)
    {
        $package = Package::findOrFail($packageId);

        $this->authorize('update', $package);

       $package->is_published = $request->publish;
       $package->save();

        return response()->json($package, 200);
    }

}

