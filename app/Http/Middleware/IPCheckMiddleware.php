<?php

namespace App\Http\Middleware;

use Closure;

class IPCheckMiddleware
{

    public function handle($request, Closure $next)
    {
        if ($request->ip() != "127.0.0.1") {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }

}