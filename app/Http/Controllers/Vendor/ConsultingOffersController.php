<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Consulting;
use App\Models\ConsultingOffers;
use Illuminate\Http\Request;

class ConsultingOffersController extends Controller
{
    public function store(Request $request){
        $data=$request->validate(['amount'=>['required','lte:'.setting('pay_later_max'),'gte:'.setting('minimum_amount_for_consultation')],'vendor_id'=>'required','consulting_id'=>'required']);
        $user=auth()->user();
        if(!$user->consulting_price){
            return back()->with('warning','الرجاء تعديل سعر الاستشارة أولا');
        }
        ConsultingOffers::create($data);
        return back()->with('success','تم إضافة العرض بنجاح');
    }
}
