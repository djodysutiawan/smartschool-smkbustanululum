<?php

namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\LinkCepat;
use Illuminate\Http\Request;
 
class LinkCepatController extends Controller
{
    public function index()
    {
        $links = LinkCepat::orderBy('urutan')->paginate(20);
        return view('Admin.LinkCepat.index', compact('links'));
    }
 
    public function create()
    {
        return view('Admin.LinkCepat.create');
    }
 
    public function store(Request $request)
    {
        LinkCepat::create($this->validateLink($request));
        return redirect()->route('admin.link-cepat.index')
            ->with('success', 'Link cepat berhasil ditambahkan.');
    }
 
    public function edit(LinkCepat $linkCepat)
    {
        return view('Admin.LinkCepat.edit', compact('linkCepat'));
    }
 
    public function update(Request $request, LinkCepat $linkCepat)
    {
        $linkCepat->update($this->validateLink($request));
        return redirect()->route('admin.link-cepat.index')
            ->with('success', 'Link cepat berhasil diperbarui.');
    }
 
    public function destroy(LinkCepat $linkCepat)
    {
        $linkCepat->delete();
        return back()->with('success', 'Link cepat berhasil dihapus.');
    }
 
    public function togglePublish(LinkCepat $linkCepat)
    {
        $linkCepat->update(['is_published' => !$linkCepat->is_published]);
        return back()->with('success', 'Status link diperbarui.');
    }
 
    public function reorder(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        foreach ($request->ids as $urutan => $id) {
            LinkCepat::where('id', $id)->update(['urutan' => $urutan + 1]);
        }
        return response()->json(['success' => true]);
    }
 
    private function validateLink(Request $request): array
    {
        return $request->validate([
            'label'        => 'required|string|max:100',
            'url'          => 'required|url|max:255',
            'ikon'         => 'nullable|string|max:50',
            'warna'        => 'nullable|string|max:30',
            'buka_tab_baru'=> 'boolean',
            'is_published' => 'boolean',
            'urutan'       => 'nullable|integer|min:0',
        ]);
    }
}