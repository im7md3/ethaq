<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Log;
use App\Models\Negotiation;
use App\Models\Offer;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
        /* ************************* Show Order ***************************** */
    public function show($hash_code){
        $order=Order::withCount(['documents','events'=>function($q){
            $q->whereNull('is_seen');
        },'invoices'=>function($q){
            $q->where('from_id',auth()->id());
        }])->with(['invoices'])->where('hash_code',$hash_code)->first();
        $order->ActiveJudger;
        $user=auth()->user()->load(['invoices','negotiations'=>function($q) use($order){
            $q->where('order_id',$order->id)->first();
        },'negotiations.messages']);
        $my_offers=Offer::with(['vendor','files','voices'])->where('order_id',$order->id)->where('vendor_id',$user->id)->latest('id')->get();
        /* ******************** check if user watch Order ************************* */
        if(!$user->alreadyWatched($order->id)){
            $user->orderWatched()->attach($order->id);
        }

        return view('vendor.order.show',compact('order','user','my_offers'));
    }
    /* ************************* Agree Or Disagree To Access Order ***************************** */
    public function orderAccess($hash_code)
    {
        request()->validate([
            'option'=>'required'
        ]);
        if(request('option')==2){
            return redirect()->route('vendor.home')->with('success','تم عدم موافقة الدخول بنجاح');
        }
        $order = Order::query()->where('hash_code',$hash_code)->first();
        $order->accessVendors()->attach(\auth()->id());
        Negotiation::create(['order_id'=>$order->id,'vendor_id'=>auth()->id()]);
        return back()->withSuccess('تم الدخول بنجاح');
    }

    public function logs($hash_code){
        $order=Order::where('hash_code',$hash_code)->first();
        $user=auth()->user();
        $logs=Log::where('order_id',$order->id)->where('type','order')->latest('id')->paginate(15);
        return view('vendor.order.logs',compact('user','order','logs'));
    }

    public function submissionOfWork(Request $request,Order $order){
        $data=$request->validate(['status'=>'required']);
        $data['delivery_date']=now();
        $order->update($data);
        return back()->withSuccess('تم تسليم الاعمال بنجاح');
    }

    public function favorite(Order $order){
        if(auth()->user()->isFavoriteOrder($order->id)){
            Favorite::destroy($order);
            $msg='تم إزالة الطلب من المفضلة';

        }else{
            Favorite::store($order);
            $msg='تم إضافة الطلب الى المفضلة';
        }
        return back()->withSuccess($msg);
    }

    public function cancel(Order $order)
    {
        $order->update(['status' => 'cancel']);
        return back()->with('success', 'تمت العملية بنجاح بنجاح');
    }
}
