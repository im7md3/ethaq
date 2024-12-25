<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasRoles;
    protected $fillable = [
        'type', 'membership', 'name', 'phone', 'email', 'id_number', 'city_id', 'gender', 'address', 'photo', 'current_balance', 'suspended_balance',  'occupation_id', 'password', 'country_id', 'birthdate', 'company_name', 'company_number', 'is_active', 'notes', 'years_of_experience', 'bio', 'contract', 'last_seen', 'is_block', 'bank_account', 'specialty_id', 'qualification_id', 'id_end', 'city_name', 'fcm_token', 'tax_number', 'username', 'bank_id', 'main_department_id', 'another_department', 'iban_cer', 'has_tax_certificate', 'tax_certificate', 'platform_id', 'vendor_id', 'another_platform', 'delete_date', 'enable_sms', 'is_advisor', 'consulting_price', 'free_consulting'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $appends = [
        'VendorConsultingTotalEvaluate',
        'VendorConsultingEvaluateCount',
        'IsItOnline',
        'last_seen_text',
        // 'closer_time',
    ];
    /* *************************** Scopes Type******************************* */
    public function scopeClients($q)
    {
        return $q->where('type', 'client');
    }
    public function scopeClientsIndividual($q)
    {
        return $q->where('type', 'client')->where('membership', 'individual');
    }
    public function scopeClientsCompany($q)
    {
        return $q->where('type', 'client')->where('membership', 'company');
    }
    public function scopeVendors($q)
    {
        return $q->where('type', 'vendor')->where('is_advisor', 0);
    }
    public function scopeVendorsIndividual($q)
    {
        return $q->where('type', 'vendor')->where('is_advisor', 0)->where('membership', 'individual');
    }
    public function scopeVendorsCompany($q)
    {
        return $q->where('type', 'vendor')->where('is_advisor', 0)->where('membership', 'company');
    }
    public function scopeAdvisors($q)
    {
        return $q->where('type', 'vendor')->where('is_advisor', 1);
    }
    public function scopeAdvisorsIndividual($q)
    {
        return $q->where('type', 'vendor')->where('is_advisor', 1)->where('membership', 'individual');
    }
    public function scopeAdvisorsCompany($q)
    {
        return $q->where('type', 'vendor')->where('is_advisor', 1)->where('membership', 'company');
    }
    public function scopeAllVendors($q)
    {
        return $q->where('type', 'vendor');
    }
    public function scopeJudgers($q)
    {
        return $q->where('type', 'judger');
    }
    public function scopeAdmins($q)
    {
        return $q->where('type', 'admin');
    }
    public function scopeBlock($q)
    {
        return $q->where('is_block', true);
    }
    public function scopeNotBlock($q)
    {
        return $q->whereNull('is_block')->OrWhere('is_block', false);
    }
    public function scopeAllDeleted($q)
    {
        return $q->whereNotNull('delete_date');
    }
    public function scopeNotDeleted($q)
    {
        return $q->whereNull('delete_date');
    }
    /* *************************** Scope Active License ******************************* */
    public function scopeActiveLicense($q)
    {
        return $q->NotBlock()->whereHas('license', function ($query) {
            $query->where('status', 'accepted')->where('end_at', '>=', today());
        })->orWhereHas('advisorFile', function ($q) {
            $q->where('status', 'accepted');
        });
    }
    public function scopePendingLicense($q)
    {
        return $q->NotBlock()->whereHas('license', function ($query) {
            $query->where('status', 'pending');
        })->orWhereHas('advisorFile', function ($q) {
            $q->where('status', 'pending');
        });
    }
    public function scopeNoLicense($q)
    {
        return $q->NotBlock()->whereDoesntHave('license')->orWhereDoesntHave('advisorFile');
    }
    /* *************************** Photo******************************* */
    public function getPhotoAttribute($value)
    {
        if ($value) {
            if (Storage::disk('uploads')->exists($value)) {
                return $value;
            }
        }
        if ($this->gender == 'male') {
            return 'boy-logo.png';
        }
        if ($this->gender == 'female') {
            return 'girl-logo.jpg';
        }
        return 'boy-logo.png';
    }
    /* *************************** Username ******************************* */
    public function getUsernameAttribute($value)
    {
        if (!$value) {
            return $this->name;
        }
        return $value;
    }
    /* *************************** Total Balance******************************* */
    public function getTotalBalanceAttribute()
    {
        return $this->current_balance + $this->suspended_balance;
    }
    /* *************************** notes ******************************* */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    /* *************************** Departments ******************************* */
    public function mainDepartment()
    {
        return $this->belongsTo(Department::class, 'main_department_id');
    }
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_users', 'user_id', 'department_id');
    }
    public function getDepartmentsNameAttribute()
    {
        $names = $this->departments()->pluck('name')->toArray();
        array_push($names, $this->another_department);
        return array_unique($names);
    }
    /* *************************** Consulting Departments ******************************* */
    public function ConsultingDepartments()
    {
        $d = Department::where('name', 'الاستشارات')->first();
        return $this->departments()->where(function ($q) use ($d) {
            $q->where('parent', $d->id);
        });
    }
    /* *************************** City******************************* */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    /* *************************** Country******************************* */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    /* *************************** Bank******************************* */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
    /* *************************** Occupation******************************* */
    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }
    /* *************************** Occupation******************************* */
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }
    /* *************************** Occupation******************************* */
    public function qualification()
    {
        return $this->belongsTo(Qualification::class);
    }
    /* *************************** License******************************* */
    public function license()
    {
        return $this->hasOne(License::class);
    }
    /* *************************** License******************************* */
    public function advisorFile()
    {
        return $this->hasOne(AdvisorFile::class, 'user_id');
    }
    /* *************************** Has Active License******************************* */
    public function getHasActiveLicenseAttribute()
    {
        if ($this->license?->status == 'refused' or $this->license?->end_at < now()->format('Y-m-d')) {
            return false;
        }
        return true;
    }
    public function getHasAcceptedLicenseAttribute()
    {
        return $this->license?->status == 'accepted' and $this->license?->end_at > now()->format('Y-m-d');
    }
    /* *************************** Has Active advisorFile******************************* */
    public function getHasActiveAdvisorFileAttribute()
    {
        if ($this->advisorFile) {
            if ($this->advisorFile?->status == 'refused') {
                return false;
            }
            return true;
        }
        return false;
    }
    public function getHasAcceptedAdvisorFileAttribute()
    {
        return $this->AdvisorFile?->status == 'accepted';
    }
    /* *************************** commercial******************************* */
    public function commercial()
    {
        return $this->hasOne(Commercial::class);
    }
    /* *************************** Has Active Commercial******************************* */
    public function getHasActiveCommercialAttribute()
    {
        if ($this->commercial?->status == 'refused' or $this->commercial?->end_at < now()->format('Y-m-d')) {
            return false;
        }
        return true;
    }
    public function getHasAcceptedCommercialAttribute()
    {
        return $this->commercial?->status == 'accepted' and $this->commercial?->end_at > now()->format('Y-m-d');
    }
    /* *************************** orders ******************************* */
    public function vendorOrders()
    {
        return $this->hasMany(Order::class, 'vendor_id');
    }
    public function clientOrders()
    {
        return $this->hasMany(Order::class, 'client_id');
    }
    public function firstJudgerOrders()
    {
        return $this->hasMany(Order::class, 'first_judger_id');
    }
    public function secondJudgerOrders()
    {
        return $this->hasMany(Order::class, 'second_judger_id');
    }
    /* *************************** Vendor who can access to order ******************************* */
    public function accessOrders()
    {
        return $this->belongsToMany(Order::class, 'access_vendors', 'vendor_id', 'order_id');
    }
    public function canAccessOrder($order_id)
    {
        return $this->accessOrders()->where('order_id', $order_id)->count() > 0;
    }
    /* *************************** Offers ******************************* */
    public function offers()
    {
        return $this->hasMany(Offer::class, 'vendor_id');
    }
    /* *************************** Negotiations ******************************* */
    public function negotiations()
    {
        return $this->hasMany(Negotiation::class, 'vendor_id');
    }
    /* *************************** Messages ******************************* */
    public function messages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }
    /* *************************** Invoices ******************************* */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'from_id');
    }
    public function invoicesForOrder($order_id, $for = null, $status)
    {
        return $this->invoices()->where(function ($q) use ($for, $order_id, $status) {
            $q->where('order_id', $order_id)->where('status', $status);
            if ($for) {
                $q->where('for_type', $for);
            }
        });
    }
    /* *************************** Events ******************************* */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    /* *************************** Notifications ******************************* */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function getUnreadNotificationsAttribute()
    {
        return $this->notifications()->whereNull('seen_at')->latest('id');
    }
    /* ************************ Orders Already watched ************************ */
    public function orderWatched()
    {
        return $this->belongsToMany(Order::class, 'order_views', 'user_id', 'order_id');
    }
    public function alreadyWatched($order_id)
    {
        return (bool)$this->orderWatched()->where('orders.id', $order_id)->count();
    }
    /* *************************** Favorites ******************************* */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    public function isFavoriteOrder($order_id)
    {
        return (bool)$this->favorites(Favorite::class)->where('favorite_type', 'App\Models\Order')->where('favorite_id', $order_id)->count();
    }
    /* *************************** Decryption Requests ******************************* */
    public function decryptionRequests()
    {
        return $this->belongsToMany(Order::class, 'order_decryption_requests', 'vendor_id', 'order_id')->withPivot('status', 'code');
    }
    public function HasDecoded($order_id)
    {
        return (bool)$this->decryptionRequests()->where('order_id', $order_id)->count() > 0;
    }
    public function HasPendingDecoded($order_id)
    {
        return (bool)$this->decryptionRequests()->where('order_id', $order_id)->wherePivot('status', 'pending')->count() > 0;
    }
    public function getRequestHasCode($order_id)
    {
        return $this->decryptionRequests()->where('order_id', $order_id)->wherePivot('status', 'pendingLogin')->whereNotNull('code');
    }
    public function HasRefusedDecoded($order_id)
    {
        return (bool)$this->decryptionRequests()->where('order_id', $order_id)->wherePivot('status', 'refused')->count() > 0;
    }
    /* *************************** Financial ******************************* */
    public function financial()
    {
        return $this->hasMany(Financial::class);
    }
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }
    public function getPendingWithdrawalsAttribute()
    {
        return $this->withdrawals()->where('status', 'pending');
    }
    /* *************************** roles ******************************* */
    public function getRoleAttribute()
    {
        return $this->roles->first();
    }
    /* *************************** Check if user active ******************************* */
    public function checkUserActive()
    {
        $user = $this;
        // check if the user is a company or individual
        if ($user->type != 'client' and !$user->email) {
            return false;
        }
        if ($user->type == 'vendor' and $user->departments()->count() == 0) {
            return false;
        }
        if ($user->type == 'vendor' and $user->consultingDepartments()->count() == 0) {
            return false;
        }
        if ($user->type == 'vendor' and is_null($user->getRawOriginal('photo'))) {
            return false;
        }
        if ($user->type == 'vendor' and !$user->consulting_price > 0) {
            return false;
        }
        if ($user->is_advisor) {
            if ($user->advisorFile) {
                if ($user->HasAcceptedAdvisorFile) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        
        if ($user->type == 'client' and $user->membership == 'individual') {
            return true;
        }
        if ($user->membership == 'individual') {
            if ($user->license) {
                if ($user->HasAcceptedLicense) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            // check if the user uploaded all documents
            if (!empty($user->contract) || $user->commercial || $user->license) {
                // check if the documents approved or not
                if ($user->HasAcceptedLicense && $user->HasAcceptedCommercial) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
    /* *************************** Check if user online ******************************* */
    public function getIsItOnlineAttribute()
    {
        if (Carbon::now()->diffInMinutes($this->last_seen) <= 2) {
            return true;
        }
        return false;
    }
    public function is_online()
    {
        $expiresAt = Carbon::now()->addMinutes(2); // keep online for 2 min
        cache()->put('user-is-online-' . $this->id, true, $expiresAt);
        $this::where('id', $this->id)->update(['last_seen' => (new \DateTime())->format("Y-m-d H:i:s")]);
    }
    /* *************************** list all the user departments ******************************* */
    public function list_departments()
    {
        $departments = $this->departments;
        $i = 0;
        foreach ($departments as $key => $department) {
            echo $department->name;
            if (++$i === count($departments)) {
                echo " ";
            } else {
                echo ' - ';
            }
        }
    }
    /* *************************** Vendor Consulting ******************************* */
    public function consultingVendor()
    {
        return $this->hasMany(Consulting::class, 'vendor_id');
    }
    public function consultingClient()
    {
        return $this->hasMany(Consulting::class, 'client_id');
    }
    public function getConsultingVendorFreeCountAttribute()
    {
        return $this->consultingVendor()->where('free', true)->count();
    }

    /* *************************** Consulting Offers ******************************* */
    public function consultingOffers()
    {
        return $this->hasMany(ConsultingOffers::class, 'vendor_id');
    }
    /* ========== Can I Access Consulting =========== */
    public function accessConsultings()
    {
        return $this->belongsToMany(Consulting::class, 'access_vendor_consultings', 'vendor_id', 'consulting_id');
    }
    public function canAccessConsulting(Consulting $consulting)
    {
        if ($consulting->pay_later) {
            return $this->accessConsultings()->where('consulting_id', $consulting->id)->count() > 0;
        }
        return true;
    }
    /* *************************** Vendor Consulting Evaluate ******************************* */
    public function vendorConsultingEvaluate()
    {
        return $this->hasMany(ConsultingEvaluation::class, 'vendor_id');
    }
    public function getVendorConsultingTotalEvaluateAttribute()
    {
        return $this->vendorConsultingEvaluate()->count() > 0 ? $this->vendorConsultingEvaluate()->sum('value') / $this->vendorConsultingEvaluate()->count() : 0;
    }
    public function getVendorConsultingEvaluateCountAttribute()
    {
        return $this->vendorConsultingEvaluate()->count();
    }
    /* *************************** Tickets ******************************* */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }
    /* ========= tokens ============== */
    public function fcmTokens()
    {
        return $this->hasMany(FcmToken::class, 'user_id');
    }
    /* ========= platform ============== */
    public function platform()
    {
        return $this->belongsTo(Platform::class, 'platform_id');
    }
    /* ========= platform ============== */
    public function affiliated()
    {
        return $this->belongsTo(User::class, 'affiliated_id');
    }
    /* ========= Last Seen Text ============== */
    public function getLastSeenTextAttribute()
    {
        $text = '';
        if ($this->last_seen != null) {
            $text = Carbon::parse($this->last_seen)->format('Y-m-d') . ' - ' . Carbon::parse($this->last_seen)->diffForHumans();
        }
        return $text;
    }
    /* ========= Profile Complete =========== */
    public function getProfileCompleteAttribute()
    {
        $hasFile=false;
        if($this->is_advisor){
            if($this->advisorFile){
                $hasFile= true;
            }
        }else{
            if($this->license){
                $hasFile= true;
            }
        }
        if ($this->name && $this->phone && $this->email && $this->id_number && $this->consultingDepartments->count() > 0 && $this->departments->count() > 0 && $this->getRawOriginal('photo') && $hasFile  && $this->consulting_price) {
            return true;
        }
        return false;
    }

    /* ========= times ======== */
    public function times()
    {
        return $this->hasMany(SetTime::class, 'user_id');
    }
    /* public function getCloserTimeAttribute()
    {
        $day = now()->format('l');
        $time = now()->format('H:i:s');
        return $this->times()->where('day', '>=', $day)
            ->orderBy('day', 'asc')
            ->orderBy('from', 'asc')->first();
    } */
}
