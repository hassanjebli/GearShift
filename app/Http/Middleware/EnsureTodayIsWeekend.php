<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTodayIsWeekend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get what week day it is today
        $dayOfWeek = now()->dayOfWeek;

        // Check if today is Saturday or Sunday we call $next()
        if ($dayOfWeek === 6 || $dayOfWeek === 0) {
            return $next($request);
        }

        // Otherwise we restrict access
        abort(403, 'The website can only be accessed on weekends');
    }
}
