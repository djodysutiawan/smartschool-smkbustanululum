<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilSekolahController extends Controller
{
    /**
     * GET /admin/profil-sekolah/edit
     */
    public function edit()
    {
        $profil = ProfilSekolah::instance();
        return view('Admin.ProfilSekolah.edit', compact('profil'));
    }

    /**
     * PUT /admin/profil-sekolah
     */
    public function update(Request $request)
    {
        $profil = ProfilSekolah::instance();

        $validated = $request->validate([
            // Identitas — nama_sekolah nullable agar tidak error saat row baru dibuat
            'nama_sekolah'      => 'nullable|string|max:255',
            'singkatan'         => 'nullable|string|max:50',
            'npsn'              => 'nullable|string|max:20',
            'nss'               => 'nullable|string|max:30',
            'akreditasi'        => 'nullable|string|max:5',
            'tahun_berdiri'     => 'nullable|integer|min:1900|max:' . date('Y'),
            'status_sekolah'    => 'nullable|in:negeri,swasta',
            'jenjang'           => 'nullable|string|max:20',
            // Alamat
            'alamat_lengkap'    => 'nullable|string',
            'desa_kelurahan'    => 'nullable|string|max:100',
            'kecamatan'         => 'nullable|string|max:100',
            'kabupaten_kota'    => 'nullable|string|max:100',
            'provinsi'          => 'nullable|string|max:100',
            'kode_pos'          => 'nullable|string|max:10',
            'latitude'          => 'nullable|numeric|between:-90,90',
            'longitude'         => 'nullable|numeric|between:-180,180',
            'embed_maps_url'    => 'nullable|url|max:2000',
            // Kontak
            'telepon'           => 'nullable|string|max:20',
            'whatsapp'          => 'nullable|string|max:20',
            'fax'               => 'nullable|string|max:20',
            'email_sekolah'     => 'nullable|email|max:100',
            'website'           => 'nullable|url|max:255',
            // Sosmed
            'facebook_url'      => 'nullable|url|max:255',
            'instagram_url'     => 'nullable|url|max:255',
            'twitter_url'       => 'nullable|url|max:255',
            'youtube_url'       => 'nullable|url|max:255',
            'tiktok_url'        => 'nullable|url|max:255',
            'linkedin_url'      => 'nullable|url|max:255',
            'telegram_url'      => 'nullable|url|max:255',
            // Kepala Sekolah
            'nama_kepsek'       => 'nullable|string|max:255',
            'nip_kepsek'        => 'nullable|string|max:30',
            'sambutan_kepsek'   => 'nullable|string',
            // Teks Umum
            'visi'              => 'nullable|string',
            'misi'              => 'nullable|string',
            'tujuan_sekolah'    => 'nullable|string',
            'sejarah_singkat'   => 'nullable|string',
            'deskripsi_singkat' => 'nullable|string',
            // SEO
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'meta_keywords'     => 'nullable|string|max:500',
            // URL eksternal (fallback jika tidak upload file)
            'logo_url'          => 'nullable|url|max:255',
            'cover_url'         => 'nullable|url|max:255',
            'foto_kepsek_url'   => 'nullable|url|max:255',
            // Upload file
            'logo'              => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'favicon'           => 'nullable|image|mimes:jpg,jpeg,png,ico,svg|max:512',
            'cover'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_kepsek'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Jika nama_sekolah dikosongkan, gunakan '-' agar kolom tidak null
        if (empty($validated['nama_sekolah'])) {
            $validated['nama_sekolah'] = '-';
        }

        // Proses upload file; hapus lama jika ada
        $uploads = [
            'logo'        => 'logo_path',
            'favicon'     => 'favicon_path',
            'cover'       => 'cover_path',
            'foto_kepsek' => 'foto_kepsek_path',
        ];

        foreach ($uploads as $inputName => $column) {
            if ($request->hasFile($inputName)) {
                // Hapus file lama
                if ($profil->$column) {
                    Storage::disk('public')->delete($profil->$column);
                }
                $validated[$column] = $request->file($inputName)
                    ->store("profil/{$inputName}", 'public');
                unset($validated[$inputName]);
            } else {
                // Jangan hapus path yang sudah ada jika tidak ada upload baru
                unset($validated[$inputName]);
            }
        }

        $profil->update($validated);

        return redirect()
            ->route('admin.profil-sekolah.edit')
            ->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}