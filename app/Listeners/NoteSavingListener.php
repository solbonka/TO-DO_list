<?php

namespace App\Listeners;

use App\Events\NoteSavingEvent;
use App\Jobs\SendAdminMessageJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NoteSavingListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NoteSavingEvent $event): void
    {
        $note = $event->note;

        SendAdminMessageJob::dispatch($note)->onQueue('admin');
    }
}
