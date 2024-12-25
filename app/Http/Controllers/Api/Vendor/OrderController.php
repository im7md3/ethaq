<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Models\JudgerOrder;
use App\Models\Log;
use App\Models\Negotiation;
use App\Models\Offer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    protected $arrWith = ['client', 'department', 'mainDepartment'];

    public function orders()
    {
        $request = request('selected');
        $user = auth()->user();
        if ($request == 'ongoing' || $request == 'pending' || $request == 'done' || $request == 'open' || $request == 'cancel' || $request == 'request_done') {
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
        $newOrders = Order::with($this->arrWith)->Show()->InUserDepartments()->where('status', 'open')->whereDoesntHave('vendors')->orWhereHas('vendors', function ($q) use ($user) {
            $q->where('vendor_id', $user->id);
        });
        $myOrders = Order::with($this->arrWith)->Show()->InUserDepartments()->where('vendor_id', $user->id);
        return $newOrders->union($myOrders)->latest('id');
        // return Order::with($this->arrWith)->where('vendor_id', $user->id)->where('status', 'open');
    }

    public function getOrdersByStatus($user, $status)
    {
        if ($status == 'pending') {
            return Order::with($this->arrWith)->InUserDepartments()->where('status', 'pending')->whereHas('offers', function ($q) use ($user) {
                $q->where('vendor_id', $user->id)->where('status', 'pending');
            })->latest('id');
            /* return Order::with($this->arrWith)->where('status', 'open')->whereHas('offers', function ($q) use ($user) {
                $q->where('vendor_id', $user->id)->where('status', 'pending');
            })->latest('id'); */
        } elseif ($status == 'cancel') {
            return Order::with($this->arrWith)->where('vendor_id', $user->id)->where('status', 'cancel')->latest('id');
        } elseif ($status == 'open') {
            /* return Order::with($this->arrWith)->InUserDepartments()->where('status', 'open')->whereDoesntHave('vendors')->orWhereHas('vendors', function ($q) use ($user) {
                $q->where('vendor_id', $user->id);
            })->latest('orders.id'); */

            return Order::with($this->arrWith)->where('vendor_id', $user->id)->where('status', 'open')->latest('id');
        } elseif ($status == 'request_done') {
            return Order::with($this->arrWith)->where('vendor_id', $user->id)->where('status', 'request_done')->latest('id');
        } elseif ($status == 'ongoing') {
            return Order::with($this->arrWith)->where('vendor_id', $user->id)->where(function ($q) {
                $q->where('status', 'ongoing')->orWhere('status', 'request_done');
            })->latest('id');
            //return Order::with($this->arrWith)->where('vendor_id', $user->id)->where('status', 'ongoing')->latest('id');
        } else {
            return Order::with($this->arrWith)->InUserDepartments()->where(function ($q) use ($status, $user) {
                $q->where('vendor_id', $user->id);
                $q->where('orders.status', $status);
            })->latest('orders.id');
            /* return Order::with($this->arrWith)->where(function ($q) use ($status, $user) {
                $q->where('vendor_id', $user->id);
                $q->where('orders.status', $status);
            })->latest('orders.id');  */
        }
    }

    public function getJudgerOrders($user)
    {
        return Order::with($this->arrWith)->InUserDepartments()->where('vendor_id', $user->id)->whereNotNull('objection_id')->latest('id');
    }
    public function private()
    {
        $request = request('selected');
        $user = auth('sanctum')->user();
        $orders = Order::with($this->arrWith)->InUserDepartments()->whereHas('vendors', function ($q) use ($user) {
            $q->where('vendor_id', $user->id);
        })->where(function ($q) use ($request) {
            if ($request) {
                $q->where('status', $request);
            }
        })->latest('id')->paginate(10);
        return responseApi(true, '', ['orders' => $orders]);
    }


    public function getFavoritesOrders($user)
    {
        return Order::with($this->arrWith)->InUserDepartments()->whereHas('favorites', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->latest('id');
    }


    /* ************************* Show Order ***************************** */
    public function show($hash_code)
    {
        $screen = 'order';
        $data_encrypted = null;
        $order = Order::withCount(['documents', 'protests', 'events' => function ($q) {
            $q->whereNull('is_seen');
        }, 'invoices' => function ($q) {
            $q->where('from_id', auth()->id());
        }])->with(['invoices', 'files', 'voices', 'client'])->where('hash_code', $hash_code)->first();
        $main_department = $order->mainDepartment?->name;
        $sub_department = $order->DepartmentName;
        $order->ActiveJudger;
        $step = $order->IndexStep;
        $msg = $order->MessageStage;
        /* Start Select Judger Stage */
        $selectedJudgers = [];
        $refusedJudgers = [];
        $showButtonSelectJudgers = true;
        $msgButtonSelectJudgers = '';
        if ($step == 1) {
            $selectJudgerStage = $this->selectJudgerStage($order);
            $selectedJudgers = $selectJudgerStage['selectedJudgers'];
            $showButtonSelectJudgers = $selectJudgerStage['showButtonSelectJudgers'];
            $msgButtonSelectJudgers = $selectJudgerStage['msgButtonSelectJudgers'];
            $refusedJudgers = $selectJudgerStage['refusedJudgers'];
        }
        /* End Select Judger Stage */
        if ($order->HasUnpaidInvoices) {
            $paid = false;
        } else {
            $paid = true;
        }
        $user = User::with(['negotiations' => function ($q) use ($order) {
            $q->where('order_id', $order->id)->first();
        }])->where('id', auth()->id())->select(['id', 'name'])->first();

        if ($order->CanAccessToEncryptedOrder) {
            $screen = 'encrypted';
            $data_encrypted = $this->encrypted_Screen($order, $user);
        } elseif (!$user->canAccessOrder($order->id)) {
            $screen = 'access';
        }
        if ($order->offer_id) {
            $my_offers = Offer::with(['vendor', 'files', 'voices'])->where('order_id', $order->id)->where('vendor_id', $user->id)->where('status', 'accepted')->get();
        } else {
            $my_offers = Offer::with(['vendor', 'files', 'voices'])->where('order_id', $order->id)->where('vendor_id', $user->id)->latest('id')->get();
        }
        $unpaid_invoices = null;
        if ($user->invoicesForOrder($order->id, 'judger', 'unpaid')->count() > 0) {
            $unpaid_invoices = $user->invoicesForOrder($order->id, 'judger', 'unpaid')->get();
        }
        /* ******************** check if user watch Order ************************* */
        if (!$user->alreadyWatched($order->id)) {
            $user->orderWatched()->attach($order->id);
        }
        $data = ['user' => $user, 'unpaid_invoices' => $unpaid_invoices, 'paid' => $paid, 'step' => $step, 'msg' => $msg, 'screen' => $screen, 'data_encrypted' => $data_encrypted, 'main_department' => $main_department, 'sub_department' => $sub_department, 'showButtonSelectJudgers' => $showButtonSelectJudgers, 'refusedJudgers' => $refusedJudgers, 'msgButtonSelectJudgers' => $msgButtonSelectJudgers, 'selectedJudgers' => $selectedJudgers, 'order' => $order, 'my_offers' => $my_offers];
        return responseApi(true, '', $data);
    }
    /* ************************* Function For Encrypted Screen***************************** */
    public function encrypted_Screen($order, $user)
    {
        $code = null;
        if (!$user->HasDecoded($order->id)) {
            $encrypted_Screen_message = 'هذا الطلب مشفر يمكنك طلب الدخول من العميل وسيتم ارسال الكود عبر المنصة عند الموافقة';
            $code_status = null;
        }
        if ($user->getRequestHasCode($order->id)->count() > 0) {
            $code = $user->getRequestHasCode($order->id)->first()->pivot->code;
            $encrypted_Screen_message = 'قام العميل بقبول طلب التشفير لهذا الطلب والكود هو ' . $code;
            $code_status = 'accepted';
        } elseif ($user->HasPendingDecoded($order->id)) {
            $encrypted_Screen_message = 'لقد طلبت كود التشفير بالفعل, يرجى انتظار رد العميل';
            $code_status = 'pending';
        } elseif ($user->HasRefusedDecoded($order->id)) {
            $encrypted_Screen_message = 'لقد تم رفض طلب التشفير الخاص بك من العميل';
            $code_status = 'refused';
        }
        return ['encrypted_Screen_message' => $encrypted_Screen_message, 'code_status' => $code_status, 'code' => $code];
    }
    /* ************************* Agree Or Disagree To Access Order ***************************** */
    public function orderAccess(Request $request, $hash_code)
    {
        $validator = Validator::make($request->all(), [
            'option' => 'required'
        ]);

        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }

        if (request('option') == 2) {
            return responseApi(true, 'تم عدم موافقة الدخول بنجاح');
        }

        $order = Order::query()->where('hash_code', $hash_code)->first();
        $order->accessVendors()->attach(\auth()->id());
        Negotiation::create(['order_id' => $order->id, 'vendor_id' => auth()->id()]);

        return responseApi(true, 'تم الدخول بنجاح', ['order' => $order]);
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
        $refusedJudgers = [];
        if ($order->ClientRefusedSelectedJudgers->count() > 0) {
            $refusedJudgers = JudgerOrder::with('judger')->where('order_id', $order->id)->where('client_decision', 'refused')->orWhere('judger_decision', 'refused')->latest('id')->take(2)->get();
        }
        if (!$order->first_judger_id and $order->second_judger_id) {
            $msgButtonSelectJudgers = 'يجب عليك اختيار محكم الأصيل';
        } elseif (!$order->second_judger_id and $order->first_judger_id) {
            $msgButtonSelectJudgers = 'يجب عليك اختيار محكم الاحتياطي';
        } else {
            $msgButtonSelectJudgers = 'يجب عليك اختيار محكم الأصيل أو الاحتياطي';
        }
        return array('selectedJudgers' => $selectedJudgers, 'showButtonSelectJudgers' => $showButtonSelectJudgers, 'refusedJudgers' => $refusedJudgers, 'msgButtonSelectJudgers' => $msgButtonSelectJudgers);
    }
    /* ************************* Submission Of Work ***************************** */
    public function submissionOfWork(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), ['status' => 'required']);

        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        if (!$order->objection_id) {
            $request->merge(['delivery_date' => now()]);
            $order->update($request->all());
            return responseApi(true, 'تم تسليم الاعمال بنجاح', ['order' => $order]);
        } else {
            return responseApi(false, 'لا يمكن تسليم الاعمال لأن الطلب لدى المحكم');
        }
    }
    /* ************************* Logs ***************************** */
    public function logs($hash_code)
    {
        $order = Order::where('hash_code', $hash_code)->first();
        $user = auth()->user();
        $logs = Log::where('order_id', $order->id)->where('type', 'order')->latest('id')->get();

        return responseApi(true, 'Logs Page', ['logs' => $logs]);
    }

    /* ************************* Logs ***************************** */
    public function cancel(Order $order)
    {
        $order->update(['status' => 'cancel']);
        return responseApi(true, 'تمت العملية بنجاح بنجاح');
    }
}
