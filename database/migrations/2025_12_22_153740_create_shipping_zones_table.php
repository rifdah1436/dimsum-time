<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shipping_zones', function (Blueprint $table) {
            $table->id();
            $table->string('nama_zona');
            $table->string('kecamatan');
            $table->string('kota');
            $table->decimal('biaya_per_km', 10, 0)->default(1000);
            $table->decimal('biaya_minimum', 10, 0)->default(10000);
            $table->integer('estimasi_hari_min')->default(1);
            $table->integer('estimasi_hari_max')->default(2);
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
            
            $table->index(['kecamatan', 'kota']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipping_zones');
    }
};