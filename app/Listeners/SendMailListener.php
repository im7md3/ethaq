<?php

namespace App\Listeners;

use App\Events\NewNotification;
use App\Jobs\NewNotification as JobsNewNotification;
use App\Jobs\SendMailJob;
use App\Mail\NewMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewNotification  $event
     * @return void
     */
    public function handle(NewNotification $event)
    {
        $notification=$event->notification;
        
            $job=new SendMailJob($notification);
            dispatch($job);
        
        
    }
}
