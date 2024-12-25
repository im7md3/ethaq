<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultingMessages extends Model
{
    use HasFactory;
    protected $fillable = ['consulting_id', 'from', 'to', 'msg', 'seen_at'];
    protected $with = ['toUser', 'fromUser', 'files'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
    protected $appends = ['seen', 'human_date'];
    public function consulting()
    {
        return $this->belongsTo(Consulting::class, 'consulting_id');
    }
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from');
    }
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to');
    }
    /* **************************************** Files ******************************* */
    public function files()
    {
        return $this->morphMany(Attachment::class, 'file');
    }
    public function getConsultingIdAttribute($value)
    {
        return (int)$value;
    }
    public function getFromAttribute($value)
    {
        return (int)$value;
    }
    public function getToAttribute($value)
    {
        return (int)$value;
    }

    /* ========== Seen ========== */
    public function getSeenAttribute()
    {
        if ($this->seen_at) {
            return true;
        }
        return false;
    }
    /* ======== Mark Messages As Seen ========= */
    public static function markMessagesAsSeen($con_id)
    {
        if (auth()->guard('sanctum')->check())
            $user = auth('sanctum')->user();
        else {
            $user = auth()->user();
        }
        $unseen_messages = ConsultingMessages::where('consulting_id', $con_id)->where('to', $user->id)->whereNull('seen_at')->get();
        foreach ($unseen_messages as $msg) {
            $msg->update(['seen_at' => now()]);
        }
    }

    /******* Human Date *******/
    public function getHumanDateAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}
