<?php

namespace App\Http\Controllers\Api\Piket;

use App\Http\Controllers\Controller;
use App\Models\AbsensiGuru;
use App\Models\Guru;
use App\Models\JadwalPiketGuru;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AbsensiGuruController extends Controller
{
    private const STATUS_LIST = ['hadir', 'telat', 'izin', 'sakit', 'alfa'];

    /**
     * GET /api/piket/absensi-guru/dashboard
     *
     * Rekap absensi guru hari ini.
     */
    public function dashboard(): JsonResponse
    {
        $rekapHariIni = [
            'hadir' => AbsensiGuru::whereIn('status', ['hadir', 'telat'])->whereDate('tanggal', today())->count(),
            'izin'  => AbsensiGuru::where('status', 'izin')->whereDate('tanggal', today())->count(),
            'sakit' => AbsensiGuru::where('status', 'sakit')->whereDate('tanggal', today())->count(),
            'alfa'  => AbsensiGuru::where('status', 'alfa')->whereDate('tanggal', today())->count(),
        ];

        $totalGuru      = Guru::aktif()->count();
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

        return response()->json([
            'rekap_hari_ini'     => $rekapHariIni,
            'total_guru'         => $totalGuru,
            'guru_belum_absen'   => $guruBelumAbsen,
            'guru_piket_hari_ini'=> $guruPiketHariIni,
            'absensi_hari_ini'   => $absensiHariIni,
        ]);
    }

    /**
     * GET /api/piket/absensi-guru/massal
     *
     * Data form absensi massal (daftar guru + absensi existing).
     *
     * Query params:
     *   - tanggal (optional, default hari ini) Y-m-d
     */
    public function massalForm(Request $request): JsonResponse
    {
        $tanggal  = $request->filled('tanggal') ? $request->tanggal : today()->toDateString();
        $guruList = Guru::aktif()->orderBy('nama_lengkap')->get();

        $absensiExisting = AbsensiGuru::whereDate('tanggal', $tanggal)
            ->get()
            ->keyBy('guru_id');

        return response()->json([
            'tanggal'          => $tanggal,
            'guru_list'        => $guruList,
            'status_list'      => self::STATUS_LIST,
            'absensi_existing' => $absensiExisting,
        ]);
    }

    /**
     * POST /api/piket/absensi-guru/massal
     *
     * Simpan absensi massal.
     *
     * Body (JSON):
     * {
     *   "tanggal": "2025-01-20",
     *   "absensi": [
     *     {
     *       "guru_id": 1,
     *       "status": "hadir",
     *       "jam_masuk": "07:30",
     *       "jam_keluar": "14:00",
     *       "keterangan": null
     *     }
     *   ]
     * }
     */
    public function massalStore(Request $request): JsonResponse
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

        return response()->json([
            'success' => true,
            'message' => "Absensi {$berhasil} guru berhasil disimpan untuk tanggal {$tanggal}.",
            'berhasil'=> $berhasil,
        ]);
    }

    /**
     * GET /api/piket/absensi-guru/riwayat
     *
     * Riwayat absensi yang dicatat oleh piket yang login.
     *
     * Query params:
     *   - guru_id        (optional)
     *   - status         (optional)
     *   - tanggal_dari   (optional) Y-m-d
     *   - tanggal_sampai (optional) Y-m-d
     *   - per_page       (optional, default 20)
     */
    public function riwayat(Request $request): JsonResponse
    {
        $user  = Auth::user();
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

        $perPage  = $request->get('per_page', 20);
        $riwayat  = $query->paginate($perPage)->withQueryString();
        $guruList = Guru::aktif()->orderBy('nama_lengkap')->get();

        return response()->json([
            'riwayat'     => $riwayat,
            'guru_list'   => $guruList,
            'status_list' => self::STATUS_LIST,
        ]);
    }

    /**
     * POST /api/piket/absensi-guru/scan-qr
     *
     * Proses scan QR guru.
     *
     * Body (JSON):
     * {
     *   "qr_data": "GURU-5",
     *   "status": "hadir"
     * }
     */
    public function prosesQr(Request $request): JsonResponse
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
            return response()->json([
                'success' => false,
                'message' => 'QR tidak valid atau guru tidak ditemukan.',
            ], 422);
        }

        $sudahAbsen = AbsensiGuru::where('guru_id', $guru->id)
            ->whereDate('tanggal', today())
            ->exists();

        if ($sudahAbsen) {
            return response()->json([
                'success' => false,
                'message' => "Guru {$guru->nama_lengkap} sudah tercatat absen hari ini.",
            ], 422);
        }

        $absensi = AbsensiGuru::create([
            'guru_id'      => $guru->id,
            'tanggal'      => today(),
            'status'       => $request->status,
            'jam_masuk'    => now()->format('H:i'),
            'dicatat_oleh' => Auth::id(),
            'metode'       => 'qr',
        ]);

        return response()->json([
            'success'  => true,
            'message'  => "Absensi {$guru->nama_lengkap} berhasil dicatat via QR.",
            'absensi'  => $absensi->load('guru'),
        ]);
    }
}