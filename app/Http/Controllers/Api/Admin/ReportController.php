<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Violation;
// use App\Models\Classes;
// use App\Models\AcademicYear;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX — ringkasan semua laporan
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => [
                'students'   => [
                    'total'  => Student::count(),
                    'aktif'  => Student::where('status', 'aktif')->count(),
                    'lulus'  => Student::where('status', 'lulus')->count(),
                    'pindah' => Student::where('status', 'pindah')->count(),
                ],
                'attendances' => [
                    'hadir' => Attendance::where('status', 'hadir')->count(),
                    'izin'  => Attendance::where('status', 'izin')->count(),
                    'sakit' => Attendance::where('status', 'sakit')->count(),
                    'alpha' => Attendance::where('status', 'alpha')->count(),
                ],
                'violations' => [
                    'total'      => Violation::count(),
                    'total_poin' => Violation::sum('poin'),
                ],
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ATTENDANCE REPORT
    |--------------------------------------------------------------------------
    */
    public function attendance(Request $request)
    {
        $request->validate([
            'class_id'   => 'nullable|exists:classes,id',
            'date_start' => 'nullable|date',
            'date_end'   => 'nullable|date|after_or_equal:date_start',
        ]);

        $query = Attendance::with(['student', 'class'])
            ->when($request->filled('class_id'),
                fn ($q) => $q->where('class_id', $request->class_id)
            )
            ->when($request->filled('date_start'),
                fn ($q) => $q->whereDate('date', '>=', $request->date_start)
            )
            ->when($request->filled('date_end'),
                fn ($q) => $q->whereDate('date', '<=', $request->date_end)
            );

        $summary = (clone $query)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return response()->json([
            'success' => true,
            'data'    => [
                'summary'     => $summary,
                'attendances' => $query->latest('date')->paginate(15)->withQueryString(),
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | VIOLATION REPORT
    |--------------------------------------------------------------------------
    */
    public function violation(Request $request)
    {
        $request->validate([
            'date_start' => 'nullable|date',
            'date_end'   => 'nullable|date|after_or_equal:date_start',
            'kategori'   => 'nullable|string|max:100',
        ]);

        $query = Violation::with(['student', 'teacher'])
            ->when($request->filled('date_start'),
                fn ($q) => $q->whereDate('tanggal', '>=', $request->date_start)
            )
            ->when($request->filled('date_end'),
                fn ($q) => $q->whereDate('tanggal', '<=', $request->date_end)
            )
            ->when($request->filled('kategori'),
                fn ($q) => $q->where('kategori', $request->kategori)
            );

        $topViolators = Student::withSum(
                ['violations as total_poin' => fn ($q) =>
                    $q->when($request->filled('date_start'),
                        fn ($q2) => $q2->whereDate('tanggal', '>=', $request->date_start)
                    )
                ],
                'poin'
            )
            ->having('total_poin', '>', 0)
            ->orderByDesc('total_poin')
            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => [
                'violations'   => $query->latest('tanggal')->paginate(15)->withQueryString(),
                'top_violators' => $topViolators,
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STUDENT REPORT
    |--------------------------------------------------------------------------
    */
    public function student(Request $request)
    {
        $query = Student::with(['class', 'academicYear'])
            ->when($request->filled('academic_year_id'),
                fn ($q) => $q->where('academic_year_id', $request->academic_year_id)
            )
            ->when($request->filled('class_id'),
                fn ($q) => $q->where('class_id', $request->class_id)
            )
            ->when($request->filled('status'),
                fn ($q) => $q->where('status', $request->status)
            );

        return response()->json([
            'success' => true,
            'data'    => [
                'stats' => [
                    'total'     => Student::count(),
                    'aktif'     => Student::where('status', 'aktif')->count(),
                    'lulus'     => Student::where('status', 'lulus')->count(),
                    'pindah'    => Student::where('status', 'pindah')->count(),
                    'laki_laki' => Student::where('jenis_kelamin', 'L')->count(),
                    'perempuan' => Student::where('jenis_kelamin', 'P')->count(),
                ],
                'students' => $query->latest()->paginate(15)->withQueryString(),
            ],
        ]);
    }
}