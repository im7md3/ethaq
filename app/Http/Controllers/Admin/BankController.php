<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\JodaResource;
use Illuminate\Http\Request;

class BankController extends Controller
{
    use JodaResource;
    public $rules=[
        'name'=>'required'
    ];
    public function query($query)
    {
        return $query->latest()->paginate(10);
    }
}
