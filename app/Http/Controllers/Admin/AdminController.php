<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
class AdminController extends Controller
{
    public function index(){
        $admins=User::admins()->latest('id')->paginate(10);
        return view('admin.admin.index',compact('admins'));
    }
    public function create(){
        $roles = Role::get();
        return view('admin.admin.create',compact('roles'));
    }
    public function store(Request $request){
        $data=$request->validate([
            'name' => 'required',
            'phone' => ['required', 'unique:users,phone','min:10','max:10'],
            'email' => ['required', 'unique:users,email'],
            'password' => 'required|min:6',
            'gender' => 'required',
            'group' => 'required',
            'image' => 'nullable',
        ]);
        $data['type']='admin';
        $data['membership']='individual';
        $data['password']=Hash::make(request('password'));
        if (request('image')) {
            $data['photo'] = store_file(request('image'), 'users');
        }
        $admin=User::create($data);
        $admin->syncRoles($request->group);
        return redirect()->route('admin.admins.index')->with('success','ـم إضافة المشرف بنجاح');
    }

    public function show(User $admin){
        return view('admin.admin.show',compact('admin'));
    }

    public function edit(User $admin){
        $roles = Role::get();
        return view('admin.admin.edit',compact('admin','roles'));
    }

    public function update(Request $request,User $admin){
        $data=$request->validate([
            'name' => 'required',
            'phone' => ['required', 'unique:users,phone,'.$admin->id,'min:10','max:10'],
            'email' => ['required', 'unique:users,email,'.$admin->id],
            'gender' => 'required',
            'group' => 'required',
            'image' => 'nullable',
        ]);
        $data['password']=$request->password?Hash::make(request('password')):$admin->password;
        if ($request->image) {
            delete_file($admin->getRawOriginal('photo'));
            $data['photo'] = store_file(request('image'), 'users');
        }
        $admin->update($data);
        $admin->syncRoles($request->group);
        return redirect()->route('admin.admins.index')->with('success','ـم تعديل المشرف بنجاح');
    }

    public function destroy(User $admin){
        delete_file($admin->getRawOriginal('photo'));
        $admin->delete();
        return back()->with('success','تم حذف المشرف بنجاح');
    }
}
