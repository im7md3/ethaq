<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
            ->as('api.front.')
                ->prefix('api')
                ->group(base_path('routes/api-front.php'));
            Route::middleware('api', 'websiteInactive', 'client','user_is_block_api')
                ->as('api.client.')
                ->prefix('api/client')
                ->group(base_path('routes/api-client.php'));
            Route::middleware('api', 'websiteInactive', 'vendor','user_is_block_api')
            ->as('api.vendor.')
                ->prefix('api/vendor')
                ->group(base_path('routes/api-vendor.php'));
            Route::middleware('api', 'websiteInactive', 'judger')
                ->prefix('api/judger')
                ->group(base_path('routes/api-judger.php'));
            Route::middleware('api')
                ->prefix('api/general')
                ->group(base_path('routes/api-general.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->as('admin.')
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web', 'websiteInactive', 'client','user_is_block')
                ->as('client.')
                ->prefix('clients')
                ->group(base_path('routes/clients.php'));

            Route::middleware('web', 'websiteInactive', 'vendor','user_is_block')
                ->as('vendor.')
                ->prefix('vendors')
                ->group(base_path('routes/vendors.php'));

            Route::middleware('web', 'websiteInactive', 'judger','user_is_block')
                ->as('judger.')
                ->prefix('judgers')
                ->group(base_path('routes/judgers.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
