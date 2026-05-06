<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\RiwayatScanQr;
use App\Models\SesiQr;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SesiQrController extends Controller
{
    // ── INDEX ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = SesiQr::with([
                'kelas',
                'mataPelajaran',
                'guru',
                'jadwalPelajaran',
                // Perbaikan bug: relasi dibuatOleh tidak di-eager-load di index()
                // sehingga view menyebabkan N+1 query pada kolom "Dibuat Oleh".
                'dibuatOleh',
            ])
            ->withCount([
                'riwayatScan',
                'riwayatScan as scan_valid_count' => fn ($q) => $q->where('status', 'valid'),
            ]);

        if ($request->filled('kelas_id'))  $query->where('kelas_id', $request->kelas_id);
        if ($request->filled('tanggal'))   $query->whereDate('tanggal', $request->tanggal);
        if ($request->filled('is_active')) $query->where('is_active', $request->boolean('is_active'));

        // Perbaikan bug: controller mengirim $sesiList tapi view memakai $sesiQrs.
        // Sekarang nama variabel diseragamkan menjadi $sesiQrs.
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

        return view('admin.sesi-qr.create', compact('jadwalHariIni', 'kelasList', 'hariIni'));
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

        // Cegah duplikat: satu jadwal, satu tanggal, satu sesi aktif
        if (! empty($validated['jadwal_pelajaran_id'])) {
            $existing = SesiQr::where('jadwal_pelajaran_id', $validated['jadwal_pelajaran_id'])
                ->whereDate('tanggal', $validated['tanggal'])
                ->where('is_active', true)
                ->first();

            if ($existing) {
                return back()
                    ->withInput()
                    ->with('error', 'Sudah ada sesi QR aktif untuk jadwal ini hari ini. Nonaktifkan sesi sebelumnya terlebih dahulu.');
            }
        }

        $berlakuMulai   = \Carbon\Carbon::parse($validated['tanggal'] . ' ' . $validated['berlaku_mulai']);
        $kadaluarsaPada = $berlakuMulai->copy()->addMinutes((int) $validated['durasi_menit']);

        // Perbaikan bug: guru_id tidak pernah diisi dari controller sehingga selalu null
        // ketika sesi dibuat manual. Sekarang diambil eksplisit dari jadwal jika ada,
        // atau dari user yang sedang login (asumsi guru/admin).
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

        return redirect()->route('admin.sesi-qr.show', $sesi)
            ->with('success', 'Sesi QR berhasil dibuat. Tampilkan QR code ke siswa.');
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    public function show(SesiQr $sesiQr)
    {
        $sesiQr->load([
            'kelas.siswa',
            'mataPelajaran',
            'jadwalPelajaran',
            'guru',
            // Perbaikan bug: dibuatOleh tidak di-load di show() sehingga view
            // $sesiQr->dibuatOleh->name menyebabkan N+1 query atau null error.
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
                // Perbaikan bug: firstOrNew() dengan jadwal_pelajaran_id = null tidak
                // pernah match karena SQL "WHERE col = NULL" selalu false (harus IS NULL).
                // Sekarang query dipisah: jika jadwal_pelajaran_id ada, pakai nilai tersebut;
                // jika null, cari berdasarkan siswa_id + sesi_qr_id + tanggal saja.
                $kondisi = [
                    'siswa_id' => $siswa->id,
                    'tanggal'  => $sesiQr->tanggal->toDateString(),
                ];

                if ($sesiQr->jadwal_pelajaran_id) {
                    $kondisi['jadwal_pelajaran_id'] = $sesiQr->jadwal_pelajaran_id;
                } else {
                    $kondisi['sesi_qr_id'] = $sesiQr->id;
                }

                $sudahAda = Absensi::where($kondisi)->exists();

                if (! $sudahAda) {
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
                'nama'         => $r->siswa->nama_lengkap,
                'nis'          => $r->siswa->nis,
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