<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VarianMenu extends Model
{
    use HasFactory;

    protected $table = 'varian_menu';
    protected $primaryKey = 'id_varian';

    protected $fillable = [
        'id_menu',
        'ukuran',
        'jumlah_pcs',
        'harga',
        'stok',
        'stok_minimum',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    // Relationship ke menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }
    
    // Relationship ke pesanan detail
    public function pesananDetails()
    {
        return $this->hasMany(PesananDetail::class, 'id_varian', 'id_varian');
    }
}