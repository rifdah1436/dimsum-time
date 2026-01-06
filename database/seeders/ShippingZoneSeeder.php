<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShippingZone;

class ShippingZoneSeeder extends Seeder
{
    public function run()
    {
        $zones = [
            [
                'nama_zona' => 'Serang',
                'kecamatan' => 'Serang',
                'kota' => 'Serang',
                'biaya_per_km' => 1000,
                'biaya_minimum' => 25000,
                'estimasi_hari_min' => 2,
                'estimasi_hari_max' => 3,
                'status_aktif' => true
            ],
            [
                'nama_zona' => 'Bekasi Pusat',
                'kecamatan' => 'Bekasi',
                'kota' => 'Bekasi',
                'biaya_per_km' => 1000,
                'biaya_minimum' => 20000,
                'estimasi_hari_min' => 1,
                'estimasi_hari_max' => 2,
                'status_aktif' => true
            ],
            [
                'nama_zona' => 'Jakarta Selatan',
                'kecamatan' => 'Jakarta Selatan',
                'kota' => 'Jakarta',
                'biaya_per_km' => 1000,
                'biaya_minimum' => 10000,
                'estimasi_hari_min' => 1,
                'estimasi_hari_max' => 1,
                'status_aktif' => true
            ],
            [
                'nama_zona' => 'Jakarta Pusat',
                'kecamatan' => 'Jakarta Pusat',
                'kota' => 'Jakarta',
                'biaya_per_km' => 1000,
                'biaya_minimum' => 10000,
                'estimasi_hari_min' => 1,
                'estimasi_hari_max' => 1,
                'status_aktif' => true
            ],
            [
                'nama_zona' => 'Jakarta Barat',
                'kecamatan' => 'Jakarta Barat',
                'kota' => 'Jakarta',
                'biaya_per_km' => 1000,
                'biaya_minimum' => 10000,
                'estimasi_hari_min' => 1,
                'estimasi_hari_max' => 1,
                'status_aktif' => true
            ],
            [
                'nama_zona' => 'Jakarta Utara',
                'kecamatan' => 'Jakarta Utara',
                'kota' => 'Jakarta',
                'biaya_per_km' => 1000,
                'biaya_minimum' => 15000,
                'estimasi_hari_min' => 1,
                'estimasi_hari_max' => 2,
                'status_aktif' => true
            ]
        ];

        foreach ($zones as $zone) {
            ShippingZone::create($zone);
        }
    }
}