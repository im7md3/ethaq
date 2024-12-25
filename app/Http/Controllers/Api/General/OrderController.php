<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::when(request()->status, function ($q) {
            $q->where('status', request()->status);
        })->get(['id', 'hash_code', 'title', 'details', 'status', 'encrypted', 'created_at']);

        return response()->json(['status' => 200, 'message' => 'Data Retrieved Successfully', 'data' => $orders]);
    }
}
