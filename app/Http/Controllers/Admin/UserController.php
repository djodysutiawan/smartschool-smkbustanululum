<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    private array $roles = ['admin', 'guru', 'siswa', 'orang_tua', 'guru_piket'];

    private function validasiPesan(): array
    {
        return [
            'name.required'          => 'Nama wajib diisi.',
            'name.max'               => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'email.unique'           => 'Email sudah digunakan, gunakan email lain.',
            'password.required'      => 'Kata sandi wajib diisi.',
            'password.min'           => 'Kata sandi minimal 8 karakter.',
            'role.required'          => 'Peran wajib dipilih.',
            'role.in'                => 'Peran yang dipilih tidak valid.',
            'no_hp.max'              => 'Nomor HP tidak boleh lebih dari 20 karakter.',
            'avatar.image'           => 'Foto profil harus berupa gambar.',
            'avatar.mimes'           => 'Foto profil harus berformat JPG atau PNG.',
            'avatar.max'             => 'Ukuran foto profil tidak boleh lebih dari 2 MB.',
        ];
    }

    public function index(Request $request)
    {
        $query = User::query()->withTrashed();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%{$search}%")
                                      ->orWhere('email', 'like', "%{$search}%"));
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total'    => User::count(),
            'aktif'    => User::where('is_active', true)->count(),
            'nonaktif' => User::where('is_active', false)->count(),
            'terhapus' => User::onlyTrashed()->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function create()
    {
        return view('admin.users.create', ['roles' => $this->roles]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'unique:users,email'],
            'password'  => ['required', Password::min(8)->mixedCase()->numbers()],
            'role'      => ['required', Rule::in($this->roles)],
            'no_hp'     => ['nullable', 'string', 'max:20'],
            'is_active' => ['boolean'],
            'avatar'    => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], $this->validasiPesan());

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $user = User::create($validated);
        $user->assignRole($validated['role']);

        return redirect()->route('admin.users.index')
            ->with('success', "Pengguna {$user->name} berhasil ditambahkan.");
    }

    public function show(User $user)
    {
        $user->load([
            'guru',
            'siswa',
            'orangTua',
            'notifikasi' => fn($q) => $q->latest()->limit(10),
        ]);

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user, 'roles' => $this->roles]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'role'      => ['required', Rule::in($this->roles)],
            'no_hp'     => ['nullable', 'string', 'max:20'],
            'is_active' => ['boolean'],
            'avatar'    => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], $this->validasiPesan());

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $user->update($validated);
        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Pengguna {$user->name} berhasil dihapus.");
    }

    public function restore(int $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return back()->with('success', "Pengguna {$user->name} berhasil dipulihkan.");
    }

    public function forceDelete(int $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->forceDelete();

        return back()->with('success', 'Pengguna berhasil dihapus secara permanen.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', Password::min(8)->mixedCase()->numbers(), 'confirmed'],
        ], [
            'password.required'  => 'Kata sandi baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min'       => 'Kata sandi minimal 8 karakter.',
        ]);

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Kata sandi berhasil direset.');
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Pengguna berhasil {$status}.");
    }
}