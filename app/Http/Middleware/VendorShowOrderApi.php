<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;

class VendorShowOrderApi
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
        $route = route('api.' . auth()->user()->type . '.settings');
        $user = $request->user();        
        if ($order->status != 'open') {
            if ($order->vendor_id != $user->id) {
                return responseApi(false, 'غير مصرح لك بدخول الطلب ', ['url' => $route]);
            }
        }
        if ($user->checkUserActive()) {
            return $next($request);
        } elseif ($user->id == $order->vendor_id) {
            return $next($request);
        }
        if(auth()->check() and !auth()->user()->email){
            return redirect()->route(auth()->user()->type . '.settings')->with('warning', 'يرجى إدخال البريد الالكتروني');
            return responseApi(false, 'يرجى إدخال البريد الالكتروني ', ['url' => $route]);
            
        }
        return responseApi(false, 'لكي يتم تفعيل كل الخدمات يجيب رفع المستندات والبيانات المطلوبة ', ['url' => $route]);

    }
}
