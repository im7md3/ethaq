<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'parent', 'photo'];
    public function scopeParents($q)
    {
        return $q->whereNull('parent');
    }
    public function scopeParentsWithoutConsultings($q)
    {
        return Department::where('parent','1')->where('name',"<>",'الاستشارات');
    }
    public function scopeConsultings($q)
    {
        $d=Department::where('name','الاستشارات')->first();
        return $q->where('parent',$d->id);
    }
    public function kids()
    {
        return $this->hasMany(Department::class, 'parent');
    }
    public function main()
    {
        return $this->belongsTo(Department::class, 'parent');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'department_users', 'department_id', 'user_id');
    }
    public function sms()
    {
        return $this->morphMany(Sms::class, 'department');
    }
    public function getPhotoAttribute($value){
        return $value ? display_file($value) : display_file('logo.png');
    }
}
