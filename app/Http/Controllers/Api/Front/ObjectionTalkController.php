<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\ObjectionTalk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ObjectionTalkController extends Controller
{

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'msg' => 'required_without:images',
            'order_id' => 'required',
            'user_id' => 'required',
            'objection_id' => 'required',
            'images.*' => 'max:15360'
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $talk = ObjectionTalk::create($request->all());
        if (request('images')) {
            foreach (request('images') as $image) {
                if (!is_null($image)) {
                    Attachment::store($image, $talk);
                }
            }
        }
        return responseApi(true,'تم ارسال الرسالة بنجاح');
    }
}
