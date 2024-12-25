<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Event;
use App\Models\Order;
use App\Models\OrderProtest;
use App\Models\User;
use App\Service\Oursms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderProtestController extends Controller
{
    public function index($hash_code)
    {
        $order = Order::where('hash_code', $hash_code)->first();
        $protests = OrderProtest::with(['user'])->where('order_id', $order->id)->get();
        return responseApi(true, '', ['protests' => $protests]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'order_id' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $protest = OrderProtest::create($request->all());

        $auth_user = User::find($request->user_id);
        $order = Order::find($request->order_id);
        if ($auth_user->type == 'vendor') {
            $user = User::find($order->client_id);
        } else {
            $user = User::find($order->vendor_id);
        }
 
        $message = 'تم إرسال اعتراض على الطلب ' . $order->id;
        Oursms::send($user->phone, $message);

        return responseApi(true, 'تم إضافة العمل بنجاح', ['protest' => $protest->load('user')]);
    }
}
