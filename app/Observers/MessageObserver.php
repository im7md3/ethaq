<?php

namespace App\Observers;

use App\Models\Message;
use App\Models\Notification;

class MessageObserver
{
    /**
     * Handle the Message "created" event.
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function created(Message $message)
    {
        $order = $message->order;
        $user_type = $message->user_id == $order->client_id ? 'vendor' : 'client';
        $user_id = $message->user_id == $order->client_id ? $message->negotiation->vendor_id : $order->client_id;
        $title = 'استفسار جديد على طلب ' . $order->title . ' من المحامي ' . $message->negotiation->vendor->name;
        $type = auth()->user()->type == 'client' ? 'vendor' : 'client';
        $link = route($type . '.orders.show', $order->hash_code);

        $notification_data = [
            'id' => intval($order->id),
            'type' => 'order',
            'hash_code' => $order->hash_code
        ];

        Notification::send($user_id, $title, $link, null, $notification_data);
        sendSms($user_id, $user_type . '_new_enquiry_on_order', $title);
    }

    /**
     * Handle the Message "updated" event.
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function updated(Message $message)
    {
        //
    }

    /**
     * Handle the Message "deleted" event.
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function deleted(Message $message)
    {
        //
    }

    /**
     * Handle the Message "restored" event.
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function restored(Message $message)
    {
        //
    }

    /**
     * Handle the Message "force deleted" event.
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function forceDeleted(Message $message)
    {
        //
    }
}
