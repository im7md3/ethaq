<?php

namespace App\Observers;

use App\Models\Notification;
use App\Models\SpecialServiceMessage;
use App\Models\User;

class SpecialServiceMessageObserver
{
    /**
     * Handle the SpecialServiceMessage "created" event.
     *
     * @param  \App\Models\SpecialServiceMessage  $specialServiceMessage
     * @return void
     */
    public function created(SpecialServiceMessage $specialServiceMessage)
    {
        $typeAr = $specialServiceMessage->user?->type == 'client' ? 'العميل' : "الدعم الفني";
        $service = $specialServiceMessage->service;
        $title = 'رد جديد على الخدمة الخاصة ' . $service->title . " من " . $typeAr;
        $notification_data = [
            'id' => intval($service->id),
            'type' => 'specialService',
        ];
        if (auth()->user()->type == 'client') {
            $admin_route = route('admin.specialServices.show', $service);
            $users = User::admins()->get();
            foreach ($users as $u) {
                Notification::send($u->id, $title, $admin_route, 'new-specialService', $notification_data);
            }
        } else {
            $client_route = route('client.specialServices.show', $service);
            Notification::send($service->client_id, $title, $client_route, 'new-specialService', $notification_data);
        }
    }

    /**
     * Handle the SpecialServiceMessage "updated" event.
     *
     * @param  \App\Models\SpecialServiceMessage  $specialServiceMessage
     * @return void
     */
    public function updated(SpecialServiceMessage $specialServiceMessage)
    {
        //
    }

    /**
     * Handle the SpecialServiceMessage "deleted" event.
     *
     * @param  \App\Models\SpecialServiceMessage  $specialServiceMessage
     * @return void
     */
    public function deleted(SpecialServiceMessage $specialServiceMessage)
    {
        //
    }

    /**
     * Handle the SpecialServiceMessage "restored" event.
     *
     * @param  \App\Models\SpecialServiceMessage  $specialServiceMessage
     * @return void
     */
    public function restored(SpecialServiceMessage $specialServiceMessage)
    {
        //
    }

    /**
     * Handle the SpecialServiceMessage "force deleted" event.
     *
     * @param  \App\Models\SpecialServiceMessage  $specialServiceMessage
     * @return void
     */
    public function forceDeleted(SpecialServiceMessage $specialServiceMessage)
    {
        //
    }
}
