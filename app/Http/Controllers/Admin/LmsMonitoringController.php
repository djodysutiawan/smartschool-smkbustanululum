<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Exam;
use App\Models\Grade;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;

use Illuminate\Http\Request;

class LmsMonitoringController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX — Dashboard monitoring LMS terpadu
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $stats = [
            'total_materi'      => Material::count(),
            'total_tugas'       => Assignment::count(),
            'total_ujian'       => Exam::count(),
            'total_submission'  => AssignmentSubmission::count(),
            'submission_graded' => AssignmentSubmission::where('status', 'graded')->count(),
            'tugas_aktif'       => Assignment::where('deadline', '>=', now())->count(),
            'tugas_expired'     => Assignment::where('deadline', '<', now())->count(),
            'ujian_upcoming'    => Exam::where('tanggal', '>=', today())->count(),
            'ujian_today'       => Exam::whereDate('tanggal', today())->count(),
        ];

        // Tugas terbaru beserta jumlah submission
        $latestAssignments = Assignment::with(['teacher', 'submissions'])
            ->withCount('submissions')
            ->latest()
            ->take(5)
            ->get();

        // Ujian mendatang
        $upcomingExams = Exam::with(['teacher', 'subject', 'class'])
            ->where('tanggal', '>=', today())
            ->orderBy('tanggal')
            ->take(5)
            ->get();

        // Materi terbaru
        $latestMaterials = Material::with(['teacher', 'subject', 'class'])
            ->latest()
            ->take(5)
            ->get();

        // Submission yang belum dinilai
        $pendingSubmissions = AssignmentSubmission::with(['assignment', 'student'])
            ->where('status', 'submitted')
            ->latest('submitted_at')
            ->take(10)
            ->get();

        return view('admin.lms.monitoring', compact(
            'stats',
            'latestAssignments',
            'upcomingExams',
            'latestMaterials',
            'pendingSubmissions',
        ));
    }
}