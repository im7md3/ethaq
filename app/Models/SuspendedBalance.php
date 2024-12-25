<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuspendedBalance extends Model
{
    use HasFactory;
    protected $fillable=['order_type', 'order_id','from','to','status','amount','invoice_id'];

    public function order(){
        return $this->morphTo();
    }
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
    public function fromUser(){
        return $this->belongsTo(User::class,'from');
    }
    public function toUser(){
        return $this->belongsTo(User::class,'to');
    }
    public static function store($obj,$invoice_id,$from,$to,$amount=null,$status='no')
    {
        $obj->suspended()->create(compact('invoice_id','from','to','amount','status'));
    }
}
