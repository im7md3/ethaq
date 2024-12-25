<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Ip;
use App\Service\Yakeen;

class YakeenController extends Controller
{

    public function otp(){
        Yakeen::otp();
    }
}
