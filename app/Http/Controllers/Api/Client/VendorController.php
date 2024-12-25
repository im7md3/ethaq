<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Department;
use App\Models\SetTime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function search(Request $request)
    {
        $vendors = User::with(['occupation', 'license', 'city'])->where('type','vendor')->where(function ($q) use ($request) {
            if ($request->name and $request->name != "") {
                $q->where('name', 'LIKE', '%' . $request->name . '%');
            }
            if (request('department_id')) {
                $q->whereRelation('departments', function ($dep) {
                    $dep->where('departments.id', request('department_id'));
                });
            }
            if (request('consulting_department_id')) {
                $q->whereRelation('consultingDepartments', function ($dep) {
                    $dep->where('departments.id', request('consulting_department_id'));
                });
            }
            if ($request->cons) {
                $q->where(function ($q) use ($request) {
                    $q->where('consulting_price', '>', 0);
                });
            }
        })->ActiveLicense()->get();
        return $vendors;
    }
    public function more(Request $request)
    {
        $ids = $request->ids ?? [];
        $vendors = User::with(['occupation', 'license', 'city'])->where('type','vendor')->ActiveLicense()->whereNotIn('id', $ids)->inRandomOrder()->take(5)->get();
        return $vendors;
    }

    // get all vendors 
    public function vendors()
    {
        $vendors = User::where('type','vendor')->with(['mainDepartment'])->where(function ($q) {
            if (request('name')) {
                $q->where('name', 'LIKE', '%' . request('name') . '%');
            }
            if (request('department')) {
                $q->whereRelation('departments', function ($d) {
                    $d->where('id', request('department'));
                });
            }
            if (request('online')) {
                $q->where('last_seen', '>=', Carbon::now()->subMinutes(5));
            }
        })->ActiveLicense()->latest('id')->paginate();


        $data = ['vendors' => $vendors];

        return responseApi(true, '', $data);
    }

    public function vendorShow(Request $request)
    {
        $user = User::with(['occupation', 'specialty', 'qualification', 'license', 'mainDepartment'])->withCount(['vendorOrders', 'consultingVendor'])->findOrFail($request->id);
        $times = SetTime::where('user_id', $user->id)->get();
        $departments = $user->departments()->pluck('departments.name');
        return responseApi(true, '', ['vendor' => $user, 'departments' => $departments, 'times' => $times]);
    }
}
