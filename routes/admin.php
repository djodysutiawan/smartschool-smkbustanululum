<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\GedungController;
use App\Http\Controllers\Admin\RuangController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\OrangTuaController;
use App\Http\Controllers\Admin\KetersediaanGuruController;
use App\Http\Controllers\Admin\JadwalPelajaranController;
use App\Http\Controllers\Admin\JadwalPiketGuruController;
use App\Http\Controllers\Admin\LogPiketController;
use App\Http\Controllers\Admin\MateriController;
use App\Http\Controllers\Admin\TugasController;
use App\Http\Controllers\Admin\PengumpulanTugasController;
use App\Http\Controllers\Admin\UjianController;
use App\Http\Controllers\Admin\NilaiController;
use App\Http\Controllers\Admin\JurnalMengajarController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\SesiQrController;
use App\Http\Controllers\Admin\RiwayatScanController;
use App\Http\Controllers\Admin\KategoriPelanggaranController;
use App\Http\Controllers\Admin\PelanggaranController;
use App\Http\Controllers\Admin\NotifikasiController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SoalUjianController;
use App\Http\Controllers\Admin\SesiUjianController;

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/',          fn () => view('admin.dashboard'))->name('dashboard');
        Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard.alt');

        // Users
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/',                       [UserController::class, 'index'])->name('index');
            Route::get('/create',                 [UserController::class, 'create'])->name('create');
            Route::post('/',                      [UserController::class, 'store'])->name('store');
            Route::get('/export/pdf',             [UserController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',           [UserController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',        [UserController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                [UserController::class, 'import'])->name('import');
            Route::get('/{user}',                 [UserController::class, 'show'])->name('show');
            Route::get('/{user}/edit',            [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}',                 [UserController::class, 'update'])->name('update');
            Route::delete('/{user}',              [UserController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/restore',          [UserController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete',   [UserController::class, 'forceDelete'])->name('force-delete');
            Route::post('/{user}/reset-password', [UserController::class, 'resetPassword'])->name('reset-password');
            Route::patch('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Tahun Ajaran
        Route::prefix('tahun-ajaran')->name('tahun-ajaran.')->group(function () {
            Route::get('/export/pdf',             [TahunAjaranController::class, 'exportPdf'])->name('export-pdf');
            Route::get('/export/excel',           [TahunAjaranController::class, 'exportExcel'])->name('export-excel');
            Route::post('/import',                [TahunAjaranController::class, 'import'])->name('import');
            Route::get('/',                       [TahunAjaranController::class, 'index'])->name('index');
            Route::get('/create',                 [TahunAjaranController::class, 'create'])->name('create');
            Route::post('/',                      [TahunAjaranController::class, 'store'])->name('store');
            Route::get('/{tahunAjaran}',          [TahunAjaranController::class, 'show'])->name('show');
            Route::get('/{tahunAjaran}/edit',     [TahunAjaranController::class, 'edit'])->name('edit');
            Route::put('/{tahunAjaran}',          [TahunAjaranController::class, 'update'])->name('update');
            Route::delete('/{tahunAjaran}',       [TahunAjaranController::class, 'destroy'])->name('destroy');
            Route::patch('/{tahunAjaran}/aktifkan', [TahunAjaranController::class, 'aktifkan'])->name('aktifkan');
        });

        // Gedung
        Route::prefix('gedung')->name('gedung.')->group(function () {
            Route::get('/',                         [GedungController::class, 'index'])->name('index');
            Route::get('/create',                   [GedungController::class, 'create'])->name('create');
            Route::post('/',                        [GedungController::class, 'store'])->name('store');
            Route::get('/export/pdf',               [GedungController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',             [GedungController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',          [GedungController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                  [GedungController::class, 'import'])->name('import');
            Route::get('/{gedung}',                 [GedungController::class, 'show'])->name('show');
            Route::get('/{gedung}/edit',            [GedungController::class, 'edit'])->name('edit');
            Route::put('/{gedung}',                 [GedungController::class, 'update'])->name('update');
            Route::delete('/{gedung}',              [GedungController::class, 'destroy'])->name('destroy');
            Route::patch('/{gedung}/toggle-status', [GedungController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Ruang
        Route::prefix('ruang')->name('ruang.')->group(function () {
            Route::get('/',                        [RuangController::class, 'index'])->name('index');
            Route::get('/create',                  [RuangController::class, 'create'])->name('create');
            Route::post('/',                       [RuangController::class, 'store'])->name('store');
            Route::get('/export/pdf',              [RuangController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',            [RuangController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',         [RuangController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                 [RuangController::class, 'import'])->name('import');
            Route::get('/{ruang}',                 [RuangController::class, 'show'])->name('show');
            Route::get('/{ruang}/edit',            [RuangController::class, 'edit'])->name('edit');
            Route::put('/{ruang}',                 [RuangController::class, 'update'])->name('update');
            Route::delete('/{ruang}',              [RuangController::class, 'destroy'])->name('destroy');
            Route::patch('/{ruang}/toggle-status', [RuangController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Kelas
        Route::prefix('kelas')->name('kelas.')->group(function () {
            Route::get('/',                        [KelasController::class, 'index'])->name('index');
            Route::get('/create',                  [KelasController::class, 'create'])->name('create');
            Route::post('/',                       [KelasController::class, 'store'])->name('store');
            Route::get('/export/pdf',              [KelasController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',            [KelasController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',         [KelasController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                 [KelasController::class, 'import'])->name('import');
            Route::get('/{kelas}',                 [KelasController::class, 'show'])->name('show');
            Route::get('/{kelas}/edit',            [KelasController::class, 'edit'])->name('edit');
            Route::put('/{kelas}',                 [KelasController::class, 'update'])->name('update');
            Route::delete('/{kelas}',              [KelasController::class, 'destroy'])->name('destroy');
            Route::patch('/{kelas}/toggle-status', [KelasController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Mata Pelajaran
        Route::prefix('mata-pelajaran')->name('mata-pelajaran.')->group(function () {
            Route::get('/',                                [MataPelajaranController::class, 'index'])->name('index');
            Route::get('/create',                          [MataPelajaranController::class, 'create'])->name('create');
            Route::post('/',                               [MataPelajaranController::class, 'store'])->name('store');
            Route::get('/export/pdf',                      [MataPelajaranController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',                    [MataPelajaranController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',                 [MataPelajaranController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                         [MataPelajaranController::class, 'import'])->name('import');
            Route::get('/{mataPelajaran}',                 [MataPelajaranController::class, 'show'])->name('show');
            Route::get('/{mataPelajaran}/edit',            [MataPelajaranController::class, 'edit'])->name('edit');
            Route::put('/{mataPelajaran}',                 [MataPelajaranController::class, 'update'])->name('update');
            Route::delete('/{mataPelajaran}',              [MataPelajaranController::class, 'destroy'])->name('destroy');
            Route::patch('/{mataPelajaran}/toggle-status', [MataPelajaranController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Guru
        Route::prefix('guru')->name('guru.')->group(function () {
            Route::get('/',                       [GuruController::class, 'index'])->name('index');
            Route::get('/create',                 [GuruController::class, 'create'])->name('create');
            Route::post('/',                      [GuruController::class, 'store'])->name('store');
            Route::get('/export/pdf',             [GuruController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',           [GuruController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',        [GuruController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                [GuruController::class, 'import'])->name('import');
            Route::get('/{guru}',                 [GuruController::class, 'show'])->name('show');
            Route::get('/{guru}/edit',            [GuruController::class, 'edit'])->name('edit');
            Route::put('/{guru}',                 [GuruController::class, 'update'])->name('update');
            Route::delete('/{guru}',              [GuruController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/restore',          [GuruController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete',   [GuruController::class, 'forceDelete'])->name('force-delete');
            Route::patch('/{guru}/toggle-status', [GuruController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Siswa
        Route::prefix('siswa')->name('siswa.')->group(function () {
            Route::get('/',                        [SiswaController::class, 'index'])->name('index');
            Route::get('/create',                  [SiswaController::class, 'create'])->name('create');
            Route::post('/',                       [SiswaController::class, 'store'])->name('store');
            Route::get('/export/pdf',              [SiswaController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',            [SiswaController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',         [SiswaController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                 [SiswaController::class, 'import'])->name('import');
            Route::get('/{siswa}',                 [SiswaController::class, 'show'])->name('show');
            Route::get('/{siswa}/edit',            [SiswaController::class, 'edit'])->name('edit');
            Route::put('/{siswa}',                 [SiswaController::class, 'update'])->name('update');
            Route::delete('/{siswa}',              [SiswaController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/restore',           [SiswaController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete',    [SiswaController::class, 'forceDelete'])->name('force-delete');
            Route::patch('/{siswa}/toggle-status', [SiswaController::class, 'toggleStatus'])->name('toggle-status');
            Route::patch('/{siswa}/pindah-kelas',  [SiswaController::class, 'pindahKelas'])->name('pindah-kelas');
        });

        // Orang Tua
        Route::prefix('orang-tua')->name('orang-tua.')->group(function () {
            Route::get('/',                                   [OrangTuaController::class, 'index'])->name('index');
            Route::get('/create',                             [OrangTuaController::class, 'create'])->name('create');
            Route::post('/',                                  [OrangTuaController::class, 'store'])->name('store');
            Route::get('/export/pdf',                         [OrangTuaController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',                       [OrangTuaController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',                    [OrangTuaController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                            [OrangTuaController::class, 'import'])->name('import');
            Route::get('/{orangTua}',                         [OrangTuaController::class, 'show'])->name('show');
            Route::get('/{orangTua}/edit',                    [OrangTuaController::class, 'edit'])->name('edit');
            Route::put('/{orangTua}',                         [OrangTuaController::class, 'update'])->name('update');
            Route::delete('/{orangTua}',                      [OrangTuaController::class, 'destroy'])->name('destroy');
            Route::post('/{orangTua}/link-siswa',             [OrangTuaController::class, 'linkSiswa'])->name('link-siswa');
            Route::delete('/{orangTua}/unlink-siswa/{siswa}', [OrangTuaController::class, 'unlinkSiswa'])->name('unlink-siswa');
        });

        // Ketersediaan Guru
        Route::prefix('ketersediaan-guru')->name('ketersediaan-guru.')->group(function () {
            Route::get('/export/pdf',                  [KetersediaanGuruController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',                [KetersediaanGuruController::class, 'exportExcel'])->name('export.excel');
            Route::post('/import',                     [KetersediaanGuruController::class, 'import'])->name('import');
            Route::get('/guru/{guru}',                 [KetersediaanGuruController::class, 'showByGuru'])->name('by-guru');
            Route::post('/guru/{guru}/bulk',           [KetersediaanGuruController::class, 'bulkStore'])->name('bulk-store');
            Route::get('/',                            [KetersediaanGuruController::class, 'index'])->name('index');
            Route::get('/create',                      [KetersediaanGuruController::class, 'create'])->name('create');
            Route::post('/',                           [KetersediaanGuruController::class, 'store'])->name('store');
            Route::get('/{ketersediaanGuru}',          [KetersediaanGuruController::class, 'show'])->name('show');
            Route::get('/{ketersediaanGuru}/edit',     [KetersediaanGuruController::class, 'edit'])->name('edit');
            Route::put('/{ketersediaanGuru}',          [KetersediaanGuruController::class, 'update'])->name('update');
            Route::delete('/{ketersediaanGuru}',       [KetersediaanGuruController::class, 'destroy'])->name('destroy');
            Route::patch('/{ketersediaanGuru}/toggle', [KetersediaanGuruController::class, 'toggle'])->name('toggle');
        });

        // Jadwal Pelajaran
        Route::prefix('jadwal-pelajaran')->name('jadwal-pelajaran.')->group(function () {
            Route::get('/export/pdf',                        [JadwalPelajaranController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',                      [JadwalPelajaranController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',                   [JadwalPelajaranController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                           [JadwalPelajaranController::class, 'import'])->name('import');
            Route::get('/',                                  [JadwalPelajaranController::class, 'index'])->name('index');
            Route::get('/create',                            [JadwalPelajaranController::class, 'create'])->name('create');
            Route::post('/',                                 [JadwalPelajaranController::class, 'store'])->name('store');
            Route::get('/{jadwalPelajaran}',                 [JadwalPelajaranController::class, 'show'])->name('show');
            Route::get('/{jadwalPelajaran}/edit',            [JadwalPelajaranController::class, 'edit'])->name('edit');
            Route::put('/{jadwalPelajaran}',                 [JadwalPelajaranController::class, 'update'])->name('update');
            Route::delete('/{jadwalPelajaran}',              [JadwalPelajaranController::class, 'destroy'])->name('destroy');
            Route::patch('/{jadwalPelajaran}/toggle-status', [JadwalPelajaranController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Jadwal Piket Guru
        Route::prefix('jadwal-piket-guru')->name('jadwal-piket-guru.')->group(function () {
            Route::get('/',                                    [JadwalPiketGuruController::class, 'index'])->name('index');
            Route::get('/create',                              [JadwalPiketGuruController::class, 'create'])->name('create');
            Route::post('/',                                   [JadwalPiketGuruController::class, 'store'])->name('store');
            Route::get('/export/pdf',                          [JadwalPiketGuruController::class, 'exportPdf'])->name('export-pdf');
            Route::get('/export/excel',                        [JadwalPiketGuruController::class, 'export'])->name('export-excel');
            Route::get('/import/template',                     [JadwalPiketGuruController::class, 'downloadTemplate'])->name('import-template');
            Route::post('/import',                             [JadwalPiketGuruController::class, 'import'])->name('import');
            Route::get('/{jadwalPiketGuru}',                   [JadwalPiketGuruController::class, 'show'])->name('show');
            Route::get('/{jadwalPiketGuru}/edit',              [JadwalPiketGuruController::class, 'edit'])->name('edit');
            Route::put('/{jadwalPiketGuru}',                   [JadwalPiketGuruController::class, 'update'])->name('update');
            Route::delete('/{jadwalPiketGuru}',                [JadwalPiketGuruController::class, 'destroy'])->name('destroy');
            Route::patch('/{jadwalPiketGuru}/toggle-status',   [JadwalPiketGuruController::class, 'toggleStatus'])->name('toggle-status');
            Route::get('/{jadwalPiketGuru}/export/pdf',        [JadwalPiketGuruController::class, 'exportPdfSingle'])->name('export-pdf-single');
        });

        // Log Piket
        Route::prefix('log-piket')->name('log-piket.')->group(function () {
            Route::get('/',                        [LogPiketController::class, 'index'])->name('index');
            Route::get('/export/pdf',              [LogPiketController::class, 'exportPdf'])->name('export-pdf');
            Route::get('/export/excel',            [LogPiketController::class, 'export'])->name('export-excel');
            Route::get('/import/template',         [LogPiketController::class, 'downloadTemplate'])->name('import-template');
            Route::post('/import',                 [LogPiketController::class, 'import'])->name('import');
            Route::get('/{logPiket}',              [LogPiketController::class, 'show'])->name('show');
            Route::delete('/{logPiket}',           [LogPiketController::class, 'destroy'])->name('destroy');
            Route::patch('/{logPiket}/check-out',  [LogPiketController::class, 'checkOut'])->name('check-out');
            Route::get('/{logPiket}/export/pdf',   [LogPiketController::class, 'exportPdfSingle'])->name('export-pdf-single');
        });

        // Materi
        Route::prefix('materi')->name('materi.')->group(function () {
            Route::get('/',                          [MateriController::class, 'index'])->name('index');
            Route::get('/create',                    [MateriController::class, 'create'])->name('create');
            Route::post('/',                         [MateriController::class, 'store'])->name('store');
            Route::get('/export/pdf',                [MateriController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',              [MateriController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',           [MateriController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                   [MateriController::class, 'import'])->name('import');
            Route::get('/{materi}',                  [MateriController::class, 'show'])->name('show');
            Route::get('/{materi}/edit',             [MateriController::class, 'edit'])->name('edit');
            Route::put('/{materi}',                  [MateriController::class, 'update'])->name('update');
            Route::delete('/{materi}',               [MateriController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/restore',             [MateriController::class, 'restore'])->name('restore');
            Route::patch('/{materi}/toggle-publish', [MateriController::class, 'togglePublish'])->name('toggle-publish');
        });

        // Tugas
        Route::prefix('tugas')->name('tugas.')->group(function () {
            Route::get('/',                        [TugasController::class, 'index'])->name('index');
            Route::get('/create',                  [TugasController::class, 'create'])->name('create');
            Route::post('/',                       [TugasController::class, 'store'])->name('store');
            Route::get('/export/pdf',              [TugasController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',            [TugasController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',         [TugasController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                 [TugasController::class, 'import'])->name('import');
            Route::get('/{tugas}',                 [TugasController::class, 'show'])->name('show');
            Route::get('/{tugas}/edit',            [TugasController::class, 'edit'])->name('edit');
            Route::put('/{tugas}',                 [TugasController::class, 'update'])->name('update');
            Route::delete('/{tugas}',              [TugasController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/restore',           [TugasController::class, 'restore'])->name('restore');
            Route::patch('/{tugas}/toggle-status', [TugasController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Pengumpulan Tugas
        Route::prefix('pengumpulan-tugas')->name('pengumpulan-tugas.')->group(function () {
            Route::get('/',                                  [PengumpulanTugasController::class, 'index'])->name('index');
            Route::get('/export/pdf',                        [PengumpulanTugasController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',                      [PengumpulanTugasController::class, 'exportExcel'])->name('export.excel');
            Route::get('/{pengumpulanTugas}',                [PengumpulanTugasController::class, 'show'])->name('show');
            Route::patch('/{pengumpulanTugas}/beri-nilai',   [PengumpulanTugasController::class, 'beriNilai'])->name('beri-nilai');
            Route::patch('/{pengumpulanTugas}/kembalikan',   [PengumpulanTugasController::class, 'kembalikan'])->name('kembalikan');
            Route::delete('/{pengumpulanTugas}',             [PengumpulanTugasController::class, 'destroy'])->name('destroy');
        });

        // Ujian
        Route::prefix('ujian')->name('ujian.')->group(function () {
            Route::get('/',                        [UjianController::class, 'index'])->name('index');
            Route::get('/create',                  [UjianController::class, 'create'])->name('create');
            Route::post('/',                       [UjianController::class, 'store'])->name('store');
            Route::get('/export/pdf',              [UjianController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',            [UjianController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',         [UjianController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                 [UjianController::class, 'import'])->name('import');
            Route::get('/{ujian}',                 [UjianController::class, 'show'])->name('show');
            Route::get('/{ujian}/edit',            [UjianController::class, 'edit'])->name('edit');
            Route::put('/{ujian}',                 [UjianController::class, 'update'])->name('update');
            Route::delete('/{ujian}',              [UjianController::class, 'destroy'])->name('destroy');
            Route::patch('/{ujian}/toggle-status', [UjianController::class, 'toggleStatus'])->name('toggle-status');

            // Soal Ujian
            Route::prefix('/{ujian}/soal')->name('soal.')->group(function () {
                Route::get('/',                    [SoalUjianController::class, 'index'])->name('index');
                Route::get('/create',              [SoalUjianController::class, 'create'])->name('create');
                Route::post('/',                   [SoalUjianController::class, 'store'])->name('store');
                Route::get('/export/pdf',          [SoalUjianController::class, 'exportPdf'])->name('export.pdf');
                Route::get('/export/excel',        [SoalUjianController::class, 'exportExcel'])->name('export.excel');
                Route::get('/import/template',     [SoalUjianController::class, 'importTemplate'])->name('import.template');
                Route::post('/import',             [SoalUjianController::class, 'import'])->name('import');
                Route::post('/reorder',            [SoalUjianController::class, 'reorder'])->name('reorder');
                Route::get('/{soal}',              [SoalUjianController::class, 'show'])->name('show');
                Route::get('/{soal}/edit',         [SoalUjianController::class, 'edit'])->name('edit');
                Route::put('/{soal}',              [SoalUjianController::class, 'update'])->name('update');
                Route::delete('/{soal}',           [SoalUjianController::class, 'destroy'])->name('destroy');
            });

            // Sesi Ujian
            Route::prefix('/{ujian}')->name('sesi.')->group(function () {
                Route::get('/mulai',               [SesiUjianController::class, 'mulai'])->name('mulai');
                Route::post('/start',              [SesiUjianController::class, 'start'])->name('start');
                Route::get('/kerjakan',            [SesiUjianController::class, 'kerjakan'])->name('kerjakan');
                Route::post('/soal/{soal}/jawab',  [SesiUjianController::class, 'jawab'])->name('soal.jawab');
                Route::post('/selesai',            [SesiUjianController::class, 'selesai'])->name('selesai');
                Route::get('/hasil',               [SesiUjianController::class, 'hasil'])->name('hasil');
                Route::get('/export/pdf',          [SesiUjianController::class, 'exportPdf'])->name('export.pdf');
                Route::get('/export/excel',        [SesiUjianController::class, 'exportExcel'])->name('export.excel');
            });
        });

        // Nilai
        Route::prefix('nilai')->name('nilai.')->group(function () {
            Route::get('/',                         [NilaiController::class, 'index'])->name('index');
            Route::get('/create',                   [NilaiController::class, 'create'])->name('create');
            Route::post('/',                        [NilaiController::class, 'store'])->name('store');
            Route::get('/export/pdf',               [NilaiController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',             [NilaiController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',          [NilaiController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                  [NilaiController::class, 'import'])->name('import');
            Route::get('/rapor-kelas',              [NilaiController::class, 'raporKelas'])->name('rapor-kelas');
            Route::get('/rapor-kelas/export/pdf',   [NilaiController::class, 'exportRaporPdf'])->name('rapor-kelas.export.pdf');
            Route::get('/rapor-kelas/export/excel', [NilaiController::class, 'exportRaporExcel'])->name('rapor-kelas.export.excel');
            Route::get('/{nilai}',                  [NilaiController::class, 'show'])->name('show');
            Route::get('/{nilai}/edit',             [NilaiController::class, 'edit'])->name('edit');
            Route::put('/{nilai}',                  [NilaiController::class, 'update'])->name('update');
            Route::delete('/{nilai}',               [NilaiController::class, 'destroy'])->name('destroy');
        });

        // Jurnal Mengajar
        Route::prefix('jurnal-mengajar')->name('jurnal-mengajar.')->group(function () {
            Route::get('/',                              [JurnalMengajarController::class, 'index'])->name('index');
            Route::get('/create',                        [JurnalMengajarController::class, 'create'])->name('create');
            Route::post('/',                             [JurnalMengajarController::class, 'store'])->name('store');
            Route::get('/export/pdf',                    [JurnalMengajarController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',                  [JurnalMengajarController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',               [JurnalMengajarController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                       [JurnalMengajarController::class, 'import'])->name('import');
            Route::get('/{jurnalMengajar}',              [JurnalMengajarController::class, 'show'])->name('show');
            Route::get('/{jurnalMengajar}/edit',         [JurnalMengajarController::class, 'edit'])->name('edit');
            Route::put('/{jurnalMengajar}',              [JurnalMengajarController::class, 'update'])->name('update');
            Route::delete('/{jurnalMengajar}',           [JurnalMengajarController::class, 'destroy'])->name('destroy');
            Route::patch('/{jurnalMengajar}/verifikasi', [JurnalMengajarController::class, 'verifikasi'])->name('verifikasi');
        });

        // Absensi
        Route::prefix('absensi')->name('absensi.')->group(function () {
            Route::get('/',                         [AbsensiController::class, 'index'])->name('index');
            Route::get('/create',                   [AbsensiController::class, 'create'])->name('create');
            Route::post('/',                        [AbsensiController::class, 'store'])->name('store');
            Route::get('/export/pdf',               [AbsensiController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',             [AbsensiController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',          [AbsensiController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                  [AbsensiController::class, 'import'])->name('import');
            Route::get('/rekap-kelas',              [AbsensiController::class, 'rekapKelas'])->name('rekap-kelas');
            Route::get('/rekap-kelas/export/pdf',   [AbsensiController::class, 'exportRekapPdf'])->name('rekap-kelas.export.pdf');
            Route::get('/rekap-kelas/export/excel', [AbsensiController::class, 'exportRekapExcel'])->name('rekap-kelas.export.excel');
            Route::get('/{absensi}',                [AbsensiController::class, 'show'])->name('show');
            Route::get('/{absensi}/edit',           [AbsensiController::class, 'edit'])->name('edit');
            Route::put('/{absensi}',                [AbsensiController::class, 'update'])->name('update');
            Route::delete('/{absensi}',             [AbsensiController::class, 'destroy'])->name('destroy');
        });

        // Sesi QR Code
        Route::prefix('sesi-qr')->name('sesi-qr.')->group(function () {
            Route::get('/',                       [SesiQrController::class, 'index'])->name('index');
            Route::get('/create',                 [SesiQrController::class, 'create'])->name('create');
            Route::post('/',                      [SesiQrController::class, 'store'])->name('store');
            Route::get('/export/pdf',             [SesiQrController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',           [SesiQrController::class, 'exportExcel'])->name('export.excel');
            Route::get('/{sesiQr}',               [SesiQrController::class, 'show'])->name('show');
            Route::delete('/{sesiQr}',            [SesiQrController::class, 'destroy'])->name('destroy');
            Route::patch('/{sesiQr}/nonaktifkan', [SesiQrController::class, 'nonaktifkan'])->name('nonaktifkan');
            Route::get('/{sesiQr}/cetak-qr',      [SesiQrController::class, 'cetakQr'])->name('cetak-qr');
        });

        // Riwayat Scan QR
        Route::prefix('riwayat-scan')->name('riwayat-scan.')->group(function () {
            Route::get('/',                  [RiwayatScanController::class, 'index'])->name('index');
            Route::get('/export/pdf',        [RiwayatScanController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',      [RiwayatScanController::class, 'exportExcel'])->name('export.excel');
            Route::get('/{riwayatScan}',     [RiwayatScanController::class, 'show'])->name('show');
            Route::delete('/{riwayatScan}',  [RiwayatScanController::class, 'destroy'])->name('destroy');
        });

        // Kategori Pelanggaran
        Route::prefix('kategori-pelanggaran')->name('kategori-pelanggaran.')->group(function () {
            Route::get('/',                                      [KategoriPelanggaranController::class, 'index'])->name('index');
            Route::get('/create',                                [KategoriPelanggaranController::class, 'create'])->name('create');
            Route::post('/',                                     [KategoriPelanggaranController::class, 'store'])->name('store');
            Route::get('/export/pdf',                            [KategoriPelanggaranController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',                          [KategoriPelanggaranController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',                       [KategoriPelanggaranController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                               [KategoriPelanggaranController::class, 'import'])->name('import');
            Route::get('/{kategoriPelanggaran}',                 [KategoriPelanggaranController::class, 'show'])->name('show');
            Route::get('/{kategoriPelanggaran}/edit',            [KategoriPelanggaranController::class, 'edit'])->name('edit');
            Route::put('/{kategoriPelanggaran}',                 [KategoriPelanggaranController::class, 'update'])->name('update');
            Route::delete('/{kategoriPelanggaran}',              [KategoriPelanggaranController::class, 'destroy'])->name('destroy');
            Route::patch('/{kategoriPelanggaran}/toggle-status', [KategoriPelanggaranController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Pelanggaran
        Route::prefix('pelanggaran')->name('pelanggaran.')->group(function () {
            Route::get('/',                          [PelanggaranController::class, 'index'])->name('index');
            Route::get('/create',                    [PelanggaranController::class, 'create'])->name('create');
            Route::post('/',                         [PelanggaranController::class, 'store'])->name('store');
            Route::get('/export/pdf',                [PelanggaranController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',              [PelanggaranController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',           [PelanggaranController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                   [PelanggaranController::class, 'import'])->name('import');
            Route::get('/{pelanggaran}',             [PelanggaranController::class, 'show'])->name('show');
            Route::get('/{pelanggaran}/edit',        [PelanggaranController::class, 'edit'])->name('edit');
            Route::put('/{pelanggaran}',             [PelanggaranController::class, 'update'])->name('update');
            Route::delete('/{pelanggaran}',          [PelanggaranController::class, 'destroy'])->name('destroy');
            Route::patch('/{pelanggaran}/selesaikan',[PelanggaranController::class, 'selesaikan'])->name('selesaikan');
            Route::patch('/{pelanggaran}/batalkan',  [PelanggaranController::class, 'batalkan'])->name('batalkan');
        });

        // Notifikasi
        Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
            Route::get('/',                          [NotifikasiController::class, 'index'])->name('index');
            Route::get('/create',                    [NotifikasiController::class, 'create'])->name('create');
            Route::post('/',                         [NotifikasiController::class, 'store'])->name('store');
            Route::get('/export/pdf',                [NotifikasiController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',              [NotifikasiController::class, 'exportExcel'])->name('export.excel');
            Route::get('/{notifikasi}',              [NotifikasiController::class, 'show'])->name('show');
            Route::delete('/{notifikasi}',           [NotifikasiController::class, 'destroy'])->name('destroy');
            Route::delete('/',                       [NotifikasiController::class, 'destroyBulk'])->name('destroy-bulk');
            Route::patch('/mark-all-read',           [NotifikasiController::class, 'markAllRead'])->name('mark-all-read');
            Route::patch('/{notifikasi}/mark-read',  [NotifikasiController::class, 'markRead'])->name('mark-read');
        });

        // Pengumuman
        Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
            Route::get('/',                        [PengumumanController::class, 'index'])->name('index');
            Route::get('/create',                  [PengumumanController::class, 'create'])->name('create');
            Route::post('/',                       [PengumumanController::class, 'store'])->name('store');
            Route::get('/export/pdf',              [PengumumanController::class, 'exportPdf'])->name('export.pdf');
            Route::get('/export/excel',            [PengumumanController::class, 'exportExcel'])->name('export.excel');
            Route::get('/import/template',         [PengumumanController::class, 'importTemplate'])->name('import.template');
            Route::post('/import',                 [PengumumanController::class, 'import'])->name('import');
            Route::get('/{pengumuman}',            [PengumumanController::class, 'show'])->name('show');
            Route::get('/{pengumuman}/edit',       [PengumumanController::class, 'edit'])->name('edit');
            Route::put('/{pengumuman}',            [PengumumanController::class, 'update'])->name('update');
            Route::delete('/{pengumuman}',         [PengumumanController::class, 'destroy'])->name('destroy');
            Route::patch('/{pengumuman}/publish',  [PengumumanController::class, 'publish'])->name('publish');
            Route::patch('/{pengumuman}/unpublish',[PengumumanController::class, 'unpublish'])->name('unpublish');
        });

        // Laporan
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index');

            Route::get('/absensi',                  [ReportController::class, 'attendance'])->name('absensi');
            Route::get('/absensi/export/pdf',       [ReportController::class, 'exportAttendancePdf'])->name('absensi.export.pdf');
            Route::get('/absensi/export/excel',     [ReportController::class, 'exportAttendanceExcel'])->name('absensi.export.excel');

            Route::get('/nilai',                    [ReportController::class, 'grades'])->name('nilai');
            Route::get('/nilai/export/pdf',         [ReportController::class, 'exportGradesPdf'])->name('nilai.export.pdf');
            Route::get('/nilai/export/excel',       [ReportController::class, 'exportGradesExcel'])->name('nilai.export.excel');

            Route::get('/pelanggaran',              [ReportController::class, 'violation'])->name('pelanggaran');
            Route::get('/pelanggaran/export/pdf',   [ReportController::class, 'exportViolationPdf'])->name('pelanggaran.export.pdf');
            Route::get('/pelanggaran/export/excel', [ReportController::class, 'exportViolationExcel'])->name('pelanggaran.export.excel');

            Route::get('/siswa',                    [ReportController::class, 'student'])->name('siswa');
            Route::get('/siswa/export/pdf',         [ReportController::class, 'exportStudentPdf'])->name('siswa.export.pdf');
            Route::get('/siswa/export/excel',       [ReportController::class, 'exportStudentExcel'])->name('siswa.export.excel');

            Route::get('/guru',                     [ReportController::class, 'teacher'])->name('guru');
            Route::get('/guru/export/pdf',          [ReportController::class, 'exportTeacherPdf'])->name('guru.export.pdf');
            Route::get('/guru/export/excel',        [ReportController::class, 'exportTeacherExcel'])->name('guru.export.excel');

            Route::get('/jurnal-mengajar',              [ReportController::class, 'teachingJournal'])->name('jurnal-mengajar');
            Route::get('/jurnal-mengajar/export/pdf',   [ReportController::class, 'exportTeachingJournalPdf'])->name('jurnal-mengajar.export.pdf');
            Route::get('/jurnal-mengajar/export/excel', [ReportController::class, 'exportTeachingJournalExcel'])->name('jurnal-mengajar.export.excel');

            Route::get('/log-piket',                [ReportController::class, 'piketLog'])->name('log-piket');
            Route::get('/log-piket/export/pdf',     [ReportController::class, 'exportPiketLogPdf'])->name('log-piket.export.pdf');
            Route::get('/log-piket/export/excel',   [ReportController::class, 'exportPiketLogExcel'])->name('log-piket.export.excel');

            Route::get('/ujian',                    [ReportController::class, 'exam'])->name('ujian');
            Route::get('/ujian/export/pdf',         [ReportController::class, 'exportExamPdf'])->name('ujian.export.pdf');
            Route::get('/ujian/export/excel',       [ReportController::class, 'exportExamExcel'])->name('ujian.export.excel');
        });

    });