<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIsActiveApi
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
        $route = route('api.' . auth()->user()->type . '.settings');
        if (auth()->check() and auth()->user()->type == 'vendor') {
            $user = auth('sanctum')->user();
            if ($user->is_advisor) {
                if (!$user->advisorFile) {
                    return responseApi(false, 'يرجى ارفاق المؤهل ', ['url' => $route]);
                }
                if ($user->advisorFile and !$user->HasAcceptedAdvisorFile) {
                    return responseApi(false, 'يرجى انتظار الموافقة على المؤهل ', ['url' => $route]);
                }
            } else {
                if (!$user->license) {
                    return responseApi(false, 'يرجى ارفاق الرخصة ', ['url' => $route]);
                }
                if ($user->license and !$user->HasAcceptedLicense) {
                    return responseApi(false, 'يرجى انتظار الموافقة على الرخصة ', ['url' => $route]);
                }
            }
            if (is_null($user->getRawOriginal('photo'))) {
                return responseApi(false, 'يرجى ارفاق الصورة الشخصية ', ['url' => $route]);
            } elseif (!$user->email) {
                return responseApi(false, 'يرجى إدخال البريد الإلكتروني', ['url' => $route]);
            } elseif ($user->consultingDepartments()->count() == 0) {
                return responseApi(false, 'يرجى تحديد أقسام الاستشارة', ['url' => $route]);
            } elseif ($user->consulting_request == 0 || !$user->consulting_request) {
                return responseApi(false, 'يرجى تحديد سعر الاستشارة', ['url' => $route]);
            } elseif ($user->departments()->count() == 0) {
                return responseApi(false, 'يرجى تحديد أقسام تقديم خدمات المحاماة', ['url' => $route]);
            }
        }
        return responseApi(false, 'لكي يتم تفعيل كل الخدمات يجيب رفع المستندات والبيانات المطلوبة', ['url' => $route]);
    }
}
