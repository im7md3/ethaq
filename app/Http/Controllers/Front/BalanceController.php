<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Financial;
use App\Models\Invoice;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function index()
    {
        $user = auth()->user()->loadCount(['invoices' => function ($q) {
            $q->where('status', 'unpaid');
        }]);
        $paidInvoices = Invoice::where('to_id', $user->id)->where('withdrawn', '<>', 1)->where('status', 'paid')->get();
        $withdrawnInvoices = Invoice::where('to_id', $user->id)->where('withdrawn', '=', 1)->where('status', 'paid')->get();
        $invoices = Invoice::with(['order'])->where('from_id', $user->id)->orWhere('to_id', $user->id)->where('status', 'paid')->paginate(10);
        return view('front.balance', compact('user', 'invoices', 'paidInvoices', 'withdrawnInvoices'));
    }
    /*  public function withdrawal(Request $request)
    {
        $data = $request->validate(['amount' => 'required', 'tax' => 'required', 'number' => 'required_if:tax,true', 'file' => 'required_if:tax,true']);
        $data['tax_certificate'] = $data['tax'] == 'true' ? true : false;
        $data['file'] = $data['tax'] == 'true' ? store_file($request->file, 'withdrawal') : null;
        $user = auth()->user();
        if ($request->amount <= $user->current_balance) {
            $user->withdrawals()->create($data);
            return back()->with('success', 'تم طلب السحب بنجاح');
        } elseif ($user->suspended_balance > 0 and $user->current_balance
        ==0) {
            return back()->with('warning', 'يرجى انتظار الرصيد المعلق ليصبح متاحا للسحب');
        } elseif($user->current_balance==0){
            return back()->with('warning', 'لا يوجد رصيد قابل للسحب');
        }elseif ($request->amount > $user->current_balance) {
            return back()->with('warning', 'المبلغ المدخل أكبر من المبلغ المتوفر');
        }
    } */

    public function withdrawal(Request $request)
    {
        $data = $request->validate(['invoices' => 'required|array'],['invoices.required'=>'يرجى تحديد الفواتير التي تريد سحبها']);
        $user = auth()->user();
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
        return back()->with('success', 'تم طلب السحب بنجاح');
    }
}
