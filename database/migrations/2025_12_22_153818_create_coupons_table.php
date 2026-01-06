<?php
// database/migrations/2024_01_15_create_coupons_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kupon')->unique();
            $table->string('nama_kupon');
            $table->enum('tipe', ['persentase', 'nominal', 'ongkir']);
            $table->decimal('nilai', 10, 2);
            $table->decimal('minimal_belanja', 10, 2)->default(0);
            $table->decimal('diskon_maksimal', 10, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->date('berlaku_dari');
            $table->date('berlaku_hingga');
            $table->integer('kuota')->default(-1); // -1 untuk unlimited
            $table->integer('terpakai')->default(0);
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}