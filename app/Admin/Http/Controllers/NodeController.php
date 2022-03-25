<?php

namespace App\Admin\Http\Controllers;

use App\Models\PackageVideo;
use Vimeo\Vimeo;
use App\Http\Requests\StoreNodeRequest;
use App\Models\Node;
use App\Models\Video;
use App\Services\NodeService;
use Illuminate\Support\Facades\DB;

class NodeController extends Controller
{
    var $nodeService;

    public function __construct(NodeService $nodeService)
    {
        $this->nodeService = $nodeService;
    }

    public function store(StoreNodeRequest $request)
    {
        $this->authorize('create', Node::class);

        if ($request->ajax()) {

            $validated = $request->validated();

            $this->nodeService->store($validated);

            return response()->json(true);
        }
    }

    /**
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        if (request()->ajax()) {

            $node = Node::query()->findOrFail($id);

//            $this->authorize('delete', $node);

            $video = Video::findOrFail($node->model_id);

            $video_id = $video->vimeo_video_path;

            $client_id = config('services.vimeo.client_id');

            $client_secret = config('services.vimeo.client_secret');

            $access_token = config('services.vimeo.vimeo_access_token');

            $domain = config('services.vimeo.domain');

            DB::beginTransaction();

            $lib = new Vimeo($client_id, $client_secret, $access_token, $domain);

            $lib->request($video_id, array(), 'DELETE');

             $package_videos =  PackageVideo::where('video_id', $node->model_id)->get();

             if($package_videos) {

                 PackageVideo::where('video_id', $node->model_id)->delete();
             }

            $video->delete();

            $node->delete();

            DB::commit();

            return response()->json(true);
        }
    }
}
