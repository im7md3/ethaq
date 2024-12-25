<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\UserNotify;
use App\Traits\JodaResource;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function admin()
    {
        $notifications = Notification::where(function ($q) {
            $q->whereRelation('user', 'type', 'admin');
            if (request('type')) {
                $q->where('type', request('type'));
            }
        })->latest('id')->paginate(10);
        return view('admin.notification.admin-notifications', compact('notifications'));
    }
    public function index()
    {
        $notifications = Notification::with(['user'])->where(function ($q) {
            $q->whereRelation('user', 'type', '!=', 'admin');
        })->latest('id')->paginate(10);
        return view('admin.notification.index', compact('notifications'));
    }
    public function create()
    {
        $user = null;
        if (request('user_id')) {
            $user = User::findOrFail(request('user_id'));
        }
        $alerts = Alert::get();

        return view('admin.notification.create', compact('user', 'alerts'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'notification' => 'required',
            'user_id' => 'required_if:id,selected'
        ]);
        if ($request->id == 0) {
            $users = User::get();
        } elseif ($request->id == 'client_individual') {
            $users = User::where('type', 'client')->where('membership', 'individual')->get();
        } elseif ($request->id == 'client_company') {
            $users = User::where('type', 'client')->where('membership', 'company')->get();
        } elseif ($request->id == 'vendor_individual') {
            $users = User::where('type', 'vendor')->where('membership', 'individual')->get();
        } elseif ($request->id == 'vendor_company') {
            $users = User::where('type', 'vendor')->where('membership', 'company')->get();
        } elseif ($request->id == 'selected') {
            $users = User::where('id', $request->user_id)->get();
        } else {
            $users = User::where('type', 'judger')->get();
        }

        $notification_data = [
            'type' => 'admin',
        ];

        foreach ($users as $user) {
            $user->message = $request->notification;
            // add this to send a notification
            Notification::send($user->id, $request->notification, null, null, $notification_data);
        }
        return redirect()->back()->withSuccess('تم ارسال الاشعارات بنجاح');
    }

    public function destroy($id)
    {
        Notification::where('id', $id)->delete();
        return redirect()->back()->withSuccess('تم حذف الاشعارات بنجاح');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->ids;

        if ($ids != null) {
            Notification::whereIn('id', $ids)->delete();

            return redirect()->back()->withSuccess('تم حذف الاشعارات بنجاح');
        } else {
            return redirect()->back()->withError('يجب تحديد صفوف أولاً');
        }
    }
    public function adminDeleteAll(Request $request)
    {
        Notification::where(function ($q) {
            $q->whereRelation('user', 'type', 'admin');
            if (request('type')) {
                $q->where('type', request('type'));
            }
        })->delete();
        return redirect()->back()->withSuccess('تم حذف الاشعارات بنجاح');
    }
    public function usersDeleteAll(Request $request)
    {
        Notification::with(['user'])->where(function ($q) {
            $q->whereRelation('user', 'type', '!=', 'admin');
        })->delete();
        return redirect()->back()->withSuccess('تم حذف الاشعارات بنجاح');
    }
}
