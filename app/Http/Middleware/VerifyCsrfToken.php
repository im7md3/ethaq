<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'register/membership',
        'clickpay-callback',
        'register/sms',
        'createUser',
        'tamam/status_callback',
        'tamam/po_callback'
    ];
}
