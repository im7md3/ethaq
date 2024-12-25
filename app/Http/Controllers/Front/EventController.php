<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index($hash_code)
    {
        $user = auth()->user();
        $order = Order::withCount(['documents', 'events' => function ($q) {
            $q->whereNull('is_seen');
        }, 'invoices' => function ($q) {
            $q->where('from_id', auth()->id());
        }])->where('hash_code', $hash_code)->first();
        $events = Event::with(['kids.files','kids.voices', 'user', 'files','voices'])->whereNull('parent')->where('order_id', $order->id)->paginate(10);
        return view($user->type . '.order.events', compact('order', 'user', 'events'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'order_id' => 'required',
            'parent' => 'nullable',
            'type' => 'nullable',
            'content' => 'required_without:images',
            'images.*' => 'max:15360'
        ]);
        $event = Event::create($data);
        if (request('images')) {
            foreach (request('images') as $image) {
                Attachment::store($image, $event);
            }
        }
        return redirect()->back()->with('success', 'تم إضافة العمل بنجاح');
    }

    public function show($hash_code, Event $event)
    {
        $user = auth()->user();
        $order = Order::withCount(['documents', 'events' => function ($q) {
            $q->whereNull('is_seen');
        }, 'invoices' => function ($q) {
            $q->where('from_id', auth()->id());
        }])->where('hash_code', $hash_code)->first();
        if(!$event->is_seen){
            $event->update(['is_seen' => now()]);
        }
        $event=$event->load(['kids'])->loadCount('kids');
        return view($user->type . '.order.show-event', compact('order', 'user', 'event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate(['is_seen' => 'required']);
        $event->update($data);
        return redirect()->back()->with('success', 'تم الإطلاع على العمل ');
    }
}
