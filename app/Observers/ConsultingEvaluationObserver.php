<?php

namespace App\Observers;

use App\Models\ConsultingEvaluation;
use App\Models\Notification;

class ConsultingEvaluationObserver
{
    /**
     * Handle the ConsultingEvaluation "created" event.
     *
     * @param  \App\Models\ConsultingEvaluation  $consultingEvaluation
     * @return void
     */
    public function created(ConsultingEvaluation $consultingEvaluation)
    {
        $title = 'تم تقييمك من قبل العميل في الاستشارة رقم ' . $consultingEvaluation->consulting_id . ' بتقييم ' . $consultingEvaluation->EvaluateName;
        $link = route('vendor.consulting.show', $consultingEvaluation->consulting_id);

        $notification_data = [
            'id' => intval($consultingEvaluation->consulting_id),
            'type' => 'consulting',
        ];

        Notification::send($consultingEvaluation->vendor_id, $title, $link, null, $notification_data);
        sendSms($consultingEvaluation->vendor_id, 'vendor_evaluate_consultation', $title);
    }

    /**
     * Handle the ConsultingEvaluation "updated" event.
     *
     * @param  \App\Models\ConsultingEvaluation  $consultingEvaluation
     * @return void
     */
    public function updated(ConsultingEvaluation $consultingEvaluation)
    {
        //
    }

    /**
     * Handle the ConsultingEvaluation "deleted" event.
     *
     * @param  \App\Models\ConsultingEvaluation  $consultingEvaluation
     * @return void
     */
    public function deleted(ConsultingEvaluation $consultingEvaluation)
    {
        //
    }

    /**
     * Handle the ConsultingEvaluation "restored" event.
     *
     * @param  \App\Models\ConsultingEvaluation  $consultingEvaluation
     * @return void
     */
    public function restored(ConsultingEvaluation $consultingEvaluation)
    {
        //
    }

    /**
     * Handle the ConsultingEvaluation "force deleted" event.
     *
     * @param  \App\Models\ConsultingEvaluation  $consultingEvaluation
     * @return void
     */
    public function forceDeleted(ConsultingEvaluation $consultingEvaluation)
    {
        //
    }
}
