<?php

namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NotifikasiExport;
 
class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Notifikasi::with('pengguna');
 
        if ($request->filled('pengguna_id')) {
            $query->where('pengguna_id', $request->pengguna_id);
        }
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('sudah_dibaca')) {
            $query->where('sudah_dibaca', $request->sudah_dibaca === 'ya');
        }
 
        $notifikasis = $query->latest()->paginate(20)->withQueryString();
        $pengguna    = User::orderBy('name')->get();

        $stats = [
            'total'        => Notifikasi::count(),
            'belum_dibaca' => Notifikasi::belumDibaca()->count(),
            'sudah_dibaca' => Notifikasi::where('sudah_dibaca', true)->count(),
        ];
 
        return view('admin.notifikasi.index', compact('notifikasis', 'pengguna', 'stats'));
    }
 
    public function create()
    {
        $pengguna = User::orderBy('name')->get();
        return view('admin.notifikasi.create', compact('pengguna'));
    }
 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pengguna_ids'   => ['required', 'array', 'min:1'],
            'pengguna_ids.*' => ['exists:users,id'],
            'judul'          => ['required', 'string', 'max:150'],
            'pesan'          => ['required', 'string'],
            'jenis'          => ['required', 'string', 'in:info,peringatan,pelanggaran,absensi,nilai,pengumuman,tugas,ujian'],
            'url_tujuan'     => ['nullable', 'url', 'max:255'],
        ], [
            'pengguna_ids.required' => 'Pilih minimal satu penerima.',
            'pengguna_ids.min'      => 'Pilih minimal satu penerima.',
            'pengguna_ids.*.exists' => 'Salah satu penerima tidak valid.',
            'judul.required'        => 'Judul notifikasi wajib diisi.',
            'judul.max'             => 'Judul maksimal 150 karakter.',
            'pesan.required'        => 'Pesan notifikasi wajib diisi.',
            'jenis.required'        => 'Jenis notifikasi wajib dipilih.',
            'jenis.in'              => 'Jenis notifikasi tidak valid.',
            'url_tujuan.url'        => 'URL tujuan harus berupa URL yang valid.',
        ]);
 
        foreach ($validated['pengguna_ids'] as $penggunaId) {
            Notifikasi::kirim(
                $penggunaId,
                $validated['judul'],
                $validated['pesan'],
                $validated['jenis'],
                $validated['url_tujuan'] ?? null,
            );
        }
 
        return redirect()->route('admin.notifikasi.index')
            ->with('success', count($validated['pengguna_ids']) . ' notifikasi berhasil dikirim.');
    }
 
    public function destroy(Notifikasi $notifikasi)
    {
        $notifikasi->delete();
        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }
 
    public function destroyBulk(Request $request)
    {
        $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['exists:notifikasi,id'],
        ], [
            'ids.required' => 'Pilih minimal satu notifikasi untuk dihapus.',
        ]);
 
        Notifikasi::whereIn('id', $request->ids)->delete();
        return back()->with('success', count($request->ids) . ' notifikasi berhasil dihapus.');
    }
 
    public function exportPdf(Request $request)
    {
        $query = Notifikasi::with('pengguna');
 
        if ($request->filled('pengguna_id')) {
            $query->where('pengguna_id', $request->pengguna_id);
        }
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('sudah_dibaca')) {
            $query->where('sudah_dibaca', $request->sudah_dibaca === 'ya');
        }
 
        $notifikasis = $query->latest()->get();
 
        $pdf = Pdf::loadView('admin.notifikasi.export-pdf', compact('notifikasis'))
            ->setPaper('a4', 'landscape');
 
        return $pdf->download('notifikasi-' . now()->format('YmdHis') . '.pdf');
    }
 
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new NotifikasiExport($request->all()),
            'notifikasi-' . now()->format('YmdHis') . '.xlsx'
        );
    }
}