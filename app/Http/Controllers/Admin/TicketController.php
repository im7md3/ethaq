<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\UserNotify;
use App\Traits\JodaResource;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    use JodaResource;

    public $rules = [
        'title' => 'required',
        'type' => 'required|in:orders,activate_mempership,other',
        'description' => 'required',
        'user_id' => 'required',
        'status' => 'sometimes|nullable|in:open,finished,closed',
    ];

    public function index()
    {
        $tickets=Ticket::where(function($q){
            if(request('status')){
                $q->where('status',request('status'));
            }
        })->latest('id')->paginate(10);
        $all=Ticket::count();
        $open=Ticket::where('status','open')->count();
        $closed=Ticket::where('status','closed')->count();
        $finished=Ticket::where('status','finished')->count();
        return view('admin.ticket.index',compact('tickets','all','open','closed','finished'));
    }

    public function storeComment(Request $request)
    {
        $request->validate([
            'comment' => 'required',
            'ticket_id' => 'required',
            'user_id' => 'required',
        ]);

        $comment = Comment::create([
            'comment' => $request->comment,
            'ticket_id' => $request->ticket_id,
            'user_id' => $request->user_id,
        ]);


        /* $ticket = Ticket::findOrFail($request->ticket_id);
        $user = User::findOrFail($ticket->user_id);
        $link = route('tickets.show', $ticket->id);

        $notification_data = [
            'type' => 'ticket',
            'id' => intval($ticket->id),
        ];

        Notification::send($user->id, $comment->comment, $link, null, $notification_data); */

        return redirect()->back()->with('success', trans('app.added'));
    }
}
