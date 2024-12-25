<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTransfer extends Model
{
    use HasFactory;
    protected $fillable=['transfer_name','bank_name','account_no','file','invoice_id','user_id','status','rejected_msg','order_type', 'order_id',];
    public function order()
    {
        return $this->morphTo();
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function invoice(){
        return $this->belongsTo(Invoice::class,'invoice_id');
    }
}
