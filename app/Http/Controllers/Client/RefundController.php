<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function store(Request $request){
        $data=$request->validate([
            'user_id'=>'required',
            'order_id'=>'required',
            'amount'=>'required',
        ]);
        $amount=$request->amount;
        $ratio=$amount*(setting('refund_ratio')/100);
        $data['admin_ratio']=$ratio;
        $data['user_ratio']=$amount-$ratio;
        $data['status']='pending';
        Refund::create($data);
        return back()->with('success','تم ارسال طلب الاسترجاع بنجاح');
    }
}
