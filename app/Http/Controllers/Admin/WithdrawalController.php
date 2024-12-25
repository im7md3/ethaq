<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index(){
        $withdrawals=Withdrawal::with(['user'])->where(function($q){
            if(request('status')){
                $q->where('status',request('status'));
            }
        })->latest('id')->paginate(10);
        $all=Withdrawal::count();
        $pending=Withdrawal::where('status','pending')->count();
        $completed=Withdrawal::where('status','completed')->count();
        $refused=Withdrawal::where('status','refused')->count();
        return view('admin.withdrawals.index',compact('withdrawals','refused','completed','pending','all'));
    }
    public function update(Request $request,Withdrawal  $withdrawal){
        $data=$request->validate(['status'=>'required','refused_msg'=>'required_if:status,refused']);
        $withdrawal->update($data);
        return redirect()->route('admin.withdrawals.index')->with('success','تم تغيير حالة الطلب بنجاح');
    }
    public function show(Withdrawal $withdrawal){
        $withdrawal->load(['invoices.order','user']);
        return view('admin.withdrawals.show',compact('withdrawal'));
    }
}
