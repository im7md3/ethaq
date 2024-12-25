<?php

namespace App\Http\Controllers\Admin;

use App\Exports\VendorsExport;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Department;
use App\Models\Invoice;
use App\Models\Qualification;
use App\Models\Specialty;
use App\Models\User;
use App\Traits\JodaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class VendorController extends Controller
{
    use JodaResource;
    public $model = 'App\Models\User';
    public $rules = [
        'type' => 'required',
        'membership' => 'required',
        'city_id' => 'nullable',
        'name' => 'required',
        'phone' => ['required', 'unique:users,phone', 'min:10', 'max:10'],
        'id_number' => ['required', 'unique:users,id_number', 'min:10', 'max:10'],
        'email' => ['nullable', 'unique:users,email'],
        'password' => 'required|min:6',
        'id_end' => 'nullable',
        'gender' => 'nullable',
        'photo' => 'nullable',
        'company_number' => 'nullable',
        'company_name' => 'nullable',
        'country_id' => 'nullable',
        'is_block' => 'boolean|nullable',
        'years_of_experience' => 'nullable',
        'specialty_id' => 'nullable',
        'qualification_id' => 'nullable',
        'bio' => 'nullable',
        'consulting_department' => 'nullable',
        'departments' => 'nullable',
        'enable_sms' => 'nullable',
        'is_advisor' => 'nullable',
    ];


    public function index(Request $request)
    {
        $users = User::vendors()->withCount('vendorOrders', 'consultingVendor')->where(function ($q) use ($request) {
            if ($request->search) {
                $q->where('id_number', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')->orWhere('name', 'like', '%' . $request->search . '%');
            }
            if (request('status') and request('status') == 'not-active') {
                $q->where('is_block', true);
            }
            if (request('membership')) {
                $q->where('membership', request('membership'));
            }
            if (request('status') and request('status') == 'active') {
                $q->where('is_block', 'false')->orWhereNull('is_block');
            }
            
            if (request('specialty')) {
                $q->where('specialty_id', request('specialty'));
            }
            if (request('qualification')) {
                $q->where('qualification_id', request('qualification'));
            }
            if (request('city')) {
                $q->where('city_id', request('city'));
            }
            if (request('license') and request('license') == 'pending') {
                $q->PendingLicense();
            }
            if (request('license') and request('license') == 'active') {
                $q->ActiveLicense();
            }
            if (request('license') and request('license') == 'no') {
                $q->NoLicense();
            }
            if (request('delete')) {
                $q->whereNotNull('delete_date');
            }
        })->latest('id')->paginate(10);
        $all = User::vendors()->count();
        $active = User::vendors()->NotBlock()->where(function ($q) {
            if (request('membership')) {
                $q->where('membership', request('membership'));
            }
        })->count();
        $not_active = User::vendors()->block()->where(function ($q) {
            if (request('membership')) {
                $q->where('membership', request('membership'));
            }
        })->count();
        $pendingLicense = User::vendors()->PendingLicense()->count();
        $activeLicense = User::vendors()->ActiveLicense()->count();
        $noLicense = User::vendors()->NoLicense()->count();
        $delete = User::vendors()->whereNotNull('delete_date')->count();
        return view('admin.vendor.index', compact('all', 'users', 'active', 'not_active', 'pendingLicense', 'activeLicense', 'noLicense','delete'));
    }

    public function beforeStore()
    {
        request()->merge(['password' => Hash::make(request('password'))]);
        if (request('image')) {
            request()->merge(['photo' => store_file(request('image'), 'users')]);
        }
    }
    public function edit(User $vendor)
    {
        $my_departments = $vendor->departments()->pluck('departments.name');
        $departments = Department::where('parent', 2)->get();
        return view('admin.vendor.edit', compact('vendor', 'departments', 'my_departments'));
    }
    public function beforeUpdate($user)
    {
        $this->rules['email'] = 'nullable|unique:users,email,' . $user->id . ',id';
        $this->rules['phone'] = 'required|unique:users,phone,' . $user->id . ',id';
        $this->rules['id_number'] = 'required|unique:users,id_number,' . $user->id . ',id';
        $this->rules['password'] = 'sometimes';

        request()->merge(['password' => request('password') ? Hash::make(request('password')) : $user->password]);
        if (request('image')) {
            delete_file($user->photo);
            request()->merge(['photo' => store_file(request('image'), 'users')]);
        }
    }
    public function afterUpdate($user)
    {
        if($user->license){
            $user->license->delete();
        }
        $departments_ids = Department::whereIn('name', request('departments'))->pluck('id');
        $user->departments()->sync($departments_ids);
    }
    public function show($user_id)
    {
        $user = User::withCount(['license', 'commercial', 'invoices'])->findOrFail($user_id);
        $invoices = Invoice::with(['order'])->where('from_id',$user->id)->orWhere('to_id',$user->id)->paginate(10);
        $license = $user->license;
        $notes = $user->notes()->paginate(10);
        $commercial = $user->commercial;
        $financial = $user->financial()->latest('id')->paginate(10);
        return view('admin.vendor.show', compact(['user', 'invoices', 'license', 'commercial', 'financial','notes']));
    }

    public function cities()
    {
        $cities = City::withCount(['users' => function ($q) {
            $q->where('type', 'vendor');
        }])->paginate();
        return view('admin.vendor.cities', compact('cities'));
    }
    public function qualificationsAndSpecialties()
    {
        $specialties = Specialty::where('type', 'vendor')->withCount(['users' => function ($q) {
            $q->where('type', 'vendor');
        }])->get();
        $qualifications = Qualification::where('type', 'vendor')->withCount(['users' => function ($q) {
            $q->where('type', 'vendor');
        }])->get();
        return view('admin.vendor.qualifications-and-specialties', compact('specialties', 'qualifications'));
    }
    public function exports()
    {
        $vendors = User::vendors()->withCount('vendorOrders', 'consultingVendor')->where(function ($q) {
            if (request('search')) {
                $q->where('id_number', 'like', '%' . request('search') . '%')
                    ->orWhere('phone', 'like', '%' . request('search') . '%');
            }
            if (request('status') and request('status') == 'active') {
                $q->NotBlock();
            }
            if (request('membership')) {
                $q->where('membership', request('membership'));
            }
            if (request('status') and request('status') == 'not-active') {
                $q->Block();
            }
            if (request('specialty')) {
                $q->where('specialty_id', request('specialty'));
            }
            if (request('qualification')) {
                $q->where('qualification_id', request('qualification'));
            }
            if (request('city')) {
                $q->where('city_id', request('city'));
            }
            if (request('license') and request('license') == 'pending') {
                $q->PendingLicense();
            }
            if (request('license') and request('license') == 'active') {
                $q->ActiveLicense();
            }
            if (request('license') and request('license') == 'no') {
                $q->NoLicense();
            }
        })->latest('id')->get();
        return Excel::download(new VendorsExport($vendors), 'vendors' . time() . '.xlsx');
    }
    public function notConsultationPrice()
    {
        $vendors = User::vendors()->whereNull('consultation_price')->orWhere('consultation_price', 0)->paginate();
        return view('admin.vendor.not-consultation-price', compact('vendors'));
    }
}
