<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Teacher;

use Illuminate\Http\Request;

class ClassController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Classes::with(['waliKelas', 'students']);

        if ($request->filled('search')) {
            $query->where('nama_kelas', 'like', "%{$request->search}%");
        }

        $query->when($request->filled('tingkat'),
            fn ($q) => $q->where('tingkat', $request->tingkat)
        );

        $query->when($request->filled('jurusan'),
            fn ($q) => $q->where('jurusan', $request->jurusan)
        );

        return view('admin.classes.index', [
            'classes'  => $query->latest()->paginate(10)->withQueryString(),
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
        return view('admin.classes.create', [
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
            'nama_kelas'    => 'required|string|max:100',
            'tingkat'       => 'required|string|max:20',
            'jurusan'       => 'nullable|string|max:100',
            'wali_kelas_id' => 'nullable|exists:teachers,id',
        ]);

        Classes::create($request->only(['nama_kelas', 'tingkat', 'jurusan', 'wali_kelas_id']));

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $class = Classes::with(['waliKelas', 'students', 'schedules'])->findOrFail($id);

        return view('admin.classes.show', compact('class'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $class = Classes::findOrFail($id);

        return view('admin.classes.edit', [
            'class'    => $class,
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
        $class = Classes::findOrFail($id);

        $request->validate([
            'nama_kelas'    => 'required|string|max:100',
            'tingkat'       => 'required|string|max:20',
            'jurusan'       => 'nullable|string|max:100',
            'wali_kelas_id' => 'nullable|exists:teachers,id',
        ]);

        $class->update($request->only(['nama_kelas', 'tingkat', 'jurusan', 'wali_kelas_id']));

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Kelas berhasil diupdate.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $class = Classes::findOrFail($id);
        $class->delete();

        return back()->with('success', 'Kelas berhasil dihapus.');
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
            'ids.*' => 'exists:classes,id',
        ]);

        Classes::whereIn('id', $request->ids)->delete();

        return back()->with('success', count($request->ids) . ' kelas berhasil dihapus.');
    }
}