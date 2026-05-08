<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JawabanSiswa;
// use App\Models\PilihanJawaban;
// use App\Models\SesiUjian;
use App\Models\SoalUjian;
use App\Models\Ujian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class SoalUjianController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX  —  Daftar soal satu ujian
    |--------------------------------------------------------------------------
    */
    public function index(Ujian $ujian)
    {
        $soal = $ujian->soal()
            ->with('pilihan')
            ->orderBy('nomor_soal')
            ->get();

        $stats = [
            'total_soal'  => $soal->count(),
            'total_bobot' => $soal->sum('bobot'),
            'pg'          => $soal->where('jenis_soal', 'pilihan_ganda')->count(),
            'essay'       => $soal->where('jenis_soal', 'essay')->count(),
            'benar_salah' => $soal->where('jenis_soal', 'benar_salah')->count(),
        ];

        return view('admin.ujian.soal.index', compact('ujian', 'soal', 'stats'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE  —  Form tambah soal baru
    |--------------------------------------------------------------------------
    */
    public function create(Ujian $ujian)
    {
        $nomorBerikutnya = $ujian->soal()->max('nomor_soal') + 1;

        return view('admin.ujian.soal.create', compact('ujian', 'nomorBerikutnya'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE  —  Simpan soal baru beserta pilihan jawaban
    |--------------------------------------------------------------------------
    */
    public function store(Request $request, Ujian $ujian)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        // Validasi tambahan: PG & benar_salah wajib ada minimal 1 jawaban benar
        if (in_array($validated['jenis_soal'], ['pilihan_ganda', 'benar_salah'])) {
            $this->validatePilihan($request, $validated['jenis_soal']);
        }

        DB::transaction(function () use ($request, $ujian, $validated) {

            if ($request->hasFile('gambar_soal')) {
                $validated['gambar_soal'] = $request->file('gambar_soal')
                    ->store('soal-ujian/gambar', 'public');
            }

            if (empty($validated['nomor_soal'])) {
                $validated['nomor_soal'] = $ujian->soal()->max('nomor_soal') + 1;
            }

            $soal = $ujian->soal()->create($validated);

            if (in_array($validated['jenis_soal'], ['pilihan_ganda', 'benar_salah'])) {
                $this->simpanPilihan($request, $soal);
            }
        });

        if ($request->boolean('tambah_lagi')) {
            return redirect()
                ->route('admin.ujian.soal.create', $ujian)
                ->with('success', 'Soal berhasil ditambahkan. Silakan tambah soal berikutnya.');
        }

        return redirect()
            ->route('admin.ujian.soal.index', $ujian)
            ->with('success', 'Soal berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW  —  Detail satu soal
    |--------------------------------------------------------------------------
    */
    public function show(Ujian $ujian, SoalUjian $soal)
    {
        $this->authorizeOwnership($ujian, $soal);
        $soal->load('pilihan');

        return view('admin.ujian.soal.show', compact('ujian', 'soal'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT  —  Form edit soal
    |--------------------------------------------------------------------------
    */
    public function edit(Ujian $ujian, SoalUjian $soal)
    {
        $this->authorizeOwnership($ujian, $soal);
        $soal->load('pilihan');

        return view('admin.ujian.soal.edit', compact('ujian', 'soal'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE  —  Perbarui soal + pilihan jawaban
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Ujian $ujian, SoalUjian $soal)
    {
        $this->authorizeOwnership($ujian, $soal);

        $validated = $request->validate($this->rules(), $this->messages());

        // Validasi tambahan: PG & benar_salah wajib ada minimal 1 jawaban benar
        if (in_array($validated['jenis_soal'], ['pilihan_ganda', 'benar_salah'])) {
            $this->validatePilihan($request, $validated['jenis_soal']);
        }

        DB::transaction(function () use ($request, $ujian, $soal, $validated) {

            if ($request->hasFile('gambar_soal')) {
                if ($soal->gambar_soal) {
                    Storage::disk('public')->delete($soal->gambar_soal);
                }
                $validated['gambar_soal'] = $request->file('gambar_soal')
                    ->store('soal-ujian/gambar', 'public');
            }

            if ($request->boolean('hapus_gambar') && $soal->gambar_soal) {
                Storage::disk('public')->delete($soal->gambar_soal);
                $validated['gambar_soal'] = null;
            }

            $soal->update($validated);

            if (in_array($validated['jenis_soal'], ['pilihan_ganda', 'benar_salah'])) {
                // Hapus pilihan lama + gambarnya, buat ulang
                $soal->pilihan()->each(function ($p) {
                    if ($p->gambar_pilihan) {
                        Storage::disk('public')->delete($p->gambar_pilihan);
                    }
                });
                $soal->pilihan()->delete();
                $this->simpanPilihan($request, $soal);
            } else {
                // Essay: hapus semua pilihan (jika ada sisa dari jenis sebelumnya)
                $soal->pilihan()->each(function ($p) {
                    if ($p->gambar_pilihan) {
                        Storage::disk('public')->delete($p->gambar_pilihan);
                    }
                });
                $soal->pilihan()->delete();
            }
        });

        return redirect()
            ->route('admin.ujian.soal.index', $ujian)
            ->with('success', 'Soal berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY  —  Hapus soal
    |--------------------------------------------------------------------------
    */
    public function destroy(Ujian $ujian, SoalUjian $soal)
    {
        $this->authorizeOwnership($ujian, $soal);

        if ($soal->gambar_soal) {
            Storage::disk('public')->delete($soal->gambar_soal);
        }

        $soal->pilihan()->each(function ($p) {
            if ($p->gambar_pilihan) {
                Storage::disk('public')->delete($p->gambar_pilihan);
            }
        });

        $soal->delete();
        $this->renumberSoal($ujian);

        return back()->with('success', 'Soal berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | REORDER  —  Ubah urutan soal via drag-drop (AJAX)
    |--------------------------------------------------------------------------
    | Request body: { "urutan": [id1, id2, id3, ...] }
    */
    public function reorder(Request $request, Ujian $ujian)
    {
        $request->validate([
            'urutan'   => ['required', 'array'],
            'urutan.*' => ['integer', 'exists:soal_ujian,id'],
        ]);

        DB::transaction(function () use ($request, $ujian) {
            foreach ($request->urutan as $index => $soalId) {
                SoalUjian::where('id', $soalId)
                    ->where('ujian_id', $ujian->id)
                    ->update(['nomor_soal' => $index + 1]);
            }
        });

        return response()->json(['message' => 'Urutan soal berhasil diperbarui.']);
    }

    /*
    |--------------------------------------------------------------------------
    | KOREKSI ESSAY  —  Admin/Guru mengoreksi jawaban essay siswa
    |--------------------------------------------------------------------------
    | GET  admin/ujian/{ujian}/soal/{soal}/koreksi-essay
    | POST admin/ujian/{ujian}/soal/{soal}/koreksi-essay
    */
    public function koreksiEssayIndex(Ujian $ujian, SoalUjian $soal)
    {
        $this->authorizeOwnership($ujian, $soal);

        abort_if($soal->jenis_soal !== 'essay', 404, 'Soal ini bukan tipe essay.');

        // Ambil semua jawaban essay untuk soal ini yang belum dikoreksi / sudah dikoreksi
        $jawabans = JawabanSiswa::with(['sesi.siswa'])
            ->where('soal_ujian_id', $soal->id)
            ->whereHas('sesi', fn($q) => $q->whereIn('status', ['selesai', 'habis_waktu']))
            ->orderByRaw("CASE WHEN poin_didapat IS NULL THEN 0 ELSE 1 END ASC") // belum dikoreksi dulu
            ->orderBy('created_at')
            ->get();

        $stats = [
            'total'         => $jawabans->count(),
            'sudah_koreksi' => $jawabans->whereNotNull('poin_didapat')->count(),
            'belum_koreksi' => $jawabans->whereNull('poin_didapat')->count(),
        ];

        return view('admin.ujian.soal.koreksi-essay', compact('ujian', 'soal', 'jawabans', 'stats'));
    }

    public function koreksiEssayStore(Request $request, Ujian $ujian, SoalUjian $soal, JawabanSiswa $jawaban)
    {
        $this->authorizeOwnership($ujian, $soal);

        abort_if($soal->jenis_soal !== 'essay', 404, 'Soal ini bukan tipe essay.');
        abort_if($jawaban->soal_ujian_id !== $soal->id, 404, 'Jawaban tidak sesuai soal ini.');

        $request->validate([
            'poin_didapat'    => ['required', 'numeric', 'min:0', 'max:' . $soal->bobot],
            'catatan_koreksi' => ['nullable', 'string', 'max:1000'],
        ], [
            'poin_didapat.required' => 'Poin wajib diisi.',
            'poin_didapat.min'      => 'Poin minimal 0.',
            'poin_didapat.max'      => "Poin maksimal {$soal->bobot} (sesuai bobot soal).",
        ]);

        $jawaban->koreksiEssay(
            (float) $request->poin_didapat,
            $request->catatan_koreksi
        );

        if ($request->expectsJson()) {
            return response()->json([
                'message'      => 'Koreksi berhasil disimpan.',
                'poin_didapat' => $jawaban->fresh()->poin_didapat,
                'adalah_benar' => $jawaban->fresh()->adalah_benar,
            ]);
        }

        return back()->with('success', 'Koreksi jawaban essay berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF
    |--------------------------------------------------------------------------
    */
    public function exportPdf(Ujian $ujian)
    {
        $soal = $ujian->soal()->with('pilihan')->orderBy('nomor_soal')->get();

        $pdf = Pdf::loadView('admin.ujian.soal.export-pdf', compact('ujian', 'soal'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('soal-ujian-' . $ujian->id . '-' . now()->format('YmdHis') . '.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */
    public function exportExcel(Ujian $ujian)
    {
        return Excel::download(
            new \App\Exports\SoalUjianExport($ujian),
            'soal-ujian-' . $ujian->id . '-' . now()->format('YmdHis') . '.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | IMPORT TEMPLATE
    |--------------------------------------------------------------------------
    */
    public function importTemplate(Ujian $ujian)
    {
        return Excel::download(
            new \App\Exports\SoalUjianTemplateExport(),
            'template-soal-ujian.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | IMPORT
    |--------------------------------------------------------------------------
    */
    public function import(Request $request, Ujian $ujian)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:5120'],
        ], [
            'file.required' => 'File impor wajib diunggah.',
            'file.mimes'    => 'Format file harus Excel (.xlsx / .xls).',
            'file.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        try {
            Excel::import(new \App\Imports\SoalUjianImport($ujian), $request->file('file'));
            return back()->with('success', 'Soal berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor soal: ' . $e->getMessage());
        }
    }

    /*
    |==========================================================================
    | PRIVATE HELPERS
    |==========================================================================
    */

    /**
     * Pastikan soal benar-benar milik ujian ybs.
     */
    private function authorizeOwnership(Ujian $ujian, SoalUjian $soal): void
    {
        abort_if($soal->ujian_id !== $ujian->id, 404, 'Soal tidak ditemukan untuk ujian ini.');
    }

    /**
     * Validasi pilihan jawaban:
     * - PG       : minimal 2 pilihan, tepat 1 jawaban benar
     * - benar_salah : tepat 2 pilihan (Benar & Salah), tepat 1 jawaban benar
     */
    private function validatePilihan(Request $request, string $jenisSoal): void
    {
        $pilihan = $request->input('pilihan', []);

        if (empty($pilihan)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'pilihan' => 'Pilihan jawaban wajib diisi untuk soal jenis ini.',
            ]);
        }

        $jumlahBenar = collect($pilihan)->filter(fn($p) => !empty($p['adalah_benar']))->count();

        if ($jumlahBenar < 1) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'pilihan' => 'Minimal satu pilihan jawaban harus ditandai sebagai benar.',
            ]);
        }

        if ($jenisSoal === 'pilihan_ganda' && $jumlahBenar > 1) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'pilihan' => 'Soal pilihan ganda hanya boleh memiliki satu jawaban benar.',
            ]);
        }

        if ($jenisSoal === 'pilihan_ganda' && count($pilihan) < 2) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'pilihan' => 'Soal pilihan ganda minimal memiliki 2 pilihan jawaban.',
            ]);
        }

        if ($jenisSoal === 'benar_salah' && count($pilihan) !== 2) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'pilihan' => 'Soal benar/salah harus memiliki tepat 2 pilihan (Benar dan Salah).',
            ]);
        }
    }

    /**
     * Simpan pilihan jawaban dari request ke soal.
     *
     * Ekspektasi field di request:
     *   pilihan[0][kode_pilihan]   = 'A'
     *   pilihan[0][teks_pilihan]   = 'Jawaban A'
     *   pilihan[0][gambar_pilihan] = <file|null>
     *   pilihan[0][adalah_benar]   = '1'|'0'
     */
    private function simpanPilihan(Request $request, SoalUjian $soal): void
    {
        $pilihanData = $request->input('pilihan', []);

        foreach ($pilihanData as $idx => $item) {
            $gambar = null;

            /** @var \Illuminate\Http\UploadedFile|null $file */
            $file = $request->file("pilihan.{$idx}.gambar_pilihan");

            if ($file && $file->isValid()) {
                $gambar = $file->store('soal-ujian/pilihan', 'public');
            }

            $soal->pilihan()->create([
                'kode_pilihan'   => strtoupper($item['kode_pilihan'] ?? ''),
                'teks_pilihan'   => $item['teks_pilihan'] ?? '',
                'gambar_pilihan' => $gambar,
                'adalah_benar'   => (bool) ($item['adalah_benar'] ?? false),
            ]);
        }
    }

    /**
     * Renumber nomor_soal dari 1 setelah ada yang dihapus.
     */
    private function renumberSoal(Ujian $ujian): void
    {
        $ujian->soal()
            ->orderBy('nomor_soal')
            ->get()
            ->each(function ($s, $i) {
                $s->update(['nomor_soal' => $i + 1]);
            });
    }

    /*
    |==========================================================================
    | VALIDATION
    |==========================================================================
    */
    private function rules(): array
    {
        return [
            'nomor_soal'   => ['nullable', 'integer', 'min:1'],
            'jenis_soal'   => ['required', Rule::in(['pilihan_ganda', 'essay', 'benar_salah'])],
            'pertanyaan'   => ['required', 'string'],
            'gambar_soal'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'bobot'        => ['required', 'integer', 'min:1', 'max:100'],
            'metadata'     => ['nullable', 'array'],

            // Pilihan jawaban (hanya relevan untuk PG & benar_salah)
            'pilihan'                      => ['nullable', 'array'],
            'pilihan.*.kode_pilihan'       => ['required_with:pilihan', 'string', 'max:5'],
            'pilihan.*.teks_pilihan'       => ['required_with:pilihan', 'string'],
            'pilihan.*.gambar_pilihan'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'pilihan.*.adalah_benar'       => ['nullable', 'boolean'],
        ];
    }

    private function messages(): array
    {
        return [
            'jenis_soal.required'                  => 'Jenis soal wajib dipilih.',
            'jenis_soal.in'                        => 'Jenis soal tidak valid.',
            'pertanyaan.required'                  => 'Pertanyaan wajib diisi.',
            'bobot.required'                       => 'Bobot soal wajib diisi.',
            'bobot.min'                            => 'Bobot minimal 1.',
            'bobot.max'                            => 'Bobot maksimal 100.',
            'gambar_soal.image'                    => 'File gambar soal harus berupa gambar.',
            'gambar_soal.max'                      => 'Ukuran gambar soal maksimal 2MB.',
            'pilihan.*.kode_pilihan.required_with' => 'Kode pilihan wajib diisi.',
            'pilihan.*.teks_pilihan.required_with' => 'Teks pilihan jawaban wajib diisi.',
            'pilihan.*.gambar_pilihan.image'        => 'File gambar pilihan harus berupa gambar.',
            'pilihan.*.gambar_pilihan.max'          => 'Ukuran gambar pilihan maksimal 1MB.',
        ];
    }
}