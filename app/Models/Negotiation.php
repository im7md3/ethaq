<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negotiation extends Model
{
    use HasFactory;
    protected $fillable=['order_id','vendor_id'];
    public function vendor(){
        return $this->belongsTo(User::class,'vendor_id');
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function messages(){
        return $this->hasMany(Message::class);
    }
}
