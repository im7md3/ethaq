<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\Consulting;
use Illuminate\Http\Request;

class ConsultingController extends Controller
{
    public function index()
    {
        $consultings = Consulting::with(['client','department'])->whereNull('vendor_id')->where('status','pending')->get();
        return response()->json(['status' => 200, 'message' => 'Data Retrieved Successfully', 'data' => $consultings->each->setAppends([])]);
    }
}
