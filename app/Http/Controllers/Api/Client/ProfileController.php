<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\City;
use App\Models\Country;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function settings()
    {
        $user = auth()->user()->load(['country', 'city','bank']);
        $countries = Country::all();
        $cities = City::all();
        $banks = Bank::all();

        $data = ['user' => $user, 'countries' => $countries, 'cities' => $cities,'banks'=>$banks];
        return responseApi(true, '', $data);
    }
    public function updateSettings(Request $request)
    {
        $user = auth()->user();
        $rules = [
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'username' => ['nullable', 'unique:users,username,' . $user->id],
            'id_number' => ['sometimes', 'required', 'integer', 'digits:10', 'unique:users,id_number,' . $user->id],
            'birthdate' => 'nullable',
            'id_end' => 'nullable',
            'iban_cer_photo'=>'nullable',
            'bank_id' => 'nullable|exists:banks,id',
            'tax_number' => 'nullable',
            'bank_account' => 'nullable', 'integer', 'min:14',
            'enable_sms' => 'nullable',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        if ($request->image) {
            delete_file($user->getRawOriginal('photo'));
            $request->merge(['photo' => store_file($request->image, 'clients')]);
        }
        if ($request->iban_cer_photo) {
            delete_file($user->iban_cer);
            $request->merge(['iban_cer' => store_file($request->iban_cer_photo, 'iban')]);
        }
        $user->update($request->except(['name']));
        $data = ['user' => $user];
        return responseApi(true, 'تم تعديل البيانات بنجاح', $data);
    }
    public function updateInfo(Request $request)
    {
        $user = auth()->user();
        $rules = [
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'username' => ['nullable', 'unique:users,username,' . $user->id],
            'id_number' => ['sometimes', 'required', 'integer', 'digits:10', 'unique:users,id_number,' . $user->id],
            'birthdate' => 'nullable',
            'id_end' => 'nullable',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        if ($request->image) {
            delete_file($user->getRawOriginal('photo'));
            $request->merge(['photo' => store_file($request->image, 'clients')]);
        }
        $user->update($request->except(['name']));
        $data = ['user' => $user];
        return responseApi(true, 'تم تعديل البيانات بنجاح', $data);
    }

    public function updateFinancial(Request $request)
    {
        $user = auth()->user();
        $rules = [
            'iban_cer_photo'=>'nullable',
            'bank_id' => 'nullable|exists:banks,id',
            'tax_number' => 'nullable',
            'bank_account' => 'nullable', 'integer', 'min:14',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        if ($request->iban_cer_photo) {
            delete_file($user->iban_cer);
            $request->merge(['iban_cer' => store_file($request->iban_cer_photo, 'iban')]);
        }
        $user->update($request->all());
        $data = ['user' => $user];
        return responseApi(true, 'تم تعديل البيانات بنجاح', $data);
    }
    public function platforms(){
        $user = auth('sanctum')->user();
        $platforms=Platform::all();
        return responseApi(true, '', ['platforms' => $platforms,'user'=>$user]);
    }
    public function updatePlatforms(Request $request){
        $user = auth('sanctum')->user();
        $rules = [
            'platform_id'=>'nullable',
            'another_platform' => 'nullable',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $user->update($request->all());
        return responseApi(true, 'تم تعديل البيانات بنجاح', ['user'=>$user]);

    }
}
