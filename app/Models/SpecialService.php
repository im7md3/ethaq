<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialService extends Model
{
    use HasFactory;
    protected $fillable = ['client_id', 'title', 'details', 'status'];
    protected $appends = [
        'LastMsgFrom',
    ];
    public function client(){
        return $this->belongsTo(User::class,'client_id');
    }
    public function messages(){
        return $this->hasMany(SpecialServiceMessage::class,'service_id');
    }
    public function getLastMsgAttribute(){
        return $this->messages()->latest('id')->first();
    }
    /* ==================* Files ================== */
    public function files()
    {
        return $this->morphMany(Attachment::class, 'file')->where(function ($q) {
            foreach (voicesMimes() as $mime) {
                $q->where('path', 'NOT LIKE', "%" . $mime . "%");
            }
        });
    }
    /* ==================* Voices ================== */
    public function voices()
    {
        return $this->morphMany(Attachment::class, 'file')->where(function ($q) {
            foreach (voicesMimes() as $mime) {
                $q->where('path', 'LIKE', "%" . $mime . "%");
            }
        });
    }

    /* ============ get last msg =========== */
    public function getLastMsgFromAttribute(){
        $msg=$this->messages()->latest()->first();
        if($msg){
            $msg_user=$msg->user;
            return $msg_user->id==$this->client_id?"أنا":"من الإدارة";
        }
        return "";
    }
}
