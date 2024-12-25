<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\Ip;
use App\Models\License;
use App\Models\LoginCode;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Notifications\WelcomeEmailNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function vendorRegister(){
        $token=null;
        return view('auth.vendor-register',compact('token'));
    }




    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'type' => ['required'],
            'membership' => ['required'],
            'phone' => ['required', 'unique:users,phone', 'min:10', 'max:10'],
            'agree' => ['required'],
        ], [
            // 'id_number.min'=>'رقم الهوية يجب أن يكون 10 أرقام ',
            'phone.min' => 'رقم الجوال يجب أن يكون 10 أرقام ',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    public function sendOtp(Request $request)
    {
        $data = $request->validate([
            'type' => ['required'],
            'membership' => ['required'],
            'phone' => ['required', 'unique:users,phone', 'min:10', 'max:10'],
            'email' => ['required', 'unique:users,email'],
            'agree' => ['required'],
            'is_advisor' => ['nullable'],
            'user_name' => 'required_if:type,client',
            'username' => 'nullable|unique:users,username',
        ]);

        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            return response()->json(['error' => __('عذرا, رقم الجوال مستخدم من قبل')], 400);
        }
        $res = LoginCode::send($request->phone);
        $code = LoginCode::where('phone', $request->phone)->latest()->first()->code;
        if (isset($res['status'])) {
            return response()->json(['error' => __($res['message'])], $res['status']);
        } elseif (isset($res['accepted']) and $res['accepted'] > 0) {
            return response()->json(['success' => __('تم ارسال رمز التحقق بنجاح'), 'code' => $code], 200);
        } else {
            return response()->json(['error' => __('خطأ في ارسال رمز التحقق')], 400);
        }
    }
    protected function createUser(Request $request)
    {
        $data = $request->validate([
            'type' => ['required'],
            'membership' => ['required'],
            'phone' => ['required', 'unique:users,phone', 'min:10', 'max:10'],
            'email' => ['required', 'unique:users,email'],
            'agree' => ['required'],
            'is_advisor' => ['nullable'],
            'otp' => ['required'],
            'username' => 'nullable|unique:users,username',
            /* 'license_name' => 'required_if:type,vendor',
            'license' => 'required_if:type,vendor',
            'end_at' => 'required_if:type,vendor', */
            'nafath' => 'nullable',
            'user_name' => 'nullable',
            'dob' =>'required_if:nafath,true',
            'gender' =>'required_if:nafath,true',
            'id_end' => 'nullable',
            'id_number' => ['required_if:nafath,true','unique:users,id_number'],
            'fcm_token' => ['sometimes',Rule::unique('users', 'fcm_token')],

        ]);
        $loginCode = LoginCode::where('code', $data['otp'])->where('phone', $data['phone'])->first();
        if ($loginCode) {
            $user = User::create([
                'type' => $data['type'],
                'membership' => $data['membership'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'is_advisor' => $request->is_advisor?1:0,
                'name' => $request->user_name?$data['user_name']:null,
                'birthdate' => $request->dob?Carbon::parse($data['dob'])->format('Y-m-d'):null,
                'gender' => $request->gender?$data['gender']:null,
                'id_end' => $request->id_end?Carbon::parse($data['id_end'])->format('Y-m-d'):null,
                'id_number' => $request->id_number?$data['id_number']:null,
                'username' => $request->username?$data['username']:null,
            ]);
            /* if ($user->type == 'vendor') {
                License::create([
                    'name' => $data['license_name'],
                    'file' => store_file($request->license, 'license'),
                    'end_at' => $data['end_at'],
                    'user_id' => $user->id,
                    'status' => 'pending'
                ]);
            } */
            $device_name = $request->post('device_name', $request->userAgent());
            $token = $user->createToken($device_name)->plainTextToken;
            $token = substr($token, strpos($token, "|") + 1); 
            auth()->loginUsingId($user->id);
            $url=auth()->user()->type=='vendor'?route('vendor.settings',['token'=>$token]):route('client.profile',['token'=>$token]);
            return response()->json(['success' => __('تم التسحيل بنجاح'), 'url' => $url], 200);
        } else {
            return response()->json(['error' => __('هناك خطأ ما')], 400);
        }

        /* Welcome Email Notification after Registeration */

        //$template = EmailTemplate::first();
        //$user->notify(new WelcomeEmailNotification($user, $template));
    }

}
