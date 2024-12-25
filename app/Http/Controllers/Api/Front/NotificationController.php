<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Consulting;
use App\Models\Notification;
use App\Service\FCMClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())->latest('id')->paginate(10);
        foreach ($notifications as $notification) {
            $notification->markAsSeen();
        }
        return responseApi(true, '', ['notifications' => $notifications]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'title' => 'required',
            'type' => 'required',
            'consulting_id' => 'required|exists:consultings,id'
        ]);
        
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }


        $notification_data = [
            'type' => $request->type,
            'id' => intval($request->consulting_id),
        ];

        $consulting = Consulting::find($request->consulting_id);

        $con = $consulting->load(['offers.vendor:id,name,photo', 'client', 'vendor', 'files', 'voices', 'messages', 'evaluate', 'invoices'])->loadCount(['evaluate', 'messages']);

        $notification = Notification::send($request->user_id, $request->title, null, $request->type, $notification_data);

        return responseApi(true, '', ['notification' => $notification, 'consulting' => $con]);
    }

    public function testFirebase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required|exists:fcm_tokens,token',
            'msg' => 'required'
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        FCMClient::send(
            $request->fcm_token,
            'اشعار جديد',
            $request->msg,
        );
        return responseApi(true, 'تم ارسال الاشعار');
    }
}
