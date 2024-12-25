<?php

namespace App\Observers;

use App\Events\MessageEvent;
use App\Events\SendMessageEvent;
use App\Models\ConsultingMessages;
use App\Models\Notification;

class ConsultingMessagesObserver
{
    /**
     * Handle the ConsultingMessages "created" event.
     *
     * @param  \App\Models\ConsultingMessages  $consultingMessages
     * @return void
     */
    public function created(ConsultingMessages $consultingMessages)
    {
        $from=$consultingMessages->fromUser;
        $to=$consultingMessages->toUser;
        $title = 'رسالة جديدة في الاستشارة رقم ' . $consultingMessages->consulting_id . ' من  ' . $from->name;
        $link = route($to->type.'.consulting.show', $consultingMessages->consulting_id);
        $notification_data = [
            'id' => intval($consultingMessages->consulting_id),
            'type' => 'consulting',
        ];
        Notification::send($to->id, $title, $link, null, $notification_data);
        sendSms($to->id, 'vendor_evaluate_consultation', $title);
    }

    /**
     * Handle the ConsultingMessages "updated" event.
     *
     * @param  \App\Models\ConsultingMessages  $consultingMessages
     * @return void
     */
    public function updated(ConsultingMessages $consultingMessages)
    {
        //
    }

    /**
     * Handle the ConsultingMessages "deleted" event.
     *
     * @param  \App\Models\ConsultingMessages  $consultingMessages
     * @return void
     */
    public function deleted(ConsultingMessages $consultingMessages)
    {
        //
    }

    /**
     * Handle the ConsultingMessages "restored" event.
     *
     * @param  \App\Models\ConsultingMessages  $consultingMessages
     * @return void
     */
    public function restored(ConsultingMessages $consultingMessages)
    {
        //
    }

    /**
     * Handle the ConsultingMessages "force deleted" event.
     *
     * @param  \App\Models\ConsultingMessages  $consultingMessages
     * @return void
     */
    public function forceDeleted(ConsultingMessages $consultingMessages)
    {
        //
    }
}
