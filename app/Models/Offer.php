<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $casts=['execution_method'=>'array'];
    protected $fillable=['order_id','vendor_id','amount','days','negotiable','response_speed','status','works','documents','execution_method','other_execution_method','decision_place','committee','management','duration','rejected_reason'];
    /* ******************* Order ************************ */
    public function order(){
        return $this->belongsTo(Order::class);
    }
    /* ******************* Order ************************ */
    public function vendor(){
        return $this->belongsTo(User::class,'vendor_id');
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
    public function getExecutionMethodEncodedAttribute(){
        $arr=$this->execution_method;
        if(in_array('other',$arr)){
            array_splice($arr,-1);
            $arr[]='أخرى: '.$this->other_execution_method;
        }
        $str='';
        foreach($arr as $a){
            $str.=$a.', ';
        }
        return $str;
    }

    public function getPeriodAttribute(){
        if($this->duration=='specified'){
            return $this->days.' يوم';
        }else{
            if($this->decision_place=='لجنة'){
                return $this->decision_place .' '. $this->committee;
            }elseif($this->decision_place=='قرار من الجهة/الإدارة'){
                return $this->decision_place .' '. $this->management;
            }else{
                return $this->decision_place;
            }
            
        }
    }
}
