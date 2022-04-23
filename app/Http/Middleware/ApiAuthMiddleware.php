<?php

namespace App\Http\Middleware;

use Closure;
use Examyou\RestAPI\Exceptions\ApiException;
use Illuminate\Http\Request;

class ApiAuthMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws ApiException
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth('api')->check()) {
            throw new ApiException('UNAUTHORIZED EXCEPTION', null, 401, 401);
        }

        return $next($request);
    }
}
