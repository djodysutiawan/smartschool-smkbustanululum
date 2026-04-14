<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ParentController extends Controller
{
    /**
     * Display a listing of parents.
     *
     * GET /api/admin/parents
     * Query params:
     *   - search  : string  (nama_lengkap | email | no_hp)
     *   - per_page: integer (default 10)
     *   - page    : integer
     */
    public function index(Request $request): JsonResponse
    {
        $query = ParentModel::with(['user', 'students:id,nama_lengkap,nis']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email',      'like', "%{$search}%")
                  ->orWhere('no_hp',      'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->get('per_page', 10);
        $parents = $query->latest()->paginate($perPage);

        return response()->json([
            'status'  => true,
            'message' => 'Data orang tua berhasil diambil.',
            'data'    => $parents->items(),
            'meta'    => [
                'current_page' => $parents->currentPage(),
                'last_page'    => $parents->lastPage(),
                'per_page'     => $parents->perPage(),
                'total'        => $parents->total(),
            ],
        ]);
    }

    /**
     * Store a newly created parent.
     *
     * POST /api/admin/parents
     * Body (JSON):
     * {
     *   "nama_lengkap": "Budi Santoso",
     *   "no_hp"       : "08123456789",
     *   "email"       : "budi@example.com",
     *   "password"    : "secret123",
     *   "password_confirmation": "secret123",
     *   "alamat"      : "Jl. Merdeka No. 1",
     *   "students"    : [1, 3],          // opsional — array student id
     *   "hubungan"    : ["Ayah", "Paman"] // opsional — index sejajar dengan students
     * }
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'nama_lengkap'          => 'required|string|max:255',
                'no_hp'                 => 'required|string|max:20',
                'email'                 => 'required|email|unique:users,email',
                'alamat'                => 'nullable|string',
                'password'              => 'required|string|min:8|confirmed',
                'students'              => 'nullable|array',
                'students.*'            => 'exists:students,id',
                'hubungan'              => 'nullable|array',
                'hubungan.*'            => 'nullable|string|max:50',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $parent = DB::transaction(function () use ($request) {
            // 1. Buat akun User
            $user = User::create([
                'name'     => $request->nama_lengkap,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Assign role 'parent' jika menggunakan Spatie Permission
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

            // 3. Sync relasi ke tabel pivot student_parent
            if ($request->filled('students')) {
                $syncData = [];
                foreach ($request->students as $index => $studentId) {
                    $syncData[$studentId] = [
                        'hubungan' => $request->hubungan[$index] ?? null,
                    ];
                }
                $parent->students()->sync($syncData);
            }

            return $parent->load(['user', 'students:id,nama_lengkap,nis']);
        });

        return response()->json([
            'status'  => true,
            'message' => 'Data orang tua berhasil ditambahkan.',
            'data'    => $parent,
        ], 201);
    }

    /**
     * Display the specified parent.
     *
     * GET /api/admin/parents/{parent}
     */
    public function show(ParentModel $parent): JsonResponse
    {
        $parent->load([
            'user',
            'students' => fn ($q) => $q->select('students.id', 'nama_lengkap', 'nis', 'class_id')
                                       ->with('class:id,nama_kelas'),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Detail orang tua berhasil diambil.',
            'data'    => $parent,
        ]);
    }

    /**
     * Update the specified parent.
     *
     * PUT/PATCH /api/admin/parents/{parent}
     * Body (JSON): sama seperti store, password opsional saat update.
     */
    public function update(Request $request, ParentModel $parent): JsonResponse
    {
        try {
            $request->validate([
                'nama_lengkap'          => 'required|string|max:255',
                'no_hp'                 => 'required|string|max:20',
                'email'                 => ['required', 'email', Rule::unique('users', 'email')->ignore($parent->user_id)],
                'alamat'                => 'nullable|string',
                'password'              => 'nullable|string|min:8|confirmed',
                'students'              => 'nullable|array',
                'students.*'            => 'exists:students,id',
                'hubungan'              => 'nullable|array',
                'hubungan.*'            => 'nullable|string|max:50',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $parent = DB::transaction(function () use ($request, $parent) {
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

            // 3. Sync pivot (kosongkan jika students tidak dikirim)
            $syncData = [];
            if ($request->filled('students')) {
                foreach ($request->students as $index => $studentId) {
                    $syncData[$studentId] = [
                        'hubungan' => $request->hubungan[$index] ?? null,
                    ];
                }
            }
            $parent->students()->sync($syncData);

            return $parent->fresh(['user', 'students:id,nama_lengkap,nis']);
        });

        return response()->json([
            'status'  => true,
            'message' => 'Data orang tua berhasil diperbarui.',
            'data'    => $parent,
        ]);
    }

    /**
     * Remove the specified parent.
     *
     * DELETE /api/admin/parents/{parent}
     */
    public function destroy(ParentModel $parent): JsonResponse
    {
        DB::transaction(function () use ($parent) {
            $parent->students()->detach();

            if ($parent->user) {
                $parent->user->delete();
            }

            $parent->delete();
        });

        return response()->json([
            'status'  => true,
            'message' => 'Data orang tua berhasil dihapus.',
        ]);
    }

    /**
     * Bulk delete parents.
     *
     * DELETE /api/admin/parents/bulk-delete
     * Body (JSON):
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids'   => 'required|array|min:1',
                'ids.*' => 'exists:parents,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

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

        return response()->json([
            'status'  => true,
            'message' => count($request->ids) . ' data orang tua berhasil dihapus.',
        ]);
    }

    /**
     * Get list of students linked to a specific parent.
     *
     * GET /api/admin/parents/{parent}/students
     */
    public function students(ParentModel $parent): JsonResponse
    {
        $students = $parent->students()
            ->with('class:id,nama_kelas')
            ->select('students.id', 'nama_lengkap', 'nis', 'nisn', 'class_id', 'status')
            ->get()
            ->map(function ($student) {
                return [
                    'id'           => $student->id,
                    'nama_lengkap' => $student->nama_lengkap,
                    'nis'          => $student->nis,
                    'nisn'         => $student->nisn,
                    'kelas'        => $student->class->nama_kelas ?? '-',
                    'status'       => $student->status,
                    'hubungan'     => $student->pivot->hubungan,
                ];
            });

        return response()->json([
            'status'  => true,
            'message' => 'Daftar siswa orang tua berhasil diambil.',
            'data'    => $students,
        ]);
    }
}