<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Sms;
use App\Models\User;
use App\Service\Oursms;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read_SMS')->only('index');
        $this->middleware('can:delete_SMS')->only('destroy');
    }

    public function index()
    {
        $sms = Sms::with('user')->latest('id')->paginate();
        return view('admin.sms.index', compact('sms'));
    }
    public function departments()
    {
        $departments = Department::all();
        return view('admin.sms.department_create', compact('departments'));
    }
    public function departmentsStore(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'department_id' => 'required',
            'msg' => 'required',
        ]);
        $department = Department::findOrFail($request->department_id);
        $data['department_id'] = $department->id;
        $data['department_type'] = get_class($department);
        $sms=Sms::create($data);
        $department = $sms->department;
            $users = $department->users()->get();
            foreach ($users as $user) {
                Oursms::send($user?->phone, $sms->msg);
            }
        return redirect()->route('admin.sms.index')->with('success', 'تم إرسال الرسالة بنجاح');
    }

    public function users()
    {
        return view('admin.sms.users_create');
    }
    public function usersStore(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'membership' => 'required',
            'group' => 'required',
            'msg' => 'required',
        ]);
        $sms=Sms::create($data);
        $membership=$request->membership;
        $group=$request->group;
        $users = User::$membership()->where(function ($q) use ($request,$group) {
            if ($group=='active') {
                $q->NotBlock();
            }
            if ($group=='not-active') {
                $q->Block();
            }
            
           
            if ($group=='pending_licens') {
                $q->PendingLicense();
            }
            if ($group=='active_licens') {
                $q->ActiveLicense();
            }
            if ($group=='no_licens') {
                $q->NoLicense();
            }
        })->get();
        foreach ($users as $user) {
            Oursms::send($user?->phone, $sms->msg);
        }
        return redirect()->route('admin.sms.index')->with('success', 'تم إرسال الرسالة بنجاح');
    }
    public function destroy(Sms $sms)
    {
        $sms->delete();
        return back()->with('success', 'تم حذف الرسالة بنجاح');
    }
}
