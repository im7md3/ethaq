<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectionTalk extends Model
{
    use HasFactory;
    protected $fillable=['order_id','objection_id','user_id','msg'];
    protected $with=['user','files','voices'];
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function objection(){
        return $this->belongsTo(Objection::class);
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
