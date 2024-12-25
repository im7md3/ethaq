<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\LoginCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function vendorRegister(){
        $token=null;
        return view('api.auth.vendor-register',compact('token'));
    }
    public function clientRegister(){
        $token=null;
        return view('api.auth.client-register',compact('token'));
    }


}
