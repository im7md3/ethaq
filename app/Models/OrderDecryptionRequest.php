<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDecryptionRequest extends Model
{
    use HasFactory;
    protected $fillable=['code','status','vendor_id','order_id'];
    public function vendor(){
        return $this->belongsTo(User::class,'vendor_id');
    }
    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
}
