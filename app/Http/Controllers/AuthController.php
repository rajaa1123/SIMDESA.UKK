<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Warga;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|max:20',
            'nik' => 'required|unique:warga|max:20',
        ]);

        try {
            // ✅ PASTIKAN transaction untuk consistency
            DB::beginTransaction();

            // Create data warga dulu
            $warga = Warga::create([
                'nik' => $validated['nik'],
                'nama_lengkap' => $validated['name'],
                'no_hp' => $validated['phone'],
                'status_hidup' => 'Hidup',
                'status_domisili' => 'Domisili Tetap',
                // field lainnya default
            ]);

            // Create user account
            $user = User::create([
                'warga_id' => $warga->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'phone' => $validated['phone'],
                'role_id' => 1, // role: warga
            ]);

            DB::commit();

            return redirect()->route('login')
                ->with('success', 'Registrasi berhasil! Silakan login.');

        } catch (\Exception $e) {
            DB::rollBack();

            // ✅ ERROR HANDLING YANG LEBIH BAIK
            return back()
                ->withInput()
                ->withErrors(['email' => 'Registrasi gagal. Silakan coba lagi atau hubungi admin.']);
        }
    }
}