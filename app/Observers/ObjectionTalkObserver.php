<?php

namespace App\Observers;

use App\Models\Log;
use App\Models\Notification;
use App\Models\ObjectionTalk;
use App\Models\User;

class ObjectionTalkObserver
{
    /**
     * Handle the ObjectionTalk "created" event.
     *
     * @param  \App\Models\ObjectionTalk  $objectionTalk
     * @return void
     */
    public function created(ObjectionTalk $objectionTalk)
    {
        $order = $objectionTalk->order;
        
        $notification_data = [
            'id' => intval($order->id),
            'type' => 'order',
            'hash_code' => $order->hash_code
        ];

        $client =  $order->client;
        $vendor =  $order->vendor;
        $judger_id =  $order->activeJudger;
        $judger = User::findOrFail($judger_id);
        $client_router = route('client.orders.show', $order->hash_code);
        $vendor_router = route('vendor.orders.show', $order->hash_code);
        $title = 'قام المحكم ' . $judger->name . ' بإضافة طلب جديد في الطلب  ' . $order->title;
        Notification::send($client->id, $title, $client_router, null, $notification_data);
        Notification::send($vendor->id, $title, $vendor_router, null, $notification_data);
        sendSms($client->id, 'client_create_objection_talk', $title);
        sendSms($vendor->id, 'client_create_objection_talk', $title);
        Log::store($order->id, 'order', $title);
    }

    /**
     * Handle the ObjectionTalk "updated" event.
     *
     * @param  \App\Models\ObjectionTalk  $objectionTalk
     * @return void
     */
    public function updated(ObjectionTalk $objectionTalk)
    {
        //
    }

    /**
     * Handle the ObjectionTalk "deleted" event.
     *
     * @param  \App\Models\ObjectionTalk  $objectionTalk
     * @return void
     */
    public function deleted(ObjectionTalk $objectionTalk)
    {
        //
    }

    /**
     * Handle the ObjectionTalk "restored" event.
     *
     * @param  \App\Models\ObjectionTalk  $objectionTalk
     * @return void
     */
    public function restored(ObjectionTalk $objectionTalk)
    {
        //
    }

    /**
     * Handle the ObjectionTalk "force deleted" event.
     *
     * @param  \App\Models\ObjectionTalk  $objectionTalk
     * @return void
     */
    public function forceDeleted(ObjectionTalk $objectionTalk)
    {
        //
    }
}
