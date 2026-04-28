<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelanggaran;
use App\Models\Kelas;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PelanggaranController extends Controller
{
    // Kolom yang tersedia di tabel pelanggaran: dicatat_oleh (user_id)
    // Tidak ada dicatat_oleh_guru_id — semua query pakai Auth::id()

    private const STATUS_INPUT = ['pending', 'diproses'];
    private const STATUS_LIST  = ['pending', 'diproses', 'selesai', 'banding'];

    // ── INDEX ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $user   = Auth::user();
        $userId = Auth::id();

        // Cek apakah user sedang aktif piket hari ini (sudah check-in, belum checkout)
        $logAktif = \App\Models\LogPiket::where('pengguna_id', $userId)
            ->whereDate('tanggal', today())
            ->whereNotNull('masuk_pada')
            ->whereNull('keluar_pada')
            ->first();

        $guruAktifId = $logAktif ? $userId : null;

        // Jika sudah check-in: tampilkan pelanggaran yang dicatat oleh user ini
        // Jika belum check-in: tampilkan semua pelanggaran hari ini (read-only)
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

        $pelanggaran = $query->latest('tanggal')->paginate(20)->withQueryString();

        // Stats
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

        $kategoriList = KategoriPelanggaran::orderBy('nama')->get();
        $kelasList    = Kelas::aktif()->orderBy('nama_kelas')->get();
        $statusList   = self::STATUS_LIST;

        return view('piket.pelanggaran.index', compact(
            'pelanggaran',
            'stats',
            'kategoriList',
            'kelasList',
            'statusList',
            'guruAktifId',  // ← ini yang ditambahkan
        ));
    }

    // ── CREATE & STORE ────────────────────────────────────────────────────────

    public function create()
    {
        $siswaList    = Siswa::aktif()->with('kelas')->orderBy('nama_lengkap')->get();
        $kategoriList = KategoriPelanggaran::aktif()->orderBy('nama')->get();

        return view('piket.pelanggaran.create', compact('siswaList', 'kategoriList'));
    }

    public function store(Request $request)
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

        // Simpan user_id akun yang login sebagai pencatat
        $validated['dicatat_oleh'] = Auth::id();

        Pelanggaran::create($validated);

        return redirect()->route('piket.pelanggaran.index')
            ->with('success', 'Pelanggaran berhasil dicatat.');
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    public function show(Pelanggaran $pelanggaran)
    {
        $this->authorizeOwnership($pelanggaran);

        $pelanggaran->load(['siswa.kelas', 'kategori', 'dicatatOleh']);

        $totalPoinSiswa = Pelanggaran::where('siswa_id', $pelanggaran->siswa_id)
            ->whereNotIn('status', ['banding'])
            ->sum('poin');

        return view('piket.pelanggaran.show', compact(
            'pelanggaran',
            'totalPoinSiswa',
        ));
    }

    // ── EDIT & UPDATE ─────────────────────────────────────────────────────────

    public function edit(Pelanggaran $pelanggaran)
    {
        $this->authorizeOwnership($pelanggaran);

        abort_unless(
            $pelanggaran->status === 'pending',
            403,
            'Pelanggaran yang sudah diproses tidak dapat diedit.'
        );

        $siswaList    = Siswa::aktif()->with('kelas')->orderBy('nama_lengkap')->get();
        $kategoriList = KategoriPelanggaran::aktif()->orderBy('nama')->get();
        $statusList   = self::STATUS_INPUT;

        return view('piket.pelanggaran.edit', compact('pelanggaran', 'siswaList', 'kategoriList', 'statusList'));
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $this->authorizeOwnership($pelanggaran);

        abort_unless(
            $pelanggaran->status === 'pending',
            403,
            'Pelanggaran yang sudah diproses tidak dapat diedit.'
        );

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

        return redirect()->route('piket.pelanggaran.show', $pelanggaran)
            ->with('success', 'Data pelanggaran berhasil diperbarui.');
    }

    // ── SELESAIKAN ────────────────────────────────────────────────────────────

    public function selesaikan(Request $request, Pelanggaran $pelanggaran)
    {
        $this->authorizeOwnership($pelanggaran);

        $request->validate([
            'tindakan' => ['nullable', 'string'],
        ]);

        $pelanggaran->selesaikan($request->tindakan ?? $pelanggaran->tindakan ?? '-');

        return back()->with('success', 'Pelanggaran berhasil diselesaikan.');
    }

    // ── Helper ────────────────────────────────────────────────────────────────

    /**
     * Otorisasi ownership: hanya user yang mencatat (dicatat_oleh)
     * yang boleh akses/edit data pelanggaran ini.
     */
    private function authorizeOwnership(Pelanggaran $pelanggaran): void
    {
        abort_unless(
            $pelanggaran->dicatat_oleh === Auth::id(),
            403,
            'Anda tidak berhak mengakses data pelanggaran ini.'
        );
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