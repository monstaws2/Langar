<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and is admin
        if (!$request->user() || !$request->user()->isAdmin()) {
            // Redirect non-admins to home with error message
            return redirect()->route('home')->with('error', 'You do not have permission to access the admin panel.');
        }

        return $next($request);
    }
}