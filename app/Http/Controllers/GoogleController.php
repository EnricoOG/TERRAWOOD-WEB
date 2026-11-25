<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Pastikan email dari Google sudah terverifikasi.
            if (
                !filter_var($googleUser->getEmail(), FILTER_VALIDATE_EMAIL) ||
                !($googleUser->user['verified_email'] ?? false)
            ) {
                return redirect('/login')
                    ->with('error', 'Email Google belum terverifikasi.');
            }

            // Cari akun berdasarkan Google ID terlebih dahulu.
            $user = User::where('google_id', $googleUser->getId())
                ->first();

            if (!$user) {
                // Periksa apakah email sudah terdaftar.
                $user = User::where('email', $googleUser->getEmail())
                    ->first();

                if ($user) {
                    // Jangan menghubungkan jika akun sudah terhubung
                    // dengan akun Google yang berbeda.
                    if (
                        $user->google_id &&
                        $user->google_id !== $googleUser->getId()
                    ) {
                        return redirect('/login')
                            ->with('error', 'Akun Google sudah terhubung dengan akun lain.');
                    }

                    // Pertahankan role dan data akun lama.
                    $user->google_id = $googleUser->getId();
                    $user->save();
                } else {
                    // Buat akun baru.
                    $user = User::create([
                        'name' => $googleUser->getName()
                            ?: 'Terrawood User',
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'password' => Str::random(40),
                    ]);
                }
            }

            Auth::login($user);

            request()->session()->regenerate();

            return redirect()->intended('/');

        } catch (Throwable $e) {
            report($e);

            return redirect('/login')
                ->with('error', 'Login Google gagal. Silakan coba kembali.');
        }
    }
}
