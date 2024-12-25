<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\SpecialService;
use App\Models\SpecialServiceMessage;
use Illuminate\Http\Request;

class SpecialServiceController extends Controller
{
    public function index()
    {
        $services = SpecialService::where('client_id',auth()->id())->latest()->paginate();
        return view('client.special_services.index', compact('services'));
    }
    public function create()
    {
        return view('client.special_services.create');
    }
    public function show(SpecialService $specialService)
    {
        $specialService->load(['client','files','voices','messages.user','messages.files']);
        return view('client.special_services.show', compact('specialService'));
    }
    public function store(Request $request){
        $data=$request->validate([
            'title'=>'required',
            'details'=>'required',
            'status'=>'nullable',
        ]);
        $data['client_id']=auth()->id();
        $data['status']='pending';
        $service=SpecialService::create($data);
        if (request('images')) {
            foreach (request('images') as $image) {
                Attachment::store($image, $service);
            }
        }
        return redirect()->route('client.specialServices.index')->with('success','تم إضافة الخدمة بنجاح');
    }
    public function storeMessage(Request $request,SpecialService $specialService){
        $data=$request->validate([
            'content'=>'required_without:images',
            'images'=>'required_without:content',
        ]);
        $data['user_id']=auth()->id();
        $data['service_id']=$specialService->id;
        $msg=SpecialServiceMessage::create($data);
        if (request('images')) {
            foreach (request('images') as $image) {
                Attachment::store($image, $msg);
            }
        }
        return back()->with('success','تم إرسال الرسالة بنجاح');
    }
}
