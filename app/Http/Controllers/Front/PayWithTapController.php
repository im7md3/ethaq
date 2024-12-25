<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Consulting;
use App\Models\Invoice;
use App\Models\Order;
use App\Service\Tap;
use Illuminate\Http\Request;

class PayWithTapController extends Controller
{
    public function payment(Request $request, Invoice $invoice)
    {
            $order = $invoice->order;
            /* $invoice->update(['status' => 'paid']);
        return redirect()->route(auth()->user()->type . '.orders.show', $order->hash_code)->with('success', 'تم سداد الفاتورة بنجاح.'); */
            if($invoice->total==0){
                $invoice->status='paid';
                $invoice->save();
                return back()->with('success','تم سداد الفاتورة بنجاح.');
            }
            $route=route(auth()->user()->type.'.tap.callback',[$order,$invoice]);
            $response = Tap::store($invoice->total,$route);
            return redirect($response->transaction->url);
        
    }

    public function callbackOrders(Request $request,$order, Invoice $invoice)
    {
        if($invoice->order_type=="App\Models\Order"){
            $order=Order::findOrFail($order);
        }else{
            $order=Consulting::findOrFail($order);
        }
        $response = Tap::callback($request, $order);
        if ($response->status == 'CAPTURED') {
            $invoice->update(['status' => 'paid']);
            if($invoice->order_type=="App\Models\Order"){
                return redirect()->route(auth()->user()->type . '.orders.show', $order->hash_code)->with('success', 'تم سداد الفاتورة بنجاح.');
            }else{
                return redirect()->route(auth()->user()->type . '.consulting.show', $order)->with('success', 'تم سداد الفاتورة بنجاح.');
            }
        }
        if($invoice->order_type=="App\Models\Order"){
            return redirect()->route(auth()->user()->type . '.orders.show', $order->hash_code)->with('error', 'هناك خطأ في عملية الدفع.');
            }else{
                return redirect()->route(auth()->user()->type . '.consulting.show', $order)->with('error', 'هناك خطأ في عملية الدفع.');
            }
    }
}
