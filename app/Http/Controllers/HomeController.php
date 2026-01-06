<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\KategoriMenu;
use App\Models\Keranjang;
use App\Models\VarianMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Jika ingin bypass login untuk testing, gunakan ini:
        // return view('auth.login'); 
        
        // Atau jika ingin menampilkan home, pastikan user sudah login
        if (!Auth::check()) {
            // TAMPILKAN HOME TANPA LOGIN - HANYA TAMPILKAN TANPA SYNC CART
            $menu_populer = Menu::with(['variants' => function($query) {
                $query->where('stok', '>', 0);
            }])
            ->where('status_tersedia', true)
            ->limit(6)
            ->get();

            return view('home', compact('menu_populer'));
        }

        // Sync cart sebelum menampilkan view
        $this->syncCartFromDatabase();

        $menu_populer = Menu::with(['variants' => function($query) {
            $query->where('stok', '>', 0);
        }])
        ->where('status_tersedia', true)
        ->limit(6)
        ->get();

        return view('home', compact('menu_populer'));
    }

    public function menu()
    {
        // Sync cart hanya jika sudah login - TAMBAHKAN KONDISI INI
        if (Auth::check()) {
            $this->syncCartFromDatabase();
        }
        
        $kategori = KategoriMenu::with(['menu' => function($query) {
            $query->where('status_tersedia', true);
        }, 'menu.variants' => function($query) {
            $query->where('stok', '>', 0);
        }])->orderBy('urutan')->get();
        
        return view('menu', compact('kategori'));
    }

    public function getVarian($id)
    {
        try {
            $varian = VarianMenu::where('id_menu', $id)
                ->get()
                ->map(function($item) {
                    return [
                        'id_varian' => $item->id_varian,
                        'ukuran' => $item->ukuran,
                        'jumlah_pcs' => $item->jumlah_pcs,
                        'harga' => (float) $item->harga,
                        'stok' => $item->stok
                    ];
                });
                
            return response()->json($varian);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data'], 500);
        }
    }

    public function tentang()
    {
        // Sync cart hanya jika sudah login - TAMBAHKAN KONDISI INI
        if (Auth::check()) {
            $this->syncCartFromDatabase();
        }
        
        return view('tentang');
    }

    public function kontak()
    {
        // Sync cart hanya jika sudah login - TAMBAHKAN KONDISI INI
        if (Auth::check()) {
            $this->syncCartFromDatabase();
        }
        
        return view('kontak');
    }

    public function keranjang()
    {
        return view('keranjang');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    /**
     * Sync cart dari database ke session
     * Method ini yang Anda panggil tapi belum ada
     */
    private function syncCartFromDatabase()
    {
        // Hanya sync jika user sudah login
        if (!Auth::check()) {
            return;
        }

        $userId = Auth::user()->id_pengguna;
        
        // Ambil cart dari database
        $dbCart = Keranjang::where('id_pengguna', $userId)
            ->with('menu')
            ->get();
        
        // Ambil cart dari session
        $sessionCart = session('cart', []);
        
        // Jika database ada data tapi session kosong, sync dari database
        if ($dbCart->count() > 0 && empty($sessionCart)) {
            $newSessionCart = [];
            
            foreach ($dbCart as $item) {
                $key = $item->menu_id;
                $newSessionCart[$key] = [
                    'menu_id' => $item->menu_id,
                    'nama_menu' => $item->menu->nama_menu,
                    'harga' => $item->menu->harga,
                    'quantity' => $item->jumlah,
                    'gambar' => $item->menu->gambar,
                    'subtotal' => $item->subtotal
                ];
            }
            
            session()->put('cart', $newSessionCart);
            \Log::info('Cart synced from database to session for user: ' . $userId);
        }
        // Jika session ada tapi database kosong, sync ke database
        elseif (!empty($sessionCart) && $dbCart->count() == 0) {
            foreach ($sessionCart as $key => $item) {
                Keranjang::updateOrCreate(
                    [
                        'id_pengguna' => $userId,
                        'id_menu' => $item['menu_id'] ?? $key
                    ],
                    [
                        'jumlah' => $item['quantity'] ?? $item['jumlah'] ?? 1,
                        'subtotal' => $item['subtotal'] ?? ($item['harga'] * ($item['quantity'] ?? $item['jumlah'] ?? 1))
                    ]
                );
            }
            \Log::info('Cart synced from session to database for user: ' . $userId);
        }
        
        // Log untuk debugging
        \Log::info('Cart sync completed. Session count: ' . count(session('cart', [])) . ', DB count: ' . $dbCart->count());
    }
}