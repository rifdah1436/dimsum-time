<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ubah kolom status_pembayaran dari ENUM ke VARCHAR
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->string('status_pembayaran', 30)
                  ->default('menunggu')
                  ->change();
        });
        
        // 2. Tambah kolom catatan jika belum ada
        if (!Schema::hasColumn('pembayaran', 'catatan')) {
            Schema::table('pembayaran', function (Blueprint $table) {
                $table->text('catatan')->nullable()->after('bukti_pembayaran');
            });
        }
        
        // 3. Tambah kolom metode_pembayaran_string untuk backup
        if (!Schema::hasColumn('pembayaran', 'metode_pembayaran_string')) {
            Schema::table('pembayaran', function (Blueprint $table) {
                $table->string('metode_pembayaran_string', 50)
                      ->nullable()
                      ->after('metode_pembayaran');
            });
        }
        
        // 4. Copy data dari ENUM ke string (opsional)
        DB::statement("UPDATE pembayaran SET metode_pembayaran_string = metode_pembayaran");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Hapus kolom tambahan
        if (Schema::hasColumn('pembayaran', 'metode_pembayaran_string')) {
            Schema::table('pembayaran', function (Blueprint $table) {
                $table->dropColumn('metode_pembayaran_string');
            });
        }
        
        if (Schema::hasColumn('pembayaran', 'catatan')) {
            Schema::table('pembayaran', function (Blueprint $table) {
                $table->dropColumn('catatan');
            });
        }
        
        // 2. Kembalikan ke ENUM (harus hati-hati karena data mungkin tidak valid)
        // Untuk safety, kita ubah dulu ke ENUM dengan values yang lebih lengkap
        DB::statement("ALTER TABLE pembayaran 
            MODIFY COLUMN status_pembayaran 
            ENUM('menunggu', 'menunggu_verifikasi', 'dibayar', 'gagal', 'dikembalikan') 
            DEFAULT 'menunggu'");
    }
};