<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DimsumSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        DB::table('pembayaran')->truncate();
        DB::table('detail_pesanan')->truncate();
        DB::table('pesanan')->truncate();
        DB::table('keranjang')->truncate();
        DB::table('varian_menu')->truncate();
        DB::table('menu')->truncate();
        DB::table('kategori_menu')->truncate();
        DB::table('pengguna')->truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // 1. Insert users
        DB::table('pengguna')->insert([
            [
                'username' => 'admin',
                'email' => 'admin@dimsumtime.id',
                'password' => Hash::make('admin123'),
                'nama_lengkap' => 'Admin Utama',
                'nomor_telepon' => '081234567890',
                'peran' => 'admin',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'username' => 'pemilik',
                'email' => 'owner@dimsumtime.id',
                'password' => Hash::make('owner123'),
                'nama_lengkap' => 'Budi Santoso',
                'nomor_telepon' => '081234567891',
                'peran' => 'pemilik',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'username' => 'kasir1',
                'email' => 'kasir@dimsumtime.id',
                'password' => Hash::make('kasir123'),
                'nama_lengkap' => 'Siti Aminah',
                'nomor_telepon' => '081234567892',
                'peran' => 'kasir',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'username' => 'kurir1',
                'email' => 'kurir@dimsumtime.id',
                'password' => Hash::make('kurir123'),
                'nama_lengkap' => 'Agus Wijaya',
                'nomor_telepon' => '081234567893',
                'peran' => 'kurir',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'username' => 'john_doe',
                'email' => 'john@example.com',
                'password' => Hash::make('pelanggan123'),
                'nama_lengkap' => 'John Doe',
                'nomor_telepon' => '081234567894',
                'peran' => 'pelanggan',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 2. Insert categories
        DB::table('kategori_menu')->insert([
            ['nama_kategori' => 'Dimsum Kukus', 'deskripsi' => 'Dimsum kukus dengan berbagai isian', 'urutan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Dimsum Goreng', 'deskripsi' => 'Dimsum goreng yang renyah', 'urutan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Dimsum Spesial', 'deskripsi' => 'Dimsum dengan topping spesial', 'urutan' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Get category IDs
        $kategori_kukus = DB::table('kategori_menu')->where('nama_kategori', 'Dimsum Kukus')->first();
        $kategori_goreng = DB::table('kategori_menu')->where('nama_kategori', 'Dimsum Goreng')->first();
        $kategori_spesial = DB::table('kategori_menu')->where('nama_kategori', 'Dimsum Spesial')->first();

        // 3. Insert menus
        $menus = [
            // Kukus
            [$kategori_kukus->id_kategori, 'Dimsum Original', 'Dimsum kukus isi udang & sayur, lembut dan juicy.'],
            [$kategori_kukus->id_kategori, 'Wonton Chilli Oil', 'Wonton isi daging siram chilli oil pedes gurih wangi.'],
            [$kategori_kukus->id_kategori, 'Dumpling Ayam', 'Dumpling kukus isi ayam yang juicy dan lembut.'],
            
            // Goreng
            [$kategori_goreng->id_kategori, 'Ekado', 'Tahu kantong isi udang, goreng garing & juicy.'],
            [$kategori_goreng->id_kategori, 'Gohyong', 'Roll daging & sayur, crispy dan gurih tiap gigit.'],
            [$kategori_goreng->id_kategori, 'Gyoza Udang', 'Gyoza pan-seared isi udang juicy, ringan & tasty.'],
            [$kategori_goreng->id_kategori, 'Pangsit Ayam', 'Pangsit renyah isi ayam, best banget buat dicocol.'],
            [$kategori_goreng->id_kategori, 'Udang Rambutan', 'Udang dibalut mie tipis, digoreng renyah.'],
            [$kategori_goreng->id_kategori, 'Lumpia Udang', 'Lumpia isi udang, daging, dan sayuran.'],
            
            // Spesial
            [$kategori_spesial->id_kategori, 'Dimsum Mentai', 'Dimsum creamy topping saus mentai gurih pedes manis.'],
            [$kategori_spesial->id_kategori, 'Dimsum Keju Lumer', 'Dimsum dengan lelehan keju creamy yang bikin nagih.'],
            [$kategori_spesial->id_kategori, 'Dimsum Mentai Mozza', 'Dimsum dengan saus mentai dan mozzarella leleh.'],
        ];

        foreach ($menus as $menu) {
            $id_menu = DB::table('menu')->insertGetId([
                'id_kategori' => $menu[0],
                'nama_menu' => $menu[1],
                'deskripsi' => $menu[2],
                'status_tersedia' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Insert variants for each menu
            $variants = [
                ['S', 4, rand(20000, 30000), rand(20, 50)],
                ['L', 6, rand(30000, 40000), rand(15, 30)],
                ['XL', 8, rand(40000, 50000), rand(10, 20)]
            ];

            foreach ($variants as $v) {
                DB::table('varian_menu')->insert([
                    'id_menu' => $id_menu,
                    'ukuran' => $v[0],
                    'jumlah_pcs' => $v[1],
                    'harga' => $v[2],
                    'stok' => $v[3],
                    'stok_minimum' => 10,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin: admin@dimsumtime.id / admin123');
        $this->command->info('Pelanggan: john@example.com / pelanggan123');
    }
}