<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;
    protected $fillable = ['name','file','end_at','status','user_id','refused_msg'];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
