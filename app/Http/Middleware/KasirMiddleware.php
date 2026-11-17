<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KasirMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->guest(route('login'));
        }

        if (!auth()->user()->canAccessKasir()) {
            abort(403, 'Akses ditolak. Halaman Kasir POS hanya untuk Karyawan (Kasir) dan Administrator NOIR COFFEE.');
        }

        return $next($request);
    }
}
