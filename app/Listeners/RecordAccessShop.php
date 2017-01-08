<?php

namespace moum\Listeners;

use moum\Events\AccessShopEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use moum\Models\AccessShop;

class RecordAccessShop implements ShouldQueue
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
     * @param  AccessShop  $event
     * @return void
     */
    public function handle(AccessShopEvent $event)
    {
        Log::info("access shop event fire.");
        $action = new AccessShop;
        $action->shop_id = $event->shop->id;
        $action->user_id = $event->arr['user_id'];
        $action->client_id = $event->arr['client_id'];
        $action->uuid = $event->arr['uuid'];
        $action->save();
        Log::info('finished');

        return true;
    }
}
