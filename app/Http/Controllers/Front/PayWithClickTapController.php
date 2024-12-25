<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Consulting;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use App\Service\ClickPay;
use Illuminate\Http\Request;

class PayWithClickTapController extends Controller
{
    public function payment(Request $request, Invoice $invoice)
    {
        if (env('APP_ENV') == 'local') {
            $invoice->update(['status' => 'paid']);
            return back();
        } else {
            $route = route('clickpay.callback', ['user' => auth()->id(), 'invoice' => $invoice->id, 'order' => $invoice->order_id]);
            $response = ClickPay::store($invoice, $route);
            return redirect($response->redirect_url);
        }
    }

    public function callbackOrders(Request $request)
    {
        auth()->loginUsingId($request->user);
        $status = $request->respStatus;
        $invoice = Invoice::findOrFail($request->invoice);
        if ($invoice->order_type == "App\Models\Order") {
            $order = Order::findOrFail($request->order);
        } else {
            $order = Consulting::findOrFail($request->order);
        }

        if ($status == 'A') {
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
