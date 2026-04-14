<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeacherAvailability;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PiketTeacherController extends Controller
{
    /** Hari yang valid */
    private const HARI = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    /**
     * GET /api/v1/piket-teachers
     *
     * Query params:
     *   - search   : nama / NIP guru
     *   - hari     : Senin|Selasa|Rabu|Kamis|Jumat|Sabtu
     *   - status   : aktif|nonaktif (status guru)
     *   - per_page : integer (default 10)
     */
    public function index(Request $request): JsonResponse
    {
        $query = TeacherAvailability::with('teacher:id,nama_lengkap,nip,foto,status');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('teacher', fn ($q) =>
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
            );
        }

        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        if ($request->filled('status')) {
            $query->whereHas('teacher', fn ($q) =>
                $q->where('status', $request->status)
            );
        }

        $perPage = (int) $request->get('per_page', 10);

        $data = $query
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('jam_mulai')
            ->paginate($perPage);

        return response()->json([
            'status'  => true,
            'message' => 'Data jadwal guru piket berhasil diambil.',
            'data'    => $data->items(),
            'meta'    => [
                'current_page' => $data->currentPage(),
                'last_page'    => $data->lastPage(),
                'per_page'     => $data->perPage(),
                'total'        => $data->total(),
            ],
        ]);
    }

    /**
     * GET /api/v1/piket-teachers/stats/summary
     *
     * Statistik jumlah jadwal piket per hari.
     */
    public function stats(): JsonResponse
    {
        $total = TeacherAvailability::count();

        $perHari = TeacherAvailability::selectRaw('hari, COUNT(*) as jumlah')
            ->groupBy('hari')
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->pluck('jumlah', 'hari');

        // Guru aktif yang belum punya jadwal piket sama sekali
        $guruTanpaJadwal = Teacher::where('status', 'aktif')
            ->whereDoesntHave('availability')
            ->count();

        return response()->json([
            'status'  => true,
            'message' => 'Statistik jadwal guru piket berhasil diambil.',
            'data'    => [
                'total_jadwal'      => $total,
                'per_hari'          => $perHari,
                'guru_tanpa_jadwal' => $guruTanpaJadwal,
            ],
        ]);
    }

    /**
     * POST /api/v1/piket-teachers
     *
     * Body (JSON):
     * {
     *   "teacher_id"  : 1,
     *   "hari"        : "Senin",
     *   "jam_mulai"   : "07:00",
     *   "jam_selesai" : "14:00"
     * }
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'teacher_id'  => 'required|exists:teachers,id',
                'hari'        => ['required', Rule::in(self::HARI)],
                'jam_mulai'   => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        // Cegah duplikasi: guru + hari yang sama
        $exists = TeacherAvailability::where('teacher_id', $request->teacher_id)
                                      ->where('hari', $request->hari)
                                      ->exists();

        if ($exists) {
            return response()->json([
                'status'  => false,
                'message' => 'Guru ini sudah memiliki jadwal piket pada hari yang sama.',
                'errors'  => [
                    'teacher_id' => ['Duplikasi jadwal piket.'],
                ],
            ], 422);
        }

        $piket = TeacherAvailability::create([
            'teacher_id'  => $request->teacher_id,
            'hari'        => $request->hari,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        $piket->load('teacher:id,nama_lengkap,nip,foto,status');

        return response()->json([
            'status'  => true,
            'message' => 'Jadwal guru piket berhasil ditambahkan.',
            'data'    => $piket,
        ], 201);
    }

    /**
     * GET /api/v1/piket-teachers/{id}
     */
    public function show(int $id): JsonResponse
    {
        $piket = TeacherAvailability::with('teacher:id,nama_lengkap,nip,no_hp,email,foto,status')
                                     ->find($id);

        if (! $piket) {
            return response()->json([
                'status'  => false,
                'message' => 'Jadwal guru piket tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Detail jadwal guru piket berhasil diambil.',
            'data'    => $piket,
        ]);
    }

    /**
     * PUT /api/v1/piket-teachers/{id}
     *
     * Body (JSON): sama seperti store.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $piket = TeacherAvailability::find($id);

        if (! $piket) {
            return response()->json([
                'status'  => false,
                'message' => 'Jadwal guru piket tidak ditemukan.',
            ], 404);
        }

        try {
            $request->validate([
                'teacher_id'  => 'required|exists:teachers,id',
                'hari'        => ['required', Rule::in(self::HARI)],
                'jam_mulai'   => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        // Cegah duplikasi, kecuali record dirinya sendiri
        $exists = TeacherAvailability::where('teacher_id', $request->teacher_id)
                                      ->where('hari', $request->hari)
                                      ->where('id', '!=', $piket->id)
                                      ->exists();

        if ($exists) {
            return response()->json([
                'status'  => false,
                'message' => 'Guru ini sudah memiliki jadwal piket pada hari yang sama.',
                'errors'  => [
                    'teacher_id' => ['Duplikasi jadwal piket.'],
                ],
            ], 422);
        }

        $piket->update([
            'teacher_id'  => $request->teacher_id,
            'hari'        => $request->hari,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        $piket->load('teacher:id,nama_lengkap,nip,foto,status');

        return response()->json([
            'status'  => true,
            'message' => 'Jadwal guru piket berhasil diperbarui.',
            'data'    => $piket,
        ]);
    }

    /**
     * DELETE /api/v1/piket-teachers/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $piket = TeacherAvailability::find($id);

        if (! $piket) {
            return response()->json([
                'status'  => false,
                'message' => 'Jadwal guru piket tidak ditemukan.',
            ], 404);
        }

        $piket->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Jadwal guru piket berhasil dihapus.',
        ]);
    }

    /**
     * DELETE /api/v1/piket-teachers/bulk-delete
     *
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
                'ids.*' => 'exists:teacher_availability,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        DB::transaction(function () use ($request) {
            TeacherAvailability::whereIn('id', $request->ids)->delete();
        });

        return response()->json([
            'status'  => true,
            'message' => count($request->ids) . ' jadwal guru piket berhasil dihapus.',
        ]);
    }
}