<?php

namespace App\Http\Middleware;

use App\Models\User;
use Auth;
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
        $user = request()->user();

        if (!$user || $user->is_admin == User::NOT_ADMIN) {

            if ($request->ajax()) {
                return sendResponse(false, 'Unauthorized access', null, Response::HTTP_UNAUTHORIZED);
            }

            if ($request->is('api/*')) {
                return sendResponse(false, 'Unauthorized access', null, Response::HTTP_UNAUTHORIZED);

            }

            if (!$request->expectsJson()) {
                return redirect()->route('home')->with('error', 'Unauthorized access');
            }
        }

        // Jodi admin na hoy, home page e redirect korbe
        return $next($request);
    }
}

