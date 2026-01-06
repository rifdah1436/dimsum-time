<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $primaryKey = 'id_menu';

    protected $fillable = [
        'id_kategori',
        'nama_menu',
        'deskripsi',
        'gambar',
        'status_tersedia',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriMenu::class, 'id_kategori');
    }

   // Relationship ke varian
    public function variants()
    {
        return $this->hasMany(VarianMenu::class, 'id_menu', 'id_menu');
    }
    
    // Relationship ke pesanan detail
    public function pesananDetails()
    {
        return $this->hasMany(PesananDetail::class, 'id_menu', 'id_menu');
    }
}