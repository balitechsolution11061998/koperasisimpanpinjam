<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permission
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            dd("masuk sini");
            return response()->json(['error' => 'Unauthorized'], 403);
        }   
        // Check if the authenticated user has the required permission
        if (!auth()->user()->hasPermission($permission)) {
            // Optionally, you can redirect or return a response
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
