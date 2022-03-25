<?php

namespace App\Console\Commands;

use App\Models\Video;
use Illuminate\Console\Command;
use Vimeo\Vimeo;

class VideoStatusUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:videos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $videos = Video::all();

        foreach ($videos as $video)
        {
            $client_id = config('services.vimeo.client_id');

            $client_secret = config('services.vimeo.client_secret');

            $access_token = config('services.vimeo.vimeo_access_token');

            $lib = new Vimeo($client_id, $client_secret, $access_token);

            $vimeo_video_details = $lib->request($video->vimeo_video_path, ['per_page' => 1], 'GET');


            if( $vimeo_video_details['status'] != 404 ){
                if(array_key_exists('transcode', $vimeo_video_details['body'])){
                    $vimeo_transcode_status = $vimeo_video_details['body']['transcode']['status'];
                    $duration = $vimeo_video_details['body']['duration'];
                    if($vimeo_transcode_status == 'complete')
                    {
                        $video->vimeo_video_json = json_encode($vimeo_video_details);
                        $video->vimeo_transcode_status = $vimeo_transcode_status;
                        $video->duration = $duration;
                        $video->update();
                    }
                }
            }

        }
    }
}
