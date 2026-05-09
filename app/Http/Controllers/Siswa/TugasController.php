<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\PengumpulanTugas;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TugasController extends Controller
{
    /**
     * FIX: Sinkronkan dengan PengumpulanTugas::JENIS_VALID dan Tugas::JENIS_PENGUMPULAN.
     * Gunakan referensi konstanta model agar tidak ada triple hardcode.
     */
    private function getSiswa()
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    /**
     * Daftar tugas untuk kelas siswa.
     * Ditandai apakah sudah dikumpulkan atau belum.
     */
    public function index(Request $request)
    {
        $siswa = $this->getSiswa();

        // FIX: Gunakan scope dipublikasikan() dan eager load tahunAjaran
        // jika dipakai di view untuk menghindari N+1.
        $query = Tugas::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $siswa->kelas_id)
            ->dipublikasikan();

        // Filter status pengumpulan
        if ($request->filled('status')) {
            match ($request->status) {
                'sudah'    => $query->whereHas('pengumpulan', fn ($q) =>
                                    $q->where('siswa_id', $siswa->id)
                                      ->where('status', '!=', PengumpulanTugas::STATUS_BELUM)),

                'belum'    => $query->whereDoesntHave('pengumpulan', fn ($q) =>
                                    $q->where('siswa_id', $siswa->id))
                                    ->where('batas_waktu', '>=', now()),

                'terlambat'=> $query->whereDoesntHave('pengumpulan', fn ($q) =>
                                    $q->where('siswa_id', $siswa->id))
                                    ->where('batas_waktu', '<', now()),

                default    => null, // nilai tidak dikenal — abaikan, tampilkan semua
            };
        }

        // FIX: Cast mapel_id ke int agar tidak ada type mismatch di query
        if ($request->filled('mapel_id')) {
            $query->where('mata_pelajaran_id', (int) $request->mapel_id);
        }

        $tugas = $query->orderBy('batas_waktu')->paginate(15)->withQueryString();

        // ID tugas yang sudah dikumpulkan siswa ini — dipakai di view untuk badge status
        $sudahDikumpulkan = PengumpulanTugas::where('siswa_id', $siswa->id)
            ->where('status', '!=', PengumpulanTugas::STATUS_BELUM)
            ->pluck('tugas_id')
            ->toArray();

        // FIX: Ganti query mapelList dari jadwalPelajaran (rentan kolom is_active tidak ada)
        // ke query via tugas yang dipublikasikan untuk kelas ini — lebih akurat.
        $mapelList = MataPelajaran::whereHas('tugas', function ($q) use ($siswa) {
                $q->where('kelas_id', $siswa->kelas_id)
                  ->where('dipublikasikan', true);
            })
            ->orderBy('nama_mapel')
            ->get();

        return view('siswa.tugas.index', compact('tugas', 'sudahDikumpulkan', 'mapelList'));
    }

    /**
     * Detail tugas beserta status pengumpulan siswa.
     */
    public function show(Tugas $tugas)
    {
        $siswa = $this->getSiswa();

        // FIX: Cast eksplisit ke int agar perbandingan tidak gagal karena string vs int
        abort_if(
            (int) $tugas->kelas_id !== (int) $siswa->kelas_id,
            403,
            'Tugas ini bukan untuk kelas Anda.'
        );

        // FIX: Cek juga dipublikasikan — siswa tidak boleh akses tugas yang di-unpublish
        abort_if(! $tugas->dipublikasikan, 403, 'Tugas ini tidak tersedia.');

        $tugas->load(['mataPelajaran', 'guru', 'kelas', 'tahunAjaran']);

        $pengumpulan = PengumpulanTugas::where('tugas_id', $tugas->id)
            ->where('siswa_id', $siswa->id)
            ->first();

        $sudahDikumpulkan = ! is_null($pengumpulan);
        $terlambat        = $tugas->isTelahBerakhir();
        $masihBisaKumpul  = $tugas->isMasihBisaDikumpulkan();

        return view('siswa.tugas.show', compact(
            'tugas', 'pengumpulan', 'sudahDikumpulkan', 'terlambat', 'masihBisaKumpul'
        ));
    }

    /**
     * Proses pengumpulan tugas (POST /{tugas}/kumpul).
     * Route name: siswa.tugas.kumpul
     */
    public function kumpul(Request $request, Tugas $tugas)
    {
        $siswa = $this->getSiswa();

        // FIX: Cast eksplisit ke int — konsisten dengan show()
        abort_if(
            (int) $tugas->kelas_id !== (int) $siswa->kelas_id,
            403,
            'Tugas ini bukan untuk kelas Anda.'
        );
        abort_if(! $tugas->dipublikasikan, 403, 'Tugas ini sudah tidak aktif.');
        abort_if(! $tugas->isMasihBisaDikumpulkan(), 422, 'Batas waktu pengumpulan sudah habis.');

        // FIX: Sertakan filter status != belum agar konsisten dengan definisi "sudah kumpul"
        $sudahDikumpulkan = PengumpulanTugas::where('tugas_id', $tugas->id)
            ->where('siswa_id', $siswa->id)
            ->where('status', '!=', PengumpulanTugas::STATUS_BELUM)
            ->exists();

        abort_if($sudahDikumpulkan, 422, 'Anda sudah mengumpulkan tugas ini.');

        // FIX: Gunakan konstanta model sebagai sumber kebenaran jenis yang valid
        $validated = $request->validate([
            'jenis_pengumpulan' => ['required', Rule::in(PengumpulanTugas::JENIS_VALID)],
            'konten_teks'       => [
                'nullable',
                'string',
                'max:10000',
                'required_if:jenis_pengumpulan,teks',
            ],
            'link_pengumpulan'  => [
                'nullable',
                'url',
                'max:2048',
                'required_if:jenis_pengumpulan,link',
            ],
            'file_pengumpulan'  => [
                'nullable',
                'file',
                // FIX: Pisahkan validasi mimes antara file dan foto
                // untuk memberi feedback yang lebih tepat kepada siswa.
                Rule::when(
                    $request->jenis_pengumpulan === 'foto',
                    ['mimes:jpg,jpeg,png', 'max:10240'],
                    ['mimes:pdf,doc,docx,jpg,jpeg,png,zip', 'max:10240']
                ),
                Rule::requiredIf(
                    fn () => in_array($request->jenis_pengumpulan, ['file', 'foto'], strict: true)
                ),
            ],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ], [
            'jenis_pengumpulan.required'  => 'Jenis pengumpulan wajib dipilih.',
            'jenis_pengumpulan.in'        => 'Jenis pengumpulan tidak valid.',
            'konten_teks.required_if'     => 'Teks jawaban wajib diisi.',
            'konten_teks.max'             => 'Teks jawaban terlalu panjang (maks 10.000 karakter).',
            'link_pengumpulan.required_if'=> 'Link wajib diisi.',
            'link_pengumpulan.url'        => 'Format link tidak valid. Pastikan diawali https://.',
            'link_pengumpulan.max'        => 'URL terlalu panjang.',
            'file_pengumpulan.required'   => 'File wajib diunggah.',
            'file_pengumpulan.mimes'      => 'Format file tidak didukung.',
            'file_pengumpulan.max'        => 'Ukuran file maksimal 10MB.',
        ]);

        // Upload file jika ada
        if ($request->hasFile('file_pengumpulan') && $request->file('file_pengumpulan')->isValid()) {
            // FIX: Gunakan folder berbeda untuk foto vs file dokumen
            $folder = $request->jenis_pengumpulan === 'foto'
                ? 'pengumpulan-foto'
                : 'pengumpulan-tugas';

            $validated['file_pengumpulan'] = $request->file('file_pengumpulan')
                ->store($folder, 'public');
        } else {
            // Pastikan tidak ada nilai sisa dari validated jika tidak ada file
            $validated['file_pengumpulan'] = null;
        }

        // FIX: Evaluasi status berdasarkan waktu saat ini vs batas_waktu,
        // bukan dari isMasihBisaDikumpulkan() (yang mencakup izinkan_terlambat).
        $status = $tugas->isTelahBerakhir()
            ? PengumpulanTugas::STATUS_TERLAMBAT
            : PengumpulanTugas::STATUS_DIKUMPULKAN;

        // FIX: Nama kolom sekarang selaras dengan PengumpulanTugas::$fillable
        PengumpulanTugas::create([
            'tugas_id'          => $tugas->id,
            'siswa_id'          => $siswa->id,
            'jenis_pengumpulan' => $validated['jenis_pengumpulan'],
            'konten_teks'       => $validated['konten_teks'] ?? null,
            'link_pengumpulan'  => $validated['link_pengumpulan'] ?? null,
            'file_pengumpulan'  => $validated['file_pengumpulan'] ?? null,
            'catatan'           => $validated['catatan'] ?? null,
            'status'            => $status,
            'dikumpulkan_pada'  => now(),
        ]);

        return redirect()->route('siswa.tugas.show', $tugas)
            ->with('success', $status === PengumpulanTugas::STATUS_TERLAMBAT
                ? 'Tugas berhasil dikumpulkan (terlambat).'
                : 'Tugas berhasil dikumpulkan tepat waktu!');
    }
}