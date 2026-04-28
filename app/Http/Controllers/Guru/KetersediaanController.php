<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\KetersediaanGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class KetersediaanController extends Controller
{
    private const HARI_OPTIONS = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

    private function getGuruId(): int
    {
        $guru = Auth::user()->guru;
        abort_if(! $guru, 403, 'Akun Anda tidak terhubung dengan data guru.');
        return $guru->id;
    }

    public function index(Request $request)
    {
        $guruId = $this->getGuruId();

        $ketersediaan = KetersediaanGuru::where('guru_id', $guruId)
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        $hariList = self::HARI_OPTIONS;

        return view('guru.ketersediaan.index', compact('ketersediaan', 'hariList'));
    }

    public function store(Request $request)
    {
        $guruId = $this->getGuruId();

        $validated = $request->validate([
            'hari'        => ['required', Rule::in(self::HARI_OPTIONS)],
            'jam_mulai'   => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'tersedia'    => ['boolean'],
        ], $this->pesanValidasi());

        $exists = KetersediaanGuru::where('guru_id', $guruId)
            ->where('hari', $validated['hari'])
            ->where('jam_mulai', $validated['jam_mulai'])
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->with('error', 'Slot ketersediaan untuk hari dan jam tersebut sudah ada.');
        }

        KetersediaanGuru::create([
            'guru_id'     => $guruId,
            'hari'        => $validated['hari'],
            'jam_mulai'   => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'tersedia'    => $validated['tersedia'] ?? true,
        ]);

        return back()->with('success', 'Ketersediaan berhasil ditambahkan.');
    }

    public function update(Request $request, KetersediaanGuru $ketersediaan)
    {
        $guruId = $this->getGuruId();
        abort_if($ketersediaan->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke data ini.');

        $validated = $request->validate([
            'hari'        => ['required', Rule::in(self::HARI_OPTIONS)],
            'jam_mulai'   => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'tersedia'    => ['boolean'],
        ], $this->pesanValidasi());

        $exists = KetersediaanGuru::where('guru_id', $guruId)
            ->where('hari', $validated['hari'])
            ->where('jam_mulai', $validated['jam_mulai'])
            ->where('id', '!=', $ketersediaan->id)
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->with('error', 'Slot ketersediaan untuk hari dan jam tersebut sudah ada.');
        }

        $ketersediaan->update($validated);

        return back()->with('success', 'Ketersediaan berhasil diperbarui.');
    }

    public function destroy(KetersediaanGuru $ketersediaan)
    {
        $guruId = $this->getGuruId();
        abort_if($ketersediaan->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke data ini.');

        $ketersediaan->delete();

        return back()->with('success', 'Ketersediaan berhasil dihapus.');
    }

    private function pesanValidasi(): array
    {
        return [
            'hari.required'           => 'Hari wajib dipilih.',
            'hari.in'                 => 'Hari yang dipilih tidak valid.',
            'jam_mulai.required'      => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format'   => 'Format jam mulai tidak valid. Gunakan format HH:MM.',
            'jam_selesai.required'    => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid. Gunakan format HH:MM.',
            'jam_selesai.after'       => 'Jam selesai harus setelah jam mulai.',
        ];
    }
}