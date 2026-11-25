<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secret = config('services.recaptcha.secret_key');

        // Kalau key belum diisi (misalnya saat development), lewati pengecekan.
        if (empty($secret)) {
            return;
        }

        try {
            $response = Http::asForm()->timeout(8)->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => $secret,
                'response' => (string) $value,
                'remoteip' => request()->ip(),
            ]);

            if (! $response->ok() || ! $response->json('success')) {
                $fail('CAPTCHA verification failed. Please try again.');
            }
        } catch (\Throwable $e) {
            $fail('Captcha verification could not be completed. Please try again.');
        }
    }
}