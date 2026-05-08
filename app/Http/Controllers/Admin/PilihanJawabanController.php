<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PilihanJawaban;
use App\Models\SoalUjian;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PilihanJawabanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STORE  —  Tambah satu pilihan jawaban ke soal (AJAX / redirect)
    |--------------------------------------------------------------------------
    */
    public function store(Request $request, Ujian $ujian, SoalUjian $soal)
    {
        $this->guardSoal($ujian, $soal);

        $validated = $request->validate($this->rules(), $this->messages());

        if ($request->hasFile('gambar_pilihan')) {
            $validated['gambar_pilihan'] = $request->file('gambar_pilihan')
                ->store('soal-ujian/pilihan', 'public');
        }

        // Untuk PG: hanya boleh 1 jawaban benar, jadi reset dulu jika ditandai benar
        // Untuk benar_salah: tetap izinkan reset (karena sistemnya juga 1 benar)
        // Untuk essay: tidak ada pilihan, tapi guard sudah mencegahnya
        if (!empty($validated['adalah_benar'])) {
            $this->resetBenar($soal);
        }

        $pilihan = $soal->pilihan()->create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Pilihan berhasil ditambahkan.',
                'pilihan' => $pilihan,
            ], 201);
        }

        return back()->with('success', 'Pilihan jawaban berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE  —  Perbarui teks / gambar pilihan jawaban
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Ujian $ujian, SoalUjian $soal, PilihanJawaban $pilihan)
    {
        $this->guardSoal($ujian, $soal);
        $this->guardPilihan($soal, $pilihan);

        $validated = $request->validate($this->rules(), $this->messages());

        if ($request->hasFile('gambar_pilihan')) {
            if ($pilihan->gambar_pilihan) {
                Storage::disk('public')->delete($pilihan->gambar_pilihan);
            }
            $validated['gambar_pilihan'] = $request->file('gambar_pilihan')
                ->store('soal-ujian/pilihan', 'public');
        }

        if ($request->boolean('hapus_gambar') && $pilihan->gambar_pilihan) {
            Storage::disk('public')->delete($pilihan->gambar_pilihan);
            $validated['gambar_pilihan'] = null;
        }

        // Reset jawaban benar lain jika pilihan ini ditandai benar
        if (!empty($validated['adalah_benar'])) {
            $this->resetBenar($soal);
        }

        $pilihan->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Pilihan berhasil diperbarui.',
                'pilihan' => $pilihan->fresh(),
            ]);
        }

        return back()->with('success', 'Pilihan jawaban berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY  —  Hapus pilihan jawaban
    |--------------------------------------------------------------------------
    */
    public function destroy(Request $request, Ujian $ujian, SoalUjian $soal, PilihanJawaban $pilihan)
    {
        $this->guardSoal($ujian, $soal);
        $this->guardPilihan($soal, $pilihan);

        if ($pilihan->gambar_pilihan) {
            Storage::disk('public')->delete($pilihan->gambar_pilihan);
        }

        $pilihan->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Pilihan berhasil dihapus.']);
        }

        return back()->with('success', 'Pilihan jawaban berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | TANDAI BENAR  —  Set satu pilihan sebagai jawaban benar (AJAX)
    |--------------------------------------------------------------------------
    | PATCH admin/ujian/{ujian}/soal/{soal}/pilihan/{pilihan}/tandai-benar
    */
    public function tandaiBenar(Request $request, Ujian $ujian, SoalUjian $soal, PilihanJawaban $pilihan)
    {
        $this->guardSoal($ujian, $soal);
        $this->guardPilihan($soal, $pilihan);

        // Hanya PG dan benar_salah yang bisa ditandai benar via endpoint ini
        abort_if(
            $soal->jenis_soal === 'essay',
            422,
            'Soal essay tidak memiliki pilihan jawaban benar.'
        );

        DB::transaction(function () use ($soal, $pilihan) {
            $soal->pilihan()->update(['adalah_benar' => false]);
            $pilihan->update(['adalah_benar' => true]);
        });

        if ($request->expectsJson()) {
            return response()->json([
                'message'    => "Pilihan {$pilihan->kode_pilihan} ditandai sebagai jawaban benar.",
                'pilihan_id' => $pilihan->id,
            ]);
        }

        return back()->with('success', "Pilihan {$pilihan->kode_pilihan} ditandai sebagai jawaban benar.");
    }

    /*
    |==========================================================================
    | PRIVATE HELPERS
    |==========================================================================
    */

    private function guardSoal(Ujian $ujian, SoalUjian $soal): void
    {
        abort_if($soal->ujian_id !== $ujian->id, 404, 'Soal tidak ditemukan untuk ujian ini.');
    }

    private function guardPilihan(SoalUjian $soal, PilihanJawaban $pilihan): void
    {
        abort_if($pilihan->soal_ujian_id !== $soal->id, 404, 'Pilihan tidak ditemukan untuk soal ini.');
    }

    /**
     * Reset semua pilihan soal jadi tidak benar.
     * Dipanggil sebelum menetapkan jawaban benar baru.
     */
    private function resetBenar(SoalUjian $soal): void
    {
        $soal->pilihan()->update(['adalah_benar' => false]);
    }

    private function rules(): array
    {
        return [
            'kode_pilihan'   => ['required', 'string', 'max:5'],
            'teks_pilihan'   => ['required', 'string'],
            'gambar_pilihan' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'adalah_benar'   => ['nullable', 'boolean'],
        ];
    }

    private function messages(): array
    {
        return [
            'kode_pilihan.required'  => 'Kode pilihan wajib diisi (cth. A, B, C).',
            'kode_pilihan.max'       => 'Kode pilihan maksimal 5 karakter.',
            'teks_pilihan.required'  => 'Teks pilihan jawaban wajib diisi.',
            'gambar_pilihan.image'   => 'File harus berupa gambar.',
            'gambar_pilihan.max'     => 'Ukuran gambar pilihan maksimal 1MB.',
        ];
    }
}