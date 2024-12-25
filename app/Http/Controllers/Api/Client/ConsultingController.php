<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Consulting;
use App\Models\ConsultingEvaluation;
use App\Models\ConsultingMessages;
use App\Models\ConsultingOffers;
use App\Models\Department;
use App\Models\Log;
use App\Models\User;
use App\Service\ClickPay;
use App\Service\Tap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultingController extends Controller
{
    public function index()
    {
        $consulting = Consulting::with(['client', 'department', 'vendor', 'invoices', 'evaluate'])->withCount('evaluate')->where('client_id', auth()->id())->where(function ($q) {
            if (request(('status'))) {
                $q->where('status', request('status'));
            }
        })->latest('id')->paginate(10);

        $pending_count = Consulting::where('client_id', auth()->id())->where('status', 'pending')->count();
        $active_count = Consulting::where('client_id', auth()->id())->where('status', 'active')->count();
        $done_count = Consulting::where('client_id', auth()->id())->where('status', 'done')->count();
        $cancel_count = Consulting::where('client_id', auth()->id())->where('status', 'cancel')->count();
        $all_count = Consulting::where('client_id', auth()->id())->count();

        $data = ['consulting' => $consulting, 'pending_count' => $pending_count, 'active_count' => $active_count, 'done_count' => $done_count, 'cancel_count' => $cancel_count, 'all_count' => $all_count];

        return responseApi(true, '', $data);
    }

    public function create()
    {
        $departments = Department::Consultings()->get();
        $vendors = User::AllVendors()->ActiveLicense()->where(function ($q) {
            if (request('name') and request('name') != "") {
                $q->where('name', 'LIKE', '%' . request('name') . '%');
            }
            if (request('department_id') && request('department_id') != 1000) {
                $q->whereRelation('departments', function ($dep) {
                    $dep->where('departments.id', request('department_id'));
                });
            }
        })->where('consulting_price', '>', 0)->with(['occupation', 'license'])->paginate(10);
        $data = ['departments' => $departments, 'vendors' => $vendors];
        return responseApi(true, '', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'other_department' => 'required_without:department_id',
            'department_id' => 'required_without:other_department',
            'client_id' => 'required',
            'vendor_id' => 'nullable',
            'details' => 'required',
            'status' => 'nullable',
            'min' => 'nullable',
            'sec' => 'nullable',
            'free' => 'nullable',
            'images.*' => 'max:15360'
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }

        $request->merge(['status' => 'pending', 'min' => "0", 'sec' => '0']);
        if ($request->vendor_id !== null) {
            $vendor = User::find($request->vendor_id);
            if ($vendor) {
                $request->merge(['amount' => $vendor->consulting_price, 'private' => 1]);
            }
        }

        $Consulting = Consulting::create($request->all());

        if (request('images')) {
            foreach (request('images') as $image) {
                Attachment::store($image, $Consulting);
            }
        }

        if ($Consulting->vendor_id) {

            $invoice = $Consulting->invoices;
            if (env('APP_ENV') == 'local') {
                $invoice->update(['status' => 'paid']);
            } else {
                return responseApi(true, 'يرجى تسديد مبلغ الاستشارة', [/* 'url' => $response->redirect_url, */'id' => (int)$Consulting->id, 'user_id' => (int)$Consulting->client_id]);
            }
        }
        $data = ['Consulting' => $Consulting, 'id' => (int)$Consulting->id, 'user_id' => (int)$Consulting->client_id];
        return responseApi(true, 'تم إضافة الاستشارة بنجاح', $data);
    }

    public function acceptOffer(Request $request)
    {
        $rules = ['status' => 'nullable', 'offer_id' => 'required_without:con_id', 'con_id' => 'required_without:offer_id'];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        if ($request->offer_id) {
            $offer = ConsultingOffers::findOrFail($request->offer_id);
            $Consulting = $offer->consulting;
            $offer->update($request->all());
        } elseif ($request->con_id) {
            $Consulting = Consulting::findOrFail($request->con_id);
        }
        $invoice = $Consulting->invoices;
        if (env('APP_ENV') == 'local') {
            $invoice->update(['status' => 'paid']);
            return responseApi(true, 'تم تسديد مبلغ الاستشارة');
        } else {
            /* $route = route('api.front.tap.callback', ['invoice' => $invoice->id]);
            $response = Tap::store($invoice->total, $route);
            return responseApi(true, 'يرجى تسديد مبلغ الاستشارة', ['url' => $response->transaction->url]); */
            $route = route('api.front.clickpay.callback', ['user' => auth()->id(), 'order' => $Consulting->id, 'invoice' => $invoice->id]);
            $response = ClickPay::store($invoice, $route);
            return responseApi(true, 'يرجى تسديد مبلغ الاستشارة', ['url' => $response->redirect_url]);
        }
    }



    public function show($id)
    {
        $consulting = Consulting::find($id);
        if ($consulting) {
            $con = $consulting->load(['offers.vendor:id,name,photo', 'client', 'vendor', 'files', 'voices', 'messages', 'evaluate', 'invoices'])->loadCount(['evaluate', 'messages']);
            ConsultingMessages::markMessagesAsSeen($con->id);
            if ($con->department_id) {
                $department = $con->department?->name;
            } else {
                $department = $con->other_department;
            }
            $screen = $con->ScreenForApi;
            // $payMessage=$con->PayMessage;
            return responseApi(true, '', ['screen' => $screen, 'department' => $department, 'consulting' => $con]);
        } else {
            return responseApi(false, 'لا يوجد استشارة');
        }
    }


    public function evaluate(Request $request)
    {
        $rules = ['value' => 'required', 'consulting_id' => 'required', 'client_id' => 'required', 'vendor_id' => 'required'];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        ConsultingEvaluation::create($request->all());
        return responseApi(true, 'تم إرسال التقييم بنجاح');
    }

    public function payMessage($con)
    {
        $msg = "";
        if ($con->invoices?->status == 'paid') {
            $msg = "تم الدفع";
        } else {
            if ($con->vendor_id and !$con->free and $con->invoices) {
                $msg = "سداد";
            }
        }
        return $msg;
    }
}
