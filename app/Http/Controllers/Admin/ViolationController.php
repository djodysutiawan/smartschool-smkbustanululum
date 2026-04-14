<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Violation;
use App\Models\Student;
use App\Models\Teacher;

use Illuminate\Http\Request;

class ViolationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Violation::with(['student', 'teacher']);

        if ($request->filled('search')) {
            $query->whereHas('student', fn ($q) =>
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                  ->orWhere('nis', 'like', "%{$request->search}%")
            );
        }

        $query->when($request->filled('kategori'),
            fn ($q) => $q->where('kategori', $request->kategori)
        );

        $query->when($request->filled('teacher_id'),
            fn ($q) => $q->where('teacher_id', $request->teacher_id)
        );

        $query->when($request->filled('tanggal'),
            fn ($q) => $q->whereDate('tanggal', $request->tanggal)
        );

        return view('admin.violations.index', [
            'violations' => $query->latest('tanggal')->paginate(10)->withQueryString(),
            'teachers'   => Teacher::all(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.violations.create', [
            'students' => Student::all(),
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
            'student_id' => 'required|exists:students,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'kategori'   => 'required|string|max:100',
            'poin'       => 'required|integer|min:1',
            'deskripsi'  => 'nullable|string|max:1000',
            'tanggal'    => 'required|date',
        ]);

        Violation::create($request->only([
            'student_id', 'teacher_id', 'kategori',
            'poin', 'deskripsi', 'tanggal',
        ]));

        return redirect()
            ->route('admin.violations.index')
            ->with('success', 'Data pelanggaran berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $violation = Violation::with(['student', 'teacher'])->findOrFail($id);

        return view('admin.violations.show', compact('violation'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $violation = Violation::findOrFail($id);

        return view('admin.violations.edit', [
            'violation' => $violation,
            'students'  => Student::all(),
            'teachers'  => Teacher::all(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $violation = Violation::findOrFail($id);

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'kategori'   => 'required|string|max:100',
            'poin'       => 'required|integer|min:1',
            'deskripsi'  => 'nullable|string|max:1000',
            'tanggal'    => 'required|date',
        ]);

        $violation->update($request->only([
            'student_id', 'teacher_id', 'kategori',
            'poin', 'deskripsi', 'tanggal',
        ]));

        return redirect()
            ->route('admin.violations.index')
            ->with('success', 'Data pelanggaran berhasil diupdate.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        Violation::findOrFail($id)->delete();

        return back()->with('success', 'Data pelanggaran berhasil dihapus.');
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
            'ids.*' => 'exists:violations,id',
        ]);

        Violation::whereIn('id', $request->ids)->delete();

        return back()->with('success', count($request->ids) . ' data pelanggaran berhasil dihapus.');
    }
}