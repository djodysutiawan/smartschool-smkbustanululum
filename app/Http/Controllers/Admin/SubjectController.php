<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;

use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Subject::withCount('schedules');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_mapel', 'like', "%{$request->search}%")
                  ->orWhere('kode_mapel', 'like', "%{$request->search}%");
            });
        }

        return view('admin.subjects.index', [
            'subjects' => $query->latest()->paginate(10)->withQueryString(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel'  => 'required|string|max:255',
            'kode_mapel'  => 'required|string|max:20|unique:subjects,kode_mapel',
        ]);

        Subject::create($request->only(['nama_mapel', 'kode_mapel']));

        return redirect()
            ->route('admin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $subject = Subject::with('schedules.teacher', 'schedules.class')->findOrFail($id);

        return view('admin.subjects.show', compact('subject'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $subject = Subject::findOrFail($id);

        return view('admin.subjects.edit', compact('subject'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $request->validate([
            'nama_mapel'  => 'required|string|max:255',
            'kode_mapel'  => "required|string|max:20|unique:subjects,kode_mapel,{$id}",
        ]);

        $subject->update($request->only(['nama_mapel', 'kode_mapel']));

        return redirect()
            ->route('admin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil diupdate.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return back()->with('success', 'Mata pelajaran berhasil dihapus.');
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
            'ids.*' => 'exists:subjects,id',
        ]);

        Subject::whereIn('id', $request->ids)->delete();

        return back()->with('success', count($request->ids) . ' mata pelajaran berhasil dihapus.');
    }
}