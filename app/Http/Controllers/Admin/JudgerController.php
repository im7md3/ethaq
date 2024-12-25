<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\JodaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class JudgerController extends Controller
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
    ];


    public function index(Request $request)
    {
        $users = User::judgers()->where(function ($q) use ($request) {
            if ($request->search) {
                $q->where('id_number', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('name', 'like', '%' . $request->search . '%');
            }
            if (request('status') and request('status')=='active') {
                $q->NotBlock();
            }
            if (request('status') and request('status')=='not-active') {
                $q->Block();
            }
        })->latest('id')->paginate(10);
        $all=User::judgers()->count();
        $active = User::judgers()->NotBlock()->count();
        $not_active = User::judgers()->Block()->count();
        return view('admin.judger.index', compact('users', 'active', 'not_active','all'));
    }

    public function beforeStore()
    {
        request()->merge(['password' => Hash::make(request('password'))]);
        if (request('image')) {
            request()->merge(['photo' => store_file(request('image'), 'users')]);
        }
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

    public function show($user_id)
    {
        $user = User::withCount(['license', 'commercial', 'invoices'])->findOrFail($user_id);
        $invoices = $user->invoices()->with(['order'])->paginate(10);
        $license = $user->license;
        $commercial = $user->commercial;
        return view('admin.judger.show', compact(['user', 'invoices', 'license', 'commercial']));
    }
}
