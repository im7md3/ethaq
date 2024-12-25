<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PayWithAppleController extends Controller
{
    public function pay(Request $request){
        $invoice=Invoice::find($request->invoice_id);
        if($invoice){
            $invoice->update(['status'=>'paid']);
            return responseApi(true,'تم الدفع بنجاح');
        }else{
            return responseApi(false,'الفاتورة غير موجودة');
        }
    }
}
