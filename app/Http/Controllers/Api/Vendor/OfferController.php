<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'amount' => 'required',
            'response_speed' => 'required',
            'duration' => 'required',
            'days' => 'required_if:duration,specified',
            'negotiable' => 'nullable',
            'status' => 'nullable',
            'works' => 'required',
            'documents' => 'required',
            'execution_method' => 'required',
            'other_execution_method' => 'required_if:execution_method,other',
            'decision_place' => 'required_if:duration,unspecified',
            'committee' => 'nullable',
            'management' => 'nullable',
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $request->merge(['negotiable' => $request->negotiable ? true : false,  'status'  => 'pending', 'vendor_id' => auth()->id()]);
        $offer = Offer::create($request->all());
        return responseApi(true, 'تم إضافة العرض بنجاح', ['offer' => $offer]);
    }
}
