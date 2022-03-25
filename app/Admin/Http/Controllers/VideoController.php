<?php

namespace App\Admin\Http\Controllers;

use App\Admin\Services\VimeoVideoService;
use App\Models\Node;
use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Vimeo\Vimeo;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class VideoController extends Controller
{
    var $vimeoService;

    /**
     * DeityController constructor.
     * @param VimeoVideoService $vimeoService
     */

    public function __construct(VimeoVideoService $vimeoService)
    {
        $this->vimeoService = $vimeoService;
    }

    public function index(Builder $builder)
    {
        $this->authorize('viewAny', Video::class);

        if (request()->ajax()) {
            $query = Node::query()->where('model', 1);

            return DataTables::of($query)
                ->filter(function ($query) {
                    $parentID = request()->input('filter.parent_id');
                    if (request()->filled('filter.parent_id')) {
                        $query->where('parent_id', $parentID);
                    }

                    if (request()->filled('filter.search')) {
                        $query->where('name', 'like', '%' . request()->input('filter.search') . '%');
                    }
                })
                ->addColumn('name', 'admin::pages.nodes.name')
                ->addColumn('type', function ($query) {
                    if ($query->type == Node::TYPE_FOLDER) {
                        return 'Folder';
                    }

                    return 'File';
                })
                ->addColumn('created_at', function ($query) {
                    return $query->created_at->toFormattedDateString();
                })
                ->addColumn('action', 'admin::pages.nodes.action')

                ->addColumn('vimeo_transcode_status', function ($node){
                    if($node->type == Node::TYPE_FILE){
                        if(!$node->video){
                            return '';
                        }
                        return $node->video->vimeo_transcode_status ?? null;
                    }
                    return '-';
                })
                ->addColumn('duration', function ($node){
                    if($node->type == Node::TYPE_FILE){
                        if(!$node->video){
                            return '';
                        }
                        return $node->video->duration ?? null;
                    }
                    return '-';
                })
                ->rawColumns(['name', 'action', 'name'])
                ->make(true);
        }

        $table = $builder->columns([
            ['name' => 'name', 'data' => 'name', 'title' => 'Name', 'width' => '40%'],
            ['name' => 'type', 'data' => 'type', 'title' => 'Type',  'width' => '10%'],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created At', 'width' => '10%'],
            ['name' => 'vimeo_transcode_status', 'data' => 'vimeo_transcode_status', 'title' => 'Status', 'width' => '10%'],
            ['name' => 'duration', 'data' => 'duration', 'title' => 'Duration', 'width' => '10%'],
            ['name' => 'action', 'data' => 'action', 'title' => '', 'width' => '10%']
        ])->parameters([
            'searching' => false,
            'lengthChange' => false,
            'ordering' => false
        ]);

        return view('admin::pages.videos.index', compact('table'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Video::class);

        $validated = $request->validate([
            'file' => 'required',
            'title' => 'required'
        ]);

        if (!$request->hasFile('file')) {
            return redirect()->back();
        }

        $file = $request->file('file');
        $title = $request->input('title');
        $parent_id = $request->input('parent_id');

        $fileName = $file->getClientOriginalName();

        $pathName = str_replace(' ', '-', $fileName);

        DB::beginTransaction();

        $video = new Video();
        $video->name = $fileName;
        $video->title = $title;
        $video->user_id = $request->user()->id;
        $video->folder_id = $parent_id;
        $video->save();

        $path = $video->id . '-' . $pathName;

        $file->storeAs('videos', $path, ['disk' => 'public']);

        $video_id = $this->vimeoService->send($title, $path);

        $privacy = $this->vimeoService->setPrivacy($video_id);

        $client_id = config('services.vimeo.client_id');

        $client_secret = config('services.vimeo.client_secret');

        $access_token = config('services.vimeo.vimeo_access_token');

        $lib = new Vimeo($client_id, $client_secret, $access_token);

        $vimeo_video_details = $lib->request($video_id, ['per_page' => 1], 'GET');

        $vimeo_transcode_status = $vimeo_video_details['body']['transcode']['status'];

        info($vimeo_transcode_status);

        $videoFolder = Video::findOrFail($video->id);
        $videoFolder->title = $title;
        $videoFolder->vimeo_video_path = $video_id;
        $videoFolder->vimeo_video_json = json_encode($vimeo_video_details);
        $videoFolder->vimeo_transcode_status = $vimeo_transcode_status;
        $videoFolder->update();

        $node = new Node();
        $node->name = $fileName;
        $node->type = Node::TYPE_FILE;
        $node->parent_id = $parent_id ?? 0;
        $node->model = 1;
        $node->model_id = $video->id;
        $node->save();

        DB::commit();

        return redirect()->route('admin.videos.index')->with('success', 'Video added successfully');
    }

    public function VimeoFileStore(Request $request)
    {
        $this->authorize('create', Video::class);

        $validated = $request->validate([
            'vimeo_url' => 'required',
            'title' => 'required'
        ]);

        $file = $request->file('file');
        $title = $request->input('title');
        $parent_id = $request->input('parent_id');
        $vimeo_url = $request->input('vimeo_url');
        $name = $title.'-'. substr($vimeo_url,18);
        $video_id = "/videos" .substr($vimeo_url,17);


        DB::beginTransaction();

        $video = new Video();
        $video->name = $name;
        $video->title = $title;
        $video->user_id = $request->user()->id;
        $video->folder_id = $parent_id;
        $video->save();

        $client_id = config('services.vimeo.client_id');

        $client_secret = config('services.vimeo.client_secret');

        $access_token = config('services.vimeo.vimeo_access_token');

        $lib = new Vimeo($client_id, $client_secret, $access_token);

        $vimeo_video_details = $lib->request($video_id, ['per_page' => 1], 'GET');

        $vimeo_transcode_status = $vimeo_video_details['body']['transcode']['status'];

        $videoFolder = Video::findOrFail($video->id);
        $videoFolder->title = $title;
        $videoFolder->vimeo_video_path = $video_id;
        $videoFolder->vimeo_video_json = json_encode($vimeo_video_details);
        $videoFolder->vimeo_transcode_status = $vimeo_transcode_status;
        $videoFolder->update();

//        return $vimeo_video_details;

        $node = new Node();
        $node->name = $name;
        $node->type = Node::TYPE_FILE;
        $node->parent_id = $parent_id ?? 0;
        $node->model = 1;
        $node->model_id = $video->id;
        $node->save();

        DB::commit();

        return redirect()->route('admin.videos.index')->with('success', 'Video added successfully');
    }

    public function show(Request $request, $id)
    {

        $node = Node::findOrFail($id);

        $video = Video::findOrFail($node->model_id);

        $this->authorize('view', $video);

        $client_id = config('services.vimeo.client_id');

        $client_secret = config('services.vimeo.client_secret');

        $access_token = config('services.vimeo.vimeo_access_token');

        $lib = new Vimeo($client_id, $client_secret, $access_token);

        $vimeo_video_details = $lib->request($video->vimeo_video_path, ['per_page' => 1], 'GET');

        return response()->json($vimeo_video_details);

    }
}
