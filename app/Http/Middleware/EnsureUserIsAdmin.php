<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Hanya mengizinkan user dengan is_admin = true.
 * Dipasang setelah middleware `auth`, alias: `is_admin`.
 */
class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->is_admin) {
            abort(403, 'Halaman ini khusus admin.');
        }

        return $next($request);
    }
}
