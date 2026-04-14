<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Classes;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ExamController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request): JsonResponse
    {
        $query = Exam::with(['teacher', 'subject', 'class']);

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
            if ($request->status === 'upcoming') {
                $q->where('tanggal', '>=', today());
            } elseif ($request->status === 'past') {
                $q->where('tanggal', '<', today());
            } elseif ($request->status === 'today') {
                $q->whereDate('tanggal', today());
            }
        });

        $exams = $query->latest('tanggal')->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data'    => $exams,
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
            'tanggal'    => 'required|date',
        ]);

        $exam = Exam::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ujian berhasil ditambahkan.',
            'data'    => $exam->load(['teacher', 'subject', 'class']),
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id): JsonResponse
    {
        $exam = Exam::with(['teacher', 'subject', 'class'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $exam,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id): JsonResponse
    {
        $exam = Exam::findOrFail($id);

        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id'   => 'required|exists:classes,id',
            'judul'      => 'required|string|max:255',
            'tanggal'    => 'required|date',
        ]);

        $exam->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ujian berhasil diupdate.',
            'data'    => $exam->load(['teacher', 'subject', 'class']),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id): JsonResponse
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ujian berhasil dihapus.',
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
            'ids.*' => 'exists:exams,id',
        ]);

        $count = count($request->ids);
        Exam::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => "{$count} ujian berhasil dihapus.",
        ]);
    }
}