<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->enum('metode_pembayaran', [
                'cod', 'ovo', 'gopay', 'dana', 'shopeepay', 
                'bca', 'mandiri', 'seabank', 'bri', 'bni'
            ])->default('cod')->after('catatan_pelanggan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            //
        });
    }
};
