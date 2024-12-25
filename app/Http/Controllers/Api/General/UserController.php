<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($id_number)
    {
        $user = User::where('id_number', $id_number)->where('type', '!=', 'admin')->first(['name', 'type', 'gender', 'id_number', 'id_end', 'phone', 'email', 'address']);
        if ($user) {
            $msg = 'User Data Retrived Successfully';
            $data = $user->setAppends([]);
        } else {
            $msg = 'User Not Found';
            $data = null;
        }
        return response()->json(['status' => 200, 'message' => $msg, 'data' => $data]);
    }

    public function client($id_number)
    {
        $user = User::where('id_number', $id_number)->where('type', 'client')->first(['name', 'type', 'gender', 'id_number', 'id_end', 'phone', 'email', 'address']);
        if ($user) {
            $msg = 'Client Data Retrived Successfully';
            $data = $user->setAppends([]);
        } else {
            $msg = 'Client Not Found';
            $data = null;
        }
        return response()->json(['status' => 200, 'message' => $msg, 'data' => $data]);
    }

    public function vendor($id_number)
    {
        $user = User::where('id_number', $id_number)->where('type', 'vendor')->first(['name', 'type', 'gender', 'id_number', 'id_end', 'phone', 'email', 'address']);
        if ($user) {
            $msg = 'Vendor Data Retrived Successfully';
            $data = $user->setAppends([]);
        } else {
            $msg = 'Vendor Not Found';
            $data = null;
        }
        return response()->json(['status' => 200, 'message' => $msg, 'data' => $data]);
    }
    public function judger($id_number)
    {
        $user = User::where('id_number', $id_number)->where('type', 'judger')->first(['name', 'type', 'gender', 'id_number', 'id_end', 'phone', 'email', 'address']);
        if ($user) {
            $msg = 'Judger Data Retrived Successfully';
            $data = $user->setAppends([]);
        } else {
            $msg = 'Judger Not Found';
            $data = null;
        }
        return response()->json(['status' => 200, 'message' => $msg, 'data' => $data]);
    }
    public function clientSearch(Request $request){
        $clients=User::clients()->where('phone','LIKE','%'.request('name').'%')->select('id','name')->get();
        return response()->json(['status' => 200, 'data' => $clients]);
    }
    public function vendorSearch(Request $request){
        $vendors=User::AllVendors()->where('phone','LIKE','%'.request('name').'%')->select('id','name')->get();
        return response()->json(['status' => 200, 'data' => $vendors]);
    }
}
