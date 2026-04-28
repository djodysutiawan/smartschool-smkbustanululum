<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PengumpulanTugas;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TugasController extends Controller
{
    private const JENIS_PENGUMPULAN = ['file', 'teks', 'link', 'foto'];

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

        $query = Tugas::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('dipublikasikan', true);

        if ($request->filled('status')) {
            if ($request->status === 'sudah') {
                $query->whereHas('pengumpulan', fn ($q) => $q->where('siswa_id', $siswa->id));
            } elseif ($request->status === 'belum') {
                $query->whereDoesntHave('pengumpulan', fn ($q) => $q->where('siswa_id', $siswa->id))
                    ->where('batas_waktu', '>=', now());
            } elseif ($request->status === 'terlambat') {
                $query->whereDoesntHave('pengumpulan', fn ($q) => $q->where('siswa_id', $siswa->id))
                    ->where('batas_waktu', '<', now());
            }
        }

        if ($request->filled('mapel_id')) {
            $query->where('mata_pelajaran_id', $request->mapel_id);
        }

        $tugas = $query->orderBy('batas_waktu')->paginate(15)->withQueryString();

        // ID tugas yang sudah dikumpulkan siswa ini
        $sudahDikumpulkan = PengumpulanTugas::where('siswa_id', $siswa->id)
            ->pluck('tugas_id')
            ->toArray();

        $mapelList = \App\Models\MataPelajaran::whereHas('jadwalPelajaran', fn ($q) =>
            $q->where('kelas_id', $siswa->kelas_id)->where('is_active', true)
        )->orderBy('nama_mapel')->get();

        return view('siswa.tugas.index', compact('tugas', 'sudahDikumpulkan', 'mapelList'));
    }

    /**
     * Detail tugas beserta status pengumpulan siswa.
     */
    public function show(Tugas $tugas)
    {
        $siswa = $this->getSiswa();

        abort_if($tugas->kelas_id !== $siswa->kelas_id, 403, 'Tugas ini bukan untuk kelas Anda.');

        $tugas->load(['mataPelajaran', 'guru', 'kelas']);

        $pengumpulan = PengumpulanTugas::where('tugas_id', $tugas->id)
            ->where('siswa_id', $siswa->id)
            ->first();

        $sudahDikumpulkan = ! is_null($pengumpulan);
        $terlambat        = now()->gt($tugas->batas_waktu);
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

        abort_if($tugas->kelas_id !== $siswa->kelas_id, 403, 'Tugas ini bukan untuk kelas Anda.');
        abort_if(! $tugas->dipublikasikan, 403, 'Tugas ini sudah tidak aktif.');
        abort_if(! $tugas->isMasihBisaDikumpulkan(), 422, 'Batas waktu pengumpulan sudah habis.');

        $sudahDikumpulkan = PengumpulanTugas::where('tugas_id', $tugas->id)
            ->where('siswa_id', $siswa->id)
            ->exists();

        abort_if($sudahDikumpulkan, 422, 'Anda sudah mengumpulkan tugas ini.');

        $validated = $request->validate([
            'jenis_pengumpulan' => ['required', Rule::in(self::JENIS_PENGUMPULAN)],
            'konten_teks'       => ['nullable', 'string', 'required_if:jenis_pengumpulan,teks'],
            'link_pengumpulan'  => ['nullable', 'url', 'required_if:jenis_pengumpulan,link'],
            'file_pengumpulan'  => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png,zip',
                'max:10240',
                Rule::requiredIf(fn () => in_array($request->jenis_pengumpulan, ['file', 'foto'])),
            ],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ], [
            'jenis_pengumpulan.required' => 'Jenis pengumpulan wajib dipilih.',
            'konten_teks.required_if'    => 'Teks jawaban wajib diisi.',
            'link_pengumpulan.required_if'=> 'Link wajib diisi.',
            'link_pengumpulan.url'       => 'Format link tidak valid.',
            'file_pengumpulan.mimes'     => 'Format file tidak didukung (pdf, doc, docx, jpg, png, zip).',
            'file_pengumpulan.max'       => 'Ukuran file maksimal 10MB.',
        ]);

        if ($request->hasFile('file_pengumpulan')) {
            $validated['file_pengumpulan'] = $request->file('file_pengumpulan')
                ->store('pengumpulan-tugas', 'public');
        }

        $status = now()->gt($tugas->batas_waktu) ? 'terlambat' : 'dikumpulkan';

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
            ->with('success', $status === 'terlambat'
                ? 'Tugas berhasil dikumpulkan (terlambat).'
                : 'Tugas berhasil dikumpulkan tepat waktu!');
    }
}