<?php

namespace App\Observers;

use App\Models\Financial;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Refund;

class RefundObserver
{
    /**
     * Handle the Refund "created" event.
     *
     * @param  \App\Models\Refund  $refund
     * @return void
     */
    public function created(Refund $refund)
    {
        $user = $refund->user;

        $notification_data = [
            'id' => intval($refund->id),
            'type' => 'refund',
        ];

        $title = 'طلب استرجاع جديد من ' . $user->name;
        $route = route('admin.refunds.index');
        Notification::send(1, $title, $route, null, $notification_data);
    }

    /**
     * Handle the Refund "updated" event.
     *
     * @param  \App\Models\Refund  $refund
     * @return void
     */
    public function updated(Refund $refund)
    {
        $order = $refund->order;
        $notification_data = [
            'id' => intval($refund->id),
            'type' => 'balance',
        ];
        $invoices = $order->invoices()->where('from_id', $refund->user_id)->get();
        if ($refund->isDirty('status')) {
            if ($refund->status == 'completed') {
                /* change invoices status to refund */
                foreach ($invoices as $invoice) {
                    $invoice->update(['status' => 'refund']);
                }
                /* Notification and Financial to user */
                $user = $refund->user;
                $type_user = $user->type;
                $amount = $refund->amount;
                $title = 'تمت عملية استرجاع مبلغ مقداره ' . $amount . ' بنجاح';
                $route = route('balance');
                Notification::send($user->id, $title, $route, null, $notification_data);
                sendSms($user->id, $type_user . '_success_refund_amount', $title);
                Financial::refundComplete($user->id, $amount);
                $user->update(['suspended_balance' => $user->suspended_balance - $invoice->total, 'current_balance' => $user->current_balance + $amount]);
            }
            if ($refund->status == 'refused') {
                $user = $refund->user;
                $type_user = $user->type;
                $amount = $refund->amount;
                $title = 'تمت رفض عملية استرجاع مبلغ مقداره ' . $amount;
                $route = route('balance');
                Notification::send($user->id, $title, $route, null, $notification_data);
                sendSms($user->id, $type_user . '_refused_refund_amount', $title);
                Financial::refundRefused($user->id, $amount);
            }
        }
    }

    /**
     * Handle the Refund "deleted" event.
     *
     * @param  \App\Models\Refund  $refund
     * @return void
     */
    public function deleted(Refund $refund)
    {
        //
    }

    /**
     * Handle the Refund "restored" event.
     *
     * @param  \App\Models\Refund  $refund
     * @return void
     */
    public function restored(Refund $refund)
    {
        //
    }

    /**
     * Handle the Refund "force deleted" event.
     *
     * @param  \App\Models\Refund  $refund
     * @return void
     */
    public function forceDeleted(Refund $refund)
    {
        //
    }
}
