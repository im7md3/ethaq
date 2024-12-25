<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Message;
use App\Models\Negotiation;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NegotiationController extends Controller
{
    public function storeMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'msg' => 'required_without:images',
            'user_id' => 'required',
            'order_id' => 'required',
            'negotiation_id' => 'required',
            'images.*' => 'max:15360'
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $message = Message::create($request->all());
        if (request('images')) {
            foreach (request('images') as $image) {
                Attachment::store($image, $message);
            }
        }
        return responseApi(true,'تم ارسال الاستفسار بنجاح',['message'=>$message->load(['user','files'])]);

    }
    public function getMessages(Order $order, Negotiation $negotiation)
    {
        $messages = Message::where('negotiation_id', $negotiation->id)->latest('id')->get();
        return responseApi(true,'',['messages'=>$messages]);
    }
    public function show(Order $order, Negotiation $negotiation)
    {
        $messages = Message::where('negotiation_id', $negotiation->id)->latest('id')->get();

        return response(['status' => true, 'code' => 200, 'data' => $messages]);
    }
}
