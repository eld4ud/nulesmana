<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika belum login atau rolenya bukan admin, tendang keluar
        if (!$request->user() || $request->user()->role !== 'admin') {
            abort(403, 'Unauthorized action. Area ini khusus Admin.');
        }

        return $next($request);
    }
}