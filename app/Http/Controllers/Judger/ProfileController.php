<?php

namespace App\Http\Controllers\Judger;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Commercial;
use App\Models\Country;
use App\Models\Department;
use App\Models\License;
use App\Models\Occupation;
use App\Models\Qualification;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function settings()
    {
        $user = auth()->user()->load(['country', 'city','occupation']);
        $my_departments=$user->departments()->pluck('departments.id');
        $mainDepartmentId=$user->departments()->first()?->main?->id;
        $countries = Country::all();
        $cities = City::all();
        $departments = Department::all();
        $occupations = Occupation::where('type','judger')->get();
        $specialties = Specialty::where('type','judger')->get();
        $qualifications = Qualification::where('type','judger')->get();
        return view('judger.settings',compact('user', 'countries', 'cities','occupations','departments','my_departments','mainDepartmentId','specialties','qualifications'));
    }
    public function updateSettings(Request $request)
    {
        $user = User::findOrFail($request->id);
        $data = $request->validate([
            'city_id' => 'required',
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'id_number' => ['required', 'integer', 'digits:10', 'unique:users,id_number,' . $user->id],
            'gender' => 'required',
            'company_number' => 'nullable',
            'company_name' => 'nullable',
            'occupation_id'=>'required',
            'specialty_id'=>'required',
            'qualification_id'=>'required',
            'birthdate' => 'nullable',
            'years_of_experience' => 'nullable',
            'bio' => 'nullable',
            'tax_number' => 'nullable',
            'bank_account' => 'nullable', 'integer', 'min:14',
        ]);
        if ($request->image) {
            delete_file($user->getRawOriginal('photo'));
            $data['photo'] = store_file($request->image, 'users');
        }
        $user->update($data);
        $user->departments()->sync($request->departments);
        return back()->with('success', 'تم تعديل البيانات بنجاح');
    }
}
