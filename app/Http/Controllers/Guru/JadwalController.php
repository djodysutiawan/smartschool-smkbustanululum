<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
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

        $query = JadwalPelajaran::with(['mataPelajaran', 'kelas', 'ruang', 'tahunAjaran'])
            ->where('guru_id', $guruId);

        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $jadwal   = $query->orderBy('hari')->orderBy('jam_mulai')->get();
        $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

        // Kelompokkan per hari untuk tampilan tabel mingguan
        $jadwalPerHari = $jadwal->groupBy('hari');

        return view('guru.jadwal.index', compact('jadwal', 'jadwalPerHari', 'hariList'));
    }

    public function show(JadwalPelajaran $jadwal)
    {
        $guruId = $this->getGuruId();

        // Pastikan jadwal milik guru yang sedang login
        abort_if($jadwal->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke jadwal ini.');

        $jadwal->load(['mataPelajaran', 'kelas', 'ruang', 'tahunAjaran', 'guru']);

        return view('guru.jadwal.show', compact('jadwal'));
    }
}