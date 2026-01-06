<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananDetail extends Model
{
    use HasFactory;

    // Perhatikan: nama tabel di database adalah `detail_pesanan`
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_pesanan',
        'id_varian',
        'id_menu',
        'jumlah',
        'harga_per_unit',
        'subtotal',
        'catatan',
    ];

    protected $casts = [
        'harga_per_unit' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

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