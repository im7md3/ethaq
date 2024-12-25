<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Consulting;
use App\Models\Department;
use App\Models\Order;
use App\Models\Slider;
use Illuminate\Http\Request;

class MainScreenController extends Controller
{
    public function mainScreen()
    {
        $user = auth()->user();
        $ongoing_orders = Order::where('vendor_id', $user->id)->where('status', 'ongoing')->count();
        $done_orders = Order::where('vendor_id', $user->id)->where('status', 'done')->count();
        $judger_orders = Order::where('vendor_id', $user->id)->where('status', 'judger Decision')->count();
        $ongoing_consultings = Consulting::where('vendor_id', $user->id)->where('status', 'active')->count();
        $active = 'non_active';
        $consulting = Consulting::with(['client', 'files','voices', 'vendor', 'department', 'invoices'])->where('vendor_id', $user->id)->whereHas('invoices',function($q){
            $q->where('status','paid');
        })->latest('id')->take(5)->get();
        $newConsultingCount = Consulting::where(function ($q) {
            $q->whereNull('vendor_id');
        })->count();
        $orders = Order::with(['client', 'files','voices', 'mainDepartment', 'department', 'invoices'])->where('vendor_id', $user->id)->latest('id')->take(5)->get();
        $sliders = Slider::where('type', 'vendor')->orWhereNull('type')->latest('id')->take(5)->get();
        /* ========== عدد الاستشارات المجانية المتبقية للمحامي =========== */
        $activeConsultingCount = Consulting::where('vendor_id', $user->id)->where('status', 'active')->count();
        $unreadNotifications = auth('sanctum')->user()->unreadNotifications->count();
        $departments = Department::where('parent', 1)->get();
        $show_for_review=(int)setting('UI_phone')??0;
        $data = ['departments' => $departments, 'ongoing_orders' => $ongoing_orders, 'done_orders' => $done_orders, 'judger_orders' => $judger_orders, 'ongoing_consultings' => $ongoing_consultings, 'active' => $active, 'orders' => $orders, 'consulting' => $consulting, 'sliders' => $sliders,  'newConsultingCount' => $newConsultingCount, 'activeConsultingCount' => $activeConsultingCount, 'unreadNotifications' => $unreadNotifications,'show_for_review'=>$show_for_review];
        return responseApi(true, '', $data);
    }
}
