<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDocument extends Model
{
    use HasFactory;
    protected $fillable=['user_id','msg','order_id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }
    /* ==================* Files ================== */
    public function files()
    {
        return $this->morphMany(Attachment::class, 'file')->where(function($q){
            foreach(voicesMimes() as $mime){
                $q->where('path','NOT LIKE',"%".$mime."%");
            }
        });
    }
    /* ==================* Voices ================== */
    public function voices()
    {
        return $this->morphMany(Attachment::class, 'file')->where(function($q){
            foreach(voicesMimes() as $mime){
                $q->where('path','LIKE',"%".$mime."%");
            }
        });
    }
}
