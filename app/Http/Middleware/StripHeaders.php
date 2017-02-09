<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class StripHeaders extends BaseVerifier
{
    /**
     * Strip X-Requested-With from the request because we're handling
     * all json output and don't want interference from Laravel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->headers->remove('X-Frame-Options');

        return $response;
    }
}
