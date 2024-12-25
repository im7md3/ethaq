<?php

namespace App\Observers;

use App\Models\Log;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\User;

class OfferObserver
{
    /**
     * Handle the Offer "created" event.
     *
     * @param  \App\Models\Offer  $offer
     * @return void
     */
    public function created(Offer $offer)
    {
        $user_id = $offer->order->client_id;
        $title = 'لديك عرض جديد على الطلب ' . $offer->order->title . ' من المحامي ' . $offer->vendor->name;
        $link = route('client.orders.show', $offer->order->hash_code);
        $notification_data = [
            'id' => intval($offer->order->id),
            'type' => 'order',
            'hash_code' => $offer->order->hash_code
        ];
        Notification::send($user_id, $title, $link, null, $notification_data);
        sendSms($user_id, 'client_create_offer_on_order', $title);
    }

    /**
     * Handle the Offer "updated" event.
     *
     * @param  \App\Models\Offer  $offer
     * @return void
     */
    public function updated(Offer $offer)
    {
        if ($offer->isDirty('status') == 'accepted') {
            $offer->order->update(['without_judgers' => true]);
            $user_id = $offer->vendor_id;
            $title = 'تم قبول عرضك على الطلب ' . $offer->order->title;
            $link = route('vendor.orders.show', $offer->order->hash_code);
            $notification_data = [
                'id' => intval($offer->order->id),
                'type' => 'order',
                'hash_code' => $offer->order->hash_code
            ];
            Notification::send($user_id, $title, $link, null, $notification_data);
            Log::store($offer->order_id, 'order', 'تم قبول العرض من قبل العميل');
            sendSms($user_id, 'vendor_accept_offer_on_order', $title);
            if ($offer->amount >= 1000) {
                $users = User::admins()->get();
                $route = route('admin.admin_notifications');
                $title = 'الطلب ' . $offer->order->id . 'قيمته أكبر من 1000 ريال ';
                $notification_data = [
                    'id' => intval($offer->order_id),
                    'type' => 'order',
                    'hash_code' => $offer->order->hash_code
                ];
                foreach ($users as $u) {
                    Notification::send($u->id, $title, $route, 'order_greater_1000',$notification_data);
                }
            }
        }
        if ($offer->isDirty('status') == 'rejected') {
            $user_id = $offer->vendor_id;
            $title = 'تم رفض عرضك على الطلب ' . $offer->order->title;
            $link = route('vendor.orders.show', $offer->order->hash_code);
            $notification_data = [
                'id' => intval($offer->order->id),
                'type' => 'order',
                'hash_code' => $offer->order->hash_code
            ];
            Notification::send($user_id, $title, $link, null, $notification_data);
            sendSms($user_id, 'vendor_rejected_offer_on_order', $title);
        }
    }

    /**
     * Handle the Offer "deleted" event.
     *
     * @param  \App\Models\Offer  $offer
     * @return void
     */
    public function deleted(Offer $offer)
    {
        //
    }

    /**
     * Handle the Offer "restored" event.
     *
     * @param  \App\Models\Offer  $offer
     * @return void
     */
    public function restored(Offer $offer)
    {
        //
    }

    /**
     * Handle the Offer "force deleted" event.
     *
     * @param  \App\Models\Offer  $offer
     * @return void
     */
    public function forceDeleted(Offer $offer)
    {
        //
    }
}
