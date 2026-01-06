<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Keranjang;

class SyncCartMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Hanya untuk user yang login
        if (auth()->check()) {
            // Ambil cart dari database
            $dbCart = Keranjang::where('id_pengguna', auth()->id())->get();
            
            // Ambil cart dari session
            $sessionCart = session('cart', []);
            
            // Jika ada perbedaan, sync
            if (!empty($dbCart) && empty($sessionCart)) {
                // Load dari database ke session
                $cartArray = [];
                foreach ($dbCart as $item) {
                    $cartArray[$item->id_menu] = [
                        'menu_id' => $item->id_menu,
                        'nama_menu' => $item->menu->nama_menu,
                        'harga' => $item->menu->harga,
                        'quantity' => $item->jumlah,
                        'gambar' => $item->menu->gambar,
                    ];
                }
                session()->put('cart', $cartArray);
            }
        }
        
        return $next($request);
    }
}