<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request by role.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            // Preserve intended URL for web users so Laravel can redirect after login
            return redirect()->guest(route('login'));
        }

        // Normalize roles and user role to be case-insensitive
        $allowedRoles = array_map('strtolower', $roles);
        $userRole = strtolower($request->user()->role ?? '');

        if (!in_array($userRole, $allowedRoles, true)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'You do not have permission.'], 403);
            }

            // Prefer redirecting back with a user-friendly flash message for web requests.
            // If no referer is available, send the user to the home page.
            $redirect = redirect()->back();
            if (!$request->headers->has('referer')) {
                $redirect = redirect()->route('home');
            }

            return $redirect->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
