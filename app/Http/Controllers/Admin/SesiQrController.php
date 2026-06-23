<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SesiQrExport;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\SesiQr;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SesiQrController extends Controller
{
    // ── HELPER: Generate barcode_mapel untuk seluruh siswa di kelas ──────────

    /**
     * Generate barcode_mapel bagi siswa yang belum punya.
     * Dipanggil setiap kali sesi QR dibuat agar barcode selalu tersedia.
     *
     * Format: MAP-{NIS} jika NIS ada, atau MAP-{ID padded 8 digit}
     */
    private function generateBarcodeMapelUntukKelas(int $kelasId): void
    {
        $siswaTanpaBarcode = Siswa::where('kelas_id', $kelasId)
            ->whereNull('barcode_mapel')
            ->get();

        foreach ($siswaTanpaBarcode as $siswa) {
            $kode = 'MAP-' . ($siswa->nis
                ? strtoupper($siswa->nis)
                : str_pad($siswa->id, 8, '0', STR_PAD_LEFT)
            );

            // Pastikan unik — jika konflik tambahkan suffix
            $base  = $kode;
            $index = 1;
            while (Siswa::where('barcode_mapel', $kode)->where('id', '!=', $siswa->id)->exists()) {
                $kode = $base . '-' . $index++;
            }

            $siswa->update(['barcode_mapel' => $kode]);
        }
    }

    // ── INDEX ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = SesiQr::with([
                'kelas',
                'mataPelajaran',
                'guru',
                'jadwalPelajaran',
                'dibuatOleh',
            ])
            ->withCount([
                'riwayatScan',
                'riwayatScan as scan_valid_count' => fn ($q) => $q->where('status', 'valid'),
            ]);

        if ($request->filled('kelas_id'))  $query->where('kelas_id', $request->kelas_id);
        if ($request->filled('tanggal'))   $query->whereDate('tanggal', $request->tanggal);
        if ($request->filled('is_active')) $query->where('is_active', $request->boolean('is_active'));

        $sesiQrs   = $query->latest()->paginate(20)->withQueryString();
        $kelasList = Kelas::aktif()->orderBy('nama_kelas')->get();

        return view('admin.sesi-qr.index', compact('sesiQrs', 'kelasList'));
    }

    // ── CREATE ────────────────────────────────────────────────────────────────

    public function create(Request $request)
    {
        $hariIndo = [
            'Sunday'    => 'minggu',
            'Monday'    => 'senin',
            'Tuesday'   => 'selasa',
            'Wednesday' => 'rabu',
            'Thursday'  => 'kamis',
            'Friday'    => 'jumat',
            'Saturday'  => 'sabtu',
        ];
        $hariIni = $hariIndo[now()->format('l')] ?? 'senin';

        $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'kelas', 'ruang'])
            ->aktif()
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();

        $kelasList = Kelas::aktif()->orderBy('nama_kelas')->get();

        // Sesi aktif hari ini — untuk validasi & info di form
        $sesiAktifHariIni = SesiQr::with(['mataPelajaran', 'kelas'])
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->where('kadaluarsa_pada', '>=', now())
            ->get()
            ->keyBy('kelas_id');

        return view('admin.sesi-qr.create', compact(
            'jadwalHariIni', 'kelasList', 'hariIni', 'sesiAktifHariIni'
        ));
    }

    // ── STORE ─────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jadwal_pelajaran_id' => ['nullable', 'exists:jadwal_pelajaran,id'],
            'kelas_id'            => ['required', 'exists:kelas,id'],
            'mata_pelajaran_id'   => ['required', 'exists:mata_pelajaran,id'],
            'tanggal'             => ['required', 'date'],
            'berlaku_mulai'       => ['required', 'date_format:H:i'],
            'durasi_menit'        => ['required', 'integer', 'min:5', 'max:240'],
            'radius_meter'        => ['nullable', 'integer', 'min:10', 'max:1000'],
            'latitude'            => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'           => ['nullable', 'numeric', 'between:-180,180'],
            'maks_scan'           => ['nullable', 'integer', 'min:0'],
        ], [
            'kelas_id.required'          => 'Kelas wajib dipilih.',
            'mata_pelajaran_id.required' => 'Mata pelajaran wajib dipilih.',
            'tanggal.required'           => 'Tanggal wajib diisi.',
            'berlaku_mulai.required'     => 'Jam mulai berlaku wajib diisi.',
            'durasi_menit.required'      => 'Durasi wajib diisi.',
            'durasi_menit.min'           => 'Durasi minimal 5 menit.',
            'durasi_menit.max'           => 'Durasi maksimal 240 menit.',
        ]);

        // ── VALIDASI: Cek apakah kelas ini sudah punya sesi aktif hari ini ──
        $sesiAktifKelas = SesiQr::where('kelas_id', $validated['kelas_id'])
            ->whereDate('tanggal', $validated['tanggal'])
            ->where('is_active', true)
            ->where('kadaluarsa_pada', '>=', now())
            ->first();

        if ($sesiAktifKelas) {
            $namaMapel = $sesiAktifKelas->mataPelajaran->nama_mapel ?? 'suatu pelajaran';
            return back()
                ->withInput()
                ->with('error',
                    "Kelas ini masih memiliki sesi QR aktif untuk {$namaMapel}. " .
                    "Tunggu hingga sesi selesai atau nonaktifkan terlebih dahulu sebelum membuat sesi baru."
                );
        }

        // ── VALIDASI: Cek duplikat per jadwal (jika jadwal dipilih) ─────────
        if (! empty($validated['jadwal_pelajaran_id'])) {
            $existing = SesiQr::where('jadwal_pelajaran_id', $validated['jadwal_pelajaran_id'])
                ->whereDate('tanggal', $validated['tanggal'])
                ->where('is_active', true)
                ->first();

            if ($existing) {
                return back()
                    ->withInput()
                    ->with('error', 'Sudah ada sesi QR aktif untuk jadwal ini. Nonaktifkan sesi sebelumnya terlebih dahulu.');
            }
        }

        $berlakuMulai   = \Carbon\Carbon::parse($validated['tanggal'] . ' ' . $validated['berlaku_mulai']);
        $kadaluarsaPada = $berlakuMulai->copy()->addMinutes((int) $validated['durasi_menit']);

        $guruId = null;
        if (! empty($validated['jadwal_pelajaran_id'])) {
            $jadwal = JadwalPelajaran::find($validated['jadwal_pelajaran_id']);
            $guruId = $jadwal?->guru_id;
        }

        $sesi = SesiQr::create([
            'kelas_id'            => $validated['kelas_id'],
            'mata_pelajaran_id'   => $validated['mata_pelajaran_id'],
            'jadwal_pelajaran_id' => $validated['jadwal_pelajaran_id'] ?? null,
            'guru_id'             => $guruId,
            'dibuat_oleh'         => Auth::id(),
            'tanggal'             => $validated['tanggal'],
            'berlaku_mulai'       => $berlakuMulai,
            'kadaluarsa_pada'     => $kadaluarsaPada,
            'radius_meter'        => $validated['radius_meter'] ?? 100,
            'latitude'            => $validated['latitude'] ?? null,
            'longitude'           => $validated['longitude'] ?? null,
            'maks_scan'           => $validated['maks_scan'] ?? 0,
            'is_active'           => true,
        ]);

        // ── AUTO-GENERATE barcode_mapel untuk siswa di kelas ini ─────────────
        $this->generateBarcodeMapelUntukKelas($validated['kelas_id']);

        return redirect()->route('admin.sesi-qr.show', $sesi)
            ->with('success', 'Sesi QR berhasil dibuat. Barcode mapel siswa yang belum punya sudah di-generate otomatis.');
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    public function show(SesiQr $sesiQr)
    {
        $sesiQr->load([
            'kelas.siswa',
            'mataPelajaran',
            'jadwalPelajaran',
            'guru',
            'dibuatOleh',
            'riwayatScan.siswa',
        ]);

        $sudahScan = $sesiQr->riwayatScan()
            ->where('status', 'valid')
            ->with('siswa')
            ->get();

        $belumScan = $sesiQr->siswaYangBelumScan();

        $stats = [
            'total_siswa' => $sesiQr->kelas->siswa->count(),
            'sudah_scan'  => $sudahScan->count(),
            'belum_scan'  => $belumScan->count(),
            'ditolak'     => $sesiQr->riwayatScan()->where('status', '!=', 'valid')->count(),
            'persentase'  => $sesiQr->kelas->siswa->count() > 0
                ? round($sudahScan->count() / $sesiQr->kelas->siswa->count() * 100, 1)
                : 0,
        ];

        return view('admin.sesi-qr.show', compact('sesiQr', 'sudahScan', 'belumScan', 'stats'));
    }

    // ── CETAK QR ─────────────────────────────────────────────────────────────

    public function cetakQr(SesiQr $sesiQr)
    {
        $sesiQr->load(['kelas', 'mataPelajaran', 'guru']);
        return view('admin.sesi-qr.cetak-qr', compact('sesiQr'));
    }

    // ── NONAKTIFKAN ───────────────────────────────────────────────────────────

    public function nonaktifkan(SesiQr $sesiQr)
    {
        $sesiQr->nonaktifkan();
        return back()->with('success', 'Sesi QR berhasil dinonaktifkan.');
    }

    // ── TUTUP SESI ────────────────────────────────────────────────────────────

    public function tutupSesi(SesiQr $sesiQr)
    {
        if (! $sesiQr->isKadaluarsa() && $sesiQr->is_active) {
            return back()->with('error', 'Sesi belum berakhir. Tunggu hingga kadaluarsa atau nonaktifkan terlebih dahulu.');
        }

        $belumScan = $sesiQr->siswaYangBelumScan();

        if ($belumScan->isEmpty()) {
            return back()->with('info', 'Semua siswa sudah tercatat absensinya.');
        }

        DB::transaction(function () use ($sesiQr, $belumScan) {
            foreach ($belumScan as $siswa) {
                $kondisi = [
                    'siswa_id' => $siswa->id,
                    'tanggal'  => $sesiQr->tanggal->toDateString(),
                ];

                if ($sesiQr->jadwal_pelajaran_id) {
                    $kondisi['jadwal_pelajaran_id'] = $sesiQr->jadwal_pelajaran_id;
                } else {
                    $kondisi['sesi_qr_id'] = $sesiQr->id;
                }

                if (! Absensi::where($kondisi)->exists()) {
                    Absensi::create([
                        'siswa_id'            => $siswa->id,
                        'kelas_id'            => $sesiQr->kelas_id,
                        'tahun_ajaran_id'     => $sesiQr->kelas->tahun_ajaran_id,
                        'mata_pelajaran_id'   => $sesiQr->mata_pelajaran_id,
                        'jadwal_pelajaran_id' => $sesiQr->jadwal_pelajaran_id,
                        'sesi_qr_id'          => $sesiQr->id,
                        'dicatat_oleh'        => Auth::id(),
                        'tanggal'             => $sesiQr->tanggal,
                        'status'              => 'alfa',
                        'metode'              => 'qr_scan',
                        'keterangan'          => 'Tidak scan QR — otomatis dicatat alfa.',
                    ]);
                }
            }
        });

        return back()->with('success', "Sesi ditutup. {$belumScan->count()} siswa yang tidak scan dicatat alfa.");
    }

    // ── KOREKSI ABSENSI ───────────────────────────────────────────────────────

    public function koreksiAbsensi(Request $request, SesiQr $sesiQr)
    {
        $validated = $request->validate([
            'siswa_id'   => ['required', 'exists:siswa,id'],
            'status'     => ['required', 'in:hadir,telat,izin,sakit,alfa'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $kondisiCari = [
            'siswa_id' => $validated['siswa_id'],
            'tanggal'  => $sesiQr->tanggal->toDateString(),
        ];

        if ($sesiQr->jadwal_pelajaran_id) {
            $kondisiCari['jadwal_pelajaran_id'] = $sesiQr->jadwal_pelajaran_id;
        } else {
            $kondisiCari['sesi_qr_id'] = $sesiQr->id;
        }

        $absensi = Absensi::firstOrNew($kondisiCari);
        $absensi->fill([
            'kelas_id'            => $sesiQr->kelas_id,
            'tahun_ajaran_id'     => $sesiQr->kelas->tahun_ajaran_id,
            'mata_pelajaran_id'   => $sesiQr->mata_pelajaran_id,
            'jadwal_pelajaran_id' => $sesiQr->jadwal_pelajaran_id,
            'sesi_qr_id'          => $sesiQr->id,
            'dicatat_oleh'        => Auth::id(),
            'status'              => $validated['status'],
            'metode'              => 'manual',
            'keterangan'          => $validated['keterangan'],
        ])->save();

        return back()->with('success', 'Absensi berhasil dikoreksi.');
    }

    // ── REALTIME STATUS (Ajax polling) ────────────────────────────────────────

    public function statusAjax(SesiQr $sesiQr)
    {
        $sudahScan = $sesiQr->riwayatScan()
            ->where('status', 'valid')
            ->with('siswa:id,nama_lengkap,nis')
            ->get()
            ->map(fn ($r) => [
                'siswa_id'     => $r->siswa_id,
                'nama'         => $r->siswa->nama_lengkap ?? '—',
                'nis'          => $r->siswa->nis ?? '—',
                'di_scan_pada' => $r->dipindai_pada->format('H:i:s'),
            ]);

        return response()->json([
            'is_valid'      => $sesiQr->isValid(),
            'is_kadaluarsa' => $sesiQr->isKadaluarsa(),
            'jumlah_scan'   => $sesiQr->jumlah_scan,
            'sudah_scan'    => $sudahScan,
            'sisa_waktu'    => max(0, now()->diffInSeconds($sesiQr->kadaluarsa_pada, false)),
        ]);
    }

    // ── EXPORT PDF ────────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $query = SesiQr::with(['kelas', 'mataPelajaran', 'guru', 'dibuatOleh'])
            ->withCount([
                'riwayatScan',
                'riwayatScan as scan_valid_count' => fn ($q) => $q->where('status', 'valid'),
            ]);

        if ($request->filled('kelas_id'))  $query->where('kelas_id', $request->kelas_id);
        if ($request->filled('tanggal'))   $query->whereDate('tanggal', $request->tanggal);
        if ($request->filled('is_active')) $query->where('is_active', $request->boolean('is_active'));

        $sesiQrs = $query->latest()->get();

        $pdf = Pdf::loadView('admin.sesi-qr.exports.pdf', compact('sesiQrs'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('sesi_qr_' . now()->format('Ymd_His') . '.pdf');
    }

    // ── EXPORT EXCEL ─────────────────────────────────────────────────────────

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new SesiQrExport($request->only(['kelas_id', 'tanggal', 'is_active'])),
            'sesi_qr_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    // ── DESTROY ───────────────────────────────────────────────────────────────

    public function destroy(SesiQr $sesiQr)
    {
        if ($sesiQr->riwayatScan()->where('status', 'valid')->exists()) {
            return back()->with('error', 'Tidak dapat menghapus sesi yang sudah memiliki scan valid. Nonaktifkan saja.');
        }

        $sesiQr->delete();

        return redirect()->route('admin.sesi-qr.index')
            ->with('success', 'Sesi QR berhasil dihapus.');
    }
}