<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reward_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengguna')->constrained('pengguna')->onDelete('cascade');
            $table->integer('poin');
            $table->enum('sumber', ['pembelian', 'referral', 'promosi', 'lainnya'])->default('pembelian');
            $table->string('keterangan')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
            
            $table->index('id_pengguna');
            $table->index('expired_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reward_points');
    }
};