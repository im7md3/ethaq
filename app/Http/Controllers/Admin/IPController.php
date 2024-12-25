<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ip;
use Illuminate\Http\Request;

class IPController extends Controller
{
    public function index()
    {
        $title='';
        if(request('type')){
            if(request('type')=='visitor'){
                $title='الزوار';
            }else{
                $title='نفاذ';
            }
        }
        $ips=Ip::where(function($q){
            if(request('type')){
                $q->where('type',request('type'));
            }
        })->latest('id')->paginate(10);
        return view('admin.IP.index',compact('ips','title'));
    }
    public function destroy($id)
    {
        $ip=Ip::findOrFail($id);
        $ip->delete();
        return back()->with('success','تم حذف السجل بنجاح');
    }
    public function destroyAll(Request $request)
    {
        $ips=Ip::where('type',$request->type)->get();
        $ips->map->delete();
        return back()->with('success','تم حذف السجلات بنجاح');
    }
}
