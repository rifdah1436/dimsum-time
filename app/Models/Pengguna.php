<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    
    protected $fillable = [
        'username',
        'email',
        'password',
        'nama_lengkap',
        'nomor_telepon',
        'alamat',
        'peran',
        'foto_profil',
        'status_aktif'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    // Relationships
    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'id_pengguna');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_pengguna');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->peran === 'admin';
    }

    public function isPelanggan()
    {
        return $this->peran === 'pelanggan';
    }

    public function isPemilik()
    {
        return $this->peran === 'pemilik';
    }

    public function isKurir()
    {
        return $this->peran === 'kurir';
    }

    public function isKasir()
    {
        return $this->peran === 'kasir';
 
   }
   // Tambahkan di dalam class Pengguna
public function coupons()
{
    return $this->belongsToMany(Coupon::class, 'user_coupons', 'id_pengguna', 'id_kupon')
                ->withPivot('jumlah_digunakan', 'terakhir_digunakan')
                ->withTimestamps();
}

public function rewardPoints()
{
    return $this->hasMany(RewardPoint::class, 'id_pengguna');
}

public function isMember()
{
    return $this->peran == 'pelanggan';
}

public function isEligibleForFreeShipping($totalBelanja)
{
    // Member dengan total belanja minimal 50k dan status bebas ongkir aktif
    return $this->isMember() && 
           $this->bebas_ongkir && 
           $totalBelanja >= 50000;
}

public function calculateRewardPoints($totalBelanja)
{
    // 1 point setiap Rp 10.000
    return floor($totalBelanja / 10000);
}
}