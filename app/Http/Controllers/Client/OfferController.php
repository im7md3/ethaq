<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function vendorOffers(Order $order,User $vendor){
        $user=auth()->user();
        $offers=Offer::where('order_id',$order->id)->where('vendor_id',$vendor->id)->latest('id')->get();
        return view('client.order.vendor-offers',compact('offers','order','user'));
    }

    public function update(Request $request,Offer $offer){
        $order=Order::findOrFail($request->order_id);
        $vendor=User::findOrFail($request->vendor_id);
        $negotiation_id=$vendor->negotiations()->where('order_id',$order->id)->first()->id;
        $offer->update(['status'=>'accepted']);
        $order->update(['offer_id'=>$offer->id,'vendor_id'=>$request->vendor_id,'status'=>'ongoing','negotiation_id'=>$negotiation_id]);
        return redirect()->route('client.orders.show',$order->hash_code)->with('success','تم قبول العرض بنجاح');
    }
}
