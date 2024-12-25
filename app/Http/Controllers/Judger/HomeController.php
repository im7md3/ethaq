<?php

namespace App\Http\Controllers\Judger;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $user = auth()->user()->load(['occupation']);
        $status = request('status');
        $orders = Order::where('first_judger_id', $user->id)->orWhere('second_judger_id', $user->id)->latest('id')->where(function ($q) use ($status) {
            if($status){
                $q->where('status',$status);
            }
           /*  if ($status == 'ongoing') {
                $q->whereNotNull('objection_id')->where('status','judger Decision');
            } elseif ($status == 'pending') {
                $q->whereNull('objection_id')->where('status','ongoing');
            } elseif ($status == 'done') {
                $q->where('status','VerdictHasBeenIssued');
            } elseif ($status == 'close') {
                $q->where('status', 'close');
            } */
        })->paginate(10);

        return view('judger.home', compact('user', 'orders'));
    }
}
