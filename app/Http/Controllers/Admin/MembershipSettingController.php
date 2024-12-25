<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MembershipSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\UserType  $userType
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user-types.index');
    }

}
