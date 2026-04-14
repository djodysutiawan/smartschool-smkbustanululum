<?php

namespace App\Http\Controllers\Admin;

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
    | INDEX — Monitoring semua nilai
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

        return view('admin.grades.index', [
            'grades'   => $query->latest()->paginate(15)->withQueryString(),
            'subjects' => Subject::all(),
            'classes'  => Classes::all(),
            'teachers' => Teacher::all(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.grades.create', [
            'students' => Student::with('class')->get(),
            'subjects' => Subject::all(),
            'teachers' => Teacher::all(),
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

        // Hitung nilai akhir otomatis: 30% tugas + 30% UTS + 40% UAS
        $data['nilai_akhir'] = $this->hitungNilaiAkhir(
            $data['nilai_tugas'] ?? 0,
            $data['nilai_uts']   ?? 0,
            $data['nilai_uas']   ?? 0,
        );

        Grade::create($data);

        return redirect()
            ->route('admin.grades.index')
            ->with('success', 'Nilai berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $grade = Grade::with(['student', 'subject'])->findOrFail($id);

        return view('admin.grades.show', compact('grade'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $grade = Grade::findOrFail($id);

        return view('admin.grades.edit', [
            'grade'    => $grade,
            'students' => Student::with('class')->get(),
            'subjects' => Subject::all(),
            'teachers' => Teacher::all(),
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

        return redirect()
            ->route('admin.grades.index')
            ->with('success', 'Nilai berhasil diupdate.');
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

        return back()->with('success', 'Nilai berhasil dihapus.');
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

        return back()->with('success', count($request->ids) . ' nilai berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | MONITORING — Rekap nilai per kelas & mapel
    |--------------------------------------------------------------------------
    */
    public function monitoring(Request $request)
    {
        $query = Grade::with(['student.class', 'subject', 'student']);

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
            'total'      => $grades->count(),
            'avg_akhir'  => round($grades->avg('nilai_akhir'), 2),
            'avg_tugas'  => round($grades->avg('nilai_tugas'), 2),
            'avg_uts'    => round($grades->avg('nilai_uts'), 2),
            'avg_uas'    => round($grades->avg('nilai_uas'), 2),
            'lulus'      => $grades->where('nilai_akhir', '>=', 75)->count(),
            'tidak_lulus'=> $grades->where('nilai_akhir', '<', 75)->count(),
        ];

        return view('admin.grades.monitoring', [
            'grades'   => $grades,
            'stats'    => $stats,
            'classes'  => Classes::all(),
            'subjects' => Subject::all(),
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