<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\JodaResource;

class PlatformController extends Controller
{
    use JodaResource;
    public $rules=[
        'name'=>'required'
    ];
    public function query($query)
    {
        return $query->withCount('users')->latest()->paginate(10);
    }
}
