<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('user_id', auth()->user()->id)->get();
        return responseApi(true, '', ['tickets' => $tickets]);
    }


    public function show(Ticket $ticket)
    {
        if ($ticket->comments) {
            $ticket_comments = $ticket->comments->where('read_at', null)->first();
            if ($ticket_comments) {
                $ticket_comments->update([
                    'read_at' => NOW()
                ]);
            }
        }
        return responseApi(true, '', ['ticket' => $ticket->load('comments.user')]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'type' => 'required|in:orders,activate_mempership,other',
            'description' => 'required',
            'user_id' => 'required',
            'status' => 'sometimes|nullable|in:open,finished,closed',
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        Ticket::create($request->all());
        return responseApi(true, 'تم إضافة التذكرة بنجاح');
    }

    public function storeComment(Request $request, Ticket $ticket)
    {
        $request->validate([
            'comment' => 'required',
        ]);
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $comment = Comment::create([
            'comment' => $request->comment,
            'ticket_id' => $ticket->id,
            'user_id' => auth()->user()->id,
        ]);

        $users = User::where('type', 'admin')->get();

        $notification_data = [
            'type' => 'ticket',
            'id' => intval($ticket->id),
        ];

        foreach ($users as $user) {
            $link = route('admin.tickets.show', $ticket->id);
            Notification::send($user->id, $comment->comment, $link, null, $notification_data);
        }
        return responseApi(true, 'تم إضافة التعليق بنجاح.');
    }
}
