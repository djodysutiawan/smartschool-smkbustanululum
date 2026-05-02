<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgendaSekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaSekolahController extends Controller
{
    // Daftar tipe yang HARUS sesuai dengan ENUM di database
    // Sesuaikan nilai ini dengan kolom `tipe` di tabel agenda_sekolah
    const TIPE_LIST = [
        'akademik'     => 'Akademik',
        'olahraga'     => 'Olahraga',
        'seni'         => 'Seni',
        'rapat'        => 'Rapat',
        'libur'        => 'Libur',
        'ujian'        => 'Ujian',
        'lainnya'      => 'Lainnya',
    ];

    public function index(Request $request)
    {
        $agenda = AgendaSekolah::query()
            ->when($request->search, fn($q) => $q->where('judul', 'like', "%{$request->search}%"))
            ->when($request->tipe,   fn($q) => $q->where('tipe', $request->tipe))
            ->when($request->status, fn($q) => match($request->status) {
                'published' => $q->where('is_published', true),
                'draft'     => $q->where('is_published', false),
                default     => $q
            })
            ->orderBy('tanggal_mulai')
            ->paginate(15)
            ->withQueryString();

        $tipeList = self::TIPE_LIST;

        return view('Admin.Agenda.index', compact('agenda', 'tipeList'));
    }

    public function create()
    {
        $tipeList = self::TIPE_LIST;
        return view('Admin.Agenda.create', compact('tipeList'));
    }

    public function store(Request $request)
    {
        $data = $this->validateAgenda($request);

        /** @var User $user */
        $user = Auth::user();
        $data['created_by'] = $user->id;

        AgendaSekolah::create($data);

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Agenda "' . $data['judul'] . '" berhasil ditambahkan.');
    }

    public function show(AgendaSekolah $agenda)
    {
        return view('Admin.Agenda.show', compact('agenda'));
    }

    public function edit(AgendaSekolah $agenda)
    {
        $tipeList = self::TIPE_LIST;
        return view('Admin.Agenda.edit', compact('agenda', 'tipeList'));
    }

    public function update(Request $request, AgendaSekolah $agenda)
    {
        $agenda->update($this->validateAgenda($request));

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Agenda "' . $agenda->judul . '" berhasil diperbarui.');
    }

    public function destroy(AgendaSekolah $agenda)
    {
        $nama = $agenda->judul;
        $agenda->delete();

        return redirect()->route('admin.agenda.index')
            ->with('success', 'Agenda "' . $nama . '" berhasil dihapus.');
    }

    public function togglePublish(AgendaSekolah $agenda)
    {
        $agenda->update(['is_published' => !$agenda->is_published]);
        $label = $agenda->is_published ? 'dipublikasikan' : 'disembunyikan';

        return back()->with('success', "Agenda \"{$agenda->judul}\" berhasil {$label}.");
    }

    public function kalender()
    {
        $agenda = AgendaSekolah::where('is_published', true)->get()->map(fn($a) => [
            'id'    => $a->id,
            'title' => $a->judul,
            'start' => \Carbon\Carbon::parse($a->tanggal_mulai)->toDateString(),
            'end'   => $a->tanggal_selesai
                        ? \Carbon\Carbon::parse($a->tanggal_selesai)->addDay()->toDateString()
                        : null,
            'color' => $a->warna ?? '#1f63db',
            'url'   => route('admin.agenda.show', $a),
        ]);

        return view('Admin.Agenda.kalender', compact('agenda'));
    }

    public function exportPdf()
    {
        return back()->with('info', 'Fitur export PDF segera hadir.');
    }

    public function exportExcel()
    {
        return back()->with('info', 'Fitur export Excel segera hadir.');
    }

    private function validateAgenda(Request $request): array
    {
        $tipeValues = implode(',', array_keys(self::TIPE_LIST));

        return $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'lokasi'          => 'nullable|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jam_mulai'       => 'nullable|date_format:H:i',
            'jam_selesai'     => 'nullable|date_format:H:i',
            'warna'           => 'nullable|string|max:30',
            // Validasi tipe sesuai nilai yang ada di ENUM database
            'tipe'            => 'nullable|in:' . $tipeValues,
            'is_published'    => 'boolean',
        ]);
    }
}