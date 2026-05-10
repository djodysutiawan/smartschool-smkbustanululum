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
    private function getSiswa()
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    /**
     * Daftar tugas untuk kelas siswa.
     */
    public function index(Request $request)
    {
        $siswa = $this->getSiswa();

        $query = Tugas::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $siswa->kelas_id)
            ->dipublikasikan();

        if ($request->filled('status')) {
            match ($request->status) {
                'sudah'     => $query->whereHas('pengumpulan', fn($q) =>
                                    $q->where('siswa_id', $siswa->id)
                                      ->whereIn('status', [
                                          PengumpulanTugas::STATUS_DIKUMPULKAN,
                                          PengumpulanTugas::STATUS_TERLAMBAT,
                                          PengumpulanTugas::STATUS_DINILAI,
                                      ])),

                'belum'     => $query->whereDoesntHave('pengumpulan', fn($q) =>
                                    $q->where('siswa_id', $siswa->id)
                                      ->whereIn('status', [
                                          PengumpulanTugas::STATUS_DIKUMPULKAN,
                                          PengumpulanTugas::STATUS_TERLAMBAT,
                                          PengumpulanTugas::STATUS_DINILAI,
                                      ]))
                                     ->where('batas_waktu', '>=', now()),

                'terlambat' => $query->whereDoesntHave('pengumpulan', fn($q) =>
                                    $q->where('siswa_id', $siswa->id)
                                      ->whereIn('status', [
                                          PengumpulanTugas::STATUS_DIKUMPULKAN,
                                          PengumpulanTugas::STATUS_TERLAMBAT,
                                          PengumpulanTugas::STATUS_DINILAI,
                                      ]))
                                     ->where('batas_waktu', '<', now()),

                default     => null,
            };
        }

        if ($request->filled('mapel_id')) {
            $query->where('mata_pelajaran_id', (int) $request->mapel_id);
        }

        $tugas = $query->orderBy('batas_waktu')->paginate(15)->withQueryString();

        // FIX: cek sudah dikumpulkan berdasarkan status yang valid, bukan != STATUS_BELUM
        $sudahDikumpulkan = PengumpulanTugas::where('siswa_id', $siswa->id)
            ->whereIn('status', [
                PengumpulanTugas::STATUS_DIKUMPULKAN,
                PengumpulanTugas::STATUS_TERLAMBAT,
                PengumpulanTugas::STATUS_DINILAI,
            ])
            ->pluck('tugas_id')
            ->toArray();

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

        abort_if(
            (int) $tugas->kelas_id !== (int) $siswa->kelas_id,
            403,
            'Tugas ini bukan untuk kelas Anda.'
        );

        abort_if(! $tugas->dipublikasikan, 403, 'Tugas ini tidak tersedia.');

        $tugas->load(['mataPelajaran', 'guru', 'kelas', 'tahunAjaran']);

        // FIX: eager load tugas di pengumpulan agar getLabelJenisAttribute tidak N+1
        $pengumpulan = PengumpulanTugas::with('tugas')
            ->where('tugas_id', $tugas->id)
            ->where('siswa_id', $siswa->id)
            ->whereIn('status', [
                PengumpulanTugas::STATUS_DIKUMPULKAN,
                PengumpulanTugas::STATUS_TERLAMBAT,
                PengumpulanTugas::STATUS_DINILAI,
            ])
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
     */
    public function kumpul(Request $request, Tugas $tugas)
    {
        $siswa = $this->getSiswa();

        abort_if(
            (int) $tugas->kelas_id !== (int) $siswa->kelas_id,
            403,
            'Tugas ini bukan untuk kelas Anda.'
        );
        abort_if(! $tugas->dipublikasikan, 403, 'Tugas ini sudah tidak aktif.');
        abort_if(! $tugas->isMasihBisaDikumpulkan(), 422, 'Batas waktu pengumpulan sudah habis.');

        // FIX: cek sudah dikumpulkan berdasarkan status positif (bukan != belum)
        // Ini menghindari false positive saat status NULL di DB
        $sudahDikumpulkan = PengumpulanTugas::where('tugas_id', $tugas->id)
            ->where('siswa_id', $siswa->id)
            ->whereIn('status', [
                PengumpulanTugas::STATUS_DIKUMPULKAN,
                PengumpulanTugas::STATUS_TERLAMBAT,
                PengumpulanTugas::STATUS_DINILAI,
            ])
            ->exists();

        abort_if($sudahDikumpulkan, 422, 'Anda sudah mengumpulkan tugas ini.');

        // FIX: jenis_pengumpulan diambil dari tugas (DB tugas punya kolom ini),
        // bukan dari input user. DB tugas: ENUM('file','teks','link','semua')
        $jenisTugas = $tugas->jenis_pengumpulan;

        // FIX: Validasi disesuaikan nama field dengan kolom DB yang ada:
        //   path_file     → kolom DB: path_file     (bukan file_pengumpulan)
        //   jawaban_teks  → kolom DB: jawaban_teks  (bukan konten_teks)
        //   url_link      → kolom DB: url_link       (bukan link_pengumpulan)
        // Kolom 'catatan' TIDAK ADA di DB — dihapus dari validasi dan insert
        $rules = [
            'jawaban_teks' => [
                'nullable',
                'string',
                'max:10000',
            ],
            'url_link' => [
                'nullable',
                'url',
                'max:255',
            ],
            'path_file' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png,zip',
                'max:10240',
            ],
        ];

        // Required berdasarkan jenis tugas
        if (in_array($jenisTugas, ['teks', 'semua'])) {
            $rules['jawaban_teks'][] = 'required';
        }
        if (in_array($jenisTugas, ['link', 'semua'])) {
            $rules['url_link'][] = 'required';
        }
        if (in_array($jenisTugas, ['file', 'semua'])) {
            $rules['path_file'][] = 'required';
        }

        $messages = [
            'jawaban_teks.required' => 'Jawaban teks wajib diisi.',
            'jawaban_teks.max'      => 'Jawaban teks terlalu panjang (maks 10.000 karakter).',
            'url_link.required'     => 'Link wajib diisi.',
            'url_link.url'          => 'Format link tidak valid. Pastikan diawali https://.',
            'url_link.max'          => 'URL terlalu panjang (maks 255 karakter).',
            'path_file.required'    => 'File wajib diunggah.',
            'path_file.mimes'       => 'Format file tidak didukung (PDF, Word, JPG, PNG, ZIP).',
            'path_file.max'         => 'Ukuran file maksimal 10MB.',
        ];

        $validated = $request->validate($rules, $messages);

        // Upload file jika ada
        $pathFile = null;
        if ($request->hasFile('path_file') && $request->file('path_file')->isValid()) {
            $pathFile = $request->file('path_file')->store('pengumpulan-tugas', 'public');
        }

        // Status: terlambat jika waktu sudah lewat, dikumpulkan jika tepat waktu
        $status = $tugas->isTelahBerakhir()
            ? PengumpulanTugas::STATUS_TERLAMBAT
            : PengumpulanTugas::STATUS_DIKUMPULKAN;

        // FIX: insert menggunakan nama kolom DB yang benar
        // path_file, jawaban_teks, url_link — bukan nama kolom model lama
        PengumpulanTugas::create([
            'tugas_id'         => $tugas->id,
            'siswa_id'         => $siswa->id,
            'path_file'        => $pathFile,
            'jawaban_teks'     => $validated['jawaban_teks'] ?? null,
            'url_link'         => $validated['url_link'] ?? null,
            'status'           => $status,
            'dikumpulkan_pada' => now(),
        ]);

        return redirect()->route('siswa.tugas.show', $tugas)
            ->with('success', $status === PengumpulanTugas::STATUS_TERLAMBAT
                ? 'Tugas berhasil dikumpulkan (terlambat).'
                : 'Tugas berhasil dikumpulkan tepat waktu!');
    }
}