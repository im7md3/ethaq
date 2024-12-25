<?php

namespace App\Observers;

use App\Models\JudgerOrder;
use App\Models\Log;
use App\Models\Notification;

class JudgerOrderObserver
{
    /**
     * Handle the JudgerOrder "created" event.
     *
     * @param  \App\Models\JudgerOrder  $judgerOrder
     * @return void
     */
    public function created(JudgerOrder $judgerOrder)
    {
        $order = $judgerOrder->order;
        $user_id = $order->client_id;
        if ($judgerOrder->type == 'main') {
            $title = 'لقد قام المحامي باختيار المحكم الأصلي في الطلب ' . $order->title;
        } else {
            $title = 'لقد قام المحامي باختيار المحكم الاحتياطي في الطلب ' . $order->title;
        }
        sendSms($user_id, 'client_choose_judger', $title);
    }

    /**
     * Handle the JudgerOrder "updated" event.
     *
     * @param  \App\Models\JudgerOrder  $judgerOrder
     * @return void
     */
    public function updated(JudgerOrder $judgerOrder)
    {
        $judger = $judgerOrder->judger;
        $order = $judgerOrder->order;
        $notification_data = [
            'id' => intval($order->id),
            'type' => 'order',
            'hash_code' => $order->hash_code
        ];
        /* ملاحظة ما يحدث بعد تغيير قرار العميل */
        if ($judgerOrder->isDirty('client_decision')) {
            if ($judgerOrder->client_decision == 'accepted') {
                /* تعيين المحكم الاساسي والمحكم الاحتياطي في جدول الطلب */
                if ($judgerOrder->type == 'main') {
                    $order->first_judger_id = $judgerOrder->judger_id;
                } else {
                    $order->second_judger_id = $judgerOrder->judger_id;
                }
                $order->save();
                $vendor_title = 'تم قبول المحكم ' . $judger?->name . ' من قبل العميل ' . auth()->user()->username . ' في الطلب ' . $order->title;
                $judger_title = 'تم اختيارك للتحكيم على الطلب  ' . $order->title;
                $judger_link = route('judger.orders.show', $order->hash_code);


                Notification::send($judger->id, $judger_title, $judger_link, null, $notification_data);
                sendSms($judger->id, 'judger_accept_client_for_judger', $judger_title);
            }
            if ($judgerOrder->client_decision == 'refused') {
                $vendor_title = 'تم رفض المحكم ' . $judger?->name . ' من قبل العميل ' . auth()->user()->username . ' في الطلب ' . $order->title;
            }
            if ($judgerOrder->client_decision !== 'cancel') {
                $vendor_link = route('vendor.orders.show', $order->hash_code);
                Notification::send($order->vendor_id, $vendor_title, $vendor_link, null, $notification_data);
                sendSms($order->vendor_id, 'vendor_accept_client_for_judger', $vendor_title);
                Log::store($order->id, 'order', $vendor_title);
            }
        }

        /* ملاحظة ما يحدث بعد تغيير قرار المحكم */
        if ($judgerOrder->isDirty('judger_decision')) {
            if ($judgerOrder->judger_decision == 'accepted') {
                /* تعيين العقد في جدول الطلب بعد قبول كلا المحكمين */
                if ($order->JudgerAcceptedSelectedJudgers->count() == 2) {
                    $order->update(['judger_period' => $judgerOrder->period]);
                }
                $title = 'لقد قبل المحكم ' . $judger?->name . ' طلب التحكيم على الطلب ' . $order->title;
            }
            if ($judgerOrder->judger_decision == 'refused') {
                /* إلغاء تعيين المحكم الاساسي والمحكم الاحتياطي في جدول الطلب */
                if ($judgerOrder->type == 'main') {
                    $order->first_judger_id = null;
                } else {
                    $order->second_judger_id = null;
                }
                $order->save();
                $title = 'لقد رفض المحكم ' . $judger?->name . ' طلب التحكيم على الطلب ' . $order->title;
            }
            /* ارسال اشعار للعميل والمحكم بقرار المحكم */
            $vendor_link = route('vendor.orders.show', $order->hash_code);
            $client_link = route('client.orders.show', $order->hash_code);

            Notification::send($order->vendor_id, $title, $vendor_link, null, $notification_data);
            Notification::send($order->client_id, $title, $client_link, null, $notification_data);
            sendSms($order->vendor_id, 'vendor_accept_judger_for_judger', $title);
            sendSms($order->client_id, 'client_accept_judger_for_judger', $title);
            Log::store($order->id, 'order', $title);
        }
    }

    /**
     * Handle the JudgerOrder "deleted" event.
     *
     * @param  \App\Models\JudgerOrder  $judgerOrder
     * @return void
     */
    public function deleted(JudgerOrder $judgerOrder)
    {
        //
    }

    /**
     * Handle the JudgerOrder "restored" event.
     *
     * @param  \App\Models\JudgerOrder  $judgerOrder
     * @return void
     */
    public function restored(JudgerOrder $judgerOrder)
    {
        //
    }

    /**
     * Handle the JudgerOrder "force deleted" event.
     *
     * @param  \App\Models\JudgerOrder  $judgerOrder
     * @return void
     */
    public function forceDeleted(JudgerOrder $judgerOrder)
    {
        //
    }
}
