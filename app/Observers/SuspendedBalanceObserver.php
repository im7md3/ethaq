<?php

namespace App\Observers;

use App\Models\Financial;
use App\Models\SuspendedBalance;

class SuspendedBalanceObserver
{
    /**
     * Handle the SuspendedBalance "created" event.
     *
     * @param  \App\Models\SuspendedBalance  $suspendedBalance
     * @return void
     */
    public function created(SuspendedBalance $suspendedBalance)
    {
        //
    }

    /**
     * Handle the SuspendedBalance "updated" event.
     *
     * @param  \App\Models\SuspendedBalance  $suspendedBalance
     * @return void
     */
    public function updated(SuspendedBalance $suspendedBalance)
    {
        /* if ($suspendedBalance->isDirty('status')) {
            $invoice = $suspendedBalance->invoice;
            $from_user = $suspendedBalance->fromUser;
            $to_user = $suspendedBalance->toUser;
            if ($suspendedBalance->status == 'yes') {
                if ($suspendedBalance->invoice->order_type == 'App\Models\Order') {
                    if ($invoice->for_type == 'vendor') {
                        $from_user->update(['suspended_balance' => $from_user->suspended_balance - $invoice->total]);
                        $to_user->update(['suspended_balance' => $to_user->suspended_balance - $suspendedBalance->amount, 'current_balance' => $to_user->current_balance + $suspendedBalance->amount]);
                    }
                    if ($invoice->for_type == 'judger') {
                        $from_user->update(['suspended_balance' => $from_user->suspended_balance - $invoice->total]);
                        $to_user->update(['suspended_balance' => $to_user->suspended_balance - $suspendedBalance->amount, 'current_balance' => $to_user->current_balance + $suspendedBalance->amount]);
                    }
                } elseif ($suspendedBalance->invoice->order_type == 'App\Models\Consulting') {
                    $from_user->update(['suspended_balance' => $from_user->suspended_balance - $invoice->total]);
                    $to_user->update(['suspended_balance' => $to_user->suspended_balance - $suspendedBalance->amount, 'current_balance' => $to_user->current_balance + $suspendedBalance->amount]);
                }


                Financial::transfer($from_user, $invoice->order, $suspendedBalance->amount);
                Financial::transfer($to_user, $invoice->order, $suspendedBalance->amount);
            }
            if ($suspendedBalance->status == 'cancel') {
                if (($suspendedBalance->invoice->order_type == 'App\Models\Consulting')) {
                    $from_user->update(['suspended_balance' => $from_user->suspended_balance - $invoice->total,'current_balance' => $from_user->current_balance + $invoice->total]);
                    $to_user->update(['suspended_balance' => $to_user->suspended_balance - $suspendedBalance->amount]);
                }
            }
        } */
    }

    /**
     * Handle the SuspendedBalance "deleted" event.
     *
     * @param  \App\Models\SuspendedBalance  $suspendedBalance
     * @return void
     */
    public function deleted(SuspendedBalance $suspendedBalance)
    {
        //
    }

    /**
     * Handle the SuspendedBalance "restored" event.
     *
     * @param  \App\Models\SuspendedBalance  $suspendedBalance
     * @return void
     */
    public function restored(SuspendedBalance $suspendedBalance)
    {
        //
    }

    /**
     * Handle the SuspendedBalance "force deleted" event.
     *
     * @param  \App\Models\SuspendedBalance  $suspendedBalance
     * @return void
     */
    public function forceDeleted(SuspendedBalance $suspendedBalance)
    {
        //
    }
}
