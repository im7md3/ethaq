<?php

namespace App\Observers;

use App\Models\Event;
use App\Models\Log;
use App\Models\Notification;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function created(Event $event)
    {
        if (!$event->parent) {

            $order = $event->order;
            $user_id = $order->client_id;
            $link = route('client.orders.show', $order->hash_code);
            $title = 'تم إضافة عمل منفذ جديد للطلب ' . $event->order->title . ' من قبل المحامي';

            $notification_data = [
                'id' => intval($order->id),
                'type' => 'order',
                'hash_code' => $order->hash_code
            ];

            Notification::send($user_id, $title, $link, null, $notification_data);
            sendSms($user_id, 'client_add_new_event', $title);
            Log::store($order->id, 'order', 'تم إضافة عمل منفذ جديد من قبل المحامي');
        }
    }

    /**
     * Handle the Event "updated" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function updated(Event $event)
    {
        //
    }

    /**
     * Handle the Event "deleted" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function deleted(Event $event)
    {
        //
    }

    /**
     * Handle the Event "restored" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function restored(Event $event)
    {
        //
    }

    /**
     * Handle the Event "force deleted" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function forceDeleted(Event $event)
    {
        //
    }
}
