<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Traits\JodaResource;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    use JodaResource;
    public $rules=[
        'result'=>'nullable',
        'name'=>'required',
        'type'=>'nullable',
    ];
    public function query($query)
    {
        return $query->latest()->simplePaginate(10);
    }

}
