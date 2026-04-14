<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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

        return response()->json([
            'success' => true,
            'data'    => $query->latest('date')->paginate(10)->withQueryString(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'class_id'   => 'required|exists:classes,id',
                'date'       => 'required|date',
                'status'     => 'required|in:hadir,izin,sakit,alpha',
                'method'     => 'nullable|in:manual,qr_code,face',
                'time_in'    => 'nullable|date_format:H:i',
                'time_out'   => 'nullable|date_format:H:i|after:time_in',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $attendance = Attendance::create($request->only([
            'student_id', 'class_id', 'date',
            'status', 'method', 'time_in', 'time_out',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Data absensi berhasil ditambahkan.',
            'data'    => $attendance->load(['student', 'class']),
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $attendance = Attendance::with(['student', 'class'])->find($id);

        if (! $attendance) {
            return response()->json([
                'success' => false,
                'message' => 'Data absensi tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $attendance,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $attendance = Attendance::find($id);

        if (! $attendance) {
            return response()->json([
                'success' => false,
                'message' => 'Data absensi tidak ditemukan.',
            ], 404);
        }

        try {
            $request->validate([
                'student_id' => 'required|exists:students,id',
                'class_id'   => 'required|exists:classes,id',
                'date'       => 'required|date',
                'status'     => 'required|in:hadir,izin,sakit,alpha',
                'method'     => 'nullable|in:manual,qr_code,face',
                'time_in'    => 'nullable|date_format:H:i',
                'time_out'   => 'nullable|date_format:H:i|after:time_in',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $attendance->update($request->only([
            'student_id', 'class_id', 'date',
            'status', 'method', 'time_in', 'time_out',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Data absensi berhasil diupdate.',
            'data'    => $attendance->fresh(['student', 'class']),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $attendance = Attendance::find($id);

        if (! $attendance) {
            return response()->json([
                'success' => false,
                'message' => 'Data absensi tidak ditemukan.',
            ], 404);
        }

        $attendance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data absensi berhasil dihapus.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | BULK DELETE
    |--------------------------------------------------------------------------
    */
    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids'   => 'required|array',
                'ids.*' => 'exists:attendances,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        Attendance::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => count($request->ids) . ' data absensi berhasil dihapus.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | REKAP
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

        return response()->json([
            'success' => true,
            'data'    => $query->paginate(10)->withQueryString(),
        ]);
    }
}