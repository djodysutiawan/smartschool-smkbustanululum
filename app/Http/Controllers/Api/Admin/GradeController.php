<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Classes;

use Illuminate\Http\Request;

class GradeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Grade::with(['student', 'student.class', 'subject']);

        if ($request->filled('search')) {
            $query->whereHas('student', fn ($q) =>
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('nisn', 'like', "%{$request->search}%")
            );
        }

        $query->when($request->filled('subject_id'),
            fn ($q) => $q->where('subject_id', $request->subject_id)
        );

        $query->when($request->filled('class_id'),
            fn ($q) => $q->whereHas('student', fn ($s) =>
                $s->where('class_id', $request->class_id)
            )
        );

        $query->when($request->filled('teacher_id'),
            fn ($q) => $q->where('teacher_id', $request->teacher_id)
        );

        $grades = $query->latest()->paginate($request->get('per_page', 15));

        return response()->json([
            'status'  => true,
            'message' => 'Data nilai berhasil diambil.',
            'data'    => $grades,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'student_id'  => 'required|exists:students,id',
            'subject_id'  => 'required|exists:subjects,id',
            'teacher_id'  => 'required|exists:teachers,id',
            'nilai_tugas' => 'nullable|numeric|min:0|max:100',
            'nilai_uts'   => 'nullable|numeric|min:0|max:100',
            'nilai_uas'   => 'nullable|numeric|min:0|max:100',
        ]);

        $data = $request->only([
            'student_id', 'subject_id', 'teacher_id',
            'nilai_tugas', 'nilai_uts', 'nilai_uas',
        ]);

        $data['nilai_akhir'] = $this->hitungNilaiAkhir(
            $data['nilai_tugas'] ?? 0,
            $data['nilai_uts']   ?? 0,
            $data['nilai_uas']   ?? 0,
        );

        $grade = Grade::create($data);
        $grade->load(['student', 'subject']);

        return response()->json([
            'status'  => true,
            'message' => 'Nilai berhasil ditambahkan.',
            'data'    => $grade,
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $grade = Grade::with(['student', 'subject'])->findOrFail($id);

        return response()->json([
            'status'  => true,
            'message' => 'Detail nilai berhasil diambil.',
            'data'    => $grade,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $grade = Grade::findOrFail($id);

        $request->validate([
            'student_id'  => 'required|exists:students,id',
            'subject_id'  => 'required|exists:subjects,id',
            'teacher_id'  => 'required|exists:teachers,id',
            'nilai_tugas' => 'nullable|numeric|min:0|max:100',
            'nilai_uts'   => 'nullable|numeric|min:0|max:100',
            'nilai_uas'   => 'nullable|numeric|min:0|max:100',
        ]);

        $data = $request->only([
            'student_id', 'subject_id', 'teacher_id',
            'nilai_tugas', 'nilai_uts', 'nilai_uas',
        ]);

        $data['nilai_akhir'] = $this->hitungNilaiAkhir(
            $data['nilai_tugas'] ?? 0,
            $data['nilai_uts']   ?? 0,
            $data['nilai_uas']   ?? 0,
        );

        $grade->update($data);
        $grade->load(['student', 'subject']);

        return response()->json([
            'status'  => true,
            'message' => 'Nilai berhasil diupdate.',
            'data'    => $grade,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);
        $grade->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Nilai berhasil dihapus.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | BULK DELETE
    |--------------------------------------------------------------------------
    */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:grades,id',
        ]);

        Grade::whereIn('id', $request->ids)->delete();

        return response()->json([
            'status'  => true,
            'message' => count($request->ids) . ' nilai berhasil dihapus.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | MONITORING — Rekap nilai per kelas & mapel
    |--------------------------------------------------------------------------
    */
    public function monitoring(Request $request)
    {
        $query = Grade::with(['student.class', 'subject']);

        $query->when($request->filled('class_id'),
            fn ($q) => $q->whereHas('student', fn ($s) =>
                $s->where('class_id', $request->class_id)
            )
        );

        $query->when($request->filled('subject_id'),
            fn ($q) => $q->where('subject_id', $request->subject_id)
        );

        $grades = $query->get();

        $stats = [
            'total'       => $grades->count(),
            'avg_akhir'   => round($grades->avg('nilai_akhir'), 2),
            'avg_tugas'   => round($grades->avg('nilai_tugas'), 2),
            'avg_uts'     => round($grades->avg('nilai_uts'), 2),
            'avg_uas'     => round($grades->avg('nilai_uas'), 2),
            'lulus'       => $grades->where('nilai_akhir', '>=', 75)->count(),
            'tidak_lulus' => $grades->where('nilai_akhir', '<', 75)->count(),
        ];

        return response()->json([
            'status'  => true,
            'message' => 'Data monitoring nilai berhasil diambil.',
            'stats'   => $stats,
            'data'    => $grades->values(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER — Hitung nilai akhir
    |--------------------------------------------------------------------------
    */
    private function hitungNilaiAkhir(float $tugas, float $uts, float $uas): float
    {
        return round(($tugas * 0.30) + ($uts * 0.30) + ($uas * 0.40), 2);
    }
}