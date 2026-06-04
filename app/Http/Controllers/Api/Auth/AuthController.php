<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ── Login ───────────────────────────────────────────────────────────────

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'identifier'  => ['required', 'string'],   // email atau NIS
            'password'    => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:255'],
        ]);

        // Resolve user dari email atau NIS
        $user = $this->resolveUser($request->string('identifier')->trim()->toString());

        // Validasi: user ditemukan, password cocok, akun aktif
        $failed = ! $user
            || ! Hash::check($request->string('password')->toString(), $user->password)
            || ! $user->is_active;

        if ($failed) {
            throw ValidationException::withMessages([
                'identifier' => ['Email/NIS atau password salah.'],
            ]);
        }

        // Hanya siswa dan orang_tua yang boleh login via Flutter
        $allowedRoles = ['siswa', 'orang_tua'];
        if (! in_array($user->role, $allowedRoles)) {
            throw ValidationException::withMessages([
                'identifier' => ['Akun ini tidak memiliki akses ke aplikasi.'],
            ]);
        }

        // Revoke token lama dengan nama perangkat yang sama, lalu buat baru
        $deviceName = $request->device_name ?? ($request->userAgent() ?? 'SmartSchool');
        $user->tokens()->where('name', $deviceName)->delete();
        $token = $user->createToken($deviceName)->plainTextToken;

        $user->updateLastLogin();
        $user->load($this->relationsForRole($user->role));

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data'    => [
                'token'      => $token,
                'token_type' => 'Bearer',
                'user'       => $this->formatUser($user),
            ],
        ]);
    }

    // ── Resolve User dari identifier (email / NIS) ──────────────────────────

    /**
     * Cari User berdasarkan:
     *  1. Email  → langsung di tabel users
     *  2. NIS    → tabel siswas → pengguna_id
     *
     * NIP (guru) sengaja tidak dimasukkan karena guru tidak boleh
     * login via aplikasi Flutter.
     */
    private function resolveUser(string $identifier): ?User
    {
        // 1. Coba sebagai email
        $user = User::where('email', $identifier)->first();
        if ($user) {
            return $user;
        }

        // 2. Coba sebagai NIS (siswa)
        $siswa = Siswa::where('nis', $identifier)->first();
        if ($siswa?->pengguna_id) {
            return User::find($siswa->pengguna_id);
        }

        return null;
    }

    // ── Register ────────────────────────────────────────────────────────────

    public function register(Request $request): JsonResponse
    {
        if (! config('app.allow_public_register', false)) {
            return response()->json([
                'success' => false,
                'message' => 'Registrasi publik tidak diizinkan. Hubungi administrator.',
            ], 403);
        }

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        /** @var User $user */
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        event(new Registered($user));

        $deviceName = $request->device_name ?? ($request->userAgent() ?? 'SmartSchool');
        $token = $user->createToken($deviceName)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil.',
            'data'    => [
                'token'      => $token,
                'token_type' => 'Bearer',
                'user'       => $this->formatUser($user),
            ],
        ], 201);
    }

    // ── Logout ──────────────────────────────────────────────────────────────

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ]);
    }

    public function logoutAll(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout dari semua perangkat berhasil.',
        ]);
    }

    // ── Me ───────────────────────────────────────────────────────────────────

    public function me(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $user->load($this->relationsForRole($user->role ?? ''));

        return response()->json([
            'success' => true,
            'data'    => ['user' => $this->formatUser($user)],
        ]);
    }

    // ── Update Profile ───────────────────────────────────────────────────────

    public function updateProfile(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $validated = $request->validate([
            'name'  => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'lowercase', 'email', 'max:255',
                        'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);
        $user->load($this->relationsForRole($user->role ?? ''));

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'data'    => ['user' => $this->formatUser($user->fresh())],
        ]);
    }

    // ── Update Password ──────────────────────────────────────────────────────

    public function updatePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        /** @var User $user */
        $user = $request->user();

        if (! Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Password saat ini tidak sesuai.'],
            ]);
        }

        $user->update(['password' => Hash::make($request->password)]);

        $user->tokens()
             ->where('id', '!=', $request->user()->currentAccessToken()->id)
             ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diperbarui.',
        ]);
    }

    // ── Upload Avatar ────────────────────────────────────────────────────────

    public function uploadAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'avatar' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        /** @var User $user */
        $user = $request->user();
        $role = $user->role ?? 'siswa';

        $folder = match ($role) {
            'siswa'              => 'siswa/foto',
            'guru', 'guru_piket' => 'guru/foto',
            default              => 'avatars',
        };

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store($folder, 'public');

        $user->update(['avatar' => $path]);
        $user->refresh();
        $user->load($this->relationsForRole($role));

        $avatarApiUrl = $this->toApiFileUrl($path);

        return response()->json([
            'success' => true,
            'message' => 'Avatar berhasil diperbarui.',
            'data'    => [
                'user'       => $this->formatUser($user),
                'avatar_url' => $avatarApiUrl,
            ],
        ]);
    }

    // ── Serve File ───────────────────────────────────────────────────────────

    public function serveFile(Request $request, string $path): StreamedResponse
    {
        $normalizedPath = $this->normalizePath($path);

        if ($normalizedPath === null) {
            abort(400, 'Path tidak valid.');
        }

        $fullPath = storage_path('app/public/' . $normalizedPath);

        if (! file_exists($fullPath) || ! is_file($fullPath)) {
            abort(404, 'File tidak ditemukan.');
        }

        $mimeType = mime_content_type($fullPath) ?: 'application/octet-stream';
        $fileSize = filesize($fullPath);
        $stream   = fopen($fullPath, 'rb');

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
            fclose($stream);
        }, 200, [
            'Content-Type'                 => $mimeType,
            'Content-Length'               => $fileSize,
            'Access-Control-Allow-Origin'  => '*',
            'Access-Control-Allow-Methods' => 'GET, OPTIONS',
            'Access-Control-Allow-Headers' => '*',
            'Cache-Control'                => 'private, max-age=3600',
        ]);
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    private function relationsForRole(string $role): array
    {
        return match ($role) {
            'siswa'               => ['siswa.kelas'],
            'guru', 'guru_piket'  => ['guru'],
            'orang_tua'           => ['orangTua'],
            default               => [],
        };
    }

    private function normalizePath(string $path): ?string
    {
        $path = ltrim($path, '/');

        if (str_contains($path, '..') || str_contains($path, "\0")) {
            return null;
        }

        $basePath     = storage_path('app/public');
        $resolvedBase = realpath($basePath);
        $fullPath     = $basePath . DIRECTORY_SEPARATOR . $path;

        if (file_exists($fullPath)) {
            $resolvedFull = realpath($fullPath);
            if ($resolvedFull === false || ! str_starts_with($resolvedFull, $resolvedBase)) {
                return null;
            }
        }

        return $path;
    }

    private function toApiFileUrl(?string $storagePath): ?string
    {
        if (! $storagePath) {
            return null;
        }

        return url('api/file/' . ltrim($storagePath, '/'));
    }

    private function formatUser(User $user): array
    {
        $role    = $user->role ?? 'siswa';
        $fileUrl = fn (?string $path): ?string => $this->toApiFileUrl($path);

        $avatarUrl = null;

        if ($user->avatar) {
            $avatarUrl = $fileUrl($user->avatar);
        }

        if (! $avatarUrl && in_array($role, ['guru', 'guru_piket'])) {
            $guru = $user->relationLoaded('guru') ? $user->guru : null;
            if ($guru?->foto) {
                $avatarUrl = $fileUrl($guru->foto);
            }
        }

        if (! $avatarUrl && $role === 'siswa') {
            $siswa = $user->relationLoaded('siswa') ? $user->siswa : null;
            if ($siswa?->foto) {
                $avatarUrl = $fileUrl($siswa->foto);
            }
        }

        $data = [
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'role'       => $role,
            'avatar'     => $user->avatar,
            'avatar_url' => $avatarUrl,
            'created_at' => $user->created_at,
        ];

        switch ($role) {
            case 'siswa':
                $s = $user->relationLoaded('siswa') ? $user->siswa : null;
                $data['siswa'] = $s ? [
                    'id'            => $s->id,
                    'nis'           => $s->nis,
                    'nisn'          => $s->nisn ?? null,
                    'nama_lengkap'  => $s->nama_lengkap,
                    'jenis_kelamin' => $s->jenis_kelamin,
                    'tempat_lahir'  => $s->tempat_lahir,
                    'tanggal_lahir' => $s->tanggal_lahir?->format('d/m/Y'),
                    'alamat'        => $s->alamat,
                    'no_telp'       => $s->no_hp ?? null,
                    'kelas'         => $s->kelas?->nama_kelas,
                    'kelas_id'      => $s->kelas?->id,
                    'foto'          => $s->foto,
                    'foto_url'      => $fileUrl($s->foto),
                ] : null;
                break;

            case 'guru':
            case 'guru_piket':
                $g = $user->relationLoaded('guru') ? $user->guru : null;
                $data['guru'] = $g ? [
                    'id'            => $g->id,
                    'nip'           => $g->nip,
                    'nama_lengkap'  => $g->nama_lengkap,
                    'jenis_kelamin' => $g->jenis_kelamin,
                    'no_telp'       => $g->no_hp ?? null,
                    'alamat'        => $g->alamat,
                    'foto'          => $g->foto,
                    'foto_url'      => $fileUrl($g->foto),
                ] : null;
                break;

            case 'orang_tua':
                $o = $user->relationLoaded('orangTua') ? $user->orangTua : null;
                $data['orang_tua'] = $o ? [
                    'id'           => $o->id,
                    'nama_lengkap' => $o->nama ?? $user->name,
                    'hubungan'     => $o->hubungan,
                    'pekerjaan'    => $o->pekerjaan,
                    'no_telp'      => $o->no_hp ?? null,
                    'alamat'       => $o->alamat,
                ] : null;
                break;
        }

        return $data;
    }

    // ── Forgot Password ──────────────────────────────────────────────────────

    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // Cek apakah email terdaftar dan role-nya siswa atau orang_tua
        $user = User::where('email', $request->email)->first();

        if (! $user || ! in_array($user->role, ['siswa', 'orang_tua'])) {
            // Pesan generik agar tidak mengekspos apakah email terdaftar atau tidak
            return response()->json([
                'success' => true,
                'message' => 'Jika email terdaftar, link reset password telah dikirim.',
            ]);
        }

        $status = Password::sendResetLink(
            ['email' => $request->email]
        );

        if ($status !== Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim link reset. Coba beberapa saat lagi.',
            ], 429);
        }

        return response()->json([
            'success' => true,
            'message' => 'Jika email terdaftar, link reset password telah dikirim.',
        ]);
    }

    // ── Reset Password ───────────────────────────────────────────────────────

    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token'    => ['required', 'string'],
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                // Cabut semua token Sanctum agar semua sesi lama tidak bisa dipakai
                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            $errorMessage = match ($status) {
                Password::INVALID_TOKEN => 'Token tidak valid atau sudah kadaluarsa.',
                Password::INVALID_USER  => 'Email tidak ditemukan.',
                Password::RESET_THROTTLED => 'Terlalu banyak percobaan. Coba beberapa saat lagi.',
                default                 => 'Reset password gagal.',
            };

            return response()->json([
                'success' => false,
                'message' => $errorMessage,
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil direset. Silakan login dengan password baru.',
        ]);
    }
}