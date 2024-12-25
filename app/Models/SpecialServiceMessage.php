<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialServiceMessage extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'service_id', 'seen', 'content'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function service()
    {
        return $this->belongsTo(SpecialService::class, 'service_id');
    }
    public function files()
    {
        return $this->morphMany(Attachment::class, 'file');
    }
}
