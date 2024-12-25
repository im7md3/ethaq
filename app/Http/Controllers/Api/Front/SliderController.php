<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function sliders()
    {
        $data=['sliders'=>Slider::get()];
        return responseApi(true,'',$data);
    }
}
