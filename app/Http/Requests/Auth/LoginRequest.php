<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $user = \App\Models\User::where('email', $this->email)->first();

        // 1. Cek apakah pengguna terdaftar di database
        if (! $user) {
            RateLimiter::hit($this->throttleKey());

            // Pertahankan password di session flash agar tidak hilang saat email salah
            $this->flashOnly(['email', 'password']);

            throw ValidationException::withMessages([
                'email' => 'User tidak terdaftar.',
            ]);
        }

        // 2. Cek apakah password sesuai
        if (! \Illuminate\Support\Facades\Hash::check($this->password, $user->password)) {
            RateLimiter::hit($this->throttleKey());

            // Password salah -> jangan simpan password di session
            $this->flashOnly(['email']);

            throw ValidationException::withMessages([
                'password' => 'Password yang Anda masukkan salah.',
            ]);
        }

        // 3. Cek status persetujuan akun oleh administrator
        if ($user->isPending()) {
            RateLimiter::hit($this->throttleKey());
            $this->flashOnly(['email']);

            throw ValidationException::withMessages([
                'unapproved' => 'Akun Anda belum disetujui oleh Administrator. Silakan hubungi admin untuk aktivasi akun.',
            ]);
        }

        if ($user->isRejected()) {
            RateLimiter::hit($this->throttleKey());
            $this->flashOnly(['email']);

            $reasonMsg = !empty($user->rejection_reason) ? 'Alasan Penolakan: "' . $user->rejection_reason . '". ' : '';

            throw ValidationException::withMessages([
                'rejected' => 'Pengajuan pendaftaran akun Anda ditolak oleh Administrator. ' . $reasonMsg . 'Silakan melakukan pendaftaran ulang.',
            ]);
        }

        if ($user->isInactive()) {
            RateLimiter::hit($this->throttleKey());
            $this->flashOnly(['email']);

            throw ValidationException::withMessages([
                'inactive' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi Administrator.',
            ]);
        }

        // 4. Cek apakah Mode Pemeliharaan (Maintenance Mode) sedang aktif
        $isMaintenance = (bool) \Illuminate\Support\Facades\Cache::get('app_setting_maintenance_mode', false);
        if ($isMaintenance && ! $user->hasRole('superadmin') && ! $user->hasRole('admin')) {
            RateLimiter::hit($this->throttleKey());
            $this->flashOnly(['email']);

            $maintenanceMsg = \Illuminate\Support\Facades\Cache::get('app_setting_maintenance_message', 'Sistem sedang dalam proses pemeliharaan berkala. Saat ini hanya Administrator yang dapat masuk ke sistem.');

            throw ValidationException::withMessages([
                'maintenance' => $maintenanceMsg,
            ]);
        }

        Auth::login($user, $this->boolean('remember'));

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
