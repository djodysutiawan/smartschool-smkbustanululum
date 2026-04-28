<?php

namespace App\Http\Controllers\Api\Piket;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Piket\Concerns\PiketActiveGuru;
use App\Models\IzinKeluarSiswa;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinKeluarSiswaController extends Controller
{
    use PiketActiveGuru;

    /**
     * GET /api/piket/izin-keluar
     *
     * Daftar izin keluar siswa dengan filter.
     *
     * Query params:
     *   - status         (optional)
     *   - kategori       (optional)
     *   - tanggal_dari   (optional) Y-m-d
     *   - tanggal_sampai (optional) Y-m-d
     *   - search         (optional) nama siswa / nomor surat / tujuan
     *   - per_page       (optional, default 20)
     */
    public function index(Request $request): JsonResponse
    {
        $query = IzinKeluarSiswa::with(['siswa.kelas', 'diprosesOleh'])
            ->latest('tanggal')->latest('id');

        if ($request->filled('status'))        $query->where('status', $request->status);
        if ($request->filled('kategori'))      $query->where('kategori', $request->kategori);
        if ($request->filled('tanggal_dari'))  $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai'))$query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn ($q) => $q
                ->whereHas('siswa', fn ($sq) => $sq->where('nama_lengkap', 'like', "%{$s}%"))
                ->orWhere('nomor_surat', 'like', "%{$s}%")
                ->orWhere('tujuan', 'like', "%{$s}%"));
        }

        $perPage = $request->get('per_page', 20);
        $izins   = $query->paginate($perPage)->withQueryString();

        $stats = [
            'menunggu'      => IzinKeluarSiswa::hariIni()->where('status', IzinKeluarSiswa::STATUS_MENUNGGU)->count(),
            'sedang_keluar' => IzinKeluarSiswa::hariIni()->belumKembali()->count(),
            'sudah_kembali' => IzinKeluarSiswa::hariIni()->where('status', IzinKeluarSiswa::STATUS_SUDAH_KEMBALI)->count(),
        ];

        return response()->json([
            'izins'          => $izins,
            'stats'          => $stats,
            'status_list'    => IzinKeluarSiswa::STATUS_LIST,
            'kategori_list'  => IzinKeluarSiswa::KATEGORI_LIST,
            'guru_aktif_id'  => $this->resolveActiveGuruId(),
        ]);
    }

    /**
     * GET /api/piket/izin-keluar/form-data
     *
     * Data untuk mengisi form buat izin (daftar siswa & tahun ajaran).
     */
    public function formData(): JsonResponse
    {
        if (! $this->resolveActiveGuruId()) {
            return response()->json([
                'success' => false,
                'message' => 'Check-in terlebih dahulu untuk membuat izin keluar siswa.',
            ], 403);
        }

        return response()->json([
            'siswas'        => Siswa::with('kelas')->aktif()->orderBy('nama_lengkap')->get(),
            'tahun_ajarans' => TahunAjaran::orderByDesc('tanggal_mulai')->get(),
            'kategori_list' => IzinKeluarSiswa::KATEGORI_LIST,
        ]);
    }

    /**
     * POST /api/piket/izin-keluar
     *
     * Buat izin keluar siswa baru.
     *
     * Body (JSON):
     * {
     *   "siswa_id": 1,
     *   "tahun_ajaran_id": 1,
     *   "tanggal": "2025-01-20",
     *   "jam_keluar": "10:00",
     *   "jam_kembali": "12:00",
     *   "tujuan": "Keperluan keluarga",
     *   "kategori": "keluarga",
     *   "keterangan": null
     * }
     */
    public function store(Request $request): JsonResponse
    {
        if (! $this->resolveActiveGuruId()) {
            return response()->json([
                'success' => false,
                'message' => 'Check-in terlebih dahulu untuk membuat izin keluar siswa.',
            ], 403);
        }

        $validated = $request->validate([
            'siswa_id'        => 'required|exists:siswa,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal'         => 'required|date',
            'jam_keluar'      => 'required|date_format:H:i',
            'jam_kembali'     => 'nullable|date_format:H:i|after:jam_keluar',
            'tujuan'          => 'required|string|max:255',
            'kategori'        => 'required|in:' . implode(',', array_keys(IzinKeluarSiswa::KATEGORI_LIST)),
            'keterangan'      => 'nullable|string|max:1000',
        ]);

        $izin = IzinKeluarSiswa::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Izin keluar siswa berhasil dibuat.',
            'izin'    => $izin->load(['siswa.kelas', 'tahunAjaran']),
        ], 201);
    }

    /**
     * GET /api/piket/izin-keluar/{izinKeluarSiswa}
     *
     * Detail izin keluar siswa.
     */
    public function show(IzinKeluarSiswa $izinKeluarSiswa): JsonResponse
    {
        $izinKeluarSiswa->load(['siswa.kelas', 'tahunAjaran', 'diprosesOleh', 'dicatatKembaliOleh']);

        return response()->json([
            'izin'          => $izinKeluarSiswa,
            'guru_aktif_id' => $this->resolveActiveGuruId(),
        ]);
    }

    /**
     * PUT /api/piket/izin-keluar/{izinKeluarSiswa}
     *
     * Edit izin (hanya status Menunggu).
     */
    public function update(Request $request, IzinKeluarSiswa $izinKeluarSiswa): JsonResponse
    {
        if (! $this->resolveActiveGuruId()) {
            return response()->json([
                'success' => false,
                'message' => 'Check-in terlebih dahulu untuk mengedit izin.',
            ], 403);
        }

        if (! $izinKeluarSiswa->isMenunggu()) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya izin berstatus Menunggu yang dapat diedit.',
            ], 403);
        }

        $validated = $request->validate([
            'siswa_id'        => 'required|exists:siswa,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal'         => 'required|date',
            'jam_keluar'      => 'required|date_format:H:i',
            'jam_kembali'     => 'nullable|date_format:H:i|after:jam_keluar',
            'tujuan'          => 'required|string|max:255',
            'kategori'        => 'required|in:' . implode(',', array_keys(IzinKeluarSiswa::KATEGORI_LIST)),
            'keterangan'      => 'nullable|string|max:1000',
        ]);

        $izinKeluarSiswa->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Izin keluar siswa berhasil diperbarui.',
            'izin'    => $izinKeluarSiswa->fresh(['siswa.kelas', 'tahunAjaran']),
        ]);
    }

    /**
     * DELETE /api/piket/izin-keluar/{izinKeluarSiswa}
     *
     * Hapus izin keluar siswa.
     */
    public function destroy(IzinKeluarSiswa $izinKeluarSiswa): JsonResponse
    {
        if (! $this->resolveActiveGuruId()) {
            return response()->json([
                'success' => false,
                'message' => 'Check-in terlebih dahulu untuk menghapus izin.',
            ], 403);
        }

        $izinKeluarSiswa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data izin keluar berhasil dihapus.',
        ]);
    }

    /**
     * PATCH /api/piket/izin-keluar/{izinKeluarSiswa}/approve
     *
     * Setujui izin keluar siswa.
     *
     * Body (JSON):
     * {
     *   "catatan_piket": "..."  // opsional
     * }
     */
    public function approve(Request $request, IzinKeluarSiswa $izinKeluarSiswa): JsonResponse
    {
        if (! $this->resolveActiveGuruId()) {
            return response()->json([
                'success' => false,
                'message' => 'Check-in terlebih dahulu untuk menyetujui izin.',
            ], 403);
        }

        if (! $izinKeluarSiswa->isMenunggu()) {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid untuk disetujui.',
            ], 422);
        }

        $request->validate([
            'catatan_piket' => 'nullable|string|max:500',
        ]);

        $izinKeluarSiswa->update([
            'status'        => IzinKeluarSiswa::STATUS_DISETUJUI,
            'nomor_surat'   => IzinKeluarSiswa::generateNomorSurat(),
            'diproses_oleh' => Auth::id(),
            'diproses_pada' => now(),
            'catatan_piket' => $request->catatan_piket,
        ]);

        return response()->json([
            'success'      => true,
            'message'      => 'Izin disetujui.',
            'nomor_surat'  => $izinKeluarSiswa->nomor_surat,
            'izin'         => $izinKeluarSiswa->fresh(['siswa.kelas', 'diprosesOleh']),
        ]);
    }

    /**
     * PATCH /api/piket/izin-keluar/{izinKeluarSiswa}/tolak
     *
     * Tolak izin keluar siswa.
     *
     * Body (JSON):
     * {
     *   "catatan_piket": "Alasan penolakan"  // wajib
     * }
     */
    public function tolak(Request $request, IzinKeluarSiswa $izinKeluarSiswa): JsonResponse
    {
        if (! $this->resolveActiveGuruId()) {
            return response()->json([
                'success' => false,
                'message' => 'Check-in terlebih dahulu untuk menolak izin.',
            ], 403);
        }

        if (! $izinKeluarSiswa->isMenunggu()) {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid untuk ditolak.',
            ], 422);
        }

        $request->validate([
            'catatan_piket' => 'required|string|max:500',
        ]);

        $izinKeluarSiswa->update([
            'status'        => IzinKeluarSiswa::STATUS_DITOLAK,
            'diproses_oleh' => Auth::id(),
            'diproses_pada' => now(),
            'catatan_piket' => $request->catatan_piket,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Izin keluar siswa ditolak.',
            'izin'    => $izinKeluarSiswa->fresh(['siswa.kelas', 'diprosesOleh']),
        ]);
    }

    /**
     * PATCH /api/piket/izin-keluar/{izinKeluarSiswa}/konfirmasi-kembali
     *
     * Konfirmasi siswa sudah kembali.
     *
     * Body (JSON):
     * {
     *   "jam_kembali_aktual": "13:30",  // wajib
     *   "catatan_piket": "..."          // opsional
     * }
     */
    public function konfirmasiKembali(Request $request, IzinKeluarSiswa $izinKeluarSiswa): JsonResponse
    {
        if (! $this->resolveActiveGuruId()) {
            return response()->json([
                'success' => false,
                'message' => 'Check-in terlebih dahulu untuk konfirmasi kepulangan siswa.',
            ], 403);
        }

        if (! $izinKeluarSiswa->isDisetujui()) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya izin berstatus Disetujui yang bisa dikonfirmasi kembali.',
            ], 422);
        }

        $request->validate([
            'jam_kembali_aktual' => 'required|date_format:H:i',
            'catatan_piket'      => 'nullable|string|max:500',
        ]);

        $izinKeluarSiswa->update([
            'status'               => IzinKeluarSiswa::STATUS_SUDAH_KEMBALI,
            'jam_kembali_aktual'   => $request->jam_kembali_aktual,
            'dicatat_kembali_oleh' => Auth::id(),
            'dicatat_kembali_pada' => now(),
            'catatan_piket'        => $request->catatan_piket ?? $izinKeluarSiswa->catatan_piket,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Siswa telah dicatat kembali ke sekolah.',
            'izin'    => $izinKeluarSiswa->fresh(['siswa.kelas', 'dicatatKembaliOleh']),
        ]);
    }
}