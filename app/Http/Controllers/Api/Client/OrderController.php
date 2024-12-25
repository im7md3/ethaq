<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Department;
use App\Models\JudgerOrder;
use App\Models\Log;
use App\Models\Offer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    protected $arrWith = ['client', 'department', 'mainDepartment'];

    public function index()
    {
        $request = request('selected');
        //$encrypted = request()->encrypted;
        /*         $orders = Order::when($status, function ($q) use ($status) {
            $q->where('status', $status);
        })->when($encrypted, function ($q) use ($encrypted) {
            $q->where('encrypted', $encrypted);
        })->where('client_id', auth()->user()->id)->latest()->take(5)->get(); */
        $user = auth('sanctum')->user();
        if ($request == 'ongoing' || $request == 'pending' || $request == 'done' || $request == 'open' || $request == 'cancel') {
            $orders = $this->getOrdersByStatus($user, $request)->paginate(10);
        } elseif ($request == 'judger') {
            $orders = $this->getJudgerOrders($user)->paginate(10);
        } else {
            $orders = $this->getModernOrders($user)->paginate(10);
        }

        return responseApi(true, '', ['orders' => $orders]);
    }

    public function getModernOrders($user)
    {
        $newOrders = Order::with($this->arrWith)->where('status', 'open')->whereDoesntHave('vendors')->orWhereHas('vendors', function ($q) use ($user) {
            $q->where('client_id', $user->id);
        });
        $myOrders = Order::with($this->arrWith)->where('client_id', $user->id);
        return $newOrders->union($myOrders)->latest('id');
    }

    public function getOrdersByStatus($user, $status)
    {
        if ($status == 'pending') {
            return Order::with($this->arrWith)->where('status', 'open')->whereHas('offers', function ($q) use ($user) {
                $q->where('client_id', $user->id)->where('status', 'pending');
            })->latest('id');
        } elseif ($status == 'cancel') {
            return Order::with($this->arrWith)->where('client_id', $user->id)->where('status', 'cancel')->latest('id');
        } elseif ($status == 'open') {
            return Order::with($this->arrWith)->where('client_id', $user->id)->where('status', 'open')->latest('orders.id');
        } elseif ($status == 'ongoing') {
            return Order::with($this->arrWith)->where('client_id', $user->id)->where(function ($q) {
                $q->where('status', 'ongoing')->orWhere('status', 'request_done');
            })->latest('id');
        } else {
            return Order::with($this->arrWith)->where(function ($q) use ($status, $user) {
                $q->where('client_id', $user->id);
                $q->where('orders.status', $status);
            })->latest('orders.id');
        }
    }

    public function getJudgerOrders($user)
    {
        return Order::with($this->arrWith)->where('client_id', $user->id)->whereNotNull('objection_id')->latest('id');
    }

    public function private()
    {
        $request = request('selected');
        $user = auth('sanctum')->user();
        $orders = Order::with($this->arrWith)->where('client_id', $user->id)->whereHas('vendors')->where(function ($q) use ($request) {
            if ($request) {
                $q->where('status', $request);
            }
        })->latest('id')->paginate(10);
        return responseApi(true, '', ['orders' => $orders]);
    }


    public function getFavoritesOrders($user)
    {
        return Order::with($this->arrWith)->whereHas('favorites', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->latest('id');
    }


    public function show($hash_code)
    {

        $order = Order::where('hash_code', $hash_code)->first();
        $user = auth('sanctum')->user();
        $main_department = $order->mainDepartment?->name;
        $sub_department = $order->DepartmentName;
        $order->ActiveJudger;
        $step = $order->IndexStep;
        $msg = $order->MessageStage;
        if ($order->HasUnpaidInvoices) {
            $paid = false;
        } else {
            $paid = true;
        }
        $selected_judgers = [];
        $unpaid_invoices = [];
        $hasPendingBankTransfer = 0;
        if ($order->offer_id) {
            $order = $this->show_after_accept_offer($order);
            $screen = 'order';
            if ($order->bankTransfers()->where('status', 'pending')->latest()->first()) {
                $hasPendingBankTransfer = 1;
            }
            if ($order->IsReadyToSelectJudgerOrAccept and $order->ClientPendingSelectedJudgers->count() > 0) {
                $selected_judgers = $order->ClientPendingSelectedJudgers;
            }
            if ($user->invoicesForOrder($order->id, 'vendor', 'unpaid')->count() > 0) {
                $unpaid_invoices = $user->invoicesForOrder($order->id, 'vendor', 'unpaid')->get();
            }
            if ($user->invoicesForOrder($order->id, 'judger', 'unpaid')->count() > 0) {
                $unpaid_invoices = $user->invoicesForOrder($order->id, 'judger', 'unpaid')->get();
            }
        } else {
            $order = $this->show_before_accept_offer($order);
            $screen = 'offers';
        }

        $download_contract = route('api.client.contract.download', $order->id);
        $data = ['user' => $user, 'step' => $step, 'msg' => $msg, 'paid' => $paid, 'screen' => $screen, 'main_department' => $main_department, 'sub_department' => $sub_department, 'order' => $order, 'selected_judgers' => $selected_judgers, 'unpaid_invoices' => $unpaid_invoices, 'download_contract' => $download_contract, 'hasPendingBankTransfer' => $hasPendingBankTransfer];
        return responseApi(true, '', $data);
    }

    public function show_before_accept_offer($order)
    {
        return $order->loadCount(['views', 'offers', 'DecryptionRequests'])->load(['invoices', 'voices', 'files', 'accessVendors' => function ($q) use ($order) {
            $q->with(['license', 'offers' => function ($offer) use ($order) {
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
        return $order->load(['vendor', 'files', 'invoices', 'activeOffer', 'activeNegotiation'])->loadCount(['views', 'documents', 'DecryptionRequests', 'events' => function ($q) {
            $q->whereNull('is_seen');
        }, 'invoices' => function ($q) {
            $q->where('from_id', auth('sanctum')->id());
        }]);
    }

    /* ************************* Select Judger Stage ***************************** */
    public function selectJudgerStage($order)
    {
        $selectedJudgers = JudgerOrder::with(['judger'])->where('order_id', $order->id)->where('client_decision', '<>', 'refused')->where('judger_decision', '<>', 'refused')->latest('id')->get();
        if ($selectedJudgers->count() == 2) {
            $showButtonSelectJudgers = false;
        } else {
            $showButtonSelectJudgers = true;
        }
        if (!$order->first_judger_id and $order->second_judger_id) {
            $msgButtonSelectJudgers = 'يجب عليك اختيار المحكم الأصيل';
        } elseif (!$order->second_judger_id and $order->first_judger_id) {
            $msgButtonSelectJudgers = 'يجب عليك اختيار المحكم الاحتياطي';
        } elseif (!$order->second_judger_id and !$order->first_judger_id) {
            $msgButtonSelectJudgers = 'يجب عليك اختيار المحكم الأصيل أو الاحتياطي';
        } else {
            $msgButtonSelectJudgers = 'برجاء انتظار رد المحامي أو المحكمين.';
            $selectedJudgers = [];
        }
        return array('selectedJudgers' => $selectedJudgers, 'showButtonSelectJudgers' => $showButtonSelectJudgers, 'msgButtonSelectJudgers' => $msgButtonSelectJudgers);
    }

    public function create()
    {
        $last_order = Order::latest('id')->first();
        $order_id = $last_order ? $last_order->id + 1 : 1;
        $departments = Department::where('name', "<>", 'الاستشارات')->get();
        $vendors = User::AllVendors()->with(['occupation', 'license', 'city', 'specialty'])->where(function ($q) {
            if (request('name')) {
                $q->where('name', 'LIKE', '%' . request('name') . '%');
            }
            if (request('department_id')) {
                $q->whereRelation('departments', function ($dep) {
                    $dep->where('departments.id', request('department_id'));
                });
            }
        })->ActiveLicense()->paginate(10);

        $data = ['order_id' => $order_id, 'departments' => $departments, 'vendors' => $vendors];
        return responseApi(true, '', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'main_department_id' => 'required',
            'department_id' => 'required_without:other_department',
            'other_department' => 'required_without:department_id',
            'client_id' => 'required',
            'vendor_id' => 'nullable',
            'vendors' => 'nullable',
            'title' => 'nullable',
            'details' => 'required',
            'encrypted' => 'nullable',
            'status' => 'nullable',
            'images.*' => 'max:15360'
        ]);

        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }

        $request->merge(['encrypted' => $request->encrypted ? true : false, 'status' => $request->status ? "archive" : "open"]);

        $order = Order::create($request->all());
        /* if ($request->vendors) {
            $order->vendors()->sync($request->vendors);
        } */
        if ($request->images) {
            foreach ($request->images as $image) {
                Attachment::store($image, $order);
            }
        }
        return responseApi(true, 'تم إضافة الطلب بنجاح', ['order' => $order]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), ['status' => 'nullable', 'encrypted' => 'nullable', 'refused_delivery_msg' => 'nullable']);

        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }

        $order->update($request->all());

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

        return responseApi(true, $msg, ['order' => $order]);
    }

    public function acceptOrder(Order $order)
    {
        $order->update([
            'status' => 'done'
        ]);

        $msg = 'تم استلام الطلب بنجاح';
        $step = $order->IndexStep;

        return responseApi(true, $msg, ['order' => $order, 'step' => $step,]);
    }

    public function logs($hash_code)
    {
        $order = Order::where('hash_code', $hash_code)->first();
        $user = auth('sanctum')->user();
        $logs = Log::where('order_id', $order->id)->where('type', 'order')->latest('id')->get();

        return responseApi(true, 'Logs Page', ['logs' => $logs]);
    }

    public function cancel(Order $order)
    {
        $order->update(['status' => 'cancel']);
        return responseApi(true, 'تمت العملية بنجاح بنجاح');
    }
}
