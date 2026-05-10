<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JawabanSiswa;
use App\Models\PilihanJawaban;
use App\Models\SoalUjian;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SoalUjianController extends Controller
{
    // ── Auth Helper ───────────────────────────────────────────────────────────

    private function getGuruId(): int
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru->id;
    }

    /**
     * Pastikan ujian milik guru yang sedang login.
     */
    private function authorizeUjian(Ujian $ujian): void
    {
        abort_if($ujian->guru_id !== $this->getGuruId(), 403, 'Anda tidak memiliki akses ke ujian ini.');
    }

    // ── Index ─────────────────────────────────────────────────────────────────

    public function index(Ujian $ujian)
    {
        $this->authorizeUjian($ujian);

        $ujian->load(['mataPelajaran', 'kelas', 'tahunAjaran']);

        $soalList = $ujian->soal()->with('pilihan')->get();

        $stats = [
            'total_soal'    => $soalList->count(),
            'total_bobot'   => $soalList->sum('bobot'),
            'pg_count'      => $soalList->where('jenis_soal', 'pilihan_ganda')->count(),
            'bs_count'      => $soalList->where('jenis_soal', 'benar_salah')->count(),
            'essay_count'   => $soalList->where('jenis_soal', 'essay')->count(),
            'ada_jawaban'   => $ujian->sesi()->whereIn('status', ['selesai', 'habis_waktu'])->exists(),
        ];

        return view('guru.ujian.soal.index', compact('ujian', 'soalList', 'stats'));
    }

    // ── Create ────────────────────────────────────────────────────────────────

    public function create(Ujian $ujian)
    {
        $this->authorizeUjian($ujian);

        $nomorBerikutnya = ($ujian->soal()->max('nomor_soal') ?? 0) + 1;

        return view('guru.ujian.soal.create', compact('ujian', 'nomorBerikutnya'));
    }

    // ── Store ─────────────────────────────────────────────────────────────────

    public function store(Request $request, Ujian $ujian)
    {
        $this->authorizeUjian($ujian);

        $validated = $request->validate($this->rulesStore(), $this->messages());

        // Pastikan nomor soal unik dalam ujian ini
        $nomorSoal = $validated['nomor_soal']
            ?? (($ujian->soal()->max('nomor_soal') ?? 0) + 1);

        // Validasi pilihan untuk PG & Benar/Salah
        if (in_array($validated['jenis_soal'], ['pilihan_ganda', 'benar_salah'])) {
            $this->validatePilihan($request);
        }

        DB::transaction(function () use ($request, $ujian, $validated, $nomorSoal) {
            // Upload gambar soal
            $gambarPath = null;
            if ($request->hasFile('gambar_soal')) {
                $gambarPath = $request->file('gambar_soal')
                    ->store('soal_ujian', 'public');
            }

            $soal = SoalUjian::create([
                'ujian_id'    => $ujian->id,
                'nomor_soal'  => $nomorSoal,
                'jenis_soal'  => $validated['jenis_soal'],
                'pertanyaan'  => $validated['pertanyaan'],
                'gambar_soal' => $gambarPath,
                'bobot'       => $validated['bobot'],
                'metadata'    => null,
            ]);

            // Simpan pilihan jawaban (bukan essay)
            if (in_array($validated['jenis_soal'], ['pilihan_ganda', 'benar_salah'])) {
                $this->storePilihan($request, $soal);
            }
        });

        if ($request->boolean('tambah_lagi')) {
            return redirect()
                ->route('guru.ujian.soal.create', $ujian)
                ->with('success', 'Soal berhasil ditambahkan. Silakan tambah soal berikutnya.');
        }

        return redirect()
            ->route('guru.ujian.soal.index', $ujian)
            ->with('success', 'Soal berhasil ditambahkan.');
    }

    // ── Show ──────────────────────────────────────────────────────────────────

    public function show(Ujian $ujian, SoalUjian $soal)
    {
        $this->authorizeUjian($ujian);
        abort_if($soal->ujian_id !== $ujian->id, 404);

        $soal->load('pilihan');

        return view('guru.ujian.soal.show', compact('ujian', 'soal'));
    }

    // ── Edit ──────────────────────────────────────────────────────────────────

    public function edit(Ujian $ujian, SoalUjian $soal)
    {
        $this->authorizeUjian($ujian);
        abort_if($soal->ujian_id !== $ujian->id, 404);

        $soal->load('pilihan');

        // Cek apakah sudah ada jawaban siswa — tampilkan warning
        $adaJawaban = JawabanSiswa::where('soal_ujian_id', $soal->id)->exists();

        return view('guru.ujian.soal.edit', compact('ujian', 'soal', 'adaJawaban'));
    }

    // ── Update ────────────────────────────────────────────────────────────────

    public function update(Request $request, Ujian $ujian, SoalUjian $soal)
    {
        $this->authorizeUjian($ujian);
        abort_if($soal->ujian_id !== $ujian->id, 404);

        $validated = $request->validate($this->rulesUpdate($soal), $this->messages());

        if (in_array($validated['jenis_soal'], ['pilihan_ganda', 'benar_salah'])) {
            $this->validatePilihan($request);
        }

        DB::transaction(function () use ($request, $soal, $validated) {
            // Handle gambar soal
            $gambarPath = $soal->gambar_soal;

            if ($request->boolean('hapus_gambar')) {
                if ($gambarPath) {
                    Storage::disk('public')->delete($gambarPath);
                }
                $gambarPath = null;
            }

            if ($request->hasFile('gambar_soal')) {
                // Hapus gambar lama
                if ($gambarPath) {
                    Storage::disk('public')->delete($gambarPath);
                }
                $gambarPath = $request->file('gambar_soal')
                    ->store('soal_ujian', 'public');
            }

            $soal->update([
                'nomor_soal'  => $validated['nomor_soal'],
                'jenis_soal'  => $validated['jenis_soal'],
                'pertanyaan'  => $validated['pertanyaan'],
                'gambar_soal' => $gambarPath,
                'bobot'       => $validated['bobot'],
            ]);

            // Sync pilihan: hapus semua lalu insert ulang
            if (in_array($validated['jenis_soal'], ['pilihan_ganda', 'benar_salah'])) {
                $soal->pilihan()->delete();
                $this->storePilihan($request, $soal);
            } else {
                // Essay: hapus pilihan yang ada (jika pernah PG lalu diganti essay)
                $soal->pilihan()->delete();
            }
        });

        return redirect()
            ->route('guru.ujian.soal.index', $ujian)
            ->with('success', 'Soal berhasil diperbarui.');
    }

    // ── Destroy ───────────────────────────────────────────────────────────────

    public function destroy(Ujian $ujian, SoalUjian $soal)
    {
        $this->authorizeUjian($ujian);
        abort_if($soal->ujian_id !== $ujian->id, 404);

        // Cegah hapus jika sudah ada jawaban siswa
        if (JawabanSiswa::where('soal_ujian_id', $soal->id)->exists()) {
            return back()->with('error',
                'Soal tidak dapat dihapus karena sudah ada siswa yang menjawab soal ini.'
            );
        }

        DB::transaction(function () use ($soal) {
            if ($soal->gambar_soal) {
                Storage::disk('public')->delete($soal->gambar_soal);
            }
            // Hapus gambar pilihan jawaban
            foreach ($soal->pilihan as $p) {
                if ($p->gambar_pilihan) {
                    Storage::disk('public')->delete($p->gambar_pilihan);
                }
            }
            $soal->pilihan()->delete();
            $soal->delete();
        });

        // Re-nomor soal setelah hapus agar tetap berurutan
        $this->renomorSoal($ujian);

        return back()->with('success', 'Soal berhasil dihapus.');
    }

    // ── Reorder (AJAX) ────────────────────────────────────────────────────────

    /**
     * Menerima array urutan soal baru dan memperbarui nomor_soal.
     * Body: { order: [soal_id, soal_id, ...] }
     */
    public function reorder(Request $request, Ujian $ujian)
    {
        $this->authorizeUjian($ujian);

        $request->validate([
            'order'   => ['required', 'array'],
            'order.*' => ['integer'],
        ]);

        DB::transaction(function () use ($request, $ujian) {
            foreach ($request->order as $nomor => $soalId) {
                SoalUjian::where('id', $soalId)
                    ->where('ujian_id', $ujian->id)
                    ->update(['nomor_soal' => $nomor + 1]);
            }
        });

        return response()->json(['success' => true]);
    }

    // ── Koreksi Essay ─────────────────────────────────────────────────────────

    /**
     * Halaman daftar jawaban essay yang belum dikoreksi untuk ujian ini.
     */
    public function koreksiIndex(Ujian $ujian)
    {
        $this->authorizeUjian($ujian);

        $ujian->load(['mataPelajaran', 'kelas']);

        // Ambil semua jawaban essay yang belum dikoreksi (poin_didapat null)
        $jawabanList = JawabanSiswa::with(['soal', 'sesi.siswa'])
            ->whereHas('soal', fn($q) => $q->where('ujian_id', $ujian->id)
                ->where('jenis_soal', 'essay'))
            ->whereNull('poin_didapat')
            ->orderBy('soal_ujian_id')
            ->get();

        $stats = [
            'belum_dikoreksi' => $jawabanList->count(),
            'sudah_dikoreksi' => JawabanSiswa::whereHas('soal', fn($q) =>
                    $q->where('ujian_id', $ujian->id)->where('jenis_soal', 'essay'))
                ->whereNotNull('poin_didapat')
                ->count(),
        ];

        return view('guru.ujian.soal.koreksi-index', compact('ujian', 'jawabanList', 'stats'));
    }

    /**
     * Simpan koreksi satu jawaban essay.
     */
    public function koreksiStore(Request $request, Ujian $ujian, JawabanSiswa $jawaban)
    {
        $this->authorizeUjian($ujian);

        // Pastikan jawaban ini milik ujian yang benar
        abort_if($jawaban->soal->ujian_id !== $ujian->id, 404);

        $maxBobot = $jawaban->soal->bobot;

        $request->validate([
            'poin_didapat'   => ['required', 'numeric', 'min:0', "max:{$maxBobot}"],
            'catatan_koreksi' => ['nullable', 'string', 'max:500'],
        ], [
            'poin_didapat.required' => 'Poin wajib diisi.',
            'poin_didapat.min'      => 'Poin minimal 0.',
            'poin_didapat.max'      => "Poin maksimal {$maxBobot} (sesuai bobot soal).",
        ]);

        $poin   = (float) $request->poin_didapat;
        $benar  = $poin >= $maxBobot;  // "benar" jika poin penuh

        $jawaban->update([
            'poin_didapat'    => $poin,
            'adalah_benar'    => $benar,
            'catatan_koreksi' => $request->catatan_koreksi,
        ]);

        // Hitung ulang nilai sesi setelah koreksi
        $sesi = $jawaban->sesi;
        if ($sesi) {
            $sesi->hitungNilai();
        }

        return back()->with('success', 'Koreksi berhasil disimpan.');
    }

    // ── Private Helpers ───────────────────────────────────────────────────────

    /**
     * Simpan pilihan jawaban dari request ke soal yang diberikan.
     */
    private function storePilihan(Request $request, SoalUjian $soal): void
    {
        $pilihanData = $request->input('pilihan', []);

        foreach ($pilihanData as $idx => $p) {
            $gambarPath = null;
            if ($request->hasFile("pilihan.{$idx}.gambar_pilihan")) {
                $gambarPath = $request->file("pilihan.{$idx}.gambar_pilihan")
                    ->store('pilihan_jawaban', 'public');
            }

            PilihanJawaban::create([
                'soal_ujian_id'  => $soal->id,
                'kode_pilihan'   => strtoupper($p['kode_pilihan']),
                'teks_pilihan'   => $p['teks_pilihan'] ?? '',
                'gambar_pilihan' => $gambarPath,
                'adalah_benar'   => (bool) ($p['adalah_benar'] ?? false),
            ]);
        }
    }

    /**
     * Validasi pilihan jawaban secara manual (tidak bisa pakai Rule biasa karena nested array).
     */
    private function validatePilihan(Request $request): void
    {
        $pilihan   = $request->input('pilihan', []);
        $jenis     = $request->input('jenis_soal');
        $benarList = collect($pilihan)->where('adalah_benar', '1');

        if (count($pilihan) < 2) {
            abort(422, 'Minimal 2 pilihan jawaban.');
        }

        if ($jenis === 'pilihan_ganda' && count($pilihan) > 5) {
            abort(422, 'Pilihan ganda maksimal 5 pilihan.');
        }

        if ($benarList->isEmpty()) {
            abort(422, 'Wajib menandai minimal 1 jawaban yang benar.');
        }

        if ($jenis === 'pilihan_ganda' && $benarList->count() > 1) {
            abort(422, 'Pilihan ganda hanya boleh 1 jawaban benar.');
        }
    }

    /**
     * Re-nomor soal secara berurutan (1, 2, 3, …) berdasarkan nomor lama.
     */
    private function renomorSoal(Ujian $ujian): void
    {
        $soalList = $ujian->soal()->orderBy('nomor_soal')->get();
        foreach ($soalList as $i => $soal) {
            $soal->update(['nomor_soal' => $i + 1]);
        }
    }

    // ── Validation Rules ──────────────────────────────────────────────────────

    private function rulesStore(): array
    {
        return [
            'jenis_soal'  => ['required', Rule::in(['pilihan_ganda', 'benar_salah', 'essay'])],
            'nomor_soal'  => ['nullable', 'integer', 'min:1'],
            'pertanyaan'  => ['required', 'string'],
            'gambar_soal' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'bobot'       => ['required', 'integer', 'min:1', 'max:100'],
        ];
    }

    private function rulesUpdate(SoalUjian $soal): array
    {
        return [
            'jenis_soal'  => ['required', Rule::in(['pilihan_ganda', 'benar_salah', 'essay'])],
            'nomor_soal'  => ['required', 'integer', 'min:1'],
            'pertanyaan'  => ['required', 'string'],
            'gambar_soal' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'bobot'       => ['required', 'integer', 'min:1', 'max:100'],
            'hapus_gambar' => ['nullable', 'boolean'],
        ];
    }

    private function messages(): array
    {
        return [
            'jenis_soal.required' => 'Jenis soal wajib dipilih.',
            'jenis_soal.in'       => 'Jenis soal tidak valid.',
            'pertanyaan.required' => 'Teks pertanyaan wajib diisi.',
            'gambar_soal.image'   => 'File harus berupa gambar.',
            'gambar_soal.mimes'   => 'Format gambar harus JPG, PNG, atau WEBP.',
            'gambar_soal.max'     => 'Ukuran gambar maksimal 2MB.',
            'bobot.required'      => 'Bobot/poin wajib diisi.',
            'bobot.min'           => 'Bobot minimal 1.',
            'bobot.max'           => 'Bobot maksimal 100.',
            'nomor_soal.min'      => 'Nomor soal minimal 1.',
        ];
    }
}