<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\RiwayatScanQr;
use App\Models\SesiQr;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AbsensiController extends Controller
{
    private const STATUS_LIST = ['hadir', 'telat', 'izin', 'sakit', 'alfa'];
    private const METODE_LIST = ['manual', 'qr', 'qr_scan', 'wajah', 'rfid', 'import'];

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function getGuru(): \App\Models\Guru
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru;
    }

    private function getGuruId(): int
    {
        return $this->getGuru()->id;
    }

    /**
     * Ambil kelas_id yang diajar guru ini (di-cache di property untuk satu request).
     */
    private ?\Illuminate\Support\Collection $cachedKelasIds = null;

    private function getKelasIds(): \Illuminate\Support\Collection
    {
        if ($this->cachedKelasIds === null) {
            $this->cachedKelasIds = JadwalPelajaran::where('guru_id', $this->getGuruId())
                ->pluck('kelas_id')
                ->unique();
        }
        return $this->cachedKelasIds;
    }

    // ── INDEX ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $kelasIds = $this->getKelasIds();

        $query = Absensi::with(['siswa', 'kelas', 'jadwalPelajaran', 'dicatatOleh'])
            ->whereIn('kelas_id', $kelasIds);

        if ($request->filled('kelas_id'))       $query->where('kelas_id', $request->kelas_id);
        if ($request->filled('status'))         $query->where('status', $request->status);
        if ($request->filled('tanggal_dari'))   $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai')) $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        if ($request->filled('search')) {
            $query->whereHas('siswa', fn ($q) =>
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
            );
        }

        $absensi   = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();
        $kelasList = Kelas::aktif()->whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();
        $statusList = self::STATUS_LIST;

        // Rekap hari ini
        $baseToday = Absensi::whereIn('kelas_id', $kelasIds)->whereDate('tanggal', today());
        $rekap = [
            'hadir' => (clone $baseToday)->whereIn('status', ['hadir', 'telat'])->count(),
            'izin'  => (clone $baseToday)->where('status', 'izin')->count(),
            'sakit' => (clone $baseToday)->where('status', 'sakit')->count(),
            'alfa'  => (clone $baseToday)->where('status', 'alfa')->count(),
        ];

        return view('guru.absensi.index', compact('absensi', 'kelasList', 'rekap', 'statusList'));
    }

    // ── CREATE (massal per kelas) ─────────────────────────────────────────────

    public function create(Request $request)
    {
        $guruId   = $this->getGuruId();
        $kelasIds = $this->getKelasIds();

        $kelasList = Kelas::aktif()->whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();

        // Jadwal difilter per kelas jika kelas sudah dipilih, agar relevan
        $jadwalQuery = JadwalPelajaran::aktif()
            ->with(['mataPelajaran', 'kelas'])
            ->where('guru_id', $guruId);

        if ($request->filled('kelas_id')) {
            $jadwalQuery->where('kelas_id', $request->kelas_id);
        }

        $jadwalList = $jadwalQuery->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get();

        $siswaList = collect();
        if ($request->filled('kelas_id')) {
            abort_unless($kelasIds->contains($request->kelas_id), 403, 'Anda tidak memiliki akses ke kelas ini.');
            $siswaList = Siswa::aktif()
                ->where('kelas_id', $request->kelas_id)
                ->orderBy('nama_lengkap')
                ->get();
        }

        $statusList = self::STATUS_LIST;

        return view('guru.absensi.create', compact('kelasList', 'jadwalList', 'siswaList', 'statusList'));
    }

    // ── STORE (satu siswa) ────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $kelasIds = $this->getKelasIds();

        $validated = $request->validate([
            'siswa_id'            => ['required', 'exists:siswa,id'],
            'kelas_id'            => ['required', 'exists:kelas,id'],
            'jadwal_pelajaran_id' => ['nullable', 'exists:jadwal_pelajaran,id'],
            'tanggal'             => ['required', 'date', 'before_or_equal:today'],
            'status'              => ['required', Rule::in(self::STATUS_LIST)],
            'metode'              => ['nullable', Rule::in(self::METODE_LIST)],
            'jam_masuk'           => ['nullable', 'date_format:H:i'],
            'jam_keluar'          => ['nullable', 'date_format:H:i', 'after:jam_masuk'],
            'keterangan'          => ['nullable', 'string', 'max:500'],
            'path_surat_izin'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ], $this->messages());

        abort_unless($kelasIds->contains($validated['kelas_id']), 403, 'Anda tidak memiliki akses ke kelas ini.');

        // Validasi siswa terdaftar di kelas tersebut
        $siswa = Siswa::findOrFail($validated['siswa_id']);
        if ($siswa->kelas_id !== (int) $validated['kelas_id']) {
            return back()->withInput()
                ->with('error', 'Siswa tidak terdaftar di kelas yang dipilih.');
        }

        // Cek duplikat (per siswa, kelas, tanggal, jadwal)
        $duplikatQuery = Absensi::where('siswa_id', $validated['siswa_id'])
            ->where('kelas_id', $validated['kelas_id'])
            ->whereDate('tanggal', $validated['tanggal']);

        if (! empty($validated['jadwal_pelajaran_id'])) {
            $duplikatQuery->where('jadwal_pelajaran_id', $validated['jadwal_pelajaran_id']);
        }

        if ($duplikatQuery->exists()) {
            return back()->withInput()
                ->with('error', 'Siswa ini sudah memiliki data absensi pada tanggal dan jadwal tersebut.');
        }

        if ($request->hasFile('path_surat_izin')) {
            $validated['path_surat_izin'] = $request->file('path_surat_izin')
                ->store('absensi/surat_izin', 'public');
        }

        $validated['dicatat_oleh'] = Auth::id();
        $validated['metode']       = $validated['metode'] ?? 'manual';

        Absensi::create($validated);

        return redirect()->route('guru.absensi.index')
            ->with('success', 'Data absensi berhasil ditambahkan.');
    }

    // ── STORE MASSAL ──────────────────────────────────────────────────────────

    public function storeMassal(Request $request)
    {
        $kelasIds = $this->getKelasIds();

        $request->validate([
            'kelas_id'            => ['required', 'exists:kelas,id'],
            'tanggal'             => ['required', 'date', 'before_or_equal:today'],
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
            'tanggal.before_or_equal'   => 'Tanggal tidak boleh melebihi hari ini.',
            'siswa.required'            => 'Tidak ada data siswa yang dikirim.',
            'siswa.*.siswa_id.required' => 'Data siswa tidak valid.',
            'siswa.*.status.required'   => 'Status kehadiran wajib dipilih untuk setiap siswa.',
            'siswa.*.status.in'         => 'Status kehadiran tidak valid.',
        ]);

        abort_unless($kelasIds->contains($request->kelas_id), 403, 'Anda tidak memiliki akses ke kelas ini.');

        $dicatatOleh       = Auth::id();
        $tanggal           = $request->tanggal;
        $kelasId           = (int) $request->kelas_id;
        $jadwalPelajaranId = $request->jadwal_pelajaran_id ?: null;
        // file() bisa null jika tidak ada upload sama sekali
        $suratFiles        = $request->hasFile('surat') ? $request->file('surat') : [];
        $created           = 0;
        $skipped           = 0;

        foreach ($request->siswa as $item) {
            $siswaId = (int) $item['siswa_id'];

            // Cek duplikat per siswa+kelas+tanggal+jadwal
            $duplikatQuery = Absensi::where('siswa_id', $siswaId)
                ->where('kelas_id', $kelasId)
                ->whereDate('tanggal', $tanggal);

            if ($jadwalPelajaranId) {
                $duplikatQuery->where('jadwal_pelajaran_id', $jadwalPelajaranId);
            }

            if ($duplikatQuery->exists()) {
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
                'jam_masuk'           => $item['jam_masuk']  ?? null,
                'jam_keluar'          => $item['jam_keluar'] ?? null,
                'keterangan'          => isset($item['keterangan']) && $item['keterangan'] !== '' ? $item['keterangan'] : null,
                'dicatat_oleh'        => $dicatatOleh,
            ];

            // Upload surat izin jika ada (key berdasarkan siswa_id)
            if (isset($suratFiles[$siswaId]) && is_object($suratFiles[$siswaId]) && $suratFiles[$siswaId]->isValid()) {
                $data['path_surat_izin'] = $suratFiles[$siswaId]
                    ->store('absensi/surat_izin', 'public');
            }

            Absensi::create($data);
            $created++;
        }

        $msg = "Absensi {$created} siswa berhasil disimpan.";
        if ($skipped > 0) {
            $msg .= " {$skipped} siswa dilewati karena sudah memiliki absensi pada tanggal ini.";
        }

        return redirect()->route('guru.absensi.index')->with('success', $msg);
    }

    // ── SHOW ──────────────────────────────────────────────────────────────────

    public function show(Absensi $absensi)
    {
        $this->authorizeAbsensi($absensi);
        $absensi->load(['siswa', 'kelas', 'jadwalPelajaran.mataPelajaran', 'dicatatOleh']);
        return view('guru.absensi.show', compact('absensi'));
    }

    // ── EDIT ──────────────────────────────────────────────────────────────────

    public function edit(Absensi $absensi)
    {
        $guruId   = $this->getGuruId();
        $kelasIds = $this->getKelasIds();
        $this->authorizeAbsensi($absensi);

        $kelasList  = Kelas::aktif()->whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();
        $siswaList  = Siswa::aktif()->where('kelas_id', $absensi->kelas_id)->orderBy('nama_lengkap')->get();
        $jadwalList = JadwalPelajaran::aktif()
            ->with(['mataPelajaran', 'kelas'])
            ->where('guru_id', $guruId)
            ->where('kelas_id', $absensi->kelas_id)
            ->get();
        $statusList = self::STATUS_LIST;
        // FIX: $metodeList was missing — now passed to view
        $metodeList = self::METODE_LIST;

        $absensi->load(['siswa', 'kelas', 'jadwalPelajaran.mataPelajaran']);

        return view('guru.absensi.edit',
            compact('absensi', 'kelasList', 'siswaList', 'jadwalList', 'statusList', 'metodeList'));
    }

    // ── UPDATE ────────────────────────────────────────────────────────────────

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
            // Hapus file lama jika ada
            if ($absensi->path_surat_izin) {
                Storage::disk('public')->delete($absensi->path_surat_izin);
            }
            $validated['path_surat_izin'] = $request->file('path_surat_izin')
                ->store('absensi/surat_izin', 'public');
        }

        $absensi->update($validated);

        return redirect()->route('guru.absensi.show', $absensi)
            ->with('success', 'Data absensi berhasil diperbarui.');
    }

    // ── DESTROY ───────────────────────────────────────────────────────────────

    public function destroy(Absensi $absensi)
    {
        $this->authorizeAbsensi($absensi);

        if ($absensi->path_surat_izin) {
            Storage::disk('public')->delete($absensi->path_surat_izin);
        }

        $absensi->delete();

        return redirect()->route('guru.absensi.index')
            ->with('success', 'Data absensi berhasil dihapus.');
    }

    // ── REKAP ─────────────────────────────────────────────────────────────────

    public function rekap(Request $request)
    {
        $kelasIds  = $this->getKelasIds();
        $kelasList = Kelas::aktif()->whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();

        // Jika kelas_id belum dipilih, tampilkan form kosong
        if (! $request->filled('kelas_id')) {
            return view('guru.absensi.rekap', [
                'absensi'   => null,
                'kelas'     => null,
                'kelasList' => $kelasList,
                'request'   => $request,
            ]);
        }

        // Validasi filter lengkap
        $request->validate([
            'kelas_id'       => ['required', 'exists:kelas,id'],
            'tanggal_dari'   => ['required', 'date'],
            'tanggal_sampai' => ['required', 'date', 'after_or_equal:tanggal_dari'],
        ], [
            'kelas_id.required'             => 'Kelas wajib dipilih.',
            'tanggal_dari.required'         => 'Tanggal dari wajib diisi.',
            'tanggal_sampai.required'       => 'Tanggal sampai wajib diisi.',
            'tanggal_sampai.after_or_equal' => 'Tanggal sampai harus sama atau setelah tanggal dari.',
        ]);

        abort_unless($kelasIds->contains($request->kelas_id), 403, 'Anda tidak memiliki akses ke kelas ini.');

        $absensi = Absensi::with('siswa')
            ->where('kelas_id', $request->kelas_id)
            ->whereBetween('tanggal', [$request->tanggal_dari, $request->tanggal_sampai])
            ->orderBy('tanggal')
            ->get()
            ->groupBy('siswa_id');

        $kelas = Kelas::findOrFail($request->kelas_id);

        return view('guru.absensi.rekap', compact('absensi', 'kelas', 'kelasList', 'request'));
    }

    // ── JADWAL: Daftar jadwal + status sesi QR hari ini ──────────────────────

    public function jadwal(Request $request)
    {
        $guruId = $this->getGuruId();
        $user   = Auth::user();

        $hariIndo = [
            'Sunday'    => 'minggu',
            'Monday'    => 'senin',
            'Tuesday'   => 'selasa',
            'Wednesday' => 'rabu',
            'Thursday'  => 'kamis',
            'Friday'    => 'jumat',
            'Saturday'  => 'sabtu',
        ];
        $hariIni = $hariIndo[now()->format('l')] ?? 'senin';

        $jadwalList = JadwalPelajaran::with(['mataPelajaran', 'kelas', 'ruang'])
            ->where('guru_id', $guruId)
            ->where('is_active', true)
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get();

        // Sesi QR hari ini milik guru ini (index by jadwal_pelajaran_id)
        $sesiHariIni = SesiQr::where('dibuat_oleh', $user->id)
            ->whereDate('tanggal', today())
            ->with(['kelas', 'mataPelajaran'])
            ->get()
            ->keyBy('jadwal_pelajaran_id');

        $jadwalHariIni = $jadwalList->where('hari', $hariIni);
        $jadwalPerHari = $jadwalList->groupBy('hari');
        $hariList      = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

        return view('guru.absensi.jadwal', compact(
            'jadwalList',
            'jadwalHariIni',
            'jadwalPerHari',
            'sesiHariIni',
            'hariIni',
            'hariList',
        ));
    }

    // ── SCAN QR: Halaman kamera / input token ────────────────────────────────

    public function scan(Request $request)
    {
        $user = Auth::user();

        $sesiAktif = SesiQr::where('dibuat_oleh', $user->id)
            ->whereDate('tanggal', today())
            ->where('is_active', true)
            ->with(['kelas', 'mataPelajaran'])
            ->get();

        return view('guru.absensi.scan', compact('sesiAktif'));
    }

    /**
     * Proses scan QR oleh guru.
     *
     * Form mengirimkan:
     *   - sesi_qr_id : ID sesi QR yang dipilih (wajib dipilih dari dropdown)
     *   - siswa_kode  : NIS atau kode barcode siswa (format "SISWA-{id}" atau NIS langsung)
     *
     * PERBAIKAN: Pisahkan pencarian SesiQr dan pencarian Siswa.
     * kode_qr pada SesiQr adalah UUID — bukan identitas siswa.
     */
    public function prosesScan(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'sesi_qr_id' => ['required', 'exists:sesi_qr,id'],
            'siswa_kode'  => ['required', 'string', 'max:100'],
        ], [
            'sesi_qr_id.required' => 'Sesi QR wajib dipilih.',
            'sesi_qr_id.exists'   => 'Sesi QR tidak ditemukan.',
            'siswa_kode.required' => 'Kode barcode siswa wajib diisi.',
        ]);

        $siswaKode = trim($request->siswa_kode);

        // ── Cari sesi QR berdasarkan ID (hanya milik guru ini) ───────────────
        $sesiQr = SesiQr::where('id', $request->sesi_qr_id)
            ->where('dibuat_oleh', $user->id)
            ->first();

        if (! $sesiQr) {
            return back()->withInput()
                ->with('error', 'Sesi QR tidak ditemukan atau bukan milik Anda.');
        }

        // ── Validasi sesi aktif & belum kadaluarsa ───────────────────────────
        if (! $sesiQr->is_active) {
            return back()->withInput()
                ->with('error', 'Sesi QR sudah tidak aktif.');
        }

        if ($sesiQr->isKadaluarsa()) {
            return back()->withInput()
                ->with('error', 'Sesi QR sudah kadaluarsa pada ' . $sesiQr->kadaluarsa_pada->format('H:i') . '.');
        }

        // ── Cari siswa berdasarkan kode barcode ──────────────────────────────
        // Format barcode siswa: "SISWA-{siswa_id}" atau NIS langsung
        $siswa = null;
        if (str_starts_with($siswaKode, 'SISWA-')) {
            $siswaId = (int) str_replace('SISWA-', '', $siswaKode);
            $siswa   = Siswa::find($siswaId);
        }

        // Fallback: cari berdasarkan NIS
        if (! $siswa) {
            $siswa = Siswa::where('nis', $siswaKode)->first();
        }

        if (! $siswa) {
            return back()->withInput()
                ->with('error', "Siswa dengan kode '{$siswaKode}' tidak ditemukan.");
        }

        // ── Validasi siswa terdaftar di kelas sesi ────────────────────────────
        if ($siswa->kelas_id !== $sesiQr->kelas_id) {
            return back()->withInput()
                ->with('error', "Siswa {$siswa->nama_lengkap} tidak terdaftar di kelas sesi QR ini.");
        }

        // ── Cek duplikat scan valid pada sesi ini ─────────────────────────────
        $sudahScan = RiwayatScanQr::where('sesi_qr_id', $sesiQr->id)
            ->where('siswa_id', $siswa->id)
            ->where('status', RiwayatScanQr::STATUS_VALID)
            ->exists();

        if ($sudahScan) {
            return back()->withInput()
                ->with('error', "Siswa {$siswa->nama_lengkap} sudah tercatat hadir di sesi ini.");
        }

        // ── Catat riwayat scan ────────────────────────────────────────────────
        RiwayatScanQr::create([
            'sesi_qr_id'   => $sesiQr->id,
            'siswa_id'     => $siswa->id,
            'status'       => RiwayatScanQr::STATUS_VALID,
            'hasil'        => 'berhasil',
            'di_scan_pada' => now(),
            'ip_address'   => $request->ip(),
            'user_agent'   => $request->userAgent(),
        ]);

        // ── Buat absensi jika belum ada ───────────────────────────────────────
        // Cek berdasarkan siswa + tanggal + (jadwal atau sesi_qr)
        $sudahAbsen = false;
        if ($sesiQr->jadwal_pelajaran_id) {
            $sudahAbsen = Absensi::where('siswa_id', $siswa->id)
                ->whereDate('tanggal', $sesiQr->tanggal->toDateString())
                ->where('jadwal_pelajaran_id', $sesiQr->jadwal_pelajaran_id)
                ->exists();
        } else {
            $sudahAbsen = Absensi::where('siswa_id', $siswa->id)
                ->whereDate('tanggal', $sesiQr->tanggal->toDateString())
                ->where('sesi_qr_id', $sesiQr->id)
                ->exists();
        }

        if (! $sudahAbsen) {
            // Tentukan status: telat jika scan > jam_mulai + toleransi 15 menit
            $toleransiMenit = 15;
            $status = now()->gt($sesiQr->berlaku_mulai->copy()->addMinutes($toleransiMenit))
                ? 'telat'
                : 'hadir';

            Absensi::create([
                'siswa_id'            => $siswa->id,
                'kelas_id'            => $sesiQr->kelas_id,
                'mata_pelajaran_id'   => $sesiQr->mata_pelajaran_id,
                'jadwal_pelajaran_id' => $sesiQr->jadwal_pelajaran_id,
                'sesi_qr_id'          => $sesiQr->id,
                'dicatat_oleh'        => $user->id,
                'tanggal'             => $sesiQr->tanggal,
                'jam_masuk'           => now()->format('H:i'),
                'status'              => $status,
                'metode'              => 'qr',
            ]);
        }

        return back()->with('success', "✓ {$siswa->nama_lengkap} berhasil dicatat " . ($sudahAbsen ? '(riwayat scan ditambahkan)' : 'hadir') . '.');
    }

    // ── HELPER: Otorisasi absensi ─────────────────────────────────────────────

    private function authorizeAbsensi(Absensi $absensi): void
    {
        abort_unless(
            $this->getKelasIds()->contains($absensi->kelas_id),
            403,
            'Anda tidak memiliki akses ke data absensi ini.'
        );
    }

    // ── Pesan validasi ────────────────────────────────────────────────────────

    private function messages(): array
    {
        return [
            'siswa_id.required'          => 'Siswa wajib dipilih.',
            'siswa_id.exists'            => 'Siswa yang dipilih tidak valid.',
            'kelas_id.required'          => 'Kelas wajib dipilih.',
            'kelas_id.exists'            => 'Kelas yang dipilih tidak valid.',
            'tanggal.required'           => 'Tanggal absensi wajib diisi.',
            'tanggal.date'               => 'Format tanggal tidak valid.',
            'tanggal.before_or_equal'    => 'Tanggal tidak boleh melebihi hari ini.',
            'status.required'            => 'Status kehadiran wajib dipilih.',
            'status.in'                  => 'Status kehadiran tidak valid.',
            'metode.in'                  => 'Metode absensi tidak valid.',
            'jam_masuk.date_format'      => 'Format jam masuk harus HH:MM.',
            'jam_keluar.date_format'     => 'Format jam keluar harus HH:MM.',
            'jam_keluar.after'           => 'Jam keluar harus setelah jam masuk.',
            'keterangan.max'             => 'Keterangan maksimal 500 karakter.',
            'path_surat_izin.mimes'      => 'Format surat izin harus PDF, JPG, JPEG, atau PNG.',
            'path_surat_izin.max'        => 'Ukuran surat izin maksimal 2MB.',
        ];
    }
}