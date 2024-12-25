<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Consulting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function vendors(Request $request) {
        $vendors = User::AllVendors()->ActiveLicense()->where(function($q){
            if (request('name')) {
                $q->where('name','LIKE','%'.request('name').'%');
            }
        })->paginate(10);
        return view('front.vendors.search', compact('vendors'));
    }

    public function vendorShow(Request $request) {
        $user = User::with(['occupation','specialty','qualification'])->withCount(['vendorOrders','consultingVendor'])->findOrFail($request->id);
        return view('front.vendors.profile', compact('user'));
    }

    public function createConsultation(User $vendor){
        $departments=$vendor->consultingDepartments;
        return view('front.vendors.createConsultation',compact('vendor','departments'));
    }
    public function storeConsultation(Request $request){
        $data=$request->validate([
            'name'=>auth()->check()?'nullable':'required',
            'phone'=>auth()->check()?'nullable':'required|unique:users,phone',
            'password'=>auth()->check()?'nullable':'required',
            'amount'=>'required',
            'vendor_id'=>'required',
            'department_id'=>'required',
            'details'=>'required',
            'status'=>'required',
            'images'=>'nullable',
        ]);
        if(!auth()->check()){
            $client=User::create(['name'=>$data['name'],'password'=>Hash::make($data['password']),'type'=>'client','membership'=>'individual','phone'=>$data['phone']]);
            auth()->loginUsingId($client->id);
            $data['client_id']=$client->id;
        }else{
            $data['client_id']=auth()->id();
        }
        $Consulting=Consulting::create($data);
        if (request('images')) {
            foreach (request('images') as $image) {
                Attachment::store($image, $Consulting);
            }
        }
        return redirect()->route('client.consulting.show',$Consulting)->with('success','تم انشاء الاستشارة بنجاح');
    }
}
