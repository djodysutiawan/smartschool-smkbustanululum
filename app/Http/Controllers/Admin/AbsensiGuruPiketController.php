<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGuru;
use App\Models\Guru;
use App\Models\JadwalPiketGuru;
use App\Models\SesiQrGuru;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AbsensiGuruPiketController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Controller ini digunakan oleh GURU PIKET (bukan admin penuh).
    | Scope-nya terbatas: hanya bisa absen guru hari ini, tidak bisa
    | mengubah tanggal lain atau mengubah data historis.
    |--------------------------------------------------------------------------
    */

    // ─── DASHBOARD PIKET ─────────────────────────────────────────────────────

    /**
     * Dashboard utama guru piket.
     * Menampilkan:
     * - Daftar semua guru aktif + status hadir/belum hari ini
     * - Sesi QR aktif (jika ada)
     * - Ringkasan rekap hari ini
     */
    public function dashboard()
    {
        $today   = today();
        $hariIni = strtolower(Carbon::today()->locale('id')->isoFormat('dddd'));

        // Normalisasi nama hari ke enum yang disimpan di DB
        $hariMap = [
            'senin' => 'senin', 'selasa' => 'selasa', 'rabu' => 'rabu',
            'kamis' => 'kamis', 'jumat'  => 'jumat',  'sabtu' => 'sabtu',
            'monday' => 'senin', 'tuesday' => 'selasa', 'wednesday' => 'rabu',
            'thursday' => 'kamis', 'friday' => 'jumat', 'saturday' => 'sabtu',
        ];
        $hariKey = $hariMap[$hariIni] ?? 'senin';

        // Semua guru aktif beserta status absensinya hari ini
        $guruList = Guru::aktif()
            ->with(['absensiGuru' => fn ($q) => $q->whereDate('tanggal', $today)])
            ->orderBy('nama_lengkap')
            ->get()
            ->map(function ($guru) {
                $absensi = $guru->absensiGuru->first();
                return [
                    'guru'    => $guru,
                    'absensi' => $absensi,
                    'sudah_absen' => ! is_null($absensi),
                    'status'  => $absensi?->status ?? 'belum',
                ];
            });

        // Rekap hari ini
        $rekap = [
            'hadir'       => AbsensiGuru::whereIn('status', ['hadir', 'telat'])->whereDate('tanggal', $today)->count(),
            'izin'        => AbsensiGuru::where('status', 'izin')->whereDate('tanggal', $today)->count(),
            'sakit'       => AbsensiGuru::where('status', 'sakit')->whereDate('tanggal', $today)->count(),
            'alfa'        => AbsensiGuru::where('status', 'alfa')->whereDate('tanggal', $today)->count(),
            'belum_absen' => Guru::aktif()->count() - AbsensiGuru::whereDate('tanggal', $today)->count(),
        ];

        // Sesi QR aktif hari ini
        $sesiQrAktif = SesiQrGuru::aktif()->whereDate('tanggal', $today)->first();

        // Jadwal piket hari ini (siapa yang bertugas)
        $jadwalPiketHariIni = JadwalPiketGuru::where('hari', $hariKey)
            ->where('is_active', true)
            ->with('guru')
            ->get();

        return view('admin.absensi-guru-piket.dashboard', compact(
            'guruList', 'rekap', 'sesiQrAktif', 'jadwalPiketHariIni', 'today'
        ));
    }

    // ─── ABSEN MANUAL SATU GURU ───────────────────────────────────────────────

    /**
     * Form absen manual satu guru — diisi oleh guru piket.
     */
    public function absenManualForm(Guru $guru)
    {
        $today   = today();
        $absensi = AbsensiGuru::where('guru_id', $guru->id)
            ->whereDate('tanggal', $today)
            ->first();

        if ($absensi) {
            return redirect()->route('admin.absensi-guru-piket.dashboard')
                ->with('info', "{$guru->nama_lengkap} sudah diabsen hari ini dengan status: {$absensi->label_status}.");
        }

        return view('admin.absensi-guru-piket.manual-form', compact('guru') + [
            'statusList' => AbsensiGuru::STATUS_LIST,
        ]);
    }

    /**
     * Simpan absen manual dari guru piket.
     */
    public function absenManualStore(Request $request, Guru $guru)
    {
        // Cek duplikat lagi di server untuk keamanan
        $sudahAda = AbsensiGuru::where('guru_id', $guru->id)
            ->whereDate('tanggal', today())
            ->exists();

        if ($sudahAda) {
            return back()->with('error', "{$guru->nama_lengkap} sudah diabsen hari ini.");
        }

        $validated = $request->validate([
            'status'     => ['required', Rule::in(AbsensiGuru::STATUS_LIST)],
            'jam_masuk'  => ['nullable', 'date_format:H:i'],
            'keterangan' => ['nullable', 'string', 'max:500'],
            'path_surat_izin' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('path_surat_izin')) {
            $validated['path_surat_izin'] = $request->file('path_surat_izin')
                ->store('absensi-guru/surat-izin', 'public');
        }

        AbsensiGuru::create([
            'guru_id'      => $guru->id,
            'dicatat_oleh' => Auth::id(),
            'tanggal'      => today(),
            'jam_masuk'    => $validated['jam_masuk'] ?? now()->format('H:i'),
            'status'       => $validated['status'],
            'metode'       => 'manual',
            'keterangan'   => $validated['keterangan'] ?? null,
            'path_surat_izin' => $validated['path_surat_izin'] ?? null,
        ]);

        return redirect()->route('admin.absensi-guru-piket.dashboard')
            ->with('success', "Absensi {$guru->nama_lengkap} berhasil dicatat.");
    }

    // ─── ABSEN MASSAL (semua guru sekaligus) ──────────────────────────────────

    /**
     * Tampilkan form absen massal — semua guru yang belum absen hari ini.
     */
    public function absenMassalForm()
    {
        $today = today();

        // Ambil hanya guru yang BELUM diabsen hari ini
        $guruBelumAbsen = Guru::aktif()
            ->whereDoesntHave('absensiGuru', fn ($q) => $q->whereDate('tanggal', $today))
            ->orderBy('nama_lengkap')
            ->get();

        return view('admin.absensi-guru-piket.massal-form', compact('guruBelumAbsen') + [
            'statusList' => AbsensiGuru::STATUS_LIST,
        ]);
    }

    /**
     * Simpan absen massal — menerima array guru_id + status.
     */
    public function absenMassalStore(Request $request)
    {
        $request->validate([
            'absensi'              => ['required', 'array', 'min:1'],
            'absensi.*.guru_id'    => ['required', 'exists:guru,id'],
            'absensi.*.status'     => ['required', Rule::in(AbsensiGuru::STATUS_LIST)],
            'absensi.*.jam_masuk'  => ['nullable', 'date_format:H:i'],
            'absensi.*.keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        $today   = today();
        $userId  = Auth::id();
        $berhasil = 0;
        $dilewati = 0;

        foreach ($request->absensi as $data) {
            // Skip jika sudah ada
            $sudahAda = AbsensiGuru::where('guru_id', $data['guru_id'])
                ->whereDate('tanggal', $today)
                ->exists();

            if ($sudahAda) {
                $dilewati++;
                continue;
            }

            AbsensiGuru::create([
                'guru_id'      => $data['guru_id'],
                'dicatat_oleh' => $userId,
                'tanggal'      => $today,
                'jam_masuk'    => $data['jam_masuk'] ?? now()->format('H:i'),
                'status'       => $data['status'],
                'metode'       => 'manual',
                'keterangan'   => $data['keterangan'] ?? null,
            ]);

            $berhasil++;
        }

        $pesan = "{$berhasil} data absensi berhasil disimpan.";
        if ($dilewati > 0) {
            $pesan .= " {$dilewati} data dilewati karena sudah ada.";
        }

        return redirect()->route('admin.absensi-guru-piket.dashboard')
            ->with('success', $pesan);
    }

    // ─── HALAMAN SCAN QR ─────────────────────────────────────────────────────

    /**
     * Halaman untuk guru piket membuka scanner QR kamera.
     * Guru piket mengarahkan kamera ke QR Code yang dibawa/ditunjukkan guru.
     */
    public function halamanScanQr()
    {
        $today = today();

        $sesiAktif = SesiQrGuru::aktif()->whereDate('tanggal', $today)->first();

        if (! $sesiAktif) {
            return redirect()->route('admin.absensi-guru-piket.dashboard')
                ->with('error', 'Tidak ada sesi QR aktif untuk hari ini. Buat sesi terlebih dahulu.');
        }

        return view('admin.absensi-guru-piket.scan-qr', compact('sesiAktif'));
    }

    // ─── RIWAYAT ─────────────────────────────────────────────────────────────

    /**
     * Riwayat absensi yang dicatat oleh guru piket yang sedang login.
     */
    public function riwayat(Request $request)
    {
        $query = AbsensiGuru::with('guru')
            ->where('dicatat_oleh', Auth::id());

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $riwayat = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();

        return view('admin.absensi-guru-piket.riwayat', compact('riwayat') + [
            'statusList' => AbsensiGuru::STATUS_LIST,
        ]);
    }
}