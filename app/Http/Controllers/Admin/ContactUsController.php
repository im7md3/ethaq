<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Traits\JodaResource;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    use JodaResource;
    public $rules = [
        'status' => 'required|in:pending,finished',
    ];
    public $route='admin.contact-us';
    public function index()
    {
        $contactuses=ContactUs::where(function($q){
            if(request('status')){
                $q->where('status',request('status'));
            }
        })->latest('id')->paginate(10);
        $all=ContactUs::count();
        $pending=ContactUs::where('status','pending')->count();
        $finished=ContactUs::where('status','finished')->count();
        return view('admin.contact-us.index',compact('contactuses','all','pending','finished'));
    }

}
