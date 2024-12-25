<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuspendedBalance;
use Illuminate\Http\Request;

class SuspendedBalances extends Controller
{
    public function index(){
        $suspended=SuspendedBalance::with(['invoice','order','fromUser','toUser'])->latest('id')->paginate(10);
        return view('admin.suspended-balances.index',compact('suspended'));
    }
    public function destroy(SuspendedBalance $suspendedBalance){
        $suspendedBalance->delete();
        return back()->with('success','تم حذف السجل بنجاح');
    }
}
