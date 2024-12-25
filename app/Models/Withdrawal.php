<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;
    protected $fillable=['user_id','amount','status','number','file','tax_certificate','refused_msg'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function invoices(){
        return $this->hasMany(Invoice::class,'withdraw_id');
    }
}
