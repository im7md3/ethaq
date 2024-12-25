<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'type', 'description', 'user_id', 'status'];
    protected $with=['user'];
    protected $appends = [
        'UnReadComments',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'ticket_id');
    }
    public function getUnReadCommentsAttribute(){
        return $this->comments()->whereNull('read_at')->where('user_id','<>',auth()->id())->count();
    }
}
