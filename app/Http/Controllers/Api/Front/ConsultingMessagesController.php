<?php

namespace App\Http\Controllers\Api\Front;

use App\Events\MessageEvent;
use App\Events\SendMessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Consulting;
use App\Models\ConsultingMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultingMessagesController extends Controller
{
    public function index(Consulting $consulting){
        return responseApi(true,'',['messages'=>$consulting->messages,'min'=>$consulting->min,'sec'=>$consulting->sec]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'nullable|max:15360',
            'msg' => 'required_without:images',
            'to' => 'required',
            'from' => 'required',
            'consulting_id' => 'required',
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $consulting=Consulting::findOrFail($request->consulting_id);
        if($consulting->status=='done'){
            return responseApi(false, 'تم إنهاء الاستشارة بالفعل');
        }
        $message = ConsultingMessages::create($request->all());
        if (request('images')) {
            foreach ($request->images as $image) {
                Attachment::store($image, $message);
            }
        }
        event(new SendMessageEvent($message->load('toUser','fromUser','files')));
        return responseApi(true,'',['message'=>$message]);
    }
}
