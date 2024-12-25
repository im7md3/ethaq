<?php

namespace App\Observers;

use App\Mail\NewUser;
use App\Mail\SendMailToAdmin;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $users = User::admins()->get();
        $route = route('admin.' . $user->type . 's.show', $user);
        if ($user->type == 'client') {
            $title = 'عميل جديد';
            foreach ($users as $u) {
                Notification::send($u->id, $title, $route, 'new-client');
            }
        } elseif ($user->type == 'vendor') {
            $title = 'محامي جديد';
            foreach ($users as $u) {
                Notification::send($u->id, $title, $route, 'new-vendor');
                /*  if(setting('activate_email')){
                    Mail::to($u->email??'test@test.com')->send(new NewUser($user));
                } */
            }
        }

        if ($user->type == 'vendor') {
            $body = [
                //'user' => 'ws',
                //'key' => '0FBjFkZlytBqod8w',
                'vendorname' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'website' => 'keytime.sa',
                'city' => $user->city?->name,
                'ID_number' => $user->id_number,
                'Membership_type' => $user->type . '_' . $user->membership,
                'license_number' => $user->license?->name,
                'remaining_days' => $user->license ? Carbon::now()->diffInDays(Carbon::parse($user->license->end_at)) : null,
                'License_expiration_date' => $user->license ? $user->license->end_at : null,
                'Legal_majors' => 'دولي',
                'number_of_orders' => $user->type == 'vendor' ? $user->vendorOrders->count() : $user->clientOrders->count(),
                'consulting_number' => $user->type == 'vendor' ? $user->consultingVendor->count() : $user->consultingClient->count(),
                'Paid_bills' => $user->invoices()->where('status', 'paid')->count(),
                'Unpaid_bills' => $user->invoices()->where('status', 'unpaid')->count(),
                'Free_consultations' => 0,
                'Support_requests' => $user->tickets->count(),
                'birth_date' => $user->birthdate,
                'Years_of_Experience' => $user->years_of_experience,
                'qualification' => $user->qualification?->name,
                'Academic_specialization' => $user->specialty?->name,
            ];

            $queryString = http_build_query($body);

            $url = "https://ethaq.kt-crm.online/ws/post_vendors.php?" . $queryString;

            $response = Http::post($url);
        }

        if ($user->type == 'client') {
            $body = [
                //'user' => 'ws',
                //'key' => '0FBjFkZlytBqod8w',
                'phone' => $user->phone,
                'name' => $user->name,
                'mobile' => $user->phone,
                'email' => $user->email,
                'secret_code' => '123',
                'city' => $user->city?->name,
                'ID_number' => $user->id_number,
            ];

            $queryString = http_build_query($body);

            $url = "https://ethaq.kt-crm.online/ws/post_contacts.php?" . $queryString;

            $response = Http::post($url);
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        if ($user->type == 'vendor') {

            $body = [
                'vendorname' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'website' => 'keytime.sa',
                'city' => $user->city?->name,
                'ID_number' => $user->id_number,
                'Membership_type' => $user->type . '_' . $user->membership,
                'license_number' => $user->license?->name,
                'remaining_days' => $user->license ? Carbon::now()->diffInDays(Carbon::parse($user->license->end_at)) : null,
                'License_expiration_date' => $user->license ? $user->license->end_at : null,
                'Legal_majors' => 'دولي',
                'number_of_orders' => $user->type == 'vendor' ? $user->vendorOrders->count() : $user->clientOrders->count(),
                'consulting_number' => $user->type == 'vendor' ? $user->consultingVendor->count() : $user->consultingClient->count(),
                'Paid_bills' => $user->invoices()->where('status', 'paid')->count(),
                'Unpaid_bills' => $user->invoices()->where('status', 'unpaid')->count(),
                'Free_consultations' => 0,
                'Support_requests' => $user->tickets->count(),
                'birth_date' => $user->birthdate,
                'Years_of_Experience' => $user->years_of_experience,
                'qualification' => $user->qualification?->name,
                'Academic_specialization' => $user->specialty?->name,
            ];


            $queryString = http_build_query($body);

            $url = "https://ethaq.kt-crm.online/ws/update_vendors.php?" . $queryString;

            $response = Http::put($url);
        }

        if ($user->type == 'client') {
            $body = [
                //'user' => 'ws',
                //'key' => '0FBjFkZlytBqod8w',
                'phone' => $user->phone,
                'name' => $user->name,
                'mobile' => $user->phone,
                'email' => $user->email,
                'secret_code' => '123',
                'city' => $user->city?->name,
                'ID_number' => $user->id_number,
            ];

            $queryString = http_build_query($body);

            $url = "https://ethaq.kt-crm.online/ws/update_contacts.php?" . $queryString;

            $response = Http::put($url);
        }
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        $user->fcmTokens()->delete();
        $user->tokens()->delete();
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
    }
}
