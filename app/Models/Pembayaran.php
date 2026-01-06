<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $primaryKey = 'id_pembayaran';
    protected $table = 'pembayaran';
    
    protected $fillable = [
        'id_pesanan',
        'metode_pembayaran',
        'metode_pembayaran_string', // tambahkan ini
        'status_pembayaran',
        'jumlah',
        'id_transaksi',
        'tanggal_pembayaran',
        'bukti_pembayaran',
        'catatan'
    ];
    
    protected $casts = [
        'tanggal_pembayaran' => 'datetime',
        'jumlah' => 'decimal:2'
    ];
    
    // Constants untuk status pembayaran
    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_MENUNGGU_VERIFIKASI = 'menunggu_verifikasi';
    const STATUS_DIBAYAR = 'dibayar';
    const STATUS_GAGAL = 'gagal';
    const STATUS_DIKEMBALIKAN = 'dikembalikan';
    
    // Constants untuk metode pembayaran
    const METHOD_COD = 'cod';
    const METHOD_OVO = 'ovo';
    const METHOD_GOPAY = 'gopay';
    const METHOD_DANA = 'dana';
    const METHOD_SHOPEEPAY = 'shopeepay';
    const METHOD_BCA = 'bca';
    const METHOD_MANDIRI = 'mandiri';
    const METHOD_SEABANK = 'seabank';
    const METHOD_BRI = 'bri';
    const METHOD_BNI = 'bni';
    
    // Relationship dengan pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
    
    // Helper method untuk status
    public function getStatusLabelAttribute()
    {
        $labels = [
            self::STATUS_MENUNGGU => 'Menunggu Pembayaran',
            self::STATUS_MENUNGGU_VERIFIKASI => 'Menunggu Verifikasi',
            self::STATUS_DIBAYAR => 'Dibayar/Lunas',
            self::STATUS_GAGAL => 'Gagal',
            self::STATUS_DIKEMBALIKAN => 'Dikembalikan'
        ];
        
        return $labels[$this->status_pembayaran] ?? $this->status_pembayaran;
    }
    
    // Helper method untuk metode pembayaran
    public function getMetodeLabelAttribute()
    {
        $labels = [
            self::METHOD_COD => 'Cash on Delivery (COD)',
            self::METHOD_OVO => 'OVO',
            self::METHOD_GOPAY => 'Gopay',
            self::METHOD_DANA => 'DANA',
            self::METHOD_SHOPEEPAY => 'ShopeePay',
            self::METHOD_BCA => 'Transfer BCA',
            self::METHOD_MANDIRI => 'Transfer Mandiri',
            self::METHOD_SEABANK => 'Transfer Seabank',
            self::METHOD_BRI => 'Transfer BRI',
            self::METHOD_BNI => 'Transfer BNI'
        ];
        
        // Gunakan metode_pembayaran_string jika ada, jika tidak gunakan metode_pembayaran
        $method = $this->metode_pembayaran_string ?? $this->metode_pembayaran;
        
        return $labels[$method] ?? ucfirst($method);
    }
    
    // Scope untuk status
    public function scopeMenunggu($query)
    {
        return $query->where('status_pembayaran', self::STATUS_MENUNGGU);
    }
    
    public function scopeMenungguVerifikasi($query)
    {
        return $query->where('status_pembayaran', self::STATUS_MENUNGGU_VERIFIKASI);
    }
    
    public function scopeLunas($query)
    {
        return $query->where('status_pembayaran', self::STATUS_DIBAYAR);
    }
}