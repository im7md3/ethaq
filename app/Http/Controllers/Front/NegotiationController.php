<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Message;
use App\Models\Negotiation;
use App\Models\Order;
use Illuminate\Http\Request;

class NegotiationController extends Controller
{
    public function storeMessage(Request $request){
        $data=$request->validate([
            'msg'=>'required_without:images',
            'user_id'=>'required',
            'order_id'=>'required',
            'negotiation_id'=>'required',
            'images.*' => 'max:15360'
        ]);
        $message=Message::create($data);
        if(request('images')){
            foreach(request('images') as $image){
                Attachment::store($image,$message);
            }
        }
        return back()->with('success','تم ارسال الاستفسار بنجاح');
    }
    public function show(Order $order,Negotiation $negotiation){
        $messages=Message::where('negotiation_id',$negotiation->id)->latest('id')->paginate(10);
        $user=auth()->user();
        return view($user->type.'.order.show-negotiation',compact('order','negotiation','messages','user'));
    }
}
