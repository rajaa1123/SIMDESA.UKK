<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Warga;
use App\Mail\OtpMail;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function showAdminLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => ['required', new \App\Rules\ReCaptcha],
        ], [
            'g-recaptcha-response.required' => 'Silakan centang reCAPTCHA untuk melanjutkan.',
        ]);

        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        // Check if user is locked out
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            
            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam $seconds detik.",
            ])->onlyInput('email')->with('unlock_at', now()->addSeconds($seconds)->timestamp);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');
        $loginType = $request->input('login_type'); // 'admin' or 'warga'

        if (Auth::attempt($credentials, $remember)) {
            RateLimiter::clear($throttleKey);
            $user = Auth::user();

            // === ROLE-BASED LOGIN SOURCE RESTRICTION ===
            
            // Check if login via /admin/login
            if ($loginType === 'admin') {
                if (!$user->isAdmin() && !$user->isKepalaDesa()) {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Akses ditolak: Akun warga tidak diizinkan masuk ke Panel Admin.',
                    ])->onlyInput('email');
                }
            } 
            // Check if login via standard /login
            else {
                if ($user->isAdmin() || $user->isKepalaDesa()) {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Email/Password Salah no acces',
                    ])->onlyInput('email');
                }
            }

            $request->session()->regenerate();
            


            return redirect()->intended('/dashboard');
        }

        // Failed attempt
        RateLimiter::hit($throttleKey);

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
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|max:20',
            'nik' => 'required|digits:16|exists:warga,nik|unique:users,nik',
            'g-recaptcha-response' => ['required', new \App\Rules\ReCaptcha],
        ], [
            'nik.exists' => 'NIK Anda tidak terdaftar sebagai warga desa. Silakan hubungi Admin.',
            'nik.unique' => 'NIK ini sudah memiliki akun.',
            'g-recaptcha-response.required' => 'Silakan centang reCAPTCHA untuk melanjutkan.',
        ]);

        try {
            DB::beginTransaction();

            // Cari data warga berdasarkan NIK
            $warga = Warga::where('nik', $validated['nik'])->first();

            if (!$warga) {
                return back()->withErrors(['nik' => 'Data warga tidak ditemukan.'])->withInput();
            }

            // Create user account dan link ke warga_id
            $user = User::create([
                'warga_id' => $warga->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'nik' => $validated['nik'],
                'password' => bcrypt($validated['password']),
                'phone' => $validated['phone'],
                'role_id' => 1, // role: warga
                'status' => 'active',
            ]);

            // Sync nomor HP ke data warga
            if ($validated['phone']) {
                $warga->update(['no_hp' => $validated['phone']]);
            }

            DB::commit();

            // Auto-login
            Auth::login($user);
            $request->session()->regenerate();




            return redirect()->route('dashboard')
                ->with('success', 'Akun Anda berhasil dibuat dan terhubung dengan data warga!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Registration failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->withErrors(['email' => 'Registrasi gagal. Silakan coba lagi atau hubungi admin.']);
        }
    }

    // --- FORGOT PASSWORD FLOW ---

    public function showForgotPassword()
    {
        return view('auth.passwords.email');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email'], [
            'email.exists' => 'Email tidak terdaftar dalam sistem.',
        ]);

        $email = $request->email;
        $otp = rand(100000, 999999);

        // Store OTP in cache for 10 minutes
        Cache::put('otp_' . $email, $otp, now()->addMinutes(10));

        try {
            Mail::to($email)->send(new OtpMail($otp));
            
            return redirect()->route('password.otp', ['email' => $email])
                ->with('success', 'Kode OTP telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            \Log::error('OTP Email failed: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Gagal mengirim email. Silakan coba lagi nanti.']);
        }
    }

    public function showVerifyOtp(Request $request)
    {
        $email = $request->email;
        if (!$email) return redirect()->route('password.request');
        return view('auth.passwords.otp', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric'
        ]);

        $cachedOtp = Cache::get('otp_' . $request->email);

        if ($cachedOtp && $cachedOtp == $request->otp) {
            // OTP is valid, store a temporary token in session to allow reset
            $resetToken = Str::random(60);
            session(['password_reset_email' => $request->email, 'password_reset_token' => $resetToken, 'otp_verified' => true]);
            
            Cache::forget('otp_' . $request->email);
            
            return redirect()->route('password.reset', ['token' => $resetToken]);
        }

        return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kadaluarsa.']);
    }

    public function showResetPassword(Request $request)
    {
        if (!session('password_reset_token') || session('password_reset_token') !== $request->token || !session('otp_verified')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi reset password tidak valid.']);
        }
        return view('auth.passwords.reset');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        if (!session('otp_verified')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi tidak valid.']);
        }

        $email = session('password_reset_email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->update(['password' => Hash::make($request->password)]);
            
            // Clear session
            session()->forget(['password_reset_email', 'password_reset_token', 'otp_verified']);

            return redirect()->route('login')->with('success', 'Password berhasil diperbarui. Silakan login kembali.');
        }

        return redirect()->route('password.request')->withErrors(['email' => 'User tidak ditemukan.']);
    }
}
