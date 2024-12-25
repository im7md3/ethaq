<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['order_type', 'order_id', 'from_id', 'to_id', 'for_type', 'amount', 'tax', 'admin_ratio', 'total', 'status', 'for_type', 'id_tamam', 'net', 'withdrawn', 'withdraw_id', 'tamam_success', 'tamam_transaction_id'];
    protected $appends = ['WebViewRoute', 'PayFromBalance', 'TypeInArabic','TypeInEn'];
    public function order()
    {
        return $this->morphTo();
    }
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_id');
    }
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_id');
    }
    public function suspended()
    {
        return $this->hasOne(SuspendedBalance::class);
    }

    public function getTypeNameAttribute()
    {
        if ($this->order_type == 'App\Models\Consulting') {
            return 'استشارة';
        } else {
            if ($this->for_type == 'vendor') {
                return 'عقد';
            } else {
                return 'تحكيم';
            }
        }
    }
    public function getWebViewRouteAttribute()
    {
        return route('api.front.invoice.webview', [$this, 'user_id' => auth()->check() ? auth()->id() : 0, 'user_type' => auth()->check() ? auth()->user()->type : '']);
    }

    public static function store($obj, $from_id, $to_id, $amount = null, $tax = null, $admin_ratio = null, $for_type = null, $net = null)
    {
        $total = $amount + $tax;
        $status = 'unpaid';
        $obj->invoices()->create(compact('from_id', 'to_id', 'amount', 'tax', 'admin_ratio', 'total', 'status', 'for_type', 'net'));
    }
    public function getPayFromBalanceAttribute()
    {
        if ($this->total <= $this->fromUser->current_balance) {
            return true;
        }
        return false;
    }
    public function getTypeInArabicAttribute()
    {
        if ($this->order_type == "App\Models\Consulting") {
            return "استشارة";
        } else {
            return "طلب";
        }
    }
    public function getTypeInEnAttribute()
    {
        if ($this->order_type == "App\Models\Consulting") {
            return "consulting";
        } else {
            return "order";
        }
    }
}
