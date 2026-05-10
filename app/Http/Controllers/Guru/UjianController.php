<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UjianController extends Controller
{
    private const JENIS_LIST = ['ulangan_harian', 'uts', 'uas', 'remedial', 'quiz'];

    // ── Auth Helper ───────────────────────────────────────────────────────────

    private function getGuruId(): int
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru->id;
    }

    // ── Index ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $guruId = $this->getGuruId();

        $query = Ujian::with(['mataPelajaran', 'kelas', 'tahunAjaran'])
            ->where('guru_id', $guruId);

        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', (bool) $request->is_active);
        }
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Stats dihitung dari DB (bukan dari paginated collection) agar akurat
        $statsQuery = (clone $query);
        $globalStats = [
            'total'    => (clone $statsQuery)->count(),
            'aktif'    => (clone $statsQuery)->where('is_active', true)->count(),
            'nonaktif' => (clone $statsQuery)->where('is_active', false)->count(),
            'kelas'    => (clone $statsQuery)->distinct('kelas_id')->count('kelas_id'),
        ];

        $ujian       = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $jenisList   = self::JENIS_LIST;

        return view('guru.ujian.index',
            compact('ujian', 'tahunAjaran', 'kelasList', 'jenisList', 'globalStats'));
    }

    // ── Create ────────────────────────────────────────────────────────────────

    public function create()
    {
        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $jenisList   = self::JENIS_LIST;

        return view('guru.ujian.create', compact('kelasList', 'mapelList', 'tahunAjaran', 'jenisList'));
    }

    // ── Store ─────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $guruId = $this->getGuruId();

        $validated = $request->validate($this->rules(), $this->messages());

        // Cast boolean fields secara eksplisit (menghindari string "0"/"1")
        $validated['acak_soal']       = (bool) ($request->acak_soal ?? false);
        $validated['acak_pilihan']    = (bool) ($request->acak_pilihan ?? false);
        $validated['tampilkan_nilai'] = (bool) ($request->tampilkan_nilai ?? false);
        $validated['is_active']       = (bool) ($request->is_active ?? false);
        $validated['guru_id']         = $guruId;

        Ujian::create($validated);

        return redirect()->route('guru.ujian.index')
            ->with('success', 'Ujian berhasil ditambahkan.');
    }

    // ── Show ──────────────────────────────────────────────────────────────────

    public function show(Ujian $ujian)
    {
        $guruId = $this->getGuruId();
        abort_if($ujian->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke ujian ini.');

        $ujian->load(['mataPelajaran', 'kelas', 'tahunAjaran', 'soal']);

        // Hitung semua stats dalam 1 query agregasi untuk efisiensi
        $sesiStats = DB::table('sesi_ujian')
            ->where('ujian_id', $ujian->id)
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->selectRaw('
                COUNT(*) as total_selesai,
                SUM(CASE WHEN lulus = 1 THEN 1 ELSE 0 END) as total_lulus,
                AVG(COALESCE(nilai_akhir, 0)) as rata_nilai
            ')
            ->first();

        $stats = [
            'total_soal'    => $ujian->soal->count(), // sudah di-load, tidak query ulang
            'total_bobot'   => $ujian->soal->sum('bobot'),
            'siswa_selesai' => (int) ($sesiStats->total_selesai ?? 0),
            'siswa_lulus'   => (int) ($sesiStats->total_lulus ?? 0),
            'rata_nilai'    => round($sesiStats->rata_nilai ?? 0, 2),
        ];

        return view('guru.ujian.show', compact('ujian', 'stats'));
    }

    // ── Edit ──────────────────────────────────────────────────────────────────

    public function edit(Ujian $ujian)
    {
        $guruId = $this->getGuruId();
        abort_if($ujian->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke ujian ini.');

        $kelasList   = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $jenisList   = self::JENIS_LIST;

        return view('guru.ujian.edit',
            compact('ujian', 'kelasList', 'mapelList', 'tahunAjaran', 'jenisList'));
    }

    // ── Update ────────────────────────────────────────────────────────────────

    public function update(Request $request, Ujian $ujian)
    {
        $guruId = $this->getGuruId();
        abort_if($ujian->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke ujian ini.');

        $validated = $request->validate($this->rules(), $this->messages());

        $validated['acak_soal']       = (bool) ($request->acak_soal ?? false);
        $validated['acak_pilihan']    = (bool) ($request->acak_pilihan ?? false);
        $validated['tampilkan_nilai'] = (bool) ($request->tampilkan_nilai ?? false);
        $validated['is_active']       = (bool) ($request->is_active ?? false);

        $ujian->update($validated);

        return redirect()->route('guru.ujian.show', $ujian)
            ->with('success', 'Ujian berhasil diperbarui.');
    }

    // ── Destroy ───────────────────────────────────────────────────────────────

    public function destroy(Ujian $ujian)
    {
        $guruId = $this->getGuruId();
        abort_if($ujian->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke ujian ini.');

        if ($ujian->sesi()->whereIn('status', ['berlangsung'])->exists()) {
            return back()->with('error', 'Ujian tidak dapat dihapus karena masih ada sesi yang sedang berlangsung.');
        }

        // Cegah hapus jika sudah ada sesi selesai (data nilai siswa)
        if ($ujian->sesi()->whereIn('status', ['selesai', 'habis_waktu'])->exists()) {
            return back()->with('error', 'Ujian tidak dapat dihapus karena sudah ada siswa yang menyelesaikan ujian ini. Nonaktifkan saja jika tidak ingin digunakan.');
        }

        $ujian->delete();

        return redirect()->route('guru.ujian.index')
            ->with('success', 'Ujian berhasil dihapus.');
    }

    // ── Toggle Status ─────────────────────────────────────────────────────────

    public function toggleStatus(Ujian $ujian)
    {
        $guruId = $this->getGuruId();
        abort_if($ujian->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke ujian ini.');

        $ujian->update(['is_active' => ! $ujian->is_active]);
        $status = $ujian->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Ujian berhasil {$status}.");
    }

    // ── Hasil ─────────────────────────────────────────────────────────────────

    public function hasil(Ujian $ujian)
    {
        $guruId = $this->getGuruId();
        abort_if($ujian->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke ujian ini.');

        $ujian->load(['mataPelajaran', 'kelas', 'tahunAjaran']);

        $sesiList = $ujian->sesi()
            ->with(['siswa'])
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->orderByDesc('nilai_akhir')
            ->orderBy('selesai_pada')   // tie-breaker: yang lebih cepat selesai di atas
            ->get();

        // Hitung stats dari collection (sudah di-eager-load, tidak query lagi)
        $totalPeserta = $sesiList->count();
        $nilaiList    = $sesiList->pluck('nilai_akhir')->filter(); // buang null

        // Cast 'lulus' ke boolean agar ->filter() akurat walau model tidak cast
        $lulusCount     = $sesiList->filter(fn($s) => (bool) $s->lulus)->count();
        $tidakLulusCount = $totalPeserta - $lulusCount;

        $stats = [
            'total_peserta'   => $totalPeserta,
            'rata_nilai'      => $nilaiList->count() ? round($nilaiList->avg(), 2) : 0,
            'nilai_tertinggi' => $nilaiList->count() ? $nilaiList->max() : 0,
            'nilai_terendah'  => $nilaiList->count() ? $nilaiList->min() : 0,
            'lulus'           => $lulusCount,
            'tidak_lulus'     => $tidakLulusCount,
        ];

        return view('guru.ujian.hasil', compact('ujian', 'sesiList', 'stats'));
    }

    // ── Validation ────────────────────────────────────────────────────────────

    private function rules(): array
    {
        return [
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id'   => ['required', 'exists:tahun_ajaran,id'],
            'judul'             => ['required', 'string', 'max:255'],
            'jenis'             => ['required', Rule::in(self::JENIS_LIST)],
            'tanggal'           => ['required', 'date'],
            'jam_mulai'         => ['nullable', 'date_format:H:i'],
            'durasi_menit'      => ['required', 'integer', 'min:1', 'max:480'],
            'nilai_kkm'         => ['nullable', 'integer', 'min:0', 'max:100'],
            'acak_soal'         => ['nullable', 'boolean'],
            'acak_pilihan'      => ['nullable', 'boolean'],
            'tampilkan_nilai'   => ['nullable', 'boolean'],
            'maks_percobaan'    => ['nullable', 'integer', 'min:1', 'max:10'],
            'keterangan'        => ['nullable', 'string', 'max:1000'],
            'is_active'         => ['nullable', 'boolean'],
        ];
    }

    private function messages(): array
    {
        return [
            'mata_pelajaran_id.required' => 'Mata pelajaran wajib dipilih.',
            'mata_pelajaran_id.exists'   => 'Mata pelajaran yang dipilih tidak valid.',
            'kelas_id.required'          => 'Kelas wajib dipilih.',
            'kelas_id.exists'            => 'Kelas yang dipilih tidak valid.',
            'tahun_ajaran_id.required'   => 'Tahun ajaran wajib dipilih.',
            'tahun_ajaran_id.exists'     => 'Tahun ajaran yang dipilih tidak valid.',
            'judul.required'             => 'Judul ujian wajib diisi.',
            'judul.max'                  => 'Judul ujian maksimal 255 karakter.',
            'jenis.required'             => 'Jenis ujian wajib dipilih.',
            'jenis.in'                   => 'Jenis ujian yang dipilih tidak valid.',
            'tanggal.required'           => 'Tanggal ujian wajib diisi.',
            'tanggal.date'               => 'Format tanggal tidak valid.',
            'jam_mulai.date_format'      => 'Format jam mulai harus HH:MM.',
            'durasi_menit.required'      => 'Durasi ujian wajib diisi.',
            'durasi_menit.integer'       => 'Durasi harus berupa angka.',
            'durasi_menit.min'           => 'Durasi minimal 1 menit.',
            'durasi_menit.max'           => 'Durasi maksimal 480 menit.',
            'nilai_kkm.min'              => 'Nilai KKM minimal 0.',
            'nilai_kkm.max'              => 'Nilai KKM maksimal 100.',
            'maks_percobaan.min'         => 'Maksimal percobaan minimal 1.',
            'maks_percobaan.max'         => 'Maksimal percobaan tidak boleh lebih dari 10.',
        ];
    }
}