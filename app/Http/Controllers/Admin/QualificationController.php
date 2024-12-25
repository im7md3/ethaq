<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\JodaResource;
class QualificationController extends Controller
{
    use JodaResource;
    protected $rules = [
        'name' => 'required|string',
        'type' => 'required|string',
    ];

    public function query($query){
        return $query->latest()->paginate(10);
    }
}
