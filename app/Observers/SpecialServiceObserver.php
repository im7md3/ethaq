<?php

namespace App\Observers;

use App\Models\Notification;
use App\Models\SpecialService;
use App\Models\User;

class SpecialServiceObserver
{
    /**
     * Handle the SpecialService "created" event.
     *
     * @param  \App\Models\SpecialService  $specialService
     * @return void
     */
    public function created(SpecialService $specialService)
    {
        $users = User::admins()->get();
        $route = route('admin.admin_notifications');
        $title = 'خدمة خاصة جديدة من العميل ' . $specialService->client->name;
        $notification_data = [
            'id' => intval($specialService->id),
            'type' => 'specialService',
        ];
        foreach ($users as $u) {
            Notification::send($u->id, $title, $route, 'new-specialService', $notification_data);
        }
    }

    /**
     * Handle the SpecialService "updated" event.
     *
     * @param  \App\Models\SpecialService  $specialService
     * @return void
     */
    public function updated(SpecialService $specialService)
    {
        //
    }

    /**
     * Handle the SpecialService "deleted" event.
     *
     * @param  \App\Models\SpecialService  $specialService
     * @return void
     */
    public function deleted(SpecialService $specialService)
    {
        //
    }

    /**
     * Handle the SpecialService "restored" event.
     *
     * @param  \App\Models\SpecialService  $specialService
     * @return void
     */
    public function restored(SpecialService $specialService)
    {
        //
    }

    /**
     * Handle the SpecialService "force deleted" event.
     *
     * @param  \App\Models\SpecialService  $specialService
     * @return void
     */
    public function forceDeleted(SpecialService $specialService)
    {
        //
    }
}
