<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Models\AccessVendorConsulting;
use App\Models\Consulting;
use App\Models\ConsultingMessages;
use App\Models\ConsultingOffers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $consulting = Consulting::with(['client', 'department','vendor','invoices'])->withCount(['evaluate'])->InUserDepartments()->where(function ($q) use($user){
            if (!request('status') || request('status') == 'pending') {
                $q->where('private','<>',1)->where('status','pending')->where(function($f) use($user){
                    $f->whereNull('vendor_id')->orWhere('vendor_id',$user->id);
                });
            }  elseif (request('status')) {
                $q->where('vendor_id', auth()->id());
                $q->where('status', request('status'));
            }
        })->latest('id')->paginate(10);
        $pending_count = Consulting::where('private','<>',1)->where('status','pending')->InUserDepartments()->where(function($f) use($user){
            $f->whereNull('vendor_id')->orWhere('vendor_id',$user->id);
        })->count();
        $active_count = Consulting::where('vendor_id', auth()->id())->InUserDepartments()->where('status','active')->count();
        $done_count = Consulting::where('vendor_id', auth()->id())->InUserDepartments()->where('status', 'done')->count();
        $cancel_count = Consulting::where('vendor_id', auth()->id())->InUserDepartments()->where('status', 'cancel')->count();
        return responseApi(true, '', ['consulting' => $consulting,'pending_count'=>$pending_count,'active_count'=>$active_count,'done_count'=>$done_count,'cancel_count'=>$cancel_count]);
    }

    public function show($id)
    {
        $consulting = Consulting::find($id);
        if ($consulting) {
            $con = $consulting->load(['client', 'vendor', 'files','voices', 'messages', 'evaluate', 'invoices'])->loadCount('evaluate');
            ConsultingMessages::markMessagesAsSeen($con->id);
            if ($con->department_id) {
                $department = $con->department?->name;
            } else {
                $department = $con->other_department;
            }
            $screen = $con->ScreenForApi;
            $user = auth()->user();
            $can_access=$user->canAccessConsulting($con);
            $my_offer = ConsultingOffers::where('vendor_id', $user->id)->where('consulting_id', $con->id)->first();
            $data = ['screen' => $screen, 'department' => $department, 'consulting' => $con, 'my_offer' => $my_offer,'can_access'=>$can_access];
            return responseApi(true, '', $data);
        } else {
            return responseApi(false, 'لا يوجد استشارة');
        }
    }

    public function consultingAccess(Request $request){
        $validator =Validator::make($request->all(), [
            'vendor_id'=>'required','consulting_id'=>'required'
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        AccessVendorConsulting::create($request->all());
        return responseApi(true, 'تم الموافقة بنجاح');
    }

}
