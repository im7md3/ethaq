<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Consulting;
use App\Models\Department;
use App\Models\Order;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;

class MainScreenController extends Controller
{
    public function mainScreen()
    {

        $sliders = Slider::where('type', 'client')->orWhereNull('type')->latest('id')->take(5)->get();
        if (auth('sanctum')->check()) {
            $unreadNotifications = auth('sanctum')->user()->unreadNotifications->count();
            $orders = auth('sanctum')->user()->clientOrders()->with(['client', 'files','voices', 'mainDepartment', 'department', 'invoices'])->latest('id')->take(5)->get();
            $consulting = Consulting::with(['client', 'files', 'vendor', 'department', 'invoices'])->where('client_id', auth('sanctum')->id())->latest('id')->take(5)->get();
            $vendors = null;
        } else {
            $orders = null;
            $consulting = null;
            $unreadNotifications = 0;
            $vendors = User::AllVendors()->take(20)->get();
        }
        $departments = Department::ParentsWithoutConsultings()->get();
        $subDepartments=Department::where('parent',2)->get();
        $show_for_review=(int)setting('UI_phone')??0;
        $tamara_active=(int)setting('tamara_active')??0;
        $data = ['departments' => $departments, 'orders' => $orders, 'consulting' => $consulting, 'slider' => $sliders, 'vendors' => $vendors, 'unreadNotifications' => $unreadNotifications,'show_for_review'=>$show_for_review,'tamara_active'=>$tamara_active,'subDepartments'=>$subDepartments];
        return responseApi(true, '', $data);
    }
}
