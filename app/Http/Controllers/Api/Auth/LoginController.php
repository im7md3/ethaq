<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PhoneRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Models\LoginCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required'
        ]);

        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }

        $mobile = '0' . $request->mobile;
        $user = User::where('phone', $mobile)->first();
        if ($user and $user->count() > 0) {
            if ($user->type != $request->account_type) {
                return responseApi(false, 'يرجى تسجيل الدخول من لوحتك');
            }
            /* if ($user->delete_date) {
                return responseApi(false,__('المستخدم محذوف'));
            } else */if ($user->is_block) {
                return responseApi(false,__('تم إيقاف العضوية من الإدارة'));
            }
            $res = LoginCode::send($mobile);
            $code = LoginCode::where('phone', $mobile)->latest()->first()->code;
            if (isset($res['status'])) {
                $data = [$res['status']];
                return responseApi(false, __($res['message']), $data);
            } elseif (isset($res['accepted']) and $res['accepted'] > 0) {
                return responseApi(true, __('تم ارسال رمز التحقق بنجاح'), ['otp' => $code]);
            } else {
                return responseApi(false, __('خطأ في ارسال رمز التحقق'));
            }
        } else {
            return responseApi(false, 'الهاتف غير موجود');
        }
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'otp.*' => 'required',
            'fcm_token' => ['sometimes']
        ]);

        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $key = $request->otp;
        $mobile = '0' . $request->mobile;
        $loginCode = LoginCode::where('code', $key)->where('phone', $mobile)->first();
        $user = User::where('phone', $mobile)->first();
        if ($loginCode and $user) {
            $loginCode->attempted = true;
            $loginCode->save();
            $device_name = $request->post('device_name', $request->userAgent());
            $token = $user->createToken($device_name);
            $user->fcmTokens()->create(
                [
                    'token' => $request->fcm_token ?? null,
                    'device_name' => $device_name
                ]
            );
            $data = ['token' => $token->plainTextToken, 'user' => $user];
            return responseApi(true, '', $data);
        }
        return responseApi(false, 'Otp Not Found');
    }
}
