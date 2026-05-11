<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelanggaran;
use App\Models\Kelas;
use App\Models\LogPiket;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PelanggaranController extends Controller
{
    /**
     * Status yang boleh diinput/diedit oleh piket.
     */
    private const STATUS_INPUT = [
        Pelanggaran::STATUS_PENDING,
        Pelanggaran::STATUS_DIPROSES,
    ];

    // =========================================================================
    // INDEX
    // =========================================================================

    public function index(Request $request): View
    {
        $userId      = Auth::id();
        $guruAktifId = $this->resolveGuruAktifId($userId);

        $query = Pelanggaran::with(['siswa.kelas', 'kategori', 'dicatatOleh']);

        if ($guruAktifId) {
            $query->where('dicatat_oleh', $userId);
        } else {
            $query->whereDate('tanggal', today());
        }

        // ── Filter ──────────────────────────────────────────────────────────
        if ($request->filled('kategori_id')) {
            $query->where('kategori_pelanggaran_id', $request->integer('kategori_id'));
        }

        if ($request->filled('status') && in_array($request->status, Pelanggaran::STATUSES, true)) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn (Builder $q) =>
                $q->where('kelas_id', $request->integer('kelas_id'))
            );
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->whereHas('siswa', fn (Builder $q) =>
                $q->where('nama_lengkap', 'like', "%{$s}%")
                  ->orWhere('nis', 'like', "%{$s}%")
            );
        }

        $pelanggaran = $query->latest('tanggal')->latest('id')->paginate(20)->withQueryString();

        // ── Stats ────────────────────────────────────────────────────────────
        $stats = $this->buildStats($userId, (bool) $guruAktifId);

        // ── Lookup data untuk filter ─────────────────────────────────────────
        // FIX: Assign semua variabel SEBELUM compact() dipanggil.
        // Bug asal: compact() dipanggil dulu, lalu ->with([...]) assign variabel
        // setelahnya — PHP sudah mengeksekusi compact() dengan variabel undefined.
        $kategoriList = KategoriPelanggaran::aktif()->orderBy('nama')->get();
        $kelasList    = Kelas::aktif()->orderBy('nama_kelas')->get();
        $statusList   = Pelanggaran::STATUSES;

        return view('piket.pelanggaran.index', compact(
            'pelanggaran',
            'stats',
            'kategoriList',
            'kelasList',
            'statusList',
            'guruAktifId',
        ));
    }

    // =========================================================================
    // CREATE
    // =========================================================================

    public function create(): View
    {
        $userId      = Auth::id();
        $guruAktifId = $this->resolveGuruAktifId($userId);

        // FIX: assign variabel dulu, baru compact — konsisten dengan index()
        $siswaList    = Siswa::aktif()->with('kelas')->orderBy('nama_lengkap')->get();
        $kategoriList = KategoriPelanggaran::aktif()->orderBy('nama')->get();

        return view('piket.pelanggaran.create', compact(
            'siswaList',
            'kategoriList',
            'guruAktifId',
        ));
    }

    // =========================================================================
    // STORE
    // =========================================================================

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->storeRules(), $this->messages());

        Pelanggaran::create(array_merge($validated, [
            'dicatat_oleh' => Auth::id(),
        ]));

        return redirect()
            ->route('piket.pelanggaran.index')
            ->with('success', 'Pelanggaran berhasil dicatat.');
    }

    // =========================================================================
    // SHOW
    // =========================================================================

    public function show(Pelanggaran $pelanggaran): View
    {
        $pelanggaran->load(['siswa.kelas', 'kategori', 'dicatatOleh']);

        $totalPoinSiswa = Pelanggaran::where('siswa_id', $pelanggaran->siswa_id)
            ->whereNotIn('status', [Pelanggaran::STATUS_DIBATALKAN, Pelanggaran::STATUS_BANDING])
            ->sum('poin');

        $riwayatPelanggaran = Pelanggaran::where('siswa_id', $pelanggaran->siswa_id)
            ->where('id', '!=', $pelanggaran->id)
            ->with('kategori')
            ->latest('tanggal')
            ->limit(10)
            ->get();

        $isOwner = $pelanggaran->dicatat_oleh === Auth::id();

        return view('piket.pelanggaran.show', compact(
            'pelanggaran',
            'totalPoinSiswa',
            'riwayatPelanggaran',
            'isOwner',
        ));
    }

    // =========================================================================
    // EDIT
    // =========================================================================

    public function edit(Pelanggaran $pelanggaran): View
    {
        $this->authorizeOwnership($pelanggaran);
        $this->authorizeEditableStatus($pelanggaran);

        // FIX: assign dulu baru compact, sama polanya dengan method lain
        $siswaList    = Siswa::aktif()->with('kelas')->orderBy('nama_lengkap')->get();
        $kategoriList = KategoriPelanggaran::aktif()->orderBy('nama')->get();
        $statusList   = self::STATUS_INPUT;

        return view('piket.pelanggaran.edit', compact(
            'pelanggaran',
            'siswaList',
            'kategoriList',
            'statusList',
        ));
    }

    // =========================================================================
    // UPDATE
    // =========================================================================

    public function update(Request $request, Pelanggaran $pelanggaran): RedirectResponse
    {
        $this->authorizeOwnership($pelanggaran);
        $this->authorizeEditableStatus($pelanggaran);

        $validated = $request->validate($this->storeRules(), $this->messages());

        unset($validated['dicatat_oleh']);
        $pelanggaran->update($validated);

        return redirect()
            ->route('piket.pelanggaran.show', $pelanggaran)
            ->with('success', 'Data pelanggaran berhasil diperbarui.');
    }

    // =========================================================================
    // SELESAIKAN
    // =========================================================================

    public function selesaikan(Request $request, Pelanggaran $pelanggaran): RedirectResponse
    {
        $this->authorizeOwnership($pelanggaran);

        if (! in_array($pelanggaran->status, [Pelanggaran::STATUS_PENDING, Pelanggaran::STATUS_DIPROSES], true)) {
            return back()->with(
                'error',
                'Pelanggaran tidak dapat diselesaikan karena statusnya sudah ' . ucfirst($pelanggaran->status) . '.'
            );
        }

        $request->validate(
            ['tindakan' => ['nullable', 'string', 'max:500']],
            ['tindakan.max' => 'Catatan tindakan maksimal 500 karakter.']
        );

        $tindakan = $request->filled('tindakan')
            ? $request->tindakan
            : ($pelanggaran->tindakan ?? '-');

        $pelanggaran->selesaikan($tindakan);

        return back()->with('success', 'Pelanggaran berhasil diselesaikan.');
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    private function resolveGuruAktifId(int $userId): ?int
    {
        $aktif = LogPiket::where('pengguna_id', $userId)
            ->aktifHariIni()
            ->exists();

        return $aktif ? $userId : null;
    }

    private function buildStats(int $userId, bool $isAktif): array
    {
        $base = fn () => $isAktif
            ? Pelanggaran::where('dicatat_oleh', $userId)
            : Pelanggaran::whereDate('tanggal', today());

        return [
            'total'     => $base()->count(),
            'diproses'  => $base()->where('status', Pelanggaran::STATUS_DIPROSES)->count(),
            'bulan_ini' => $base()
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count(),
            'selesai'   => $base()->where('status', Pelanggaran::STATUS_SELESAI)->count(),
        ];
    }

    private function authorizeOwnership(Pelanggaran $pelanggaran): void
    {
        abort_unless(
            $pelanggaran->dicatat_oleh === Auth::id(),
            403,
            'Anda tidak berhak mengubah pelanggaran ini.'
        );
    }

    private function authorizeEditableStatus(Pelanggaran $pelanggaran): void
    {
        abort_unless(
            $pelanggaran->status === Pelanggaran::STATUS_PENDING,
            403,
            'Pelanggaran yang sudah diproses tidak dapat diedit. Hubungi Admin.'
        );
    }

    private function storeRules(): array
    {
        return [
            'siswa_id'                => ['required', 'integer', 'exists:siswa,id'],
            'kategori_pelanggaran_id' => ['required', 'integer', 'exists:kategori_pelanggaran,id'],
            'poin'                    => ['required', 'integer', 'min:1', 'max:100'],
            'deskripsi'               => ['required', 'string', 'max:1000'],
            'tanggal'                 => ['required', 'date', 'before_or_equal:today'],
            'tindakan'                => ['nullable', 'string', 'max:500'],
            'status'                  => ['required', Rule::in(self::STATUS_INPUT)],
        ];
    }

    private function messages(): array
    {
        return [
            'siswa_id.required'                => 'Siswa wajib dipilih.',
            'siswa_id.exists'                  => 'Siswa tidak ditemukan.',
            'kategori_pelanggaran_id.required' => 'Kategori pelanggaran wajib dipilih.',
            'kategori_pelanggaran_id.exists'   => 'Kategori tidak valid.',
            'poin.required'                    => 'Poin wajib diisi.',
            'poin.integer'                     => 'Poin harus berupa angka bulat.',
            'poin.min'                         => 'Poin minimal 1.',
            'poin.max'                         => 'Poin maksimal 100.',
            'deskripsi.required'               => 'Deskripsi pelanggaran wajib diisi.',
            'deskripsi.max'                    => 'Deskripsi maksimal 1.000 karakter.',
            'tanggal.required'                 => 'Tanggal wajib diisi.',
            'tanggal.date'                     => 'Format tanggal tidak valid.',
            'tanggal.before_or_equal'          => 'Tanggal tidak boleh melebihi hari ini.',
            'tindakan.max'                     => 'Tindakan maksimal 500 karakter.',
            'status.required'                  => 'Status wajib dipilih.',
            'status.in'                        => 'Status tidak valid. Pilih pending atau diproses.',
        ];
    }
}