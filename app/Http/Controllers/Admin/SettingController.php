<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Konfigurasi path file settings
    |--------------------------------------------------------------------------
    */
    private string $settingsPath = 'settings/app.json';

    /*
    |--------------------------------------------------------------------------
    | INDEX — tampilkan halaman pengaturan
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        return view('admin.settings.index', [
            'settings' => $this->getSettings(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE — simpan pengaturan umum
    |--------------------------------------------------------------------------
    */
    public function update(Request $request)
    {
        $request->validate([
            'nama_sekolah'  => 'required|string|max:255',
            'alamat'        => 'nullable|string|max:500',
            'no_telp'       => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:100',
            'website'       => 'nullable|url|max:255',
            'kepala_sekolah'=> 'nullable|string|max:255',
            'npsn'          => 'nullable|string|max:20',
            'logo'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $current = $this->getSettings();

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if (! empty($current['logo'])) {
                Storage::disk('public')->delete($current['logo']);
            }
            $current['logo'] = $request->file('logo')->store('settings', 'public');
        }

        $updated = array_merge($current, $request->only([
            'nama_sekolah', 'alamat', 'no_telp',
            'email', 'website', 'kepala_sekolah', 'npsn',
        ]));

        $this->saveSettings($updated);

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | PRIVATE HELPER — baca settings dari storage
    |--------------------------------------------------------------------------
    */
    private function getSettings(): array
    {
        if (! Storage::disk('public')->exists($this->settingsPath)) {
            return [];
        }

        return json_decode(
            Storage::disk('public')->get($this->settingsPath),
            true
        ) ?? [];
    }

    /*
    |--------------------------------------------------------------------------
    | PRIVATE HELPER — simpan settings ke storage
    |--------------------------------------------------------------------------
    */
    private function saveSettings(array $data): void
    {
        Storage::disk('public')->put(
            $this->settingsPath,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }
}