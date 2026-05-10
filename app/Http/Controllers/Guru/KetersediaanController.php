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
        return (int) $guru->id;
    }

    public function index(Request $request)
    {
        $guruId = $this->getGuruId();

        $rows = KetersediaanGuru::where('guru_id', $guruId)
            ->orderBy('jam_mulai')
            ->get();

        $grouped = $rows->groupBy('hari');

        $ketersediaan = collect(self::HARI_OPTIONS)->mapWithKeys(
            fn ($hari) => [$hari => $grouped->get($hari, collect())]
        );

        $stats = [
            'total'      => $rows->count(),
            'tersedia'   => $rows->where('tersedia', true)->count(),
            'tidak'      => $rows->where('tersedia', false)->count(),
            'hari_diisi' => $rows->pluck('hari')->unique()->count(),
        ];

        $adaSlot = $rows->isNotEmpty();

        return view('guru.ketersediaan.index', [
            'ketersediaan' => $ketersediaan,
            'hariList'     => self::HARI_OPTIONS,
            'stats'        => $stats,
            'adaSlot'      => $adaSlot,
        ]);
    }

    public function store(Request $request)
    {
        $guruId   = $this->getGuruId();
        $tersedia = $request->boolean('tersedia');

        $validated = $request->validate([
            'hari'        => ['required', Rule::in(self::HARI_OPTIONS)],
            'jam_mulai'   => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
        ], $this->pesanValidasi());

        // Cek duplikat jam_mulai di hari yang sama
        $exists = KetersediaanGuru::where('guru_id', $guruId)
            ->where('hari', $validated['hari'])
            ->where('jam_mulai', $validated['jam_mulai'])
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->with('error', 'Slot ketersediaan untuk hari dan jam mulai tersebut sudah ada.');
        }

        // Cek overlap waktu
        $overlap = KetersediaanGuru::where('guru_id', $guruId)
            ->where('hari', $validated['hari'])
            ->where('jam_mulai', '<', $validated['jam_selesai'])
            ->where('jam_selesai', '>', $validated['jam_mulai'])
            ->exists();

        if ($overlap) {
            return back()->withInput()
                ->with('error', 'Slot ini bertumpang tindih dengan slot yang sudah ada di hari ' . ucfirst($validated['hari']) . '.');
        }

        KetersediaanGuru::create([
            'guru_id'     => $guruId,
            'hari'        => $validated['hari'],
            'jam_mulai'   => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'tersedia'    => $tersedia,
        ]);

        return back()->with('success', 'Slot ketersediaan berhasil ditambahkan.');
    }

    public function update(Request $request, KetersediaanGuru $ketersediaan)
    {
        $guruId = $this->getGuruId();
        abort_if($ketersediaan->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke data ini.');

        $tersedia = $request->boolean('tersedia');

        $validated = $request->validate([
            'hari'        => ['required', Rule::in(self::HARI_OPTIONS)],
            'jam_mulai'   => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
        ], $this->pesanValidasi());

        // Cek duplikat, kecualikan record ini
        $exists = KetersediaanGuru::where('guru_id', $guruId)
            ->where('hari', $validated['hari'])
            ->where('jam_mulai', $validated['jam_mulai'])
            ->where('id', '!=', $ketersediaan->id)
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->with('error', 'Slot ketersediaan untuk hari dan jam mulai tersebut sudah ada.');
        }

        // Cek overlap, kecualikan record ini
        $overlap = KetersediaanGuru::where('guru_id', $guruId)
            ->where('hari', $validated['hari'])
            ->where('id', '!=', $ketersediaan->id)
            ->where('jam_mulai', '<', $validated['jam_selesai'])
            ->where('jam_selesai', '>', $validated['jam_mulai'])
            ->exists();

        if ($overlap) {
            return back()->withInput()
                ->with('error', 'Slot ini bertumpang tindih dengan slot yang sudah ada di hari ' . ucfirst($validated['hari']) . '.');
        }

        $ketersediaan->update([
            'hari'        => $validated['hari'],
            'jam_mulai'   => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'tersedia'    => $tersedia,
        ]);

        return back()->with('success', 'Slot ketersediaan berhasil diperbarui.');
    }

    public function destroy(KetersediaanGuru $ketersediaan)
    {
        $guruId = $this->getGuruId();
        abort_if($ketersediaan->guru_id !== $guruId, 403, 'Anda tidak memiliki akses ke data ini.');

        $ketersediaan->delete();

        return back()->with('success', 'Slot ketersediaan berhasil dihapus.');
    }

    private function pesanValidasi(): array
    {
        return [
            'hari.required'           => 'Hari wajib dipilih.',
            'hari.in'                 => 'Hari yang dipilih tidak valid.',
            'jam_mulai.required'      => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format'   => 'Format jam mulai tidak valid (HH:MM).',
            'jam_selesai.required'    => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid (HH:MM).',
            'jam_selesai.after'       => 'Jam selesai harus setelah jam mulai.',
        ];
    }
}