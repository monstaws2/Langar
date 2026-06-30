<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param   Request  $request
     * @param   Closure(Request): Response  $next
     * @return  Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->is_admin == 1) {
            return $next($request);
        }

        // User is not an admin, redirect to homepage with an error message in Farsi
        return redirect('/')->with('error', 'شما دسترسی ندارید');
    }
}
