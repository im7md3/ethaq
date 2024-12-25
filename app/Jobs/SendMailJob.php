<?php

namespace App\Jobs;

use App\Mail\ConsultingGreater;
use App\Mail\NewConsulting;
use App\Mail\NewMail;
use App\Mail\NewOrder;
use App\Mail\NewUser;
use App\Mail\OrderGreater;
use App\Models\Consulting;
use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected $notification)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->notification->user;
        if (setting('activate_email')) {
            if ($this->notification->type == 'new-vendor' or $this->notification->type == 'new-client') {
                $user = User::latest('id')->first();
                Mail::to($user->email ?? 'test@test.com')->send(new NewUser($user));
            } elseif ($this->notification->type == 'new-order') {
                $order = Order::latest('id')->first();
                Mail::to($user->email ?? 'test@test.com')->send(new NewOrder($order));
            } elseif ($this->notification->type == 'new-consulting') {
                $consulting = Consulting::latest('id')->first();
                Mail::to($user->email ?? 'test@test.com')->send(new NewConsulting($consulting));
            } elseif ($this->notification->type == 'order_greater_1000') {
                $order = Order::find($this->notification->data['id']);
                Mail::to($user->email ?? 'test@test.com')->send(new OrderGreater($order));
            } elseif ($this->notification->type == 'consulting_greater_1000') {
                $consulting = Consulting::find($this->notification->data['id']);
                Mail::to($user->email ?? 'test@test.com')->send(new ConsultingGreater($consulting));
            } else {
                Mail::to($user->email)->send(new NewMail($this->notification));
            }
        }
    }
}
