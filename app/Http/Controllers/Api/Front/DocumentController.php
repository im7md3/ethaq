<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\AdvisorFile;
use App\Models\Commercial;
use App\Models\License;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    /* public function documents()
    {
        $user = auth()->user()->load(['license', 'commercial']);
        return view('front.documents', compact('user'));
    } */
    public function license(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:10',
            'license' => 'required',
            'end_at' => 'required',
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $user = auth()->user();
        $user->license()->delete();
        License::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'end_at' => $request->end_at,
            'file' => store_file($request->license, 'licenses'),
        ]);
        return responseApi(true, 'تم رفع العضوية بنجاح');
    }
    public function commercial(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'commercial' => 'required',
            'end_at' => 'required',
        ]);
        $user = auth()->user();
        $data['user_id'] = $user->id;
        $user->commercial()->delete();
        $data['file'] = store_file($request->commercial, 'commercials');
        Commercial::create($data);
        return response()->json(['status' => true, 'message' => "تم رفع السجل بنجاح"]);
    }

    public function companyInfo(Request $request)
    {
        $data = $request->validate([
            'file' => 'required',
            'company_name' => 'required',
            'company_number' => 'required',
        ]);
        $data['contract'] = store_file($request->file, 'company-contracts');
        $user = auth()->user();
        $user->update($data);
        return response()->json(['status' => true, 'message' => "تم رفع العقد بنجاح"]);
    }

    public function advisorFiles(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'attach' => 'required',
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $user = auth('sanctum')->user();
        $user->advisorFile()->delete();
        $request->merge(['file' => store_file($request->attach, 'advisorFiles'), 'status' => 'pending']);
        AdvisorFile::create($request->all());
        return responseApi(true, 'تم رفع العضوية بنجاح');
    }
}
