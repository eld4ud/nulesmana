<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMemberIsApproved
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user login sebagai member tapi statusnya belum approved
        if ($request->user() && $request->user()->role === 'member' && $request->user()->status !== 'approved') {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda masih dalam status pending atau belum disetujui admin.',
            ]);
        }

        return $next($request);
    }
}