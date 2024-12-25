<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index($hash_code)
    {
        $order = Order::where('hash_code', $hash_code)->first();
        $events = Event::with(['user'])->whereNull('parent')->where('order_id', $order->id)->paginate(10);
        return responseApi(true,'',['events'=>$events]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'order_id' => 'required',
            'parent' => 'nullable',
            'type' => 'nullable',
            'content' => 'required_without:images',
            'images.*' => 'max:15360'
        ]);

        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $event = Event::create($request->all());
        if (request('images')) {
            foreach (request('images') as $image) {
                Attachment::store($image, $event);
            }
        }
        return responseApi(true,'تم إضافة العمل بنجاح',['event'=>$event->load('files','voices','user')]);

    }

    public function show($hash_code, Event $event)
    {
        $user = auth()->user();
        $order = Order::where('hash_code', $hash_code)->first();
        if(!$event->is_seen){
            $event->update(['is_seen' => now()]);
        }
        $event=$event->load(['kids.files','kids.voices','kids.user','user','files','voices'])->loadCount('kids');
        return responseApi(true,'',['event'=>$event]);
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate(['is_seen' => 'required']);
        $validator = Validator::make($request->all(), [
            'is_seen' => 'required'
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $event->update($request->all());
        return responseApi(true,'تم الإطلاع على العمل',['event'=>$event]);
    }
}
