<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Classes;

use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Assignment::with(['teacher', 'subject', 'class', 'submissions'])
            ->withCount('submissions');

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        $query->when($request->filled('subject_id'),
            fn ($q) => $q->where('subject_id', $request->subject_id)
        );

        $query->when($request->filled('class_id'),
            fn ($q) => $q->where('class_id', $request->class_id)
        );

        $query->when($request->filled('teacher_id'),
            fn ($q) => $q->where('teacher_id', $request->teacher_id)
        );

        // Filter berdasarkan status deadline
        $query->when($request->filled('status'), function ($q) use ($request) {
            if ($request->status === 'active') {
                $q->where('deadline', '>=', now());
            } elseif ($request->status === 'expired') {
                $q->where('deadline', '<', now());
            }
        });

        return view('admin.assignments.index', [
            'assignments' => $query->latest()->paginate(10)->withQueryString(),
            'teachers'    => Teacher::all(),
            'subjects'    => Subject::all(),
            'classes'     => Classes::all(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.assignments.create', [
            'teachers' => Teacher::all(),
            'subjects' => Subject::all(),
            'classes'  => Classes::all(),
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
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id'   => 'required|exists:classes,id',
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'deadline'   => 'required|date|after:now',
        ]);

        Assignment::create($request->only([
            'teacher_id', 'subject_id', 'class_id',
            'judul', 'deskripsi', 'deadline',
        ]));

        return redirect()
            ->route('admin.assignments.index')
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    | Perubahan: tambah eager load 'subject' dan 'class' agar data lengkap
    | di halaman detail assignment.
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $assignment = Assignment::with([
            'teacher',
            'subject',            // ← ditambahkan
            'class',              // ← ditambahkan
            'submissions.student',
        ])->findOrFail($id);

        // Statistik submission
        $stats = [
            'total'     => $assignment->submissions->count(),
            'graded'    => $assignment->submissions->where('status', 'graded')->count(),
            'submitted' => $assignment->submissions->where('status', 'submitted')->count(),
            'returned'  => $assignment->submissions->where('status', 'returned')->count(),
            'avg_nilai' => $assignment->submissions->whereNotNull('nilai')->avg('nilai'),
            'max_nilai' => $assignment->submissions->whereNotNull('nilai')->max('nilai'),
            'min_nilai' => $assignment->submissions->whereNotNull('nilai')->min('nilai'),
        ];

        return view('admin.assignments.show', compact('assignment', 'stats'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $assignment = Assignment::findOrFail($id);

        return view('admin.assignments.edit', [
            'assignment' => $assignment,
            'teachers'   => Teacher::all(),
            'subjects'   => Subject::all(),
            'classes'    => Classes::all(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);

        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id'   => 'required|exists:classes,id',
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'deadline'   => 'required|date',
        ]);

        $assignment->update($request->only([
            'teacher_id', 'subject_id', 'class_id',
            'judul', 'deskripsi', 'deadline',
        ]));

        return redirect()
            ->route('admin.assignments.index')
            ->with('success', 'Tugas berhasil diupdate.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->delete();

        return back()->with('success', 'Tugas berhasil dihapus.');
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
            'ids.*' => 'exists:assignments,id',
        ]);

        Assignment::whereIn('id', $request->ids)->delete();

        return back()->with('success', count($request->ids) . ' tugas berhasil dihapus.');
    }

    // CATATAN: method gradeSubmission() telah dipindahkan ke
    // AssignmentSubmissionController::grade() agar tanggung jawab
    // setiap controller lebih jelas dan terpisah.
}