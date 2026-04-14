<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentSubmissionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX — Semua submission (opsional filter per assignment)
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = AssignmentSubmission::with(['assignment.subject', 'assignment.class', 'student'])
            ->latest('submitted_at');

        // Filter by assignment
        $query->when($request->filled('assignment_id'),
            fn ($q) => $q->where('assignment_id', $request->assignment_id)
        );

        // Filter by student
        $query->when($request->filled('student_id'),
            fn ($q) => $q->where('student_id', $request->student_id)
        );

        // Filter by status (submitted / graded / returned)
        $query->when($request->filled('status'),
            fn ($q) => $q->where('status', $request->status)
        );

        // Filter by nilai range
        $query->when($request->filled('nilai_min'),
            fn ($q) => $q->where('nilai', '>=', $request->nilai_min)
        );
        $query->when($request->filled('nilai_max'),
            fn ($q) => $q->where('nilai', '<=', $request->nilai_max)
        );

        return view('admin.assignment-submissions.index', [
            'submissions' => $query->paginate(15)->withQueryString(),
            'assignments' => Assignment::with('subject')->latest()->get(),
            'students'    => Student::orderBy('nama_lengkap')->get(),
            'statusList'  => ['submitted' => 'Submitted', 'graded' => 'Graded', 'returned' => 'Returned'],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX PER ASSIGNMENT — Daftar submission dalam 1 tugas
    |--------------------------------------------------------------------------
    */
    public function byAssignment(Request $request, $assignmentId)
    {
        $assignment = Assignment::with(['teacher', 'subject', 'class'])->findOrFail($assignmentId);

        $submissions = AssignmentSubmission::with('student')
            ->where('assignment_id', $assignmentId)
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest('submitted_at')
            ->paginate(20)
            ->withQueryString();

        // Statistik
        $stats = [
            'total'       => $submissions->total(),
            'submitted'   => AssignmentSubmission::where('assignment_id', $assignmentId)->where('status', 'submitted')->count(),
            'graded'      => AssignmentSubmission::where('assignment_id', $assignmentId)->where('status', 'graded')->count(),
            'returned'    => AssignmentSubmission::where('assignment_id', $assignmentId)->where('status', 'returned')->count(),
            'avg_nilai'   => AssignmentSubmission::where('assignment_id', $assignmentId)->whereNotNull('nilai')->avg('nilai'),
            'max_nilai'   => AssignmentSubmission::where('assignment_id', $assignmentId)->whereNotNull('nilai')->max('nilai'),
            'min_nilai'   => AssignmentSubmission::where('assignment_id', $assignmentId)->whereNotNull('nilai')->min('nilai'),
        ];

        return view('admin.assignment-submissions.by-assignment', compact('assignment', 'submissions', 'stats'));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW — Detail satu submission
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $submission = AssignmentSubmission::with([
            'assignment.teacher',
            'assignment.subject',
            'assignment.class',
            'student',
        ])->findOrFail($id);

        return view('admin.assignment-submissions.show', compact('submission'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE — Form submit tugas (admin/guru menambahkan submission manual)
    |--------------------------------------------------------------------------
    */
    public function create(Request $request)
    {
        $assignmentId = $request->query('assignment_id');
        $assignment   = $assignmentId ? Assignment::with('class.students')->findOrFail($assignmentId) : null;

        return view('admin.assignment-submissions.create', [
            'assignments' => Assignment::with(['subject', 'class'])->latest()->get(),
            'students'    => Student::orderBy('nama_lengkap')->get(),
            'assignment'  => $assignment,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE — Simpan submission baru
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'student_id'    => 'required|exists:students,id',
            'file'          => 'nullable|file|mimes:pdf,doc,docx,zip,png,jpg,jpeg|max:10240',
            'nilai'         => 'nullable|numeric|min:0|max:100',
            'status'        => 'required|in:submitted,graded,returned',
            'submitted_at'  => 'nullable|date',
        ]);

        // Cek duplikat submission
        $exists = AssignmentSubmission::where('assignment_id', $request->assignment_id)
            ->where('student_id', $request->student_id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['student_id' => 'Siswa ini sudah memiliki submission untuk tugas tersebut.']);
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('submissions', 'public');
        }

        AssignmentSubmission::create([
            'assignment_id' => $request->assignment_id,
            'student_id'    => $request->student_id,
            'file_path'     => $filePath,
            'nilai'         => $request->nilai,
            'status'        => $request->status,
            'submitted_at'  => $request->submitted_at ?? now(),
        ]);

        return redirect()
            ->route('admin.assignment-submissions.by-assignment', $request->assignment_id)
            ->with('success', 'Submission berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $submission = AssignmentSubmission::with(['assignment.subject', 'student'])->findOrFail($id);

        return view('admin.assignment-submissions.edit', [
            'submission'  => $submission,
            'assignments' => Assignment::with('subject')->latest()->get(),
            'students'    => Student::orderBy('nama_lengkap')->get(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $submission = AssignmentSubmission::findOrFail($id);

        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'student_id'    => 'required|exists:students,id',
            'file'          => 'nullable|file|mimes:pdf,doc,docx,zip,png,jpg,jpeg|max:10240',
            'nilai'         => 'nullable|numeric|min:0|max:100',
            'status'        => 'required|in:submitted,graded,returned',
            'submitted_at'  => 'nullable|date',
        ]);

        $filePath = $submission->file_path;
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file')->store('submissions', 'public');
        }

        $submission->update([
            'assignment_id' => $request->assignment_id,
            'student_id'    => $request->student_id,
            'file_path'     => $filePath,
            'nilai'         => $request->nilai,
            'status'        => $request->status,
            'submitted_at'  => $request->submitted_at,
        ]);

        return redirect()
            ->route('admin.assignment-submissions.show', $submission->id)
            ->with('success', 'Submission berhasil diupdate.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY — Hapus satu submission + file-nya
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $submission = AssignmentSubmission::findOrFail($id);
        $assignmentId = $submission->assignment_id;

        if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
            Storage::disk('public')->delete($submission->file_path);
        }

        $submission->delete();

        return redirect()
            ->route('admin.assignment-submissions.by-assignment', $assignmentId)
            ->with('success', 'Submission berhasil dihapus.');
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
            'ids.*' => 'exists:assignment_submissions,id',
        ]);

        $submissions = AssignmentSubmission::whereIn('id', $request->ids)->get();

        foreach ($submissions as $submission) {
            if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
                Storage::disk('public')->delete($submission->file_path);
            }
        }

        AssignmentSubmission::whereIn('id', $request->ids)->delete();

        return back()->with('success', count($request->ids) . ' submission berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | GRADE — Beri nilai satu submission
    |--------------------------------------------------------------------------
    */
    public function grade(Request $request, $id)
    {
        $request->validate([
            'nilai'  => 'required|numeric|min:0|max:100',
            'status' => 'required|in:graded,returned',
        ]);

        $submission = AssignmentSubmission::findOrFail($id);
        $submission->update([
            'nilai'  => $request->nilai,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Nilai berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | BULK GRADE — Nilai banyak submission sekaligus
    |--------------------------------------------------------------------------
    */
    public function bulkGrade(Request $request)
    {
        $request->validate([
            'grades'          => 'required|array',
            'grades.*.id'     => 'required|exists:assignment_submissions,id',
            'grades.*.nilai'  => 'required|numeric|min:0|max:100',
            'grades.*.status' => 'required|in:graded,returned',
        ]);

        foreach ($request->grades as $grade) {
            AssignmentSubmission::where('id', $grade['id'])->update([
                'nilai'  => $grade['nilai'],
                'status' => $grade['status'],
            ]);
        }

        return back()->with('success', count($request->grades) . ' nilai berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD FILE submission
    |--------------------------------------------------------------------------
    */
    public function download($id)
    {
        $submission = AssignmentSubmission::findOrFail($id);

        if (!$submission->file_path || !Storage::disk('public')->exists($submission->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        return $disk->download(
            $submission->file_path,
            'submission_' . $submission->student->nama_lengkap . '_' . $submission->id . '.' . pathinfo($submission->file_path, PATHINFO_EXTENSION)
        );
    }
}