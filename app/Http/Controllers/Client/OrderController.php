<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Department;
use App\Models\Log;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderFile;
use App\Models\User;
use App\Traits\JodaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use JodaResource;
    public function show($hash_code)
    {
        $order = Order::where('hash_code', $hash_code)->first();
        $order->ActiveJudger;
        if ($order->offer_id) {
            $order = $this->show_after_accept_offer($order);
        } else {
            $order = $this->show_before_accept_offer($order);
        }
        $user = auth()->user()->load(['invoices']);
        return view('client.order.show', compact('order', 'user'));
    }
    public function show_before_accept_offer($order)
    {
        return $order->load(['accessVendors' => function ($q) use ($order) {
            $q->with(['offers' => function ($offer) use ($order) {
                $offer->where('order_id', $order->id)->latest('id');
            }, 'negotiations' => function ($negotiation) use ($order) {
                $negotiation->where('order_id', $order->id);
            }])->withCount(['offers' => function ($offer) use ($order) {
                $offer->where('order_id', $order->id);
            }, 'messages' => function ($message) use ($order) {
                $message->where('order_id', $order->id);
            }]);
        }]);
    }
    public function show_after_accept_offer($order)
    {
        return $order->load(['invoices', 'activeOffer', 'activeNegotiation'])->loadCount(['documents', 'events' => function ($q) {
            $q->whereNull('is_seen');
        }, 'invoices' => function ($q) {
            $q->where('from_id', auth()->id());
        }]);
    }
    public function create()
    {
        $dep_id = request('dep_id');
        $vendor_id = request('vendor_id') ?? null;
        $last_order = Order::latest('id')->first();
        $order_id = $last_order ? $last_order->id + 1 : 1;
        $departments = Department::where('name', "<>", 'الاستشارات')->get();
        $vendors = User::AllVendors()->with(['occupation', 'license'])->ActiveLicense()->take(5)->get();
        return view('client.order.create', compact('departments', 'vendors', 'order_id', 'dep_id', 'vendor_id'));
    }

    public $rules = [
        'main_department_id' => 'required',
        'department_id' => 'required_without:other_department',
        'other_department' => 'required_without:department_id',
        'client_id' => 'required',
        'vendor_id' => 'nullable',
        'title' => 'required',
        'details' => 'required',
        'encrypted' => 'nullable',
        'status' => 'nullable',
        'images.*' => 'max:15360'
    ];

    public function query($query)
    {
        return $query->with(['client', 'vendor', 'judger', 'department', 'files', 'voices'])->latest()->paginate(10);
    }

    public function beforeStore()
    {
        request()->merge(['encrypted' => request('encrypted') ? true : false, 'status' => request('status') ? 'archive' : 'open']);
    }
    public function afterStore($order)
    {
        /* if (request('vendors')) {
            $order->vendors()->sync(request('vendors'));
            $vendors = $order->vendors;

            $route = route('vendor.orders.show', $order->hash_code);
            $title = 'تم اختيارك في الطلب ' . $order->title . ' من العميل ' . $order->client->name;

            $notification_data = [
                'id' => intval($order->id),
                'type' => 'order',
                'hash_code' => $order->hash_code
            ];

            foreach ($vendors as $v) {
                Notification::send($v->id, $title, $route, 'new-order', $notification_data);
            }
        } */
        if (request('images')) {
            foreach (request('images') as $image) {
                Attachment::store($image, $order);
            }
        }
        return redirect()->route('client.profile')->with('success', 'تم إضافة الطلب بنجاح');
    }

    public function logs($hash_code)
    {
        $order = Order::where('hash_code', $hash_code)->first();
        $user = auth()->user();
        $logs = Log::where('order_id', $order->id)->where('type', 'order')->latest('id')->paginate(15);
        return view('client.order.logs', compact('user', 'order', 'logs'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate(['status' => 'nullable', 'encrypted' => 'nullable', 'refused_delivery_msg' => 'nullable']);
        $order->update($data);
        $msg = 'تم تحديث حالة التشفير بنجاح';
        if ($request->status == 'done') {
            $msg = 'تم استلام الطلب بنجاح';
        } elseif ($request->status == 'ongoing') {
            $msg = 'تم رفض تسليم الطلب بنجاح';
        } elseif ($request->status == 'archive') {
            $msg = 'تم جعل الطلب كمسودة';
        } elseif ($request->status == 'open') {
            $msg = 'تم فتح الطلب ';
        } elseif ($request->status == 'close') {
            $msg = 'تم إغلاق الطلب ';
        }
        return back()->withSuccess($msg);
    }

    public function cancel(Order $order)
    {
        $order->update(['status' => 'cancel']);
        return back()->with('success', 'تمت العملية بنجاح بنجاح');
    }
}
