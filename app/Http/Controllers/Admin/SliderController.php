<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\JodaResource;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use JodaResource;
    public $rules=[
        'file'=>'nullable',
        'image'=>'nullable',
        'type'=>'nullable',
        'model_type'=>'nullable',
    ];
    public function query($query)
    {
        return $query->latest()->paginate(10);
    } 
    public function beforeStore()
    {
        if(request()->hasFile('file')){
            request()->merge(['image'=>store_file(request('file'),'slider')]);
        }
    }
    public function beforeUpdate($slider)
    {
        if (request('file')) {
            delete_file($slider->image);
            request()->merge(['image' => store_file(request('file'), 'slider')]);
        }
    }
}
