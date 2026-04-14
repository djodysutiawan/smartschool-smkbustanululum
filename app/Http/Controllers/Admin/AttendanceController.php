<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Classes;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Attendance::with(['student', 'class']);

        if ($request->filled('search')) {
            $query->whereHas('student', fn ($q) =>
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                  ->orWhere('nis', 'like', "%{$request->search}%")
            );
        }

        $query->when($request->filled('class_id'),
            fn ($q) => $q->where('class_id', $request->class_id)
        );

        $query->when($request->filled('status'),
            fn ($q) => $q->where('status', $request->status)
        );

        $query->when($request->filled('date'),
            fn ($q) => $q->whereDate('date', $request->date)
        );

        $query->when($request->filled('method'),
            fn ($q) => $q->where('method', $request->method)
        );

        return view('admin.attendances.index', [
            'attendances' => $query->latest('date')->paginate(10)->withQueryString(),
            'classes'     => Classes::all(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE — input absensi manual
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.attendances.create', [
            'students' => Student::all(),
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
            'student_id' => 'required|exists:students,id',
            'class_id'   => 'required|exists:classes,id',
            'date'       => 'required|date',
            'status'     => 'required|in:hadir,izin,sakit,alpha',
            'method'     => 'nullable|in:manual,qr_code,face',
            'time_in'    => 'nullable|date_format:H:i',
            'time_out'   => 'nullable|date_format:H:i|after:time_in',
        ]);

        Attendance::create($request->only([
            'student_id', 'class_id', 'date',
            'status', 'method', 'time_in', 'time_out',
        ]));

        return redirect()
            ->route('admin.attendances.index')
            ->with('success', 'Data absensi berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $attendance = Attendance::with(['student', 'class'])->findOrFail($id);

        return view('admin.attendances.show', compact('attendance'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);

        return view('admin.attendances.edit', [
            'attendance' => $attendance,
            'students'   => Student::all(),
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
        $attendance = Attendance::findOrFail($id);

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'class_id'   => 'required|exists:classes,id',
            'date'       => 'required|date',
            'status'     => 'required|in:hadir,izin,sakit,alpha',
            'method'     => 'nullable|in:manual,qr_code,face',
            'time_in'    => 'nullable|date_format:H:i',
            'time_out'   => 'nullable|date_format:H:i|after:time_in',
        ]);

        $attendance->update($request->only([
            'student_id', 'class_id', 'date',
            'status', 'method', 'time_in', 'time_out',
        ]));

        return redirect()
            ->route('admin.attendances.index')
            ->with('success', 'Data absensi berhasil diupdate.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        Attendance::findOrFail($id)->delete();

        return back()->with('success', 'Data absensi berhasil dihapus.');
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
            'ids.*' => 'exists:attendances,id',
        ]);

        Attendance::whereIn('id', $request->ids)->delete();

        return back()->with('success', count($request->ids) . ' data absensi berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | REKAP — ringkasan absensi per siswa / per kelas
    |--------------------------------------------------------------------------
    */
    public function rekap(Request $request)
    {
        $query = Attendance::with(['student', 'class'])
            ->selectRaw('student_id, class_id,
                COUNT(*) as total,
                SUM(status = "hadir") as hadir,
                SUM(status = "izin")  as izin,
                SUM(status = "sakit") as sakit,
                SUM(status = "alpha") as alpha')
            ->groupBy('student_id', 'class_id');

        $query->when($request->filled('class_id'),
            fn ($q) => $q->where('class_id', $request->class_id)
        );

        return view('admin.attendances.rekap', [
            'rekap'   => $query->paginate(10)->withQueryString(),
            'classes' => Classes::all(),
        ]);
    }
}