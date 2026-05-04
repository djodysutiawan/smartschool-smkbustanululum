<?php
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PengumumanExport;
 
class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengumuman::with('dibuatOleh')->latest();
 
        if ($request->filled('target_role')) {
            $query->where('target_role', $request->target_role);
        }
        if ($request->filled('status_publikasi')) {
            if ($request->status_publikasi === 'dipublikasikan') {
                $query->whereNotNull('dipublikasikan_pada');
            } else {
                $query->whereNull('dipublikasikan_pada');
            }
        }
 
        $pengumuman = $query->paginate(20)->withQueryString();
 
        return view('admin.pengumuman.index', compact('pengumuman'));
    }
 
    public function create()
    {
        return view('admin.pengumuman.create');
    }
 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'               => ['required', 'string', 'max:255'],
            'isi'                 => ['required', 'string'],
            'target_role'         => ['required', 'string', 'in:semua,guru,siswa,orang_tua,guru_piket'],
            'kadaluarsa_pada'     => ['nullable', 'date', 'after:now'],
            'lampiran'            => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'dipinned'            => ['nullable', 'boolean'],
            'publikasikan_sekarang' => ['nullable', 'boolean'],
        ], [
            'judul.required'          => 'Judul pengumuman wajib diisi.',
            'judul.max'               => 'Judul maksimal 255 karakter.',
            'isi.required'            => 'Isi pengumuman wajib diisi.',
            'target_role.required'    => 'Target penerima wajib dipilih.',
            'target_role.in'          => 'Target penerima tidak valid.',
            'kadaluarsa_pada.date'    => 'Format tanggal kadaluarsa tidak valid.',
            'kadaluarsa_pada.after'   => 'Tanggal kadaluarsa harus setelah sekarang.',
            'lampiran.mimes'          => 'Format lampiran harus PDF, DOC, DOCX, JPG, atau PNG.',
            'lampiran.max'            => 'Ukuran lampiran maksimal 5 MB.',
            'dipublikasikan_pada' => $request->boolean('publikasikan_sekarang') ? now() : null,
            'dipublikasikan_oleh' => $request->boolean('publikasikan_sekarang') ? Auth::id() : null,
        ]);
 
        $pathLampiran = null;
        if ($request->hasFile('lampiran')) {
            $pathLampiran = $request->file('lampiran')->store('pengumuman/lampiran', 'public');
        }
 
        $pengumuman = Pengumuman::create([
            'judul'               => $validated['judul'],
            'isi'                 => $validated['isi'],
            'target_role'         => $validated['target_role'],
            'path_lampiran'       => $pathLampiran,
            'kadaluarsa_pada'     => $validated['kadaluarsa_pada'] ?? null,
            'dipinned'            => $request->boolean('dipinned'),
            'dibuat_oleh'         => Auth::id(),
            'dipublikasikan_pada' => $request->boolean('publikasikan_sekarang') ? now() : null,
        ]);
 
        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dibuat.');
    }
 
    public function show(Pengumuman $pengumuman)
    {
        $pengumuman->load('dibuatOleh');
        return view('admin.pengumuman.show', compact('pengumuman'));
    }
 
    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }
 
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul'           => ['required', 'string', 'max:255'],
            'isi'             => ['required', 'string'],
            'target_role'     => ['required', 'string', 'in:semua,guru,siswa,orang_tua,guru_piket'],
            'kadaluarsa_pada' => ['nullable', 'date'],
            'lampiran'        => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:5120'],
            'dipinned'        => ['nullable', 'boolean'],
        ], [
            'judul.required'       => 'Judul pengumuman wajib diisi.',
            'judul.max'            => 'Judul maksimal 255 karakter.',
            'isi.required'         => 'Isi pengumuman wajib diisi.',
            'target_role.required' => 'Target penerima wajib dipilih.',
            'target_role.in'       => 'Target penerima tidak valid.',
            'kadaluarsa_pada.date' => 'Format tanggal kadaluarsa tidak valid.',
            'lampiran.mimes'       => 'Format lampiran harus PDF, DOC, DOCX, JPG, atau PNG.',
            'lampiran.max'         => 'Ukuran lampiran maksimal 5 MB.',
        ]);
 
        if ($request->hasFile('lampiran')) {
            if ($pengumuman->path_lampiran) {
                Storage::disk('public')->delete($pengumuman->path_lampiran);
            }
            $validated['path_lampiran'] = $request->file('lampiran')->store('pengumuman/lampiran', 'public');
        }
 
        $pengumuman->update([
            'judul'           => $validated['judul'],
            'isi'             => $validated['isi'],
            'target_role'     => $validated['target_role'],
            'kadaluarsa_pada' => $validated['kadaluarsa_pada'] ?? null,
            'dipinned'        => $request->boolean('dipinned'),
            'path_lampiran'   => $validated['path_lampiran'] ?? $pengumuman->path_lampiran,
        ]);
 
        return redirect()->route('admin.pengumuman.show', $pengumuman)
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }
 
    public function destroy(Pengumuman $pengumuman)
    {
        if ($pengumuman->path_lampiran) {
            Storage::disk('public')->delete($pengumuman->path_lampiran);
        }
        $pengumuman->delete();
 
        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
 
    public function publish(Pengumuman $pengumuman)
    {
        $pengumuman->publish(Auth::id());
 
        return back()->with('success', 'Pengumuman berhasil dipublikasikan.');
    }
    // public function publish(Pengumuman $pengumuman)
    // {
    //     $pengumuman->update(['dipublikasikan_pada' => now()]);
 
    //     return back()->with('success', 'Pengumuman berhasil dipublikasikan.');
    // }
 
    public function unpublish(Pengumuman $pengumuman)
    {
        $pengumuman->update(['dipublikasikan_pada' => null]);
 
        return back()->with('success', 'Pengumuman berhasil ditarik dari publikasi.');
    }
 
    public function exportPdf(Request $request)
    {
        $query = Pengumuman::with('dibuatOleh')->latest();
 
        if ($request->filled('target_role')) {
            $query->where('target_role', $request->target_role);
        }
        if ($request->filled('status_publikasi')) {
            if ($request->status_publikasi === 'dipublikasikan') {
                $query->whereNotNull('dipublikasikan_pada');
            } else {
                $query->whereNull('dipublikasikan_pada');
            }
        }
 
        $pengumuman = $query->get();
 
        $pdf = Pdf::loadView('admin.pengumuman.export-pdf', compact('pengumuman'))
            ->setPaper('a4', 'landscape');
 
        return $pdf->download('pengumuman-' . now()->format('YmdHis') . '.pdf');
    }
 
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new PengumumanExport($request->all()),
            'pengumuman-' . now()->format('YmdHis') . '.xlsx'
        );
    }
}
 