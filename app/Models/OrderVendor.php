<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderVendor extends Model
{
    use HasFactory;
    protected $table = 'order_vendors';
    protected $fillable=['order_id','vendor_id'];
}
