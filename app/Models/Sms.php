<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'msg', 'department_type', 'department_id'];
    public function department()
    {
        return $this->morphTo();
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
