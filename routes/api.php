<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\StudentController;
use App\Http\Controllers\Api\Admin\TeacherController;
use App\Http\Controllers\Api\Admin\ParentController;
use App\Http\Controllers\Api\Admin\PiketTeacherController;
use App\Http\Controllers\Api\Admin\ClassController;
use App\Http\Controllers\Api\Admin\SubjectController;
use App\Http\Controllers\Api\Admin\AcademicYearController;
use App\Http\Controllers\Api\Admin\ScheduleController;
use App\Http\Controllers\Api\Admin\AttendanceController;
use App\Http\Controllers\Api\Admin\ViolationController;
use App\Http\Controllers\Api\Admin\ReportController;
use App\Http\Controllers\Api\Admin\NotificationController;
use App\Http\Controllers\Api\Admin\SettingController;
use App\Http\Controllers\Api\Admin\RolePermissionController;
use App\Http\Controllers\Api\Admin\MaterialController;
use App\Http\Controllers\Api\Admin\AssignmentController;
use App\Http\Controllers\Api\Admin\AssignmentSubmissionController;
use App\Http\Controllers\Api\Admin\ExamController;
use App\Http\Controllers\Api\Admin\GradeController;
use App\Http\Controllers\Api\Admin\LmsMonitoringController;

/*
|--------------------------------------------------------------------------
| API ROUTES
|--------------------------------------------------------------------------
| Versioning : v1
| Auth       : Sanctum
| Prefix     : /api/v1
|--------------------------------------------------------------------------
*/

Route::prefix('v1')
    ->middleware(['auth:sanctum', 'role:admin'])
    ->group(function () {

        /*
        |----------------------------------------------------------------------
        | STUDENTS
        |
        | PENTING: Endpoint statis (stats, export, bulk-delete) harus
        | didaftarkan SEBELUM route dengan parameter /{id} agar tidak
        | salah tangkap.
        |----------------------------------------------------------------------
        */
        Route::prefix('students')->group(function () {
            Route::get   ('stats/summary', [StudentController::class, 'stats']);
            Route::get   ('export',        [StudentController::class, 'export']);
            Route::delete('bulk-delete',   [StudentController::class, 'bulkDelete']);

            Route::get   ('',      [StudentController::class, 'index']);
            Route::post  ('',      [StudentController::class, 'store']);
            Route::get   ('{id}',  [StudentController::class, 'show']);
            Route::put   ('{id}',  [StudentController::class, 'update']);
            Route::delete('{id}',  [StudentController::class, 'destroy']);
        });

        /*
        |----------------------------------------------------------------------
        | TEACHERS — Data Guru
        |----------------------------------------------------------------------
        */
        Route::prefix('teachers')->group(function () {
            Route::get   ('stats/summary', [TeacherController::class, 'stats']);
            Route::get   ('export',        [TeacherController::class, 'export']);
            Route::delete('bulk-delete',   [TeacherController::class, 'bulkDelete']);

            Route::get   ('',      [TeacherController::class, 'index']);
            Route::post  ('',      [TeacherController::class, 'store']);
            Route::get   ('{id}',  [TeacherController::class, 'show']);
            Route::put   ('{id}',  [TeacherController::class, 'update']);
            Route::delete('{id}',  [TeacherController::class, 'destroy']);
        });

        /*
        |----------------------------------------------------------------------
        | PARENTS — Data Orang Tua
        |
        | Endpoint statis & nested harus SEBELUM /{id}.
        |----------------------------------------------------------------------
        */
        Route::prefix('parents')->group(function () {
            Route::delete('bulk-delete',   [ParentController::class, 'bulkDelete']);
            Route::get   ('{id}/students', [ParentController::class, 'students']);

            Route::get   ('',      [ParentController::class, 'index']);
            Route::post  ('',      [ParentController::class, 'store']);
            Route::get   ('{id}',  [ParentController::class, 'show']);
            Route::put   ('{id}',  [ParentController::class, 'update']);
            Route::delete('{id}',  [ParentController::class, 'destroy']);
        });

        /*
        |----------------------------------------------------------------------
        | PIKET TEACHERS — Data Guru Piket (pakai model TeacherAvailability)
        |
        | Endpoint statis harus SEBELUM /{id}.
        |----------------------------------------------------------------------
        */
        Route::prefix('piket-teachers')->group(function () {
            Route::get   ('stats/summary', [PiketTeacherController::class, 'stats']);
            Route::delete('bulk-delete',   [PiketTeacherController::class, 'bulkDelete']);

            Route::get   ('',      [PiketTeacherController::class, 'index']);
            Route::post  ('',      [PiketTeacherController::class, 'store']);
            Route::get   ('{id}',  [PiketTeacherController::class, 'show']);
            Route::put   ('{id}',  [PiketTeacherController::class, 'update']);
            Route::delete('{id}',  [PiketTeacherController::class, 'destroy']);
        });

        /*
        |----------------------------------------------------------------------
        | CLASSES
        |----------------------------------------------------------------------
        */
        Route::prefix('classes')->group(function () {
            Route::delete('bulk-delete', [ClassController::class, 'bulkDelete']);

            Route::get   ('',      [ClassController::class, 'index']);
            Route::post  ('',      [ClassController::class, 'store']);
            Route::get   ('{id}',  [ClassController::class, 'show']);
            Route::put   ('{id}',  [ClassController::class, 'update']);
            Route::delete('{id}',  [ClassController::class, 'destroy']);
        });

        /*
        |----------------------------------------------------------------------
        | SUBJECTS
        |----------------------------------------------------------------------
        */
        Route::prefix('subjects')->group(function () {
            Route::delete('bulk-delete', [SubjectController::class, 'bulkDelete']);

            Route::get   ('',      [SubjectController::class, 'index']);
            Route::post  ('',      [SubjectController::class, 'store']);
            Route::get   ('{id}',  [SubjectController::class, 'show']);
            Route::put   ('{id}',  [SubjectController::class, 'update']);
            Route::delete('{id}',  [SubjectController::class, 'destroy']);
        });

        /*
        |----------------------------------------------------------------------
        | ACADEMIC YEARS
        |
        | set-active SEBELUM /{id}.
        |----------------------------------------------------------------------
        */
        Route::prefix('academic-years')->group(function () {
            Route::patch('{id}/set-active', [AcademicYearController::class, 'setActive']);

            Route::get   ('',      [AcademicYearController::class, 'index']);
            Route::post  ('',      [AcademicYearController::class, 'store']);
            Route::get   ('{id}',  [AcademicYearController::class, 'show']);
            Route::put   ('{id}',  [AcademicYearController::class, 'update']);
            Route::delete('{id}',  [AcademicYearController::class, 'destroy']);
        });

        /*
        |----------------------------------------------------------------------
        | SCHEDULES
        |----------------------------------------------------------------------
        */
        Route::prefix('schedules')->group(function () {
            Route::delete('bulk-delete', [ScheduleController::class, 'bulkDelete']);

            Route::get   ('',      [ScheduleController::class, 'index']);
            Route::post  ('',      [ScheduleController::class, 'store']);
            Route::get   ('{id}',  [ScheduleController::class, 'show']);
            Route::put   ('{id}',  [ScheduleController::class, 'update']);
            Route::delete('{id}',  [ScheduleController::class, 'destroy']);
        });

        /*
        |----------------------------------------------------------------------
        | ATTENDANCES
        |
        | rekap/summary & bulk-delete SEBELUM /{id}.
        |----------------------------------------------------------------------
        */
        Route::prefix('attendances')->group(function () {
            Route::get   ('rekap/summary', [AttendanceController::class, 'rekap']);
            Route::delete('bulk-delete',   [AttendanceController::class, 'bulkDelete']);

            Route::get   ('',      [AttendanceController::class, 'index']);
            Route::post  ('',      [AttendanceController::class, 'store']);
            Route::get   ('{id}',  [AttendanceController::class, 'show']);
            Route::put   ('{id}',  [AttendanceController::class, 'update']);
            Route::delete('{id}',  [AttendanceController::class, 'destroy']);
        });

        /*
        |----------------------------------------------------------------------
        | VIOLATIONS
        |----------------------------------------------------------------------
        */
        Route::prefix('violations')->group(function () {
            Route::delete('bulk-delete', [ViolationController::class, 'bulkDelete']);

            Route::get   ('',      [ViolationController::class, 'index']);
            Route::post  ('',      [ViolationController::class, 'store']);
            Route::get   ('{id}',  [ViolationController::class, 'show']);
            Route::put   ('{id}',  [ViolationController::class, 'update']);
            Route::delete('{id}',  [ViolationController::class, 'destroy']);
        });

        /*
        |----------------------------------------------------------------------
        | REPORTS — Read-only (hanya GET)
        |----------------------------------------------------------------------
        */
        Route::prefix('reports')->group(function () {
            Route::get('',           [ReportController::class, 'index']);
            Route::get('attendance', [ReportController::class, 'attendance']);
            Route::get('violation',  [ReportController::class, 'violation']);
            Route::get('student',    [ReportController::class, 'student']);
        });

        /*
        |----------------------------------------------------------------------
        | NOTIFICATIONS
        |
        | Endpoint statis SEBELUM /{id}.
        |----------------------------------------------------------------------
        */
        Route::prefix('notifications')->group(function () {
            Route::patch ('mark-all-read', [NotificationController::class, 'markAllRead']);
            Route::delete('bulk-delete',   [NotificationController::class, 'bulkDelete']);
            Route::post  ('broadcast',     [NotificationController::class, 'broadcast']);

            Route::get   ('',      [NotificationController::class, 'index']);
            Route::get   ('{id}',  [NotificationController::class, 'show']);
            Route::delete('{id}',  [NotificationController::class, 'destroy']);
        });

        /*
        |----------------------------------------------------------------------
        | SETTINGS — hanya dua endpoint: ambil & simpan
        |----------------------------------------------------------------------
        */
        Route::prefix('settings')->group(function () {
            Route::get('', [SettingController::class, 'index']);
            Route::put('', [SettingController::class, 'update']);
        });

        /*
        |----------------------------------------------------------------------
        | ROLES — Manajemen Role (Spatie Permission)
        |----------------------------------------------------------------------
        */
        Route::prefix('roles')->group(function () {
            Route::get   ('',      [RolePermissionController::class, 'indexRoles']);
            Route::post  ('',      [RolePermissionController::class, 'storeRole']);
            Route::get   ('{id}',  [RolePermissionController::class, 'showRole']);
            Route::put   ('{id}',  [RolePermissionController::class, 'updateRole']);
            Route::delete('{id}',  [RolePermissionController::class, 'destroyRole']);
        });

        /*
        |----------------------------------------------------------------------
        | PERMISSIONS — Manajemen Permission (Spatie Permission)
        |----------------------------------------------------------------------
        */
        Route::prefix('permissions')->group(function () {
            Route::get   ('',      [RolePermissionController::class, 'indexPermissions']);
            Route::post  ('',      [RolePermissionController::class, 'storePermission']);
            Route::put   ('{id}',  [RolePermissionController::class, 'updatePermission']);
            Route::delete('{id}',  [RolePermissionController::class, 'destroyPermission']);
        });

        /*
        |----------------------------------------------------------------------
        | USERS — Assign & Revoke Role per User
        |----------------------------------------------------------------------
        */
        Route::prefix('users')->group(function () {
            Route::get   ('{id}/roles', [RolePermissionController::class, 'userRoles']);
            Route::post  ('{id}/roles', [RolePermissionController::class, 'assignRole']);
            Route::delete('{id}/roles', [RolePermissionController::class, 'revokeRole']);
        });

        /*
        |----------------------------------------------------------------------
        | ROLE-PERMISSION SEED
        |----------------------------------------------------------------------
        */
        Route::post('role-permission/seed', [RolePermissionController::class, 'seed']);

        /*
        |----------------------------------------------------------------------
        | LMS — MATERIALS (Semua Materi)
        |
        | PENTING: bulk-delete HARUS di atas /{id}.
        |----------------------------------------------------------------------
        */
        Route::prefix('materials')->group(function () {
            Route::delete('bulk-delete', [MaterialController::class, 'bulkDelete']);

            Route::get   ('',      [MaterialController::class, 'index']);
            Route::post  ('',      [MaterialController::class, 'store']);
            Route::get   ('{id}',  [MaterialController::class, 'show']);
            Route::put   ('{id}',  [MaterialController::class, 'update']);
            Route::delete('{id}',  [MaterialController::class, 'destroy']);
        });

        /*
        |----------------------------------------------------------------------
        | LMS — ASSIGNMENTS (Semua Tugas)
        |
        | PENTING: bulk-delete HARUS di atas /{id}.
        | gradeSubmission sudah dipindah ke AssignmentSubmissionController.
        |----------------------------------------------------------------------
        */
        Route::prefix('assignments')->group(function () {
            Route::delete('bulk-delete', [AssignmentController::class, 'bulkDelete']);

            Route::get   ('',      [AssignmentController::class, 'index']);
            Route::post  ('',      [AssignmentController::class, 'store']);
            Route::get   ('{id}',  [AssignmentController::class, 'show']);
            Route::put   ('{id}',  [AssignmentController::class, 'update']);
            Route::delete('{id}',  [AssignmentController::class, 'destroy']);
        });

        /*
        |----------------------------------------------------------------------
        | LMS — ASSIGNMENT SUBMISSIONS
        |
        | PENTING: Endpoint statis (bulk-delete, bulk-grade, by-assignment)
        | HARUS di atas /{id} agar tidak tertangkap sebagai parameter.
        |
        | DELETE /api/v1/assignment-submissions/bulk-delete              → bulkDelete
        | POST   /api/v1/assignment-submissions/bulk-grade               → bulkGrade
        | GET    /api/v1/assignment-submissions/by-assignment/{id}       → byAssignment
        | GET    /api/v1/assignment-submissions                          → index
        | POST   /api/v1/assignment-submissions                          → store
        | GET    /api/v1/assignment-submissions/{id}                     → show
        | PUT    /api/v1/assignment-submissions/{id}                     → update
        | DELETE /api/v1/assignment-submissions/{id}                     → destroy
        | PATCH  /api/v1/assignment-submissions/{id}/grade               → grade
        | GET    /api/v1/assignment-submissions/{id}/download            → download
        |----------------------------------------------------------------------
        */
        Route::prefix('assignment-submissions')->group(function () {
            Route::delete('bulk-delete',           [AssignmentSubmissionController::class, 'bulkDelete']);
            Route::post  ('bulk-grade',            [AssignmentSubmissionController::class, 'bulkGrade']);
            Route::get   ('by-assignment/{id}',    [AssignmentSubmissionController::class, 'byAssignment']);

            Route::get   ('',      [AssignmentSubmissionController::class, 'index']);
            Route::post  ('',      [AssignmentSubmissionController::class, 'store']);
            Route::get   ('{id}',  [AssignmentSubmissionController::class, 'show']);
            Route::put   ('{id}',  [AssignmentSubmissionController::class, 'update']);
            Route::delete('{id}',  [AssignmentSubmissionController::class, 'destroy']);

            Route::patch('{id}/grade',    [AssignmentSubmissionController::class, 'grade']);
            Route::get  ('{id}/download', [AssignmentSubmissionController::class, 'download']);
        });

        /*
        |----------------------------------------------------------------------
        | LMS — EXAMS (Semua Ujian)
        |
        | PENTING: bulk-delete HARUS di atas /{id}.
        |----------------------------------------------------------------------
        */
        Route::prefix('exams')->group(function () {
            Route::delete('bulk-delete', [ExamController::class, 'bulkDelete']);

            Route::get   ('',      [ExamController::class, 'index']);
            Route::post  ('',      [ExamController::class, 'store']);
            Route::get   ('{id}',  [ExamController::class, 'show']);
            Route::put   ('{id}',  [ExamController::class, 'update']);
            Route::delete('{id}',  [ExamController::class, 'destroy']);
        });

        /*
        |----------------------------------------------------------------------
        | LMS — GRADES (Nilai Siswa)
        |
        | PENTING: monitoring & bulk-delete HARUS di atas /{id}.
        |----------------------------------------------------------------------
        */
        Route::prefix('grades')->group(function () {
            Route::get   ('monitoring',  [GradeController::class, 'monitoring']);
            Route::delete('bulk-delete', [GradeController::class, 'bulkDelete']);

            Route::get   ('',      [GradeController::class, 'index']);
            Route::post  ('',      [GradeController::class, 'store']);
            Route::get   ('{id}',  [GradeController::class, 'show']);
            Route::put   ('{id}',  [GradeController::class, 'update']);
            Route::delete('{id}',  [GradeController::class, 'destroy']);
        });

        /*
        |----------------------------------------------------------------------
        | LMS — MONITORING TERPADU
        |----------------------------------------------------------------------
        */
        Route::get('lms/monitoring', [LmsMonitoringController::class, 'index']);

    });