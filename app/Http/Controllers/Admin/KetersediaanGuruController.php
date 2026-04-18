<?php

namespace App\Http\Controllers\Admin;

use App\Exports\KetersediaanGuruExport;
use App\Http\Controllers\Controller;
use App\Imports\KetersediaanGuruImport;
use App\Models\Guru;
use App\Models\KetersediaanGuru;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;

class KetersediaanGuruController extends Controller
{
    private const HARI_OPTIONS = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

    // ─── INDEX ───────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = KetersediaanGuru::with('guru');

        if ($request->filled('guru_id'))  $query->where('guru_id', $request->guru_id);
        if ($request->filled('hari'))     $query->where('hari', $request->hari);
        if ($request->filled('tersedia')) $query->where('tersedia', $request->boolean('tersedia'));

        $ketersediaan = $query
            ->orderBy('guru_id')
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->paginate(25)
            ->withQueryString();

        $gurus    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $hariList = self::HARI_OPTIONS;

        return view('admin.ketersediaan-guru.index', compact('ketersediaan', 'gurus', 'hariList'));
    }

    // ─── SHOW BY GURU ─────────────────────────────────────────────────────────────

    public function showByGuru(Guru $guru)
    {
        $ketersediaan = $guru->ketersediaan()
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        $hariList = self::HARI_OPTIONS;

        return view('admin.ketersediaan-guru.by-guru', compact('guru', 'ketersediaan', 'hariList'));
    }

    // ─── CREATE & STORE ───────────────────────────────────────────────────────────

    public function create()
    {
        $gurus    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $hariList = self::HARI_OPTIONS;

        return view('admin.ketersediaan-guru.create', compact('gurus', 'hariList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id'     => ['required', 'exists:guru,id'],
            'hari'        => ['required', Rule::in(self::HARI_OPTIONS)],
            'jam_mulai'   => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'tersedia'    => ['boolean'],
        ], $this->pesanValidasi());

        $exists = KetersediaanGuru::where('guru_id', $validated['guru_id'])
            ->where('hari', $validated['hari'])
            ->where('jam_mulai', $validated['jam_mulai'])
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->with('error', 'Slot ketersediaan untuk guru, hari, dan jam tersebut sudah ada.');
        }

        KetersediaanGuru::create($validated);

        return redirect()->route('admin.ketersediaan-guru.index')
            ->with('success', 'Ketersediaan guru berhasil ditambahkan.');
    }

    // ─── SHOW ─────────────────────────────────────────────────────────────────────

    public function show(KetersediaanGuru $ketersediaanGuru)
    {
        $ketersediaanGuru->load('guru');

        return view('admin.ketersediaan-guru.show', compact('ketersediaanGuru'));
    }

    // ─── EDIT & UPDATE ────────────────────────────────────────────────────────────

    public function edit(KetersediaanGuru $ketersediaanGuru)
    {
        $gurus    = Guru::aktif()->orderBy('nama_lengkap')->get();
        $hariList = self::HARI_OPTIONS;

        $ketersediaan = $ketersediaanGuru; // alias agar cocok dengan blade

        return view('admin.ketersediaan-guru.edit', compact('ketersediaan', 'gurus', 'hariList'));
    }

    public function update(Request $request, KetersediaanGuru $ketersediaanGuru)
    {
        $validated = $request->validate([
            'guru_id'     => ['required', 'exists:guru,id'],
            'hari'        => ['required', Rule::in(self::HARI_OPTIONS)],
            'jam_mulai'   => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'tersedia'    => ['boolean'],
        ], $this->pesanValidasi());

        $exists = KetersediaanGuru::where('guru_id', $validated['guru_id'])
            ->where('hari', $validated['hari'])
            ->where('jam_mulai', $validated['jam_mulai'])
            ->where('id', '!=', $ketersediaanGuru->id)
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->with('error', 'Slot ketersediaan untuk guru, hari, dan jam tersebut sudah ada.');
        }

        $ketersediaanGuru->update($validated);

        return redirect()->route('admin.ketersediaan-guru.index')
            ->with('success', 'Ketersediaan guru berhasil diperbarui.');
    }

    // ─── DESTROY ─────────────────────────────────────────────────────────────────

    public function destroy(KetersediaanGuru $ketersediaanGuru)
    {
        $ketersediaanGuru->delete();

        return back()->with('success', 'Ketersediaan guru berhasil dihapus.');
    }

    // ─── BULK STORE ──────────────────────────────────────────────────────────────

    public function bulkStore(Request $request, Guru $guru)
    {
        $request->validate([
            'slots'               => ['required', 'array', 'min:1'],
            'slots.*.hari'        => ['required', Rule::in(self::HARI_OPTIONS)],
            'slots.*.jam_mulai'   => ['required', 'date_format:H:i'],
            'slots.*.jam_selesai' => ['required', 'date_format:H:i'],
            'slots.*.tersedia'    => ['boolean'],
        ]);

        foreach ($request->slots as $index => $slot) {
            if (strtotime($slot['jam_selesai']) <= strtotime($slot['jam_mulai'])) {
                return back()->withInput()
                    ->with('error', 'Jam selesai pada slot ke-' . ($index + 1) . ' harus setelah jam mulai.');
            }
        }

        $guru->ketersediaan()->delete();

        $now     = now();
        $records = array_map(fn ($slot) => [
            'guru_id'     => $guru->id,
            'hari'        => $slot['hari'],
            'jam_mulai'   => $slot['jam_mulai'],
            'jam_selesai' => $slot['jam_selesai'],
            'tersedia'    => isset($slot['tersedia']) ? (bool) $slot['tersedia'] : true,
            'created_at'  => $now,
            'updated_at'  => $now,
        ], $request->slots);

        KetersediaanGuru::insert($records);

        return back()->with('success', 'Ketersediaan guru berhasil disimpan.');
    }

    // ─── TOGGLE ──────────────────────────────────────────────────────────────────

    public function toggle(KetersediaanGuru $ketersediaanGuru)
    {
        $ketersediaanGuru->update(['tersedia' => ! $ketersediaanGuru->tersedia]);
        $status = $ketersediaanGuru->tersedia ? 'tersedia' : 'tidak tersedia';

        return back()->with('success', "Slot ketersediaan berhasil diubah menjadi {$status}.");
    }

    // ─── EXPORT PDF ──────────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $query = KetersediaanGuru::with('guru');

        if ($request->filled('guru_id'))  $query->where('guru_id', $request->guru_id);
        if ($request->filled('hari'))     $query->where('hari', $request->hari);
        if ($request->filled('tersedia')) $query->where('tersedia', $request->boolean('tersedia'));

        $ketersediaan = $query
            ->orderBy('guru_id')
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai')
            ->get();

        $filterGuru = $request->filled('guru_id')
            ? optional(Guru::find($request->guru_id))->nama_lengkap
            : null;

        $pdf = Pdf::loadView('admin.ketersediaan-guru.pdf', compact('ketersediaan', 'filterGuru'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('data-ketersediaan-guru-' . now()->format('Ymd-His') . '.pdf');
    }

    // ─── EXPORT EXCEL ────────────────────────────────────────────────────────────

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new KetersediaanGuruExport($request->guru_id),
            'ketersediaan-guru-' . now()->format('Ymd-His') . '.xlsx'
        );
    }

    // ─── IMPORT ──────────────────────────────────────────────────────────────────

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:2048'],
        ], [
            'file.required' => 'File impor wajib diunggah.',
            'file.mimes'    => 'Format file harus xlsx, xls, atau csv.',
            'file.max'      => 'Ukuran file tidak boleh melebihi 2 MB.',
        ]);

        try {
            Excel::import(new KetersediaanGuruImport, $request->file('file'));
        } catch (ExcelValidationException $e) {
            $errors = collect($e->failures())->map(
                fn ($f) => "Baris {$f->row()}: " . implode(', ', $f->errors())
            )->implode(' | ');

            return back()->with('error', 'Import gagal: ' . $errors);
        } catch (\Throwable $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }

        return back()->with('success', 'Data ketersediaan guru berhasil diimpor.');
    }

    // ─── PRIVATE HELPERS ─────────────────────────────────────────────────────────

    private function pesanValidasi(): array
    {
        return [
            'guru_id.required'        => 'Guru wajib dipilih.',
            'guru_id.exists'          => 'Guru yang dipilih tidak ditemukan.',
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