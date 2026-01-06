<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            DimsumSeeder::class,
            // Tambahkan seeder baru
            CouponSeeder::class,
            ShippingZoneSeeder::class,
        ]);
    }
}