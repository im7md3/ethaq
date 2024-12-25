<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BalanceController extends Controller
{
    public function index(){
        $user=auth()->user();
        $pendingWithdrawals=$user->PendingWithdrawals->get();
        $paidInvoices = Invoice::where('to_id', $user->id)->where('withdrawn', '<>', 1)->where('status', 'paid')->sum('total');
        $withdrawnInvoices = Invoice::where('to_id', $user->id)->where('withdrawn', '=', 1)->where('status', 'paid')->sum('total');
        $invoices = Invoice::with(['order'])->where('from_id', $user->id)->orWhere('to_id', $user->id)->where('status', 'paid')->paginate(10);
        $data=['invoices'=>$invoices,'withdrawnInvoices'=>$withdrawnInvoices,'paidInvoices'=>$paidInvoices,'pendingWithdrawals'=>$pendingWithdrawals];
        return responseApi(true,'',$data);
    }
    /* public function withdrawal(Request $request){
        
        $validator = Validator::make($request->all(), [
            'amount'=>'required|gt:0|min:25','tax'=>'required','number'=>'required_if:tax,true','file'=>'required_if:tax,true'
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $request->merge([
            'tax_certificate'=>$request->tax=='true'?true:false,
            'file'=>$request->tax=='true'?store_file($request->file,'withdrawal'):null
        ]);
        $user=auth()->user();
        if ($request->amount <= $user->current_balance) {
            $user->withdrawals()->create($request->all());
            return responseApi(true,'تم طلب السحب بنجاح');
        } elseif ($user->suspended_balance > 0 and $user->current_balance
        ==0) {
            return responseApi(false,'يرجى انتظار الرصيد المعلق ليصبح متاحا للسحب');
        } elseif($user->current_balance==0){
            return responseApi(false,'لا يوجد رصيد قابل للسحب');
        }elseif ($request->amount > $user->current_balance) {
            return responseApi(false,'المبلغ المدخل أكبر من المبلغ المتوفر');
        }

    } */

    public function withdrawal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoices'=>'required|array'
        ],['invoices.required'=>'يرجى تحديد الفواتير التي تريد سحبها']);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $user = auth('sanctum')->user();
        $amount = 0;
        foreach ($request->invoices as $id) {
            $invoice = Invoice::find($id);
            $amount += $invoice->net;
        }
        $data['amount'] = $amount;
        $withdrawal=$user->withdrawals()->create($data);
        foreach ($request->invoices as $id) {
            $invoice = Invoice::find($id);
            $invoice->update(['withdrawn'=>1,'withdraw_id'=>$withdrawal->id]);
        }
        return responseApi(true,'تم طلب السحب بنجاح');
    }
}
