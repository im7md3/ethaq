<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultingOffers extends Model
{
    use HasFactory;
    protected $fillable=['consulting_id','vendor_id','status','amount'];
    public function vendor(){
        return $this->belongsTo(User::class,'vendor_id');
    }
    public function consulting(){
        return $this->belongsTo(Consulting::class,'consulting_id');
    }
}
