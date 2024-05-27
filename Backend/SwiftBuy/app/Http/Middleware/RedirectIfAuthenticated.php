<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check() && $guard == 'admin') {
                return ApiResponse::sendResponse(200,'Already authenticated');
            }
            if (Auth::guard($guard)->check()) {
                return ApiResponse::sendResponse(200,'Already authenticated');
            }
        }

        return $next($request);
    }
}
