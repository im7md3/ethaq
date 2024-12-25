<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\Log;
use App\Models\Notification;
use App\Models\Objection;
use App\Models\User;

class ObjectionObserver
{
    /**
     * Handle the Objection "created" event.
     *
     * @param  \App\Models\Objection  $objection
     * @return void
     */
    public function created(Objection $objection)
    {
        $order = $objection->order;
        $notification_data = [
            'id' => intval($order->id),
            'type' => 'order',
            'hash_code' => $order->hash_code
        ];
        $user_id = $objection->user_id == $order->client_id ? $order->vendor_id : $order->client_id;
        $first_judger_id = $order->first_judger_id;
        $second_judger_id = $order->second_judger_id;
        $type_router = auth()->user()->type == 'client' ? 'vendor' : 'client';
        $type_link = auth()->user()->type == 'client' ? 'العميل' : 'المحامي';
        $link = route($type_router . '.orders.show', $order->hash_code);
        $link_judger = route('judger.orders.show', $order->hash_code);
        $title = 'تم إضافة اعتراض على الطلب ' . $order->title . ' من قبل ' . $type_link;
        Notification::send($user_id, $title, $link, null, $notification_data);
        Notification::send($first_judger_id, $title, $link_judger, null, $notification_data);
        sendSms($user_id, $type_router . '_add_objection', $title);
        sendSms($first_judger_id, 'judger_add_objection', $title);
        if ($second_judger_id) {
            Notification::send($second_judger_id, $title, null, $notification_data);
            sendSms($second_judger_id, 'judger_add_objection', $title);
        }
        $contract_amount = $order->activeOffer->amount;
        $amount = $contract_amount * (setting('judger_cost') / 100);
        $tax = setting('activate_taxes') ? $amount * (setting('judger_cost_tax') / 100) : 0;
        $admin_ratio = $amount * (setting('admin_ratio_of_judger') / 100);
        Invoice::store($order, auth()->id(), $order->first_judger_id, $amount, $tax, $admin_ratio, 'judger');
        Log::store($order->id, 'order', $title);
        $users = User::admins()->get();
        $route = route('admin.admin_notifications');
        foreach ($users as $u) {
            Notification::send($u->id, $title, $route, 'new-objection', $notification_data);
        }
    }

    /**
     * Handle the Objection "updated" event.
     *
     * @param  \App\Models\Objection  $objection
     * @return void
     */
    public function updated(Objection $objection)
    {
        $order = $objection->order;
        $notification_data = [
            'id' => intval($order->id),
            'type' => 'order',
            'hash_code' => $order->hash_code
        ];

        if ($objection->isDirty('time')) {
            $order = $objection->order;
            $client_id =  $order->client_id;
            $vendor_id =  $order->vendor_id;
            $client_router = route('client.orders.show', $order->hash_code);
            $vendor_router = route('vendor.orders.show', $order->hash_code);
            $title = 'لقد قام المحكم بإقتراح مدة للطلب ' . $order->title;
            Notification::send($client_id, $title, $client_router, null, $notification_data);
            Notification::send($vendor_id, $title, $vendor_router, null, $notification_data);
            sendSms($client_id, 'vendor_suggested_duration', $title);
            sendSms($client_id, 'client_suggested_duration', $title);

            Log::store($order->id, 'order', $title);
        }
        if ($objection->isDirty('judger_judgment')) {
            $order = $objection->order;
            $client =  $order->client;
            $vendor =  $order->vendor;
            $judger =  $order->firstJudger;
            $client_router = route('client.orders.show', $order->hash_code);
            $vendor_router = route('vendor.orders.show', $order->hash_code);
            $title = 'لقد قام المحكم بإصدار قرار الحكم للطلب ' . $order->title;
            Notification::send($client->id, $title, null, $notification_data);
            Notification::send($vendor->id, $title, $vendor_router, null, $notification_data);
            sendSms($client->id, 'client_judger_judgment', $title);
            sendSms($vendor->id, 'vendor_judger_judgment', $title);
            Log::store($order->id, 'order', $title);
            $order_suspended = $order->suspended;
            foreach ($order_suspended as $suspended) {
                $suspended->update(['status' => 'yes']);
            }
        }
        if ($objection->isDirty('client_decision') or $objection->isDirty('vendor_decision')) {
            if ($objection->client_decision == 'accepted' and $objection->vendor_decision == 'accepted') {
                $order = $objection->order;
                $order->update(['judger_period' => $objection->time]);
            }
        }
        /* مراقبة  قرار العميل على المدة المقترحة */
        if ($objection->isDirty('client_decision')) {
            $order = $objection->order;
            $judger_id =  $order->ActiveJudger;
            $vendor_id =  $order->vendor_id;
            $vendor_router = route('vendor.orders.show', $order->hash_code);
            $judger_router = route('judger.orders.show', $order->hash_code);
            if ($objection->client_decision == 'accepted') {
                $title = 'لقد قام العميل بقبول المدة المقترحة للطلب ' . $order->title;
            } else {
                $title = 'لقد قام العميل برفض المدة المقترحة للطلب ' . $order->title;
            }
            Notification::send($judger_id, $title, $judger_router, null, $notification_data);
            Notification::send($vendor_id, $title, $vendor_router, null, $notification_data);
            sendSms($judger_id, 'judger_decision_client_duration', $title);
            sendSms($vendor_id, 'vendor_decision_client_duration', $title);
            Log::store($order->id, 'order', $title);
        }
        /* مراقبة  قرار المحامي على المدة المقترحة */
        if ($objection->isDirty('vendor_decision')) {
            $order = $objection->order;
            $judger_id =  $order->ActiveJudger;
            $client_id =  $order->client_id;
            $client_router = route('client.orders.show', $order->hash_code);
            $judger_router = route('judger.orders.show', $order->hash_code);
            if ($objection->client_decision == 'accepted') {
                $title = 'لقد قام المحامي بقبول المدة المقترحة للطلب ' . $order->title;
            } else {
                $title = 'لقد قام المحامي برفض المدة المقترحة للطلب ' . $order->title;
            }
            Notification::send($judger_id, $title, $judger_router, null, $notification_data);
            Notification::send($client_id, $title, $client_router, null, $notification_data);
            sendSms($judger_id, 'judger_decision_vendor_duration', $title);
            sendSms($client_id, 'client_decision_vendor_duration', $title);
            Log::store($order->id, 'order', $title);
        }
        if ($objection->isDirty('client_objection')) {
            $order = $objection->order;
            $client =  $order->client;
            $vendor =  $order->vendor;
            $judger =  $order->firstJudger;
            $judger_router = route('judger.orders.show', $order->hash_code);
            $vendor_router = route('vendor.orders.show', $order->hash_code);
            $title = 'قام العميل ' . $client->username . ' بالاعتراض على الحكم في الطلب  ' . $order->title;
            Notification::send($judger->id, $title, $judger_router, null, $notification_data);
            Notification::send($vendor->id, $title, $vendor_router, null, $notification_data);
            sendSms($judger->id, 'judger_objection_client', $title);
            sendSms($vendor->id, 'vendor_objection_client', $title);
            Log::store($order->id, 'order', $title);
        }
        if ($objection->isDirty('vendor_objection')) {
            $order = $objection->order;
            $client =  $order->client;
            $vendor =  $order->vendor;
            $judger =  $order->firstJudger;
            $judger_router = route('judger.orders.show', $order->hash_code);
            $client_router = route('client.orders.show', $order->hash_code);
            $title = 'قام المحامي ' . $vendor->name . ' بالاعتراض على الحكم في الطلب  ' . $order->title;
            Notification::send($judger->id, $title, $judger_router, null, $notification_data);
            Notification::send($client->id, $title, $client_router, null, $notification_data);
            sendSms($judger->id, 'judger_objection_vendor', $title);
            sendSms($client->id, 'client_objection_vendor', $title);
            Log::store($order->id, 'order', $title);
        }
    }

    /**
     * Handle the Objection "deleted" event.
     *
     * @param  \App\Models\Objection  $objection
     * @return void
     */
    public function deleted(Objection $objection)
    {
        //
    }

    /**
     * Handle the Objection "restored" event.
     *
     * @param  \App\Models\Objection  $objection
     * @return void
     */
    public function restored(Objection $objection)
    {
        //
    }

    /**
     * Handle the Objection "force deleted" event.
     *
     * @param  \App\Models\Objection  $objection
     * @return void
     */
    public function forceDeleted(Objection $objection)
    {
        //
    }
}
