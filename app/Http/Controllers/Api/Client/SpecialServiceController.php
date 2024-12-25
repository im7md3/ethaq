<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\SpecialService;
use App\Models\SpecialServiceMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecialServiceController extends Controller
{
    public function index()
    {
        $services = SpecialService::where(function($q){
            $q->where('client_id',auth()->id());
            if(request('status')){
                $q->where('status',request('status'));
            }
        })->latest()->paginate();
        return responseApi(true,'',['services'=>$services]);
    }
    public function show(SpecialService $specialService)
    {
        $specialService->load(['client','files','voices','messages.user','messages.files']);
        return responseApi(true,'',['service'=>$specialService]);
    }
    public function store(Request $request){
        $rules = [
            'details'=>'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $request->merge(['client_id'=>auth('sanctum')->id(),'title'=>'طلب','status'=>'pending']);
        $service=SpecialService::create($request->all());
        if (request('images')) {
            foreach (request('images') as $image) {
                Attachment::store($image, $service);
            }
        }
        return responseApi(true,'تم إضافة الخدمة بنجاح',['service'=>$service]);
    }

    public function storeMessage(Request $request,SpecialService $specialService){
        $rules = [
            'content'=>'required_without:images',
            'images'=>'required_without:content',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $request->merge(['user_id'=>auth('sanctum')->id(),'service_id'=>$specialService->id]);
        $msg=SpecialServiceMessage::create($request->all());
        if (request('images')) {
            foreach (request('images') as $image) {
                Attachment::store($image, $msg);
            }
        }
        return responseApi(true,'تم إرسال الرسالة بنجاح',['msg'=>$msg->load(['user','files'])]);
    }
}
