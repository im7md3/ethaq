<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\JodaResource;
use Illuminate\Http\Request;

class CommercialController extends Controller
{
    use JodaResource;
    protected $rules = [
        'name' => 'nullable|string',
        'file' => 'nullable|string',
        'user_id' => 'nullable|integer',
        'end_at' => 'nullable|date',
        'status' => 'required|string',
        'refused_msg' => 'required_if:status,refused|string',
    ];

    public function query($query){
        return $query->paginate(10);
    }

    public function afterUpdate ($commercial)
    {
            return back()->with('success','تم التعديل بنجاح');
    }
    public function beforeDestroy ($commercial)
    {
            delete_file($commercial->file);
    }
    public function afterDestroy ()
    {
            return back()->with('success','تم الحذف بنجاح');
    }
}
