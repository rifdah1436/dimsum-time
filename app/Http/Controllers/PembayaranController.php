<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    // Tampilkan halaman instruksi pembayaran
    public function showInstructions($id)
    {
        $pesanan = Pesanan::where('id_pesanan', $id)
            ->where('id_pengguna', auth()->id())
            ->firstOrFail();
            
        // Cek jika sudah lewat waktu
        if ($pesanan->waktu_kedaluwarsa && now()->gt($pesanan->waktu_kedaluwarsa)) {
            $pesanan->status = 'dibatalkan';
            $pesanan->save();
            
            return redirect()->route('pesanan')
                ->with('error', 'Pembayaran sudah kedaluwarsa. Pesanan dibatalkan.');
        }
        
        return view('pembayaran-instructions', compact('pesanan'));
    }
    
    // Proses upload bukti pembayaran
    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'nama_pengirim' => 'required|string|max:100'
        ]);
        
        $pesanan = Pesanan::where('id_pesanan', $id)
            ->where('id_pengguna', auth()->id())
            ->firstOrFail();
            
        // Cek waktu
        if ($pesanan->waktu_kedaluwarsa && now()->gt($pesanan->waktu_kedaluwarsa)) {
            return back()->with('error', 'Waktu pembayaran sudah habis. Pesanan dibatalkan.');
        }
        
        // Upload file
        $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        
        // Update pesanan
        $pesanan->update([
            'bukti_pembayaran' => $path,
            'nama_pengirim' => $request->nama_pengirim,
            'status' => 'menunggu_verifikasi', // Status baru
            'tanggal_pembayaran' => now(),
        ]);
        
        return redirect()->route('pesanan')
            ->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');
    }
    
    // API untuk cek status pembayaran (untuk auto-check)
    public function checkStatus($id)
    {
        $pesanan = Pesanan::where('id_pesanan', $id)
            ->where('id_pengguna', auth()->id())
            ->firstOrFail();
            
        return response()->json([
            'status' => $pesanan->status,
            'waktu_kedaluwarsa' => $pesanan->waktu_kedaluwarsa,
            'sisa_waktu' => $pesanan->waktu_kedaluwarsa 
                ? now()->diffInSeconds($pesanan->waktu_kedaluwarsa, false) 
                : null
        ]);
    }
}