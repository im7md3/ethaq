<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIsActive
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
        if (auth()->check() and auth()->user()->checkUserActive()) {
            return $next($request);
        }
        $route = route(auth()->user()->type . '.settings');
        if (auth()->check() and !auth()->user()->email) {
            return redirect()->route(auth()->user()->type . '.settings')->with('warning', 'يرجى إدخال البريد الالكتروني');
        }
        if (auth()->check() and auth()->user()->type == 'vendor') {
            $user = auth()->user();
            if (!$user->license) {
                return redirect()->route(auth()->user()->type . '.settings')->with('warning', 'يرجى ارفاق الرخصة');
            } elseif ($user->license and !$user->HasAcceptedLicense) {
                return redirect()->route(auth()->user()->type . '.settings')->with('warning', 'يرجى انتظار الموافقة على الرخصة');
            } elseif (is_null($user->getRawOriginal('photo'))) {
                return redirect()->route(auth()->user()->type . '.settings')->with('warning', 'يرجى ارفاق الصورة الشخصية');
            } elseif ($user->consultingDepartments()->count() == 0) {
                return redirect()->route(auth()->user()->type . '.settings')->with('warning', 'يرجى تحديد أقسام الاستشارة');
            } elseif ($user->consulting_price==0 || !$user->consulting_price) {
                return redirect()->route(auth()->user()->type . '.settings')->with('warning', 'يرجى تحديد سعر الاستشارة');
            } elseif ($user->departments()->count() == 0) {
                return redirect()->route(auth()->user()->type . '.settings')->with('warning', 'يرجى تحديد أقسام تقديم خدمات المحاماة');
            }
        }

        return redirect()->route(auth()->user()->type . '.settings')->with('warning', 'لكي يتم تفعيل كل الخدمات يجيب رفع المستندات والبيانات المطلوبة');
    }
}
