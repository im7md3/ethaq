<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Consulting;
use App\Models\Invoice;
use App\Models\Order;
use App\Service\Tamara;
use Illuminate\Http\Request;

class PayWithTamaraController extends Controller
{
    public function payment(Request $request, Invoice $invoice)
    {
        if ($invoice->total == 0) {
            $invoice->status = 'paid';
            $invoice->save();
            return back()->with('success', 'تم سداد الفاتورة بنجاح.');
        }
        $route = route('tamara.callback', ['user' => auth()->id(), 'invoice' => $invoice->id, 'order' => $invoice->order_id]);
        $cancelRoute = route('client.orders.show', $invoice->order->hash_code);
        $response = Tamara::store($invoice, $route,$cancelRoute);
        return redirect($response);
    }

    public function callbackOrders(Request $request)
    {
        auth()->loginUsingId($request->user);
        $status = $request->paymentStatus;
        $invoice = Invoice::findOrFail($request->invoice);
        if ($invoice->order_type == "App\Models\Order") {
            $order = Order::findOrFail($request->order);
        } else {
            $order = Consulting::findOrFail($request->order);
        }

        if ($status == 'approved') {
            $invoice->update(['status' => 'paid']);
            if ($invoice->order_type == "App\Models\Order") {
                return redirect()->route(auth()->user()->type . '.orders.show', $order->hash_code)->with('success', 'تم سداد الفاتورة بنجاح.');
            } else {
                return redirect()->route(auth()->user()->type . '.consulting.show', $order)->with('success', 'تم سداد الفاتورة بنجاح.');
            }
        }
        if ($invoice->order_type == "App\Models\Order") {
            return redirect()->route(auth()->user()->type . '.orders.show', $order->hash_code)->with('error', 'هناك خطأ في عملية الدفع.');
        } else {
            return redirect()->route(auth()->user()->type . '.consulting.show', $order)->with('error', 'هناك خطأ في عملية الدفع.');
        }
    }
}
