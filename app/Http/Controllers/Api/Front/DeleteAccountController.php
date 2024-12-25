<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class DeleteAccountController extends Controller
{
    public function destroy()
    {
        try {

            $user = auth('sanctum')->user();
            $user->fcmTokens()->delete();
            $user->tokens()->delete();
            $user->update(['delete_date' => now()]);
            return responseApi(true, 'تم حذف الحساب بنجاح');
        } catch (Exception $e) {
            return responseApi(true, '');
        }
    }
}
