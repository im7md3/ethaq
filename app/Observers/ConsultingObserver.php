<?php

namespace App\Observers;

use App\Events\RefreshConsultingEvent;
use App\Mail\NewConsulting;
use App\Models\Consulting;
use App\Models\ConsultingInvoices;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ConsultingObserver
{
    /**
     * Handle the Consulting "created" event.
     *
     * @param  \App\Models\Consulting  $consulting
     * @return void
     */
    public function created(Consulting $consulting)
    {
        $notification_data = [
            'id' => intval($consulting->id),
            'type' => 'consulting',
        ];

        if ($consulting->vendor_id) {
            $vendor = $consulting->vendor;
            $amount = $vendor->consulting_price;
            $tax = setting('activate_taxes') ? $amount * (setting('tax_for_consultation') / 100) : 0;
            $admin_ratio = $amount * (setting('admin_ratio_from_consultation') / 100);
            $net = $amount - $admin_ratio;
            if ($vendor->tax_number) {
                $admin_ratio = $admin_ratio + ($admin_ratio * setting('admin_ratio_from_consultation') / 100);
                $net = $net + ($net * setting('admin_ratio_from_consultation') / 100);
            }
            Invoice::store($consulting, $consulting->client_id, $consulting->vendor_id, $amount, $tax, $admin_ratio, null, $net);
            if ($consulting->amount >= 1000) {
                $users = User::admins()->get();
                $route = route('admin.admin_notifications');
                $title = 'استشارة رقم ' . $consulting->id . 'قيمتها أكبر من 1000 ريال ';
                $notification_data = [
                    'id' => intval($consulting->id),
                ];
                foreach ($users as $u) {
                    Notification::send($u->id, $title, $route, 'consulting_greater_1000', $notification_data);
                }
            }
        }

        $users = User::admins()->get();
        $route = route('admin.consulting.show', $consulting->id);
        $title = 'استشارة جديدة من العميل ' . $consulting->client->username;
        foreach ($users as $u) {
            Notification::send($u->id, $title, $route, 'new-consulting', $notification_data);
        }
        if (!$consulting->vendor_id) {
            $department = $consulting->department;
            $vendors = $department->users()->notDeleted()->get();
            foreach ($vendors as $vendor) {
                sendSms($vendor->id, 'vendor_create_consultation', ' استشارة جديدة في القسم ' . $department->name);
                Notification::send($vendor->id, ' استشارة جديدة في القسم ' . $department->name);
            }
        }
    }

    /**
     * Handle the Consulting "updated" event.
     *
     * @param  \App\Models\Consulting  $consulting
     * @return void
     */
    public function updated(Consulting $consulting)
    {
        $notification_data = [
            'id' => intval($consulting->id),
            'type' => 'consulting',
        ];

        if ($consulting->isDirty('status')) {
            $invoice = $consulting->invoices;
            // $suspended = $consulting->suspended;
            if ($consulting->status == 'done') {
                if ($invoice->status == 'paid') {
                    // $suspended->update(['status' => 'yes']);
                    $title = 'تم إنهاء جلسة الاستشارة رقم ' . $consulting->id;
                }
                $link = route('balance');
                event(new RefreshConsultingEvent($consulting->id));
                Notification::send($consulting->vendor_id, $title, $link, null, $notification_data);
                sendSms($consulting->vendor_id, 'vendor_end_consultation', $title);
            }
            if ($consulting->status == 'cancel') {
                // $invoice->update(['status' => 'cancel']);
                /*  if ($invoice and $suspended) {
                    $suspended->update(['status' => 'cancel']);
                } */
            }
        }
        // $consulting->free
        if ($consulting->isDirty('vendor_id')) {
            $vendor = $consulting->vendor;
            $amount = $consulting->amount;
            $tax = setting('activate_taxes') ? $amount * (setting('tax_for_consultation') / 100) : 0;
            $admin_ratio = $amount * (setting('admin_ratio_from_consultation') / 100);
            $net = $amount - $admin_ratio;
            if ($vendor->tax_number) {
                $admin_ratio = $admin_ratio + ($admin_ratio * setting('admin_ratio_from_consultation') / 100);
                $net = $net + ($net * setting('admin_ratio_from_consultation') / 100);
            }
            Invoice::store($consulting, $consulting->client_id, $consulting->vendor_id, $amount, $tax, $admin_ratio, null, $net);
            if ($consulting->amount >= 1000) {
                $users = User::admins()->get();
                $route = route('admin.admin_notifications');
                $title = 'استشارة رقم ' . $consulting->id . 'قيمتها أكبر من 1000 ريال ';
                $notification_data = [
                    'id' => intval($consulting->id),
                ];
                foreach ($users as $u) {
                    Notification::send($u->id, $title, $route, 'consulting_greater_1000', $notification_data);
                }
            }
        }
    }

    /**
     * Handle the Consulting "deleted" event.
     *
     * @param  \App\Models\Consulting  $consulting
     * @return void
     */
    public function deleted(Consulting $consulting)
    {
        //
    }

    /**
     * Handle the Consulting "restored" event.
     *
     * @param  \App\Models\Consulting  $consulting
     * @return void
     */
    public function restored(Consulting $consulting)
    {
        //
    }

    /**
     * Handle the Consulting "force deleted" event.
     *
     * @param  \App\Models\Consulting  $consulting
     * @return void
     */
    public function forceDeleted(Consulting $consulting)
    {
        //
    }
}
