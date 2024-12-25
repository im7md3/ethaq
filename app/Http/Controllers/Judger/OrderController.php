<?php

namespace App\Http\Controllers\Judger;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Department;
use App\Models\Log;
use App\Models\Order;
use App\Models\OrderFile;
use App\Models\User;
use App\Traits\JodaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function show($hash_code){
        $order=Order::with(['invoices','activeOffer','activeNegotiation'])->withCount(['documents','events'=>function($q){
            $q->whereNull('is_seen');
        },'invoices'=>function($q){
            $q->where('from_id',auth()->id());
        }])->where('hash_code',$hash_code)->first();
        $order->ActiveJudger;
        $user=auth()->user();
        return view('judger.order.show',compact('order','user'));
    }

    public function logs($hash_code){
        $order=Order::where('hash_code',$hash_code)->first();
        $user=auth()->user();
        $logs=Log::where('order_id',$order->id)->where('type','order')->latest('id')->paginate(15);
        return view($user->type.'.order.logs',compact('user','order','logs'));
    }
    
}
