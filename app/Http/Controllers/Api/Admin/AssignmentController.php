<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Classes;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AssignmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request): JsonResponse
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

        $query->when($request->filled('status'), function ($q) use ($request) {
            if ($request->status === 'active') {
                $q->where('deadline', '>=', now());
            } elseif ($request->status === 'expired') {
                $q->where('deadline', '<', now());
            }
        });

        $assignments = $query->latest()->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data'    => $assignments,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id'   => 'required|exists:classes,id',
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'deadline'   => 'required|date|after:now',
        ]);

        $assignment = Assignment::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil ditambahkan.',
            'data'    => $assignment->load(['teacher', 'subject', 'class']),
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id): JsonResponse
    {
        $assignment = Assignment::with([
            'teacher',
            'subject',
            'class',
            'submissions.student',
        ])->findOrFail($id);

        $stats = [
            'total'     => $assignment->submissions->count(),
            'graded'    => $assignment->submissions->where('status', 'graded')->count(),
            'submitted' => $assignment->submissions->where('status', 'submitted')->count(),
            'returned'  => $assignment->submissions->where('status', 'returned')->count(),
            'avg_nilai' => round($assignment->submissions->whereNotNull('nilai')->avg('nilai'), 2),
            'max_nilai' => $assignment->submissions->whereNotNull('nilai')->max('nilai'),
            'min_nilai' => $assignment->submissions->whereNotNull('nilai')->min('nilai'),
        ];

        return response()->json([
            'success' => true,
            'data'    => $assignment,
            'stats'   => $stats,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id): JsonResponse
    {
        $assignment = Assignment::findOrFail($id);

        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id'   => 'required|exists:classes,id',
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'deadline'   => 'required|date',
        ]);

        $assignment->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil diupdate.',
            'data'    => $assignment->load(['teacher', 'subject', 'class']),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id): JsonResponse
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dihapus.',
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
            'ids.*' => 'exists:assignments,id',
        ]);

        $count = count($request->ids);
        Assignment::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => "{$count} tugas berhasil dihapus.",
        ]);
    }
}