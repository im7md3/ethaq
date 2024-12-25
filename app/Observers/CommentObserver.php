<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\User;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        $typeAr = $comment->user?->type == 'client' ? 'العضو' : "الدعم الفني";
        $ticket = $comment->ticket;
        $title = 'رد جديد على التذكرة ' . $ticket->title . " من " . $typeAr;
        $notification_data = [
            'id' => intval($ticket->id),
            'type' => 'ticket',
        ];
        if (auth()->user()->type == 'admin') {
            $user_route = route('tickets.show', $ticket);
            Notification::send($ticket->user_id, $title, $user_route, 'new-ticket', $notification_data);
        } else {
            $admin_route = route('admin.tickets.show', $ticket);
            $users = User::admins()->get();
            foreach ($users as $u) {
                Notification::send($u->id, $title, $admin_route, 'new-ticket-comment', $notification_data);
            }
        }
    }

    /**
     * Handle the Comment "updated" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        //
    }

    /**
     * Handle the Comment "deleted" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        //
    }

    /**
     * Handle the Comment "restored" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function restored(Comment $comment)
    {
        //
    }

    /**
     * Handle the Comment "force deleted" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function forceDeleted(Comment $comment)
    {
        //
    }
}
