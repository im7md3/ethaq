<?php

use App\Jobs\SendSmsJob;
use App\Models\User;
use App\Service\Oursms;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

function store_file($file, $path)
{
    //$name = time() . $file->getClientOriginalName();
    $name = $file->hashName();
    return $value = $file->storeAs($path, $name, 'uploads');
}
function delete_file($file)
{
    if ($file != '' and !is_null($file) and Storage::disk('uploads')->exists($file)) {
        unlink('uploads/' . $file);
    }
}
function display_file($name)
{
    return asset('uploads') . '/' . $name;
}

function sendSms($user_id, $enable, $message)
{

    $enableSMS = setting('enableSMS');
    if ($enableSMS == "" or !$enableSMS) {
        $enableSMS = [];
    }
    if (in_array($enable, $enableSMS) and setting('phone_verification_status')) {
        $user = User::notDeleted()->findOrFail($user_id);
        if ($user and $user->enable_sms) {
            if ($user->phone) {
                dispatch(new SendSmsJob($user->phone, $message));
            }
        }
    }
}
function responseApi($status = true, $message = '', $data = null, $errors = null)
{
    if ($errors) {
        return response()->json(['status' => $status, 'message' => $message, 'data' => $data, 'errors' => $errors]);
    } else {
        $user_is_active = null;
        if (auth('sanctum')->check() && (auth('sanctum')->user()->is_block == 1)) {
            auth('sanctum')->user()->update(['fcm_token' => null]);
            $user_is_active = false;
            $status = false;
            $message = 'تم إيقاف العضوية من الإدارة';
        } elseif (auth('sanctum')->check() && (auth('sanctum')->user()->is_block != 1)) {
            $user_is_active = true;
        }
        return response()->json(['status' => $status, 'message' => $message, 'data' => $data, 'user_is_active' => $user_is_active]);
    }
}

function voicesMimes()
{
    return ['audio_example', 'm4a'];
}
