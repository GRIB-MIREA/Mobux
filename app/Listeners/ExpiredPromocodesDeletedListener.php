<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Events\NotificationCreated;
use App\Notifications\ExpiredPromocodesDeleted;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ExpiredPromocodesDeletedListener implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
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
     * @param  object  $event
     * @return void
     */
    public function handle(NotificationCreated $event)
    {
        foreach ($event->deletedPromocodes as $promocode) {
            Notification::send($promocode->admin, new ExpiredPromocodesDeleted($promocode));
        }
    }
}
