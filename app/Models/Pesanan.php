<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $primaryKey = 'id_pesanan';
    protected $table = 'pesanan';
    
    protected $fillable = [
        'nomor_pesanan',
        'id_pengguna',
        'id_menu',
        'nama_penerima',
        'nomor_telepon',
        'alamat_pengiriman',
        'jenis_pengiriman',
        'tanggal_pengiriman',
        'catatan_pelanggan',
        'status',
        'subtotal',
        'biaya_pengiriman',
        'diskon',
        'total_bayar',
        'tanggal_pesanan'
    ];
    
    protected $casts = [
        'tanggal_pengiriman' => 'datetime',
        'tanggal_pesanan' => 'datetime',
        'subtotal' => 'decimal:2',
        'biaya_pengiriman' => 'decimal:2',
        'diskon' => 'decimal:2',
        'total_bayar' => 'decimal:2'
    ];
    
    // Relationship dengan pembayaran
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pesanan', 'id_pesanan');
    }
    
    // Relationship dengan detail pesanan
    public function details()
    {
        return $this->hasMany(PesananDetail::class, 'id_pesanan', 'id_pesanan');
    }
    
    // Relationship dengan pengguna
    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
    
    // Alias untuk kompatibilitas
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
    
    // Scope untuk status tertentu
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    
    // Scope untuk pesanan hari ini
    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal_pesanan', today());
    }
    
    // Scope untuk periode tertentu
    public function scopePeriode($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_pesanan', [$startDate, $endDate]);
    }
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }
    
    // Relationship ke varian
    public function varian()
    {
        return $this->belongsTo(VarianMenu::class, 'id_varian');
    }
    
    // Relationship ke pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }
}