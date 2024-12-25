<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;

class VendorShowOrder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $order = Order::where('hash_code', $request->route()->parameters()['hash_code'])->first();
        $user = $request->user();        
        if ($order->status != 'open') {
            if ($order->vendor_id != $user->id) {
                abort(403);
            }
        }
        if ($user->checkUserActive()) {
            return $next($request);
        } elseif ($user->id == $order->vendor_id) {
            return $next($request);
        }
        if(auth()->check() and !auth()->user()->email){
            return redirect()->route(auth()->user()->type . '.settings')->with('warning', 'يرجى إدخال البريد الالكتروني');
        }
        return redirect()->route(auth()->user()->type . '.settings')->with('warning', 'لكي يتم تفعيل كل الخدمات يجيب رفع المستندات والبيانات المطلوبة');
    }
}
