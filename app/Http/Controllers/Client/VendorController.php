<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    // get all vendors 
    public function vendors(Request $request) {
        $vendors = User::AllVendors()->ActiveLicense()->where(function($q){
            if (request('name')) {
                $q->where('name','LIKE','%'.request('name').'%');
            }
        })->paginate(10);
        return view('client.vendors.search', compact('vendors'));
    }

    public function vendorShow(Request $request) {
        $user = User::with(['occupation','specialty','qualification'])->withCount(['vendorOrders','consultingVendor'])->findOrFail($request->id);
        return view('client.vendors.profile', compact('user'));
    }
}
