<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengguna;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function index()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    // Update data profil
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:pengguna,username,' . $user->id_pengguna . ',id_pengguna',
            'email' => 'required|email|max:100|unique:pengguna,email,' . $user->id_pengguna . ',id_pengguna',
            'nomor_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui!'
        ]);
    }

    // Ubah password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password saat ini salah!'
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah!'
        ]);
    }

    // Upload/update avatar
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Hapus foto lama jika ada
        if ($user->foto_profil) {
            Storage::delete('public/' . $user->foto_profil);
        }

        // Simpan foto baru
        $path = $request->file('foto_profil')->store('avatars', 'public');
        $user->foto_profil = $path;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diperbarui!',
            'avatar_url' => asset('storage/' . $path)
        ]);
    }

    // Hapus avatar
    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->foto_profil) {
            Storage::delete('public/' . $user->foto_profil);
            $user->foto_profil = null;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil dihapus!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tidak ada foto profil untuk dihapus!'
        ], 422);
    }
    
    /**
     * Update alamat - VERSI YANG BENAR untuk struktur database Anda
     */
    public function updateAddress(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Validasi input
            if (!$request->alamat || !$request->kecamatan || !$request->kota) {
                return response()->json([
                    'success' => false,
                    'message' => 'Alamat, kecamatan, dan kota wajib diisi!'
                ]);
            }
            
            // Gabungkan semua alamat menjadi satu string
            $alamatLengkap = $request->alamat;
            
            // Tambahkan kecamatan dan kota
            $alamatLengkap .= ', ' . $request->kecamatan . ', ' . $request->kota;
            
            // Tambahkan kode pos jika ada
            if ($request->kode_pos) {
                $alamatLengkap .= ' ' . $request->kode_pos;
            }
            
            // Tambahkan catatan jika ada
            if ($request->catatan_alamat) {
                $alamatLengkap .= ' - ' . $request->catatan_alamat;
            }
            
            // Simpan ke kolom alamat (satu kolom saja)
            $user->alamat = $alamatLengkap;
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Alamat berhasil diperbarui!',
                'alamat' => $alamatLengkap
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui alamat: ' . $e->getMessage()
            ]);
        }
    }
}