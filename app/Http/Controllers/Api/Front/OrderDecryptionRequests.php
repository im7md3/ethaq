<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class OrderDecryptionRequests extends Controller
{
    public function index($hash_code)
    {
        $user = auth()->user();
        $order = Order::with(['DecryptionRequests'])->firstWhere('hash_code', $hash_code);

        return response(['status' => true, 'code' => 200, 'order' => $order, 'user' => $user]);
    }

    public function store(Order $order)
    {
        auth()->user()->decryptionRequests()->attach($order->id, ['status' => 'pending', 'created_at' => now()]);
        $link = route('client.orders.show', $order->hash_code);
        $title = 'قام المحامي ' . auth()->user()->name . ' بطلب فك التشفير للطلب ' . $order->title;
        $notification_data = [
            'id' => intval($order->id),
            'type' => 'order',
            'hash_code' => $order->hash_code
        ];
        Notification::send($order->client_id, $title, $link, null, $notification_data);

        return responseApi(true, 'تم ارسال طلب التشفير الى العميل بنجاح');
    }

    public function update(Request $request, Order $order, User $vendor)
    {
        if ($request->status == 'refused') {
            $order->decryptionRequests()->where('vendor_id', $vendor->id)->update(['status' => $request->status, 'updated_at' => now()]);
            $title = 'قام العميل برفض طلب التشفير للطلب ' . $order->title;
        } else {
            $code = $vendor->id . '' . rand(1000, 9999) . '' . $order->id;
            $order->decryptionRequests()->where('vendor_id', $vendor->id)->update(['code' => $code, 'status' => $request->status, 'updated_at' => now()]);
            $title = 'قام العميل بقبول طلب التشفير للطلب ' . $order->title . ' والكود هو ' . $code;
        }

        $link = route('vendor.orders.show', $order->hash_code);

        $notification_data = [
            'id' => intval($order->id),
            'type' => 'order',
            'hash_code' => $order->hash_code
        ];

        Notification::send($vendor->id, $title, $link, null, $notification_data);
        return responseApi(true, $title);
    }

    public function login(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required'
        ]);

        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $decryptionRequests = $order->DecryptionRequests()->where('vendor_id', auth()->id())->first();
        if ($request->code == $decryptionRequests->pivot->code) {
            $order->decryptionRequests()->where('vendor_id', auth()->id())->update(['status' => 'accepted']);

            return responseApi(true, 'تم تسجيل الدخول بنجاح');
        } else {
            return responseApi(false, 'يرجى ادخال الكود بشكل صحيح');
        }
    }
}
