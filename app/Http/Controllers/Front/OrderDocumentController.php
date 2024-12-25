<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Order;
use App\Models\OrderDocument;
use Illuminate\Http\Request;

class OrderDocumentController extends Controller
{
    public function index($hash_code){
        $order=Order::withCount(['documents','events'=>function($q){
            $q->whereNull('is_seen');
        },'invoices'=>function($q){
            $q->where('from_id',auth()->id());
        },'documents'])->where('hash_code',$hash_code)->first();
        $user=auth()->user();
        $documents=OrderDocument::with('user')->where('order_id',$order->id)->paginate(10);
        return view($user->type.'.order.documents',compact('order','user','documents'));
    }
    public function store(Request $request){
        $data=$request->validate([
            'msg'=>'required_without:images',
            'user_id'=>'required',
            'order_id'=>'required',
            'images.*' => 'max:15360'
        ]);
        $document=OrderDocument::create($data);
        if(request('images')){
            foreach(request('images') as $image){
                Attachment::store($image,$document);
            }
        }
        return back()->with('success','تم ارسال المستند بنجاح');
    }
}
