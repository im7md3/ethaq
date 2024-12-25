<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\JodaResource;

class AlertController extends Controller
{
    use JodaResource;
    public $rules = [
        'title' => 'required'
    ];
    public function query($query)
    {
        return $query->latest()->paginate(10);
    }
}
