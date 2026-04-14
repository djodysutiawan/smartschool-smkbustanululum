<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SubjectController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Subject::withCount('schedules');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_mapel', 'like', "%{$request->search}%")
                  ->orWhere('kode_mapel', 'like', "%{$request->search}%");
            });
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
                'nama_mapel' => 'required|string|max:255',
                'kode_mapel' => 'required|string|max:20|unique:subjects,kode_mapel',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $subject = Subject::create($request->only(['nama_mapel', 'kode_mapel']));

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil ditambahkan.',
            'data'    => $subject,
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $subject = Subject::with('schedules.teacher', 'schedules.class')->find($id);

        if (! $subject) {
            return response()->json([
                'success' => false,
                'message' => 'Mata pelajaran tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $subject,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $subject = Subject::find($id);

        if (! $subject) {
            return response()->json([
                'success' => false,
                'message' => 'Mata pelajaran tidak ditemukan.',
            ], 404);
        }

        try {
            $request->validate([
                'nama_mapel' => 'required|string|max:255',
                'kode_mapel' => "required|string|max:20|unique:subjects,kode_mapel,{$id}",
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $subject->update($request->only(['nama_mapel', 'kode_mapel']));

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil diupdate.',
            'data'    => $subject->fresh(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $subject = Subject::find($id);

        if (! $subject) {
            return response()->json([
                'success' => false,
                'message' => 'Mata pelajaran tidak ditemukan.',
            ], 404);
        }

        $subject->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil dihapus.',
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
                'ids.*' => 'exists:subjects,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        Subject::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => count($request->ids) . ' mata pelajaran berhasil dihapus.',
        ]);
    }
}