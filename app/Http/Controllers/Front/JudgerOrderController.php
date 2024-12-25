<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\JudgerOrder;
use App\Models\Log;
use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class JudgerOrderController extends Controller
{
    public function create(Order $order)
    {
        $judgers = User::judgers()->latest('id')->get();
        return view('vendor.order.select-judgers', compact('judgers', 'order'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'main_judger' => ['required', 'different:sub_judger'],
            'sub_judger' => ['required', 'different:main_judger'],
            'order_id' => 'required',
            'client_decision' => 'required',
            'period' => 'required',
        ]);
        $order = Order::findOrFail($request->order_id);
        if (!$order->first_judger_id) {
            $order->selectedJudgers()->attach($request->main_judger, ['type' => 'main', 'period' => $request->period]);
        }
        if (!$order->second_judger_id) {
            $order->selectedJudgers()->attach($request->sub_judger, ['type' => 'sub', 'period' => $request->period]);
        }
        $user_id = $order->client_id;
        $title = 'تم اختيار المحكم من قبل المحامي ' . auth()->user()->name . ' في الطلب ' . $order->title;
        $link = route('client.orders.show', $order->hash_code);
        $notification_data = [
            'id' => intval($order->id),
            'type' => 'order',
            'hash_code' => $order->hash_code
        ];
        Notification::send($user_id, $title, $link, null, $notification_data);
        Log::store($order->id, 'order', 'تم اختيار المحكم من قبل المحامي في الطلب ');
        return redirect()->route('vendor.orders.show', $order->hash_code)->with('success', 'تم اختيار المحكم بنجاح');
    }

    public function clientDecision(Request $request)
    {
        $data = $request->validate([
            'judger_id' => 'required',
            'client_decision' => 'required',
            'client_refused_msg' => 'required_if:client_decision,refused'
        ]);
        $order = Order::findOrFail($request->order_id);
        $selectedJudgers = JudgerOrder::where('order_id', $order->id)->where('judger_id', $request->judger_id)->latest('id')->first();
        $selectedJudgers->update($data);
        $msg = $request->client_decision == 'accepted' ? 'تم اختيار المحكم بنجاح' : 'تم رفض المحكم بنجاح';
        return redirect()->back()->with('success', $msg);
    }

    public function judgerDecision(Request $request)
    {
        $data = $request->validate([
            'judger_id' => 'required',
            'judger_decision' => 'required',
            'judger_refused_msg' => 'required_if:judger_decision,refused',
            'rejected' => 'nullable',
        ]);
        if ($request->judger_decision == 'refused') {
            $data['client_decision'] = 'cancel';
        }
        $order = Order::findOrFail($request->order_id);
        $selectedJudgers = JudgerOrder::where('order_id', $order->id)->where('judger_id', $request->judger_id)->latest('id')->first();
        $selectedJudgers->update($data);
        $msg = $request->judger_decision == 'accepted' ? 'تم الموافقة على طلب التحكيم بنجاح' : 'تم رفض طلب التحكيم';
        if ($request->judger_decision == 'accepted') {
            return redirect()->back()->with('success', $msg);
        } else {
            return redirect()->route('judger.home')->with('success', $msg);
        }
    }

    public function withoutJudgers(Request $request, Order $order)
    {
        // $ff = view('components.order.contract', compact('order'))->render();
        $order->update(['first_judger_id' => null, 'second_judger_id' => null, 'without_judgers' => true]);
        // $order->update(['contract'=>$ff]);
        // $title = 'تم إنشاء عقد المحاماة بنجاح';
        // Log::store($order->id, 'order', $title);
        return back()->with('success', 'تم إنشاء العقد بنجاح');
    }
}
