<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\ObjectionTalk;
use Illuminate\Http\Request;

class ObjectionTalkController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'msg' => 'required_without:images',
            'order_id' => 'required',
            'user_id' => 'required',
            'objection_id' => 'required',
            'images.*' => 'max:15360'
        ]);
        $talk = ObjectionTalk::create($data);
        if (request('images')) {
            foreach (request('images') as $image) {
                if(!is_null($image)){
                    Attachment::store($image, $talk);
                }
            }
        }
        return back()->with('success','تم ارسال الرسالة بنجاح');
    }
}
