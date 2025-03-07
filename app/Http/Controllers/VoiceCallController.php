<?php

namespace App\Http\Controllers;

use App\Classes\AgoraDynamicKey\RtcTokenBuilder;
use App\Events\MakeAgoraCall;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoiceCallController extends Controller
{
    public function index(Request $request)
    {
        // fetch all users apart from the authenticated user
        $users = User::where('id', '<>',3)->get();
        return view('agora-chat', ['users' => $users]);
    }

    public function token(Request $request)
    {

        $appID = env('AGORA_APP_ID');
        $appCertificate = env('AGORA_APP_CERTIFICATE');
        $channelName = $request->channelName;
        $user = Auth::user()->name;
        $role = RtcTokenBuilder::RoleAttendee;
        $expireTimeInSeconds = 3600;
        $currentTimestamp = now()->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

        $token = RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $user, $role, $privilegeExpiredTs);

        return $token;
    }

    public function callUser(Request $request)
    {

        $data['userToCall'] = $request->user_to_call;
        $data['channelName'] = $request->channel_name;
        $data['from'] = Auth::id();

        broadcast(new MakeAgoraCall($data))->toOthers();
    }
}
