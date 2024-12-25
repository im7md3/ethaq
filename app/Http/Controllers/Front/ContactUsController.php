<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Traits\JodaResource;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    use JodaResource;

    public $rules = [
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        'subject' => 'required',
        'message' => 'required',
        'g-recaptcha-response' => 'required|captcha'
    ];

    public function afterStore()
    {
        return redirect()->back()->with('success', 'تم إرسال الرسالة بنجاح');
    }
}
