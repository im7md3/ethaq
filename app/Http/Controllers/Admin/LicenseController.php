<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\JodaResource;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    use JodaResource;

    protected $rules = [
        'name' => 'nullable|string',
        'file' => 'nullable|string',
        'user_id' => 'nullable|integer',
        'end_at' => 'nullable|date',
        'status' => 'nullable|string',
        'refused_msg' => 'required_if:status,refused|string',
    ];

    public function query($query){
        return $query->paginate(10);
    }
    public function afterUpdate ($user)
    {
            return back()->with('success','تم التعديل بنجاح');
    }
    public function beforeDestroy ($license)
    {
            delete_file($license->file);
    }
    public function afterDestroy ()
    {
            return back()->with('success','تم الحذف بنجاح');
    }
}
