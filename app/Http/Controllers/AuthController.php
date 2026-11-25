<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Rules\Recaptcha;

class AuthController extends Controller
{
    // Halaman registrasi
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'country' => 'required|string|max:100',
            'g-recaptcha-response' => ['required', new Recaptcha()],
            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'country' => $validated['country'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('account.index')
            ->with('success', 'Registrasi berhasil. Selamat datang di TERRAWOOD!');
    }

    // Halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('account.index');
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password yang dimasukkan salah.',
            ])
            ->onlyInput('email');
    }

    // Google OAuth tanpa package tambahan; membutuhkan client ID/secret di .env.
    public function redirectToGoogle(Request $request)
    {
        $clientId = config('services.google.client_id');
        if (!$clientId || !config('services.google.client_secret')) {
            return redirect()->route('login')->withErrors(['email' => 'Login Google belum dikonfigurasi. Silakan gunakan login biasa.']);
        }

        $state = bin2hex(random_bytes(24));
        $request->session()->put('google_oauth_state', $state);
        $query = http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => route('google.callback'),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'prompt' => 'select_account',
        ]);

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
    }

    public function handleGoogleCallback(Request $request)
    {
        $expectedState = (string) $request->session()->pull('google_oauth_state', '');
        $providedState = (string) $request->query('state', '');
        if (!$request->query('code') || !$expectedState || !$providedState || !hash_equals($expectedState, $providedState)) {
            return redirect()->route('login')->withErrors(['email' => 'Login Google gagal, silakan coba kembali.']);
        }

        $tokenResponse = \Illuminate\Support\Facades\Http::asForm()->timeout(15)->post('https://oauth2.googleapis.com/token', [
            'code' => $request->query('code'),
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'redirect_uri' => route('google.callback'),
            'grant_type' => 'authorization_code',
        ]);
        if (!$tokenResponse->successful() || !$tokenResponse->json('access_token')) {
            return redirect()->route('login')->withErrors(['email' => 'Tidak dapat memverifikasi login Google.']);
        }

        $profileResponse = \Illuminate\Support\Facades\Http::withToken($tokenResponse->json('access_token'))->timeout(15)->get('https://www.googleapis.com/oauth2/v2/userinfo');
        if (!$profileResponse->successful()) {
            return redirect()->route('login')->withErrors(['email' => 'Profil Google tidak dapat dibaca.']);
        }
        $profile = $profileResponse->json();
        if (empty($profile['email']) || empty($profile['id']) || empty($profile['verified_email'])) {
            return redirect()->route('login')->withErrors(['email' => 'Google harus memberikan email yang terverifikasi.']);
        }

        $user = User::where('google_id', $profile['id'])->orWhere('email', $profile['email'])->first();
        if (!$user) {
            $request->session()->put('google_new_user', [
                'name' => $profile['name'] ?? '',
                'email' => $profile['email'],
                'google_id' => $profile['id'],
            ]);
            return redirect()->route('google.country');
        }

        if (!$user->google_id) {
            $user->update(['google_id' => $profile['id']]);
        }
        Auth::login($user);
        $request->session()->regenerate();
        return $user->role === 'admin' ? redirect()->route('admin.dashboard') : redirect()->route('account.index');
    }

    public function showGoogleCountry(Request $request)
    {
        if (!$request->session()->has('google_new_user')) {
            return redirect()->route('register');
        }
        return view('auth.google-country', ['profile' => $request->session()->get('google_new_user')]);
    }

    public function finishGoogleRegistration(Request $request)
    {
        $profile = $request->session()->get('google_new_user');
        if (!$profile) {
            return redirect()->route('register');
        }

        $validated = $request->validate(['country' => 'required|string|max:100']);
        $user = User::firstOrCreate(
            ['email' => $profile['email']],
            [
                'name' => $profile['name'],
                'google_id' => $profile['google_id'],
                'country' => $validated['country'],
                'password' => Hash::make(bin2hex(random_bytes(24))),
                'role' => 'user',
            ]
        );
        $request->session()->forget('google_new_user');
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('account.index')->with('success', 'Account Google berhasil dibuat.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Kamu berhasil logout.');
    }
}
