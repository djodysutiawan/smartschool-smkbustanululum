<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => $this->getSettings(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'nama_sekolah'   => 'required|string|max:255',
                'alamat'         => 'nullable|string|max:500',
                'no_telp'        => 'nullable|string|max:20',
                'email'          => 'nullable|email|max:100',
                'website'        => 'nullable|url|max:255',
                'kepala_sekolah' => 'nullable|string|max:255',
                'npsn'           => 'nullable|string|max:20',
                'logo'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $current = $this->getSettings();

        if ($request->hasFile('logo')) {
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

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan berhasil disimpan.',
            'data'    => $updated,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PRIVATE HELPER — baca settings
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
    | PRIVATE HELPER — simpan settings
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