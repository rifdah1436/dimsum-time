<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    public $timestamps = true;

    protected $fillable = [
        'id_pengguna',
        'id_varian',
        'jumlah',
        'catatan'
    ];

    // Relationships
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function varian()
    {
        return $this->belongsTo(VarianMenu::class, 'id_varian');
    }

    // Helper methods
    public function getSubtotalAttribute()
    {
        return $this->jumlah * $this->varian->harga;
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }
}