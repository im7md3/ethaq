<?php

namespace App\Observers;

use App\Models\Financial;
use App\Models\Notification;
use App\Models\User;
use App\Models\Withdrawal;

class WithdrawalObserver
{
    /**
     * Handle the Withdrawal "created" event.
     *
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return void
     */
    public function created(Withdrawal $withdrawal)
    {
        $amount = $withdrawal->amount;
        $user = $withdrawal->user;
        $user->update(['current_balance' => $user->current_balance - $amount, 'suspended_balance' => $user->suspended_balance + $amount]);
        Financial::withdrawal($withdrawal->user_id, $amount);
        $title = 'طلب سحب جديد من ' . $user->name;
        $route = route('admin.withdrawals.index');
        $users = User::admins()->get();
        foreach ($users as $u) {
            Notification::send($u->id, $title, $route, 'new-withdrawal');
        }
    }

    /**
     * Handle the Withdrawal "updated" event.
     *
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return void
     */
    public function updated(Withdrawal $withdrawal)
    {
        $notification_data = [
            'id' => intval($withdrawal->id),
            'type' => 'balance',
        ];

        if ($withdrawal->isDirty('status')) {
            if ($withdrawal->status == 'completed') {
                foreach($withdrawal->invoices as $invoice){
                    $invoice->update(['withdrawn'=>1]);
                }
                $user = $withdrawal->user;
                $type_user = $user->type;
                $amount = $withdrawal->amount;
                $user->update(['suspended_balance' => $user->suspended_balance - $amount]);
                $title = 'تمت عملية سحب مبلغ مقداره ' . $amount . ' بنجاح';
                $route = route($type_user.'.balance');
                Notification::send($user->id, $title, $route, null, $notification_data);
                sendSms($user->id, $type_user . '_success_withdrawal_amount', $title);

                Financial::withdrawalComplete($user->id, $amount);
            }
            if ($withdrawal->status == 'refused') {
                foreach($withdrawal->invoices as $invoice){
                    $invoice->update(['withdrawn'=>0]);
                }
                $user = $withdrawal->user;
                $type_user = $user->type;
                $amount = $withdrawal->amount;
                $user->update(['suspended_balance' => $user->suspended_balance - $amount, 'current_balance' => $user->current_balance + $amount]);
                $title = 'تمت رفض عملية سحب مبلغ مقداره ' . $amount.' بسبب '.$withdrawal->refused_msg;
                $route = route($type_user.'.balance');
                Notification::send($user->id, $title, $route, null, $notification_data);
                sendSms($user->id, $type_user . '_refused_withdrawal_amount', $title);
                Financial::withdrawalRefused($user->id, $amount);
            }
        }
    }

    /**
     * Handle the Withdrawal "deleted" event.
     *
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return void
     */
    public function deleted(Withdrawal $withdrawal)
    {
        //
    }

    /**
     * Handle the Withdrawal "restored" event.
     *
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return void
     */
    public function restored(Withdrawal $withdrawal)
    {
        //
    }

    /**
     * Handle the Withdrawal "force deleted" event.
     *
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return void
     */
    public function forceDeleted(Withdrawal $withdrawal)
    {
        //
    }
}
