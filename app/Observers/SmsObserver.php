<?php

namespace App\Observers;

use App\Models\Sms;
use App\Service\Oursms;

class SmsObserver
{
    /**
     * Handle the Sms "created" event.
     *
     * @param  \App\Models\Sms  $sms
     * @return void
     */
    public function created(Sms $sms)
    {
    }

    /**
     * Handle the Sms "updated" event.
     *
     * @param  \App\Models\Sms  $sms
     * @return void
     */
    public function updated(Sms $sms)
    {
        //
    }

    /**
     * Handle the Sms "deleted" event.
     *
     * @param  \App\Models\Sms  $sms
     * @return void
     */
    public function deleted(Sms $sms)
    {
        //
    }

    /**
     * Handle the Sms "restored" event.
     *
     * @param  \App\Models\Sms  $sms
     * @return void
     */
    public function restored(Sms $sms)
    {
        //
    }

    /**
     * Handle the Sms "force deleted" event.
     *
     * @param  \App\Models\Sms  $sms
     * @return void
     */
    public function forceDeleted(Sms $sms)
    {
        //
    }
}
