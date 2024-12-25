<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objection extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'user_id', 'content', 'time', 'note_time', 'client_decision', 'client_refused_msg', 'vendor_decision', 'vendor_refused_msg', 'judger_id', 'judger_judgment', 'judger_judgment_time', 'client_objection', 'client_objection_reason', 'vendor_objection', 'vendor_objection_reason'];
    protected $appends = ['ContentText'];
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

    public function getContentTextAttribute()
    {
        $html = $this->content;
        $new_str=trim($html);
        $htmlWithoutR=preg_replace("@\r@","",$new_str);
        $text = preg_replace('/<[^>]+>/', '', $htmlWithoutR);
        return $text;
    }
}
