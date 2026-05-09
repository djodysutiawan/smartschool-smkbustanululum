<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelanggaran;
use App\Models\Kelas;
use App\Models\LogPiket;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PelanggaranController extends Controller
{
    // -------------------------------------------------------------------------
    // Piket hanya boleh input/edit: pending | diproses
    // selesai, banding, dibatalkan → hanya Admin
    // -------------------------------------------------------------------------
    private const STATUS_INPUT = ['pending', 'diproses'];
    private const STATUS_LIST  = ['pending', 'diproses', 'selesai', 'banding', 'dibatalkan'];

    // =========================================================================
    // INDEX
    // =========================================================================

    public function index(Request $request)
    {
        $userId      = Auth::id();
        $logAktif    = $this->getLogAktif($userId);
        $guruAktifId = $logAktif ? $userId : null;

        // Aktif piket  → tampilkan milik sendiri
        // Tidak aktif  → tampilkan semua pelanggaran hari ini (read-only)
        $query = Pelanggaran::with(['siswa.kelas', 'kategori', 'dicatatOleh'])
            ->when($guruAktifId,   fn (Builder $q) => $q->where('dicatat_oleh', $userId))
            ->when(! $guruAktifId, fn (Builder $q) => $q->whereDate('tanggal', today()));

        if ($request->filled('kategori_id')) {
            $query->where('kategori_pelanggaran_id', $request->kategori_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn (Builder $q) => $q->where('kelas_id', $request->kelas_id));
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('siswa', fn (Builder $q) => $q
                ->where('nama_lengkap', 'like', "%{$s}%")
                ->orWhere('nis', 'like', "%{$s}%"));
        }

        $pelanggaran = $query->latest('tanggal')->paginate(20)->withQueryString();

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
            'guruAktifId',
        ));
    }

    // =========================================================================
    // CREATE & STORE
    // — Tidak diblokir meski belum check-in.
    //   View akan tampilkan banner peringatan via $guruAktifId === null.
    // =========================================================================

    public function create()
    {
        $userId      = Auth::id();
        $guruAktifId = $this->getLogAktif($userId) ? $userId : null;

        $siswaList    = Siswa::aktif()->with('kelas')->orderBy('nama_lengkap')->get();
        $kategoriList = KategoriPelanggaran::aktif()->orderBy('nama')->get();

        return view('piket.pelanggaran.create', compact(
            'siswaList',
            'kategoriList',
            'guruAktifId', // null = belum check-in → view tampilkan banner peringatan
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        $validated['dicatat_oleh'] = Auth::id();

        Pelanggaran::create($validated);

        return redirect()
            ->route('piket.pelanggaran.index')
            ->with('success', 'Pelanggaran berhasil dicatat.');
    }

    // =========================================================================
    // SHOW
    // — Semua piket boleh lihat, tidak ada ownership check.
    // =========================================================================

    public function show(Pelanggaran $pelanggaran)
    {
        $pelanggaran->load(['siswa.kelas', 'kategori', 'dicatatOleh']);

        // Konsisten dengan AdminController: exclude dibatalkan & banding
        $totalPoinSiswa = Pelanggaran::where('siswa_id', $pelanggaran->siswa_id)
            ->whereNotIn('status', ['dibatalkan', 'banding'])
            ->sum('poin');

        // Riwayat lain milik siswa yang sama (limit 10, sama dengan Admin)
        $riwayatPelanggaran = Pelanggaran::where('siswa_id', $pelanggaran->siswa_id)
            ->where('id', '!=', $pelanggaran->id)
            ->with('kategori')
            ->latest('tanggal')
            ->limit(10)
            ->get();

        return view('piket.pelanggaran.show', compact(
            'pelanggaran',
            'totalPoinSiswa',
            'riwayatPelanggaran',
        ));
    }

    // =========================================================================
    // EDIT & UPDATE
    // — Hanya pencatat asli, hanya saat status masih 'pending'.
    // =========================================================================

    public function edit(Pelanggaran $pelanggaran)
    {
        $this->authorizeOwnership($pelanggaran);

        abort_unless(
            $pelanggaran->status === 'pending',
            403,
            'Pelanggaran yang sudah diproses tidak dapat diedit. Hubungi Admin.'
        );

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

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $this->authorizeOwnership($pelanggaran);

        abort_unless(
            $pelanggaran->status === 'pending',
            403,
            'Pelanggaran yang sudah diproses tidak dapat diedit. Hubungi Admin.'
        );

        $validated = $request->validate($this->rules(), $this->messages());

        $pelanggaran->update($validated);

        return redirect()
            ->route('piket.pelanggaran.show', $pelanggaran)
            ->with('success', 'Data pelanggaran berhasil diperbarui.');
    }

    // =========================================================================
    // SELESAIKAN
    // — Hanya pencatat asli, hanya saat pending | diproses.
    //   Selaras penuh dengan AdminController::selesaikan().
    // =========================================================================

    public function selesaikan(Request $request, Pelanggaran $pelanggaran)
    {
        $this->authorizeOwnership($pelanggaran);

        if (! in_array($pelanggaran->status, ['pending', 'diproses'])) {
            return back()->with(
                'error',
                'Pelanggaran tidak dapat diselesaikan karena statusnya sudah ' . $pelanggaran->status . '.'
            );
        }

        $request->validate(
            ['tindakan' => ['nullable', 'string', 'max:500']],
            ['tindakan.max' => 'Tindakan maksimal 500 karakter.']
        );

        $pelanggaran->selesaikan($request->tindakan ?? $pelanggaran->tindakan ?? '-');

        return back()->with('success', 'Pelanggaran berhasil diselesaikan.');
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    /**
     * Cek log piket aktif hari ini (sudah check-in, belum checkout).
     * Dipakai untuk konteks tampilan — bukan hard-block akses.
     */
    private function getLogAktif(int $userId): ?object
    {
        return LogPiket::where('pengguna_id', $userId)
            ->whereDate('tanggal', today())
            ->whereNotNull('masuk_pada')
            ->whereNull('keluar_pada')
            ->first();
    }

    /**
     * Hanya pencatat asli (dicatat_oleh) yang boleh mutasi data.
     * show() tidak melewati ini — semua piket boleh lihat.
     */
    private function authorizeOwnership(Pelanggaran $pelanggaran): void
    {
        abort_unless(
            $pelanggaran->dicatat_oleh === Auth::id(),
            403,
            'Anda tidak berhak mengubah pelanggaran ini.'
        );
    }

    /**
     * Validasi — diselaraskan penuh dengan AdminController.
     * Status dibatasi hanya STATUS_INPUT (pending | diproses).
     */
    private function rules(): array
    {
        return [
            'siswa_id'                => ['required', 'exists:siswa,id'],
            'kategori_pelanggaran_id' => ['required', 'exists:kategori_pelanggaran,id'],
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
            'poin.integer'                     => 'Poin harus berupa angka.',
            'poin.min'                         => 'Poin minimal 1.',
            'poin.max'                         => 'Poin maksimal 100.',
            'deskripsi.required'               => 'Deskripsi pelanggaran wajib diisi.',
            'deskripsi.max'                    => 'Deskripsi maksimal 1000 karakter.',
            'tanggal.required'                 => 'Tanggal wajib diisi.',
            'tanggal.date'                     => 'Format tanggal tidak valid.',
            'tanggal.before_or_equal'          => 'Tanggal tidak boleh melebihi hari ini.',
            'tindakan.max'                     => 'Tindakan maksimal 500 karakter.',
            'status.required'                  => 'Status wajib dipilih.',
            'status.in'                        => 'Status tidak valid. Pilih pending atau diproses.',
        ];
    }
}