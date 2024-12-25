<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\JodaResource;
use Illuminate\Support\Facades\Crypt;

class TicketController extends Controller
{
    use JodaResource;

    public function show($id)
    {
        $ticket_id = Crypt::decrypt($id);
        $ticket = Ticket::findOrFail($ticket_id);
        if ($ticket->comments) {
            $ticket_comments = $ticket->comments->where('read_at', null)->first();
            if ($ticket_comments) {
                $ticket_comments->update([
                    'read_at' => NOW()
                ]);
            }
        }

        return view('front.ticket.show', compact('ticket'));
    }
    public function create()
    {
        return view('front.ticket.create');
    }

    public $rules = [
        'title' => 'required',
        'type' => 'required|in:orders,activate_mempership,other',
        'description' => 'required',
        'user_id' => 'required',
        'status' => 'sometimes|nullable|in:open,finished,closed',
    ];

    public function query($query)
    {
        return $query->with(['user', 'comments'])->where('user_id', auth()->user()->id)->latest()->paginate(10);
    }

    public function afterStore()
    {
        return redirect()->route('tickets.index')->with('success', 'تم إضافة التذكرة بنجاح');
    }

    public function storeComment(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $request->validate([
            'comment' => 'required',
        ]);

        $comment = Comment::create([
            'comment' => $request->comment,
            'ticket_id' => $ticket->id,
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->back()->with('success', 'تم إضافة التعليق بنجاح.');
    }
}
