<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ParentController extends Controller
{
    /**
     * Display a listing of parents.
     */
    public function index(Request $request)
    {
        $query = ParentModel::with(['user', 'students']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email',       'like', "%{$search}%")
                  ->orWhere('no_hp',       'like', "%{$search}%");
            });
        }

        $parents = $query->latest()->paginate(10)->withQueryString();

        return view('admin.parents.index', compact('parents'));
    }

    /**
     * Show form to create a new parent.
     */
    public function create()
    {
        // Daftar siswa untuk dihubungkan ke orang tua
        $students = Student::orderBy('nama_lengkap')->get();

        return view('admin.parents.create', compact('students'));
    }

    /**
     * Store a newly created parent in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp'        => 'required|string|max:20',
            'email'        => 'required|email|unique:users,email',
            'alamat'       => 'nullable|string',
            'password'     => 'required|string|min:8|confirmed',
            // Relasi ke siswa (opsional)
            'students'     => 'nullable|array',
            'students.*'   => 'exists:students,id',
            'hubungan'     => 'nullable|array',
            'hubungan.*'   => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat akun User
            $user = User::create([
                'name'     => $request->nama_lengkap,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Assign role 'parent' jika menggunakan Spatie
            if (method_exists($user, 'assignRole')) {
                $user->assignRole('parent');
            }

            // 2. Buat data ParentModel
            $parent = ParentModel::create([
                'user_id'      => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'no_hp'        => $request->no_hp,
                'email'        => $request->email,
                'alamat'       => $request->alamat,
            ]);

            // 3. Hubungkan ke siswa (pivot student_parent)
            if ($request->filled('students')) {
                $syncData = [];
                foreach ($request->students as $index => $studentId) {
                    $syncData[$studentId] = [
                        'hubungan' => $request->hubungan[$index] ?? null,
                    ];
                }
                $parent->students()->sync($syncData);
            }
        });

        return redirect()
            ->route('admin.parents.index')
            ->with('success', 'Data orang tua berhasil ditambahkan.');
    }

    /**
     * Display the specified parent.
     */
    public function show(ParentModel $parent)
    {
        $parent->load(['user', 'students.class']);

        return view('admin.parents.show', compact('parent'));
    }

    /**
     * Show the form for editing the specified parent.
     */
    public function edit(ParentModel $parent)
    {
        $parent->load(['user', 'students']);
        $students = Student::orderBy('nama_lengkap')->get();

        return view('admin.parents.edit', compact('parent', 'students'));
    }

    /**
     * Update the specified parent in storage.
     */
    public function update(Request $request, ParentModel $parent)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp'        => 'required|string|max:20',
            'email'        => ['required', 'email', Rule::unique('users', 'email')->ignore($parent->user_id)],
            'alamat'       => 'nullable|string',
            'password'     => 'nullable|string|min:8|confirmed',
            'students'     => 'nullable|array',
            'students.*'   => 'exists:students,id',
            'hubungan'     => 'nullable|array',
            'hubungan.*'   => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($request, $parent) {
            // 1. Update User
            $userData = [
                'name'  => $request->nama_lengkap,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $parent->user->update($userData);

            // 2. Update ParentModel
            $parent->update([
                'nama_lengkap' => $request->nama_lengkap,
                'no_hp'        => $request->no_hp,
                'email'        => $request->email,
                'alamat'       => $request->alamat,
            ]);

            // 3. Sync relasi siswa
            $syncData = [];
            if ($request->filled('students')) {
                foreach ($request->students as $index => $studentId) {
                    $syncData[$studentId] = [
                        'hubungan' => $request->hubungan[$index] ?? null,
                    ];
                }
            }
            $parent->students()->sync($syncData);
        });

        return redirect()
            ->route('admin.parents.index')
            ->with('success', 'Data orang tua berhasil diperbarui.');
    }

    /**
     * Remove the specified parent from storage.
     */
    public function destroy(ParentModel $parent)
    {
        DB::transaction(function () use ($parent) {
            // Detach semua relasi siswa terlebih dahulu
            $parent->students()->detach();

            // Hapus user terkait
            if ($parent->user) {
                $parent->user->delete();
            }

            // Hapus data parent
            $parent->delete();
        });

        return redirect()
            ->route('admin.parents.index')
            ->with('success', 'Data orang tua berhasil dihapus.');
    }

    /**
     * Bulk delete parents.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:parents,id',
        ]);

        DB::transaction(function () use ($request) {
            $parents = ParentModel::with('user')->whereIn('id', $request->ids)->get();

            foreach ($parents as $parent) {
                $parent->students()->detach();

                if ($parent->user) {
                    $parent->user->delete();
                }

                $parent->delete();
            }
        });

        return redirect()
            ->route('admin.parents.index')
            ->with('success', count($request->ids) . ' data orang tua berhasil dihapus.');
    }
}