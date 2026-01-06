<?php

namespace App\Jobs;

use App\Models\Pesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BatalkanPesananKedaluwarsa implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $pesananKedaluwarsa = Pesanan::where('status', 'menunggu_pembayaran')
            ->whereNotNull('waktu_kedaluwarsa')
            ->where('waktu_kedaluwarsa', '<', now())
            ->get();
            
        foreach ($pesananKedaluwarsa as $pesanan) {
            $pesanan->status = 'dibatalkan';
            $pesanan->save();
            
            // Kembalikan stok
            foreach ($pesanan->detail as $detail) {
                $varian = VarianMenu::find($detail->id_varian);
                if ($varian) {
                    $varian->stok += $detail->jumlah;
                    $varian->save();
                }
            }
        }
    }
}