<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankTransfer;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class BankTransferController extends Controller
{
    public function index(){
        $banks=BankTransfer::with(['user','invoice'])->where(function($q){
            if(request('status')){
                $q->where('status',request('status'));
            }
        })->latest('id')->paginate(10);
        $all=BankTransfer::count();
        $pending=BankTransfer::where('status','pending')->count();
        $completed=BankTransfer::where('status','accepted')->count();
        $refused=BankTransfer::where('status','rejected')->count();
        return view('admin.banks.index',compact('banks','refused','completed','pending','all'));
    }
    public function update(Request $request,BankTransfer  $bankTransfer){
        $data=$request->validate(['status'=>'required','rejected_msg'=>'required_if:status,rejected']);
        $bankTransfer->update($data);
        return redirect()->route('admin.bankTransfers.index')->with('success','تم تغيير حالة الطلب بنجاح');
    }
    public function show(BankTransfer $bankTransfer){
        $bankTransfer->load(['invoice.order','user']);
        return view('admin.banks.show',compact('bankTransfer'));
    }
}
