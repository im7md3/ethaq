<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Objection;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ObjectionController extends Controller
{
    public function show(Objection $objection)
    {
        $objection = $objection->load(['user']);
        /* $plain_text = preg_replace('/<[^>]+>/', '', $objection->content);
        return $plain_text; */
        $objectionTalks = $objection->order->objectionTalks;
        // $other_id = auth()->id() == $order->client_id ? $order->vendor_id : $order->client_id;
        // $period = $order->judger_period;
        $data = ['objection' => $objection];
        return responseApi(true, '', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'user_id' => 'required',
            'reasons' => 'nullable',
            'other_reason' => 'nullable',
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $order = Order::findOrFail($request->order_id);
        $user = auth()->user();
        $other_id = auth()->id() == $order->client_id ? $order->vendor_id : $order->client_id;
        $other = User::findOrFail($other_id);
        $reasons = $request->reasons;
        $other_reason = $request->other_text;
        $ff = view('api.create-objection', compact('order', 'user', 'other', 'reasons', 'other_reason'))->render();
        $request->merge(['content' => $ff]);
        $objection = Objection::create($request->all());
        $order = Order::findOrFail($request->order_id);
        $order->update(['objection_id' => $objection->id, 'status' => 'judger Decision']);
        return responseApi(true, 'تم إضافة الاعتراض ورفع الطلب الى المحكم');
    }

    public function time(Request $request, Objection $objection)
    {
        $data = $request->validate([
            'time' => 'required',
        ]);
        $data['time'] = $request->time + $request->period;
        $objection->update($data);
        return response(['status' => true, 'code' => 200, 'message' => 'تم ارسال مدة التحكيم بنجاح']);
    }

    public function client_decision(Request $request, Objection $objection)
    {
        $validator = Validator::make($request->all(), [
            'client_decision' => 'required',
            'client_refused_msg' => 'required_if:client_decision,refused'
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $objection->update($request->all());
        return responseApi(true, 'تم ارسال الرد بنجاح');
    }

    public function vendor_decision(Request $request, Objection $objection)
    {
        $validator = Validator::make($request->all(), [
            'vendor_decision' => 'required',
            'vendor_refused_msg' => 'required_if:vendor_decision,refused'
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $objection->update($request->all());
        return responseApi(true, 'تم ارسال الرد بنجاح');
    }

    public function arbitration($hash_code)
    {
        $order = Order::with('objection')->firstWhere('hash_code', $hash_code);
        $user1 = $order->objection->user->load('city');
        $user2 = $order->objection->user_id == $order->client_id ? $order->vendor->load('city') : $order->client->load('city');
        return response(['status' => true, 'code' => 200, 'order' => $order]);
    }

    public function arbitrationStore(Request $request, Order $order)
    {
        $data = $request->validate(['judger_judgment' => 'required']);
        $data['judger_judgment_time'] = now();
        $data['judger_id'] = auth()->id();
        $objection = Objection::firstWhere('order_id', $order->id);
        $order->update(['status' => 'VerdictHasBeenIssued']);
        $objection->update($data);

        return response(['status' => true, 'code' => 200, 'message' => 'تم إصدار القرار بنجاح']);
    }

    public function objectionJudgment(Request $request)
    {

        $user = auth()->user();
        $data = $request->validate([
            $user->type . '_objection_reason' => 'nullable',
            'objection_id' => 'required',
        ]);
        $data[$user->type . '_objection'] = 1;
        $obj = Objection::findOrFail($request->objection_id);
        $obj->update($data);
        return response(['status' => true, 'code' => 200, 'message' => 'تم ارسال طلب الاعتراض بنجاح']);
    }
}
