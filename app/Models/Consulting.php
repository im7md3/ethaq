<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulting extends Model
{
    use HasFactory;
    protected $fillable = ['finish_call', 'client_id', 'vendor_id', 'department_id', 'other_department', 'offer_id', 'details', 'status', 'amount', 'min', 'sec', 'free', 'pay_later', 'private'];

    protected $appends = [
        'total',
        'PayMessage',
        'CanCancel'
    ];
    public function scopeInUserDepartments($query)
    {
        $query->whereIn('department_id', auth()->user()->departments()->pluck('departments.id'))->orWhereNull('department_id');
    }
    /* ==================* Users ================== */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
    /* ==================** Departments ================== */
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
    /* ==================* Offers ================== */
    public function offers()
    {
        return $this->hasMany(ConsultingOffers::class, 'consulting_id');
    }
    public function getAddedOfferAttribute()
    {
        if (auth()->guard('sanctum')->check())
            $user = auth('sanctum')->user();
        else {
            $user = auth()->user();
        }
        return (bool)$this->offers()->where('vendor_id', $user->id)->count();
    }
    /* ================== Invoices ================== */
    public function invoices()
    {
        return $this->morphOne(Invoice::class, 'order');
    }
    /* ================== suspended ================== */
    public function suspended()
    {
        return $this->morphOne(SuspendedBalance::class, 'order');
    }
    /* ================== Messages ================== */
    public function messages()
    {
        return $this->hasMany(ConsultingMessages::class, 'consulting_id');
    }
    /* ================== Evaluate ================== */
    public function evaluate()
    {
        return $this->hasOne(ConsultingEvaluation::class, 'consulting_id');
    }
    /* ================== check if active ================== */
    public function getScreenForApiAttribute()
    {
        if (!$this->vendor_id) {
            $screen = "offer";
        } elseif ($this->vendor_id and $this->status == 'pending' and $this->invoices and $this->invoices?->status != 'paid') {
            $screen = "paid";
        } elseif ($this->vendor_id and $this->status == 'active' and $this->invoices and $this->invoices?->status == 'paid') {
            $screen = "chat";
        } elseif ($this->vendor_id and $this->status == 'done' and $this->invoices and $this->invoices?->status == 'paid' and $this->evaluate_count == 0) {
            $screen = "evaluate";
        } else {
            $screen = "done";
        }
        return $screen;
    }
    /* =========== Total ========= */
    public function getTotalAttribute()
    {
        if ($this->invoices()->count() > 0) {
            return $this->invoices->total;
        }
        return 0;
    }
    /* =========== Payment status ========= */
    public function getPayMessageAttribute()
    {
        if (auth()->guard('sanctum')->check())
            $user = auth('sanctum')->user();
        else {
            $user = auth()->user();
        }
        if ($user->type == 'client') {
            if (!$this->vendor_id) {
                return 'تلقي العروض';
            } elseif ($this->status == 'cancel') {
                return 'تم إلغاء الاستشارة';
            } elseif ($this->invoices?->status == 'paid') {
                return 'تم سداد ' . $this->invoices->total . ' ر.س';
            } else {
                if ($this->vendor_id and $this->invoices) {
                    return "سداد";
                }
            }
        } else {
            if ($this->status == 'cancel') {
                return 'تم إلغاء الاستشارة';
            } elseif (!$this->vendor_id and $this->AddedOffer) {
                return 'بانتظار قبول العرض';
            } elseif (!$this->vendor_id) {
                return 'تلقي العروض';
            } elseif ($this->invoices?->status == 'paid') {
                return 'تم سداد ' . $this->invoices->total . ' ر.س';
            } else {
                return ' بانتظار العميل سداد الفاتورة';
            }
        }
    }

    public function getCanCancelAttribute()
    {
        if ($this->sec == 0 and $this->min == 0 and $this->status != 'cancel') {
            return true;
        }
        return false;
    }
}
