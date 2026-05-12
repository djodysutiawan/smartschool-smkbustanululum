<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\PengumpulanTugas;
use App\Models\Tugas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    private function getSiswa()
    {
        $siswa = Auth::user()->siswa;
        abort_if(! $siswa, 403, 'Akun Anda tidak terhubung dengan data siswa.');
        return $siswa;
    }

    private function statusDikumpulkan(): array
    {
        return [
            PengumpulanTugas::STATUS_DIKUMPULKAN,
            PengumpulanTugas::STATUS_TERLAMBAT,
            PengumpulanTugas::STATUS_DINILAI,
        ];
    }

    /**
     * GET /api/siswa/tugas
     */
    public function index(Request $request): JsonResponse
    {
        $siswa = $this->getSiswa();

        $query = Tugas::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $siswa->kelas_id)
            ->dipublikasikan();

        if ($request->filled('status')) {
            match ($request->status) {
                'sudah'     => $query->whereHas('pengumpulan', fn($q) =>
                                    $q->where('siswa_id', $siswa->id)
                                      ->whereIn('status', $this->statusDikumpulkan())),

                'belum'     => $query->whereDoesntHave('pengumpulan', fn($q) =>
                                    $q->where('siswa_id', $siswa->id)
                                      ->whereIn('status', $this->statusDikumpulkan()))
                                     ->where('batas_waktu', '>=', now()),

                'terlambat' => $query->whereDoesntHave('pengumpulan', fn($q) =>
                                    $q->where('siswa_id', $siswa->id)
                                      ->whereIn('status', $this->statusDikumpulkan()))
                                     ->where('batas_waktu', '<', now()),

                default     => null,
            };
        }

        if ($request->filled('mapel_id')) {
            $query->where('mata_pelajaran_id', (int) $request->mapel_id);
        }

        $tugas = $query->orderBy('batas_waktu')->paginate(15)->withQueryString();

        $sudahDikumpulkanIds = PengumpulanTugas::where('siswa_id', $siswa->id)
            ->whereIn('status', $this->statusDikumpulkan())
            ->pluck('tugas_id')
            ->toArray();

        $mapelList = MataPelajaran::whereHas('tugas', function ($q) use ($siswa) {
                $q->where('kelas_id', $siswa->kelas_id)->where('dipublikasikan', true);
            })
            ->orderBy('nama_mapel')
            ->get(['id', 'nama_mapel']);

        // Tandai setiap tugas apakah sudah dikumpulkan
        $tugas->getCollection()->transform(function ($t) use ($sudahDikumpulkanIds) {
            $t->sudah_dikumpulkan = in_array($t->id, $sudahDikumpulkanIds);
            return $t;
        });

        return response()->json([
            'success' => true,
            'data'    => [
                'tugas'      => $tugas,
                'mapel_list' => $mapelList,
            ],
        ]);
    }

    /**
     * GET /api/siswa/tugas/{tugas}
     */
    public function show(Tugas $tugas): JsonResponse
    {
        $siswa = $this->getSiswa();

        if ((int) $tugas->kelas_id !== (int) $siswa->kelas_id) {
            return response()->json(['success' => false, 'message' => 'Tugas ini bukan untuk kelas Anda.'], 403);
        }

        if (! $tugas->dipublikasikan) {
            return response()->json(['success' => false, 'message' => 'Tugas ini tidak tersedia.'], 403);
        }

        $tugas->load(['mataPelajaran', 'guru', 'kelas', 'tahunAjaran']);

        $pengumpulan = PengumpulanTugas::with('tugas')
            ->where('tugas_id', $tugas->id)
            ->where('siswa_id', $siswa->id)
            ->whereIn('status', $this->statusDikumpulkan())
            ->first();

        return response()->json([
            'success' => true,
            'data'    => [
                'tugas'            => $tugas,
                'pengumpulan'      => $pengumpulan,
                'sudah_dikumpulkan'=> ! is_null($pengumpulan),
                'terlambat'        => $tugas->isTelahBerakhir(),
                'masih_bisa_kumpul'=> $tugas->isMasihBisaDikumpulkan(),
            ],
        ]);
    }

    /**
     * POST /api/siswa/tugas/{tugas}/kumpul
     */
    public function kumpul(Request $request, Tugas $tugas): JsonResponse
    {
        $siswa = $this->getSiswa();

        if ((int) $tugas->kelas_id !== (int) $siswa->kelas_id) {
            return response()->json(['success' => false, 'message' => 'Tugas ini bukan untuk kelas Anda.'], 403);
        }
        if (! $tugas->dipublikasikan) {
            return response()->json(['success' => false, 'message' => 'Tugas ini sudah tidak aktif.'], 403);
        }
        if (! $tugas->isMasihBisaDikumpulkan()) {
            return response()->json(['success' => false, 'message' => 'Batas waktu pengumpulan sudah habis.'], 422);
        }

        $sudahDikumpulkan = PengumpulanTugas::where('tugas_id', $tugas->id)
            ->where('siswa_id', $siswa->id)
            ->whereIn('status', $this->statusDikumpulkan())
            ->exists();

        if ($sudahDikumpulkan) {
            return response()->json(['success' => false, 'message' => 'Anda sudah mengumpulkan tugas ini.'], 422);
        }

        $jenisTugas = $tugas->jenis_pengumpulan;

        $rules = [
            'jawaban_teks' => ['nullable', 'string', 'max:10000'],
            'url_link'     => ['nullable', 'url', 'max:255'],
            'path_file'    => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png,zip', 'max:10240'],
        ];

        if (in_array($jenisTugas, ['teks', 'semua']))  $rules['jawaban_teks'][] = 'required';
        if (in_array($jenisTugas, ['link', 'semua']))  $rules['url_link'][]     = 'required';
        if (in_array($jenisTugas, ['file', 'semua']))  $rules['path_file'][]    = 'required';

        $validated = $request->validate($rules, [
            'jawaban_teks.required' => 'Jawaban teks wajib diisi.',
            'jawaban_teks.max'      => 'Jawaban teks terlalu panjang (maks 10.000 karakter).',
            'url_link.required'     => 'Link wajib diisi.',
            'url_link.url'          => 'Format link tidak valid.',
            'url_link.max'          => 'URL terlalu panjang (maks 255 karakter).',
            'path_file.required'    => 'File wajib diunggah.',
            'path_file.mimes'       => 'Format file tidak didukung (PDF, Word, JPG, PNG, ZIP).',
            'path_file.max'         => 'Ukuran file maksimal 10MB.',
        ]);

        $pathFile = null;
        if ($request->hasFile('path_file') && $request->file('path_file')->isValid()) {
            $pathFile = $request->file('path_file')->store('pengumpulan-tugas', 'public');
        }

        $status = $tugas->isTelahBerakhir()
            ? PengumpulanTugas::STATUS_TERLAMBAT
            : PengumpulanTugas::STATUS_DIKUMPULKAN;

        $pengumpulan = PengumpulanTugas::create([
            'tugas_id'         => $tugas->id,
            'siswa_id'         => $siswa->id,
            'path_file'        => $pathFile,
            'jawaban_teks'     => $validated['jawaban_teks'] ?? null,
            'url_link'         => $validated['url_link'] ?? null,
            'status'           => $status,
            'dikumpulkan_pada' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => $status === PengumpulanTugas::STATUS_TERLAMBAT
                ? 'Tugas berhasil dikumpulkan (terlambat).'
                : 'Tugas berhasil dikumpulkan tepat waktu!',
            'data'    => ['pengumpulan' => $pengumpulan],
        ], 201);
    }
}