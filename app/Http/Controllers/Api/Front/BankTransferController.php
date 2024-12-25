<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\BankTransfer;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankTransferController extends Controller
{
    public function payment(Request $request, Invoice $invoice)
    {
        $rules = ['transfer_name' => 'required', 'bank_name' => 'required', 'account_no' => 'required', 'image' => 'required'];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $id = auth('sanctum')->id();
        $bank = BankTransfer::where('user_id', $id)->where('invoice_id', $invoice->id)->where('status', 'pending')->first();
        if ($bank) {
            return responseApi(false, 'قمت بإرسال تحويل بنكي بالفعل');
        }
        $request->merge(['file' => store_file($request->image, 'bank'), 'user_id' => $id, 'invoice_id' => $invoice->id, 'status' => 'pending','order_id'=>$invoice->order_id,'order_type'=>$invoice->order_type]);
        BankTransfer::create($request->all());
        return responseApi(true, 'تم إرسال التحويل بنجاح');
    }
}
