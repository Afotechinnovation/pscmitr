<?php

namespace App\Admin\Http\Controllers;

use App\Models\Testimonial;
use Carbon\Carbon;
use Yajra\DataTables\Html\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TestimonialController extends Controller
{

    public function index(Builder $builder)
    {
        $this->authorize('viewAny', Testimonial::class);


        if (request()->ajax()) {
            $testimonial = Testimonial::query();
            return DataTables::of($testimonial)
                ->filter(function ($testimonial) {
                    if (request()->filled('filter.search')) {
                        $testimonial->where(function ($testimonial) {
                            $testimonial->where('name', 'like', '%'. request('filter.search') . '%');
                            $testimonial->orWhere('designation', 'like', '%'. request('filter.search') . '%');
                            $testimonial->orWhere('rating', 'like', '%'. request('filter.search') . '%');
                        });
                    }

                })
                ->editColumn('image', function ($testimonial ) {

                    return '<div><img width="50" height="50" src="'.$testimonial->image.'"></div>';
                })
                ->addColumn('action', function ($testimonial){
                    return view('admin::pages.testimonials.action', compact('testimonial'));
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        $table = $builder->columns([
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'designation', 'name' => 'designation', 'title' => 'Designation'],
            ['data' => 'image', 'name' => 'image', 'title' => 'Image'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3']
        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        return view('admin::pages.testimonials.index', compact('table'));
    }

    public function create()
    {
        $this->authorize('create', Testimonial::class);

        return view('admin::pages.testimonials.create');
    }

    public function store(Request $request, Testimonial $testimonial)
    {
        $this->authorize('create', Testimonial::class);

        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|dimensions:max_width=300,max_height=300',
            'rating' => 'required|lte:5',
            'body'      => 'required',

        ]);

        $testimonial->name = $request->input('name');
        $testimonial->designation = $request->input('designation');
        $testimonial->body = $request->input('body');
        $testimonial->rating = $request->input('rating');

        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $file_extension =  $photo->getClientOriginalExtension();
            $filename = time() . '.' . $file_extension;
            $filePath = $request->file('image')->storeAs('testimonials', $filename, 'public');
            $testimonial->image  = $filename;
        }

        $testimonial->save();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial successfully created');
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $this->authorize('update', $testimonial);

        return view('admin::pages.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, $id)
    {

        $request->all();
        $testimonial = Testimonial::findOrFail($id);

        $this->authorize('update', $testimonial);

        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|dimensions:max_width=300,max_height=300',
            'rating' => 'required|lte:5',
            'body'      => 'required',
//            'body' => [
//                'required',
//                function($attribute, $value, $fail) {
//                    $body =  json_decode($value,true);
//                    if (($body['blocks'])==null) {
//                        return $fail('Body cannot be empty.');
//                    }
//                }
//            ]

        ]);

        $testimonial->name = $request->input('name');
        $testimonial->designation = $request->input('designation');
        $testimonial->body = $request->input('body');
        $testimonial->rating = $request->input('rating');

        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $file_extension =  $photo->getClientOriginalExtension();
            $filename = time() . '.' . $file_extension;
            $filePath = $request->file('image')->storeAs('testimonials', $filename, 'public');
            $testimonial->image  = $filename;
        }
        $testimonial->update();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial successfully updated');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $this->authorize('update', $testimonial);

        $testimonial->delete();

        return response()->json(true, 200);
    }
}
