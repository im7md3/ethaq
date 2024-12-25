<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $fillable=['order_id','type','content'];
    public static function store($order_id,$type,$content){
        static::query()->create(compact('order_id','type','content'));
    }
}
