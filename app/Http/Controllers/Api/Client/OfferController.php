<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    public function vendorOffers(Order $order, User $vendor)
    {
        $offers = Offer::with(['vendor.license'])->where('order_id', $order->id)->where('vendor_id', $vendor->id)->latest('id')->get();
        $data = ['offer' => $offers];
        return responseApi(true, '', $data);
    }

    public function update(Request $request, Offer $offer)
    {
        $validator = Validator::make($request->all(), [
            'rejected_reason' => 'required_if:status,rejected',
            'status'=>'required'
        ]);

        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $order = Order::findOrFail($request->order_id);
        $vendor = User::findOrFail($request->vendor_id);
        $negotiation_id = $vendor->negotiations()->where('order_id', $order->id)->first()->id;
        $offer->update(['status' => $request->status,'rejected_reason'=>$request->rejected_reason]);
        if($offer->status=='accepted'){
            $order->update(['offer_id' => $offer->id, 'vendor_id' => $request->vendor_id, 'status' => 'ongoing', 'negotiation_id' => $negotiation_id]);
        }
        $msg=$request->status=="accepted"?'تم قبول العرض بنجاح':'تم رفض العرض بنجاح';
        return responseApi(true, $msg);
    }
}
