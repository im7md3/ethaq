<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JudgerOrder extends Model
{
    use HasFactory;
    protected $fillable=['order_id','judger_id','client_decision','client_refused_msg','judger_decision','judger_refused_msg','type','period','rejected'];
    protected $appends = ['status']; 
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function judger(){
        return $this->belongsTo(User::class,'judger_id');
    }

    public function getStatusAttribute(){
        if($this->client_decision=='accepted' and $this->judger_decision=='accepted'){
            return 'accepted';
        }elseif($this->client_decision=='refused' or $this->judger_decision=='refused'){
            return 'refused';
        }else{
            return 'pending';
        }
    }
}
