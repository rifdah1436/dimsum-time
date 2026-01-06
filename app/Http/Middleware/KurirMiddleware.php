<?php
// app/Http/Middleware/KurirMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KurirMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Cek apakah user memiliki role kurir
        // Sesuaikan dengan cara Anda mengecek role
        // Contoh: jika ada kolom 'role' di tabel users
        if (Auth::user()->peran !== 'kurir') {
            return redirect()->route('home')->with('error', 'Akses ditolak!');
        }

        return $next($request);
    }
}