<?php

namespace App\Http\Controllers\Api\Piket;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelanggaran;
use App\Models\Kelas;
use App\Models\LogPiket;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PelanggaranController extends Controller
{
    private const STATUS_INPUT = ['pending', 'diproses'];
    private const STATUS_LIST  = ['pending', 'diproses', 'selesai', 'banding'];

    /**
     * GET /api/piket/pelanggaran
     *
     * Daftar pelanggaran.
     * Jika sudah check-in: tampilkan yang dicatat oleh user ini.
     * Jika belum check-in: tampilkan semua hari ini (read-only).
     *
     * Query params:
     *   - kategori_id    (optional)
     *   - status         (optional)
     *   - kelas_id       (optional)
     *   - tanggal_dari   (optional) Y-m-d
     *   - tanggal_sampai (optional) Y-m-d
     *   - search         (optional) nama / nis siswa
     *   - per_page       (optional, default 20)
     */
    public function index(Request $request): JsonResponse
    {
        $userId = Auth::id();

        $logAktif = LogPiket::where('pengguna_id', $userId)
            ->whereDate('tanggal', today())
            ->whereNotNull('masuk_pada')
            ->whereNull('keluar_pada')
            ->first();

        $guruAktifId = $logAktif ? $userId : null;

        $query = $guruAktifId
            ? Pelanggaran::with(['siswa.kelas', 'kategori', 'dicatatOleh'])
                ->where('dicatat_oleh', $userId)
            : Pelanggaran::with(['siswa.kelas', 'kategori', 'dicatatOleh'])
                ->whereDate('tanggal', today());

        if ($request->filled('kategori_id')) {
            $query->where('kategori_pelanggaran_id', $request->kategori_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', $request->kelas_id));
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('siswa', fn ($q) => $q
                ->where('nama_lengkap', 'like', "%{$s}%")
                ->orWhere('nis', 'like', "%{$s}%"));
        }

        $perPage     = $request->get('per_page', 20);
        $pelanggaran = $query->latest('tanggal')->paginate($perPage)->withQueryString();

        $statsBase = $guruAktifId
            ? Pelanggaran::where('dicatat_oleh', $userId)
            : Pelanggaran::whereDate('tanggal', today());

        $stats = [
            'total'     => (clone $statsBase)->count(),
            'diproses'  => (clone $statsBase)->where('status', 'diproses')->count(),
            'bulan_ini' => (clone $statsBase)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count(),
            'selesai'   => (clone $statsBase)->where('status', 'selesai')->count(),
        ];

        return response()->json([
            'pelanggaran'   => $pelanggaran,
            'stats'         => $stats,
            'kategori_list' => KategoriPelanggaran::orderBy('nama')->get(),
            'kelas_list'    => Kelas::aktif()->orderBy('nama_kelas')->get(),
            'status_list'   => self::STATUS_LIST,
            'guru_aktif_id' => $guruAktifId,
        ]);
    }

    /**
     * GET /api/piket/pelanggaran/form-data
     *
     * Data untuk mengisi form buat/edit pelanggaran.
     */
    public function formData(): JsonResponse
    {
        return response()->json([
            'siswa_list'    => Siswa::aktif()->with('kelas')->orderBy('nama_lengkap')->get(),
            'kategori_list' => KategoriPelanggaran::aktif()->orderBy('nama')->get(),
            'status_list'   => self::STATUS_INPUT,
        ]);
    }

    /**
     * POST /api/piket/pelanggaran
     *
     * Catat pelanggaran baru.
     *
     * Body (JSON):
     * {
     *   "siswa_id": 1,
     *   "kategori_pelanggaran_id": 2,
     *   "poin": 10,
     *   "deskripsi": "...",
     *   "tanggal": "2025-01-20",
     *   "tindakan": null,
     *   "status": "pending"
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'siswa_id'                => ['required', 'exists:siswa,id'],
            'kategori_pelanggaran_id' => ['required', 'exists:kategori_pelanggaran,id'],
            'poin'                    => ['required', 'integer', 'min:1', 'max:100'],
            'deskripsi'               => ['required', 'string'],
            'tanggal'                 => ['required', 'date'],
            'tindakan'                => ['nullable', 'string'],
            'status'                  => ['required', Rule::in(self::STATUS_INPUT)],
        ], $this->messages());

        $validated['dicatat_oleh'] = Auth::id();

        $pelanggaran = Pelanggaran::create($validated);

        return response()->json([
            'success'     => true,
            'message'     => 'Pelanggaran berhasil dicatat.',
            'pelanggaran' => $pelanggaran->load(['siswa.kelas', 'kategori', 'dicatatOleh']),
        ], 201);
    }

    /**
     * GET /api/piket/pelanggaran/{pelanggaran}
     *
     * Detail pelanggaran.
     */
    public function show(Pelanggaran $pelanggaran): JsonResponse
    {
        $this->authorizeOwnership($pelanggaran);

        $pelanggaran->load(['siswa.kelas', 'kategori', 'dicatatOleh']);

        $totalPoinSiswa = Pelanggaran::where('siswa_id', $pelanggaran->siswa_id)
            ->whereNotIn('status', ['banding'])
            ->sum('poin');

        return response()->json([
            'pelanggaran'     => $pelanggaran,
            'total_poin_siswa'=> $totalPoinSiswa,
        ]);
    }

    /**
     * PUT /api/piket/pelanggaran/{pelanggaran}
     *
     * Update pelanggaran (hanya status pending).
     */
    public function update(Request $request, Pelanggaran $pelanggaran): JsonResponse
    {
        $this->authorizeOwnership($pelanggaran);

        if ($pelanggaran->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggaran yang sudah diproses tidak dapat diedit.',
            ], 403);
        }

        $validated = $request->validate([
            'siswa_id'                => ['required', 'exists:siswa,id'],
            'kategori_pelanggaran_id' => ['required', 'exists:kategori_pelanggaran,id'],
            'poin'                    => ['required', 'integer', 'min:1', 'max:100'],
            'deskripsi'               => ['required', 'string'],
            'tanggal'                 => ['required', 'date'],
            'tindakan'                => ['nullable', 'string'],
            'status'                  => ['required', Rule::in(self::STATUS_INPUT)],
        ], $this->messages());

        $pelanggaran->update($validated);

        return response()->json([
            'success'     => true,
            'message'     => 'Data pelanggaran berhasil diperbarui.',
            'pelanggaran' => $pelanggaran->fresh(['siswa.kelas', 'kategori', 'dicatatOleh']),
        ]);
    }

    /**
     * PATCH /api/piket/pelanggaran/{pelanggaran}/selesaikan
     *
     * Tandai pelanggaran sebagai selesai.
     *
     * Body (JSON):
     * {
     *   "tindakan": "..."  // opsional
     * }
     */
    public function selesaikan(Request $request, Pelanggaran $pelanggaran): JsonResponse
    {
        $this->authorizeOwnership($pelanggaran);

        $request->validate([
            'tindakan' => ['nullable', 'string'],
        ]);

        $pelanggaran->selesaikan($request->tindakan ?? $pelanggaran->tindakan ?? '-');

        return response()->json([
            'success'     => true,
            'message'     => 'Pelanggaran berhasil diselesaikan.',
            'pelanggaran' => $pelanggaran->fresh(['siswa.kelas', 'kategori']),
        ]);
    }

    // ── Helper ────────────────────────────────────────────────────────────────

    private function authorizeOwnership(Pelanggaran $pelanggaran): void
    {
        if ($pelanggaran->dicatat_oleh !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengakses data pelanggaran ini.');
        }
    }

    private function messages(): array
    {
        return [
            'siswa_id.required'                => 'Siswa wajib dipilih.',
            'siswa_id.exists'                  => 'Siswa tidak ditemukan.',
            'kategori_pelanggaran_id.required' => 'Kategori pelanggaran wajib dipilih.',
            'kategori_pelanggaran_id.exists'   => 'Kategori tidak valid.',
            'poin.required'                    => 'Poin wajib diisi.',
            'poin.min'                         => 'Poin minimal 1.',
            'poin.max'                         => 'Poin maksimal 100.',
            'deskripsi.required'               => 'Deskripsi pelanggaran wajib diisi.',
            'tanggal.required'                 => 'Tanggal wajib diisi.',
            'tanggal.date'                     => 'Format tanggal tidak valid.',
            'status.required'                  => 'Status wajib dipilih.',
            'status.in'                        => 'Status tidak valid.',
        ];
    }
}