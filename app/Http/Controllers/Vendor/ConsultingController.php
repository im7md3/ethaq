<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\AccessVendorConsulting;
use App\Models\Consulting;
use App\Models\ConsultingMessages;
use App\Models\ConsultingOffers;
use Illuminate\Http\Request;

class ConsultingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $consulting = Consulting::with(['client', 'department'])->withCount(['evaluate'])->InUserDepartments()->where(function ($q) use($user){
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
        return view('vendor.consulting.index', compact('user', 'consulting', 'active_count', 'done_count', 'cancel_count','pending_count'));
    }

    public function show(Consulting $consulting)
    {
        $con = $consulting->load(['client', 'vendor', 'files', 'voices', 'messages', 'evaluate', 'invoices'])->loadCount('evaluate');
        ConsultingMessages::markMessagesAsSeen($con->id);
        $from = auth()->id();
        $to = $con->client_id;
        $user = auth()->user();
        $my_offer = ConsultingOffers::where('vendor_id', $user->id)->where('consulting_id', $con->id)->first();
        return view('vendor.consulting.show', compact('con', 'from', 'to', 'user', 'my_offer'));
    }
    public function consultingAccess(Request $request)
    {
        $data = $request->validate(['vendor_id' => 'required', 'consulting_id' => 'required']);
        AccessVendorConsulting::create($data);
        return back()->with('success', 'تم الموافقة بنجاح');
    }

    public function update(Request $request, Consulting $consulting)
    {
        $data = $request->validate(['status' => 'required']);
        $consulting->update($data);
        if ($request->status == 'cancel') {
            $msg = 'تم إلغاء الاستشارة بنجاح';
        }
        return back()->with('success', $msg);
    }
}
