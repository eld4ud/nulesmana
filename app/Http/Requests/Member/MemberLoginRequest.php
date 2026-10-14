<?php

namespace App\Http\Requests\Member;

use App\Models\User;
use App\Support\Phone;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MemberLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login_type' => ['required', Rule::in(['email', 'phone', 'nia', 'username'])],
            'login'      => ['required', 'string', 'max:100'],
            'password'   => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'login.required'    => 'Isi data masuk Anda.',
            'password.required' => 'Isi password Anda.',
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $user = $this->findUser();

        // Cek password dulu supaya status akun tidak bocor ke orang yang bukan pemiliknya.
        if (! $user || ! Hash::check($this->string('password')->toString(), $user->password)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => 'Data masuk atau password salah.',
            ]);
        }

        if ($user->status !== 'approved') {
            throw ValidationException::withMessages([
                'login' => $user->status === 'pending'
                    ? 'Pendaftaran Anda masih menunggu verifikasi pengurus.'
                    : 'Akun Anda belum aktif. Hubungi pengurus ranting.',
            ]);
        }

        Auth::login($user, $this->boolean('remember'));

        RateLimiter::clear($this->throttleKey());
    }

    private function findUser(): ?User
    {
        $value = trim($this->string('login')->toString());

        // Hanya akun anggota. Akun admin masuk lewat halaman login admin.
        $query = User::query()->where('role', 'member');

        return match ($this->input('login_type')) {
            'email'    => $query->whereRaw('lower(email) = ?', [Str::lower($value)])->first(),
            'phone'    => $query->whereHas('member', fn ($q) => $q->where('phone', Phone::normalize($value)))->first(),
            'nia'      => $query->whereRaw('upper(nia) = ?', [Str::upper($value)])->first(),
            default    => $query->whereRaw('lower(username) = ?', [Str::lower($value)])->first(),
        };
    }

    private function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => 'Terlalu banyak percobaan. Coba lagi dalam '.$seconds.' detik.',
        ]);
    }

    private function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower($this->input('login_type').'|'.$this->input('login')).'|'.$this->ip()
        );
    }
}
