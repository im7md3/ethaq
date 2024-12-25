<?php

namespace App\Observers;

use App\Models\License;
use App\Models\Notification;

class LicenseObserver
{
    /**
     * Handle the License "created" event.
     *
     * @param  \App\Models\License  $license
     * @return void
     */
    public function created(License $license)
    {
        //
    }

    /**
     * Handle the License "updated" event.
     *
     * @param  \App\Models\License  $license
     * @return void
     */
    public function updated(License $license)
    {
        $user=$license->user;
        if ($license->isDirty('status')) {
            if($license->status=='accepted'){
                $msg='تم قبول رخصة المحاماة الخاصة بك وتفعيل العضوية بنجاح في منصة إيثاق';
                sendSms($user->id,'vendor_Accept_or_refused_license',$msg);
                Notification::send($user->id, $msg);
            }elseif($license->status=='refused'){
                $msg='تم رفض رخصتك بسبب '.$license->refused_msg;
                sendSms($user->id,'vendor_Accept_or_refused_license',$msg);
                Notification::send($user->id, $msg);
            }
        }
    }

    /**
     * Handle the License "deleted" event.
     *
     * @param  \App\Models\License  $license
     * @return void
     */
    public function deleted(License $license)
    {
        //
    }

    /**
     * Handle the License "restored" event.
     *
     * @param  \App\Models\License  $license
     * @return void
     */
    public function restored(License $license)
    {
        //
    }

    /**
     * Handle the License "force deleted" event.
     *
     * @param  \App\Models\License  $license
     * @return void
     */
    public function forceDeleted(License $license)
    {
        //
    }
}
