<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\JurnalMengajar;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JurnalMengajarController extends Controller
{
    private const METODE_LIST = [
        'ceramah',
        'diskusi',
        'praktikum',
        'demonstrasi',
        'proyek',
        'lainnya',
    ];

    // ── Helper ────────────────────────────────────────────────────────────────

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

        // Base query hanya milik guru ini
        $baseQuery = JurnalMengajar::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guruId);

        // ── Stats global (sebelum filter) ──────────────────────────────────
        $totalJurnal     = (clone $baseQuery)->count();
        $totalVerifikasi = (clone $baseQuery)->whereNotNull('diverifikasi_pada')->count();
        $totalMenunggu   = (clone $baseQuery)->whereNull('diverifikasi_pada')->count();
        $totalKelas      = (clone $baseQuery)->distinct('kelas_id')->count('kelas_id');

        // ── Filter ─────────────────────────────────────────────────────────
        $query = clone $baseQuery;

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('mata_pelajaran_id')) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        // Filter status verifikasi
        if ($request->filled('status')) {
            if ($request->status === 'verified') {
                $query->whereNotNull('diverifikasi_pada');
            } elseif ($request->status === 'pending') {
                $query->whereNull('diverifikasi_pada');
            }
        }

        $jurnal    = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();
        $kelasList = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList = MataPelajaran::aktif()->orderBy('nama_mapel')->get();

        return view('guru.jurnal-mengajar.index', compact(
            'jurnal',
            'kelasList',
            'mapelList',
            'totalJurnal',
            'totalVerifikasi',
            'totalMenunggu',
            'totalKelas'
        ));
    }

    // ── Create ────────────────────────────────────────────────────────────────

    public function create()
    {
        $guruId = $this->getGuruId();

        $kelasList  = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList  = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $jadwalList = JadwalPelajaran::aktif()
            ->with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guruId)
            ->get();
        $metodeList = self::METODE_LIST;

        return view('guru.jurnal-mengajar.create',
            compact('kelasList', 'mapelList', 'jadwalList', 'metodeList'));
    }

    // ── Store ─────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $guruId = $this->getGuruId();

        $validated = $request->validate([
            'kelas_id'            => ['required', 'exists:kelas,id'],
            'mata_pelajaran_id'   => ['required', 'exists:mata_pelajaran,id'],
            'jadwal_pelajaran_id' => ['nullable', 'exists:jadwal_pelajaran,id'],
            'tanggal'             => ['required', 'date', 'before_or_equal:today'],
            'pertemuan_ke'        => ['nullable', 'integer', 'min:1', 'max:52'],
            'materi_ajar'         => ['required', 'string', 'max:2000'],
            'metode_pembelajaran' => ['nullable', 'string', 'in:' . implode(',', self::METODE_LIST)],
            'jumlah_hadir'        => ['nullable', 'integer', 'min:0'],
            'jumlah_tidak_hadir'  => ['nullable', 'integer', 'min:0'],
            'catatan_kelas'       => ['nullable', 'string', 'max:2000'],
        ], $this->messages());

        $validated['guru_id'] = $guruId;

        JurnalMengajar::create($validated);

        return redirect()->route('guru.jurnal-mengajar.index')
            ->with('success', 'Jurnal mengajar berhasil ditambahkan.');
    }

    // ── Show ──────────────────────────────────────────────────────────────────

    public function show(JurnalMengajar $jurnal)
    {
        $guruId = $this->getGuruId();
        abort_if($jurnal->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke jurnal ini.');

        $jurnal->load(['kelas', 'mataPelajaran', 'jadwalPelajaran', 'diverifikasiOleh']);

        return view('guru.jurnal-mengajar.show', compact('jurnal'));
    }

    // ── Edit ──────────────────────────────────────────────────────────────────

    public function edit(JurnalMengajar $jurnal)
    {
        $guruId = $this->getGuruId();
        abort_if($jurnal->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke jurnal ini.');

        if ($jurnal->diverifikasi_pada) {
            return back()->with('error', 'Jurnal yang sudah diverifikasi tidak dapat diubah.');
        }

        $kelasList  = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList  = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $jadwalList = JadwalPelajaran::aktif()
            ->with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guruId)
            ->get();
        $metodeList = self::METODE_LIST;

        return view('guru.jurnal-mengajar.edit',
            compact('jurnal', 'kelasList', 'mapelList', 'jadwalList', 'metodeList'));
    }

    // ── Update ────────────────────────────────────────────────────────────────

    public function update(Request $request, JurnalMengajar $jurnal)
    {
        $guruId = $this->getGuruId();
        abort_if($jurnal->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke jurnal ini.');

        if ($jurnal->diverifikasi_pada) {
            return back()->with('error', 'Jurnal yang sudah diverifikasi tidak dapat diubah.');
        }

        $validated = $request->validate([
            'kelas_id'            => ['required', 'exists:kelas,id'],
            'mata_pelajaran_id'   => ['required', 'exists:mata_pelajaran,id'],
            'jadwal_pelajaran_id' => ['nullable', 'exists:jadwal_pelajaran,id'],
            'tanggal'             => ['required', 'date', 'before_or_equal:today'],
            'pertemuan_ke'        => ['nullable', 'integer', 'min:1', 'max:52'],
            'materi_ajar'         => ['required', 'string', 'max:2000'],
            'metode_pembelajaran' => ['nullable', 'string', 'in:' . implode(',', self::METODE_LIST)],
            'jumlah_hadir'        => ['nullable', 'integer', 'min:0'],
            'jumlah_tidak_hadir'  => ['nullable', 'integer', 'min:0'],
            'catatan_kelas'       => ['nullable', 'string', 'max:2000'],
        ], $this->messages());

        $jurnal->update($validated);

        return redirect()->route('guru.jurnal-mengajar.show', $jurnal)
            ->with('success', 'Jurnal mengajar berhasil diperbarui.');
    }

    // ── Destroy ───────────────────────────────────────────────────────────────

    public function destroy(JurnalMengajar $jurnal)
    {
        $guruId = $this->getGuruId();
        abort_if($jurnal->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke jurnal ini.');

        if ($jurnal->diverifikasi_pada) {
            return back()->with('error', 'Jurnal yang sudah diverifikasi tidak dapat dihapus.');
        }

        $jurnal->delete();

        return redirect()->route('guru.jurnal-mengajar.index')
            ->with('success', 'Jurnal mengajar berhasil dihapus.');
    }

    // ── Validation Messages ───────────────────────────────────────────────────

    private function messages(): array
    {
        return [
            'kelas_id.required'            => 'Kelas wajib dipilih.',
            'kelas_id.exists'              => 'Kelas yang dipilih tidak valid.',
            'mata_pelajaran_id.required'   => 'Mata pelajaran wajib dipilih.',
            'mata_pelajaran_id.exists'     => 'Mata pelajaran yang dipilih tidak valid.',
            'jadwal_pelajaran_id.exists'   => 'Jadwal pelajaran yang dipilih tidak valid.',
            'tanggal.required'             => 'Tanggal jurnal wajib diisi.',
            'tanggal.date'                 => 'Format tanggal tidak valid.',
            'tanggal.before_or_equal'      => 'Tanggal jurnal tidak boleh lebih dari hari ini.',
            'pertemuan_ke.integer'         => 'Pertemuan ke harus berupa angka.',
            'pertemuan_ke.min'             => 'Pertemuan ke minimal 1.',
            'pertemuan_ke.max'             => 'Pertemuan ke maksimal 52.',
            'materi_ajar.required'         => 'Materi ajar wajib diisi.',
            'materi_ajar.max'              => 'Materi ajar maksimal 2000 karakter.',
            'metode_pembelajaran.in'       => 'Metode pembelajaran yang dipilih tidak valid.',
            'jumlah_hadir.integer'         => 'Jumlah hadir harus berupa angka.',
            'jumlah_hadir.min'             => 'Jumlah hadir tidak boleh negatif.',
            'jumlah_tidak_hadir.integer'   => 'Jumlah tidak hadir harus berupa angka.',
            'jumlah_tidak_hadir.min'       => 'Jumlah tidak hadir tidak boleh negatif.',
            'catatan_kelas.max'            => 'Catatan kelas maksimal 2000 karakter.',
        ];
    }
}