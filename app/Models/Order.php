<?php

namespace App\Models;

use App\Http\Middleware\Vendor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['client_id', 'vendor_id', 'first_judger_id', 'second_judger_id', 'main_department_id', 'other_department', 'department_id', 'vendor_contract', 'contract', 'title', 'details', 'status', 'encrypted', 'refused_msg', 'hash_code', 'offer_id', 'negotiation_id', 'objection_id', 'refused_delivery_msg', 'money_back', 'without_judgers', 'judger_period', 'delivery_date', 'code_accept_contract', 'accepted_contract_date', 'contract_file'];

    protected $appends = [
        'offers_count',
        'protests_count',
    ];

    /* **************************************** Users ******************************* */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function firstJudger()
    {
        return $this->belongsTo(User::class, 'first_judger_id');
    }
    public function secondJudger()
    {
        return $this->belongsTo(User::class, 'second_judger_id');
    }
    /* ========= scope =========== */
    public function scopeShow($query)
    {
        $query->whereNotIn('status', ['archive', 'cancel']);
    }
    /* **************************************** Departments ******************************* */
    public function mainDepartment()
    {
        return $this->belongsTo(Department::class, 'main_department_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function getDepartmentNameAttribute()
    {
        if ($this->department_id) {
            return $this->department?->name;
        } else {
            return $this->other_department;
        }
    }
    public function scopeInUserDepartments($query)
    {
        $query->whereIn('department_id', auth()->user()->departments()->pluck('departments.id'))->orWhereNull('department_id');
    }
    /* ******************************* Active Offer ************************* */
    public function activeOffer()
    {
        return $this->belongsTo(Offer::class, 'offer_id')->with('vendor');
    }
    /* ******************************* Active Negotiation ************************* */
    public function activeNegotiation()
    {
        return $this->belongsTo(Negotiation::class, 'negotiation_id')->with('messages.user');
    }

    // The vendors that were selected during order creation
    public function vendors()
    {
        return $this->belongsToMany(User::class, 'order_vendors', 'order_id', 'vendor_id');
    }
    // The vendors that can access to order
    public function accessVendors()
    {
        return $this->belongsToMany(User::class, 'access_vendors', 'order_id', 'vendor_id');
    }
    /* ==================* Files ================== */
    public function files()
    {
        return $this->morphMany(Attachment::class, 'file')->where(function ($q) {
            foreach (voicesMimes() as $mime) {
                $q->where('path', 'NOT LIKE', "%" . $mime . "%");
            }
        });
    }
    /* ==================* Voices ================== */
    public function voices()
    {
        return $this->morphMany(Attachment::class, 'file')->where(function ($q) {
            foreach (voicesMimes() as $mime) {
                $q->where('path', 'LIKE', "%" . $mime . "%");
            }
        });
    }
    /* **************************************** Offers ******************************* */
    public function offers()
    {
        return $this->hasMany(Offer::class, 'order_id');
    }
    public function getAddedOfferAttribute()
    {
        return (bool)$this->offers()->where('vendor_id', auth()->id())->count();
    }
    public function getOffersCountAttribute()
    {
        return $this->offers()->count();
    }
    /* ************************ Judgers who choose from vendor ******************************* */
    public function selectedJudgers()
    {
        return $this->belongsToMany(User::class, 'judger_orders', 'order_id', 'judger_id')->withPivot('client_refused_msg', 'type', 'period', 'judger_refused_msg', 'rejected')->orderByPivot('id', 'desc');
    }

    public function getHasSelectedJudgersAttribute()
    {
        return (bool)$this->selectedJudgers()->count();
    }
    public function getClientAcceptedSelectedJudgersAttribute()
    {
        return $this->selectedJudgers()->where('client_decision', 'accepted')->latest('id')->take(2)->get();
    }
    public function getClientPendingSelectedJudgersAttribute()
    {
        return $this->selectedJudgers()->where('client_decision', 'pending')->latest('id')->take(2)->get();
    }
    public function getClientRefusedSelectedJudgersAttribute()
    {
        return $this->selectedJudgers()->where('client_decision', 'refused')->latest('id')->take(2)->get();
    }
    public function getJudgerAcceptedSelectedJudgersAttribute()
    {
        return $this->selectedJudgers()->where('client_decision', 'accepted')->where('judger_decision', 'accepted')->latest('id')->take(2)->get();
    }
    public function getPendingSelectedJudgersAttribute()
    {
        return $this->selectedJudgers()->where('client_decision', 'accepted')->where('judger_decision', 'pending')->latest('id')->take(2)->get();
    }
    public function getJudgerPendingSelectedJudgersAttribute()
    {
        return $this->selectedJudgers()->where('client_decision', 'accepted')->where('judger_decision', 'pending')->where('judger_id', auth()->id())->first();
    }
    public function getJudgerRefusedSelectedJudgersAttribute()
    {
        return $this->selectedJudgers()->where('client_decision', 'cancel')->where('judger_decision', 'refused')->latest('id')->take(2)->get();
    }
    public function getIsReadyToSelectJudgerOrAcceptAttribute()
    {
        return $this->vendor_id and $this->offer_id;
    }
    /* *************************** Contract ******************************* */
    public function getIsReadyToContractAttribute()
    {
        return $this->IsReadyToSelectJudgerOrAccept and ($this->JudgerAcceptedSelectedJudgers->count() == 2 or $this->without_judgers);
    }
    /* *************************** Invoices ******************************* */
    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'order');
    }
    public function getHasUnpaidInvoicesAttribute()
    {
        return $this->contract and (bool)$this->invoices->where('status', 'unpaid')->count() > 0;
    }
    /* *************************** Events ******************************* */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    public function getNotSeenEventAttribute()
    {
        return $this->events()->whereNull('parent')->whereNull('is_seen')->first();
    }
    public function getIsEventStageAttribute()
    {
        return $this->contract and (bool)$this->invoices->where('status', 'unpaid')->count() == 0;
    }
    /* *************************** Protest ******************************* */
    public function protests()
    {
        return $this->hasMany(OrderProtest::class, 'order_id');
    }
    public function getProtestsCountAttribute()
    {
        return $this->protests()->count();
    }
    /* *************************** Objection ******************************* */
    public function objection()
    {
        return $this->hasOne(Objection::class);
    }
    /* ************************ Users who watch order ************************ */
    public function views()
    {
        return $this->belongsToMany(User::class, 'order_views', 'order_id', 'user_id');
    }
    public function getViewsCountAttribute()
    {
        return $this->views->count();
    }
    /* *************************** Favorites ******************************* */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorite');
    }
    public function getIsFavoriteOrderAttribute()
    {
        return (bool)$this->favorites(Favorite::class)->where('user_id', auth()->id())->count();
    }
    /* *************************** Decryption Requests ******************************* */
    public function DecryptionRequests()
    {
        return $this->belongsToMany(User::class, 'order_decryption_requests', 'order_id', 'vendor_id')->withPivot(['status', 'created_at', 'code']);
    }
    public function getCanAccessToEncryptedOrderAttribute()
    {
        return (bool)$this->encrypted && ($this->DecryptionRequests()->where('vendor_id', auth()->id())->count() == 0 || $this->DecryptionRequests()->wherePivot('status', '!=', 'accepted')->count());
    }
    /* *************************** Suspended ******************************* */
    public function suspended()
    {
        return $this->morphMany(SuspendedBalance::class, 'order');
    }
    /* *************************** Documents ******************************* */
    public function documents()
    {
        return $this->hasMany(OrderDocument::class);
    }
    /* *************************** Objection Talk ******************************* */
    public function objectionTalks()
    {
        return $this->hasMany(ObjectionTalk::class);
    }
    /* *************************** Change First Judger To Second  ******************************* */
    public function getActiveJudgerAttribute()
    {
        /* قبل الاحالة للتحكيم سوف يتم جلب معرف المستخدم الحالي, بعد الاحالة سوف يتم جلب فقط المحكم الاول قبل انقضاء المدة, بعد انقضاء المدة سوف يتم جلب المحكم الاحتياطي*/
        if ($this->objection_id) {
            $time = $this->judger_period;
            if ($this->objection->time and $this->objection->client_decision == 'accepted' and $this->objection->vendor_decision == 'accepted') {
                $time = $this->objection->time;
            }
            if (now()->diffInDays(Carbon::parse($this->objection->created_at)) > $time) {
                $this->changeJudger();
                return $this->secondJudger->id;
            } else {
                return $this->firstJudger->id;
            }
        } else {
            return auth()->id();
        }
    }
    public function changeJudger()
    {
        /* تغيير الفواتير وجعلها للمحكم الاحتياطي */
        $sec = $this->secondJudger;
        $judger_invoice = $this->invoices()->where('for_type', 'judger')->where('status', 'paid')->latest()->first();
        if ($judger_invoice) {
            $suspended = $judger_invoice->suspended;
            $judger_invoice->update(['to_id' => $sec->id]);
            $suspended->update(['to' => $sec->id]);
        }
    }
    /* *************************** Show Forms ******************************* */
    public function getShowFormsAttribute()
    {
        if ($this->objection_id) {
            return false;
        }
        if ($this->status == 'done') {
            return false;
        }
        if ($this->status == 'cancel') {
            return false;
        }
        if ($this->status == 'request_done') {
            return false;
        }
        return true;
    }
    /* *************************** For API ******************************* */
    public function getIndexStepAttribute()
    {
        $index = 0;/* الاطلاع وتقديم العروض */
        if ($this->status == 'done') {
            if ($this->is_ready_to_select_judger_or_accept) {
                $index = 3;/* الانتهاء */
            } else {
                $index = 4;
            }
        } elseif ($this->contract) {
            if ($this->is_ready_to_select_judger_or_accept) {
                $index = 2;/* التنفيذ */
            } else {
                $index = 3;
            }
        } elseif ($this->IsReadyToContract or $this->without_judgers) {
            if ($this->is_ready_to_select_judger_or_accept) {
                $index = 1;/* الاتفاق (العرض) */
            } else {
                $index = 2;/* الاتفاق (العرض) */
            }
        } elseif ($this->is_ready_to_select_judger_or_accept) {
            if ($this->is_ready_to_select_judger_or_accept) {
                $index = 1;/* اختيار محكم */
            } else {
                $index = 0;/* اختيار محكم */
            }
        }
        return $index;

        /* $index = 0;/ الاطلاع وتقديم العروض
        if ($this->status == 'done') {
            $index = 4;// الانتهاء 
        }elseif($this->contract) {
            $index = 3;// التنفيذ 
        }elseif($this->IsReadyToContract or $this->without_judgers) {
            $index = 2;// الاتفاق (العرض)
        }elseif($this->is_ready_to_select_judger_or_accept) {
            $index = 1;// اختيار محكم 
        }
        return $index; */
    }
    public function getMessageStageAttribute()
    {
        if ($this->status == 'done') {
            $msg = ' الطلب منفذ';
        } elseif ($this->status == 'cancel') {
            $msg = 'تم إلغاء الطلب';
        } elseif ($this->status == 'request_done')
            $msg = ' لقد قام المحامي بتسليم الأعمال المتفق عليها, ويمكنك الاطلاع عليها';
        elseif ($this->status == 'VerdictHasBeenIssued')
            $msg = ' تم إصدار حكم التحكيم';
        elseif ($this->objection_id) {
            $msg = ' الطلب تحت الدراسة لدى المحكم';
        } elseif ($this->IsEventStage)
            $msg = ' الطلب قيد التنفيذ';
        elseif ($this->HasUnpaidInvoices)
            if (auth('sanctum')->user()->type == 'client') {
                $msg = ' بانتظار المحامي تسديد الفواتير';
            } else {
                $msg = ' بانتظار العميل تسديد الفواتير';
            }
        elseif ($this->vendor_contract)
            $msg = ' بانتظار قبول العميل للعقد';
        elseif (count($this->JudgerAcceptedSelectedJudgers) == 2)
            $msg = ' يتم انشاء العقد من قبل المحامي';
        elseif (count($this->PendingSelectedJudgers) > 0 and count($this->ClientPendingSelectedJudgers) == 0 and count($this->ClientAcceptedSelectedJudgers) == 2)
            $msg = ' انتظار الموافقة من قبل المحكمين على الطلب';
        elseif (count($this->ClientPendingSelectedJudgers) > 0)
            $msg = ' انتظار اختيار الموافقة من قبل العميل على المحكمين';
        elseif ($this->IsReadyToSelectJudgerOrAccept) {
            $msg = ' الطلب بانتظار اختيار المحكمين من قبل المحامي';
        } else {
            $msg = 'الطلب بانتظار تقديم العروض من المحامين';
        }
        return $msg;
    }
    /* =========== Bank Transfer ============= */
    public function bankTransfers()
    {
        return $this->morphMany(BankTransfer::class, 'order');
    }
}
