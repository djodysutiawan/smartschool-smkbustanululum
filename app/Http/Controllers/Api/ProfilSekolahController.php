<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProfilSekolah;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilSekolahController extends Controller
{
    /**
     * GET /api/profil-sekolah
     */
    public function show(): JsonResponse
    {
        $profil = ProfilSekolah::instance();

        return response()->json([
            'success' => true,
            'data'    => $this->formatProfil($profil),
        ]);
    }

    /**
     * PUT /api/profil-sekolah
     */
    public function update(Request $request): JsonResponse
    {
        $profil = ProfilSekolah::instance();

        $validated = $request->validate([
            // Identitas
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
            'logo'              => 'nullable|file|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'favicon'           => 'nullable|file|image|mimes:jpg,jpeg,png,ico,svg|max:512',
            'cover'             => 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_kepsek'       => 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

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
                if ($profil->$column) {
                    Storage::disk('public')->delete($profil->$column);
                }
                $validated[$column] = $request->file($inputName)
                    ->store("profil/{$inputName}", 'public');
                unset($validated[$inputName]);
            } else {
                unset($validated[$inputName]);
            }
        }

        $profil->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profil sekolah berhasil diperbarui.',
            'data'    => $this->formatProfil($profil->fresh()),
        ]);
    }

    // ── Helper ───────────────────────────────────────────────────────────────

    private function formatProfil(ProfilSekolah $profil): array
    {
        $fileUrl = fn (?string $path): ?string => $path
            ? url('api/file/' . ltrim($path, '/'))
            : null;

        return [
            // Identitas
            'nama_sekolah'      => $profil->nama_sekolah,
            'singkatan'         => $profil->singkatan,
            'npsn'              => $profil->npsn,
            'nss'               => $profil->nss,
            'akreditasi'        => $profil->akreditasi,
            'tahun_berdiri'     => $profil->tahun_berdiri,
            'status_sekolah'    => $profil->status_sekolah,
            'jenjang'           => $profil->jenjang,
            // Alamat
            'alamat_lengkap'    => $profil->alamat_lengkap,
            'desa_kelurahan'    => $profil->desa_kelurahan,
            'kecamatan'         => $profil->kecamatan,
            'kabupaten_kota'    => $profil->kabupaten_kota,
            'provinsi'          => $profil->provinsi,
            'kode_pos'          => $profil->kode_pos,
            'latitude'          => $profil->latitude,
            'longitude'         => $profil->longitude,
            'embed_maps_url'    => $profil->embed_maps_url,
            // Kontak
            'telepon'           => $profil->telepon,
            'whatsapp'          => $profil->whatsapp,
            'fax'               => $profil->fax,
            'email_sekolah'     => $profil->email_sekolah,
            'website'           => $profil->website,
            // Sosmed
            'facebook_url'      => $profil->facebook_url,
            'instagram_url'     => $profil->instagram_url,
            'twitter_url'       => $profil->twitter_url,
            'youtube_url'       => $profil->youtube_url,
            'tiktok_url'        => $profil->tiktok_url,
            'linkedin_url'      => $profil->linkedin_url,
            'telegram_url'      => $profil->telegram_url,
            // Kepala Sekolah
            'nama_kepsek'       => $profil->nama_kepsek,
            'nip_kepsek'        => $profil->nip_kepsek,
            'sambutan_kepsek'   => $profil->sambutan_kepsek,
            'foto_kepsek_url'   => $fileUrl($profil->foto_kepsek_path) ?? $profil->foto_kepsek_url,
            // Teks Umum
            'visi'              => $profil->visi,
            'misi'              => $profil->misi,
            'tujuan_sekolah'    => $profil->tujuan_sekolah,
            'sejarah_singkat'   => $profil->sejarah_singkat,
            'deskripsi_singkat' => $profil->deskripsi_singkat,
            // SEO
            'meta_title'        => $profil->meta_title,
            'meta_description'  => $profil->meta_description,
            'meta_keywords'     => $profil->meta_keywords,
            // File URLs (upload path diprioritaskan, fallback ke URL eksternal)
            'logo_url'          => $fileUrl($profil->logo_path) ?? $profil->logo_url,
            'favicon_url'       => $fileUrl($profil->favicon_path),
            'cover_url'         => $fileUrl($profil->cover_path) ?? $profil->cover_url,
        ];
    }
}