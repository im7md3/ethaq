<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Log;
use App\Models\Order;
use App\Traits\JodaResource;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    use JodaResource;

    public $rules = [
        'main_department_id' => 'required',
        'department_id' => 'nullable',
        'other_department' => 'required_without:department_id',
        'client_id' => 'required',
        'vendor_id' => 'nullable',
        'title' => 'required',
        'details' => 'required',
        'encrypted' => 'nullable',
        'status' => 'nullable',
        'images.*' => 'max:15360',
        'refused_msg' => 'nullable',
        'money_back' => 'nullable',
        'contract_file' => 'nullable|max:15360|mimes:pdf',
    ];

    public function query($query)
    {
        return $query->with(['client', 'vendor', 'firstJudger', 'department'])->where(function ($q) {
            if (request('status')) {
                $q->where('status', request('status'));
            }
            if (request('paid')) {
                $q->whereHas('invoices', function ($i) {
                    $i->where('status', 'paid');
                });
            }
            if (request('unpaid')) {
                $q->whereHas('invoices', function ($i) {
                    $i->where('status', 'unpaid');
                });
            }
            if (request('search')) {
                $q->where('id', request('search'))->orWhereRelation('client', 'name', 'LIKE', "%" . request('search') . "%")->orWhereRelation('vendor', 'name', 'LIKE', "%" . request('search') . "%");
            }
        })->latest()->paginate(10);
    }

    public function beforeStore()
    {
        request()->merge(['encrypted' => request('encrypted') ? true : false]);
    }
    public function beforeUpdate($order)
    {
        request()->merge(['encrypted' => request('encrypted') ? true : false, 'money_back' => request('money_back') ? true : false]);
    }
    public function afterStore($order)
    {
        if (request('images')) {
            foreach (request('images') as $image) {
                Attachment::store($image, $order);
            }
        }
        return redirect()->route("admin.orders.index")->with('success', 'تم إضافة الطلب بنجاح');
    }
    public function afterUpdate($order)
    {
        if (request('contract_file')) {
            $order->update(['contract_file' => store_file(request()->file('contract_file'), 'orders')]);
        }
    }

    public function show($hash_code)
    {
        $order = Order::with(['invoices', 'activeOffer', 'activeNegotiation'])->withCount(['events', 'documents', 'invoices' => function ($q) {
            $q->where('from_id', auth()->id());
        }])->where('hash_code', $hash_code)->first();
        $user = auth()->user();
        return view('admin.order.show', compact('order', 'user'));
    }
    public function logs($hash_code)
    {
        $order = Order::where('hash_code', $hash_code)->first();
        $user = auth()->user();
        $logs = Log::where('order_id', $order->id)->where('type', 'order')->latest('id')->paginate(15);
        return view('admin.order.logs', compact('user', 'order', 'logs'));
    }

    public function exports()
    {
        $orders = Order::with(['client', 'vendor', 'firstJudger', 'department'])->where(function ($q) {
            if (request('status')) {
                $q->where('status', request('status'));
            }
        })->latest()->get();
        return Excel::download(new OrdersExport($orders), 'orders' . time() . '.xlsx');
    }
}
