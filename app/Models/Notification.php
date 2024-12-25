<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'link', 'user_id', 'group_name', 'seen_at', 'type', 'data'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function markAsSeen()
    {
        $this->seen=true;
        if (!$this->seen_at) {
            $this->seen_at = Carbon::now();
        }
        $this->save();
    }
    public static function send($user_id, $title, $link = null, $type = null, $data = null)
    {
        static::query()->create(compact('user_id', 'title', 'link', 'type', 'data'));
    }
    public function getTitleAttribute($value)
    {
        $html = $value;
        $new_str = trim($html);
        $htmlWithoutR = preg_replace("@\r@", "", $new_str);
        $text = preg_replace('/<[^>]+>/', '', $htmlWithoutR);
        return $text;
    }


    protected function data(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
}
