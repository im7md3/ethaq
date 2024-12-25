<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Traits\JodaResource;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    use JodaResource;
    public $rules = [
        'order_id' => 'required',
        'vendor_id' => 'required',
        'amount' => 'required',
        'response_speed' => 'required',
        'duration' => 'required',
        'days' => 'required_if:duration,specified',
        'negotiable' => 'nullable',
        'status'=>'nullable',
        'works'=>'required',
        'documents'=>'required',
        'execution_method'=>'required',
        'other_execution_method'=>'required_if:execution_method,other',
        'decision_place'=>'required_if:duration,unspecified',
        'committee'=>'nullable',
        'management'=>'nullable',
        'images.*' => 'max:15360'
    ];
    public function beforeStore()
    {
        request()->merge(['negotiable'=>request('negotiable')?true:false,'status'=>'pending']);
    }
    public function afterStore($offer)
    {
        return back()->with('success','تم إضافة العرض بنجاح');
    }
}
