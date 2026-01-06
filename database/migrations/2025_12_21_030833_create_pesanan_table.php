<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->unsignedBigInteger('id_user');
            $table->string('nomor_pesanan', 50)->unique();
            $table->string('nama_penerima', 255);
            $table->string('nomor_telepon', 20);
            $table->string('email', 255);
            $table->text('alamat_lengkap');
            $table->string('kecamatan', 100);
            $table->string('kota', 100);
            $table->string('kode_pos', 10)->nullable();
            $table->text('catatan_pelanggan')->nullable();
            $table->enum('metode_pengiriman', ['delivery', 'pickup']);
            $table->enum('waktu_pengiriman', ['secepatnya', 'jadwal']);
            $table->date('tanggal_pengiriman')->nullable();
            $table->string('jam_pengiriman', 5)->nullable();
            $table->enum('metode_pembayaran', ['cod', 'transfer', 'ewallet']);
            $table->string('kode_promo', 50)->nullable();
            $table->decimal('subtotal', 12, 0);
            $table->decimal('biaya_pengiriman', 12, 0);
            $table->decimal('diskon', 12, 0)->default(0);
            $table->decimal('total_bayar', 12, 0);
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
            $table->timestamp('tanggal_pesanan')->useCurrent();
            $table->string('bukti_pembayaran', 255)->nullable();
            $table->timestamp('tanggal_pembayaran')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanan');
    }
};