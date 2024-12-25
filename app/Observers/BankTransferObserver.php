<?php

namespace App\Observers;

use App\Models\BankTransfer;
use App\Models\Notification;
use App\Models\User;

class BankTransferObserver
{
    /**
     * Handle the BankTransfer "created" event.
     *
     * @param  \App\Models\BankTransfer  $bankTransfer
     * @return void
     */
    public function created(BankTransfer $bankTransfer)
    {
        $notification_data = [
            'id' => intval($bankTransfer->id),
            'type' => 'bankTransfer',
        ];
        $users = User::admins()->get();
        $route = route('admin.bankTransfers.index');
        $title = 'تحويل بنكي جديد من المستخدم  ' . $bankTransfer->user->name;
        foreach ($users as $u) {
            Notification::send($u->id, $title, $route, 'new-bankTransfer', $notification_data);
        }
    }

    /**
     * Handle the BankTransfer "updated" event.
     *
     * @param  \App\Models\BankTransfer  $bankTransfer
     * @return void
     */
    public function updated(BankTransfer $bankTransfer)
    {
        if ($bankTransfer->isDirty('status')) {
            if ($bankTransfer->status == 'accepted') {
                $invoice = $bankTransfer->invoice;
                $order = $invoice->order;
                $invoice->update(['status' => 'paid']);
                $notification_data = [
                    'id' => intval($order->id),
                    'type' => 'order',
                ];
                $route = route('client.orders.show', $order->hash_code);
                $title = 'تم قبول طلب التحويل البنكي للطلب ' . $order->title . ' بنجاح';
                Notification::send($bankTransfer->user_id, $title, $route, null, $notification_data);
            }
            if ($bankTransfer->status == 'rejected') {
                $invoice = $bankTransfer->invoice;
                $order = $invoice->order;
                $notification_data = [
                    'id' => intval($order->id),
                    'type' => 'order',
                ];
                $route = route('client.orders.show', $order->hash_code);
                $title = 'تم رفض طلب التحويل البنكي للطلب ' . $order->title . ' بسبب '.$bankTransfer->rejected_msg;
                Notification::send($bankTransfer->user_id, $title, $route, null, $notification_data);
            }
        }
    }

    /**
     * Handle the BankTransfer "deleted" event.
     *
     * @param  \App\Models\BankTransfer  $bankTransfer
     * @return void
     */
    public function deleted(BankTransfer $bankTransfer)
    {
        //
    }

    /**
     * Handle the BankTransfer "restored" event.
     *
     * @param  \App\Models\BankTransfer  $bankTransfer
     * @return void
     */
    public function restored(BankTransfer $bankTransfer)
    {
        //
    }

    /**
     * Handle the BankTransfer "force deleted" event.
     *
     * @param  \App\Models\BankTransfer  $bankTransfer
     * @return void
     */
    public function forceDeleted(BankTransfer $bankTransfer)
    {
        //
    }
}
