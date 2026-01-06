<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Coupon extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id_kupon';
    protected $table = 'coupons';

    protected $fillable = [
        'kode_kupon',
        'nama_kupon',
        'tipe',
        'nilai',
        'minimal_belanja',
        'diskon_maksimal',
        'keterangan',
        'berlaku_dari',
        'berlaku_hingga',
        'kuota',
        'terpakai',
        'status_aktif'
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
        'minimal_belanja' => 'decimal:2',
        'diskon_maksimal' => 'decimal:2',
        'berlaku_dari' => 'datetime',
        'berlaku_hingga' => 'datetime'
    ];

    // Scope untuk voucher aktif
    public function scopeAktif($query)
    {
        return $query->where('status_aktif', 1)
            ->where('berlaku_dari', '<=', now())
            ->where('berlaku_hingga', '>=', now())
            ->where(function($q) {
                $q->where('kuota', -1) // unlimited
                  ->orWhereRaw('kuota > terpakai');
            });
    }

    // Cek apakah voucher berlaku untuk user tertentu
    public function berlakuUntukUser($userId = null)
    {
        // Anda bisa menambahkan logika khusus untuk member baru
        // Contoh: cek jika user baru (register < 30 hari)
        // atau cek riwayat order user
        
        return true;
    }

    // Hitung diskon berdasarkan subtotal
    public function hitungDiskon($subtotal)
    {
        if ($subtotal < $this->minimal_belanja) {
            return 0;
        }

        $diskon = 0;

        switch ($this->tipe) {
            case 'persentase':
                $diskon = ($subtotal * $this->nilai) / 100;
                if ($this->diskon_maksimal && $diskon > $this->diskon_maksimal) {
                    $diskon = $this->diskon_maksimal;
                }
                break;

            case 'nominal':
                $diskon = $this->nilai;
                break;

            case 'ongkir':
                // Diskus khusus ongkir akan ditangani terpisah
                $diskon = $this->nilai;
                break;
        }

        return $diskon;
    }

    // Cek apakah voucher bisa digunakan
    public function bisaDigunakan($subtotal)
    {
        // Cek masa berlaku
        if (now()->lt($this->berlaku_dari) || now()->gt($this->berlaku_hingga)) {
            return false;
        }

        // Cek status aktif
        if (!$this->status_aktif) {
            return false;
        }

        // Cek kuota
        if ($this->kuota > 0 && $this->terpakai >= $this->kuota) {
            return false;
        }

        // Cek minimal belanja
        if ($subtotal < $this->minimal_belanja) {
            return false;
        }

        return true;
    }

    // Tambah jumlah penggunaan
    public function tambahPenggunaan()
    {
        $this->increment('terpakai');
    }
}