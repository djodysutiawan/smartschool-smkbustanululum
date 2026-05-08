<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CascadeDropdownTrait;
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\JurnalMengajar;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JurnalMengajarExport;
use App\Imports\JurnalMengajarImport;
use Illuminate\Support\Facades\Auth;

class JurnalMengajarController extends Controller
{
    use CascadeDropdownTrait;

    // ─────────────────────────────────────────────────────────────────────────
    // INDEX
    // ─────────────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = JurnalMengajar::with(['guru', 'kelas', 'mataPelajaran', 'jadwalPelajaran']);

        if ($request->filled('guru_id'))           $query->where('guru_id', $request->guru_id);
        if ($request->filled('kelas_id'))          $query->where('kelas_id', $request->kelas_id);
        if ($request->filled('mata_pelajaran_id')) $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        if ($request->filled('tanggal_dari'))      $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai'))    $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        if ($request->filled('terverifikasi')) {
            if ($request->boolean('terverifikasi')) {
                $query->sudahDiverifikasi();
            } else {
                $query->belumDiverifikasi();
            }
        }

        $jurnal    = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();
        $guruList  = Guru::aktif()->orderBy('nama_lengkap')->get();
        $kelasList = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList = MataPelajaran::aktif()->orderBy('nama_mapel')->get();

        return view('admin.jurnal_mengajar.index',
            compact('jurnal', 'guruList', 'kelasList', 'mapelList'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // CREATE
    // ─────────────────────────────────────────────────────────────────────────

    public function create()
    {
        $guruList   = Guru::aktif()->orderBy('nama_lengkap')->get();
        $kelasList  = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList  = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $jadwalList = JadwalPelajaran::aktif()->with(['kelas', 'mataPelajaran'])->get();
        $metodeList = $this->metodeList();

        return view('admin.jurnal_mengajar.create',
            compact('guruList', 'kelasList', 'mapelList', 'jadwalList', 'metodeList'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // STORE
    // ─────────────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        JurnalMengajar::create($validated);

        return redirect()->route('admin.jurnal-mengajar.index')
            ->with('success', 'Jurnal mengajar berhasil ditambahkan.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // SHOW
    // ─────────────────────────────────────────────────────────────────────────

    public function show(JurnalMengajar $jurnalMengajar)
    {
        $jurnalMengajar->load(['guru', 'kelas', 'mataPelajaran', 'jadwalPelajaran', 'diverifikasiOleh']);

        return view('admin.jurnal_mengajar.show', compact('jurnalMengajar'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // EDIT
    // ─────────────────────────────────────────────────────────────────────────

    public function edit(JurnalMengajar $jurnalMengajar)
    {
        $guruList   = Guru::aktif()->orderBy('nama_lengkap')->get();
        $kelasList  = Kelas::aktif()->orderBy('nama_kelas')->get();
        $mapelList  = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $jadwalList = JadwalPelajaran::aktif()->with(['kelas', 'mataPelajaran'])->get();
        $metodeList = $this->metodeList();

        // Pre-populate cascade dropdown
        $mapelGuru = $this->getMapelByGuru($jurnalMengajar->guru_id);
        $kelasGuru = $this->getKelasByGuru($jurnalMengajar->guru_id);

        return view('admin.jurnal_mengajar.edit',
            compact('jurnalMengajar', 'guruList', 'kelasList', 'mapelList',
                    'jadwalList', 'metodeList', 'mapelGuru', 'kelasGuru'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // UPDATE
    // ─────────────────────────────────────────────────────────────────────────

    public function update(Request $request, JurnalMengajar $jurnalMengajar)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        $jurnalMengajar->update($validated);

        return redirect()->route('admin.jurnal-mengajar.show', $jurnalMengajar)
            ->with('success', 'Jurnal mengajar berhasil diperbarui.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // DESTROY
    // ─────────────────────────────────────────────────────────────────────────

    public function destroy(JurnalMengajar $jurnalMengajar)
    {
        $jurnalMengajar->delete();

        return redirect()->route('admin.jurnal-mengajar.index')
            ->with('success', 'Jurnal mengajar berhasil dihapus.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // RESTORE (SoftDeletes)
    // ─────────────────────────────────────────────────────────────────────────

    public function restore(int $id)
    {
        JurnalMengajar::onlyTrashed()->findOrFail($id)->restore();

        return back()->with('success', 'Jurnal mengajar berhasil dipulihkan.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // VERIFIKASI
    // FIX: Hapus Schema::hasColumn() per-request (sangat lambat di production).
    // Kolom diverifikasi_oleh & diverifikasi_pada sudah ada di $fillable model.
    // ─────────────────────────────────────────────────────────────────────────

    public function verifikasi(JurnalMengajar $jurnalMengajar)
    {
        if ($jurnalMengajar->sudah_diverifikasi) {
            return back()->with('error', 'Jurnal ini sudah diverifikasi sebelumnya.');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $jurnalMengajar->update([
            'diverifikasi_oleh' => $user->id,
            'diverifikasi_pada' => now(),
        ]);

        return back()->with('success', 'Jurnal mengajar berhasil diverifikasi.');
    }

    /**
     * Batalkan verifikasi (hanya admin).
     */
    public function batalVerifikasi(JurnalMengajar $jurnalMengajar)
    {
        if (! $jurnalMengajar->sudah_diverifikasi) {
            return back()->with('error', 'Jurnal ini belum diverifikasi.');
        }

        $jurnalMengajar->update([
            'diverifikasi_oleh' => null,
            'diverifikasi_pada' => null,
        ]);

        return back()->with('success', 'Verifikasi jurnal berhasil dibatalkan.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // AJAX — Cascade Dropdown
    // ─────────────────────────────────────────────────────────────────────────

    public function ajaxMapelByGuru(Guru $guru)
    {
        return response()->json($this->getMapelByGuru($guru->id));
    }

    public function ajaxKelasByGuru(Guru $guru)
    {
        return response()->json($this->getKelasByGuru($guru->id));
    }

    /**
     * GET /admin/jurnal-mengajar/ajax/jadwal-by-guru/{guru}
     * Kembalikan jadwal pelajaran aktif milik guru ini untuk cascade form.
     */
    public function ajaxJadwalByGuru(Guru $guru)
    {
        $jadwal = JadwalPelajaran::aktif()
            ->where('guru_id', $guru->id)
            ->with(['kelas', 'mataPelajaran'])
            ->get()
            ->map(fn($j) => [
                'id'          => $j->id,
                'label'       => $j->label,
                'kelas_id'    => $j->kelas_id,
                'mapel_id'    => $j->mata_pelajaran_id,
                'kelas_nama'  => $j->kelas?->nama_kelas,
                'mapel_nama'  => $j->mataPelajaran?->nama_mapel,
            ]);

        return response()->json($jadwal);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // EXPORT / IMPORT
    // ─────────────────────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $query = JurnalMengajar::with(['guru', 'kelas', 'mataPelajaran']);

        if ($request->filled('guru_id'))        $query->where('guru_id', $request->guru_id);
        if ($request->filled('tanggal_dari'))   $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai')) $query->whereDate('tanggal', '<=', $request->tanggal_sampai);

        $jurnal = $query->orderByDesc('tanggal')->get();

        $pdf = Pdf::loadView('admin.jurnal_mengajar.export-pdf', compact('jurnal'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('jurnal-mengajar-' . now()->format('YmdHis') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new JurnalMengajarExport($request->all()),
            'jurnal-mengajar-' . now()->format('YmdHis') . '.xlsx'
        );
    }

    public function importTemplate()
    {
        return Excel::download(
            new \App\Exports\JurnalMengajarTemplateExport(),
            'template-jurnal-mengajar.xlsx'
        );
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:5120'],
        ], [
            'file.required' => 'File impor wajib diunggah.',
            'file.mimes'    => 'Format file harus berupa Excel (.xlsx atau .xls).',
            'file.max'      => 'Ukuran file tidak boleh lebih dari 5MB.',
        ]);

        try {
            Excel::import(new JurnalMengajarImport(), $request->file('file'));
            return back()->with('success', 'Data jurnal mengajar berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PRIVATE HELPERS
    // ─────────────────────────────────────────────────────────────────────────

    private function metodeList(): array
    {
        return ['ceramah', 'diskusi', 'praktikum', 'demonstrasi', 'proyek', 'lainnya'];
    }

    private function rules(): array
    {
        return [
            'guru_id'             => ['required', 'exists:guru,id'],
            'kelas_id'            => ['required', 'exists:kelas,id'],
            'mata_pelajaran_id'   => ['required', 'exists:mata_pelajaran,id'],
            'jadwal_pelajaran_id' => ['nullable', 'exists:jadwal_pelajaran,id'],
            'tanggal'             => ['required', 'date', 'before_or_equal:today'],
            'pertemuan_ke'        => ['nullable', 'integer', 'min:1', 'max:52'],
            'materi_ajar'         => ['required', 'string', 'max:2000'],
            'metode_pembelajaran' => ['nullable', 'string', 'max:100'],
            'jumlah_hadir'        => ['nullable', 'integer', 'min:0'],
            'jumlah_tidak_hadir'  => ['nullable', 'integer', 'min:0'],
            'catatan_kelas'       => ['nullable', 'string', 'max:2000'],
        ];
    }

    private function messages(): array
    {
        return [
            'guru_id.required'           => 'Guru wajib dipilih.',
            'guru_id.exists'             => 'Guru yang dipilih tidak valid.',
            'kelas_id.required'          => 'Kelas wajib dipilih.',
            'kelas_id.exists'            => 'Kelas yang dipilih tidak valid.',
            'mata_pelajaran_id.required' => 'Mata pelajaran wajib dipilih.',
            'mata_pelajaran_id.exists'   => 'Mata pelajaran yang dipilih tidak valid.',
            'jadwal_pelajaran_id.exists' => 'Jadwal pelajaran yang dipilih tidak valid.',
            'tanggal.required'           => 'Tanggal jurnal wajib diisi.',
            'tanggal.date'               => 'Format tanggal tidak valid.',
            'tanggal.before_or_equal'    => 'Tanggal jurnal tidak boleh lebih dari hari ini.',
            'pertemuan_ke.integer'       => 'Pertemuan ke harus berupa angka.',
            'pertemuan_ke.min'           => 'Pertemuan ke minimal 1.',
            'pertemuan_ke.max'           => 'Pertemuan ke maksimal 52.',
            'materi_ajar.required'       => 'Materi ajar wajib diisi.',
            'materi_ajar.max'            => 'Materi ajar maksimal 2000 karakter.',
            'jumlah_hadir.integer'       => 'Jumlah hadir harus berupa angka.',
            'jumlah_hadir.min'           => 'Jumlah hadir tidak boleh negatif.',
            'jumlah_tidak_hadir.integer' => 'Jumlah tidak hadir harus berupa angka.',
            'jumlah_tidak_hadir.min'     => 'Jumlah tidak hadir tidak boleh negatif.',
            'catatan_kelas.max'          => 'Catatan kelas maksimal 2000 karakter.',
        ];
    }
}