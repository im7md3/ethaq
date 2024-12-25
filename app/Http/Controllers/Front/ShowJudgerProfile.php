<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ShowJudgerProfile extends Controller
{
    public function profile(User $judger){
        $user = $judger->load(['occupation','specialty','qualification'])->loadCount(['secondJudgerOrders','firstJudgerOrders']);
        return view('front.show-judger-profile', compact('user'));
    }
}
