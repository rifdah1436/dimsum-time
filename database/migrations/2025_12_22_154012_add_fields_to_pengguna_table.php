<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->integer('poin_reward')->default(0)->after('alamat');
            $table->boolean('bebas_ongkir')->default(false)->after('poin_reward');
            $table->integer('tingkat_loyalitas')->default(1)->after('bebas_ongkir'); // 1: Bronze, 2: Silver, 3: Gold
            $table->decimal('total_belanja', 15, 2)->default(0)->after('tingkat_loyalitas');
        });
    }

    public function down(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropColumn(['poin_reward', 'bebas_ongkir', 'tingkat_loyalitas', 'total_belanja']);
        });
    }
};