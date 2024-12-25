<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable=['user_id','negotiation_id','msg','order_id'];
    protected $with=['user','files'];
    public function negotiation(){
        return $this->belongsTo(Negotiation::class,'negotiation_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }
    /* **************************************** Files ******************************* */
    public function files(){
        return $this->morphMany(Attachment::class,'file');
    }
}
