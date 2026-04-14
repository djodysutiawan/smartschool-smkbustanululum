<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\Admin\PiketTeacherController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ViolationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\AssignmentSubmissionController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\LmsMonitoringController;

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {

        /*
        |----------------------------------------------------------------------
        | DASHBOARD
        |----------------------------------------------------------------------
        */
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        /*
        |----------------------------------------------------------------------
        | ROLE & PERMISSION — Halaman utama
        |
        | Route /users digunakan sebagai halaman Role & Permission karena
        | sudah terdaftar di sidebar dengan nama route admin.users.
        |----------------------------------------------------------------------
        */
        Route::get('/users', [RolePermissionController::class, 'index'])
            ->name('users');

        /*
        |----------------------------------------------------------------------
        | ROLES
        |
        | PENTING: Tidak pakai Route::resource karena Spatie menggunakan
        | model binding berbeda. Route didaftarkan manual satu per satu.
        |----------------------------------------------------------------------
        */
        Route::post('roles',              [RolePermissionController::class, 'storeRole'])
            ->name('roles.store');

        Route::put('roles/{role}',        [RolePermissionController::class, 'updateRole'])
            ->name('roles.update');

        Route::delete('roles/{role}',     [RolePermissionController::class, 'destroyRole'])
            ->name('roles.destroy');

        /*
        |----------------------------------------------------------------------
        | PERMISSIONS
        |
        | PENTING: 'permissions/bulk' harus SEBELUM 'permissions/{permission}'
        | agar kata "bulk" tidak ditangkap sebagai parameter.
        |----------------------------------------------------------------------
        */
        Route::post('permissions/bulk',              [RolePermissionController::class, 'bulkStorePermission'])
            ->name('permissions.bulk');

        Route::post('permissions',                   [RolePermissionController::class, 'storePermission'])
            ->name('permissions.store');

        Route::put('permissions/{permission}',        [RolePermissionController::class, 'updatePermission'])
            ->name('permissions.update');

        Route::delete('permissions/{permission}',     [RolePermissionController::class, 'destroyPermission'])
            ->name('permissions.destroy');

        /*
        |----------------------------------------------------------------------
        | ASSIGN ROLE KE USER
        |
        | PENTING: Semua route statis ('users', 'assign', 'revoke', 'seed')
        | harus SEBELUM route dengan parameter agar tidak bertabrakan.
        |----------------------------------------------------------------------
        */
        Route::get('role-permission/users',          [RolePermissionController::class, 'users'])
            ->name('role-permission.users');

        Route::post('role-permission/assign',        [RolePermissionController::class, 'assignRole'])
            ->name('role-permission.assign');

        Route::delete('role-permission/revoke',      [RolePermissionController::class, 'revokeRole'])
            ->name('role-permission.revoke');

        Route::post('role-permission/seed',          [RolePermissionController::class, 'seed'])
            ->name('role-permission.seed');

        /*
        |----------------------------------------------------------------------
        | STUDENTS
        |
        | PENTING: Route statis (export, bulk-delete) harus didaftarkan
        | SEBELUM Route::resource agar tidak tertangkap sebagai {student}.
        |----------------------------------------------------------------------
        */
        Route::get('students/export/excel',          [StudentController::class, 'export'])
            ->name('students.export');

        Route::delete('students/bulk/delete',        [StudentController::class, 'bulkDelete'])
            ->name('students.bulkDelete');

        Route::resource('students', StudentController::class);

        /*
        |----------------------------------------------------------------------
        | TEACHERS — Data Guru
        |----------------------------------------------------------------------
        */
        Route::delete('teachers/bulk/delete',        [TeacherController::class, 'bulkDelete'])
            ->name('teachers.bulkDelete');

        Route::resource('teachers', TeacherController::class);

        /*
        |----------------------------------------------------------------------
        | PARENTS — Data Orang Tua
        |
        | Route statis HARUS di atas Route::resource.
        |----------------------------------------------------------------------
        */
        Route::get('parents/export/excel',           [ParentController::class, 'export'])
            ->name('parents.export');

        Route::delete('parents/bulk/delete',         [ParentController::class, 'bulkDelete'])
            ->name('parents.bulkDelete');

        Route::resource('parents', ParentController::class);

        /*
        |----------------------------------------------------------------------
        | PIKET TEACHERS — Data Guru Piket (pakai model TeacherAvailability)
        |
        | Route statis HARUS di atas Route::resource.
        |----------------------------------------------------------------------
        */
        Route::delete('piket-teachers/bulk/delete',  [PiketTeacherController::class, 'bulkDelete'])
            ->name('piket-teachers.bulkDelete');

        Route::resource('piket-teachers', PiketTeacherController::class);

        /*
        |----------------------------------------------------------------------
        | CLASSES
        |----------------------------------------------------------------------
        */
        Route::delete('classes/bulk/delete',         [ClassController::class, 'bulkDelete'])
            ->name('classes.bulkDelete');

        Route::resource('classes', ClassController::class);

        /*
        |----------------------------------------------------------------------
        | SUBJECTS
        |----------------------------------------------------------------------
        */
        Route::delete('subjects/bulk/delete',        [SubjectController::class, 'bulkDelete'])
            ->name('subjects.bulkDelete');

        Route::resource('subjects', SubjectController::class);

        /*
        |----------------------------------------------------------------------
        | ACADEMIC YEARS
        |
        | set-active HARUS sebelum Route::resource.
        |----------------------------------------------------------------------
        */
        Route::patch('academic-years/{id}/set-active', [AcademicYearController::class, 'setActive'])
            ->name('academic-years.setActive');

        Route::resource('academic-years', AcademicYearController::class);

        /*
        |----------------------------------------------------------------------
        | SCHEDULES
        |----------------------------------------------------------------------
        */
        Route::delete('schedules/bulk/delete',       [ScheduleController::class, 'bulkDelete'])
            ->name('schedules.bulkDelete');

        Route::resource('schedules', ScheduleController::class);

        /*
        |----------------------------------------------------------------------
        | ATTENDANCES
        |
        | Route statis (rekap, bulk-delete) HARUS di atas Route::resource
        | agar tidak tertangkap sebagai parameter {attendance}.
        |----------------------------------------------------------------------
        */
        Route::get('attendances/rekap/summary',      [AttendanceController::class, 'rekap'])
            ->name('attendances.rekap');

        Route::delete('attendances/bulk/delete',     [AttendanceController::class, 'bulkDelete'])
            ->name('attendances.bulkDelete');

        Route::resource('attendances', AttendanceController::class);

        /*
        |----------------------------------------------------------------------
        | VIOLATIONS
        |----------------------------------------------------------------------
        */
        Route::delete('violations/bulk/delete',      [ViolationController::class, 'bulkDelete'])
            ->name('violations.bulkDelete');

        Route::resource('violations', ViolationController::class);

        /*
        |----------------------------------------------------------------------
        | REPORTS
        |
        | Tidak pakai resource karena hanya read-only (GET).
        |----------------------------------------------------------------------
        */
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/',           [ReportController::class, 'index'])      ->name('index');
            Route::get('/attendance', [ReportController::class, 'attendance']) ->name('attendance');
            Route::get('/violation',  [ReportController::class, 'violation'])  ->name('violation');
            Route::get('/student',    [ReportController::class, 'student'])    ->name('student');
        });

        /*
        |----------------------------------------------------------------------
        | NOTIFICATIONS
        |
        | Route statis (mark-all-read, bulk-delete, broadcast) HARUS
        | di atas Route::resource agar tidak tertangkap sebagai parameter.
        |----------------------------------------------------------------------
        */
        Route::patch('notifications/mark-all-read',  [NotificationController::class, 'markAllRead'])
            ->name('notifications.markAllRead');

        Route::delete('notifications/bulk/delete',   [NotificationController::class, 'bulkDelete'])
            ->name('notifications.bulkDelete');

        Route::post('notifications/broadcast',       [NotificationController::class, 'broadcast'])
            ->name('notifications.broadcast');

        Route::resource('notifications', NotificationController::class)
            ->only(['index', 'show', 'destroy']);

        /*
        |----------------------------------------------------------------------
        | SETTINGS
        |
        | Hanya butuh dua route: tampilkan form & simpan.
        |----------------------------------------------------------------------
        */
        Route::get('settings',  [SettingController::class, 'index']) ->name('settings.index');
        Route::put('settings',  [SettingController::class, 'update'])->name('settings.update');

        /*
        |----------------------------------------------------------------------
        | LMS — MATERIALS (Semua Materi)
        |
        | PENTING: Route statis (bulk-delete) HARUS di atas Route::resource
        | agar tidak tertangkap sebagai parameter {material}.
        |----------------------------------------------------------------------
        */
        Route::delete('materials/bulk/delete',       [MaterialController::class, 'bulkDelete'])
            ->name('materials.bulkDelete');

        Route::resource('materials', MaterialController::class);

        /*
        |----------------------------------------------------------------------
        | LMS — ASSIGNMENTS (Semua Tugas)
        |
        | PENTING: Route statis (bulk-delete) HARUS di atas Route::resource.
        | gradeSubmission sudah dipindah ke AssignmentSubmissionController.
        |----------------------------------------------------------------------
        */
        Route::delete('assignments/bulk/delete',     [AssignmentController::class, 'bulkDelete'])
            ->name('assignments.bulkDelete');

        Route::resource('assignments', AssignmentController::class);

        /*
        |----------------------------------------------------------------------
        | LMS — ASSIGNMENT SUBMISSIONS
        |
        | PENTING: Semua route statis (bulk-delete, bulk-grade, by-assignment)
        | HARUS di atas Route::resource agar tidak tertangkap sebagai
        | parameter {assignment_submission}.
        |----------------------------------------------------------------------
        */
        Route::delete('assignment-submissions/bulk/delete',     [AssignmentSubmissionController::class, 'bulkDelete'])
            ->name('assignment-submissions.bulkDelete');

        Route::post('assignment-submissions/bulk/grade',        [AssignmentSubmissionController::class, 'bulkGrade'])
            ->name('assignment-submissions.bulkGrade');

        Route::get('assignment-submissions/by-assignment/{id}', [AssignmentSubmissionController::class, 'byAssignment'])
            ->name('assignment-submissions.byAssignment');

        Route::patch('assignment-submissions/{id}/grade',       [AssignmentSubmissionController::class, 'grade'])
            ->name('assignment-submissions.grade');

        Route::get('assignment-submissions/{id}/download',      [AssignmentSubmissionController::class, 'download'])
            ->name('assignment-submissions.download');

        Route::resource('assignment-submissions', AssignmentSubmissionController::class);

        /*
        |----------------------------------------------------------------------
        | LMS — EXAMS (Semua Ujian)
        |
        | PENTING: Route statis (bulk-delete) HARUS di atas Route::resource.
        |----------------------------------------------------------------------
        */
        Route::delete('exams/bulk/delete',           [ExamController::class, 'bulkDelete'])
            ->name('exams.bulkDelete');

        Route::resource('exams', ExamController::class);

        /*
        |----------------------------------------------------------------------
        | LMS — GRADES (Nilai Siswa)
        |
        | PENTING: Route statis (monitoring, bulk-delete) HARUS di atas
        | Route::resource agar tidak tertangkap sebagai parameter {grade}.
        |----------------------------------------------------------------------
        */
        Route::get('grades/monitoring',              [GradeController::class, 'monitoring'])
            ->name('grades.monitoring');

        Route::delete('grades/bulk/delete',          [GradeController::class, 'bulkDelete'])
            ->name('grades.bulkDelete');

        Route::resource('grades', GradeController::class);

        /*
        |----------------------------------------------------------------------
        | LMS — MONITORING (Dashboard LMS Terpadu)
        |
        | Hanya satu route GET, tidak perlu resource.
        |----------------------------------------------------------------------
        */
        Route::get('lms/monitoring',                 [LmsMonitoringController::class, 'index'])
            ->name('lms.monitoring');

    });