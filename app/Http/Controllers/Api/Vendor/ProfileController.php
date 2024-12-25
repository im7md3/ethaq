<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Models\AdvisorFile;
use App\Models\Bank;
use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\License;
use App\Models\Occupation;
use App\Models\Qualification;
use App\Models\SetTime;
use App\Models\Specialty;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function settings()
    {
        $user = auth()->user()->load(['country', 'city', 'occupation', 'license', 'bank', 'consultingDepartments', 'advisorFile']);
        $my_departments = $user->departments()->pluck('departments.name');
        $mainDepartment = $user->mainDepartment;
        $countries = Country::all();
        $cities = City::all();
        $banks = Bank::all();
        $departments = Department::all();
        $consulting_departments = Department::Consultings()->get();
        $occupations = Occupation::where('type', 'vendor')->get();
        $specialties = Specialty::where('type', 'vendor')->get();
        $qualifications = Qualification::where('type', 'vendor')->get();
        $times = SetTime::where('user_id', $user->id)->get();

        $verified_data = [
            'photo' => is_null($user->getRawOriginal('photo')) ? false : true,
            'email_verified' => $user->email ? true : false,
            'departments' => $user->departments->count() > 0 ? true : false,
            'consultingDepartments' => $user->consultingDepartments->count() > 0 ? true : false,
            'consulting_requests_price' => $user->consulting_price > 0 ? true : false,
        ];
        if($user->is_advisor){
            $verified_data['license']=$user->advisorFile ? true : false;
        }else{
            $verified_data['license']=$user->license ? true : false;
        }
        $profile_complete = $user->ProfileComplete;
        $data = ['user' => $user, 'verified_data' => $verified_data, 'profile_complete' => $profile_complete, 'countries' => $countries, 'cities' => $cities, 'occupations' => $occupations, 'specialties' => $specialties, 'qualifications' => $qualifications, 'banks' => $banks, 'consulting_departments' => $consulting_departments, 'order_departments' => $departments, 'my_departments' => $my_departments, 'mainDepartment' => $mainDepartment, 'times' => $times];

        return responseApi(true, '', $data);
    }

    public function updateSettings(Request $request)
    {
        $user = auth()->user()->load('times');
        $rules = [
            'city_name' => 'nullable',
            'city_id' => 'required',
            'email' => ['sometimes', 'required', 'email', 'unique:users,email,' . $user->id],
            'id_number' => ['required', 'digits:10', 'unique:users,id_number,' . $user->id],
            'gender' => 'nullable',
            'company_number' => 'nullable',
            'company_name' => 'nullable',
            'country_id' => 'nullable',
            'address' => 'nullable',
            'birthdate' => 'nullable',
            'id_end' => 'nullable',
            'occupation_id' => 'sometimes|required',
            'specialty_id' => 'sometimes|required',
            'qualification_id' => 'sometimes|required',
            'years_of_experience' => 'required',
            'bio' => 'required',
            'main_department_id' => 'required',
            'departments' => 'required',
            'another_department' => 'nullable',
            'has_tax_certificate' => 'nullable',
            'tax_certificate_photo' => 'nullable',
            'iban_cer_photo' => 'nullable',
            'bank_id' => 'nullable|exists:banks,id',
            'tax_number' => 'nullable',
            'bank_account' => 'nullable', 'integer', 'min:22',
            /*'times' => 'required_without:from_time|required_without:to_time',
            'times.*.day' => ['in:saturday,sunday,monday,tuesday,wednesday,thursday,friday'],
             "from_time" => "required_without:times",
            "to_time" => "required_without:times", */
            'times' => 'nullable',
            'times.*.day' => 'nullable',
            "from_time" => "nullable",
            "to_time" => "nullable",
            'consulting_price' => ['required', 'gte:' . setting('minimum_amount_for_consultation')],
        ];
        if (is_null($user->getRawOriginal('photo'))) {
            $rules['image'] = 'required';
        }
        if (!$user->is_advisor and !$user->license) {
            $rules['license_name'] = 'required';
            $rules['license'] = 'required';
            $rules['end_at'] = 'required';
        }
        if ($user->is_advisor and !$user->advisorFile) {
            $rules['advisor_file'] = 'required';
            $rules['advisor_file_name'] = 'required';
        }
        $validator = Validator::make($request->all(), $rules, ['main_department_id' => 'يجب اختيار القسم الرئيسي']);
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
        if ($request->has_tax_certificate == true) {
            $request->merge(['has_tax_certificate' => true]);
        }
        if ($request->tax_certificate_photo) {
            delete_file($user->tax_certificate);
            $request->merge(['tax_certificate' => store_file($request->tax_certificate_photo, 'tax_certificate')]);
        }
        $this->setTimes($user, $request);
        $user->update($request->except(['name']));
        $departments_ids = Department::whereIn('name', $request->departments)->pluck('id');
        $user->departments()->sync($departments_ids);
        if ($request->license) {
            $user->license()->delete();
            License::create([
                'user_id' => $user->id,
                'file' => store_file($request->license, 'licenses'),
                'end_at' => $request->end_at,
                'name' => $request->license_name,
            ]);
        }
        if ($request->advisor_file) {
            $user->advisorFile()->delete();
            AdvisorFile::create([
                'user_id' => $user->id,
                'file' => store_file($request->advisor_file, 'licenses'),
                'name' => $request->advisor_file_name,
                'status' => 'pending'
            ]);
        }
        $data = ['user' => $user];
        return responseApi(true, 'تم تعديل البيانات بنجاح', $data);
    }

    public function updateInfo(Request $request)
    {
        $user = auth()->user();
        $rules = [
            'city_name' => 'nullable',
            'city_id' => 'required',
            'email' => ['sometimes', 'required', 'email', 'unique:users,email,' . $user->id],
            'id_number' => ['required', 'digits:10', 'unique:users,id_number,' . $user->id],
            'gender' => 'nullable',
            'company_number' => 'nullable',
            'company_name' => 'nullable',
            'country_id' => 'nullable',
            'address' => 'nullable',
            'birthdate' => 'nullable',
            'id_end' => 'nullable',
            'occupation_id' => 'sometimes|required',
            'specialty_id' => 'sometimes|required',
            'qualification_id' => 'sometimes|required',
            'years_of_experience' => 'required',
            'bio' => 'required',
            'license_name' => 'nullable',
            'license' => 'nullable',
            'end_at' => 'nullable',
            'advisor_file' => 'nullable',
            'advisor_file_name' => 'nullable',
            'enable_sms' => 'nullable',
            'consulting_price' => ['required', 'gte:' . setting('minimum_amount_for_consultation')],

        ];
        /* if(is_null($user->getRawOriginal('photo'))){
            $rules['image']='required';
        } */
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        if ($request->image) {
            delete_file($user->getRawOriginal('photo'));
            $request->merge(['photo' => store_file($request->image, 'clients')]);
        }
        $user->update($request->except(['name']));
        if ($request->license) {
            $user->license()->delete();
            License::create([
                'user_id' => $user->id,
                'file' => store_file($request->license, 'licenses'),
                'end_at' => $request->end_at,
                'name' => $request->license_name,
            ]);
        }

        if ($request->advisor_file) {
            $user->advisorFile()->delete();
            AdvisorFile::create([
                'user_id' => $user->id,
                'file' => store_file($request->advisor_file, 'licenses'),
                'name' => $request->advisor_file_name,
                'status' => 'pending'
            ]);
        }
        $data = ['user' => $user];
        return responseApi(true, 'تم تعديل البيانات بنجاح', $data);
    }

    public function updateDepartments(Request $request)
    {
        $user = auth()->user();
        $rules = [
            'main_department_id' => 'required',
            'departments' => 'required',
            'another_department' => 'nullable',
        ];
        $validator = Validator::make($request->all(), $rules, ['main_department_id' => 'يجب اختيار القسم الرئيسي']);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $departments_ids = Department::whereIn('name', $request->departments)->pluck('id');
        $user->departments()->sync($departments_ids);
        $user->update($request->all());
        $data = ['user' => $user];
        return responseApi(true, 'تم تعديل البيانات بنجاح', $data);
    }
    public function updateConsultingDepartment(Request $request)
    {
        $user = auth()->user();
        $rules = [
            'consulting_department' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $user->departments()->sync($request->consulting_department);
        $data = ['user' => $user];
        return responseApi(true, 'تم تعديل البيانات بنجاح', $data);
    }
    public function updateFinancial(Request $request)
    {
        $user = auth()->user();
        $rules = [
            'has_tax_certificate' => 'nullable',
            'tax_certificate_photo' => 'required_if:has_tax_certificate,true',
            'iban_cer_photo' => 'nullable',
            'bank_id' => 'nullable|exists:banks,id',
            'tax_number' => 'required_if:has_tax_certificate,true',
            'bank_account' => 'nullable', 'integer', 'min:22',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        if ($request->iban_cer_photo) {
            delete_file($user->iban_cer);
            $request->merge(['iban_cer' => store_file($request->iban_cer_photo, 'iban')]);
        }
        if ($request->has_tax_certificate == true) {
            $request->merge(['has_tax_certificate' => true]);
        }
        if ($request->tax_certificate_photo) {
            delete_file($user->tax_certificate);
            $request->merge(['tax_certificate' => store_file($request->tax_certificate_photo, 'tax_certificate')]);
        }
        $user->update($request->all());
        $data = ['user' => $user];
        return responseApi(true, 'تم تعديل البيانات بنجاح', $data);
    }

    public function times()
    {
        $user = auth('sanctum')->user();
        $times = SetTime::where('user_id', $user->id)->get();
        return responseApi(true, '', ['times' => $times]);
    }

    public function updateTimes(Request $request)
    {
        $user = auth('sanctum')->user()->load('times');
        $rules = [
            /* 'times' => 'required_without:from_time|required_without:to_time',
            'times.*.day' => ['in:saturday,sunday,monday,tuesday,wednesday,thursday,friday'],
            "from_time" => "required_without:times",
            "to_time" => "required_without:times", */
            'times' => 'nullable',
            'times.*.day' => 'nullable',
            "from_time" => "nullable",
            "to_time" => "nullable",
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $this->setTimes($user, $request);
        $data = ['user' => $user];
        return responseApi(true, 'تم تعديل البيانات بنجاح', $data);
    }

    public function setTimes($user, $request)
    {
        if ($request->times or $request->from_time or $request->to_time) {
            $user->times()->delete();
            /* if ($request->from_time and $request->to_time) {
                $days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
                foreach ($days as $day) {
                    SetTime::create([
                        'user_id' => $user->id,
                        'day' => $day,
                        'from' => $request->from_time,
                        'to' => $request->to_time,
                    ]);
                }
            } */
            if ($request->times) {
                foreach ($request->times as $time) {
                    $t = SetTime::where('user_id', $user->id)->where('day', $time['day'])->first();
                    if ($t) {
                        $t->update([
                            'from' =>$time['from']??$request->from_time,
                            'to' => $time['to']??$request->to_time
                        ]);
                    } else {
                        SetTime::create([
                            'user_id' => $user->id,
                            'day' => $time['day'],
                            'from' =>$time['from']??$request->from_time,
                            'to' => $time['to']??$request->to_time
                        ]);
                    }
                }
            }
        }
    }
}
