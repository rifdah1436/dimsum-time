<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pengguna', function (Blueprint $table) {
            // Tambahkan kolom alamat yang lengkap jika belum ada
            if (!Schema::hasColumn('pengguna', 'kecamatan')) {
                $table->string('kecamatan', 100)->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('pengguna', 'kota')) {
                $table->string('kota', 100)->nullable()->after('kecamatan');
            }
            if (!Schema::hasColumn('pengguna', 'kode_pos')) {
                $table->string('kode_pos', 10)->nullable()->after('kota');
            }
            if (!Schema::hasColumn('pengguna', 'catatan_alamat')) {
                $table->text('catatan_alamat')->nullable()->after('kode_pos');
            }
            
            // Tambahkan kolom reward points
            if (!Schema::hasColumn('pengguna', 'poin_reward')) {
                $table->integer('poin_reward')->default(0)->after('peran');
            }
            if (!Schema::hasColumn('pengguna', 'total_belanja')) {
                $table->decimal('total_belanja', 15, 2)->default(0)->after('poin_reward');
            }
            if (!Schema::hasColumn('pengguna', 'tingkat_loyalitas')) {
                $table->tinyInteger('tingkat_loyalitas')->default(1)
                    ->comment('1: Bronze, 2: Silver, 3: Gold')
                    ->after('total_belanja');
            }
            if (!Schema::hasColumn('pengguna', 'bebas_ongkir')) {
                $table->boolean('bebas_ongkir')->default(false)->after('tingkat_loyalitas');
            }
        });
    }

    public function down()
    {
        Schema::table('pengguna', function (Blueprint $table) {
            // Jangan hapus kolom alamat utama
            // Hanya hapus kolom reward
            $table->dropColumn([
                'poin_reward',
                'total_belanja',
                'tingkat_loyalitas',
                'bebas_ongkir'
            ]);
        });
    }
};