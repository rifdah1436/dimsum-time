<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Table Pengguna
        if (!Schema::hasTable('pengguna')) {
            Schema::create('pengguna', function (Blueprint $table) {
                $table->id('id_pengguna');
                $table->string('username', 50)->unique();
                $table->string('email', 100)->unique();
                $table->string('password');
                $table->string('nama_lengkap', 100);
                $table->string('nomor_telepon', 15)->nullable();
                $table->text('alamat')->nullable();
                $table->enum('peran', ['admin', 'pelanggan', 'pemilik', 'kurir', 'kasir'])->default('pelanggan');
                $table->string('foto_profil')->nullable();
                $table->boolean('status_aktif')->default(true);
                $table->timestamps();
            });
        }

        // 2. Table Kategori Menu
        if (!Schema::hasTable('kategori_menu')) {
            Schema::create('kategori_menu', function (Blueprint $table) {
                $table->id('id_kategori');
                $table->string('nama_kategori', 50);
                $table->text('deskripsi')->nullable();
                $table->string('icon', 100)->nullable();
                $table->tinyInteger('urutan')->default(1);
                $table->timestamps();
            });
        }

        // 3. Table Menu
        if (!Schema::hasTable('menu')) {
            Schema::create('menu', function (Blueprint $table) {
                $table->id('id_menu');
                $table->foreignId('id_kategori')->constrained('kategori_menu', 'id_kategori')->onDelete('cascade');
                $table->string('nama_menu', 100);
                $table->text('deskripsi')->nullable();
                $table->string('gambar')->nullable();
                $table->boolean('status_tersedia')->default(true);
                $table->timestamps();
            });
        }

        // 4. Table Varian Menu
        if (!Schema::hasTable('varian_menu')) {
            Schema::create('varian_menu', function (Blueprint $table) {
                $table->id('id_varian');
                $table->foreignId('id_menu')->constrained('menu', 'id_menu')->onDelete('cascade');
                $table->enum('ukuran', ['S', 'M', 'L', 'XL', 'Reguler'])->default('Reguler');
                $table->integer('jumlah_pcs');
                $table->decimal('harga', 10, 2);
                $table->integer('stok')->default(0);
                $table->integer('stok_minimum')->default(10);
                $table->timestamps();
                
                $table->unique(['id_menu', 'ukuran']);
            });
        }

        // 5. Table Keranjang
        if (!Schema::hasTable('keranjang')) {
            Schema::create('keranjang', function (Blueprint $table) {
                $table->id('id_keranjang');
                $table->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna')->onDelete('cascade');
                $table->foreignId('id_varian')->constrained('varian_menu', 'id_varian')->onDelete('cascade');
                $table->integer('jumlah')->default(1);
                $table->text('catatan')->nullable();
                $table->timestamps();
            });
        }

        // 6. Table Pesanan
        if (!Schema::hasTable('pesanan')) {
            Schema::create('pesanan', function (Blueprint $table) {
                $table->id('id_pesanan');
                $table->string('nomor_pesanan', 20)->unique();
                $table->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna')->onDelete('cascade');
                $table->timestamp('tanggal_pesanan')->useCurrent();
                $table->string('nama_penerima', 100);
                $table->text('alamat_pengiriman');
                $table->string('nomor_telepon', 15);
                $table->enum('jenis_pengiriman', ['delivery', 'pickup'])->default('delivery');
                $table->timestamp('tanggal_pengiriman')->nullable();
                $table->text('catatan_pelanggan')->nullable();
                $table->enum('status', [
                    'menunggu_pembayaran',
                    'dikonfirmasi',
                    'diproses',
                    'dimasak',
                    'siap_diantar',
                    'diantar',
                    'selesai',
                    'dibatalkan'
                ])->default('menunggu_pembayaran');
                $table->decimal('subtotal', 10, 2);
                $table->decimal('biaya_pengiriman', 10, 2)->default(0);
                $table->decimal('diskon', 10, 2)->default(0);
                $table->decimal('total_bayar', 10, 2);
                $table->timestamps();
            });
        }

        // 7. Table Detail Pesanan
        if (!Schema::hasTable('detail_pesanan')) {
            Schema::create('detail_pesanan', function (Blueprint $table) {
                $table->id('id_detail');
                $table->foreignId('id_pesanan')->constrained('pesanan', 'id_pesanan')->onDelete('cascade');
                $table->foreignId('id_varian')->constrained('varian_menu', 'id_varian')->onDelete('cascade');
                $table->integer('jumlah');
                $table->decimal('harga_per_unit', 10, 2);
                $table->decimal('subtotal', 10, 2);
                $table->text('catatan')->nullable();
                $table->timestamps();
            });
        }

        // 8. Table Pembayaran
        if (!Schema::hasTable('pembayaran')) {
            Schema::create('pembayaran', function (Blueprint $table) {
                $table->id('id_pembayaran');
                $table->foreignId('id_pesanan')->constrained('pesanan', 'id_pesanan')->onDelete('cascade');
                $table->enum('metode_pembayaran', [
                    'cod',
                    'ovo',
                    'gopay',
                    'dana',
                    'shopeepay',
                    'bca',
                    'mandiri',
                    'seabank',
                    'bri',
                    'bni'
                ]);
                $table->enum('status_pembayaran', ['menunggu', 'dibayar', 'gagal', 'dikembalikan'])->default('menunggu');
                $table->decimal('jumlah', 10, 2);
                $table->string('id_transaksi', 100)->nullable();
                $table->timestamp('tanggal_pembayaran')->nullable();
                $table->string('bukti_pembayaran')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        // Drop tables in reverse order
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('detail_pesanan');
        Schema::dropIfExists('pesanan');
        Schema::dropIfExists('keranjang');
        Schema::dropIfExists('varian_menu');
        Schema::dropIfExists('menu');
        Schema::dropIfExists('kategori_menu');
        Schema::dropIfExists('pengguna');
    }
};