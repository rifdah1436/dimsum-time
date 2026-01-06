<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\KasirController;

// ==============================================
// RUTE PUBLIK - BISA DIAKSES TANPA LOGIN
// ==============================================
Route::get('/', function () {
    return redirect()->route('home');
});

// Halaman utama yang bisa dilihat tanpa login
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');

// API untuk mendapatkan varian (untuk melihat menu)
Route::get('/menu/get-varian/{id}', [HomeController::class, 'getVarian'])->name('menu.get-varian');

// ==============================================
// RUTE AUTH (Login/Register) - Untuk guest
// ==============================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ==============================================
// RUTE YANG PERLU LOGIN
// ==============================================
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/password', [ProfileController::class, 'changePassword'])->name('profile.password');
        Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
        Route::delete('/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
    });
    
    
    // Update address route
    Route::post('/profile/update-address', [ProfileController::class, 'updateAddress'])->name('profile.update.address');
    
    // Cart Routes
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('keranjang');
        Route::post('/add', [CartController::class, 'add'])->name('cart.add');
        Route::get('/count', [CartController::class, 'getCartCount'])->name('cart.count');
        Route::post('/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear'); // TAMBAHKAN INI
    });
    
    
    // Checkout Routes
    Route::prefix('checkout')->group(function () {
        Route::get('/', [CartController::class, 'checkoutPage'])->name('checkout');
        Route::post('/process', [CartController::class, 'processCheckout'])->name('checkout.process'); 
    });
    
    // Routes untuk voucher
Route::middleware(['auth'])->group(function () {
    Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.apply.coupon');
    Route::post('/checkout/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('checkout.remove.coupon');
    Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
});
    
    // Pesanan Routes
    Route::prefix('pesanan')->group(function () {
        // GET routes
        Route::get('/', [PesananController::class, 'index'])->name('pesanan');
        Route::get('/{id}', [PesananController::class, 'show'])->name('pesanan.show');
        Route::get('/{id}/detail', [PesananController::class, 'detail'])->name('pesanan.detail');
        Route::get('/{id}/pembayaran', [PesananController::class, 'pembayaran'])->name('pesanan.pembayaran');
        Route::get('/{id}/upload-bukti', [PesananController::class, 'uploadBukti'])->name('pesanan.upload-bukti');
        
        // POST routes
        Route::post('/{id}/batal', [PesananController::class, 'batal'])->name('pesanan.batal');
        Route::post('/{id}/bayar', [PesananController::class, 'bayar'])->name('pesanan.bayar');
        Route::post('/{id}/selesai', [PesananController::class, 'selesai'])->name('pesanan.selesai');
        Route::post('/{id}/ulang', [PesananController::class, 'ulang'])->name('pesanan.ulang');
        // Route untuk upload bukti dari checkout (tanpa ID)
Route::post('/pesanan/simpan-bukti', [PesananController::class, 'simpanBuktiValidStatus'])->name('pesanan.simpan-bukti-checkout')->middleware('auth');
        Route::post('/{id}/simpan-bukti', [PesananController::class, 'simpanBuktiValidStatus'])->name('pesanan.simpan-bukti');
        
        // Alias routes
        Route::post('/{id}/cancel', [PesananController::class, 'cancel'])->name('pesanan.cancel');
        Route::post('/{id}/pesan-ulang', [PesananController::class, 'pesanUlang'])->name('pesanan.pesan-ulang');
    });
    
    // ==============================================
    // ADMIN ROUTES - Hanya untuk admin, pemilik, kasir
    // ==============================================
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard/data', [DashboardController::class, 'getDashboardData'])->name('dashboard.data');
        
        // Produk Management
        Route::prefix('produk')->name('produk.')->group(function () {
            Route::get('/', [DashboardController::class, 'produk'])->name('index');
            Route::get('/create', [DashboardController::class, 'createProduk'])->name('create');
            Route::post('/', [DashboardController::class, 'storeProduk'])->name('store');
            Route::get('/{id}/edit', [DashboardController::class, 'editProduk'])->name('edit');
            Route::put('/{id}', [DashboardController::class, 'updateProduk'])->name('update');
            Route::delete('/{id}', [DashboardController::class, 'destroyProduk'])->name('destroy');
            
            // Route untuk varian
            Route::prefix('{id_menu}/varian')->name('varian.')->group(function () {
                Route::get('/create', [DashboardController::class, 'createVarian'])->name('create');
                Route::post('/', [DashboardController::class, 'storeVarian'])->name('store');
                Route::get('/edit', [DashboardController::class, 'editVarian'])->name('edit');
                Route::post('/{id_varian}', [DashboardController::class, 'updateVarian'])->name('update');
                Route::delete('/{id_varian}', [DashboardController::class, 'destroyVarian'])->name('destroy');
                Route::post('/{id_varian}/stok', [DashboardController::class, 'updateStok'])->name('update-stok');
            });
            
            // Bulk update stok
            Route::post('/stok/bulk-update', [DashboardController::class, 'updateBulkStok'])->name('stok.bulk-update');
        });
        
        // Pesanan Management
        Route::prefix('pesanan')->name('pesanan.')->group(function () {
            Route::get('/', [DashboardController::class, 'pesanan'])->name('index');
            Route::get('/{id}', [DashboardController::class, 'detailPesanan'])->name('show');
            Route::post('/{id}/status', [DashboardController::class, 'updateStatusPesanan'])->name('update-status');
            Route::post('/{id}/batal', [DashboardController::class, 'batalPesanan'])->name('batal');
        });
        
        // Pelanggan Management
        Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
            Route::get('/', [DashboardController::class, 'pelanggan'])->name('index');
            Route::get('/{id}', [DashboardController::class, 'detailPelanggan'])->name('show');
            Route::post('/{id}/status', [DashboardController::class, 'updateStatusPelanggan'])->name('update-status');
        });
        
        // Laporan
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [DashboardController::class, 'laporan'])->name('index');
        });
    });
    
    // Redirect berdasarkan role setelah login
    Route::get('/redirect', function () {
        $user = auth()->user();
        
        if (in_array($user->peran, ['admin', 'pemilik', 'kasir'])) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('home');
        }
    })->name('redirect');
});
// Route untuk kurir
Route::prefix('kurir')->name('kurir.')->group(function () {
    Route::middleware(['auth', 'kurir'])->group(function () {
        // Dashboard kurir
        Route::get('/dashboard', [App\Http\Controllers\KurirController::class, 'dashboard'])->name('dashboard');
        
        // Get detail pesanan untuk modal
        Route::get('/order/{id}/detail', [App\Http\Controllers\KurirController::class, 'getOrderDetail'])->name('order.detail');
        
        // Selesaikan pengiriman
        Route::post('/order/{id}/complete', [App\Http\Controllers\KurirController::class, 'completeDelivery'])->name('order.complete');
        
        // Riwayat pengiriman
        Route::get('/history', [App\Http\Controllers\KurirController::class, 'history'])->name('history');
    });
});
// ==============================================
// OWNER ROUTE (Logika Satpam Langsung Disini)
// ==============================================
// routes/web.php

// Kita hanya pasang 'auth' di sini. Pengecekan 'owner/pemilik' kita pindah ke Controller.
Route::prefix('owner')->middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\OwnerDashboardController::class, 'index'])
        ->name('owner.dashboard');
    });
    // ROUTE CRUD PEGAWAI OWNER
Route::prefix('owner/pegawai')->name('owner.pegawai.')->group(function () {
Route::get('/create', [OwnerPegawaiController::class, 'create'])->name('create');
Route::post('/store', [OwnerPegawaiController::class, 'store'])->name('store');
Route::get('/edit/{id}', [OwnerPegawaiController::class, 'edit'])->name('edit');
Route::put('/update/{id}', [OwnerPegawaiController::class, 'update'])->name('update');
Route::delete('/delete/{id}', [OwnerPegawaiController::class, 'destroy'])->name('destroy');
});
/// Route untuk kasir
Route::prefix('kasir')->name('kasir.')->group(function () {
    Route::middleware(['auth', 'kasir'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [KasirController::class, 'dashboard'])->name('dashboard');
        
        // Order Management
        Route::get('/order/{id}/detail', [KasirController::class, 'getOrderDetail'])->name('order.detail');
        Route::post('/order/{id}/status', [KasirController::class, 'updateOrderStatus'])->name('order.status');
        Route::get('/orders/status/{status}', [KasirController::class, 'viewOrdersByStatus'])->name('orders.by_status');
        
        // Payment Management
        Route::get('/payment/{id}/detail', [KasirController::class, 'getPaymentDetail'])->name('payment.detail');
        Route::post('/payment/{id}/update', [KasirController::class, 'updatePayment'])->name('payment.update');
        Route::post('/payment/{id}/cash', [KasirController::class, 'processCashPayment'])->name('payment.cash');
        
        // Print Invoice
        Route::get('/invoice/{id}/print', [KasirController::class, 'printInvoice'])->name('invoice.print');
        
        // Reports
        Route::get('/report/daily', [KasirController::class, 'dailyReport'])->name('report.daily');
        
        // Menu (Read-Only)
        Route::get('/menu', [KasirController::class, 'viewMenu'])->name('menu.index');
        Route::get('/menu/{id}', [KasirController::class, 'viewMenuDetail'])->name('menu.detail');
        
        // Stock Report (Read-Only)
        Route::get('/stock', [KasirController::class, 'viewStockReport'])->name('stock.index');
    });
});