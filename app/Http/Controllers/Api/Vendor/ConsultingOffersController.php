<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Models\ConsultingOffers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultingOffersController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount'=>['required','lte:'.setting('pay_later_max'),'gte:'.setting('minimum_amount_for_consultation')],
            'vendor_id' => 'required',
            'consulting_id' => 'required'
        ]);

        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $user=auth('sanctum')->user();
        if(!$user->consulting_price){
            return responseApi(false,'الرجاء تعديل سعر الاستشارة أولا');
        }
        $offer = ConsultingOffers::create($request->all());

        return responseApi(true, 'تم إضافة العرض بنجاح', ['offer' => $offer]);
    }
}
