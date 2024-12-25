<?php

namespace App\Observers;

use App\Models\Financial;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\SuspendedBalance;
use App\Models\SuspendedBalanceConsulting;
use Ramsey\Uuid\Uuid;

class InvoiceObserver
{
    /**
     * Handle the Invoice "created" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function created(Invoice $invoice)
    {
        $uuid = Uuid::uuid4()->toString();
        $invoice->update(['tamam_id' => $uuid]);
    }

    /**
     * Handle the Invoice "updated" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function updated(Invoice $invoice)
    {
        $order = $invoice->order;
        /* مراقبة فواتير الطلبات */
        if ($invoice->order_type == "App\Models\Order" and $invoice->isDirty('status')) {
            /* *************** if invoice for vendor ***************** */
            /* if ($invoice->status == 'paid' and !$order->objection_id) {
                $client = $invoice->fromUser;
                $vendor = $order->vendor;
                $judger = $order->firstJudger;
                $vendor_amount = $invoice->amount - $invoice->admin_ratio;
                $client->update(['suspended_balance' => $invoice->total]);
                $vendor->update(['suspended_balance' => $vendor_amount]);
                SuspendedBalance::store($order, $invoice->id, $client->id, $vendor->id, $vendor_amount);
                Financial::suspension($client, $order, $invoice->total);
                Financial::suspension($vendor, $order, $vendor_amount);
            } */
            /* *************** if invoice for judger ***************** */
            /* if ($invoice->status == 'paid' and $order->objection_id) {
                $user = $invoice->fromUser;
                $judger = $order->firstJudger;
                $judger_amount = $invoice->amount - $invoice->admin_ratio;
                $user->update(['suspended_balance' => $user->suspended_balance + $invoice->total]);
                $judger->update(['suspended_balance' => $judger->suspended_balance + $judger_amount]);
                SuspendedBalance::store($order, $invoice->id, $user->id, $judger->id, $judger_amount);
                Financial::suspension($user, $order, $invoice->total);
                Financial::suspension($judger, $order, $judger_amount);
            }
             if ($invoice->status == 'refund') {
                $suspended = $invoice->suspended;
                if ($invoice->for_type == 'vendor') {
                    $vendor = $order->vendor;
                    $vendor->update(['suspended_balance' => $vendor->suspended_balance - $suspended->amount]);
                }
                if ($invoice->for_type == 'judger') {
                    $judger = $order->firstJudger;
                    $judger->update(['suspended_balance' => $judger->suspended_balance - $suspended->amount]);
                }
            } */
            /* مراقبة تعديل الفاتورة لتصبح للمحكم الاحتياطي */
            if ($invoice->isDirty('to_id')) {
                $order = $invoice->order;
                $user_id = $order->second_judger_id;
                $title = 'تم إحالة الطلب ' . $order->title . ' إليك بعد انقضاء فترة المحكم الأصلي';
                $route = route('judger.orders.show', $order->hash_code);

                $notification_data = [
                    'id' => intval($order->id),
                    'type' => 'order',
                    'hash_code' => $order->hash_code
                ];

                Notification::send($user_id, $title, $route, null, $notification_data);
                sendSms($user_id, 'judger_forward_the_order_to_you', $title);
            }
        }

        /* مراقبة فواتير الاستشارات */
        if ($invoice->order_type == "App\Models\Consulting" and $invoice->isDirty('status')) {
            $con = $invoice->order;
            if ($invoice->status == 'paid') {
                $con->update(['status'=>'active']);
                $title = 'تم اختيارك في طلب استشارة من قبل العميل ' . $con->client->username;
                $link = route('vendor.consulting.index');
                $notification_data = [
                    'id' => intval($con->id),
                    'type' => 'consulting',
                ];
                Notification::send($con->vendor_id, $title, $link, null, $notification_data);
                sendSms($con->vendor_id, 'vendor_choose_on_consultation', $title);
                $client = $invoice->fromUser;
                $vendor = $invoice->toUser;

                if ($con->status == 'done') {
                    /* $vendor_amount = $invoice->net;
                    $vendor->update(['current_balance' => $vendor->current_balance + $vendor_amount]);
                    Financial::transfer($client, $invoice->order, $vendor_amount);
                    Financial::transfer($vendor, $invoice->order, $vendor_amount); */
                } else {
                   /*  $con->update(['status' => 'active', 'amount' => $invoice->amount - $invoice->admin_ratio]);
                    $client->update(['suspended_balance' => $client->suspended_balance + $invoice->total]);
                    $vendor_amount = $invoice->net;
                    $vendor->update(['suspended_balance' => $vendor->suspended_balance + $vendor_amount]);
                    SuspendedBalance::store($con, $invoice->id, $client->id, $vendor->id, $vendor_amount);
                    Financial::suspension($client, $invoice->order, $invoice->total);
                    Financial::suspension($vendor, $invoice->order, $vendor_amount); */
                }
            }
        }
    }

    /**
     * Handle the Invoice "deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function deleted(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "restored" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function restored(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function forceDeleted(Invoice $invoice)
    {
        //
    }
}
