<?php

namespace App\Http\Controllers\Api\Front;

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
            return responseApi(true, 'تم سداد الفاتورة بنجاح');
        }
        $route = route('api.front.tamara.callback', ['user' => auth()->id(), 'invoice' => $invoice->id, 'order' => $invoice->order_id]);
        $cancelRoute =route('api.front.pay.fail');
        $response = Tamara::store($invoice, $route, $cancelRoute);
        if($response){
            return responseApi(true, 'يرجى تسديد مبلغ الفاتورة', ['url' => $response]);
        }
        return responseApi(false, 'لم يتم الموافقه على المبلغ من قبل بوابة الدفع');

    }

    public function callbackOrders(Request $request)
    {
        auth()->loginUsingId($request->user);
        $status = $request->paymentStatus;
        $invoice = Invoice::findOrFail($request->invoice);
        if ($status == 'approved') {
            $invoice->update(['status' => 'paid']);
            return redirect()->route('api.front.pay.success');
        }
        return redirect()->route('api.front.pay.fail');
    }
}
