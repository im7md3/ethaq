<?php

namespace App\Observers;

use App\Models\Event;
use App\Models\Log;
use App\Models\Notification;
use App\Models\OrderProtest;
use App\Models\User;

class OrderProtestObserver
{
    /**
     * Handle the Event "created" event.
     *
     * @param  \App\Models\Event  $event
     * @return void
     */
    public function created(OrderProtest $OrderProtest)
    {
        $user = auth()->user();
        $order = $OrderProtest->order;
        $typeAr = $user == $order->client_id ? "العميل" : "المحامي";
        $to_user = $user == $order->client_id ? $order->vendor : $order->client;
        $link = route($to_user . '.orders.show', $order->hash_code);
        $title = 'تم إضافة اعتراض جديد للطلب ' . $order->title . ' من قبل ' . $typeAr . " " . $user->name;
        $notification_data = [
            'id' => intval($order->id),
            'type' => 'order',
            'hash_code' => $order->hash_code
        ];

        Notification::send($to_user->id, $title, $link, null, $notification_data);
        Log::store($order->id, 'order', 'تم إضافة اعتراض جديد من قبل ' . $typeAr);

        $admins = User::admins()->get();
        $route = route('admin.admin_notifications');
        foreach ($admins as $a) {
            Notification::send($a->id, $title, $route, 'new-protest', $notification_data);
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
