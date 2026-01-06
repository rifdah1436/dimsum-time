<?php
// database/migrations/2024_..._add_fields_to_pesanan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPesananTable extends Migration
{
    public function up()
    {
        Schema::table('pesanan', function (Blueprint $table) {
            // Field untuk foto bukti pengiriman
            $table->string('bukti_pengiriman')->nullable()->after('status_pembayaran');
            
            // Field untuk catatan dari kurir
            $table->text('catatan_kurir')->nullable()->after('catatan_pelanggan');
            
            // Field untuk ID kurir yang menangani
            $table->unsignedBigInteger('id_kurir')->nullable()->after('id_pengguna');
            
            // Foreign key constraint
            $table->foreign('id_kurir')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropForeign(['id_kurir']);
            $table->dropColumn(['bukti_pengiriman', 'catatan_kurir', 'id_kurir']);
        });
    }
}