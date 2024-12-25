<?php

namespace App\Http\Controllers\Front;

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
            $route = route('tamam.callback', ['invoice' => $invoice]);
            $response = Tamam::store($invoice, $route);
            return redirect($response->response->redirection_url);
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'حدث خطأ ما');
        }
    }
    public function callbackOrders(Request $request, Invoice $invoice)
    {
        $invoice->update(['tamam_transaction_id' => $request->transaction_id]);
        $response = Tamam::CheckTransactionStatus($request->transaction_id);
        if ($response) {
            $order = Order::findOrFail($invoice->order_id);
            if ($response->response->order_status == "SUCCESS") {
                $invoice->update(['tamam_success' => now()]);
                return redirect()->route('client.orders.show', $order->hash_code)->with('success', $response->response->transaction_status_ar);
            }
        }
        return redirect()->route('client.orders.show', $order->hash_code)->with('error', $response->response->transaction_status_ar);
    }
    public function poCallback(Request $request)
    {
        $data = [
            "po_id" => "$request->po_id",
            "merchant_id" => env('Tamam_Merchant_id'),
            "order_id" => "$request->order_id",
            "transaction_id" => "$request->transaction_id",
            "accepted_at" => now()->format('Y-m-d'),
            "accept" => true
        ];
        return response()->json($data);
    }
    public function statusCallback(Request $request)
    {
        $data = [
            "accepted_at" => now()->format('Y-m-d'),
            "accept" => true
        ];
        return response()->json($data);
    }
    public function transaction(Invoice $invoice){
        $response=Tamam::CheckTransactionStatus($invoice->tamam_transaction_id);
        // $response=Tamam::ReportDelivery($invoice);
            dd($response);
    }
}
