<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\SpecialService;
use App\Models\SpecialServiceMessage;
use Illuminate\Http\Request;

class SpecialServiceController extends Controller
{
    public function index()
    {
        $services = SpecialService::latest()->paginate();
        return view('admin.special_services.index', compact('services'));
    }
    public function show(SpecialService $specialService)
    {
        $specialService->load(['client', 'files', 'voices', 'messages.user', 'messages.files']);
        return view('admin.special_services.show', compact('specialService'));
    }
    public function storeMessage(Request $request, SpecialService $specialService)
    {
        $data = $request->validate([
            'content' => 'required_without:images',
            'images' => 'required_without:content',
        ]);
        if ($specialService->status == 'pending') {
            $specialService->update(['status' => 'active']);
        }
        $data['user_id'] = auth()->id();
        $data['service_id'] = $specialService->id;
        $msg = SpecialServiceMessage::create($data);
        if (request('images')) {
            foreach (request('images') as $image) {
                Attachment::store($image, $msg);
            }
        }
        return back()->with('success', 'تم إرسال الرسالة بنجاح');
    }

    public function destroy(SpecialService $specialService)
    {
        $specialService->delete();

        return back()->with('success', 'تم حذف الخدمة بنجاح');

    }
}
