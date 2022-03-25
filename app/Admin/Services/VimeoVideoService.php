<?php

namespace App\Admin\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Vimeo\Vimeo;

class VimeoVideoService
{
    public function send($title, $file)
    {
        $client_id = config('services.vimeo.client_id');

        $client_secret = config('services.vimeo.client_secret');

        $access_token = config('services.vimeo.vimeo_access_token');

        $url = Storage::disk('public')->path('videos/'. $file);

        $lib = new Vimeo($client_id, $client_secret, $access_token);

        $response = $lib->upload($url, [
            'name' => $title,
            'privacy' => [
                'view' => 'disable'
            ]
        ]);

        return $response;
    }

public function setPrivacy($video_id) {

   // $client->request($uri . 'videos/{video_id}/privacy/domains/example.com', 'PUT');

    $client_id = config('services.vimeo.client_id');

    $client_secret = config('services.vimeo.client_secret');

    $access_token = config('services.vimeo.vimeo_access_token');

    $domain = config('services.vimeo.domain');

    $lib = new Vimeo($client_id, $client_secret, $access_token, $domain);

   $lib->request($video_id. '/privacy/domains/'.$domain,  ['per_page' => 1],'PUT');

   $response = $lib->request($video_id, array(
            'privacy' => array(
                'embed' => 'whitelist'
            )
        ), 'PATCH');

    return $response;
}

}
