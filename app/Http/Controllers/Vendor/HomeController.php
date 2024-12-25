<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $arrWith=['client', 'department', 'mainDepartment'];
    public function orders()
    {
        $request=request('selected');
        $user = auth()->user()->load(['occupation', 'vendorOrders']);
        if($request=='ongoing' || $request=='pending' || $request=='done' || $request=='open'){
            $orders = $this->getOrdersByStatus($user,$request)->simplePaginate(10);
        }elseif($request=='judger'){
            $orders = $this->getJudgerOrders($user)->simplePaginate(10);
        }elseif($request=='private'){
            $orders = $this->getPrivateOrders($user)->simplePaginate(10);
        }else{
            $orders = $this->getModernOrders($user)->simplePaginate(10);
        }
        
        return view('vendor.home', compact('user', 'orders'));
    }

    public function getModernOrders($user){
        $newOrders=Order::with($this->arrWith)->Show()->InUserDepartments()->where('status','open')->whereDoesntHave('vendors')->orWhereHas('vendors',function($q) use($user){
            $q->where('vendor_id',$user->id);
        });
        $myOrders=Order::with($this->arrWith)->Show()->InUserDepartments()->where('vendor_id',$user->id);
        return $newOrders->union($myOrders)->latest('id');
    }

    public function getOrdersByStatus($user,$status)
    {
        if ($status == 'pending') {
            return Order::with($this->arrWith)->InUserDepartments()->where('status','open')->whereHas('offers', function ($q) use ($user) {
                $q->where('vendor_id',$user->id)->where('status','pending');
            })->latest('id');
        }elseif($status == 'open'){
            return Order::with($this->arrWith)->InUserDepartments()->where('status','open')->whereDoesntHave('vendors')->orWhereHas('vendors',function($q) use($user){
                $q->where('vendor_id',$user->id);
            })->latest('orders.id');
        } else {
            return Order::with($this->arrWith)->InUserDepartments()->where(function ($q) use ($status,$user) {
                $q->where('vendor_id',$user->id);
                $q->where('orders.status', $status);
            })->latest('orders.id');
        }
    }

    public function getJudgerOrders($user){
        return Order::with($this->arrWith)->InUserDepartments()->where('vendor_id',$user->id)->whereNotNull('objection_id')->latest('id');
    }

    public function getPrivateOrders($user){
        return Order::with($this->arrWith)->InUserDepartments()->whereHas('vendors',function($q) use($user){
            $q->where('vendor_id',$user->id);
        })->where(function($q) use($user){
            $q->where('status','open')->orWhere('vendor_id',$user->id);
        })->latest('id');
    }

    public function getFavoritesOrders($user){
        return Order::with($this->arrWith)->InUserDepartments()->whereHas('favorites',function($q) use($user){
            $q->where('user_id',$user->id);
        })->latest('id');
    }
}
