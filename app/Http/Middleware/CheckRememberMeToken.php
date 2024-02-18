<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRememberMeToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

        // Check if the user is not authenticated and has a "Remember Me" cookie
        if (!Auth::check() && $request->hasCookie('remember_web_')) {
            // Redirect to the dashboard or the desired route
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
