<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Objection;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ObjectionController extends Controller
{
    public function index($hash_code){
        $order=Order::with(['objectionTalks'])->withCount(['documents','objectionTalks','events'=>function($q){
            $q->whereNull('is_seen');
        },'invoices'=>function($q){
            $q->where('from_id',auth()->id());
        }])->where('hash_code',$hash_code)->first();
        $user=auth()->user();
        $other_id=auth()->id()==$order->client_id?$order->vendor_id:$order->client_id;
        $objection=Objection::with(['user','files','voices'])->where('order_id',$order->id)->first();
        $period=$order->judger_period;
        $other=User::findOrFail($other_id);
        return view($user->type.'.order.objection',compact('order','user','objection','other','period'));
    }

    public function store(Request $request){
        $data=$request->validate([
            'order_id'=>'required',
            'user_id'=>'required',
            'content'=>'required',
            'images.*' => 'max:15360'
        ]);
        $objection=Objection::create($data);
        $order=Order::findOrFail($request->order_id);
        $order->update(['objection_id'=>$objection->id,'status'=>'judger Decision']);
        if(request('images')){
            foreach(request('images') as $image){
                Attachment::store($image,$objection);
            }
        }
        return back()->with('success','تم إضافة الاعتراض ورفع الطلب الى المحكم');
    }

    public function seen(Request $request,Objection $objection){
        $data=$request->validate([
            'other_side_is_seen'=>'required',
            'other_side_message'=>'nullable',
        ]);
        $objection->update($data);
        return redirect()->route(auth()->user()->type.'.objection',$objection->order->hash_code)->with('success','تم الاطلاع على الاعتراض');
    }

    public function time(Request $request,Objection $objection){
        $data=$request->validate([
            'time'=>'required',
        ]);
        $data['time']=$request->time+$request->period;
        $objection->update($data);
        return back()->with('success','تم ارسال مدة التحكيم بنجاح');
    }

    public function client_decision(Request $request,Objection $objection){
        $data=$request->validate([
            'client_decision'=>'required',
            'client_refused_msg'=>'required_if:client_decision,refused'
        ]);
        $objection->update($data);
        return back()->with('success','تم ارسال الرد بنجاح');
    }
    public function vendor_decision(Request $request,Objection $objection){
        $data=$request->validate([
            'vendor_decision'=>'required',
            'vendor_refused_msg'=>'required_if:vendor_decision,refused'
        ]);
        $objection->update($data);
        return back()->with('success','تم ارسال الرد بنجاح');
    }

    public function arbitration($hash_code){
        $order=Order::with('objection')->firstWhere('hash_code',$hash_code);
        $user1=$order->objection->user->load('city');
        $user2=$order->objection->user_id==$order->client_id?$order->vendor->load('city'):$order->client->load('city');
        return view('judger.order.arbitration',compact('order','user1','user2'));
    }
    public function arbitrationStore(Request $request,Order $order){
        $data=$request->validate(['judger_judgment'=>'required']);
        $data['judger_judgment_time']=now();
        $data['judger_id']=auth()->id();
        $objection=Objection::firstWhere('order_id',$order->id);
        $order->update(['status'=>'VerdictHasBeenIssued']);
        $objection->update($data);
        return redirect()->route('judger.orders.show',$order->hash_code)->withSuccess('تم إصدار القرار بنجاح');
    }
    public function objectionJudgment(Request $request){
        
        $user=auth()->user();
        $data=$request->validate([
            $user->type.'_objection_reason'=>'nullable',
            'objection_id'=>'required',
        ]);
        $data[$user->type.'_objection']=1;
        $obj=Objection::findOrFail($request->objection_id);
        $obj->update($data);
        return back()->with('success','تم ارسال طلب الاعتراض بنجاح');
    }
}
