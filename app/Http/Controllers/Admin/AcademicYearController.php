<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;

use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = AcademicYear::withCount('students');

        if ($request->filled('search')) {
            $query->where('tahun', 'like', "%{$request->search}%");
        }

        $query->when($request->filled('semester'),
            fn ($q) => $q->where('semester', $request->semester)
        );

        $query->when($request->filled('status'),
            fn ($q) => $q->where('status', $request->status)
        );

        return view('admin.academic-years.index', [
            'years' => $query->latest()->paginate(10)->withQueryString(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.academic-years.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'tahun'    => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'status'   => 'required|in:aktif,tidak_aktif',
        ]);

        // Jika status aktif, nonaktifkan tahun ajaran lain terlebih dahulu
        if ($request->status === 'aktif') {
            AcademicYear::where('status', 'aktif')->update(['status' => 'tidak_aktif']);
        }

        AcademicYear::create($request->only(['tahun', 'semester', 'status']));

        return redirect()
            ->route('admin.academic-years.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $year = AcademicYear::withCount('students')->findOrFail($id);

        return view('admin.academic-years.show', compact('year'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $year = AcademicYear::findOrFail($id);

        return view('admin.academic-years.edit', compact('year'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $year = AcademicYear::findOrFail($id);

        $request->validate([
            'tahun'    => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'status'   => 'required|in:aktif,tidak_aktif',
        ]);

        // Jika status diubah menjadi aktif, nonaktifkan yang lain
        if ($request->status === 'aktif') {
            AcademicYear::where('status', 'aktif')
                ->where('id', '!=', $id)
                ->update(['status' => 'tidak_aktif']);
        }

        $year->update($request->only(['tahun', 'semester', 'status']));

        return redirect()
            ->route('admin.academic-years.index')
            ->with('success', 'Tahun ajaran berhasil diupdate.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $year = AcademicYear::findOrFail($id);
        $year->delete();

        return back()->with('success', 'Tahun ajaran berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | SET ACTIVE — shortcut aktivasi langsung dari index
    |--------------------------------------------------------------------------
    */
    public function setActive($id)
    {
        AcademicYear::where('status', 'aktif')->update(['status' => 'tidak_aktif']);
        AcademicYear::findOrFail($id)->update(['status' => 'aktif']);

        return back()->with('success', 'Tahun ajaran berhasil diaktifkan.');
    }
}