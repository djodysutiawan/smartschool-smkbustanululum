<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGuru;
use App\Models\Guru;
use App\Models\JadwalPiketGuru;
use App\Models\SesiQrGuru;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * AbsensiGuruController (Piket)
 *
 * Digunakan oleh role 'guru_piket' untuk mencatat absensi guru lain.
 *
 * Perbedaan utama vs Admin\AbsensiGuruController:
 *  - Piket tidak bisa edit/delete data yang sudah ada (hanya admin)
 *  - Piket tidak bisa input untuk tanggal jauh ke belakang / depan (max H-1)
 *  - Piket melihat semua absensi hari ini (bukan hanya yang dia catat sendiri)
 *  - Scan QR divalidasi lewat SesiQrGuru (kode_qr + masihBerlaku())
 *  - Export PDF harian ada — untuk diserahkan ke TU / kepala sekolah
 *
 * Views: resources/views/piket/absensi-guru/
 */
class AbsensiGuruController extends Controller
{
    private const VIEW_PREFIX = 'piket.absensi-guru.';

    /**
     * Batas tanggal input — piket hanya boleh input H-1 s/d hari ini.
     * Tanggal lebih lama = wewenang admin untuk koreksi.
     */
    private const BATAS_HARI_LALU = 1;

    /**
     * Jam batas telat default. Idealnya diambil dari config/setting sekolah.
     */
    private const JAM_BATAS_TELAT = '07:15';

    // ── DASHBOARD ─────────────────────────────────────────────────────────────

    /**
     * Dashboard absensi guru hari ini.
     *
     * Menampilkan:
     *  - Rekap status (hadir, izin, sakit, alfa)
     *  - Daftar guru yang belum tercatat hari ini
     *  - Daftar guru piket yang berjaga hari ini (dari JadwalPiketGuru)
     *  - Semua absensi yang sudah masuk hari ini
     *  - Sesi QR aktif (jika ada)
     */
    public function dashboard(): View
    {
        $hariIni = today();

        // ── Rekap status hari ini ─────────────────────────────────────────────
        $rekapRaw = AbsensiGuru::whereDate('tanggal', $hariIni)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $rekapHariIni = [
            'hadir' => ($rekapRaw['hadir'] ?? 0) + ($rekapRaw['telat'] ?? 0),
            'telat' => $rekapRaw['telat']  ?? 0,
            'izin'  => $rekapRaw['izin']   ?? 0,
            'sakit' => $rekapRaw['sakit']  ?? 0,
            'alfa'  => $rekapRaw['alfa']   ?? 0,
        ];

        $totalGuru = Guru::aktif()->count();

        // ── Guru yang belum tercatat hari ini ─────────────────────────────────
        $guruSudahAbsenIds = AbsensiGuru::whereDate('tanggal', $hariIni)
            ->pluck('guru_id');

        $guruBelumAbsen = Guru::aktif()
            ->whereNotIn('id', $guruSudahAbsenIds)
            ->orderBy('nama_lengkap')
            ->get();

        // ── Guru piket yang berjaga hari ini ──────────────────────────────────
        $namaHariIni      = strtolower(Carbon::now()->locale('id')->isoFormat('dddd'));
        $guruPiketHariIni = JadwalPiketGuru::with('guru')
            ->where('hari', $namaHariIni)
            ->where('is_active', true)
            ->get();

        // ── Semua absensi yang sudah tercatat hari ini ────────────────────────
        $absensiHariIni = AbsensiGuru::with(['guru', 'pencatat'])
            ->whereDate('tanggal', $hariIni)
            ->orderBy('jam_masuk')
            ->get();

        // ── Sesi QR guru aktif ────────────────────────────────────────────────
        $sesiQrAktif = SesiQrGuru::aktif()->first();

        return view(self::VIEW_PREFIX . 'dashboard', compact(
            'rekapHariIni',
            'totalGuru',
            'guruBelumAbsen',
            'guruPiketHariIni',
            'absensiHariIni',
            'sesiQrAktif',
        ));
    }

    // ── ABSENSI MASSAL ────────────────────────────────────────────────────────

    /**
     * Form absensi massal — semua guru dalam satu halaman.
     */
    public function massalForm(Request $request): View
    {
        $tanggal = $request->filled('tanggal')
            ? $request->tanggal
            : today()->toDateString();

        // Guard: jangan izinkan tanggal terlalu jauh ke belakang atau ke depan
        $tanggalCarbon = Carbon::parse($tanggal);
        $batasMinimum  = today()->subDays(self::BATAS_HARI_LALU);
        $batasMaksimum = today();

        if ($tanggalCarbon->lt($batasMinimum) || $tanggalCarbon->gt($batasMaksimum)) {
            $tanggal = today()->toDateString();
        }

        $guruList   = Guru::aktif()->orderBy('nama_lengkap')->get();
        $statusList = AbsensiGuru::STATUS_LIST;

        // Data absensi yang sudah ada — agar piket tidak double-input
        $absensiExisting = AbsensiGuru::with('pencatat')
            ->whereDate('tanggal', $tanggal)
            ->get()
            ->keyBy('guru_id');

        // Info guru piket hari ini
        $namaHariIni      = strtolower(Carbon::parse($tanggal)->locale('id')->isoFormat('dddd'));
        $guruPiketHariIni = JadwalPiketGuru::with('guru')
            ->where('hari', $namaHariIni)
            ->where('is_active', true)
            ->get();

        $tanggalMin = today()->subDays(self::BATAS_HARI_LALU)->toDateString();
        $tanggalMax = today()->toDateString();

        return view(self::VIEW_PREFIX . 'massal', compact(
            'tanggal',
            'guruList',
            'statusList',
            'absensiExisting',
            'guruPiketHariIni',
            'tanggalMin',
            'tanggalMax',
        ));
    }

    /**
     * Simpan absensi massal.
     *
     * Gunakan updateOrCreate agar:
     *  - Jika guru belum absen → buat baru
     *  - Jika sudah ada (misal dari QR) → update (piket bisa koreksi keterangan)
     *
     * Khusus record dari QR: hanya jam_keluar & keterangan yang diupdate.
     */
    public function massalStore(Request $request): RedirectResponse
    {
        $request->validate([
            'tanggal'              => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $tgl = Carbon::parse($value);
                    if ($tgl->lt(today()->subDays(self::BATAS_HARI_LALU))) {
                        $fail('Tanggal terlalu jauh ke belakang. Piket hanya bisa input untuk hari ini atau kemarin.');
                    }
                    if ($tgl->gt(today())) {
                        $fail('Tidak bisa input absensi untuk tanggal mendatang.');
                    }
                },
            ],
            'absensi'              => ['required', 'array', 'min:1'],
            'absensi.*.guru_id'    => ['required', 'exists:guru,id'],
            'absensi.*.status'     => ['required', Rule::in(AbsensiGuru::STATUS_LIST)],
            'absensi.*.jam_masuk'  => ['nullable', 'date_format:H:i'],
            'absensi.*.jam_keluar' => [
                'nullable',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    if (! $value) return;
                    preg_match('/absensi\.(\d+)\.jam_keluar/', $attribute, $matches);
                    $index    = $matches[1] ?? null;
                    $jamMasuk = $index !== null
                        ? $request->input("absensi.{$index}.jam_masuk")
                        : null;
                    if ($jamMasuk && $value <= $jamMasuk) {
                        $fail('Jam keluar harus setelah jam masuk.');
                    }
                },
            ],
            'absensi.*.keterangan' => ['nullable', 'string', 'max:500'],
        ], [
            'tanggal.required'           => 'Tanggal absensi wajib diisi.',
            'absensi.required'           => 'Data absensi tidak boleh kosong.',
            'absensi.*.guru_id.required' => 'Data guru tidak valid.',
            'absensi.*.status.required'  => 'Status absensi wajib diisi.',
            'absensi.*.status.in'        => 'Status absensi tidak valid.',
        ]);

        $dicatatOleh = Auth::id();
        $tanggal     = $request->tanggal;
        $berhasil    = 0;
        $dilewati    = 0;

        foreach ($request->absensi as $data) {
            $existing = AbsensiGuru::where('guru_id', $data['guru_id'])
                ->whereDate('tanggal', $tanggal)
                ->first();

            if ($existing && $existing->metode === 'qr') {
                // Hanya update jam_keluar dan keterangan, pertahankan status QR
                $existing->update([
                    'jam_keluar'   => $data['jam_keluar']  ?? $existing->jam_keluar,
                    'keterangan'   => $data['keterangan']  ?? $existing->keterangan,
                    'dicatat_oleh' => $dicatatOleh,
                ]);
                $dilewati++;
            } else {
                AbsensiGuru::updateOrCreate(
                    [
                        'guru_id' => $data['guru_id'],
                        'tanggal' => $tanggal,
                    ],
                    [
                        'status'       => $data['status'],
                        'jam_masuk'    => $data['jam_masuk']  ?? null,
                        'jam_keluar'   => $data['jam_keluar'] ?? null,
                        'keterangan'   => $data['keterangan'] ?? null,
                        'dicatat_oleh' => $dicatatOleh,
                        'metode'       => 'manual',
                    ]
                );
                $berhasil++;
            }
        }

        $pesan = "Absensi {$berhasil} guru berhasil disimpan untuk tanggal {$tanggal}.";
        if ($dilewati > 0) {
            $pesan .= " {$dilewati} guru sudah absen via QR (hanya keterangan yang diperbarui).";
        }

        return redirect()->route('piket.absensi-guru.dashboard')
            ->with('success', $pesan);
    }

    // ── RIWAYAT ───────────────────────────────────────────────────────────────

    /**
     * Riwayat absensi guru — semua yang tercatat, termasuk milik piket shift lain.
     * Filter tambahan: dicatat_oleh (opsional, untuk filter "saya saja").
     */
    public function riwayat(Request $request): View
    {
        $query = AbsensiGuru::with(['guru', 'pencatat'])
            ->orderByDesc('tanggal')
            ->orderBy('jam_masuk');

        // Default: tampilkan 7 hari terakhir
        if (! $request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', today()->subDays(6));
        } else {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('guru_id')) {
            $query->where('guru_id', (int) $request->guru_id);
        }

        if ($request->filled('status') && in_array($request->status, AbsensiGuru::STATUS_LIST)) {
            $query->where('status', $request->status);
        }

        if ($request->boolean('saya_saja')) {
            $query->where('dicatat_oleh', Auth::id());
        }

        $riwayat    = $query->paginate(25)->withQueryString();
        $guruList   = Guru::aktif()->orderBy('nama_lengkap')->get();
        $statusList = AbsensiGuru::STATUS_LIST;

        return view(self::VIEW_PREFIX . 'riwayat', compact(
            'riwayat',
            'guruList',
            'statusList',
        ));
    }

    // ── SCAN QR ───────────────────────────────────────────────────────────────

    /**
     * Halaman scan QR guru.
     *
     * Piket memverifikasi guru yang scan QR dari ponsel,
     * atau scan langsung menggunakan kamera di pos piket.
     */
    public function scanQr(): View
    {
        $sesiQrAktif = SesiQrGuru::aktif()
            ->with('pembuat:id,name')
            ->first();

        // Absensi yang sudah masuk hari ini via QR (untuk live feedback)
        $sudahScanHariIni = AbsensiGuru::with('guru:id,nama_lengkap,nip')
            ->whereDate('tanggal', today())
            ->where('metode', 'qr')
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();

        return view(self::VIEW_PREFIX . 'scan-qr', compact(
            'sesiQrAktif',
            'sudahScanHariIni',
        ));
    }

    /**
     * Proses hasil scan QR guru.
     *
     * Model SesiQrGuru menyimpan kode_qr (UUID) — bukan token terpisah.
     * Flow:
     *  1. Piket scan QR → frontend kirim kode_qr ke sini
     *  2. Cari SesiQrGuru berdasarkan kode_qr yang masih aktif (masihBerlaku())
     *  3. Catat absensi guru (hadir/telat otomatis berdasarkan jam)
     *
     * kode_qr di-rotate oleh SesiQrGuruController::refreshKodeQr()
     * sehingga QR lama tidak bisa dipakai ulang setelah di-refresh.
     */
    public function prosesQr(Request $request): RedirectResponse
    {
        $request->validate([
            'kode_qr'  => ['required', 'string', 'uuid'],
            'guru_id'  => ['required', 'exists:guru,id'],
            'status'   => ['nullable', Rule::in(AbsensiGuru::STATUS_LIST)],
        ], [
            'kode_qr.required' => 'Data QR tidak boleh kosong.',
            'kode_qr.uuid'     => 'Format kode QR tidak valid.',
            'guru_id.required' => 'Data guru tidak boleh kosong.',
        ]);

        // ── Validasi sesi QR ──────────────────────────────────────────────────
        // Cari sesi berdasarkan kode_qr yang masih berlaku
        $sesiQr = SesiQrGuru::where('kode_qr', $request->kode_qr)->first();

        if (! $sesiQr) {
            return back()
                ->with('error', 'Kode QR tidak ditemukan. Pastikan guru scan QR yang benar.')
                ->withInput();
        }

        if (! $sesiQr->masihBerlaku()) {
            return back()
                ->with('error', 'Sesi QR sudah tidak aktif atau telah kedaluwarsa. Minta piket membuka sesi QR baru.')
                ->withInput();
        }

        // ── Validasi guru ─────────────────────────────────────────────────────
        $guru = Guru::find((int) $request->guru_id);

        if (! $guru || ! $guru->isAktif()) {
            return back()
                ->with('error', 'Data guru tidak ditemukan atau sudah tidak aktif.')
                ->withInput();
        }

        // ── Cek duplikat ──────────────────────────────────────────────────────
        $sudahAbsen = AbsensiGuru::where('guru_id', $guru->id)
            ->whereDate('tanggal', today())
            ->exists();

        if ($sudahAbsen) {
            return back()->with('warning', "Guru {$guru->nama_lengkap} sudah tercatat absen hari ini.");
        }

        // ── Tentukan status otomatis berdasarkan jam ──────────────────────────
        $jamMasukSekarang = now()->format('H:i');

        if ($request->filled('status')) {
            $status = $request->status;
        } else {
            $status = ($jamMasukSekarang > self::JAM_BATAS_TELAT) ? 'telat' : 'hadir';
        }

        // ── Simpan absensi ────────────────────────────────────────────────────
        AbsensiGuru::create([
            'guru_id'      => $guru->id,
            'tanggal'      => today(),
            'status'       => $status,
            'jam_masuk'    => $jamMasukSekarang,
            'dicatat_oleh' => Auth::id(),
            'metode'       => 'qr',
        ]);

        $labelStatus = $status === 'telat' ? 'TELAT' : 'hadir';

        return back()->with('success', "Absensi {$guru->nama_lengkap} berhasil dicatat ({$labelStatus}) via QR — {$jamMasukSekarang}.");
    }

    // ── EXPORT PDF ────────────────────────────────────────────────────────────

    /**
     * Export rekap absensi guru harian ke PDF.
     * Piket hanya bisa export per tanggal — export multi-periode ada di admin.
     */
    public function exportPdf(Request $request): mixed
    {
        $tanggal = $request->input('tanggal', today()->toDateString());

        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
            $tanggal = today()->toDateString();
        }

        // Guard: tidak bisa export tanggal mendatang
        if (Carbon::parse($tanggal)->gt(today())) {
            return back()->with('error', 'Tidak bisa export absensi untuk tanggal mendatang.');
        }

        $absensiList = AbsensiGuru::with(['guru', 'pencatat'])
            ->whereDate('tanggal', $tanggal)
            ->orderByRaw("FIELD(status, 'hadir', 'telat', 'izin', 'sakit', 'alfa')")
            ->orderBy('jam_masuk')
            ->get();

        $sudahAbsenIds = $absensiList->pluck('guru_id');
        $belumAbsen    = Guru::aktif()
            ->whereNotIn('id', $sudahAbsenIds)
            ->orderBy('nama_lengkap')
            ->get();

        $rekap = [
            'hadir' => $absensiList->whereIn('status', ['hadir', 'telat'])->count(),
            'telat' => $absensiList->where('status', 'telat')->count(),
            'izin'  => $absensiList->where('status', 'izin')->count(),
            'sakit' => $absensiList->where('status', 'sakit')->count(),
            'alfa'  => $absensiList->where('status', 'alfa')->count(),
            'belum' => $belumAbsen->count(),
            'total' => Guru::aktif()->count(),
        ];

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        $meta = [
            'tanggal'      => $tanggal,
            'dicetak_pada' => now()->isoFormat('D MMMM Y, HH:mm'),
            'dicetak_oleh' => $authUser->name,
        ];

        $pdf = Pdf::loadView(
            self::VIEW_PREFIX . 'export-pdf',
            compact('absensiList', 'belumAbsen', 'rekap', 'meta')
        )->setPaper('a4', 'portrait');

        return $pdf->download('absensi-guru-' . $tanggal . '.pdf');
    }
}