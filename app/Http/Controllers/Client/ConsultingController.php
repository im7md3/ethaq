<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Consulting;
use App\Models\ConsultingEvaluation;
use App\Models\ConsultingInvoices;
use App\Models\ConsultingMessages;
use App\Models\ConsultingOffers;
use App\Models\Department;
use App\Models\Invoice;
use App\Models\User;
use App\Service\ClickPay;
use App\Service\Tap;
use App\Traits\JodaResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConsultingController extends Controller
{
    use JodaResource;
    public $rules = [
        // 'other_department' => 'required_without:department_id',
        'department_id' => 'required',
        'client_id' => 'required',
        'vendor_id' => 'nullable',
        'details' => 'required',
        'status' => 'nullable',
        'min' => 'nullable',
        'sec' => 'nullable',
        'free' => 'nullable',
        'private' => 'nullable',
        'amount' => 'nullable',
        'images.*' => 'max:15360'
    ];
    public function index()
    {
        $user = auth()->user()->loadCount(['invoices' => function ($q) {
            $q->where('status', 'unpaid');
        }]);
        $consulting = Consulting::with(['client', 'department'])->withCount('evaluate')->where('client_id', auth()->id())->where(function ($q) {
            if (request(('status'))) {
                $q->where('status', request('status'));
            }
        })->latest('id')->paginate(10);
        $pending_count = Consulting::where('client_id', auth()->id())->where('status', 'pending')->count();
        $all_count = Consulting::where('client_id', auth()->id())->count();
        $active_count = Consulting::where('client_id', auth()->id())->where('status', 'active')->count();
        $done_count = Consulting::where('client_id', auth()->id())->where('status', 'done')->count();
        $cancel_count = Consulting::where('client_id', auth()->id())->where('status', 'cancel')->count();
        return view('client.consulting.index', compact('user', 'consulting', 'pending_count', 'active_count', 'done_count', 'cancel_count', 'all_count'));
    }
    public function create()
    {
        $last_consultation = Consulting::latest('id')->first();
        $vendor_id = request('vendor_id') ?? null;
        if ($vendor_id) {
            $vendor = User::findOrFail($vendor_id);
        }
        $consultation_id = $last_consultation ? $last_consultation->id + 1 : 1;
        $departments = Department::Consultings()->get();
        $vendors = User::AllVendors()->ActiveLicense()->where('consulting_price', '>', 0)->with(['occupation', 'license'])->get();
        return view('client.consulting.create', compact('departments', 'vendors', 'consultation_id', 'vendor_id'));
    }
    public function beforeStore()
    {
        // 'rest_time' => Carbon::createFromFormat('i', setting('consultation_time'))->format('i:s')
        request()->merge(['status' => 'pending', 'min' => "0", 'sec' => '0']);
        if (request('vendor_id')) {
            $vendor = User::findOrFail(request('vendor_id'));
            request()->merge(['amount' => $vendor->consulting_price, 'private' => 1]);
        }
    }
    public function afterStore($Consulting)
    {
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
                $route = route('clickpay.callback', ['user' => auth()->id(), 'order' => $Consulting->id, 'invoice' => $invoice->id]);
                $response = ClickPay::store($invoice, $route);
                return redirect($response->redirect_url);
            }
        }

        return redirect()->route('client.profile')->with('success', 'تم إضافة الاستشارة بنجاح');
    }

    public function acceptOffer(Request $request)
    {
        $data = $request->validate(['status' => 'required', 'offer_id' => 'required']);
        $offer = ConsultingOffers::findOrFail($request->offer_id);
        $Consulting = $offer->consulting;
        $offer->update($data);
        $invoice = $Consulting->invoices;
        if (env('APP_ENV') == 'local') {
            $invoice->update(['status' => 'paid']);
            return back()->with('success');
        } else {
            /* $route = route('client.consulting.callback', ['invoice' => $invoice->id]);
            $response = Tap::store($invoice->total, $route);
            return redirect($response->transaction->url); */
            /*  $route = route('clickpay.callback', ['user'=>auth()->id(),'order'=>$Consulting->id,'invoice' => $invoice->id]);
            $response = ClickPay::store($invoice, $route); */
            return redirect()->route('clickpay.store', $invoice);
        }
    }
    public function show(Consulting $consulting)
    {
        $con = $consulting->load(['offers', 'client', 'vendor', 'files', 'voices', 'messages', 'evaluate', 'invoices'])->loadCount(['evaluate', 'messages']);
        ConsultingMessages::markMessagesAsSeen($con->id);
        $from = auth()->id();
        $to = $con->vendor_id;
        return view('client.consulting.show', compact('con', 'from', 'to'));
    }
    public function update(Request $request, Consulting $consulting)
    {
        $data = $request->validate(['status' => 'required']);
        $consulting->update($data);
        if ($request->status == 'cancel') {
            $msg = 'تم إلغاء الاستشارة بنجاح';
        } else {
            $msg = 'تم إنهاء الاستشارة بنجاح';
        }
        return back()->with('success', $msg);
    }

    public function evaluate(Request $request)
    {
        $data = $request->validate(['value' => 'required', 'consulting_id' => 'required', 'client_id' => 'required', 'vendor_id' => 'required']);
        ConsultingEvaluation::create($data);
        return back()->with('success', 'تم إرسال التقييم بنجاح');
    }
}
