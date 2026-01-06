<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class OwnerPegawaiController extends Controller
{
    // Pastikan hanya Owner yang bisa akses
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->peran !== 'pemilik') {
                return redirect('/home');
            }
            return $next($request);
        });
    }

    // 1. TAMPILKAN FORM TAMBAH
    public function create()
    {
        return view('owner.pegawai.create');
    }

    // 2. SIMPAN DATA BARU (CREATE)
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:pengguna,username',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6',
            'peran' => 'required|in:admin,kasir,kurir',
            'nomor_telepon' => 'required'
        ]);

        DB::table('pengguna')->insert([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password di-hash
            'nomor_telepon' => $request->nomor_telepon,
            'peran' => $request->peran,
            'status_aktif' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('owner.dashboard')->with('success', 'Pegawai berhasil ditambahkan!');
    }

    // 3. TAMPILKAN FORM EDIT
    public function edit($id)
    {
        $pegawai = DB::table('pengguna')->where('id_pengguna', $id)->first();
        return view('owner.pegawai.edit', compact('pegawai'));
    }

    // 4. SIMPAN PERUBAHAN (UPDATE)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email',
            'peran' => 'required',
            'nomor_telepon' => 'required'
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'peran' => $request->peran,
            'updated_at' => now()
        ];

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('pengguna')->where('id_pengguna', $id)->update($data);

        return redirect()->route('owner.dashboard')->with('success', 'Data pegawai berhasil diperbarui!');
    }

    // 5. HAPUS DATA (DELETE)
    public function destroy($id)
    {
        DB::table('pengguna')->where('id_pengguna', $id)->delete();
        return redirect()->route('owner.dashboard')->with('success', 'Pegawai berhasil dihapus!');
    }
}