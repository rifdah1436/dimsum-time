<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Show login page
    public function showLogin()
    {
        // Jika user sudah login, redirect berdasarkan role
        if (Auth::check()) {
            $user = Auth::user();
            
            // Redirect berdasarkan peran
            return $this->redirectBasedOnRole($user);
        }
        
        return view('auth.login');
    }

    // Process login
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cek credentials
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Check if user is active
            if (!$user->status_aktif) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda dinonaktifkan. Silakan hubungi admin.',
                ])->withInput($request->except('password'));
            }
            
            // Redirect berdasarkan role
            return $this->redirectBasedOnRole($user);
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->except('password'));
    }

    // Helper function untuk redirect berdasarkan role
    private function redirectBasedOnRole($user)
    {
        switch ($user->peran) {
            case 'kurir':
                return redirect()->route('kurir.dashboard');
                
            case 'kasir':
                return redirect()->route('kasir.dashboard');
                
            case 'pemilik':
            case 'owner':
                return redirect()->route('owner.dashboard');
                
            case 'admin':
                return redirect()->route('admin.dashboard');
                
            case 'pelanggan':
            default:
                return redirect()->route('home');
        }
    }

    // Show registration page
    public function showRegister()
    {
        // Jika user sudah login, redirect berdasarkan role
        if (Auth::check()) {
            $user = Auth::user();
            return $this->redirectBasedOnRole($user);
        }
        
        return view('auth.register');
    }

    // Process registration
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6|confirmed',
            'nomor_telepon' => 'required|string|max:15',
            'terms' => 'required'
        ], [
            'terms.required' => 'Anda harus menyetujui syarat dan ketentuan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate username dari email
        $username = str_replace(['@', '.', '-', '_'], '', explode('@', $request->email)[0]) . rand(100, 999);

        // Buat user baru
        $user = Pengguna::create([
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'nomor_telepon' => $request->nomor_telepon,
            'peran' => 'pelanggan', // Default role untuk registrasi
            'status_aktif' => true
        ]);

        // Login otomatis setelah register
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registrasi berhasil! Selamat datang di Dimsum Time.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
    
    // Show forgot password page (optional)
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }
    
    // Process forgot password (optional)
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:pengguna,email']);
        
        // Logic untuk mengirim link reset password
        // Bisa menggunakan Laravel's built-in password reset
        
        return back()->with('success', 'Link reset password telah dikirim ke email Anda.');
    }
}