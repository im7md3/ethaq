<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ClientsExport;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use App\Traits\JodaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
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
        'enable_sms' => 'nullable',
    ];


    public function index(Request $request)
    {
        $users = User::clients()->withCount('clientOrders', 'consultingClient')->where(function ($q) use ($request) {
            if ($request->search) {
                $q->where('id_number', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('name', 'like', '%' . $request->search . '%');
            }
            if (request('client_id')) {
                $q->where('client_id', request('client_id'));
            }
            if (request('plat')) {
                $q->where('platform_id', request('plat'));
            }
            if (request('status') and request('status') == 'active') {
                $q->NotBlock();
            }
            if (request('status') and request('status') == 'not-active') {
                $q->Block();
            }
            if (request('delete') == true) {
                $q->whereNotNull('delete_date');
            }
        })->latest('id')->paginate(10);
        $all = User::clients()->count();

        $active = User::clients()->NotBlock()->count();
        $not_active = User::clients()->Block()->count();
        $delete = User::clients()->whereNotNull('delete_date')->count();
        return view('admin.client.index', compact('users', 'active', 'not_active', 'all', 'delete'));
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
        $invoices = Invoice::with(['order'])->where('from_id', $user->id)->orWhere('to_id', $user->id)->paginate(10);
        $notes = $user->notes()->paginate(10);
        $license = $user->license;
        $commercial = $user->commercial;
        $financial = $user->financial()->latest('id')->paginate(10);
        return view('admin.client.show', compact(['user', 'invoices', 'license', 'commercial', 'financial', 'notes']));
    }

    public function exports(Request $request)
    {
        $clients = User::clients()->withCount('clientOrders', 'consultingClient')->where(function ($q) use ($request) {
            if ($request->search) {
                $q->where('id_number', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('name', 'like', '%' . $request->search . '%');
            }
            if (request('client_id')) {
                $q->where('client_id', request('client_id'));
            }
            if (request('plat')) {
                $q->where('platform_id', request('plat'));
            }
            if (request('status') and request('status') == 'active') {
                $q->NotBlock();
            }
            if (request('status') and request('status') == 'not-active') {
                $q->Block();
            }
        })->latest('id')->get();

        return Excel::download(new ClientsExport($clients), 'clients' . time() . '.xlsx');
    }
}
