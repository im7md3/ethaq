<?php

namespace App\Http\Controllers\Api\Front;

use App\Events\ChangeTimerConsulting;
use App\Http\Controllers\Controller;
use App\Models\Consulting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultingController extends Controller
{
    public function getTime($consulting_id)
    {
        $consulting = Consulting::find($consulting_id);
        if ($consulting) {
            $data = ['min' => $consulting->min, 'sec' => $consulting->sec];
            return responseApi(true, '', $data);
        } else {
            return responseApi(false, 'لا يوجد استشارة');
        }
    }
    public function setTime(Request $request, $consulting_id)
    {
        $consulting = Consulting::find($consulting_id);
        if ($consulting) {
            $consulting->update(['sec' => $request->sec, 'min' => $request->min]);
            event(new ChangeTimerConsulting($consulting_id));
            return responseApi(true, 'تم تحديث الوقت بنجاح');
        } else {
            return responseApi(false, 'لا يوجد استشارة');
        }
    }
    public function changeStatus(Request $request, $consulting_id)
    {
        $consulting = Consulting::find($consulting_id);
        if ($consulting) {
            $consulting->update(['status' => 'done']);
        } else {
            return responseApi(false, 'لا يوجد استشارة');
        }
    }

    public function updateCall($consulting_id)
    {
        $consulting = Consulting::find($consulting_id);
        if ($consulting) {
            $consulting->update(['finish_call' => 1]);
            return responseApi(true, 'تم تحديث المكالمة بنجاح');
        } else {
            return responseApi(false, 'لا يوجد استشارة');
        }
    }

    public function end(Request $request, $id)
    {
        $consulting = Consulting::find($id);

        if ($consulting) {
            $rules = ['status' => 'required'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return responseApi(false, $validator->errors()->first(), null, $validator->errors());
            }
            $consulting->update($request->all());
            return responseApi(true, 'تم إنهاء الاستشارة بنجاح');
        } else {
            return responseApi(false, 'لا يوجد استشارة');
        }
    }
    public function cancel(Request $request, Consulting $consulting)
    {
        $rules = ['status' => 'required'];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $consulting->update(['status' => 'cancel']);
        return responseApi(true, 'تم إلغاء الاستشارة بنجاح');
    }
}
