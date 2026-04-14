<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AcademicYearController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = AcademicYear::withCount('students');

        $query->when($request->filled('semester'),
            fn ($q) => $q->where('semester', $request->semester)
        );

        $query->when($request->filled('status'),
            fn ($q) => $q->where('status', $request->status)
        );

        if ($request->filled('search')) {
            $query->where('tahun', 'like', "%{$request->search}%");
        }

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
                'tahun'    => 'required|string|max:20',
                'semester' => 'required|in:Ganjil,Genap',
                'status'   => 'required|in:aktif,tidak_aktif',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        if ($request->status === 'aktif') {
            AcademicYear::where('status', 'aktif')->update(['status' => 'tidak_aktif']);
        }

        $year = AcademicYear::create($request->only(['tahun', 'semester', 'status']));

        return response()->json([
            'success' => true,
            'message' => 'Tahun ajaran berhasil ditambahkan.',
            'data'    => $year,
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $year = AcademicYear::withCount('students')->find($id);

        if (! $year) {
            return response()->json([
                'success' => false,
                'message' => 'Tahun ajaran tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $year,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $year = AcademicYear::find($id);

        if (! $year) {
            return response()->json([
                'success' => false,
                'message' => 'Tahun ajaran tidak ditemukan.',
            ], 404);
        }

        try {
            $request->validate([
                'tahun'    => 'required|string|max:20',
                'semester' => 'required|in:Ganjil,Genap',
                'status'   => 'required|in:aktif,tidak_aktif',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        if ($request->status === 'aktif') {
            AcademicYear::where('status', 'aktif')
                ->where('id', '!=', $id)
                ->update(['status' => 'tidak_aktif']);
        }

        $year->update($request->only(['tahun', 'semester', 'status']));

        return response()->json([
            'success' => true,
            'message' => 'Tahun ajaran berhasil diupdate.',
            'data'    => $year->fresh(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $year = AcademicYear::find($id);

        if (! $year) {
            return response()->json([
                'success' => false,
                'message' => 'Tahun ajaran tidak ditemukan.',
            ], 404);
        }

        $year->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tahun ajaran berhasil dihapus.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SET ACTIVE
    |--------------------------------------------------------------------------
    */
    public function setActive($id)
    {
        $year = AcademicYear::find($id);

        if (! $year) {
            return response()->json([
                'success' => false,
                'message' => 'Tahun ajaran tidak ditemukan.',
            ], 404);
        }

        AcademicYear::where('status', 'aktif')->update(['status' => 'tidak_aktif']);
        $year->update(['status' => 'aktif']);

        return response()->json([
            'success' => true,
            'message' => 'Tahun ajaran berhasil diaktifkan.',
            'data'    => $year->fresh(),
        ]);
    }
}