<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGuru;
use App\Models\Guru;
use App\Models\JadwalPiketGuru;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * AbsensiGuruController
 *
 * Digunakan oleh role 'guru_piket' untuk menginput absensi guru lain.
 *
 * View diarahkan ke resources/views/piket/absensi-guru-piket/
 *
 * Fitur:
 *  - dashboard()    : rekap absensi guru hari ini
 *  - massalForm()   : form absensi massal semua guru hari ini
 *  - massalStore()  : simpan absensi massal
 *  - riwayat()      : riwayat absensi yang dicatat oleh piket ini
 *  - scanQr()       : halaman scan QR guru
 *  - prosesQr()     : proses hasil scan QR
 */
class AbsensiGuruController extends Controller
{
    private const STATUS_LIST = ['hadir', 'telat', 'izin', 'sakit', 'alfa'];

    /**
     * Prefix view — semua view berada di piket/absensi-guru-piket/
     */
    private const VIEW_PREFIX = 'piket.absensi-guru-piket.';

    // ── DASHBOARD ─────────────────────────────────────────────────────────────

    public function dashboard()
    {
        $rekapHariIni = [
            'hadir'  => AbsensiGuru::whereIn('status', ['hadir', 'telat'])->whereDate('tanggal', today())->count(),
            'izin'   => AbsensiGuru::where('status', 'izin')->whereDate('tanggal', today())->count(),
            'sakit'  => AbsensiGuru::where('status', 'sakit')->whereDate('tanggal', today())->count(),
            'alfa'   => AbsensiGuru::where('status', 'alfa')->whereDate('tanggal', today())->count(),
        ];

        $totalGuru = Guru::aktif()->count();

        $guruSudahAbsen = AbsensiGuru::whereDate('tanggal', today())->pluck('guru_id');
        $guruBelumAbsen = Guru::aktif()
            ->whereNotIn('id', $guruSudahAbsen)
            ->orderBy('nama_lengkap')
            ->get();

        $hariIni          = strtolower(Carbon::now()->locale('id')->isoFormat('dddd'));
        $guruPiketHariIni = JadwalPiketGuru::with('guru')
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->get();

        $absensiHariIni = AbsensiGuru::with('guru')
            ->whereDate('tanggal', today())
            ->orderBy('jam_masuk')
            ->get();

        return view(self::VIEW_PREFIX . 'dashboard', compact(
            'rekapHariIni',
            'totalGuru',
            'guruBelumAbsen',
            'guruPiketHariIni',
            'absensiHariIni',
        ));
    }

    // ── ABSENSI MASSAL ────────────────────────────────────────────────────────

    public function massalForm(Request $request)
    {
        $tanggal    = $request->filled('tanggal') ? $request->tanggal : today()->toDateString();
        $guruList   = Guru::aktif()->orderBy('nama_lengkap')->get();
        $statusList = self::STATUS_LIST;

        $absensiExisting = AbsensiGuru::whereDate('tanggal', $tanggal)
            ->get()
            ->keyBy('guru_id');

        return view(self::VIEW_PREFIX . 'massal', compact(
            'tanggal',
            'guruList',
            'statusList',
            'absensiExisting',
        ));
    }

    public function massalStore(Request $request)
    {
        $request->validate([
            'tanggal'               => ['required', 'date'],
            'absensi'               => ['required', 'array'],
            'absensi.*.guru_id'     => ['required', 'exists:guru,id'],
            'absensi.*.status'      => ['required', Rule::in(self::STATUS_LIST)],
            'absensi.*.jam_masuk'   => ['nullable', 'date_format:H:i'],
            'absensi.*.jam_keluar'  => ['nullable', 'date_format:H:i', 'after:absensi.*.jam_masuk'],
            'absensi.*.keterangan'  => ['nullable', 'string', 'max:500'],
        ], [
            'tanggal.required'           => 'Tanggal absensi wajib diisi.',
            'absensi.required'           => 'Data absensi tidak boleh kosong.',
            'absensi.*.guru_id.required' => 'Guru wajib dipilih.',
            'absensi.*.status.required'  => 'Status absensi wajib diisi.',
            'absensi.*.status.in'        => 'Status absensi tidak valid.',
        ]);

        $dicatatOleh = Auth::id();
        $tanggal     = $request->tanggal;
        $berhasil    = 0;

        foreach ($request->absensi as $data) {
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

        return redirect()->route('piket.absensi-guru.dashboard')
            ->with('success', "Absensi {$berhasil} guru berhasil disimpan untuk tanggal {$tanggal}.");
    }

    // ── RIWAYAT ───────────────────────────────────────────────────────────────

    public function riwayat(Request $request)
    {
        $user = Auth::user();

        $query = AbsensiGuru::with('guru')
            ->where('dicatat_oleh', $user->id)
            ->orderByDesc('tanggal');

        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        $riwayat    = $query->paginate(20)->withQueryString();
        $guruList   = Guru::aktif()->orderBy('nama_lengkap')->get();
        $statusList = self::STATUS_LIST;

        return view(self::VIEW_PREFIX . 'riwayat', compact('riwayat', 'guruList', 'statusList'));
    }

    // ── SCAN QR ───────────────────────────────────────────────────────────────

    public function scanQr()
    {
        return view(self::VIEW_PREFIX . 'scan-qr');
    }

    public function prosesQr(Request $request)
    {
        $request->validate([
            'qr_data' => ['required', 'string'],
            'status'  => ['required', Rule::in(self::STATUS_LIST)],
        ], [
            'qr_data.required' => 'Data QR tidak boleh kosong.',
            'status.required'  => 'Status absensi wajib dipilih.',
            'status.in'        => 'Status tidak valid.',
        ]);

        $qrData = trim($request->qr_data);
        $guru   = null;

        if (str_starts_with($qrData, 'GURU-')) {
            $guruId = (int) str_replace('GURU-', '', $qrData);
            $guru   = Guru::find($guruId);
        } else {
            $guru = Guru::where('nip', $qrData)->first();
        }

        if (! $guru) {
            return back()
                ->with('error', 'QR tidak valid atau guru tidak ditemukan.')
                ->withInput();
        }

        $sudahAbsen = AbsensiGuru::where('guru_id', $guru->id)
            ->whereDate('tanggal', today())
            ->exists();

        if ($sudahAbsen) {
            return back()->with('warning', "Guru {$guru->nama_lengkap} sudah tercatat absen hari ini.");
        }

        AbsensiGuru::create([
            'guru_id'      => $guru->id,
            'tanggal'      => today(),
            'status'       => $request->status,
            'jam_masuk'    => now()->format('H:i'),
            'dicatat_oleh' => Auth::id(),
            'metode'       => 'qr',
        ]);

        return back()->with('success', "Absensi {$guru->nama_lengkap} berhasil dicatat via QR.");
    }
}