<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Student;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class AssignmentSubmissionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX — Semua submission dengan filter
    |--------------------------------------------------------------------------
    */
    public function index(Request $request): JsonResponse
    {
        $query = AssignmentSubmission::with(['assignment.subject', 'assignment.class', 'student'])
            ->latest('submitted_at');

        $query->when($request->filled('assignment_id'),
            fn ($q) => $q->where('assignment_id', $request->assignment_id)
        );

        $query->when($request->filled('student_id'),
            fn ($q) => $q->where('student_id', $request->student_id)
        );

        $query->when($request->filled('status'),
            fn ($q) => $q->where('status', $request->status)
        );

        $query->when($request->filled('nilai_min'),
            fn ($q) => $q->where('nilai', '>=', $request->nilai_min)
        );

        $query->when($request->filled('nilai_max'),
            fn ($q) => $q->where('nilai', '<=', $request->nilai_max)
        );

        $submissions = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data'    => $submissions,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX PER ASSIGNMENT — Submission dalam 1 tugas beserta statistik
    |--------------------------------------------------------------------------
    */
    public function byAssignment(Request $request, $assignmentId): JsonResponse
    {
        $assignment = Assignment::with(['teacher', 'subject', 'class'])->findOrFail($assignmentId);

        $submissions = AssignmentSubmission::with('student')
            ->where('assignment_id', $assignmentId)
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest('submitted_at')
            ->paginate($request->get('per_page', 20));

        $stats = [
            'total'     => AssignmentSubmission::where('assignment_id', $assignmentId)->count(),
            'submitted' => AssignmentSubmission::where('assignment_id', $assignmentId)->where('status', 'submitted')->count(),
            'graded'    => AssignmentSubmission::where('assignment_id', $assignmentId)->where('status', 'graded')->count(),
            'returned'  => AssignmentSubmission::where('assignment_id', $assignmentId)->where('status', 'returned')->count(),
            'avg_nilai' => round(AssignmentSubmission::where('assignment_id', $assignmentId)->whereNotNull('nilai')->avg('nilai'), 2),
            'max_nilai' => AssignmentSubmission::where('assignment_id', $assignmentId)->whereNotNull('nilai')->max('nilai'),
            'min_nilai' => AssignmentSubmission::where('assignment_id', $assignmentId)->whereNotNull('nilai')->min('nilai'),
        ];

        return response()->json([
            'success'     => true,
            'assignment'  => $assignment,
            'data'        => $submissions,
            'stats'       => $stats,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW — Detail satu submission
    |--------------------------------------------------------------------------
    */
    public function show($id): JsonResponse
    {
        $submission = AssignmentSubmission::with([
            'assignment.teacher',
            'assignment.subject',
            'assignment.class',
            'student',
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $submission,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE — Tambah submission baru
    |--------------------------------------------------------------------------
    */
    public function store(Request $request): JsonResponse
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
            return response()->json([
                'success' => false,
                'message' => 'Siswa ini sudah memiliki submission untuk tugas tersebut.',
                'errors'  => ['student_id' => ['Duplikat submission tidak diizinkan.']],
            ], 422);
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('submissions', 'public');
        }

        $submission = AssignmentSubmission::create([
            'assignment_id' => $request->assignment_id,
            'student_id'    => $request->student_id,
            'file_path'     => $filePath,
            'nilai'         => $request->nilai,
            'status'        => $request->status,
            'submitted_at'  => $request->submitted_at ?? now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Submission berhasil ditambahkan.',
            'data'    => $submission->load(['assignment', 'student']),
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE — Edit submission
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id): JsonResponse
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

        return response()->json([
            'success' => true,
            'message' => 'Submission berhasil diupdate.',
            'data'    => $submission->load(['assignment', 'student']),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY — Hapus submission + file
    |--------------------------------------------------------------------------
    */
    public function destroy($id): JsonResponse
    {
        $submission = AssignmentSubmission::findOrFail($id);

        if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
            Storage::disk('public')->delete($submission->file_path);
        }

        $submission->delete();

        return response()->json([
            'success' => true,
            'message' => 'Submission berhasil dihapus.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | BULK DELETE
    |--------------------------------------------------------------------------
    */
    public function bulkDelete(Request $request): JsonResponse
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

        $count = count($request->ids);
        AssignmentSubmission::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => "{$count} submission berhasil dihapus.",
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | GRADE — Beri nilai satu submission
    |--------------------------------------------------------------------------
    */
    public function grade(Request $request, $id): JsonResponse
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

        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil disimpan.',
            'data'    => $submission->load(['assignment', 'student']),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | BULK GRADE — Nilai banyak submission sekaligus
    |--------------------------------------------------------------------------
    */
    public function bulkGrade(Request $request): JsonResponse
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

        $count = count($request->grades);

        return response()->json([
            'success' => true,
            'message' => "{$count} nilai berhasil disimpan.",
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD FILE — Return URL download file submission
    |--------------------------------------------------------------------------
    */
    public function download($id): JsonResponse
    {
        $submission = AssignmentSubmission::with('student')->findOrFail($id);

        if (!$submission->file_path || !Storage::disk('public')->exists($submission->file_path)) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan.',
            ], 404);
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        return response()->json([
            'success'   => true,
            'file_url'  => $disk->url($submission->file_path),
            'file_name' => 'submission_' . $submission->student->nama . '_' . $submission->id . '.' . pathinfo($submission->file_path, PATHINFO_EXTENSION),
        ]);
    }
}