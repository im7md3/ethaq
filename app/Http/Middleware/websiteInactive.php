<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class websiteInactive
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
        if(!setting('website_active')){
            return response()->view('front.inactive');
        }
        return $next($request);
    }
}
