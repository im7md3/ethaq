<?php

namespace App\Observers;

use App\Mail\NewOrder;
use App\Models\Invoice;
use App\Models\Log;
use App\Models\Notification;
use App\Models\Order;
use App\Models\SuspendedBalance;
use App\Models\User;
use App\Service\Oursms;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        if (is_null($order->hash_code)) {
            $order->update(['hash_code' => Str::random(50)]);
        }
        $users = User::admins()->get();
        $route = route('admin.admin_notifications');
        $title = 'طلب جديد من العميل ' . $order->client->username;
        $notification_data = [
            'id' => intval($order->id),
            'type' => 'order',
            'hash_code' => $order->hash_code
        ];
        foreach ($users as $u) {
            Notification::send($u->id, $title, $route, 'new-order', $notification_data);
        }
        sendSms($order->client_id, 'client_create_order', 'لقد قمت بإنشاء طلب جديد بعنوان ' . $order->title);
        if ($order->vendor_id) {
            sendSms($order->vendor_id, 'vendor_create_order', 'تم اختيارك في طلب جديد بعنوان ' . $order->title);
            Notification::send($order->vendor_id,  ' تم اختيارك في طلب جديد بعنوان ' . $order->title);
        }
        if ($order->vendors()->count() > 0) {
            $vendors = $order->AllVendors()->notDeleted()->get();
            foreach ($vendors as $vendor) {
                sendSms($vendor->id, 'vendor_create_order', 'تم اختيارك في طلب جديد بعنوان ' . $order->title);
                Notification::send($vendor->id,  ' تم اختيارك في طلب جديد بعنوان ' . $order->title);
            }
        }
        /* $department = $order->department;
        if ($order->vendors()->count() > 0) {
            $vendors = $order->vendors()->get();
        } else {
            $vendors = $department->users()->ActiveLicense()->get();
        }
        foreach ($vendors as $vendor) {
            sendSms($vendor->id, 'vendor_create_order', ' طلب جديد بعنوان ' . $order->title . ' في القسم ' . $department->name);
            Notification::send($vendor->id,  ' طلب جديد بعنوان ' . $order->title . ' في القسم ' . $department->name);
        } */
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        $notification_data = [
            'id' => intval($order->id),
            'type' => 'order',
            'hash_code' => $order->hash_code
        ];

        if ($order->isDirty('vendor_contract')) {
            $user_id = $order->client_id;
            $title = 'تم إرسال عقد الطلب ' . $order->title . ' من قبل من المحامي ' . $order->vendor->name;
            $route = route('client.orders.show', $order->hash_code);
            Notification::send($user_id, $title, $route, null, $notification_data);
            sendSms($user_id, 'client_send_contract', $title);
        }
        if ($order->isDirty('contract')) {
            $user_id = $order->vendor_id;
            $title = 'تم الموافقة على عقد الطلب ' . $order->title . ' من قبل من العميل ' . $order->client->username;
            $route = route('vendor.orders.show', $order->hash_code);
            Notification::send($user_id, $title, $route, null, $notification_data);
            sendSms($user_id, 'client_accept_contract', $title);
            $amount = $order->activeOffer->amount;
            $tax = setting('activate_taxes') ? $amount * (setting('contract_tax') / 100) : 0;
            $admin_ratio = $amount * (setting('admin_ratio_of_contract') / 100);
            Invoice::store($order, $order->client_id, $order->vendor_id, $amount, $tax, $admin_ratio, 'vendor');
        }
        if ($order->isDirty('status')) {
            if ($order->status == 'request_done') {
                $user_id = $order->client_id;
                $title = 'تم تسليم أعمال الطلب ' . $order->title . ' من المحامي ' . $order->vendor->name;
                $link = route('client.orders.show', $order->hash_code);
                Notification::send($user_id, $title, $link, null, $notification_data);
                sendSms($user_id, 'client_delivery_order', $title);
                Log::store($order->id, 'order', $title);
                $users = User::admins()->get();
                $route = route('admin.admin_notifications');
                foreach ($users as $u) {
                    Notification::send($u->id, $title, $route, 'new-delivery', $notification_data);
                }
            }
            if ($order->status == 'done') {
                $user_id = $order->vendor_id;
                $title = 'تم استلام الطلب ' . $order->title . ' بنجاح';
                $link = route('vendor.orders.show', $order->hash_code);
                $client = $order->client;
                $vendor = $order->vendor;
                $client_invoice = $order->invoices()->where('from_id', $client->id)->first();
                /* $suspended_balance = $client_invoice->suspended;
                $suspended_balance->update(['status' => 'yes']); */
                Notification::send($user_id, $title, $link, null, $notification_data);
                sendSms($user_id, 'vendor_accept_delivery_order', $title);
                Log::store($order->id, 'order', $title);
            }
            if ($order->status == 'ongoing') {
                if ($order->getRawOriginal('status') == 'request_done') {
                    $user_id = $order->vendor_id;
                    $title = 'تم رفض استلام الطلب ' . $order->title . ' من قبل العميل بسبب ' . $order->refused_delivery_msg;
                    $link = route('vendor.orders.show', $order->hash_code);
                    Notification::send($user_id, $title, $link, null, $notification_data);
                    sendSms($user_id, 'vendor_refused_delivery_order', $title);
                    Log::store($order->id, 'order', $title);
                }
            }
            /* if ($order->status == 'close') {
                if ($order->invoices()->count() > 0) {
                    foreach ($order->invoices()->get() as $invoice) {
                        $invoice->suspended->update(['status' => 'yes']);
                    }
                }
            } */
            if ($order->status == 'cancel') {
                $user = auth()->user();
                $to_user = auth()->id() == $order->client_id ? $order->vendor : $order->client;
                $typeAr = auth()->id() == $order->client_id ? "العميل" : "المحامي";
                if (!$order->offer_id) {
                    $title = "تم إلغاء الطلب " . $order->title . " من قبل " . $typeAr . " " . $user->name;
                }
                if ($order->offer_id and !$order->contract) {
                    $title = "تم رفض التعاقد في الطلب " . $order->title . " من قبل " . $typeAr . " " . $user->name;
                }
                if ($order->contract) {
                    $title = "تم فسخ التعاقد في الطلب " . $order->title . " من قبل " . $typeAr . " " . $user->name;
                }
                $link = route($to_user->type . '.orders.show', $order->hash_code);
                Notification::send($to_user->id, $title, $link, null, $notification_data);
                Log::store($order->id, 'order', $title);
            }
            /* ارسال رسائل جوال للعميل والمحامي والمحكم بحالة الطلب */
            if (setting('order_status_sms')) {
                $client = $order->client;
                $vendor = $order->vendor;
                $firstJudger = $order->firstJudger;
                $secondJudger = $order->secondJudger;
                $message = 'تم تغيير حالة الطلب ' . $order->title . ' الى ' . __($order->status);
                sendSms($client->id, 'client_accept_contract', $message);
                sendSms($vendor->id, 'vendor_accept_contract', $message);
                sendSms($firstJudger->id, 'judger_accept_contract', $message);
                sendSms($secondJudger->id, 'judger_accept_contract', $message);
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
