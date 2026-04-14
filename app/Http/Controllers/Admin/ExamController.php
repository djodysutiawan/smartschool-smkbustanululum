<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Classes;

use Illuminate\Http\Request;

class ExamController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
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

        // Filter berdasarkan status tanggal ujian
        $query->when($request->filled('status'), function ($q) use ($request) {
            if ($request->status === 'upcoming') {
                $q->where('tanggal', '>=', today());
            } elseif ($request->status === 'past') {
                $q->where('tanggal', '<', today());
            } elseif ($request->status === 'today') {
                $q->whereDate('tanggal', today());
            }
        });

        return view('admin.exams.index', [
            'exams'    => $query->latest('tanggal')->paginate(10)->withQueryString(),
            'teachers' => Teacher::all(),
            'subjects' => Subject::all(),
            'classes'  => Classes::all(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.exams.create', [
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
            'tanggal'    => 'required|date',
        ]);

        Exam::create($request->only([
            'teacher_id', 'subject_id', 'class_id', 'judul', 'tanggal',
        ]));

        return redirect()
            ->route('admin.exams.index')
            ->with('success', 'Ujian berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $exam = Exam::with(['teacher', 'subject', 'class'])->findOrFail($id);

        return view('admin.exams.show', compact('exam'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $exam = Exam::findOrFail($id);

        return view('admin.exams.edit', [
            'exam'     => $exam,
            'teachers' => Teacher::all(),
            'subjects' => Subject::all(),
            'classes'  => Classes::all(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);

        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id'   => 'required|exists:classes,id',
            'judul'      => 'required|string|max:255',
            'tanggal'    => 'required|date',
        ]);

        $exam->update($request->only([
            'teacher_id', 'subject_id', 'class_id', 'judul', 'tanggal',
        ]));

        return redirect()
            ->route('admin.exams.index')
            ->with('success', 'Ujian berhasil diupdate.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();

        return back()->with('success', 'Ujian berhasil dihapus.');
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
            'ids.*' => 'exists:exams,id',
        ]);

        Exam::whereIn('id', $request->ids)->delete();

        return back()->with('success', count($request->ids) . ' ujian berhasil dihapus.');
    }
}