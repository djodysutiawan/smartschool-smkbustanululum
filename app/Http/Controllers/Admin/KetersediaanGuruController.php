<?php

namespace App\Http\Controllers\Admin;

use App\Exports\KetersediaanGuruExport;
use App\Http\Controllers\Controller;
use App\Imports\KetersediaanGuruImport;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\KetersediaanGuru;
use App\Models\MataPelajaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;

class KetersediaanGuruController extends Controller
{
    private const HARI_OPTIONS = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

    // ── INDEX ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = KetersediaanGuru::with(['guru', 'mataPelajaran', 'jurusan']);

        if ($request->filled('guru_id'))           $query->where('guru_id', $request->guru_id);
        if ($request->filled('hari'))              $query->where('hari', $request->hari);
        if ($request->filled('tersedia'))          $query->where('tersedia', $request->boolean('tersedia'));
        if ($request->filled('mata_pelajaran_id')) $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        if ($request->filled('jurusan_id'))        $query->where('jurusan_id', $request->jurusan_id);

        $ketersediaan = $query
            ->orderBy('guru_id')
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->paginate(25)
            ->withQueryString();

        $gurus    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $mapels   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $jurusans = Jurusan::where('is_published', true)->orderBy('urutan')->get();
        $hariList = self::HARI_OPTIONS;

        return view('admin.ketersediaan-guru.index',
            compact('ketersediaan', 'gurus', 'mapels', 'jurusans', 'hariList'));
    }

    // ── SHOW BY GURU ──────────────────────────────────────────────────────────

    public function showByGuru(Guru $guru)
    {
        $ketersediaan = $guru->ketersediaan()
            ->with(['mataPelajaran', 'jurusan'])
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        $mapelDiampu = $guru->mataPelajaran()
            ->where('guru_mata_pelajaran.is_active', true)
            ->with('jurusan')
            ->get();

        $jadwalAktif = $guru->jadwalPelajaran()
            ->aktif()
            ->whereHas('tahunAjaran', fn($q) => $q->where('status', 'aktif'))
            ->with(['mataPelajaran', 'kelas.jurusan', 'ruang'])
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        $semuaMapel   = MataPelajaran::aktif()->orderBy('nama_mapel')->get();
        $semuaJurusan = Jurusan::where('is_published', true)->orderBy('urutan')->get();
        $hariList     = self::HARI_OPTIONS;

        return view('admin.ketersediaan-guru.by-guru', compact(
            'guru', 'ketersediaan', 'hariList',
            'mapelDiampu', 'jadwalAktif',
            'semuaMapel', 'semuaJurusan'
        ));
    }

    // ── CREATE & STORE ────────────────────────────────────────────────────────

    /**
     * FIX: Tambahkan $guruTerpilih dari query string agar dropdown guru
     * otomatis terpilih saat form dibuka via ?guru_id=X dari halaman by-guru.
     */
    public function create(Request $request)
    {
        $gurus    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $jurusans = Jurusan::where('is_published', true)->orderBy('urutan')->get();
        $hariList = self::HARI_OPTIONS;

        // FIX: Resolve $guruTerpilih dari query string supaya view bisa pre-select
        $guruTerpilih = $request->filled('guru_id')
            ? Guru::find($request->guru_id)
            : null;

        $oldJurusanId = old('jurusan_id');
        $mapels = $oldJurusanId
            ? $this->getMapelByJurusan((int) $oldJurusanId)
            : MataPelajaran::aktif()->orderBy('nama_mapel')->get(['id', 'nama_mapel', 'scope']);

        return view('admin.ketersediaan-guru.create',
            compact('gurus', 'mapels', 'jurusans', 'hariList', 'guruTerpilih'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id'           => ['required', 'exists:guru,id'],
            'jurusan_id'        => ['nullable', 'exists:jurusan,id'],
            'mata_pelajaran_id' => ['nullable', 'exists:mata_pelajaran,id'],
            'hari'              => ['required', Rule::in(self::HARI_OPTIONS)],
            'jam_mulai'         => ['required', 'date_format:H:i'],
            'jam_selesai'       => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'tersedia'          => ['boolean'],
            'catatan'           => ['nullable', 'string', 'max:255'],
            'berlaku_mulai'     => ['nullable', 'date'],
            'berlaku_selesai'   => ['nullable', 'date', 'after_or_equal:berlaku_mulai'],
        ], $this->pesanValidasi());

        $exists = KetersediaanGuru::where('guru_id', $validated['guru_id'])
            ->where('hari', $validated['hari'])
            ->where('jam_mulai', $validated['jam_mulai'])
            ->where('mata_pelajaran_id', $validated['mata_pelajaran_id'] ?? null)
            ->where('jurusan_id', $validated['jurusan_id'] ?? null)
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->with('error', 'Slot ketersediaan dengan kombinasi guru, hari, jam, mapel, dan jurusan tersebut sudah ada.');
        }

        KetersediaanGuru::create($validated);

        if ($request->filled('redirect_guru')) {
            return redirect()->route('admin.ketersediaan-guru.by-guru', $validated['guru_id'])
                ->with('success', 'Slot ketersediaan berhasil ditambahkan.');
        }

        return redirect()->route('admin.ketersediaan-guru.index')
            ->with('success', 'Slot ketersediaan berhasil ditambahkan.');
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    public function show(KetersediaanGuru $ketersediaanGuru)
    {
        $ketersediaanGuru->load(['guru', 'mataPelajaran', 'jurusan']);
        return view('admin.ketersediaan-guru.show', compact('ketersediaanGuru'));
    }

    // ── EDIT & UPDATE ─────────────────────────────────────────────────────────

    public function edit(KetersediaanGuru $ketersediaanGuru)
    {
        $ketersediaan = $ketersediaanGuru->load(['guru', 'mataPelajaran', 'jurusan']);
        $gurus        = Guru::aktif()->orderBy('nama_lengkap')->get();
        $jurusans     = Jurusan::where('is_published', true)->orderBy('urutan')->get();
        $hariList     = self::HARI_OPTIONS;

        $currentJurusanId = old('jurusan_id', $ketersediaan->jurusan_id);
        $mapels = $currentJurusanId
            ? $this->getMapelByJurusan((int) $currentJurusanId)
            : MataPelajaran::aktif()->orderBy('nama_mapel')->get(['id', 'nama_mapel', 'scope']);

        return view('admin.ketersediaan-guru.edit',
            compact('ketersediaan', 'gurus', 'mapels', 'jurusans', 'hariList'));
    }

    public function update(Request $request, KetersediaanGuru $ketersediaanGuru)
    {
        $validated = $request->validate([
            'guru_id'           => ['required', 'exists:guru,id'],
            'jurusan_id'        => ['nullable', 'exists:jurusan,id'],
            'mata_pelajaran_id' => ['nullable', 'exists:mata_pelajaran,id'],
            'hari'              => ['required', Rule::in(self::HARI_OPTIONS)],
            'jam_mulai'         => ['required', 'date_format:H:i'],
            'jam_selesai'       => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'tersedia'          => ['boolean'],
            'catatan'           => ['nullable', 'string', 'max:255'],
            'berlaku_mulai'     => ['nullable', 'date'],
            'berlaku_selesai'   => ['nullable', 'date', 'after_or_equal:berlaku_mulai'],
        ], $this->pesanValidasi());

        $exists = KetersediaanGuru::where('guru_id', $validated['guru_id'])
            ->where('hari', $validated['hari'])
            ->where('jam_mulai', $validated['jam_mulai'])
            ->where('mata_pelajaran_id', $validated['mata_pelajaran_id'] ?? null)
            ->where('jurusan_id', $validated['jurusan_id'] ?? null)
            ->where('id', '!=', $ketersediaanGuru->id)
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->with('error', 'Slot ketersediaan dengan kombinasi tersebut sudah ada.');
        }

        $ketersediaanGuru->update($validated);

        return redirect()->route('admin.ketersediaan-guru.show', $ketersediaanGuru)
            ->with('success', 'Slot ketersediaan berhasil diperbarui.');
    }

    // ── DESTROY ───────────────────────────────────────────────────────────────

    public function destroy(KetersediaanGuru $ketersediaanGuru)
    {
        $ketersediaanGuru->delete();
        return back()->with('success', 'Slot ketersediaan berhasil dihapus.');
    }

    // ── BULK STORE ────────────────────────────────────────────────────────────

    public function bulkStore(Request $request, Guru $guru)
    {
        $request->validate([
            'slots'                       => ['required', 'array', 'min:1'],
            'slots.*.hari'                => ['required', Rule::in(self::HARI_OPTIONS)],
            'slots.*.jam_mulai'           => ['required', 'date_format:H:i'],
            'slots.*.jam_selesai'         => ['required', 'date_format:H:i'],
            'slots.*.tersedia'            => ['boolean'],
            'slots.*.mata_pelajaran_id'   => ['nullable', 'exists:mata_pelajaran,id'],
            'slots.*.jurusan_id'          => ['nullable', 'exists:jurusan,id'],
            'slots.*.catatan'             => ['nullable', 'string', 'max:255'],
            'slots.*.berlaku_mulai'       => ['nullable', 'date'],
            'slots.*.berlaku_selesai'     => ['nullable', 'date'],
        ], [
            'slots.required'               => 'Minimal tambahkan 1 slot.',
            'slots.min'                    => 'Minimal tambahkan 1 slot.',
            'slots.*.hari.required'        => 'Hari wajib dipilih di setiap baris.',
            'slots.*.jam_mulai.required'   => 'Jam mulai wajib diisi di setiap baris.',
            'slots.*.jam_selesai.required' => 'Jam selesai wajib diisi di setiap baris.',
        ]);

        // Validasi jam_selesai > jam_mulai dan range berlaku SEBELUM hapus data lama
        foreach ($request->slots as $index => $slot) {
            if (strtotime($slot['jam_selesai']) <= strtotime($slot['jam_mulai'])) {
                return back()->withInput()
                    ->with('error', 'Jam selesai pada baris ke-' . ($index + 1) . ' harus setelah jam mulai.');
            }
            if (
                ! empty($slot['berlaku_mulai']) &&
                ! empty($slot['berlaku_selesai']) &&
                strtotime($slot['berlaku_selesai']) < strtotime($slot['berlaku_mulai'])
            ) {
                return back()->withInput()
                    ->with('error', 'Tanggal berlaku selesai pada baris ke-' . ($index + 1) . ' harus setelah tanggal mulai.');
            }
        }

        $now = now();
        $records = array_map(fn($slot) => [
            'guru_id'           => $guru->id,
            'mata_pelajaran_id' => $slot['mata_pelajaran_id'] ?? null,
            'jurusan_id'        => $slot['jurusan_id'] ?? null,
            'hari'              => $slot['hari'],
            'jam_mulai'         => $slot['jam_mulai'],
            'jam_selesai'       => $slot['jam_selesai'],
            'tersedia'          => isset($slot['tersedia']) ? (bool) $slot['tersedia'] : true,
            'catatan'           => $slot['catatan'] ?? null,
            'berlaku_mulai'     => $slot['berlaku_mulai'] ?? null,
            'berlaku_selesai'   => $slot['berlaku_selesai'] ?? null,
            'created_at'        => $now,
            'updated_at'        => $now,
        ], $request->slots);

        DB::transaction(function () use ($guru, $records) {
            $guru->ketersediaan()->delete();
            KetersediaanGuru::insert($records);
        });

        return back()->with('success', 'Ketersediaan guru berhasil disimpan (' . count($records) . ' slot).');
    }

    // ── TOGGLE ────────────────────────────────────────────────────────────────

    public function toggle(KetersediaanGuru $ketersediaanGuru)
    {
        $ketersediaanGuru->update(['tersedia' => ! $ketersediaanGuru->tersedia]);
        $status = $ketersediaanGuru->tersedia ? 'tersedia' : 'tidak tersedia';
        return back()->with('success', "Slot berhasil diubah menjadi {$status}.");
    }

    // ── SYNC MAPEL GURU ───────────────────────────────────────────────────────

    public function syncMapel(Request $request, Guru $guru)
    {
        $request->validate([
            'mapel'                     => ['nullable', 'array'],
            'mapel.*.mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'mapel.*.jurusan_id'        => ['nullable', 'exists:jurusan,id'],
            'mapel.*.is_mapel_utama'    => ['boolean'],
            'mapel.*.jam_per_minggu'    => ['nullable', 'integer', 'min:1', 'max:40'],
        ]);

        $syncData = [];
        foreach ($request->input('mapel', []) as $item) {
            $syncData[$item['mata_pelajaran_id']] = [
                'jurusan_id'     => $item['jurusan_id'] ?? null,
                'jam_per_minggu' => $item['jam_per_minggu'] ?? null,
                'is_mapel_utama' => isset($item['is_mapel_utama']) ? (bool) $item['is_mapel_utama'] : false,
                'is_active'      => true,
            ];
        }

        $guru->mataPelajaran()->sync($syncData);

        return back()->with('success', 'Daftar mata pelajaran yang diampu berhasil diperbarui.');
    }

    // ── AJAX: MAPEL BY JURUSAN ────────────────────────────────────────────────

    /**
     * FIX: Method ini sekarang menangani DUA route:
     *  1. /ajax/mapel-by-jurusan/{jurusan}  → mapel spesifik jurusan
     *  2. /ajax/mapel-all                   → semua mapel (jurusan = null)
     * Parameter $jurusan bersifat nullable sehingga bisa dipanggil tanpa parameter.
     */
    public function mapelByJurusan(?Jurusan $jurusan = null)
    {
        $query = MataPelajaran::aktif()->orderBy('nama_mapel');

        if ($jurusan) {
            $query->where(function ($q) use ($jurusan) {
                $q->where('scope', 'umum')
                  ->orWhere(function ($q2) use ($jurusan) {
                      $q2->where('scope', 'jurusan')
                         ->whereHas('jurusan', function ($q3) use ($jurusan) {
                             $q3->where('jurusan.id', $jurusan->id)
                                ->where('jurusan_mata_pelajaran.is_active', true);
                         });
                  });
            });
        }

        $mapels = $query->get(['id', 'nama_mapel', 'scope']);

        return response()->json([
            'mapels' => $mapels->map(fn($m) => [
                'id'    => $m->id,
                'label' => $m->nama_mapel . ($m->scope === 'umum' ? ' ✦' : ''),
                'scope' => $m->scope,
            ]),
        ]);
    }

    // ── EXPORT PDF ────────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $query = KetersediaanGuru::with(['guru', 'mataPelajaran', 'jurusan']);

        if ($request->filled('guru_id'))  $query->where('guru_id', $request->guru_id);
        if ($request->filled('hari'))     $query->where('hari', $request->hari);
        if ($request->filled('tersedia')) $query->where('tersedia', $request->boolean('tersedia'));

        $ketersediaan = $query
            ->orderBy('guru_id')
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get();

        $filterGuru = $request->filled('guru_id')
            ? optional(Guru::find($request->guru_id))->nama_lengkap
            : null;

        $pdf = Pdf::loadView('admin.ketersediaan-guru.pdf', compact('ketersediaan', 'filterGuru'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('data-ketersediaan-guru-' . now()->format('Ymd-His') . '.pdf');
    }

    // ── EXPORT EXCEL ──────────────────────────────────────────────────────────

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new KetersediaanGuruExport($request->guru_id),
            'ketersediaan-guru-' . now()->format('Ymd-His') . '.xlsx'
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
            Excel::import(new KetersediaanGuruImport, $request->file('file'));
        } catch (ExcelValidationException $e) {
            $errors = collect($e->failures())->map(
                fn($f) => "Baris {$f->row()}: " . implode(', ', $f->errors())
            )->implode(' | ');
            return back()->with('error', 'Import gagal: ' . $errors);
        } catch (\Throwable $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }

        return back()->with('success', 'Data ketersediaan guru berhasil diimpor.');
    }

    // ── PRIVATE HELPERS ───────────────────────────────────────────────────────

    private function getMapelByJurusan(int $jurusanId)
    {
        return MataPelajaran::aktif()
            ->where(function ($q) use ($jurusanId) {
                $q->where('scope', 'umum')
                  ->orWhere(function ($q2) use ($jurusanId) {
                      $q2->where('scope', 'jurusan')
                         ->whereHas('jurusan', function ($q3) use ($jurusanId) {
                             $q3->where('jurusan.id', $jurusanId)
                                ->where('jurusan_mata_pelajaran.is_active', true);
                         });
                  });
            })
            ->orderBy('nama_mapel')
            ->get(['id', 'nama_mapel', 'scope']);
    }

    private function pesanValidasi(): array
    {
        return [
            'guru_id.required'               => 'Guru wajib dipilih.',
            'guru_id.exists'                 => 'Guru yang dipilih tidak ditemukan.',
            'jurusan_id.exists'              => 'Jurusan tidak ditemukan.',
            'mata_pelajaran_id.exists'       => 'Mata pelajaran tidak ditemukan.',
            'hari.required'                  => 'Hari wajib dipilih.',
            'hari.in'                        => 'Hari yang dipilih tidak valid.',
            'jam_mulai.required'             => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format'          => 'Format jam mulai tidak valid (HH:MM).',
            'jam_selesai.required'           => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format'        => 'Format jam selesai tidak valid (HH:MM).',
            'jam_selesai.after'              => 'Jam selesai harus setelah jam mulai.',
            'catatan.max'                    => 'Catatan maksimal 255 karakter.',
            'berlaku_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
        ];
    }
}