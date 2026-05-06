<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\KenaikanKelas;
use App\Models\KenaikanKelasDetail;
use App\Models\RiwayatKelasSiswa;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KenaikanKelasController extends Controller
{
    private const MIN_KEHADIRAN_PERSEN = 75.0;
    private const MIN_RATA_RATA_NILAI  = 65.0;

    // ── INDEX ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $batch = KenaikanKelas::with(['tahunAjaranAsal', 'tahunAjaranTujuan', 'diprosesOleh'])
            ->latest()
            ->paginate(15);

        return view('admin.kenaikan-kelas.index', compact('batch'));
    }

    // ── FORM PERSIAPAN ────────────────────────────────────────────────────────

    public function create()
    {
        $tahunAjarans = TahunAjaran::orderByDesc('id')->get();
        return view('admin.kenaikan-kelas.create', compact('tahunAjarans'));
    }

    // ── PREVIEW ───────────────────────────────────────────────────────────────

    public function preview(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran_asal_id'   => ['required', 'exists:tahun_ajaran,id'],
            'tahun_ajaran_tujuan_id' => ['required', 'exists:tahun_ajaran,id',
                'different:tahun_ajaran_asal_id'],
            'dari_tingkat'           => ['required', 'in:X,XI,XII'],
        ], [
            'tahun_ajaran_asal_id.required'   => 'Tahun ajaran asal wajib dipilih.',
            'tahun_ajaran_tujuan_id.required' => 'Tahun ajaran tujuan wajib dipilih.',
            'tahun_ajaran_tujuan_id.different' => 'Tahun ajaran tujuan harus berbeda dari asal.',
            'dari_tingkat.required'           => 'Tingkat wajib dipilih.',
        ]);

        $sudahAda = KenaikanKelas::where('tahun_ajaran_asal_id', $validated['tahun_ajaran_asal_id'])
            ->where('tahun_ajaran_tujuan_id', $validated['tahun_ajaran_tujuan_id'])
            ->where('dari_tingkat', $validated['dari_tingkat'])
            ->where('status', KenaikanKelas::STATUS_SELESAI)
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Proses kenaikan kelas untuk kombinasi ini sudah pernah diselesaikan.');
        }

        $keTingkat = match ($validated['dari_tingkat']) {
            'X'   => 'XI',
            'XI'  => 'XII',
            'XII' => 'lulus',
        };

        $kelasList = Kelas::with('siswa')
            ->where('tahun_ajaran_id', $validated['tahun_ajaran_asal_id'])
            ->where('tingkat', $validated['dari_tingkat'])
            ->where('status', 'aktif')
            ->get();

        if ($kelasList->isEmpty()) {
            return back()->with('error', "Tidak ada kelas tingkat {$validated['dari_tingkat']} aktif pada tahun ajaran yang dipilih.");
        }

        $kelasTujuanList = $keTingkat !== 'lulus'
            ? Kelas::where('tahun_ajaran_id', $validated['tahun_ajaran_tujuan_id'])
                ->where('tingkat', $keTingkat)
                ->where('status', 'aktif')
                ->with('jurusan')
                ->get()
            : collect();

        $evaluasi = [];
        foreach ($kelasList as $kelas) {
            foreach ($kelas->siswa as $siswa) {
                $evaluasi[] = $this->evaluasiSiswa(
                    $siswa,
                    $kelas,
                    $validated['tahun_ajaran_asal_id'],
                    $keTingkat,
                    $kelasTujuanList,
                );
            }
        }

        $taAsal   = TahunAjaran::find($validated['tahun_ajaran_asal_id']);
        $taTujuan = TahunAjaran::find($validated['tahun_ajaran_tujuan_id']);

        return view('admin.kenaikan-kelas.preview', compact(
            'evaluasi', 'kelasList', 'kelasTujuanList',
            'taAsal', 'taTujuan', 'keTingkat', 'validated'
        ));
    }

    // ── STORE ─────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran_asal_id'   => ['required', 'exists:tahun_ajaran,id'],
            'tahun_ajaran_tujuan_id' => ['required', 'exists:tahun_ajaran,id'],
            'dari_tingkat'           => ['required', 'in:X,XI,XII'],
            'siswa'                  => ['required', 'array', 'min:1'],
            'siswa.*.siswa_id'       => ['required', 'exists:siswa,id'],
            'siswa.*.keputusan'      => ['required', 'in:naik_kelas,tidak_naik,lulus'],
            'siswa.*.kelas_tujuan_id'=> ['nullable', 'exists:kelas,id'],
        ]);

        $sudahAda = KenaikanKelas::where('tahun_ajaran_asal_id', $request->tahun_ajaran_asal_id)
            ->where('tahun_ajaran_tujuan_id', $request->tahun_ajaran_tujuan_id)
            ->where('dari_tingkat', $request->dari_tingkat)
            ->where('status', KenaikanKelas::STATUS_SELESAI)
            ->exists();

        if ($sudahAda) {
            return back()->withInput()
                ->with('error', 'Proses kenaikan kelas untuk kombinasi ini sudah pernah diselesaikan.');
        }

        foreach ($request->siswa as $item) {
            if ($item['keputusan'] === 'naik_kelas' && empty($item['kelas_tujuan_id'])) {
                return back()->withInput()
                    ->with('error', 'Setiap siswa yang naik kelas harus ditentukan kelas tujuannya.');
            }
        }

        $keTingkat = match ($request->dari_tingkat) {
            'X'   => 'XI',
            'XI'  => 'XII',
            'XII' => 'lulus',
        };

        DB::transaction(function () use ($request, $keTingkat) {
            $naik = 0; $tidakNaik = 0; $lulus = 0;

            /**
             * PERBAIKAN: Gunakan STATUS_DIPROSES bukan langsung 'diproses'.
             * Konsisten dengan konstanta model.
             */
            $batch = KenaikanKelas::create([
                'tahun_ajaran_asal_id'   => $request->tahun_ajaran_asal_id,
                'tahun_ajaran_tujuan_id' => $request->tahun_ajaran_tujuan_id,
                'dari_tingkat'           => $request->dari_tingkat,
                'ke_tingkat'             => $keTingkat,
                'diproses_oleh'          => Auth::id(),
                'diproses_pada'          => now(),
                'status'                 => KenaikanKelas::STATUS_DIPROSES,
                'total_siswa'            => count($request->siswa),
                'catatan'                => $request->catatan,
            ]);

            foreach ($request->siswa as $item) {
                $siswa = Siswa::find($item['siswa_id']);

                // Cari kelas asal siswa di tahun ajaran ini
                $kelasAsal = Kelas::where('tahun_ajaran_id', $request->tahun_ajaran_asal_id)
                    ->where('status', 'aktif')
                    ->whereHas('siswa', fn($q) => $q->where('siswa.id', $siswa->id))
                    ->first();

                if (! $kelasAsal) {
                    $kelasAsal = Kelas::where('id', $siswa->kelas_id)
                        ->where('tahun_ajaran_id', $request->tahun_ajaran_asal_id)
                        ->first();

                    if (! $kelasAsal) {
                        throw new \RuntimeException(
                            "Kelas asal tidak ditemukan untuk siswa: {$siswa->nama_lengkap} (ID: {$siswa->id})"
                        );
                    }
                }

                $snapshot = $this->snapshotSiswa($siswa->id, $kelasAsal->id, $request->tahun_ajaran_asal_id);

                KenaikanKelasDetail::create([
                    'kenaikan_kelas_id'         => $batch->id,
                    'siswa_id'                  => $siswa->id,
                    'kelas_asal_id'             => $kelasAsal->id,
                    'kelas_tujuan_id'           => $item['kelas_tujuan_id'] ?? null,
                    'keputusan'                 => $item['keputusan'],
                    'rata_rata_nilai'           => $snapshot['rata_rata'],
                    'total_hadir'               => $snapshot['hadir'],
                    'total_pertemuan'           => $snapshot['total'],
                    'persentase_kehadiran'      => $snapshot['persen'],
                    'memenuhi_syarat_nilai'     => $snapshot['rata_rata'] >= self::MIN_RATA_RATA_NILAI,
                    'memenuhi_syarat_kehadiran' => $snapshot['persen'] >= self::MIN_KEHADIRAN_PERSEN,
                    'catatan'                   => $item['catatan'] ?? null,
                ]);

                $statusAkhirRiwayat = match ($item['keputusan']) {
                    'naik_kelas' => RiwayatKelasSiswa::STATUS_NAIK_KELAS,
                    'tidak_naik' => RiwayatKelasSiswa::STATUS_TIDAK_NAIK,
                    'lulus'      => RiwayatKelasSiswa::STATUS_LULUS,
                    default      => RiwayatKelasSiswa::STATUS_AKTIF,
                };

                // Tutup riwayat kelas asal
                RiwayatKelasSiswa::where('siswa_id', $siswa->id)
                    ->where('tahun_ajaran_id', $request->tahun_ajaran_asal_id)
                    ->where('status_akhir', RiwayatKelasSiswa::STATUS_AKTIF)
                    ->update([
                        'status_akhir'         => $statusAkhirRiwayat,
                        'tanggal_keluar_kelas' => today(),
                        'dicatat_oleh'         => Auth::id(),
                    ]);

                if ($item['keputusan'] === 'naik_kelas') {
                    // Pindahkan ke kelas tujuan
                    $siswa->update(['kelas_id' => $item['kelas_tujuan_id']]);

                    // Buat riwayat baru di kelas tujuan
                    RiwayatKelasSiswa::create([
                        'siswa_id'            => $siswa->id,
                        'kelas_id'            => $item['kelas_tujuan_id'],
                        'tahun_ajaran_id'     => $request->tahun_ajaran_tujuan_id,
                        'tingkat'             => $keTingkat,
                        'status_akhir'        => RiwayatKelasSiswa::STATUS_AKTIF,
                        'tanggal_masuk_kelas' => today(),
                        'dicatat_oleh'        => Auth::id(),
                    ]);

                    $naik++;

                } elseif ($item['keputusan'] === 'tidak_naik') {
                    /**
                     * PERBAIKAN: Siswa tidak naik — kelas_id diset ke NULL dulu
                     * karena kelas di tahun ajaran lama tidak valid untuk TA baru.
                     * Admin harus assign kelas baru di TA tujuan via halaman siswa.
                     *
                     * Ini lebih aman daripada biarkan kelas_id tetap menunjuk
                     * ke kelas TA lama yang membingungkan.
                     *
                     * Status siswa tetap 'aktif' — siswa belum lulus/keluar.
                     */
                    $siswa->update(['kelas_id' => null]);

                    $tidakNaik++;

                } elseif ($item['keputusan'] === 'lulus') {
                    $siswa->update([
                        'status'         => 'lulus',
                        'tanggal_keluar' => today(),
                        'tanggal_lulus'  => today(), // Ada setelah migrasi fix dijalankan
                        'kelas_id'       => null,    // Lepas dari kelas karena sudah lulus
                    ]);

                    $lulus++;
                }
            }

            $batch->update([
                'status'     => KenaikanKelas::STATUS_SELESAI,
                'naik_kelas' => $naik,
                'tidak_naik' => $tidakNaik,
                'lulus'      => $lulus,
            ]);
        });

        return redirect()->route('admin.kenaikan-kelas.index')
            ->with('success', 'Proses kenaikan kelas berhasil diselesaikan.');
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    public function show(KenaikanKelas $kenaikanKelas)
    {
        $kenaikanKelas->load([
            'tahunAjaranAsal',
            'tahunAjaranTujuan',
            'diprosesOleh',
            'detail.siswa',
            'detail.kelasAsal.jurusan',
            'detail.kelasTujuan',
        ]);

        return view('admin.kenaikan-kelas.show', compact('kenaikanKelas'));
    }

    // ── BATALKAN ──────────────────────────────────────────────────────────────

    public function batalkan(KenaikanKelas $kenaikanKelas)
    {
        /**
         * PERBAIKAN: Gunakan bisaDibatalkan() yang sudah diperbaiki di model
         * (sekarang mencakup STATUS_DRAFT dan STATUS_DIPROSES).
         */
        if (! $kenaikanKelas->bisaDibatalkan()) {
            return back()->with('error', 'Hanya proses dengan status "draft" atau "diproses" yang dapat dibatalkan.');
        }

        $kenaikanKelas->update(['status' => KenaikanKelas::STATUS_DIBATALKAN]);

        return back()->with('success', 'Proses kenaikan kelas dibatalkan.');
    }

    // ── SISWA TIDAK NAIK: ASSIGN KELAS BARU ──────────────────────────────────

    /**
     * TAMBAHAN: Endpoint untuk admin mengassign kelas baru
     * bagi siswa yang tidak naik kelas di tahun ajaran tujuan.
     *
     * Route: POST /admin/kenaikan-kelas/{kenaikanKelas}/assign-kelas-tidak-naik
     */
    public function assignKelasTidakNaik(Request $request, KenaikanKelas $kenaikanKelas)
    {
        if (! $kenaikanKelas->isSelesai()) {
            return back()->with('error', 'Hanya batch yang sudah selesai yang bisa diproses.');
        }

        $request->validate([
            'assignments'              => ['required', 'array', 'min:1'],
            'assignments.*.siswa_id'   => ['required', 'exists:siswa,id'],
            'assignments.*.kelas_id'   => ['required', 'exists:kelas,id'],
        ]);

        DB::transaction(function () use ($request, $kenaikanKelas) {
            foreach ($request->assignments as $item) {
                $siswa = Siswa::find($item['siswa_id']);
                $kelas = Kelas::find($item['kelas_id']);

                // Pastikan siswa ini memang punya keputusan tidak_naik di batch ini
                $detail = $kenaikanKelas->detail()
                    ->where('siswa_id', $siswa->id)
                    ->where('keputusan', KenaikanKelasDetail::KEPUTUSAN_TIDAK_NAIK)
                    ->first();

                if (! $detail) continue;

                // Update kelas_id siswa ke kelas baru
                $siswa->update(['kelas_id' => $kelas->id]);

                // Buat riwayat kelas baru di TA tujuan
                RiwayatKelasSiswa::updateOrCreate(
                    [
                        'siswa_id'        => $siswa->id,
                        'tahun_ajaran_id' => $kenaikanKelas->tahun_ajaran_tujuan_id,
                    ],
                    [
                        'kelas_id'            => $kelas->id,
                        'tingkat'             => $kelas->tingkat,
                        'status_akhir'        => RiwayatKelasSiswa::STATUS_AKTIF,
                        'tanggal_masuk_kelas' => today(),
                        'dicatat_oleh'        => Auth::id(),
                    ]
                );

                // Update kelas_tujuan_id di detail batch
                $detail->update(['kelas_tujuan_id' => $kelas->id]);
            }
        });

        return back()->with('success', 'Kelas untuk siswa tidak naik berhasil diassign.');
    }

    // ── Private Helpers ───────────────────────────────────────────────────────

    private function evaluasiSiswa(
        Siswa $siswa,
        Kelas $kelas,
        int $taAsalId,
        string $keTingkat,
        $kelasTujuanList,
    ): array {
        /**
         * PERBAIKAN: Kirim kelas->id ke snapshotSiswa agar absensi
         * difilter berdasarkan kelas spesifik siswa, bukan semua kelas TA.
         */
        $snapshot = $this->snapshotSiswa($siswa->id, $kelas->id, $taAsalId);

        $memenuhiNilai     = $snapshot['rata_rata'] >= self::MIN_RATA_RATA_NILAI;
        $memenuhiKehadiran = $snapshot['persen'] >= self::MIN_KEHADIRAN_PERSEN;
        $rekomendasiNaik   = $memenuhiNilai && $memenuhiKehadiran;

        $kelasTujuanRekomendasi = $kelasTujuanList->isNotEmpty()
            ? $kelasTujuanList->where('jurusan_id', $kelas->jurusan_id)->first()
            : null;

        return [
            'siswa'                    => $siswa,
            'kelas_asal'               => $kelas,
            'kelas_tujuan_rekomendasi' => $kelasTujuanRekomendasi,
            'rata_rata_nilai'          => $snapshot['rata_rata'],
            'persentase_kehadiran'     => $snapshot['persen'],
            'total_hadir'              => $snapshot['hadir'],
            'total_pertemuan'          => $snapshot['total'],
            'memenuhi_syarat_nilai'    => $memenuhiNilai,
            'memenuhi_syarat_kehadiran'=> $memenuhiKehadiran,
            'rekomendasi'              => $rekomendasiNaik ? 'naik_kelas' : 'tidak_naik',
            'ke_tingkat'               => $keTingkat,
        ];
    }

    /**
     * PERBAIKAN KRITIS: Tambah parameter $kelasId agar filter absensi
     * hanya dari kelas spesifik siswa ini, bukan semua kelas di TA.
     *
     * Sebelumnya: whereIn('kelas_id', Kelas::where('tahun_ajaran_id', ...)->pluck('id'))
     * → Bisa include absensi siswa di kelas lain (jika ada data historis duplikat)
     *
     * Sekarang: where('kelas_id', $kelasId) → pasti hanya kelas siswa ini.
     */
    private function snapshotSiswa(int $siswaId, int $kelasId, int $tahunAjaranId): array
    {
        // Kehadiran — filter berdasarkan kelas spesifik siswa
        $totalAbsensi = Absensi::where('siswa_id', $siswaId)
            ->where('kelas_id', $kelasId)
            ->count();

        $totalHadir = Absensi::where('siswa_id', $siswaId)
            ->where('kelas_id', $kelasId)
            ->whereIn('status', Absensi::STATUS_DIHITUNG_HADIR)
            ->count();

        $persen = $totalAbsensi > 0
            ? round($totalHadir / $totalAbsensi * 100, 2)
            : 0.0;

        // Nilai rata-rata dari tabel nilai
        $rataRata = 0.0;
        if (class_exists(\App\Models\Nilai::class)) {
            $rataRata = \App\Models\Nilai::where('siswa_id', $siswaId)
                ->where('tahun_ajaran_id', $tahunAjaranId)
                ->avg('nilai_akhir') ?? 0.0;
        }

        return [
            'total'     => $totalAbsensi,
            'hadir'     => $totalHadir,
            'persen'    => $persen,
            'rata_rata' => round((float) $rataRata, 2),
        ];
    }
}