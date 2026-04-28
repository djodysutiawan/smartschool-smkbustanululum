<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\SesiQr;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiQrController extends Controller
{
    private function getGuruId(): int
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru->id;
    }

    public function index(Request $request)
    {
        $guruId = $this->getGuruId();

        $query = SesiQr::with(['kelas', 'mataPelajaran'])
            ->where('dibuat_oleh', Auth::id());

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $sesiQrs   = $query->latest()->paginate(15)->withQueryString();

        // Kelas yang diajar guru ini
        $kelasIds  = \App\Models\JadwalPelajaran::where('guru_id', $guruId)->pluck('kelas_id')->unique();
        $kelasList = Kelas::aktif()->whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();

        return view('guru.sesi-qr.index', compact('sesiQrs', 'kelasList'));
    }

    public function create()
    {
        $guruId = $this->getGuruId();

        $kelasIds      = \App\Models\JadwalPelajaran::where('guru_id', $guruId)->pluck('kelas_id')->unique();
        $kelasList     = Kelas::aktif()->whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();
        $mataPelajaran = MataPelajaran::aktif()->orderBy('nama_mapel')->get();

        return view('guru.sesi-qr.create', compact('kelasList', 'mataPelajaran'));
    }

    public function store(Request $request)
    {
        $guruId = $this->getGuruId();

        $validated = $request->validate([
            'kelas_id'          => ['required', 'exists:kelas,id'],
            'mata_pelajaran_id' => ['nullable', 'exists:mata_pelajaran,id'],
            'tanggal'           => ['required', 'date'],
            'berlaku_mulai'     => ['required', 'date'],
            'kadaluarsa_pada'   => ['required', 'date', 'after:berlaku_mulai'],
            'radius_meter'      => ['nullable', 'integer', 'min:10', 'max:1000'],
        ], [
            'kelas_id.required'       => 'Kelas wajib dipilih.',
            'kelas_id.exists'         => 'Kelas yang dipilih tidak valid.',
            'tanggal.required'        => 'Tanggal wajib diisi.',
            'tanggal.date'            => 'Format tanggal tidak valid.',
            'berlaku_mulai.required'  => 'Waktu berlaku wajib diisi.',
            'kadaluarsa_pada.required' => 'Waktu kadaluarsa wajib diisi.',
            'kadaluarsa_pada.after'   => 'Waktu kadaluarsa harus setelah waktu berlaku.',
            'radius_meter.min'        => 'Radius minimal 10 meter.',
            'radius_meter.max'        => 'Radius maksimal 1000 meter.',
        ]);

        // Pastikan kelas yang dipilih adalah kelas yang diajar guru ini
        $kelasIds = \App\Models\JadwalPelajaran::where('guru_id', $guruId)->pluck('kelas_id')->unique();
        abort_unless($kelasIds->contains($validated['kelas_id']), 403, 'Anda tidak mengajar kelas yang dipilih.');

        // kode_qr di-generate otomatis oleh SesiQr::booted()
        $validated['dibuat_oleh'] = Auth::id();

        SesiQr::create($validated);

        return redirect()->route('guru.sesi-qr.index')
            ->with('success', 'Sesi QR berhasil dibuat.');
    }

    public function show(SesiQr $sesiQr)
    {
        $this->authorizeSesiQr($sesiQr);

        $sesiQr->load([
            'kelas',
            'mataPelajaran',
            'riwayatScan.siswa',
        ]);

        return view('guru.sesi-qr.show', compact('sesiQr'));
    }

    public function destroy(SesiQr $sesiQr)
    {
        $this->authorizeSesiQr($sesiQr);

        $sesiQr->delete();

        return redirect()->route('guru.sesi-qr.index')
            ->with('success', 'Sesi QR berhasil dihapus.');
    }

    public function nonaktifkan(SesiQr $sesiQr)
    {
        $this->authorizeSesiQr($sesiQr);

        $sesiQr->nonaktifkan();

        return back()->with('success', 'Sesi QR berhasil dinonaktifkan.');
    }

    /**
     * Cetak QR code ke PDF untuk ditempel di kelas.
     */
    public function cetakQr(SesiQr $sesiQr)
    {
        $this->authorizeSesiQr($sesiQr);

        $sesiQr->load(['kelas', 'mataPelajaran']);

        $pdf = Pdf::loadView('guru.sesi-qr.exports.cetak-qr', compact('sesiQr'))
            ->setPaper('a5', 'portrait');

        return $pdf->stream('qr_sesi_' . $sesiQr->id . '_' . $sesiQr->tanggal->format('Ymd') . '.pdf');
    }

    /**
     * Pastikan sesi QR dibuat oleh guru yang sedang login.
     */
    private function authorizeSesiQr(SesiQr $sesiQr): void
    {
        abort_if($sesiQr->dibuat_oleh !== Auth::id(), 403, 'Anda tidak memiliki akses ke sesi QR ini.');
    }
}