<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SliderBeranda;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SliderBerandaController extends Controller
{
    public function index()
    {
        $sliders = SliderBeranda::orderBy('urutan')->paginate(15);
        return view('Admin.Slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('Admin.Slider.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateSlider($request);

        /** @var User $user */
        $user = Auth::user();
        $data['created_by'] = $user->id;

        // Konversi checkbox boolean dengan benar
        $data['is_published'] = $request->boolean('is_published');

        $this->handleFoto($request, $data);
        SliderBeranda::create($data);

        return redirect()->route('admin.slider.index')
            ->with('success', 'Slider berhasil ditambahkan.');
    }

    public function edit(SliderBeranda $slider)
    {
        return view('Admin.Slider.edit', compact('slider'));
    }

    public function update(Request $request, SliderBeranda $slider)
    {
        $data = $this->validateSlider($request);

        // Konversi checkbox boolean dengan benar
        $data['is_published'] = $request->boolean('is_published');

        $this->handleFoto($request, $data, $slider);
        $slider->update($data);

        return redirect()->route('admin.slider.index')
            ->with('success', 'Slider "' . $slider->judul . '" berhasil diperbarui.');
    }

    public function destroy(SliderBeranda $slider)
    {
        if ($slider->foto_path) {
            // FIX: harus pakai disk 'public'
            Storage::disk('public')->delete($slider->foto_path);
        }
        $slider->delete();

        return redirect()->route('admin.slider.index')
            ->with('success', 'Slider berhasil dihapus.');
    }

    public function togglePublish(SliderBeranda $slider)
    {
        $slider->update(['is_published' => !$slider->is_published]);
        $label = $slider->is_published ? 'dipublikasikan' : 'disembunyikan';

        return back()->with('success', "Slider \"{$slider->judul}\" berhasil {$label}.");
    }

    public function reorder(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        foreach ($request->ids as $urutan => $id) {
            SliderBeranda::where('id', $id)->update(['urutan' => $urutan + 1]);
        }
        return response()->json(['success' => true]);
    }

    private function validateSlider(Request $request): array
    {
        return $request->validate([
            'judul'        => 'required|string|max:255',
            'subjudul'     => 'nullable|string|max:500',
            'foto_alt'     => 'nullable|string|max:255',
            'tombol_label' => 'nullable|string|max:50',
            'tombol_url'   => 'nullable|url|max:255',
            // FIX: nullable|boolean — checkbox tidak terkirim saat tidak dicentang
            'is_published' => 'nullable|boolean',
            'urutan'       => 'nullable|integer|min:0',
            'foto'         => 'nullable|image|max:3072',
            'foto_url'     => 'nullable|url|max:255',
        ]);
    }

    private function handleFoto(Request $request, array &$data, ?SliderBeranda $existing = null): void
    {
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($existing?->foto_path) {
                Storage::disk('public')->delete($existing->foto_path);
            }
            $data['foto_path'] = $request->file('foto')->store('slider', 'public');
            // FIX: hapus key 'foto' dari $data agar tidak masuk ke fillable
            unset($data['foto']);
            // FIX: jika upload file, kosongkan foto_url agar tidak konflik
            $data['foto_url'] = null;
        } elseif (!empty($data['foto_url'])) {
            // Jika user ganti ke URL, hapus foto_path lama
            if ($existing?->foto_path) {
                Storage::disk('public')->delete($existing->foto_path);
                $data['foto_path'] = null;
            }
            unset($data['foto']);
        } else {
            // Tidak ada perubahan foto — buang kedua key agar tidak overwrite
            unset($data['foto']);
            // Jangan overwrite foto_url yang sudah ada jika dikirim kosong
            if (isset($data['foto_url']) && $data['foto_url'] === null) {
                unset($data['foto_url']);
            }
        }
    }
}