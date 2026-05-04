<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // ── Login ───────────────────────────────────────────────────────────────

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email'       => ['required', 'string', 'email'],
            'password'    => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:255'],
        ]);

        if (! Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        $deviceName = $request->device_name ?? ($request->userAgent() ?? 'SmartSchool');
        $user->tokens()->where('name', $deviceName)->delete();
        $token = $user->createToken($deviceName)->plainTextToken;

        $user->load($this->relationsForRole($user->role ?? ''));

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

    // ── Register ────────────────────────────────────────────────────────────

    public function register(Request $request): JsonResponse
    {
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

        $folder = match($role) {
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

        return response()->json([
            'success' => true,
            'message' => 'Avatar berhasil diperbarui.',
            'data'    => [
                'user'       => $this->formatUser($user),
                // asset() pakai APP_URL — tidak lewat PHP untuk serve file
                'avatar_url' => asset('storage/' . $path),
            ],
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

    /**
     * Format user untuk response JSON ke Flutter.
     *
     * Prioritas avatar_url:
     *   1. users.avatar  → diupload user sendiri (paling prioritas)
     *   2. guru.foto     → diisi admin di data guru
     *   3. siswa.foto    → diisi admin di data siswa
     *   4. null          → Flutter tampilkan inisial huruf
     *
     * PENTING: Gunakan asset('storage/...') bukan url('api/file/...')
     * agar file dilayani langsung oleh web server (bukan lewat PHP).
     * php artisan serve tidak stabil untuk binary streaming via PHP.
     *
     * Pastikan sudah jalankan: php artisan storage:link
     * Pastikan .env: APP_URL=http://localhost:8000
     */
    private function formatUser(User $user): array
    {
        $role = $user->role ?? 'siswa';

        // Helper — konversi path storage ke public URL via symlink
        // storage/app/public/avatars/x.png → http://localhost:8000/storage/avatars/x.png
        $storageUrl = fn (?string $path): ?string =>
            $path ? asset('storage/' . $path) : null;

        // ── Avatar priority ────────────────────────────────────────────────
        $avatarUrl = null;

        // 1. Avatar user (diupload sendiri)
        if ($user->avatar) {
            $avatarUrl = $storageUrl($user->avatar);
        }

        // 2. Foto guru
        if (! $avatarUrl && in_array($role, ['guru', 'guru_piket'])) {
            $guru = $user->relationLoaded('guru') ? $user->guru : null;
            if ($guru && $guru->foto) {
                $avatarUrl = $storageUrl($guru->foto);
            }
        }

        // 3. Foto siswa
        if (! $avatarUrl && $role === 'siswa') {
            $siswa = $user->relationLoaded('siswa') ? $user->siswa : null;
            if ($siswa && $siswa->foto) {
                $avatarUrl = $storageUrl($siswa->foto);
            }
        }

        // ── Base data ─────────────────────────────────────────────────────
        $data = [
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'role'       => $role,
            'avatar'     => $user->avatar,
            'avatar_url' => $avatarUrl,
            'created_at' => $user->created_at,
        ];

        // ── Role-specific data ─────────────────────────────────────────────
        switch ($role) {
            case 'siswa':
                $s = $user->relationLoaded('siswa') ? $user->siswa : null;
                $data['siswa'] = $s ? [
                    'id'            => $s->id,
                    'nis'           => $s->nis,
                    'nisn'          => $s->nisn,
                    'nama_lengkap'  => $s->nama_lengkap,
                    'jenis_kelamin' => $s->jenis_kelamin,
                    'tempat_lahir'  => $s->tempat_lahir,
                    'tanggal_lahir' => $s->tanggal_lahir?->format('d/m/Y'),
                    'alamat'        => $s->alamat,
                    'no_telp'       => $s->no_hp,
                    'foto'          => $s->foto,
                    'foto_url'      => $storageUrl($s->foto),
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
                    'no_telp'       => $g->no_hp,
                    'alamat'        => $g->alamat,
                    'foto'          => $g->foto,
                    'foto_url'      => $storageUrl($g->foto),
                ] : null;
                break;

            case 'orang_tua':
                $o = $user->relationLoaded('orangTua') ? $user->orangTua : null;
                $data['orang_tua'] = $o ? [
                    'id'        => $o->id,
                    'hubungan'  => $o->hubungan,
                    'pekerjaan' => $o->pekerjaan,
                    'no_telp'   => $o->no_hp,
                    'alamat'    => $o->alamat,
                ] : null;
                break;
        }

        return $data;
    }
}