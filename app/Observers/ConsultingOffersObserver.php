<?php

namespace App\Observers;

use App\Models\ConsultingOffers;
use App\Models\Notification;

class ConsultingOffersObserver
{
    /**
     * Handle the ConsultingOffers "created" event.
     *
     * @param  \App\Models\ConsultingOffers  $consultingOffers
     * @return void
     */
    public function created(ConsultingOffers $consultingOffers)
    {

        $consulting = $consultingOffers->consulting;
        $vendor = $consultingOffers->vendor;
        $title = ' قام المحامي ' . $vendor->name . ' بإضافة عرض جديد على الاستشارة رقم ' . $consulting->id;
        $link = route('client.consulting.show', $consulting->id);
        $notification_data = [
            'id' => intval($consulting->id),
            'type' => 'consulting',
        ];

        Notification::send($consulting->client_id, $title, $link, null, $notification_data);
        sendSms($consulting->client_id, 'client_create_offer_on_consultation', $title);
    }

    /**
     * Handle the ConsultingOffers "updated" event.
     *
     * @param  \App\Models\ConsultingOffers  $consultingOffers
     * @return void
     */
    public function updated(ConsultingOffers $consultingOffers)
    {
        if ($consultingOffers->isDirty('status')) {
            if ($consultingOffers->status == 'accepted') {
                $con = $consultingOffers->consulting;
                $con->update(['status' => 'pending', 'amount' => $consultingOffers->amount, 'vendor_id' => $consultingOffers->vendor_id, 'offer_id' => $consultingOffers->id]);
                $title = 'قام العميل ' . $con->client->username . ' بقبول عرضك على الاستشارة رقم ' . $con->id;
                $link = route('vendor.consulting.show', $con->id);

                $notification_data = [
                    'id' => intval($con->id),
                    'type' => 'consulting',
                ];

                Notification::send($con->vendor_id, $title, $link, null, $notification_data);
                sendSms($con->vendor_id, 'vendor_accepted_on_consultation', $title);
            }
        }
    }

    /**
     * Handle the ConsultingOffers "deleted" event.
     *
     * @param  \App\Models\ConsultingOffers  $consultingOffers
     * @return void
     */
    public function deleted(ConsultingOffers $consultingOffers)
    {
        //
    }

    /**
     * Handle the ConsultingOffers "restored" event.
     *
     * @param  \App\Models\ConsultingOffers  $consultingOffers
     * @return void
     */
    public function restored(ConsultingOffers $consultingOffers)
    {
        //
    }

    /**
     * Handle the ConsultingOffers "force deleted" event.
     *
     * @param  \App\Models\ConsultingOffers  $consultingOffers
     * @return void
     */
    public function forceDeleted(ConsultingOffers $consultingOffers)
    {
        //
    }
}
