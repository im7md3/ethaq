<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvisorFile extends Model
{
    use HasFactory;
    protected $fillable=['status','name','file','user_id','refused_msg'];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
