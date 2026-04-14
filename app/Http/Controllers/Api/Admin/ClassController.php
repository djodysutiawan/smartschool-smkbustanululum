<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
// use App\Models\Teacher;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClassController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Classes::with(['waliKelas', 'students']);

        if ($request->filled('search')) {
            $query->where('nama_kelas', 'like', "%{$request->search}%");
        }

        $query->when($request->filled('tingkat'),
            fn ($q) => $q->where('tingkat', $request->tingkat)
        );

        $query->when($request->filled('jurusan'),
            fn ($q) => $q->where('jurusan', $request->jurusan)
        );

        return response()->json([
            'success' => true,
            'data'    => $query->latest()->paginate(10)->withQueryString(),
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
                'nama_kelas'    => 'required|string|max:100',
                'tingkat'       => 'required|string|max:20',
                'jurusan'       => 'nullable|string|max:100',
                'wali_kelas_id' => 'nullable|exists:teachers,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $class = Classes::create($request->only([
            'nama_kelas', 'tingkat', 'jurusan', 'wali_kelas_id',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil ditambahkan.',
            'data'    => $class->load('waliKelas'),
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $class = Classes::with(['waliKelas', 'students', 'schedules'])->find($id);

        if (! $class) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $class,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $class = Classes::find($id);

        if (! $class) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak ditemukan.',
            ], 404);
        }

        try {
            $request->validate([
                'nama_kelas'    => 'required|string|max:100',
                'tingkat'       => 'required|string|max:20',
                'jurusan'       => 'nullable|string|max:100',
                'wali_kelas_id' => 'nullable|exists:teachers,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $class->update($request->only([
            'nama_kelas', 'tingkat', 'jurusan', 'wali_kelas_id',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil diupdate.',
            'data'    => $class->fresh('waliKelas'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $class = Classes::find($id);

        if (! $class) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak ditemukan.',
            ], 404);
        }

        $class->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil dihapus.',
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
                'ids.*' => 'exists:classes,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        Classes::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => count($request->ids) . ' kelas berhasil dihapus.',
        ]);
    }
}