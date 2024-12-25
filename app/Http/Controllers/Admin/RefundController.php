<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index(){
        $refunds=Refund::with(['user','order'])->latest('id')->paginate(10);
        return view('admin.refunds.index',compact('refunds'));
    }
    public function update(Request $request,Refund  $refund){
        $data=$request->validate(['status'=>'required']);
        $refund->update($data);
        return back()->with('success','تم تغيير حالة الطلب بنجاح');
    }
}
