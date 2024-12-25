<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $fillable=['favorite_type','favorite_id','user_id'];
    public function favorite(){
        return $this->morphTo();
    }
    public static function store($obj){
        $user_id=auth()->id();
        $obj->favorites()->create(compact('user_id'));
    }
    public static function destroy($obj){
        $user_id=auth()->id();
        $obj->favorites()->where('user_id',$user_id)->delete();
    }
}
