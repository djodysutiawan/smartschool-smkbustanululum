<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    private const STATUS_LIST = ['hadir', 'telat', 'izin', 'sakit', 'alfa'];
    private const METODE_LIST = ['manual', 'qr'];

    private function getGuruId(): int
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru->id;
    }

    public function index(Request $request)
    {
        $guruId = $this->getGuruId();

        // Guru hanya melihat absensi yang dia catat atau untuk kelas yang dia ajar
        $kelasIds = JadwalPelajaran::where('guru_id', $guruId)
            ->pluck('kelas_id')
            ->unique();

        $query = Absensi::with(['siswa', 'kelas', 'jadwalPelajaran', 'dicatatOleh'])
            ->whereIn('kelas_id', $kelasIds);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('search')) {
            $query->whereHas('siswa', fn ($q) =>
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
            );
        }

        $absensi    = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();
        $kelasList  = Kelas::aktif()->whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();
        $statusList = self::STATUS_LIST;

        // Rekap hari ini
        $rekap = [
            'hadir' => Absensi::whereIn('kelas_id', $kelasIds)->whereIn('status', ['hadir', 'telat'])->whereDate('tanggal', today())->count(),
            'izin'  => Absensi::whereIn('kelas_id', $kelasIds)->where('status', 'izin')->whereDate('tanggal', today())->count(),
            'sakit' => Absensi::whereIn('kelas_id', $kelasIds)->where('status', 'sakit')->whereDate('tanggal', today())->count(),
            'alfa'  => Absensi::whereIn('kelas_id', $kelasIds)->where('status', 'alfa')->whereDate('tanggal', today())->count(),
        ];

        return view('guru.absensi.index', compact('absensi', 'kelasList', 'statusList', 'rekap'));
    }

    public function create(Request $request)
    {
        $guruId = $this->getGuruId();
    
        $kelasIds   = JadwalPelajaran::where('guru_id', $guruId)->pluck('kelas_id')->unique();
        $kelasList  = Kelas::aktif()->whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();
        $jadwalList = JadwalPelajaran::aktif()
            ->with(['mataPelajaran', 'kelas'])
            ->where('guru_id', $guruId)
            ->get();
    
        // Jika sudah pilih kelas, muat siswa aktif di kelas tersebut
        $siswaList = collect();
        if ($request->filled('kelas_id')) {
            // Pastikan guru punya akses ke kelas ini
            abort_unless($kelasIds->contains($request->kelas_id), 403, 'Anda tidak memiliki akses ke kelas ini.');
    
            $siswaList = \App\Models\Siswa::aktif()
                ->where('kelas_id', $request->kelas_id)   // sesuaikan kolom jika berbeda
                ->orderBy('nama_lengkap')
                ->get();
        }
    
        return view('guru.absensi.create',
            compact('kelasList', 'jadwalList', 'siswaList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id'            => ['required', 'exists:siswa,id'],
            'kelas_id'            => ['required', 'exists:kelas,id'],
            'jadwal_pelajaran_id' => ['nullable', 'exists:jadwal_pelajaran,id'],
            'tanggal'             => ['required', 'date'],
            'status'              => ['required', Rule::in(self::STATUS_LIST)],
            'metode'              => ['nullable', Rule::in(self::METODE_LIST)],
            'jam_masuk'           => ['nullable', 'date_format:H:i'],
            'jam_keluar'          => ['nullable', 'date_format:H:i', 'after:jam_masuk'],
            'keterangan'          => ['nullable', 'string', 'max:500'],
            'path_surat_izin'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ], $this->messages());

        if ($request->hasFile('path_surat_izin')) {
            $validated['path_surat_izin'] = $request->file('path_surat_izin')
                ->store('absensi/surat_izin', 'public');
        }

        $validated['dicatat_oleh'] = Auth::id();

        Absensi::create($validated);

        return redirect()->route('guru.absensi.index')
            ->with('success', 'Data absensi berhasil ditambahkan.');
    }

    public function storeMassal(Request $request)
    {
        $guruId = $this->getGuruId();
    
        // Validasi header
        $request->validate([
            'kelas_id'            => ['required', 'exists:kelas,id'],
            'tanggal'             => ['required', 'date'],
            'jadwal_pelajaran_id' => ['nullable', 'exists:jadwal_pelajaran,id'],
            'siswa'               => ['required', 'array', 'min:1'],
            'siswa.*.siswa_id'    => ['required', 'exists:siswa,id'],
            'siswa.*.status'      => ['required', Rule::in(self::STATUS_LIST)],
            'siswa.*.jam_masuk'   => ['nullable', 'date_format:H:i'],
            'siswa.*.jam_keluar'  => ['nullable', 'date_format:H:i'],
            'siswa.*.keterangan'  => ['nullable', 'string', 'max:500'],
        ], [
            'kelas_id.required'         => 'Kelas wajib dipilih.',
            'tanggal.required'          => 'Tanggal absensi wajib diisi.',
            'siswa.required'            => 'Tidak ada data siswa yang dikirim.',
            'siswa.*.siswa_id.required' => 'Data siswa tidak valid.',
            'siswa.*.status.required'   => 'Status kehadiran wajib dipilih untuk setiap siswa.',
            'siswa.*.status.in'         => 'Status kehadiran tidak valid.',
            'siswa.*.jam_masuk.date_format'  => 'Format jam masuk harus HH:MM.',
            'siswa.*.jam_keluar.date_format' => 'Format jam keluar harus HH:MM.',
        ]);
    
        // Pastikan guru punya akses ke kelas ini
        $kelasIds = JadwalPelajaran::where('guru_id', $guruId)->pluck('kelas_id')->unique();
        abort_unless($kelasIds->contains($request->kelas_id), 403, 'Anda tidak memiliki akses ke kelas ini.');
    
        $dicatatOleh        = Auth::id();
        $tanggal            = $request->tanggal;
        $kelasId            = $request->kelas_id;
        $jadwalPelajaranId  = $request->jadwal_pelajaran_id;
        $suratFiles         = $request->file('surat', []);  // array indexed by siswa_id
    
        $created = 0;
        $skipped = 0;
    
        foreach ($request->siswa as $item) {
            $siswaId = $item['siswa_id'];
    
            // Skip jika absensi untuk siswa + tanggal + kelas sudah ada
            $exists = Absensi::where('siswa_id', $siswaId)
                ->where('kelas_id', $kelasId)
                ->where('tanggal', $tanggal)
                ->exists();
    
            if ($exists) {
                $skipped++;
                continue;
            }
    
            $data = [
                'siswa_id'            => $siswaId,
                'kelas_id'            => $kelasId,
                'tanggal'             => $tanggal,
                'jadwal_pelajaran_id' => $jadwalPelajaranId,
                'status'              => $item['status'],
                'metode'              => 'manual',
                'jam_masuk'           => $item['jam_masuk']   ?? null,
                'jam_keluar'          => $item['jam_keluar']  ?? null,
                'keterangan'          => $item['keterangan']  ?? null,
                'dicatat_oleh'        => $dicatatOleh,
            ];
    
            // Upload surat izin jika ada
            if (isset($suratFiles[$siswaId]) && $suratFiles[$siswaId]->isValid()) {
                $data['path_surat_izin'] = $suratFiles[$siswaId]
                    ->store('absensi/surat_izin', 'public');
            }
    
            Absensi::create($data);
            $created++;
        }
    
        if ($skipped > 0) {
            $msg = "Absensi {$created} siswa berhasil disimpan.";
            if ($skipped > 0) $msg .= " {$skipped} siswa dilewati (sudah ada absensi untuk tanggal ini).";
            return redirect()->route('guru.absensi.index')->with('success', $msg);
        }
    
        return redirect()->route('guru.absensi.index')
            ->with('success', "Absensi {$created} siswa berhasil disimpan.");
    }

    public function show(Absensi $absensi)
    {
        $this->authorizeAbsensi($absensi);

        $absensi->load(['siswa', 'kelas', 'jadwalPelajaran', 'dicatatOleh']);

        return view('guru.absensi.show', compact('absensi'));
    }

    public function edit(Absensi $absensi)
    {
        $guruId = $this->getGuruId();
        $this->authorizeAbsensi($absensi);

        $kelasIds   = JadwalPelajaran::where('guru_id', $guruId)->pluck('kelas_id')->unique();
        $kelasList  = Kelas::aktif()->whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();
        $siswaList  = Siswa::aktif()->orderBy('nama_lengkap')->get();
        $jadwalList = JadwalPelajaran::aktif()
            ->with(['mataPelajaran', 'kelas'])
            ->where('guru_id', $guruId)
            ->get();
        $statusList = self::STATUS_LIST;
        $metodeList = self::METODE_LIST;

        return view('guru.absensi.edit',
            compact('absensi', 'kelasList', 'siswaList', 'jadwalList', 'statusList', 'metodeList'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $this->authorizeAbsensi($absensi);

        $validated = $request->validate([
            'status'          => ['required', Rule::in(self::STATUS_LIST)],
            'metode'          => ['nullable', Rule::in(self::METODE_LIST)],
            'jam_masuk'       => ['nullable', 'date_format:H:i'],
            'jam_keluar'      => ['nullable', 'date_format:H:i', 'after:jam_masuk'],
            'keterangan'      => ['nullable', 'string', 'max:500'],
            'path_surat_izin' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ], $this->messages());

        if ($request->hasFile('path_surat_izin')) {
            $validated['path_surat_izin'] = $request->file('path_surat_izin')
                ->store('absensi/surat_izin', 'public');
        }

        $absensi->update($validated);

        return redirect()->route('guru.absensi.show', $absensi)
            ->with('success', 'Data absensi berhasil diperbarui.');
    }

    public function destroy(Absensi $absensi)
    {
        $this->authorizeAbsensi($absensi);

        $absensi->delete();

        return redirect()->route('guru.absensi.index')
            ->with('success', 'Data absensi berhasil dihapus.');
    }

    /**
     * Rekap kehadiran per kelas (difilter hanya kelas yang diajar guru ini).
     */
    public function rekap(Request $request)
    {
        $guruId   = $this->getGuruId();
        $kelasIds = JadwalPelajaran::where('guru_id', $guruId)->pluck('kelas_id')->unique();
        $kelasList = Kelas::aktif()->whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();

        if (! $request->filled('kelas_id')) {
            return view('guru.absensi.rekap', [
                'absensi'   => null,
                'kelas'     => null,
                'kelasList' => $kelasList,
                'request'   => $request,
            ]);
        }

        $request->validate([
            'kelas_id'       => ['required', 'exists:kelas,id'],
            'tanggal_dari'   => ['required', 'date'],
            'tanggal_sampai' => ['required', 'date', 'after_or_equal:tanggal_dari'],
        ], [
            'kelas_id.required'        => 'Kelas wajib dipilih.',
            'tanggal_dari.required'    => 'Tanggal mulai wajib diisi.',
            'tanggal_sampai.required'  => 'Tanggal akhir wajib diisi.',
            'tanggal_sampai.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',
        ]);

        // Pastikan kelas yang diminta adalah kelas yang diajar guru ini
        abort_unless($kelasIds->contains($request->kelas_id), 403, 'Anda tidak memiliki akses ke kelas ini.');

        $absensi = Absensi::with('siswa')
            ->where('kelas_id', $request->kelas_id)
            ->whereBetween('tanggal', [$request->tanggal_dari, $request->tanggal_sampai])
            ->get()
            ->groupBy('siswa_id');

        $kelas = \App\Models\Kelas::findOrFail($request->kelas_id);

        return view('guru.absensi.rekap', compact('absensi', 'kelas', 'kelasList', 'request'));
    }

    /**
     * Pastikan guru hanya bisa akses absensi kelas yang dia ajar.
     */
    private function authorizeAbsensi(Absensi $absensi): void
    {
        $guruId   = $this->getGuruId();
        $kelasIds = JadwalPelajaran::where('guru_id', $guruId)->pluck('kelas_id')->unique();
        abort_unless($kelasIds->contains($absensi->kelas_id), 403, 'Anda tidak memiliki akses ke data absensi ini.');
    }

    private function messages(): array
    {
        return [
            'siswa_id.required'   => 'Siswa wajib dipilih.',
            'siswa_id.exists'     => 'Siswa yang dipilih tidak valid.',
            'kelas_id.required'   => 'Kelas wajib dipilih.',
            'kelas_id.exists'     => 'Kelas yang dipilih tidak valid.',
            'tanggal.required'    => 'Tanggal absensi wajib diisi.',
            'tanggal.date'        => 'Format tanggal tidak valid.',
            'status.required'     => 'Status kehadiran wajib dipilih.',
            'status.in'           => 'Status kehadiran tidak valid.',
            'metode.in'           => 'Metode absensi tidak valid.',
            'jam_masuk.date_format'  => 'Format jam masuk harus HH:MM.',
            'jam_keluar.date_format' => 'Format jam keluar harus HH:MM.',
            'jam_keluar.after'       => 'Jam keluar harus setelah jam masuk.',
            'keterangan.max'         => 'Keterangan maksimal 500 karakter.',
            'path_surat_izin.mimes'  => 'Format surat izin harus PDF, JPG, JPEG, atau PNG.',
            'path_surat_izin.max'    => 'Ukuran surat izin maksimal 2MB.',
        ];
    }
}