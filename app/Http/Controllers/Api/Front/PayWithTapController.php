<?php

namespace App\Http\Controllers\Api\Front;

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
            if($invoice->total==0){
                $invoice->status='paid';
                $invoice->save();
                return responseApi(true,'تم سداد الفاتورة بنجاح.');
            }
            $route = route('api.front.tap.callback', ['invoice' => $invoice->id]);
            $response = Tap::store($invoice->total,$route);
            return responseApi(true, 'يرجى تسديد مبلغ الفاتورة', ['url' => $response->transaction->url]);
        
    }
    public function callback(Request $request, Invoice $invoice)
    {
        $response = Tap::callback($request, $invoice->order);
        if ($response->status == 'CAPTURED') {
            $invoice->update(['status' => 'paid']);
            return redirect()->route('api.front.tap.success');
        }
        return redirect()->route('api.front.tap.fail');
    }
    public function success()
    {
        
    }
    public function fail()
    {
        
    }
}
