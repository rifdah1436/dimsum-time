<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardPoint extends Model
{
    use HasFactory;

    protected $table = 'reward_points';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id_pengguna',
        'poin',
        'sumber',
        'keterangan',
        'expired_at'
    ];

    protected $casts = [
        'poin' => 'integer',
        'expired_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public static function addPoints($userId, $points, $source = 'pembelian', $description = null)
    {
        return self::create([
            'id_pengguna' => $userId,
            'poin' => $points,
            'sumber' => $source,
            'keterangan' => $description ?? 'Poin dari ' . $source,
            'expired_at' => now()->addMonths(6) // Poin expired dalam 6 bulan
        ]);
    }

    public static function getTotalPoints($userId)
    {
        return self::where('id_pengguna', $userId)
                   ->where('expired_at', '>', now())
                   ->sum('poin');
    }
}