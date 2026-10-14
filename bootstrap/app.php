<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Alias middleware: admin, verifikasi status member, dan pengecekan role
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'approved.member' => \App\Http\Middleware\EnsureMemberIsApproved::class,
            'role' => \App\Http\Middleware\EnsureRole::class,
        ]);

        // Tamu yang membuka /akun diarahkan ke login anggota, selain itu ke login admin (Breeze).
        $middleware->redirectGuestsTo(
            fn (Request $request) => $request->is('akun*')
                ? route('member.login')
                : route('login')
        );

        // Yang sudah login dan membuka halaman tamu diarahkan sesuai role.
        $middleware->redirectUsersTo(
            fn () => auth()->user()?->role === 'admin'
                ? route('admin.dashboard')
                : route('member.dashboard')
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
