<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commercial;
use App\Models\License;
use App\Models\User;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    
    public function license(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'license' => 'required',
            'end_at' => 'required',
        ]);
        $user = User::findOrFail($request->user_id);
        $user->license()->delete();
        $data['file'] = store_file($request->license, 'licenses');
        License::create($data);
        return back()->with('success', 'تم رفع الرخصة بنجاح');
    }
    public function licenseUpdate(Request $request,License $license)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'license_file' => 'nullable',
            'end_at' => 'required',
        ]);
        if($request->license_file){
            delete_file($license->file);
            $data['file']=store_file($request->license_file,'licenses');
        }else{
            $data['file']=$license->file;
        }
        $license->update($data);
        return back()->with('success', 'تم تعديل الرخصة بنجاح');
    }
    public function commercial(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'commercial' => 'required',
            'end_at' => 'required',
        ]);
        $user = User::findOrFail($request->user_id);
        $user->commercial()->delete();
        $data['file'] = store_file($request->commercial, 'commercials');
        Commercial::create($data);
        return back()->with('success', 'تم رفع السجل بنجاح');
    }

    public function companyInfo(Request $request){
        $data=$request->validate([
            'file'=>'required',
            'company_name'=>'required',
            'company_number'=>'required',
        ]);
        $data['contract']=store_file($request->file,'company-contracts');
        $user=User::findOrFail($request->user_id);
        $user->update($data);
        return back()->with('success','تم رفع العقد بنجاح');
    }
}
