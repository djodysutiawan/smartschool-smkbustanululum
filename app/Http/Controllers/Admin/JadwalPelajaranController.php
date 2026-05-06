<?php

namespace App\Http\Controllers\Admin;

use App\Exports\JadwalPelajaranExport;
use App\Http\Controllers\Controller;
use App\Imports\JadwalPelajaranImport;
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Ruang;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;

class JadwalPelajaranController extends Controller
{
    private const HARI_OPTIONS = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

    // ── INDEX ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = JadwalPelajaran::with(['guru', 'mataPelajaran', 'kelas.jurusan', 'ruang', 'tahunAjaran']);

        if ($request->filled('tahun_ajaran_id')) $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        if ($request->filled('kelas_id'))        $query->where('kelas_id', $request->kelas_id);
        if ($request->filled('guru_id'))         $query->where('guru_id', $request->guru_id);
        if ($request->filled('hari'))            $query->where('hari', $request->hari);
        if ($request->filled('is_active'))       $query->where('is_active', $request->boolean('is_active'));

        $jadwal = $query
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->paginate(20)
            ->withQueryString();

        // ── FIX: Hitung stats dari DB langsung, bukan dari hasil paginate ──────
        // Bangun query stats dengan filter yang sama agar konsisten dengan tampilan
        $statsQuery = JadwalPelajaran::query();
        if ($request->filled('tahun_ajaran_id')) $statsQuery->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        if ($request->filled('kelas_id'))        $statsQuery->where('kelas_id', $request->kelas_id);
        if ($request->filled('guru_id'))         $statsQuery->where('guru_id', $request->guru_id);
        if ($request->filled('hari'))            $statsQuery->where('hari', $request->hari);
        if ($request->filled('is_active'))       $statsQuery->where('is_active', $request->boolean('is_active'));

        $stats = [
            'total'       => $jadwal->total(),                                     // total semua dari filter
            'total_aktif' => (clone $statsQuery)->where('is_active', true)->count(),
            // Guru & kelas unik yang terlibat (sesuai filter aktif)
            'total_guru'  => (clone $statsQuery)->distinct()->count('guru_id'),
            'total_kelas' => (clone $statsQuery)->distinct()->count('kelas_id'),
        ];

        $tahunAjaran = TahunAjaran::orderByDesc('id')->get();
        $kelasList   = Kelas::aktif()->with('jurusan')->orderBy('tingkat')->orderBy('nama_kelas')->get();
        $guruList    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $hariList    = self::HARI_OPTIONS;

        return view('admin.jadwal_pelajaran.index',
            compact('jadwal', 'tahunAjaran', 'kelasList', 'guruList', 'hariList', 'stats'));
    }

    // ── CREATE & STORE ────────────────────────────────────────────────────────

    public function create()
    {
        $tahunAjaran = TahunAjaran::orderByDesc('id')->get();
        $kelasList   = Kelas::aktif()->with('jurusan')->orderBy('tingkat')->orderBy('nama_kelas')->get();
        $guruList    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $ruangList   = Ruang::tersedia()->with('gedung')->orderBy('nama_ruang')->get();
        $hariList    = self::HARI_OPTIONS;

        return view('admin.jadwal_pelajaran.create',
            compact('tahunAjaran', 'kelasList', 'guruList', 'ruangList', 'hariList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'guru_id'           => ['required', 'exists:guru,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'ruang_id'          => ['nullable', 'exists:ruang,id'],
            'hari'              => ['required', Rule::in(self::HARI_OPTIONS)],
            'jam_mulai'         => ['required', 'date_format:H:i'],
            'jam_selesai'       => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'pertemuan_ke'      => ['nullable', 'integer', 'min:1'],
            'sumber_jadwal'     => ['nullable', Rule::in(['manual', 'otomatis'])],
            'is_active'         => ['boolean'],
        ], $this->pesanValidasi());

        $this->validasiMapelVsKelas($validated['mata_pelajaran_id'], $validated['kelas_id']);

        $pesanJam = $this->cekJamPerMinggu(
            $validated['mata_pelajaran_id'],
            $validated['kelas_id'],
            $validated['tahun_ajaran_id'],
            $validated['jam_mulai'],
            $validated['jam_selesai'],
        );
        if ($pesanJam) {
            return back()->withInput()->with('error', $pesanJam);
        }

        $konflik = $this->cekKonflikJadwal(
            $validated['guru_id'],
            $validated['kelas_id'],
            $validated['ruang_id'] ?? null,
            $validated['tahun_ajaran_id'],
            $validated['hari'],
            $validated['jam_mulai'],
            $validated['jam_selesai'],
        );
        if ($konflik) {
            return back()->withInput()->with('error', $konflik);
        }

        JadwalPelajaran::create($validated);

        return redirect()->route('admin.jadwal-pelajaran.index')
            ->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    public function show(JadwalPelajaran $jadwalPelajaran)
    {
        // ── FIX: Eager-load absensi di dalam sesiQr agar tidak N+1 ──────────
        $jadwalPelajaran->load([
            'guru',
            'mataPelajaran',
            'kelas.jurusan',
            'kelas.siswa',          // untuk total siswa per sesi (jika dibutuhkan)
            'ruang.gedung',
            'tahunAjaran',
            'sesiQr' => fn($q) => $q->with([
                'absensi' => fn($qa) => $qa->select('id', 'sesi_qr_id', 'status'),
            ])->latest()->limit(10),
        ]);

        $stats = [
            'total_pertemuan'  => $jadwalPelajaran->sesiQr()->count(),
            'total_hadir'      => $jadwalPelajaran->absensi()->whereIn('status', ['hadir', 'telat'])->count(),
            'total_absensi'    => $jadwalPelajaran->absensi()->count(),
            'persen_kehadiran' => $jadwalPelajaran->persentase_kehadiran_kelas,
            'ada_sesi_aktif'   => $jadwalPelajaran->hasSesiQrAktifHariIni(),
        ];

        return view('admin.jadwal_pelajaran.show', compact('jadwalPelajaran', 'stats'));
    }

    // ── EDIT & UPDATE ─────────────────────────────────────────────────────────

    public function edit(JadwalPelajaran $jadwalPelajaran)
    {
        $tahunAjaran = TahunAjaran::orderByDesc('id')->get();
        $kelasList   = Kelas::aktif()->with('jurusan')->orderBy('tingkat')->orderBy('nama_kelas')->get();
        $guruList    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $ruangList   = Ruang::with('gedung')->orderBy('nama_ruang')->get();
        $hariList    = self::HARI_OPTIONS;

        return view('admin.jadwal_pelajaran.edit',
            compact('jadwalPelajaran', 'tahunAjaran', 'kelasList', 'guruList',
                    'ruangList', 'hariList'));
    }

    public function update(Request $request, JadwalPelajaran $jadwalPelajaran)
    {
        $validated = $request->validate([
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'guru_id'           => ['required', 'exists:guru,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'ruang_id'          => ['nullable', 'exists:ruang,id'],
            'hari'              => ['required', Rule::in(self::HARI_OPTIONS)],
            'jam_mulai'         => ['required', 'date_format:H:i'],
            'jam_selesai'       => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'pertemuan_ke'      => ['nullable', 'integer', 'min:1'],
            // ── FIX: sumber_jadwal ada di edit view tapi sebelumnya tidak divalidasi ──
            'sumber_jadwal'     => ['nullable', Rule::in(['manual', 'otomatis'])],
            'is_active'         => ['boolean'],
        ], $this->pesanValidasi());

        $this->validasiMapelVsKelas($validated['mata_pelajaran_id'], $validated['kelas_id']);

        $pesanJam = $this->cekJamPerMinggu(
            $validated['mata_pelajaran_id'],
            $validated['kelas_id'],
            $validated['tahun_ajaran_id'],
            $validated['jam_mulai'],
            $validated['jam_selesai'],
            $jadwalPelajaran->id,
        );
        if ($pesanJam) {
            return back()->withInput()->with('error', $pesanJam);
        }

        $konflik = $this->cekKonflikJadwal(
            $validated['guru_id'],
            $validated['kelas_id'],
            $validated['ruang_id'] ?? null,
            $validated['tahun_ajaran_id'],
            $validated['hari'],
            $validated['jam_mulai'],
            $validated['jam_selesai'],
            $jadwalPelajaran->id,
        );
        if ($konflik) {
            return back()->withInput()->with('error', $konflik);
        }

        $jadwalPelajaran->update($validated);

        return redirect()->route('admin.jadwal-pelajaran.show', $jadwalPelajaran)
            ->with('success', 'Jadwal pelajaran berhasil diperbarui.');
    }

    // ── DESTROY ───────────────────────────────────────────────────────────────

    public function destroy(JadwalPelajaran $jadwalPelajaran)
    {
        if ($jadwalPelajaran->sesiQr()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus jadwal yang sudah memiliki sesi QR absensi.');
        }
        if ($jadwalPelajaran->absensi()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus jadwal yang sudah memiliki data absensi.');
        }

        $jadwalPelajaran->delete();

        return redirect()->route('admin.jadwal-pelajaran.index')
            ->with('success', 'Jadwal pelajaran berhasil dihapus.');
    }

    // ── TOGGLE STATUS ─────────────────────────────────────────────────────────

    public function toggleStatus(JadwalPelajaran $jadwalPelajaran)
    {
        $jadwalPelajaran->update(['is_active' => ! $jadwalPelajaran->is_active]);
        $status = $jadwalPelajaran->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Jadwal berhasil {$status}.");
    }

    // ── GENERATE QR LANGSUNG ──────────────────────────────────────────────────

    public function generateQr(JadwalPelajaran $jadwalPelajaran)
    {
        if ($jadwalPelajaran->hasSesiQrAktifHariIni()) {
            $sesi = $jadwalPelajaran->getSesiQrAktifHariIni();
            return redirect()->route('admin.sesi-qr.show', $sesi)
                ->with('info', 'Sudah ada sesi QR aktif hari ini untuk jadwal ini.');
        }

        return redirect()->route('admin.sesi-qr.create', [
            'jadwal_pelajaran_id' => $jadwalPelajaran->id,
            'kelas_id'            => $jadwalPelajaran->kelas_id,
            'mata_pelajaran_id'   => $jadwalPelajaran->mata_pelajaran_id,
            'tanggal'             => today()->toDateString(),
            'berlaku_mulai'       => substr($jadwalPelajaran->jam_mulai, 0, 5),
        ]);
    }

    // ── AJAX: GET MAPEL BY KELAS ──────────────────────────────────────────────

    /**
     * AJAX endpoint — mengembalikan mapel + field terpakai_menit agar
     * kuota badge di JS bisa menampilkan data yang akurat.
     *
     * FIX: Sebelumnya terpakai_menit tidak dikembalikan sehingga badge
     * selalu menampilkan 0.
     */
    public function getMapelByKelas(Request $request)
    {
        $kelas = Kelas::with('jurusan')->find($request->kelas_id);
        if (! $kelas) {
            return response()->json([]);
        }

        $tingkatAngka = match ($kelas->tingkat) {
            'X'   => 10,
            'XI'  => 11,
            'XII' => 12,
            default => null,
        };

        // [1] Ambil mapel sesuai jurusan + tingkat kelas
        $mapel = MataPelajaran::aktif()
            ->when(
                $kelas->jurusan_id,
                fn($q) => $q->untukJurusan($kelas->jurusan_id, $tingkatAngka)
            )
            ->orderBy('nama_mapel')
            ->get(['id', 'nama_mapel', 'kode_mapel', 'kelompok', 'scope',
                   'jam_per_minggu', 'durasi_per_sesi']);

        $excludeId = $request->filled('exclude_id') ? (int) $request->exclude_id : null;

        // [2] Keluarkan mapel yang sudah dijadwalkan di hari + kelas + tahun_ajaran yang sama
        if ($request->filled('hari') && $request->filled('tahun_ajaran_id')) {
            $sudahDiHariIni = JadwalPelajaran::where('kelas_id', $kelas->id)
                ->where('hari', $request->hari)
                ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
                ->where('is_active', true)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->pluck('mata_pelajaran_id')
                ->toArray();

            $mapel = $mapel->whereNotIn('id', $sudahDiHariIni)->values();
        }

        // ── FIX: Hitung terpakai_menit per mapel dan inject ke collection ────
        // Agar JS dapat menampilkan badge kuota yang akurat
        $terpakaiMap = [];
        if ($request->filled('tahun_ajaran_id')) {
            $jadwalAktif = JadwalPelajaran::where('kelas_id', $kelas->id)
                ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
                ->where('is_active', true)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->get(['mata_pelajaran_id', 'jam_mulai', 'jam_selesai']);

            foreach ($jadwalAktif as $j) {
                $mid = $j->mata_pelajaran_id;
                $terpakaiMap[$mid] = ($terpakaiMap[$mid] ?? 0)
                    + (int) Carbon::parse($j->jam_mulai)->diffInMinutes($j->jam_selesai);
            }
        }

        // [3] Keluarkan mapel yang kuota jam per minggunya sudah terpenuhi
        if ($request->filled('tahun_ajaran_id')) {
            $terpenuhi = $this->getMapelKuotaTerpenuhi(
                $kelas->id,
                (int) $request->tahun_ajaran_id,
                $excludeId,
            );
            $mapel = $mapel->whereNotIn('id', $terpenuhi)->values();
        }

        // Inject terpakai_menit ke setiap item mapel
        $mapel = $mapel->map(function ($m) use ($terpakaiMap) {
            $m->terpakai_menit = $terpakaiMap[$m->id] ?? 0;
            return $m;
        });

        return response()->json($mapel);
    }

    // ── EXPORT PDF ────────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $query = JadwalPelajaran::with(['guru', 'mataPelajaran', 'kelas.jurusan', 'ruang', 'tahunAjaran']);

        if ($request->filled('tahun_ajaran_id')) $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        if ($request->filled('kelas_id'))        $query->where('kelas_id', $request->kelas_id);
        if ($request->filled('guru_id'))         $query->where('guru_id', $request->guru_id);
        if ($request->filled('hari'))            $query->where('hari', $request->hari);

        $jadwal = $query
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get();

        $filterParts = [];
        if ($request->filled('hari'))     $filterParts[] = 'Hari: ' . ucfirst($request->hari);
        if ($request->filled('kelas_id')) $filterParts[] = 'Kelas: ' . optional(Kelas::find($request->kelas_id))->nama_kelas;
        if ($request->filled('guru_id'))  $filterParts[] = 'Guru: ' . optional(Guru::find($request->guru_id))->nama_lengkap;
        $filterLabel = implode(', ', $filterParts);

        $pdf = Pdf::loadView('admin.jadwal_pelajaran.pdf', compact('jadwal', 'filterLabel'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('data-jadwal-pelajaran-' . now()->format('Ymd-His') . '.pdf');
    }

    // ── EXPORT EXCEL ──────────────────────────────────────────────────────────

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new JadwalPelajaranExport($request->all()),
            'jadwal-pelajaran-' . now()->format('Ymd-His') . '.xlsx'
        );
    }

    // ── IMPORT ────────────────────────────────────────────────────────────────

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:2048'],
        ], [
            'file.required' => 'File impor wajib diunggah.',
            'file.mimes'    => 'Format file harus xlsx, xls, atau csv.',
            'file.max'      => 'Ukuran file tidak boleh melebihi 2 MB.',
        ]);

        try {
            Excel::import(new JadwalPelajaranImport, $request->file('file'));
        } catch (ExcelValidationException $e) {
            $errors = collect($e->failures())->map(
                fn($f) => "Baris {$f->row()}: " . implode(', ', $f->errors())
            )->implode(' | ');
            return back()->with('error', 'Import gagal: ' . $errors);
        } catch (\Throwable $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }

        return back()->with('success', 'Data jadwal pelajaran berhasil diimpor.');
    }

    // ── PRIVATE HELPERS ───────────────────────────────────────────────────────

    private function validasiMapelVsKelas(int $mapelId, int $kelasId): void
    {
        $mapel = MataPelajaran::find($mapelId);
        $kelas = Kelas::find($kelasId);

        if (! $mapel || ! $kelas) return;

        if ($mapel->scope === 'umum') return;

        if (! $kelas->jurusan_id) return;

        $tingkatAngka = match ($kelas->tingkat) {
            'X'   => 10,
            'XI'  => 11,
            'XII' => 12,
            default => null,
        };

        $terdaftar = $mapel->jurusan()
            ->where('jurusan.id', $kelas->jurusan_id)
            ->where('jurusan_mata_pelajaran.is_active', true)
            ->where(function ($q) use ($tingkatAngka) {
                $q->whereNull('jurusan_mata_pelajaran.tingkat')
                  ->orWhere('jurusan_mata_pelajaran.tingkat', $tingkatAngka);
            })
            ->exists();

        if (! $terdaftar) {
            throw ValidationException::withMessages([
                'mata_pelajaran_id' => [
                    "Mata pelajaran \"{$mapel->nama_mapel}\" tidak terdaftar "
                    . "untuk jurusan {$kelas->jurusan?->nama} tingkat {$kelas->tingkat}.",
                ],
            ]);
        }
    }

    private function cekJamPerMinggu(
        int $mapelId,
        int $kelasId,
        int $tahunAjaranId,
        string $jamMulai,
        string $jamSelesai,
        ?int $kecualiId = null,
    ): ?string {
        $mapel = MataPelajaran::find($mapelId);
        if (! $mapel || $mapel->jam_per_minggu <= 0) return null;

        $durasiPerSesi = $mapel->durasi_per_sesi ?: 45;
        $kuotaMenit    = $mapel->jam_per_minggu * $durasiPerSesi;

        $jadwalAda = JadwalPelajaran::where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('mata_pelajaran_id', $mapelId)
            ->where('is_active', true)
            ->when($kecualiId, fn($q) => $q->where('id', '!=', $kecualiId))
            ->get(['jam_mulai', 'jam_selesai']);

        $totalMenitAda = $jadwalAda->sum(
            fn($j) => (int) Carbon::parse($j->jam_mulai)->diffInMinutes($j->jam_selesai)
        );

        $menitBaru = (int) Carbon::parse($jamMulai)->diffInMinutes($jamSelesai);

        if (($totalMenitAda + $menitBaru) > $kuotaMenit) {
            $sudahJam = round($totalMenitAda / 60, 1);
            $kuotaJam = round($kuotaMenit / 60, 1);
            $baruJam  = round($menitBaru / 60, 1);

            return "Mata pelajaran \"{$mapel->nama_mapel}\" sudah memiliki {$sudahJam} jam/minggu "
                 . "dari kuota {$kuotaJam} jam/minggu. "
                 . "Jadwal baru ini akan menambah {$baruJam} jam sehingga melebihi kuota.";
        }

        return null;
    }

    private function getMapelKuotaTerpenuhi(
        int $kelasId,
        int $tahunAjaranId,
        ?int $kecualiId = null,
    ): array {
        $jadwalAktif = JadwalPelajaran::where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('is_active', true)
            ->when($kecualiId, fn($q) => $q->where('id', '!=', $kecualiId))
            ->get(['mata_pelajaran_id', 'jam_mulai', 'jam_selesai']);

        $totalMenitPerMapel = [];
        foreach ($jadwalAktif as $j) {
            $mid = $j->mata_pelajaran_id;
            $totalMenitPerMapel[$mid] = ($totalMenitPerMapel[$mid] ?? 0)
                + (int) Carbon::parse($j->jam_mulai)->diffInMinutes($j->jam_selesai);
        }

        if (empty($totalMenitPerMapel)) return [];

        $mapelData = MataPelajaran::whereIn('id', array_keys($totalMenitPerMapel))
            ->get(['id', 'nama_mapel', 'jam_per_minggu', 'durasi_per_sesi']);

        $terpenuhi = [];
        foreach ($mapelData as $m) {
            if ($m->jam_per_minggu <= 0) continue;
            $kuotaMenit = $m->jam_per_minggu * ($m->durasi_per_sesi ?: 45);
            if (($totalMenitPerMapel[$m->id] ?? 0) >= $kuotaMenit) {
                $terpenuhi[] = $m->id;
            }
        }

        return $terpenuhi;
    }

    private function cekKonflikJadwal(
        int $guruId,
        int $kelasId,
        ?int $ruangId,
        int $tahunAjaranId,
        string $hari,
        string $jamMulai,
        string $jamSelesai,
        ?int $kecualiId = null,
    ): ?string {
        $base = JadwalPelajaran::where('tahun_ajaran_id', $tahunAjaranId)
            ->where('hari', $hari)
            ->where('is_active', true)
            ->where(fn($q) =>
                $q->where('jam_mulai', '<', $jamSelesai)
                  ->where('jam_selesai', '>', $jamMulai)
            )
            ->when($kecualiId, fn($q) => $q->where('id', '!=', $kecualiId));

        if ((clone $base)->where('guru_id', $guruId)->exists()) {
            return 'Guru yang dipilih sudah memiliki jadwal mengajar pada hari dan jam tersebut.';
        }

        if ((clone $base)->where('kelas_id', $kelasId)->exists()) {
            return 'Kelas yang dipilih sudah memiliki jadwal pelajaran pada hari dan jam tersebut.';
        }

        if ($ruangId && (clone $base)->where('ruang_id', $ruangId)->exists()) {
            return 'Ruangan yang dipilih sudah digunakan oleh kelas lain pada hari dan jam tersebut.';
        }

        return null;
    }

    private function pesanValidasi(): array
    {
        return [
            'tahun_ajaran_id.required'   => 'Tahun ajaran wajib dipilih.',
            'tahun_ajaran_id.exists'     => 'Tahun ajaran yang dipilih tidak ditemukan.',
            'guru_id.required'           => 'Guru wajib dipilih.',
            'guru_id.exists'             => 'Guru yang dipilih tidak ditemukan.',
            'mata_pelajaran_id.required' => 'Mata pelajaran wajib dipilih.',
            'mata_pelajaran_id.exists'   => 'Mata pelajaran yang dipilih tidak ditemukan.',
            'kelas_id.required'          => 'Kelas wajib dipilih.',
            'kelas_id.exists'            => 'Kelas yang dipilih tidak ditemukan.',
            'ruang_id.exists'            => 'Ruangan yang dipilih tidak ditemukan.',
            'hari.required'              => 'Hari wajib dipilih.',
            'hari.in'                    => 'Hari yang dipilih tidak valid.',
            'jam_mulai.required'         => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format'      => 'Format jam mulai tidak valid (HH:MM).',
            'jam_selesai.required'       => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format'    => 'Format jam selesai tidak valid (HH:MM).',
            'jam_selesai.after'          => 'Jam selesai harus setelah jam mulai.',
            'pertemuan_ke.integer'       => 'Pertemuan ke harus berupa angka.',
            'pertemuan_ke.min'           => 'Pertemuan ke minimal 1.',
        ];
    }
}