<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaleriKategori;
use App\Models\GaleriVideo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GaleriVideoController extends Controller
{
    public function index(Request $request)
    {
        $video = GaleriVideo::with('kategori')
            ->when($request->kategori_id, fn($q) => $q->where('galeri_kategori_id', $request->kategori_id))
            ->when($request->tipe_sumber, fn($q) => $q->where('tipe_sumber', $request->tipe_sumber))
            ->orderBy('urutan')
            ->paginate(20);
        $kategori = GaleriKategori::published()->get();
        return view('Admin.GaleriVideo.index', compact('video', 'kategori'));
    }

    public function create()
    {
        $kategori = GaleriKategori::published()->get();
        return view('Admin.GaleriVideo.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $data = $this->validateVideo($request);

        /** @var User $user */
        $user = Auth::user();
        $data['uploaded_by'] = $user->id;

        $this->handleVideoFiles($request, $data);
        GaleriVideo::create($data);
        return redirect()->route('admin.galeri.video.index')
            ->with('success', 'Video berhasil ditambahkan.');
    }

    public function edit(GaleriVideo $galeriVideo)
    {
        $kategori = GaleriKategori::published()->get();
        return view('Admin.GaleriVideo.edit', compact('galeriVideo', 'kategori'));
    }

    public function update(Request $request, GaleriVideo $galeriVideo)
    {
        $data = $this->validateVideo($request);
        $this->handleVideoFiles($request, $data, $galeriVideo);
        $galeriVideo->update($data);
        return redirect()->route('admin.galeri.video.index')
            ->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(GaleriVideo $galeriVideo)
    {
        if ($galeriVideo->video_path) Storage::delete($galeriVideo->video_path);
        if ($galeriVideo->thumbnail_path) Storage::delete($galeriVideo->thumbnail_path);
        $galeriVideo->delete();
        return back()->with('success', 'Video berhasil dihapus.');
    }

    public function togglePublish(GaleriVideo $galeriVideo)
    {
        $galeriVideo->update(['is_published' => !$galeriVideo->is_published]);
        return back()->with('success', 'Status video diperbarui.');
    }

    public function toggleFeatured(GaleriVideo $galeriVideo)
    {
        $galeriVideo->update(['is_featured' => !$galeriVideo->is_featured]);
        return back()->with('success', 'Status unggulan video diperbarui.');
    }

    public function parseUrl(Request $request)
    {
        $request->validate(['url' => 'required|url']);
        $url = $request->url;

        $youtubeId = GaleriVideo::extractYoutubeId($url);
        if ($youtubeId) {
            return response()->json([
                'tipe_sumber'    => 'youtube',
                'video_embed_id' => $youtubeId,
                'thumbnail_url'  => "https://img.youtube.com/vi/{$youtubeId}/hqdefault.jpg",
                'embed_url'      => "https://www.youtube.com/embed/{$youtubeId}",
            ]);
        }

        if (preg_match('/vimeo\.com\/(\d+)/', $url, $m)) {
            return response()->json([
                'tipe_sumber'    => 'vimeo',
                'video_embed_id' => $m[1],
                'embed_url'      => "https://player.vimeo.com/video/{$m[1]}",
            ]);
        }

        return response()->json(['error' => 'URL tidak dikenali.'], 422);
    }

    public function reorder(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        foreach ($request->ids as $urutan => $id) {
            GaleriVideo::where('id', $id)->update(['urutan' => $urutan + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function exportPdf()
    {
        return back()->with('info', 'Fitur export PDF segera hadir.');
    }

    private function validateVideo(Request $request): array
    {
        return $request->validate([
            'galeri_kategori_id' => 'required|exists:galeri_kategori,id',
            'judul'              => 'required|string|max:255',
            'deskripsi'          => 'nullable|string',
            'tipe_sumber'        => 'required|in:youtube,vimeo,upload',
            'video_url'          => 'nullable|url|max:500',
            'video_embed_id'     => 'nullable|string|max:100',
            'video_embed_url'    => 'nullable|url|max:500',
            'thumbnail_url'      => 'nullable|url|max:255',
            'durasi'             => 'nullable|string|max:20',
            'tanggal_video'      => 'nullable|date',
            'sumber'             => 'nullable|string|max:255',
            'is_published'       => 'boolean',
            'is_featured'        => 'boolean',
            'urutan'             => 'nullable|integer|min:0',
            'video'              => 'nullable|file|mimes:mp4,webm,mov|max:204800',
            'thumbnail'          => 'nullable|image|max:2048',
        ]);
    }

    private function handleVideoFiles(Request $request, array &$data, ?GaleriVideo $existing = null): void
    {
        if ($request->hasFile('video')) {
            if ($existing && $existing->video_path) Storage::delete($existing->video_path);
            $data['video_path'] = $request->file('video')->store('galeri/video', 'public');
            unset($data['video']);
        }
        if ($request->hasFile('thumbnail')) {
            if ($existing && $existing->thumbnail_path) Storage::delete($existing->thumbnail_path);
            $data['thumbnail_path'] = $request->file('thumbnail')->store('galeri/thumbnail', 'public');
            unset($data['thumbnail']);
        }
    }
}