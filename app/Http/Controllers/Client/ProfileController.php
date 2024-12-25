<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\City;
use App\Models\Commercial;
use App\Models\Country;
use App\Models\Department;
use App\Models\License;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile()
    {
        $user=auth()->user()->loadCount(['invoices'=>function($q){
            $q->where('status','unpaid');
        }]);
        $orders=Order::where('client_id',$user->id)->with(['client','files','voices'])->withCount('views')->where(function($q){
            if(request('status')){
                if(request('status')=='done'){
                    $q->where('status','done')->orWhere('status','request_done');
                }elseif(request('status')=='private'){
                    $q->whereHas('vendors');
                }else{
                    $q->where('status',request('status'));
                }
            }
        })->latest('id')->simplePaginate(10);
        $departments=Department::where('parent',1)->get();
        return view('client.profile',compact('departments','orders','user'));
    }
    public function settings()
    {
        $user = auth()->user()->load(['country', 'city']);
        $countries = Country::all();
        $cities = City::all();
        $banks = Bank::all();
        return view('client.settings', compact('user', 'countries', 'cities','banks'));
    }
    public function updateSettings(Request $request)
    {
        $user = User::findOrFail($request->id);
        $data = $request->validate([
            'name' => 'required',
            'city_id' => 'nullable',
            'city_name' => 'nullable',
            'email' => ['nullable', 'email', 'unique:users,email,' . $user->id],
            'username' => ['nullable', 'unique:users,username,' . $user->id],
            'id_number' => ['required', 'integer', 'digits:10', 'unique:users,id_number,' . $user->id],
            'gender' => 'nullable',
            'company_number' => 'nullable',
            'company_name' => 'nullable',
            'birthdate' => 'nullable',
            'id_end' => 'nullable',
            'tax_number' => 'nullable',
            'bank_account' => 'nullable', 'integer', 'min:14',
            'bank_id' => 'nullable|exists:banks,id',
            'iban_cer_photo'=>'required'
        ]);
        if ($request->image) {
            delete_file($user->getRawOriginal('photo'));
            $data['photo'] = store_file($request->image, 'clients');
        }
        if ($request->iban_cer_photo) {
            delete_file($user->iban_cer);
            $request->merge(['iban_cer' => store_file($request->iban_cer_photo, 'iban')]);
        }
        $user->update($data);
        return redirect()->route('client.profile')->with('success', 'تم تعديل البيانات بنجاح');
    }
    
    
}
