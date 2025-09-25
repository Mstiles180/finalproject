<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        if ($user->is_suspended ?? false) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your account is suspended.');
        }

        return $next($request);
    }
}


