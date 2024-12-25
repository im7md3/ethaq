<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable=['order_id','user_id','parent','type','is_seen','content'];
    public function main()
    {
        return $this->belongsTo(Event::class,'parent');
    }
    public function kids()
    {
        return $this->hasMany(Event::class,'parent');
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
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
