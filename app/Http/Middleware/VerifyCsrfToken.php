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
        "payu-money-payment-cancel", "payu-money-payment-success", 
        "ccavenue-handler", "ccavenue-cancel", "ccavenue-success",
        "do/login", 'checkCompanyCode'
    ];
}