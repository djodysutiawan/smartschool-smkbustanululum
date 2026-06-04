<?php

namespace App\Http\Requests\Auth;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'identifier' => ['required', 'string'],
            'password'   => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'identifier.required' => 'Email, NIS, atau NIP wajib diisi.',
            'password.required'   => 'Password wajib diisi.',
        ];
    }

    /**
     * Resolve User dari identifier (email / NIS / NIP).
     */
    protected function resolveUser(): ?User
    {
        $identifier = $this->string('identifier')->trim()->toString();

        // 1. Coba sebagai email
        $user = User::where('email', $identifier)->first();
        if ($user) return $user;

        // 2. Coba sebagai NIS (siswa)
        $siswa = Siswa::where('nis', $identifier)->first();
        if ($siswa?->pengguna_id) {
            return User::find($siswa->pengguna_id);
        }

        // 3. Coba sebagai NIP (guru)
        $guru = Guru::where('nip', $identifier)->first();
        if ($guru?->pengguna_id) {
            return User::find($guru->pengguna_id);
        }

        return null;
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $user = $this->resolveUser();

        // Cek user ditemukan, password cocok, dan akun aktif
        $failed = ! $user
            || ! Auth::getProvider()->validateCredentials($user, ['password' => $this->string('password')->toString()])
            || ! $user->is_active;

        if ($failed) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'identifier' => __('auth.failed'),
            ]);
        }

        Auth::login($user, $this->boolean('remember'));

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'identifier' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('identifier')) . '|' . $this->ip());
    }
}