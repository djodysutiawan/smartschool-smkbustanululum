<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\JawabanSiswa;
use App\Models\SesiUjian;
use App\Models\SoalUjian;
use App\Models\Ujian;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UjianController extends Controller
{
    // ── Helper ────────────────────────────────────────────────────

    private function getSiswa()
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    private function selesaikanJikaHabisWaktu(SesiUjian $sesi): bool
    {
        if ($sesi->isHabisWaktu()) {
            $sesi->selesaikan(habisWaktu: true);
            return true;
        }
        return false;
    }

    /**
     * Ambil date-only dari kolom tanggal (bisa date atau datetime),
     * lalu gabung dengan jam — hindari "double time specification".
     */
    private function buildTanggalMulai(Ujian $u): ?string
    {
        if (! $u->tanggal || ! $u->jam_mulai) return null;
        try {
            $tgl = Carbon::parse($u->tanggal)->format('Y-m-d');
            $jam = Carbon::parse($u->jam_mulai)->format('H:i:s');
            return Carbon::parse("{$tgl} {$jam}")->toIso8601String();
        } catch (\Throwable) {
            return null;
        }
    }

    private function buildTanggalSelesai(Ujian $u): ?string
    {
        if (! $u->tanggal || ! $u->jam_selesai) return null;
        try {
            $tgl = Carbon::parse($u->tanggal)->format('Y-m-d');
            $jam = Carbon::parse($u->jam_selesai)->format('H:i:s');
            return Carbon::parse("{$tgl} {$jam}")->toIso8601String();
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * Format satu Ujian untuk response list/index.
     * Field disesuaikan dengan UjianItem.fromJson() di Flutter.
     */
    private function formatUjianItem(Ujian $u, $siswa, array $selesaiMap, array $nilaiMap): array
    {
        $percobaan      = $selesaiMap[$u->id] ?? 0;
        $nilaiTertinggi = $nilaiMap[$u->id] ?? null;
        $maksPercobaan  = $u->maks_percobaan ?? 1;

        // Cek sesi aktif
        $sesiAktif = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $u->id)
            ->where('status', 'berlangsung')
            ->latest()
            ->first();

        if ($sesiAktif && $sesiAktif->isHabisWaktu()) {
            $sesiAktif->selesaikan(habisWaktu: true);
            $sesiAktif = null;
        }

        // Tentukan status string — sesuai ujianStatusFromString() di Flutter
        $statusStr = 'belum_mulai';
        if ($sesiAktif) {
            $statusStr = 'sedang_dikerjakan';
        } elseif ($percobaan >= $maksPercobaan) {
            $statusStr = 'selesai';
        } elseif ($u->sudahBerakhir()) {
            $statusStr = 'kedaluwarsa';
        }

        return [
            'id'              => $u->id,
            'judul'           => $u->judul,
            'deskripsi'       => $u->deskripsi ?? null,
            'status'          => $statusStr,
            'mata_pelajaran'  => $u->relationLoaded('mataPelajaran') && $u->mataPelajaran ? [
                'id'         => $u->mataPelajaran->id,
                'nama_mapel' => $u->mataPelajaran->nama_mapel,
            ] : null,
            'guru' => $u->relationLoaded('guru') && $u->guru ? [
                'id'           => $u->guru->id,
                'nama_lengkap' => $u->guru->nama_lengkap,
            ] : null,
            'tanggal_mulai'   => $this->buildTanggalMulai($u),
            'tanggal_selesai' => $this->buildTanggalSelesai($u),
            'durasi_menit'    => $u->durasi_menit ?? null,
            'jumlah_soal'     => $u->soal_count ?? null,
            'nilai_kkm'       => $u->nilai_kkm ?? null,
            'acak_soal'       => (bool) ($u->acak_soal ?? false),
            'acak_opsi'       => (bool) ($u->acak_opsi ?? false),
            'tampilkan_hasil' => (bool) ($u->tampilkan_nilai ?? true),
            'nilai_akhir'     => $nilaiTertinggi,
            'selesai_pada'    => null,
        ];
    }

    // ── INDEX ─────────────────────────────────────────────────────
    // GET /api/siswa/ujian

    public function index(): JsonResponse
    {
        $siswa = $this->getSiswa();

        $selesaiMap = SesiUjian::where('siswa_id', $siswa->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->select('ujian_id', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('ujian_id')
            ->pluck('jumlah', 'ujian_id')
            ->toArray();

        $nilaiMap = SesiUjian::where('siswa_id', $siswa->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->select('ujian_id', DB::raw('MAX(nilai_akhir) as nilai_tertinggi'))
            ->groupBy('ujian_id')
            ->pluck('nilai_tertinggi', 'ujian_id')
            ->toArray();

        $paginated = Ujian::with(['mataPelajaran', 'guru'])
            ->withCount('soal')
            ->where('kelas_id', $siswa->kelas_id)
            ->where('is_active', true)
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->paginate(15);

        $items = $paginated->getCollection()
            ->map(fn ($u) => $this->formatUjianItem($u, $siswa, $selesaiMap, $nilaiMap))
            ->values();

        return response()->json([
            'success' => true,
            'data'    => [
                'ujian' => [
                    'data'         => $items,
                    'current_page' => $paginated->currentPage(),
                    'last_page'    => $paginated->lastPage(),
                    'per_page'     => $paginated->perPage(),
                    'total'        => $paginated->total(),
                ],
            ],
        ]);
    }

    // ── RIWAYAT ───────────────────────────────────────────────────
    // GET /api/siswa/ujian/riwayat

    public function riwayat(): JsonResponse
    {
        $siswa = $this->getSiswa();

        $sesiList = SesiUjian::with(['ujian.mataPelajaran', 'ujian.guru'])
            ->where('siswa_id', $siswa->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->orderByDesc('selesai_pada')
            ->paginate(15);

        $items = $sesiList->getCollection()->map(function ($sesi) {
            $u = $sesi->ujian;
            if (! $u) return null;

            return [
                'id'              => $u->id,
                'judul'           => $u->judul,
                'deskripsi'       => $u->deskripsi ?? null,
                'status'          => 'selesai',
                'mata_pelajaran'  => $u->mataPelajaran ? [
                    'id'         => $u->mataPelajaran->id,
                    'nama_mapel' => $u->mataPelajaran->nama_mapel,
                ] : null,
                'guru' => $u->guru ? [
                    'id'           => $u->guru->id,
                    'nama_lengkap' => $u->guru->nama_lengkap,
                ] : null,
                'tanggal_mulai'   => $this->buildTanggalMulai($u),
                'tanggal_selesai' => $this->buildTanggalSelesai($u),
                'durasi_menit'    => $u->durasi_menit ?? null,
                'jumlah_soal'     => $u->soal()->count(),
                'nilai_kkm'       => $u->nilai_kkm ?? null,
                'acak_soal'       => (bool) ($u->acak_soal ?? false),
                'acak_opsi'       => (bool) ($u->acak_opsi ?? false),
                'tampilkan_hasil' => (bool) ($u->tampilkan_nilai ?? true),
                'nilai_akhir'     => $sesi->nilai_akhir,
                'jumlah_benar'    => $sesi->total_benar ?? null,
                'jumlah_salah'    => $sesi->total_salah ?? null,
                'selesai_pada'    => $sesi->selesai_pada?->toIso8601String(),
            ];
        })->filter()->values();

        return response()->json([
            'success' => true,
            'data'    => [
                'ujian' => [
                    'data'         => $items,
                    'current_page' => $sesiList->currentPage(),
                    'last_page'    => $sesiList->lastPage(),
                    'per_page'     => $sesiList->perPage(),
                    'total'        => $sesiList->total(),
                ],
            ],
        ]);
    }

    // ── INFO ──────────────────────────────────────────────────────
    // GET /api/siswa/ujian/{ujian}/info

    public function info(Ujian $ujian): JsonResponse
    {
        $siswa = $this->getSiswa();

        if ($ujian->kelas_id !== $siswa->kelas_id) {
            return response()->json(['success' => false, 'message' => 'Ujian ini bukan untuk kelas Anda.'], 403);
        }
        if (! $ujian->is_active) {
            return response()->json(['success' => false, 'message' => 'Ujian ini tidak aktif.'], 403);
        }

        $ujian->load(['mataPelajaran', 'guru', 'kelas']);
        $totalSoal = $ujian->soal()->count();

        $sesiAktif = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()
            ->first();

        if ($sesiAktif && $this->selesaikanJikaHabisWaktu($sesiAktif)) {
            $sesiAktif = null;
        }

        $percobaan      = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->count();
        $maksPercobaan  = $ujian->maks_percobaan ?? 1;
        $nilaiTertinggi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->max('nilai_akhir');

        $statusStr = 'belum_mulai';
        if ($sesiAktif) {
            $statusStr = 'sedang_dikerjakan';
        } elseif ($percobaan >= $maksPercobaan) {
            $statusStr = 'selesai';
        } elseif ($ujian->sudahBerakhir()) {
            $statusStr = 'kedaluwarsa';
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'ujian' => [
                    'id'               => $ujian->id,
                    'judul'            => $ujian->judul,
                    'deskripsi'        => $ujian->deskripsi ?? null,
                    'status'           => $statusStr,
                    'mata_pelajaran'   => $ujian->mataPelajaran ? [
                        'id'         => $ujian->mataPelajaran->id,
                        'nama_mapel' => $ujian->mataPelajaran->nama_mapel,
                    ] : null,
                    'guru' => $ujian->guru ? [
                        'id'           => $ujian->guru->id,
                        'nama_lengkap' => $ujian->guru->nama_lengkap,
                    ] : null,
                    'tanggal_mulai'    => $this->buildTanggalMulai($ujian),
                    'tanggal_selesai'  => $this->buildTanggalSelesai($ujian),
                    'durasi_menit'     => $ujian->durasi_menit ?? null,
                    'jumlah_soal'      => $totalSoal,
                    'nilai_kkm'        => $ujian->nilai_kkm ?? null,
                    'acak_soal'        => (bool) ($ujian->acak_soal ?? false),
                    'acak_opsi'        => (bool) ($ujian->acak_opsi ?? false),
                    'tampilkan_hasil'  => (bool) ($ujian->tampilkan_nilai ?? true),
                    'nilai_akhir'      => $nilaiTertinggi,
                    'aturan'           => $ujian->aturan ?? null,
                    'boleh_lihat_soal' => (bool) ($ujian->boleh_lihat_soal ?? false),
                    'sisa_waktu_detik' => $sesiAktif?->sisa_detik ?? null,
                ],
            ],
        ]);
    }

    // ── START ─────────────────────────────────────────────────────
    // POST /api/siswa/ujian/{ujian}/start

    public function start(Request $request, Ujian $ujian): JsonResponse
    {
        $siswa = $this->getSiswa();

        if ($ujian->kelas_id !== $siswa->kelas_id) {
            return response()->json(['success' => false, 'message' => 'Ujian ini bukan untuk kelas Anda.'], 403);
        }
        if (! $ujian->is_active) {
            return response()->json(['success' => false, 'message' => 'Ujian ini tidak aktif.'], 403);
        }
        if ($ujian->sudahBerakhir()) {
            return response()->json(['success' => false, 'message' => 'Waktu ujian sudah habis.'], 422);
        }
        if (! $ujian->bolehIkut($siswa->id)) {
            return response()->json(['success' => false, 'message' => 'Anda sudah mencapai batas percobaan.'], 422);
        }

        $sesiAktif = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()
            ->first();

        if ($sesiAktif) {
            if ($this->selesaikanJikaHabisWaktu($sesiAktif)) {
                // habis waktu, buat sesi baru di bawah
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Melanjutkan sesi ujian yang sedang berlangsung.',
                    'data'    => [
                        'sesi_id'          => $sesiAktif->id,
                        'sisa_waktu_detik' => $sesiAktif->sisa_detik,
                        'durasi_menit'     => $ujian->durasi_menit,
                    ],
                ]);
            }
        }

        $percobaanKe = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->count() + 1;

        /** @var SesiUjian $sesi */
        $sesi = DB::transaction(function () use ($ujian, $siswa): SesiUjian {
            $sesi = SesiUjian::create([
                'siswa_id' => $siswa->id,
                'ujian_id' => $ujian->id,
                'status'   => 'berlangsung',
            ]);
            $sesi->mulai();
            return $sesi;
        });

        $sesi->refresh();

        return response()->json([
            'success' => true,
            'message' => "Percobaan ke-{$percobaanKe} dimulai. Selamat mengerjakan!",
            'data'    => [
                'sesi_id'          => $sesi->id,
                'sisa_waktu_detik' => $sesi->sisa_detik,
                'durasi_menit'     => $ujian->durasi_menit,
            ],
        ], 201);
    }

    // ── KERJAKAN ──────────────────────────────────────────────────
    // GET /api/siswa/ujian/{ujian}/kerjakan

    public function kerjakan(Ujian $ujian): JsonResponse
    {
        $siswa = $this->getSiswa();

        $sesi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()
            ->first();

        if (! $sesi) {
            $sesiSelesai = SesiUjian::where('siswa_id', $siswa->id)
                ->where('ujian_id', $ujian->id)
                ->whereIn('status', ['selesai', 'habis_waktu'])
                ->latest('selesai_pada')
                ->first();

            return response()->json([
                'success'  => false,
                'message'  => $sesiSelesai ? 'Ujian sudah selesai.' : 'Silakan mulai ujian terlebih dahulu.',
                'redirect' => $sesiSelesai ? 'hasil' : 'info',
            ], 422);
        }

        if ($this->selesaikanJikaHabisWaktu($sesi)) {
            return response()->json([
                'success'     => false,
                'habis_waktu' => true,
                'message'     => 'Waktu ujian telah habis.',
                'redirect'    => 'hasil',
            ], 422);
        }

        $ujian->load(['mataPelajaran', 'guru']);

        $soalQuery = $ujian->soal()->with('pilihan');
        $soalList  = $ujian->acak_soal
            ? $soalQuery->get()->shuffle((int) $sesi->id)
            : $soalQuery->orderBy('nomor_soal')->orderBy('id')->get();

        $jawabanMap = JawabanSiswa::where('sesi_ujian_id', $sesi->id)
            ->get(['soal_ujian_id', 'pilihan_jawaban_id', 'jawaban_essay'])
            ->keyBy('soal_ujian_id');

        $soalFormatted = $soalList->map(function ($soal) use ($jawabanMap) {
            $jawaban        = $jawabanMap[$soal->id] ?? null;
            $pilihanDipilih = [];
            $jawabanEsai    = null;
            $sudahDijawab   = false;

            if ($jawaban) {
                if ($jawaban->pilihan_jawaban_id) {
                    $pilihanDipilih = [(string) $jawaban->pilihan_jawaban_id];
                    $sudahDijawab   = true;
                }
                if ($jawaban->jawaban_essay) {
                    $jawabanEsai  = $jawaban->jawaban_essay;
                    $sudahDijawab = true;
                }
            }

            // FIX: gunakan kolom yang benar: teks_pilihan & gambar_pilihan
            $pilihan = $soal->pilihan->map(fn ($p) => [
                'id'         => (string) $p->id,
                'teks'       => $p->teks_pilihan ?? '',
                'gambar_url' => $p->gambar_pilihan ?? null,
            ])->values();

            return [
                'id'              => $soal->id,
                'nomor'           => $soal->nomor_soal,
                'pertanyaan'      => $soal->pertanyaan ?? $soal->soal ?? '',
                'gambar_url'      => $soal->gambar_url ?? null,
                'tipe'            => $soal->tipe ?? 'pilgan_satu',
                'opsi'            => $pilihan,
                'bobot'           => $soal->bobot ?? $soal->poin ?? null,
                'jawaban_dipilih' => $pilihanDipilih,
                'jawaban_esai'    => $jawabanEsai,
                'sudah_dijawab'   => $sudahDijawab,
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data'    => [
                'ujian_id'         => $ujian->id,
                'judul_ujian'      => $ujian->judul,
                'durasi_menit'     => $ujian->durasi_menit ?? 0,
                'sisa_waktu_detik' => $sesi->sisa_detik,
                'soal'             => $soalFormatted,
            ],
        ]);
    }

    // ── JAWAB ─────────────────────────────────────────────────────
    // POST /api/siswa/ujian/{ujian}/soal/{soal}/jawab

    public function jawab(Request $request, Ujian $ujian, SoalUjian $soal): JsonResponse
    {
        $siswa = $this->getSiswa();

        if ($soal->ujian_id !== $ujian->id) {
            return response()->json(['success' => false, 'message' => 'Soal tidak valid.'], 422);
        }

        $sesi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()
            ->first();

        if (! $sesi) {
            return response()->json(['success' => false, 'message' => 'Sesi ujian tidak ditemukan.'], 404);
        }

        if ($this->selesaikanJikaHabisWaktu($sesi)) {
            return response()->json([
                'success'     => false,
                'habis_waktu' => true,
                'message'     => 'Waktu ujian habis.',
            ], 422);
        }

        $request->validate([
            'jawaban'            => ['nullable', 'array'],
            'jawaban.*'          => ['string'],
            'jawaban_esai'       => ['nullable', 'string', 'max:5000'],
            'pilihan_jawaban_id' => ['nullable', 'integer'],
        ]);

        $pilihanJawabanId = null;
        if ($request->filled('jawaban') && is_array($request->jawaban) && count($request->jawaban) > 0) {
            $pilihanJawabanId = (int) $request->jawaban[0];
        } elseif ($request->filled('pilihan_jawaban_id')) {
            $pilihanJawabanId = (int) $request->pilihan_jawaban_id;
        }

        $jawabanEsai = $request->jawaban_esai ?? null;

        try {
            $jawaban = JawabanSiswa::updateOrCreate(
                ['sesi_ujian_id' => $sesi->id, 'soal_ujian_id' => $soal->id],
                [
                    'pilihan_jawaban_id' => $pilihanJawabanId,
                    'jawaban_essay'      => $jawabanEsai,
                ]
            );

            return response()->json([
                'success'    => true,
                'jawaban_id' => $jawaban->id,
                'sisa_detik' => $sesi->fresh()->sisa_detik,
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan jawaban: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan jawaban.'], 500);
        }
    }

    // ── SELESAI ───────────────────────────────────────────────────
    // POST /api/siswa/ujian/{ujian}/selesai

    public function selesai(Request $request, Ujian $ujian): JsonResponse
    {
        $siswa = $this->getSiswa();

        $sesi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->where('status', 'berlangsung')
            ->latest()
            ->first();

        if (! $sesi) {
            $sesiSelesai = SesiUjian::where('siswa_id', $siswa->id)
                ->where('ujian_id', $ujian->id)
                ->whereIn('status', ['selesai', 'habis_waktu'])
                ->latest('selesai_pada')
                ->first();

            if ($sesiSelesai) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ujian sudah selesai sebelumnya.',
                    'data'    => [
                        'tampilkan_hasil' => (bool) ($ujian->tampilkan_nilai ?? true),
                    ],
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Sesi ujian tidak ditemukan.'], 404);
        }

        $sesi->selesaikan(habisWaktu: false);

        return response()->json([
            'success' => true,
            'message' => 'Ujian berhasil dikumpulkan!',
            'data'    => [
                'tampilkan_hasil' => (bool) ($ujian->tampilkan_nilai ?? true),
            ],
        ]);
    }

    // ── HASIL ─────────────────────────────────────────────────────
    // GET /api/siswa/ujian/{ujian}/hasil

    public function hasil(Ujian $ujian): JsonResponse
    {
        $siswa = $this->getSiswa();

        $sesi = SesiUjian::where('siswa_id', $siswa->id)
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->orderByDesc('nilai_akhir')
            ->orderByDesc('selesai_pada')
            ->first();

        if (! $sesi) {
            $sesiAktif = SesiUjian::where('siswa_id', $siswa->id)
                ->where('ujian_id', $ujian->id)
                ->where('status', 'berlangsung')
                ->latest()
                ->first();

            return response()->json([
                'success'  => false,
                'message'  => $sesiAktif ? 'Ujian Anda masih berlangsung.' : 'Anda belum pernah mengerjakan ujian ini.',
                'redirect' => $sesiAktif ? 'kerjakan' : 'index',
            ], 422);
        }

        $ujian->load(['mataPelajaran', 'guru']);

        $soalList = $ujian->soal()
            ->with('pilihan')
            ->orderBy('nomor_soal')
            ->orderBy('id')
            ->get();

        $jawabanMap = JawabanSiswa::where('sesi_ujian_id', $sesi->id)
            ->get()
            ->keyBy('soal_ujian_id');

        $totalSoal      = $soalList->count();
        $tampilkanNilai = (bool) ($ujian->tampilkan_nilai ?? true);

        $detailSoal = [];
        if ($tampilkanNilai) {
            $detailSoal = $soalList->map(function ($soal) use ($jawabanMap) {
                $jawaban          = $jawabanMap[$soal->id] ?? null;
                $jawabanSiswa     = [];
                $jawabanEsaiSiswa = null;

                if ($jawaban) {
                    if ($jawaban->pilihan_jawaban_id) {
                        $jawabanSiswa = [(string) $jawaban->pilihan_jawaban_id];
                    }
                    $jawabanEsaiSiswa = $jawaban->jawaban_essay ?? null;
                }

                $jawabanBenar = $soal->pilihan
                    ->where('adalah_benar', true)
                    ->map(fn ($p) => (string) $p->id)
                    ->values()
                    ->toArray();

                // FIX: gunakan kolom yang benar: teks_pilihan & gambar_pilihan
                $opsi = $soal->pilihan->map(fn ($p) => [
                    'id'         => (string) $p->id,
                    'teks'       => $p->teks_pilihan ?? '',
                    'gambar_url' => $p->gambar_pilihan ?? null,
                ])->values();

                return [
                    'soal_id'            => $soal->id,
                    'nomor'              => $soal->nomor_soal,
                    'pertanyaan'         => $soal->pertanyaan ?? $soal->soal ?? '',
                    'tipe'               => $soal->tipe ?? 'pilgan_satu',
                    'opsi'               => $opsi,
                    'jawaban_siswa'      => $jawabanSiswa,
                    'jawaban_esai_siswa' => $jawabanEsaiSiswa,
                    'jawaban_benar'      => $jawabanBenar,
                    'pembahasan'         => $soal->pembahasan ?? null,
                    'is_benar'           => $jawaban ? (bool) $jawaban->adalah_benar : false,
                    'poin'               => $jawaban ? ($jawaban->poin_didapat ?? 0) : 0,
                    'poin_maksimal'      => $soal->bobot ?? $soal->poin ?? null,
                ];
            })->values()->toArray();
        }

        $dijawab      = $jawabanMap->filter(fn ($j) => $j->pilihan_jawaban_id || $j->jawaban_essay)->count();
        $tidakDijawab = max(0, $totalSoal - $dijawab);

        $durasiPengerjaan = null;
        if ($sesi->mulai_pada && $sesi->selesai_pada) {
            $detik = $sesi->selesai_pada->diffInSeconds($sesi->mulai_pada);
            $menit = intdiv($detik, 60);
            $sisa  = $detik % 60;
            $durasiPengerjaan = $menit > 0
                ? "{$menit} menit {$sisa} detik"
                : "{$sisa} detik";
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'ujian_id'             => $ujian->id,
                'judul_ujian'          => $ujian->judul,
                'mata_pelajaran'       => $ujian->mataPelajaran ? [
                    'id'         => $ujian->mataPelajaran->id,
                    'nama_mapel' => $ujian->mataPelajaran->nama_mapel,
                ] : null,
                'nilai_akhir'          => (float) ($sesi->nilai_akhir ?? 0),
                'nilai_kkm'            => $ujian->nilai_kkm ?? null,
                'jumlah_benar'         => (int) ($sesi->total_benar ?? 0),
                'jumlah_salah'         => (int) ($sesi->total_salah ?? 0),
                'jumlah_tidak_dijawab' => $tidakDijawab,
                'total_soal'           => $totalSoal,
                'selesai_pada'         => $sesi->selesai_pada?->toIso8601String(),
                'durasi_pengerjaan'    => $durasiPengerjaan,
                'lulus'                => (bool) ($sesi->lulus ?? false),
                'tampilkan_pembahasan' => $tampilkanNilai,
                'detail_soal'          => $detailSoal,
            ],
        ]);
    }
}