<?php

namespace App\Observers;

use App\Events\NewNotification;
use App\Jobs\NewNotification as JobsNewNotification;
use App\Jobs\SendFirebaseNotification;
use App\Models\Notification;

class NotificationObserver
{
    /**
     * Handle the Notification "created" event.
     *
     * @param  \App\Models\Notification  $notification
     * @return void
     */
    public function created(Notification $notification)
    {
        $user = $notification->user;
        event(new NewNotification($notification->user_id, $notification));

        $fcmTokens = $user?->fcmTokens()->get();

        if ($fcmTokens and $fcmTokens->count() > 0) {
            foreach ($fcmTokens as $token) {
                if ($token->token != null) {
                    dispatch(new SendFirebaseNotification($notification, $token->token));
                }
            }
        }
    }

    /**
     * Handle the Notification "updated" event.
     *
     * @param  \App\Models\Notification  $notification
     * @return void
     */
    public function updated(Notification $notification)
    {
        //
    }

    /**
     * Handle the Notification "deleted" event.
     *
     * @param  \App\Models\Notification  $notification
     * @return void
     */
    public function deleted(Notification $notification)
    {
        //
    }

    /**
     * Handle the Notification "restored" event.
     *
     * @param  \App\Models\Notification  $notification
     * @return void
     */
    public function restored(Notification $notification)
    {
        //
    }

    /**
     * Handle the Notification "force deleted" event.
     *
     * @param  \App\Models\Notification  $notification
     * @return void
     */
    public function forceDeleted(Notification $notification)
    {
        //
    }
}
