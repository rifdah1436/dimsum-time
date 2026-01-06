<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    public function run()
    {
        $coupons = [
            [
                'kode_kupon' => 'DIMSUM10',
                'nama_kupon' => 'Diskon 10%',
                'tipe' => 'persentase',
                'nilai' => 10,
                'minimal_belanja' => 50000,
                'diskon_maksimal' => 20000,
                'berlaku_dari' => Carbon::now(),
                'berlaku_hingga' => Carbon::now()->addMonths(3),
                'kuota_penggunaan' => 100,
                'penggunaan_sekarang' => 0,
                'status_aktif' => true
            ],
            [
                'kode_kupon' => 'DIMSUM20K',
                'nama_kupon' => 'Potongan Rp20.000',
                'tipe' => 'nominal',
                'nilai' => 20000,
                'minimal_belanja' => 100000,
                'diskon_maksimal' => null,
                'berlaku_dari' => Carbon::now(),
                'berlaku_hingga' => Carbon::now()->addMonths(2),
                'kuota_penggunaan' => 50,
                'penggunaan_sekarang' => 0,
                'status_aktif' => true
            ],
            [
                'kode_kupon' => 'GRATISONGKIR',
                'nama_kupon' => 'Gratis Ongkir',
                'tipe' => 'nominal',
                'nilai' => 15000,
                'minimal_belanja' => 75000,
                'diskon_maksimal' => 15000,
                'berlaku_dari' => Carbon::now(),
                'berlaku_hingga' => Carbon::now()->addMonth(),
                'kuota_penggunaan' => 30,
                'penggunaan_sekarang' => 0,
                'status_aktif' => true
            ],
            [
                'kode_kupon' => 'NEWUSER15',
                'nama_kupon' => 'Diskon 15% User Baru',
                'tipe' => 'persentase',
                'nilai' => 15,
                'minimal_belanja' => 30000,
                'diskon_maksimal' => 25000,
                'berlaku_dari' => Carbon::now(),
                'berlaku_hingga' => Carbon::now()->addYear(),
                'kuota_penggunaan' => 1000,
                'penggunaan_sekarang' => 0,
                'khusus_pengguna' => 'new',
                'status_aktif' => true
            ]
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}