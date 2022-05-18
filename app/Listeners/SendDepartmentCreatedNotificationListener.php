<?php

namespace App\Listeners;

use App\Events\DepartmentCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendDepartmentCreatedNotificationListener implements ShouldQueue
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
     * @param  \App\Events\DepartmentCreatedEvent  $event
     * @return void
     */
    public function handle(DepartmentCreatedEvent $event)
    {
        //
    }
}
