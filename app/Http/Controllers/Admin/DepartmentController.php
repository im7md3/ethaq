<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Traits\JodaResource;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    use JodaResource;
    public $rules = [
        'parent' => 'nullable',
        'name' => 'required',
        'photo' => 'nullable|image'
    ];
    public function query($query)
    {
        return $query->where('parent', 1)->orWhereNull('parent')->with('main')->withCount('users')->latest()->paginate(10);
    }
    public function users(Department $department)
    {
        $users = $department->users()->paginate();
        return view('admin.department.users', compact('department', 'users'));
    }
    public function sub_departments()
    {
        $sub_departments = Department::when(request('parent'), function ($q) {
            $q->where('parent', request('parent'));
        })->whereNotNull('parent')->where('parent', '!=', 1)->with('main')->withCount('users')->latest()->paginate(10);
        return view('admin.department.sub_departments', compact('sub_departments'));
    }

    public function store(Request $request)
    {
        $data = $this->validateStoreRequest();

        if ($photo = $request->file('photo')) {
            $data['photo'] = store_file($photo, 'departments');
        }

        Department::create($data);

        return redirect()->back()->with('success', trans('تم الحفظ بنجاح'));
    }



    public function update(Request $request, Department $department)
    {
        $data = $this->validateUpdateRequest();

        if ($photo = $request->file('photo')) {
            delete_file($department->photo);
            $data['photo'] = store_file($photo, 'departments');
        }

        $department->update($data);

        return redirect()->back()->with('success', trans('تم التعديل'));
    }

    protected function beforeDestroy($department)
    {
        if ($department->photo) {
            delete_file($department->photo);
        }
    }
}
