<?php

namespace moum\Listeners;

use moum\Events\OldUserLogin;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use moum\Services\OSS;
use GuzzleHttp\Client;
use moum\Models\User;

class UpdateUserProfileImageUrl implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OldUserLogin  $event
     * @return void
     */
    public function handle(OldUserLogin $event)
    {
        Log::info('UpdateUserProfileImageUrl: '. $event->profile_image_url);
        if( empty($event->profile_image_url) )
        {
            return ;
        }

        $client = new Client();
        $res = $client->request('GET', $event->profile_image_url);
        $data = $res->getBody()->getContents();
        $code = $res->getStatusCode();
        if( $code == '200')
        {
            $extension = strrchr($event->profile_image_url, '.');
            $filename = md5($data).$extension;

            OSS::uploadContent($filename, $data);
            Log::info($filename);

            $user = User::find($event->userId);
            $user->profile_image_url = $filename;
            $user->save();
        }
    }
}
