<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\JodaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function activeRequests()
    {
        $vendors = User::whereHas('license', function ($q) {
            $q->where('status', 'pending');
        })->orWhereHas('commercial', function ($q) {
            $q->where('status', 'pending');
        })->paginate(10);
        $advisors = User::whereHas('advisorFile', function ($q) {
            $q->where('status', 'pending');
        })->paginate(10);
        return view('admin.user.active-requests', compact('vendors','advisors'));
    }

    public function block($id, Request $request)
    {
        $user = User::findOrFail($id);
        if ($request->has('is_block')) {
            $user->update(['is_block' => 1]);
            return redirect()->back()->with('success', 'تم إيقاف العضو بنجاح');
        } else {
            $user->update(['is_block' => 0]);
            return redirect()->back()->with('success', 'تم إلغاء إيقاف العضو بنجاح');
        }
    }

    public function deletedUsers(){
        $users=User::whereNotNull('delete_date')->where(function($q){
            if(request('search')){
                $q->where('name',"LIKE","%".request('search')."%")->orWhere('phone',request('search'));
            }
        })->paginate();
        return view('admin.user.deleted-users',compact('users'));
    }
    public function returnUser(Request $request,User $user){
        $user->update(['delete_date'=>null]);
        return back()->with('success','تم استعادة العضو بنجاح');
    }
}
