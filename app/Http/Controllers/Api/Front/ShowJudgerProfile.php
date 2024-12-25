<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ShowJudgerProfile extends Controller
{
    public function profile(User $judger){
        $user = $judger->load(['occupation','specialty','qualification'])->loadCount(['secondJudgerOrders','firstJudgerOrders']);
        return responseApi(true,'',['judger'=>$user]);
    }
}
