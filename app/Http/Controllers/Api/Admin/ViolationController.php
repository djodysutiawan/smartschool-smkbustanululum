<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Violation;
// use App\Models\Student;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ViolationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Violation::with(['student', 'teacher']);

        if ($request->filled('search')) {
            $query->whereHas('student', fn ($q) =>
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                  ->orWhere('nis', 'like', "%{$request->search}%")
            );
        }

        $query->when($request->filled('kategori'),
            fn ($q) => $q->where('kategori', $request->kategori)
        );

        $query->when($request->filled('teacher_id'),
            fn ($q) => $q->where('teacher_id', $request->teacher_id)
        );

        $query->when($request->filled('tanggal'),
            fn ($q) => $q->whereDate('tanggal', $request->tanggal)
        );

        return response()->json([
            'success' => true,
            'data'    => $query->latest('tanggal')->paginate(10)->withQueryString(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'teacher_id' => 'nullable|exists:teachers,id',
                'kategori'   => 'required|string|max:100',
                'poin'       => 'required|integer|min:1',
                'deskripsi'  => 'nullable|string|max:1000',
                'tanggal'    => 'required|date',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $violation = Violation::create($request->only([
            'student_id', 'teacher_id', 'kategori',
            'poin', 'deskripsi', 'tanggal',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Data pelanggaran berhasil ditambahkan.',
            'data'    => $violation->load(['student', 'teacher']),
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $violation = Violation::with(['student', 'teacher'])->find($id);

        if (! $violation) {
            return response()->json([
                'success' => false,
                'message' => 'Data pelanggaran tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $violation,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $violation = Violation::find($id);

        if (! $violation) {
            return response()->json([
                'success' => false,
                'message' => 'Data pelanggaran tidak ditemukan.',
            ], 404);
        }

        try {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'teacher_id' => 'nullable|exists:teachers,id',
                'kategori'   => 'required|string|max:100',
                'poin'       => 'required|integer|min:1',
                'deskripsi'  => 'nullable|string|max:1000',
                'tanggal'    => 'required|date',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $violation->update($request->only([
            'student_id', 'teacher_id', 'kategori',
            'poin', 'deskripsi', 'tanggal',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Data pelanggaran berhasil diupdate.',
            'data'    => $violation->fresh(['student', 'teacher']),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $violation = Violation::find($id);

        if (! $violation) {
            return response()->json([
                'success' => false,
                'message' => 'Data pelanggaran tidak ditemukan.',
            ], 404);
        }

        $violation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data pelanggaran berhasil dihapus.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | BULK DELETE
    |--------------------------------------------------------------------------
    */
    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids'   => 'required|array',
                'ids.*' => 'exists:violations,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        Violation::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => count($request->ids) . ' data pelanggaran berhasil dihapus.',
        ]);
    }
}