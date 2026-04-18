<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogPiket;
use App\Models\Guru;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LogPiketExport;
use App\Imports\LogPiketImport;

class LogPiketController extends Controller
{
    public function index(Request $request)
    {
        $query = LogPiket::with(['guru', 'pengguna'])
            ->orderByDesc('tanggal')
            ->orderByDesc('masuk_pada');

        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }
        if ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        $logs           = $query->paginate(15)->withQueryString();
        $sedangBertugas = LogPiket::with('guru')
            ->whereNotNull('masuk_pada')
            ->whereNull('keluar_pada')
            ->whereDate('tanggal', today())
            ->get();
        $guruPiket      = Guru::orderBy('nama_lengkap')->get();

        return view('admin.log_piket.index', compact('logs', 'sedangBertugas', 'guruPiket'));
    }

    public function show(LogPiket $logPiket)
    {
        $logPiket->load(['guru', 'pengguna']);

        return view('admin.log_piket.show', compact('logPiket'));
    }

    public function checkOut(LogPiket $logPiket)
    {
        if (!$logPiket->masuk_pada) {
            return back()->with('error', 'Guru belum melakukan check-in.');
        }

        if ($logPiket->keluar_pada) {
            return back()->with('error', 'Guru sudah melakukan check-out sebelumnya.');
        }

        $logPiket->checkOut();

        return back()->with('success', 'Check-out berhasil dicatat.');
    }

    public function destroy(LogPiket $logPiket)
    {
        $logPiket->delete();

        return redirect()->route('admin.log_piket.index')
            ->with('success', 'Log piket berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $filename = 'log_piket_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new LogPiketExport($request->all()), $filename);
    }

    public function exportPdf(Request $request)
    {
        $query = LogPiket::with(['guru', 'pengguna'])
            ->orderByDesc('tanggal')
            ->orderByDesc('masuk_pada');

        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }
        if ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        $logs = $query->get();

        $pdf = Pdf::loadView('admin.log_piket.pdf', compact('logs'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('log_piket_' . now()->format('Ymd') . '.pdf');
    }

    public function exportPdfSingle(LogPiket $logPiket)
    {
        $logPiket->load(['guru', 'pengguna']);

        $logs = collect([$logPiket]);

        $pdf = Pdf::loadView('admin.log_piket.pdf', compact('logs'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('log_piket_' . $logPiket->id . '.pdf');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:5120',
        ], [
            'file.required' => 'File wajib diunggah.',
            'file.mimes'    => 'File harus berformat xlsx atau xls.',
            'file.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        try {
            $import = new LogPiketImport();
            Excel::import($import, $request->file('file'));

            $errors = $import->getErrors();

            if (!empty($errors)) {
                return redirect()->route('admin.log_piket.index')
                    ->with('import_errors', $errors)
                    ->with('success', 'Import selesai dengan beberapa peringatan.');
            }

            return redirect()->route('admin.log_piket.index')
                ->with('success', 'Data log piket berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->route('admin.log_piket.index')
                ->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $filename = 'template_log_piket.xlsx';

        return Excel::download(new \App\Exports\LogPiketTemplateExport(), $filename);
    }
}