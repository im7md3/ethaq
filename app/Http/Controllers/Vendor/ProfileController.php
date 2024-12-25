<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\City;
use App\Models\Commercial;
use App\Models\Country;
use App\Models\Department;
use App\Models\License;
use App\Models\Occupation;
use App\Models\Qualification;
use App\Models\Specialty;
use App\Models\User;
use App\Rules\ArabicWords;
use App\Rules\PhotoIsNull;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function settings()
    {
        $user = auth()->user()->load(['country', 'city', 'occupation']);
        $my_departments = $user->departments()->pluck('departments.name');
        $mainDepartmentId = $user->departments()->first()?->main?->id;
        $countries = Country::all();
        $cities = City::all();
        $banks = Bank::all();
        $departments = Department::where('parent',2)->get();
        $occupations = Occupation::where('type', 'vendor')->get();
        $specialties = Specialty::where('type', 'vendor')->get();
        $qualifications = Qualification::where('type', 'vendor')->get();
        return view('vendor.settings', compact('user', 'countries', 'cities', 'occupations', 'departments', 'my_departments', 'mainDepartmentId', 'specialties', 'qualifications','banks'));
    }
    public function updateSettings(Request $request)
    {
        $user = User::findOrFail($request->id);
        $rules=[
            'city_name' => 'nullable',
            'city_id' => 'required',
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'id_number' => ['required', 'integer', 'digits:10', 'unique:users,id_number,' . $user->id],
            'gender' => 'nullable',
            'company_number' => 'nullable',
            'company_name' => 'nullable',
            'country_id' => 'nullable',
            'address' => 'nullable',
            'birthdate' => 'nullable',
            'id_end' => 'nullable',
            'occupation_id' => 'required',
            'specialty_id' => 'required',
            'qualification_id' => 'required',
            'bank_id' => 'nullable|exists:banks,id',
            'bank_account' => 'nullable', 'integer', 'min:22',
            'years_of_experience' => 'required',
            'bio' => 'required',
            'tax_number' => 'nullable',
            'departments' => 'required',
            'another_department' => 'nullable',
            'iban_cer_photo'=>'nullable',
            'consulting_price'=>['required','gte:'.setting('minimum_amount_for_consultation')],
            'enable_sms' => 'nullable',

        ];
        if (is_null($user->getRawOriginal('photo'))) {
            $rules['image'] = 'required';
        }
        $data = $request->validate($rules);
        
        $departments_ids=Department::whereIn('name',$request->departments)->pluck('id');
        if ($request->image) {
            delete_file($user->getRawOriginal('photo'));
            $data['photo'] = store_file($request->image, 'users');
        }
        if ($request->iban_cer_photo) {
            delete_file($user->iban_cer);
            $request->merge(['iban_cer' => store_file($request->iban_cer_photo, 'iban')]);
        }
        $user->update($data);
        $user->departments()->sync($departments_ids);
        return redirect()->route('vendor.home')->with('success', 'تم تعديل البيانات بنجاح');
    }
}
