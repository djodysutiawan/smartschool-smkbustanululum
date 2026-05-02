<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand-700: #1750c0;
        --brand-600: #1f63db;
        --brand-500: #3582f0;
        --brand-100: #d9ebff;
        --brand-50:  #eef6ff;
        --surface:   #fff;
        --surface2:  #f8fafc;
        --surface3:  #f1f5f9;
        --border:    #e2e8f0;
        --border2:   #cbd5e1;
        --text:      #0f172a;
        --text2:     #475569;
        --text3:     #94a3b8;
        --radius:    10px;
        --radius-sm: 7px;
        --danger:    #dc2626;
    }

    .page { padding: 28px 28px 40px; }

    .page-header {
        display: flex; align-items: flex-start;
        justify-content: space-between; gap: 16px;
        margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2; }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .header-actions { display: flex; gap: 8px; flex-wrap: wrap; }

    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 18px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none; transition: filter .15s; white-space: nowrap;
    }
    .btn:hover { filter: brightness(.93); }
    .btn-primary  { background: var(--brand-600); color: #fff; }
    .btn-ghost    { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); filter: none; }
    .btn-success  { background: #15803d; color: #fff; }
    .btn-warning  { background: #fefce8; color: #a16207; border: 1px solid #fde68a; }
    .btn-warning:hover { background: #fef9c3; filter: none; }
    .btn-danger   { background: #fff0f0; color: #dc2626; border: 1px solid #fecaca; }
    .btn-danger:hover { background: #fee2e2; filter: none; }

    .layout { display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start; }

    .card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
    }
    .card-header {
        padding: 14px 20px; border-bottom: 1px solid var(--border);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text);
        display: flex; align-items: center; gap: 8px;
    }
    .card-body { padding: 20px; }
    .card + .card { margin-top: 16px; }

    .article-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 22px; font-weight: 800; color: var(--text);
        line-height: 1.35; margin-bottom: 12px;
    }
    .article-meta {
        display: flex; flex-wrap: wrap; gap: 16px; align-items: center;
        padding-bottom: 16px; border-bottom: 1px solid var(--border); margin-bottom: 20px;
    }
    .article-meta-item {
        display: flex; align-items: center; gap: 5px;
        font-size: 12.5px; color: var(--text3); font-family: 'DM Sans', sans-serif;
    }
    .article-meta-item strong { color: var(--text2); }

    .thumbnail-img {
        width: 100%; border-radius: var(--radius);
        object-fit: cover; max-height: 360px;
        border: 1px solid var(--border); margin-bottom: 20px;
        display: block;
    }

    .article-ringkasan {
        background: var(--brand-50); border-left: 3px solid var(--brand-500);
        padding: 12px 16px; border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        font-size: 13.5px; color: var(--text2); line-height: 1.6;
        margin-bottom: 20px; font-style: italic;
    }

    .article-body {
        font-family: 'DM Sans', sans-serif; font-size: 14px;
        color: var(--text); line-height: 1.8;
        white-space: pre-wrap; word-break: break-word;
    }

    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 12px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
    }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; }
    .status-published { background: #dcfce7; color: #15803d; }
    .status-published .status-dot { background: #15803d; }
    .status-draft { background: #fef9c3; color: #a16207; }
    .status-draft .status-dot { background: #a16207; }

    .featured-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 99px;
        background: #fdf4ff; color: #7c3aed; border: 1px solid #e9d5ff;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
    }

    .meta-row {
        display: flex; justify-content: space-between; align-items: flex-start;
        padding: 9px 0; border-bottom: 1px solid var(--border);
        font-size: 12.5px; gap: 8px;
    }
    .meta-row:last-child { border-bottom: none; padding-bottom: 0; }
    .meta-key { color: var(--text3); font-weight: 600; flex-shrink: 0; }
    .meta-val { color: var(--text2); font-weight: 600; text-align: right; word-break: break-all; }

    .tag-list { display: flex; flex-wrap: wrap; gap: 5px; justify-content: flex-end; }
    .tag {
        display: inline-block; padding: 2px 9px; border-radius: 5px;
        background: var(--surface3); color: var(--text2);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 600;
        border: 1px solid var(--border);
    }

    .seo-field { margin-bottom: 14px; }
    .seo-field:last-child { margin-bottom: 0; }
    .seo-label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px;
        font-weight: 700; color: var(--text3); text-transform: uppercase;
        letter-spacing: .04em; margin-bottom: 4px;
    }
    .seo-val {
        font-size: 13px; color: var(--text2); line-height: 1.5;
        background: var(--surface2); padding: 8px 12px;
        border-radius: var(--radius-sm); border: 1px solid var(--border);
        word-break: break-word;
    }
    .seo-empty { font-size: 12.5px; color: var(--text3); font-style: italic; }

    .action-panel { display: flex; flex-direction: column; gap: 8px; }

    @media (max-width: 900px) {
        .layout { grid-template-columns: 1fr; }
        .page { padding: 16px; }
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Berita</h1>
            <p class="page-sub">Pratinjau & manajemen artikel</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <a href="{{ route('admin.berita.index') }}" class="btn btn-ghost">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="layout">

        {{-- Kolom Kiri: Konten --}}
        <div>
            <div class="card">
                <div class="card-body">

                    {{-- Thumbnail --}}
                    @php
                        $thumbSrc = $berita->thumbnail_path
                            ? asset('storage/'.$berita->thumbnail_path)
                            : ($berita->thumbnail_url ?? null);
                    @endphp
                    @if($thumbSrc)
                        <img src="{{ $thumbSrc }}" alt="{{ $berita->thumbnail_alt ?? $berita->judul }}" class="thumbnail-img">
                    @endif

                    {{-- Badges --}}
                    <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:12px;">
                        <span class="status-badge {{ $berita->status === 'published' ? 'status-published' : 'status-draft' }}">
                            <span class="status-dot"></span>
                            {{ $berita->status === 'published' ? 'Dipublikasikan' : 'Draft' }}
                        </span>
                        @if($berita->is_featured)
                        <span class="featured-badge">
                            <svg width="11" height="11" fill="#7c3aed" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            Unggulan
                        </span>
                        @endif
                        @if($berita->kategori)
                        <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;background:var(--brand-50);color:var(--brand-700);font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;border:1px solid var(--brand-100)">
                            {{ $berita->kategori->nama }}
                        </span>
                        @endif
                    </div>

                    {{-- Judul --}}
                    <h2 class="article-title">{{ $berita->judul }}</h2>

                    {{-- Meta --}}
                    <div class="article-meta">
                        <span class="article-meta-item">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <strong>{{ $berita->nama_penulis ?? ($berita->author->name ?? 'Admin') }}</strong>
                        </span>
                        <span class="article-meta-item">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ $berita->created_at->format('d M Y') }}
                        </span>
                        @if($berita->published_at)
                        <span class="article-meta-item">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Publish: {{ $berita->published_at->format('d M Y, H:i') }}
                        </span>
                        @endif
                        @if($berita->allow_comment)
                        <span class="article-meta-item">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            Komentar aktif
                        </span>
                        @endif
                    </div>

                    {{-- Ringkasan --}}
                    @if($berita->ringkasan)
                    <div class="article-ringkasan">{{ $berita->ringkasan }}</div>
                    @endif

                    {{-- Konten --}}
                    <div class="article-body">{{ $berita->konten }}</div>

                    {{-- Tags --}}
                    @if($berita->tags)
                    <div style="margin-top:24px; padding-top:16px; border-top:1px solid var(--border);">
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);margin-bottom:8px;text-transform:uppercase;letter-spacing:.04em">Tags</p>
                        <div style="display:flex;flex-wrap:wrap;gap:6px;">
                            @foreach(array_map('trim', explode(',', $berita->tags)) as $tag)
                                @if($tag)
                                <span class="tag"># {{ $tag }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            {{-- SEO --}}
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    SEO & Meta
                </div>
                <div class="card-body">
                    <div class="seo-field">
                        <p class="seo-label">Slug</p>
                        <p class="seo-val">{{ $berita->slug }}</p>
                    </div>
                    <div class="seo-field">
                        <p class="seo-label">Meta Title</p>
                        @if($berita->meta_title)
                            <p class="seo-val">{{ $berita->meta_title }}</p>
                        @else
                            <p class="seo-empty">— menggunakan judul berita</p>
                        @endif
                    </div>
                    <div class="seo-field">
                        <p class="seo-label">Meta Description</p>
                        @if($berita->meta_description)
                            <p class="seo-val">{{ $berita->meta_description }}</p>
                        @else
                            <p class="seo-empty">— tidak diisi</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Panel --}}
        <div>

            {{-- Aksi --}}
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Aksi
                </div>
                <div class="card-body">
                    <div class="action-panel">
                        <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-primary" style="justify-content:center">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit Berita
                        </a>

                        @if($berita->status === 'draft')
                        <form action="{{ route('admin.berita.publish', $berita->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success" style="width:100%;justify-content:center">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                Publikasikan
                            </button>
                        </form>
                        @else
                        <form action="{{ route('admin.berita.unpublish', $berita->id) }}" method="POST">
                            @csrf
                            <button type="button" class="btn btn-warning" style="width:100%;justify-content:center"
                                onclick="confirmUnpublish(this.closest('form'))">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                Tarik dari Publikasi
                            </button>
                        </form>
                        @endif

                        <form action="{{ route('admin.berita.toggle-featured', $berita->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-ghost" style="width:100%;justify-content:center">
                                <svg width="14" height="14" fill="{{ $berita->is_featured ? '#7c3aed' : 'none' }}" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                {{ $berita->is_featured ? 'Hapus dari Unggulan' : 'Jadikan Unggulan' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST" id="deleteForm">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-danger" style="width:100%;justify-content:center"
                                onclick="confirmDelete()">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                Hapus Berita
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Info --}}
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Informasi
                </div>
                <div class="card-body">
                    <div class="meta-row">
                        <span class="meta-key">ID</span>
                        <span class="meta-val">#{{ $berita->id }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Status</span>
                        <span class="status-badge {{ $berita->status === 'published' ? 'status-published' : 'status-draft' }}">
                            <span class="status-dot"></span>
                            {{ $berita->status === 'published' ? 'Dipublikasikan' : 'Draft' }}
                        </span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Kategori</span>
                        <span class="meta-val">{{ $berita->kategori->nama ?? '-' }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Penulis</span>
                        <span class="meta-val">{{ $berita->nama_penulis ?? ($berita->author->name ?? '-') }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Dibuat</span>
                        <span class="meta-val">{{ $berita->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Diperbarui</span>
                        <span class="meta-val">{{ $berita->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($berita->published_at)
                    <div class="meta-row">
                        <span class="meta-key">Dipublikasikan</span>
                        <span class="meta-val">{{ $berita->published_at->format('d M Y, H:i') }}</span>
                    </div>
                    @endif
                    @if($berita->tags)
                    <div class="meta-row">
                        <span class="meta-key">Tags</span>
                        <div class="tag-list">
                            @foreach(array_map('trim', explode(',', $berita->tags)) as $tag)
                                @if($tag)<span class="tag">{{ $tag }}</span>@endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <div class="meta-row">
                        <span class="meta-key">Komentar</span>
                        <span class="meta-val">{{ $berita->allow_comment ? 'Diizinkan' : 'Ditutup' }}</span>
                    </div>
                </div>
            </div>

            {{-- Thumbnail Preview --}}
            @if($thumbSrc)
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Thumbnail
                </div>
                <div class="card-body" style="padding:12px">
                    <img src="{{ $thumbSrc }}" alt="{{ $berita->thumbnail_alt ?? '' }}"
                        style="width:100%;border-radius:8px;object-fit:cover;border:1px solid var(--border)">
                    @if($berita->thumbnail_alt)
                    <p style="font-size:11.5px;color:var(--text3);margin-top:6px;text-align:center">{{ $berita->thumbnail_alt }}</p>
                    @endif
                </div>
            </div>
            @endif

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif

    function confirmDelete() {
        Swal.fire({
            title: 'Hapus Berita?',
            text: 'Berita ini akan dihapus permanen.',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('deleteForm').submit(); });
    }

    function confirmUnpublish(form) {
        Swal.fire({
            title: 'Tarik dari Publikasi?',
            text: 'Berita ini akan kembali ke status Draft.',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Tarik!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>