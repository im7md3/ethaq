<?php

namespace App\Observers;

use App\Models\AdvisorFile;
use App\Models\Notification;

class AdvisorFileObserver
{
    /**
     * Handle the AdvisorFile "created" event.
     *
     * @param  \App\Models\AdvisorFile  $advisorFile
     * @return void
     */
    public function created(AdvisorFile $advisorFile)
    {
        //
    }

    /**
     * Handle the AdvisorFile "updated" event.
     *
     * @param  \App\Models\AdvisorFile  $advisorFile
     * @return void
     */
    public function updated(AdvisorFile $advisorFile)
    {
        $user=$advisorFile->user;
        if ($advisorFile->isDirty('status')) {
            if($advisorFile->status=='accepted'){
                $msg='تم قبول المؤهل الخاصة بك وتفعيل العضوية بنجاح في منصة إيثاق';
                sendSms($user->id,'vendor_Accept_or_refused_license',$msg);
                Notification::send($user->id, $msg);
            }elseif($advisorFile->status=='refused'){
                $msg='تم رفض المؤهل بسبب '.$advisorFile->refused_msg;
                sendSms($user->id,'vendor_Accept_or_refused_license',$msg);
                Notification::send($user->id, $msg);
            }
        }
    }

    /**
     * Handle the AdvisorFile "deleted" event.
     *
     * @param  \App\Models\AdvisorFile  $advisorFile
     * @return void
     */
    public function deleted(AdvisorFile $advisorFile)
    {
        //
    }

    /**
     * Handle the AdvisorFile "restored" event.
     *
     * @param  \App\Models\AdvisorFile  $advisorFile
     * @return void
     */
    public function restored(AdvisorFile $advisorFile)
    {
        //
    }

    /**
     * Handle the AdvisorFile "force deleted" event.
     *
     * @param  \App\Models\AdvisorFile  $advisorFile
     * @return void
     */
    public function forceDeleted(AdvisorFile $advisorFile)
    {
        //
    }
}
