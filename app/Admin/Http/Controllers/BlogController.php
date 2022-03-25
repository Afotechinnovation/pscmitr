<?php

namespace App\Admin\Http\Controllers;

use App\Models\Blog;
use App\Models\Node;
use App\Models\RelatedBlog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Rules\Required;
use function React\Promise\all;

class BlogController extends Controller
{

    public function index(Builder $builder)
    {
        $this->authorize('viewAny', Blog::class);

        if (request()->ajax()) {

            if(!Auth::user()->hasPermissionTo('videos.view')){

                $query = Blog::query()->with('category')
                    ->where('blog_type', Blog::BLOG_TYPE_ARTICLE)
                    ->orderBy('created_at', 'desc');

            }  else {
                $query = Blog::query()->with('category')->orderBy('created_at', 'desc');
            }


            return DataTables::of($query)
                ->filter(function (\Illuminate\Database\Eloquent\Builder $query) {
                    if (request()->filled('filter.search')) {
                        $query
                            ->where('title', 'like', '%' . request()->input('filter.search') . '%')
                            ->orWhere('author', 'like', '%' . request()->input('filter.search') . '%');

                        $query->orWhereHas('category', function( $category)  {
                            $category->where('name', 'like', '%'. request('filter.search') . '%');
                             });

                    }
                })
                ->editColumn('category_id', function ($query) {
                    if(! $query->category){
                        return '-';
                    }
                    return $query->category->name;
                })
                ->editColumn('image', function ($query) {

                    return '<div><img width="50" height="50" src="'.$query->image.'"></div>';
                })
                ->editColumn('cover_pic', function ($query) {

                    return '<div><img width="50" height="50" src="'.$query->cover_pic.'"></div>';
                })
                ->editColumn('blog_type', function ($query) {
                    return ucfirst($query->blog_type);
                })
                ->editColumn('is_published', function ($query) {

                    if(!$query->is_published){
                        return '<span class="badge badge-warning">Unpublished</span>';
                    }

                    return '<span class="badge badge-info">Published</span>';
                })
                ->addColumn('action', function ($blog) {
                    return view('admin::pages.blogs.action', compact('blog'));
                })
                ->rawColumns(['action', 'image', 'cover_pic','is_published'])
                ->make(true);
        }

        $table = $builder->columns([
            ['data' => 'title', 'name' => 'title', 'title' => 'Name'],
            ['data' => 'author', 'name' => 'author', 'title' => 'Author'],
            ['data' => 'blog_type', 'name' => 'blog_type', 'title' => 'Type'],
            ['data' => 'category_id', 'name' => 'category_id', 'title' => 'Category'],
            ['data' => 'image', 'name' => 'image', 'title' => 'Image'],
            ['data' => 'is_published', 'name' => 'is_published', 'title' => 'Is Published'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'class' => 'text-right p-3']
        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        return view('admin::pages.blogs.index', compact('table'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', Blog::class);

        $blogs = Blog::all();

        if(Auth::user()->hasPermissionTo('videos.view')){
            $blogTypes =  Blog::$blogTypes;
            $article = 0;
        }
       else{
            $article = 1;
            $blogTypes = 'ARTICLE';
        }

        return view('admin::pages.blogs.create', compact('blogs', 'blogTypes', 'article'));
    }

    public function store(Request $request)
    {

        $this->authorize('create', Blog::class);

        $request->validate([
            'title'         => 'required|unique:blogs',
            'author'        => 'required',
            'category_id'   => 'required',
            'image'         => 'required',
            'blog_type'     =>'required',
            'cover_pic'     => 'dimensions:min_width=1200,min_height=600,max_width=1600,max_height=800',
            'body' => [
                'required',
                function($attribute, $value, $fail) {
                $body =  json_decode($value,true);
                    if (($body['blocks'])==null) {
                        return $fail('Body cannot be empty.');
                    }
                }
            ]
        ]);

        if($request->video) {
            $video_file = $request->input('video');
            $videoId = Node::findOrFail($video_file)->video->id;
        }
            DB::beginTransaction();

            $blog= new Blog();
            $blog->title      = $request->input('title');
            $blog->name_slug  = Str::of($request->title)->slug('-');
            $blog->author     = $request->input('author');
            $blog->blog_type  = $request->input('blog_type');
            $blog->category_id = $request->input('category_id');
            $blog->body        = $request->input('body');
            if($request->video) {
                $blog->video_id = $videoId;
            }

            if($request->image){
                $data = $request->image;
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);
                $image_name= Carbon::now()->timestamp. rand(1,9999) .'.png';

                Storage::disk('public')->put("blog_image/$image_name", $data);
                $blog->image = $image_name;
            }

           if ($request->cover_pic) {
                $photo = $request->file('cover_pic');
                $file_extension =  $photo->getClientOriginalExtension();
                $filename = time() . '.' . $file_extension;
                $filePath = $request->file('cover_pic')->storeAs('blog_cover_pic', $filename, 'public');
                $blog->cover_pic  = $filename;
           }
            $blog->save();

        if($request->related_blogs){

            foreach($request->related_blogs as $related_blog){
                $blog->relatedBlogs()->attach($blog->id, ['blog_id' => $blog->id, 'related_blog_id' => $related_blog]);
            }
        }
        DB::commit();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog successfully created');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);

        $related_blogs = RelatedBlog::with('blog')
           ->whereHas('blog')
            ->where('blog_id' , $id)
            ->get();

        $articles = Blog::where('id','!=',$id)->get();

        if(Auth::user()->hasPermissionTo('videos.view')){

            $blogTypes =  Blog::$blogTypes;
            $blogtypeArticle = 0;

        }
        else{

            $blogtypeArticle = 1;
            $blogTypes = 'ARTICLE';
        }

        $this->authorize('update', $blog);

        return view('admin::pages.blogs.edit', compact('blog','related_blogs','articles','blogTypes','blogtypeArticle'));
    }

    public function update(Request $request, $id)
    {

        $blog = Blog::findOrFail($id);

         $this->authorize('update', $blog);

        $request->validate([
            'title' => 'required|max:191|unique:blogs,title,'.$id,
            'author' => 'required',
            'category_id' => 'required',
            'blog_type'  => 'required',
            'cover_pic' => 'dimensions:min_width=1200,min_height=600,max_width=1600,max_height=800',
            'body' => [
                'required',
                function($attribute, $value, $fail) {
                    $body =  json_decode($value,true);
                    if (($body['blocks'])==null) {
                        return $fail('Body cannot be empty.');
                    }
                }
            ]
        ]);

        DB::beginTransaction();


        if($request->video) {
            $video_file = $request->input('video');
            $videoId = Node::findOrFail($video_file)->video->id;
        }

        $blog->title = $request->input('title');
        $blog->name_slug  = Str::of($request->title)->slug('-');
        $blog->author = $request->input('author');
        $blog->category_id = $request->input('category_id');
        $blog->body = $request->input('body');
        $blog->blog_type = $request->input('blog_type');
        if($request->video) {
            $blog->video_id = $videoId;
            $blog->cover_pic = null;
        }

        if($request->image){
            $data = $request->image;
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name= Carbon::now()->timestamp. rand(1,9999) .'.png';

            Storage::disk('public')->put("blog_image/$image_name", $data);
            $blog->image = $image_name;
        }

        if ($request->hasFile('cover_pic')) {
            $photo = $request->file('cover_pic');
            $file_extension =  $photo->getClientOriginalExtension();
            $filename = time() . '.' . $file_extension;
            $filePath = $request->file('cover_pic')->storeAs('blog_cover_pic', $filename, 'public');
            $blog->cover_pic  = $filename;
            $blog->video_id = null;
        }

        $blog->update();

        $related_blogs = $request->related_blogs;

        $blog->relatedBlogs()->sync($related_blogs);

        DB::commit();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog successfully updated');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        $this->authorize('delete', $blog);

        $blog->delete();

        return response()->json(true, 200);
    }

    public function publish(Request $request, $blogId)
    {
        $blog = Blog::findOrFail($blogId);

        $this->authorize('update', $blog);

        $blog->is_published = $request->publish;
        $blog->save();

        return response()->json($blog, 200);
    }

    public function imageStore() {

        if (request()->hasFile('image')) {
            $image = request()->file('image');

            $fileName = 'IMAGE_' . time() . '.' .$image->getClientOriginalExtension();
            $image->storeAs('public/body_images/', $fileName);

            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => url('storage/body_images') .'/' . $fileName
                ]
            ]);
        }

        return response()->json([
            'success' => 0
        ]);

    }
}
