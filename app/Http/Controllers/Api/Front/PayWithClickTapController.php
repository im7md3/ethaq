<?php

namespace App\Http\Controllers\Api\Front;

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
        $order = $invoice->order;
        if ($invoice->total == 0) {
            $invoice->status = 'paid';
            $invoice->save();
            return responseApi(true, 'تم سداد الفاتورة بنجاح');
        }
        if ($request->from_balance) {
            $invoice->status = 'paid';
            $invoice->save();
            $user = $invoice->fromUser;
            $user->update(['current_balance' => $user->current_balance - $invoice->total]);
            return responseApi(true, 'تم سداد الفاتورة بنجاح');
        }
        $route = route('api.front.clickpay.callback', ['invoice' => $invoice->id]);
        $response = ClickPay::store($invoice, $route);
        return responseApi(true, 'يرجى تسديد مبلغ الفاتورة', ['url' => $response->redirect_url]);
    }

    public function callbackOrders(Request $request)
    {
        $status = $request->respStatus;
        $invoice = Invoice::findOrFail($request->invoice);
        if ($status == 'A') {
            $invoice->update(['status' => 'paid']);
            return redirect()->route('api.front.pay.success');
        }
        return redirect()->route('api.front.pay.fail');
    }

    public function success()
    {
    }
    public function fail()
    {
    }
}
