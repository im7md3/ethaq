<?php

namespace App\Observers;

use App\Models\Notification;
use App\Models\Ticket;
use App\Models\User;

class TicketObserver
{
    /**
     * Handle the Ticket "created" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function created(Ticket $ticket)
    {
        $notification_data = [
            'id' => intval($ticket->id),
            'type' => 'ticket',
        ];
        $users = User::admins()->get();
        $route = route('admin.admin_notifications');
        $title = 'تذكرة جديدة من ' . $ticket->user->name;
        foreach ($users as $u) {
            Notification::send($u->id, $title, $route, 'new-ticket', $notification_data);
        }
    }

    /**
     * Handle the Ticket "updated" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function updated(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "deleted" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function deleted(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "restored" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function restored(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function forceDeleted(Ticket $ticket)
    {
        //
    }
}
