<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (!in_array(auth()->user()->role, ['administrator', 'admin'])) {
            abort(403, 'Unauthorized. Hanya admin yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
