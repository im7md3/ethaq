<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Service\Tamam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class PayWithTamamController extends Controller
{
    public function tamam(Invoice $invoice)
    {
        try {
            $invoice->update(['id_tamam' => Uuid::uuid4()->toString()]);
            $route = route('api.front.tamam.callback', ['invoice' => $invoice]);
            $response = Tamam::store($invoice, $route);
            return responseApi(true, 'يرجى تسديد مبلغ الفاتورة', ['url' => $response->response->redirection_url]);
        } catch (\Exception $e) {
            return responseApi(false, 'حدث خطأ ما');
        }
    }
    public function callbackOrders(Request $request, Invoice $invoice)
    {
        $invoice->update(['tamam_transaction_id' => $request->transaction_id]);
        $response = Tamam::CheckTransactionStatus($request->transaction_id);
        if ($response) {
            if ($response->response->order_status == "SUCCESS") {
                $invoice->update(['tamam_success' => now()]);
                return redirect()->route('api.front.pay.success');
            }
        }
        return redirect()->route('api.front.pay.fail');
    }
}
