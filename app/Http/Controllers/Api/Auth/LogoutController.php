<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\FcmToken;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request){
        try{

            $user=auth()->user();
            $token=FcmToken::where('token',$request->fcm_token)->first();
            if($token){
                $token->delete();
            }
            $user->currentAccessToken()->delete();
            return responseApi(true,'تم تسجيل الخروج بنجاح');
        }catch (Exception $e) {
            return responseApi(true,'');
        }
    }

}
