<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    use HasFactory;

    protected $table = 'shipping_zones';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'nama_zona',
        'kecamatan',
        'kota',
        'biaya_per_km',
        'biaya_minimum',
        'estimasi_hari_min',
        'estimasi_hari_max',
        'status_aktif'
    ];

    protected $casts = [
        'biaya_per_km' => 'decimal:0',
        'biaya_minimum' => 'decimal:0',
        'status_aktif' => 'boolean'
    ];

    public static function calculateShippingFee($kecamatan, $kota, $distance = null)
    {
        $zone = self::where('kecamatan', $kecamatan)
                    ->where('kota', $kota)
                    ->where('status_aktif', true)
                    ->first();

        if (!$zone) {
            return 10000; // Default fee
        }

        // If distance provided, calculate based on distance
        if ($distance !== null) {
            $fee = $distance * $zone->biaya_per_km;
            return max($fee, $zone->biaya_minimum);
        }

        return $zone->biaya_minimum;
    }
}