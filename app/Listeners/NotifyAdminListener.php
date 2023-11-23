<?php

namespace App\Listeners;

use App\Events\NotifyAdminEvent;
use App\Mail\SendEmailNotificationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyAdminListener implements ShouldQueue
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
     * @param  NotifyAdminEvent  $event
     * @return void
     */
    public function handle(NotifyAdminEvent $event)
    {
        $admins = ['admin1@example.com', 'admin1@example.com'];
        Mail::to($admins)->send(new SendEmailNotificationEmail($event));
    }
}
