<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultingEvaluation extends Model
{
    use HasFactory;
    protected $fillable=['consulting_id','client_id','vendor_id','value'];
    protected $appends = [
        'EvaluateName',
    ];
    public function consulting(){
        return $this->belongsTo(Consulting::class,'consulting_id');
    }
    public function client(){
        return $this->belongsTo(User::class,'client_id');
    }
    public function vendor(){
        return $this->belongsTo(User::class,'vendor_id');
    }
    public function getEvaluateNameAttribute(){
        $arr=[
            '1'=>'ضعيف',
            '2'=>'مقبول',
            '3'=>'جيد',
            '4'=>'جيد جدا',
            '5'=>'ممتاز',
        ];
        return $arr[$this->value];
    }
}
