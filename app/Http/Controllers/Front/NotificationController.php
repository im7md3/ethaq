<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(){
        $notifications=Notification::where('user_id',auth()->id())->latest('id')->paginate(10);
        foreach($notifications as $notification){
        $notification->markAsSeen();
        }
        return view('front.notifications',compact('notifications'));
    }
}
