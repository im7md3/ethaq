<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Order;
use App\Models\OrderDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderDocumentController extends Controller
{
    public function index($hash_code)
    {
        $order = Order::where('hash_code', $hash_code)->first();
        $documents = OrderDocument::with(['user','files','voices'])->where('order_id', $order->id)->get();
        return responseApi(true,'',['documents'=>$documents]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'msg' => 'required_without:images',
            'user_id' => 'required',
            'order_id' => 'required',
            'images.*' => 'max:15360'
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $document = OrderDocument::create($request->all());
        if (request('images')) {
            foreach (request('images') as $image) {
                Attachment::store($image, $document);
            }
        }
        return responseApi(true,'تم ارسال المستند بنجاح',['document'=>$document->load(['user','files','voices'])]);
    }
}
