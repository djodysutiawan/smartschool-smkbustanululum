<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700: #1750c0; --brand-600: #1f63db; --brand-500: #3582f0;
        --brand-100: #d9ebll; --brand-50: #eef6ff; --brand-100: #d9ebff;
        --surface: #fff; --surface2: #f8fafc; --surface3: #f1f5f9;
        --border: #e2e8f0; --border2: #cbd5e1;
        --text: #0f172a; --text2: #475569; --text3: #94a3b8;
        --radius: 10px; --radius-sm: 7px;
    }
    .page { padding: 28px 28px 60px; max-width: 2000px; margin: 0 auto; }
    .breadcrumb { display: flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600; color: var(--text3); margin-bottom: 20px; }
    .breadcrumb a { color: var(--text3); text-decoration: none; }
    .breadcrumb a:hover { color: var(--brand-600); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }
    .page-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s; white-space: nowrap; }
    .btn-back      { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-back:hover      { background: var(--surface3); }
    .btn-edit      { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover      { background: var(--brand-100); }
    .btn-del       { background: #fff0f0; color: #dc2626; border: 1px solid #fecaca; }
    .btn-del:hover       { background: #fee2e2; }
    .btn-publish   { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .btn-publish:hover   { background: #dcfce7; }
    .btn-unpublish { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }
    .btn-unpublish:hover { background: #ffedd5; }

    .detail-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; margin-bottom: 16px; }
    .card-header { padding: 16px 24px; border-bottom: 1px solid var(--border); background: var(--surface2); display: flex; align-items: center; gap: 10px; }
    .card-header-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .card-body { padding: 24px; }

    .dl-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .dl-span2 { grid-column: span 2; }
    .dl-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); letter-spacing: .04em; text-transform: uppercase; margin-bottom: 5px; }
    .dl-value { font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 500; color: var(--text); }

    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; white-space: nowrap; }
    .badge-dot { width: 6px; height: 6px; border-radius: 50%; }
    .badge-pub   { background: #dcfce7; color: #15803d; } .badge-pub .badge-dot   { background: #15803d; }
    .badge-draft { background: #f1f5f9; color: var(--text3); } .badge-draft .badge-dot { background: var(--text3); }

    .jenis-pill { display: inline-block; padding: 3px 10px; border-radius: 5px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; }
    .jenis-file  { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .jenis-video { background: #faf5ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .jenis-link  { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .jenis-teks  { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }

    .thumbnail-preview { width: 100%; max-width: 280px; border-radius: var(--radius-sm); overflow: hidden; border: 1px solid var(--border); }
    .thumbnail-preview img { width: 100%; height: auto; display: block; }
    .file-download { display: inline-flex; align-items: center; gap: 8px; background: var(--brand-50); border: 1px solid var(--brand-100); border-radius: var(--radius-sm); padding: 10px 16px; text-decoration: none; color: var(--brand-700); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; transition: background .15s; }
    .file-download:hover { background: var(--brand-100); }
    .link-external { display: inline-flex; align-items: center; gap: 6px; color: var(--brand-600); font-family: 'DM Sans', sans-serif; font-size: 13.5px; font-weight: 500; text-decoration: none; border-bottom: 1px solid var(--brand-100); padding-bottom: 1px; word-break: break-all; }
    .link-external:hover { color: var(--brand-700); }
    .deskripsi-box { background: var(--surface2); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 14px 16px; font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text2); line-height: 1.6; white-space: pre-wrap; }
    .action-bar { display: flex; gap: 10px; flex-wrap: wrap; padding: 16px 24px; border-top: 1px solid var(--border); background: var(--surface2); }
    .meta-row { display: flex; gap: 20px; flex-wrap: wrap; padding: 12px 24px; border-top: 1px solid var(--border); }
    .meta-item { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; }
    .meta-item strong { color: var(--text2); font-weight: 600; }

    @media (max-width: 600px) { .dl-grid { grid-template-columns: 1fr; } .dl-span2 { grid-column: span 1; } .page { padding: 16px 16px 40px; } }
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.materi.index') }}">Materi Pelajaran</a>
        <span class="sep">›</span>
        <span class="current">{{ Str::limit($materi->judul, 40) }}</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Materi</h1>
            <p class="page-sub">Informasi lengkap materi pembelajaran</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <a href="{{ route('admin.materi.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.materi.edit', $materi->id) }}" class="btn btn-edit">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
        </div>
    </div>

    <div class="detail-card">
        <div class="card-header">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            <span class="card-header-title">Informasi Materi</span>
        </div>
        <div class="card-body">
            <div style="display:flex;gap:24px;align-items:flex-start;flex-wrap:wrap;margin-bottom:20px">
                @if($materi->thumbnail)
                <div class="thumbnail-preview">
                    <img src="{{ asset('storage/'.$materi->thumbnail) }}" alt="{{ $materi->judul }}">
                </div>
                @endif
                <div style="flex:1;min-width:200px">
                    <h2 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--text);margin-bottom:8px;line-height:1.3">{{ $materi->judul }}</h2>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
                        <span class="jenis-pill jenis-{{ $materi->jenis }}">{{ ucfirst($materi->jenis) }}</span>
                        @if($materi->dipublikasikan)
                            <span class="badge badge-pub"><span class="badge-dot"></span>Dipublikasikan</span>
                        @else
                            <span class="badge badge-draft"><span class="badge-dot"></span>Draft</span>
                        @endif
                        @if($materi->urutan !== null)
                            <span style="font-size:12px;color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600">Urutan #{{ $materi->urutan }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="dl-grid">
                <div>
                    <p class="dl-label">Guru</p>
                    <p class="dl-value">{{ $materi->guru->nama_lengkap ?? '-' }}</p>
                </div>
                <div>
                    <p class="dl-label">Mata Pelajaran</p>
                    <p class="dl-value">{{ $materi->mataPelajaran->nama_mapel ?? '-' }}</p>
                </div>
                <div>
                    <p class="dl-label">Kelas</p>
                    <p class="dl-value">{{ $materi->kelas->nama_kelas ?? '-' }}</p>
                </div>
                <div>
                    <p class="dl-label">Tahun Ajaran</p>
                    <p class="dl-value">{{ $materi->tahunAjaran->tahun ?? '-' }}</p>
                </div>
                @if($materi->deskripsi)
                <div class="dl-span2">
                    <p class="dl-label">Deskripsi</p>
                    <div class="deskripsi-box">{{ $materi->deskripsi }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="card-header">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            <span class="card-header-title">Konten / File Materi</span>
        </div>
        <div class="card-body">
            @if($materi->jenis == 'file' && $materi->path_file)
                <a href="{{ asset('storage/'.$materi->path_file) }}" download class="file-download" target="_blank">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Unduh File Materi
                </a>
                <p style="font-size:12px;color:var(--text3);margin-top:8px">{{ $materi->path_file }}</p>

            @elseif(in_array($materi->jenis, ['link','video']) && $materi->url_eksternal)
                <p class="dl-label" style="margin-bottom:8px">URL {{ ucfirst($materi->jenis) }}</p>
                <a href="{{ $materi->url_eksternal }}" target="_blank" class="link-external">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    {{ $materi->url_eksternal }}
                </a>
                @if($materi->jenis == 'video')
                    @php preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\s]+)/', $materi->url_eksternal, $ytMatch); $ytId = $ytMatch[1] ?? null; @endphp
                    @if($ytId)
                    <div style="margin-top:16px;border-radius:var(--radius-sm);overflow:hidden;max-width:560px">
                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/{{ $ytId }}"
                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    @endif
                @endif

            @elseif($materi->jenis == 'teks')
                <div class="deskripsi-box" style="min-height:100px">{{ $materi->konten ?? '(Tidak ada konten teks)' }}</div>

            @else
                <p style="color:var(--text3);font-size:13.5px">Tidak ada konten terlampir.</p>
            @endif
        </div>
    </div>

    <div class="detail-card">
        <div class="action-bar">
            <form action="{{ route('admin.materi.toggle-publish', $materi->id) }}" method="POST" id="pubForm">
                @csrf @method('PATCH')
                @if($materi->dipublikasikan)
                <button type="button" class="btn btn-unpublish" onclick="confirmUnpublish()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    Sembunyikan (Draft)
                </button>
                @else
                <button type="button" class="btn btn-publish" onclick="confirmPublish()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 8 12 12 14 14"/></svg>
                    Publikasikan
                </button>
                @endif
            </form>
            <form action="{{ route('admin.materi.destroy', $materi->id) }}" method="POST" id="delForm">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                    Hapus Materi
                </button>
            </form>
        </div>
        <div class="meta-row">
            <span class="meta-item"><strong>Dibuat:</strong> {{ $materi->created_at?->format('d M Y, H:i') ?? '-' }}</span>
            <span class="meta-item"><strong>Diperbarui:</strong> {{ $materi->updated_at?->format('d M Y, H:i') ?? '-' }}</span>
            @if($materi->dipublikasikan_pada)
            <span class="meta-item"><strong>Dipublikasikan:</strong> {{ \Carbon\Carbon::parse($materi->dipublikasikan_pada)->format('d M Y, H:i') }}</span>
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

    function confirmPublish() {
        Swal.fire({ title:'Publikasikan Materi?', text:'Materi akan dapat diakses oleh siswa.', icon:'question', showCancelButton:true, confirmButtonColor:'#15803d', cancelButtonColor:'#64748b', confirmButtonText:'Ya, Publikasikan!', cancelButtonText:'Batal' })
        .then(r => { if (r.isConfirmed) document.getElementById('pubForm').submit(); });
    }
    function confirmUnpublish() {
        Swal.fire({ title:'Sembunyikan Materi?', text:'Materi akan dikembalikan ke status draft.', icon:'warning', showCancelButton:true, confirmButtonColor:'#c2410c', cancelButtonColor:'#64748b', confirmButtonText:'Ya, Sembunyikan!', cancelButtonText:'Batal' })
        .then(r => { if (r.isConfirmed) document.getElementById('pubForm').submit(); });
    }
    function confirmDelete() {
        Swal.fire({ title:'Hapus Materi?', text:'Materi akan dihapus (bisa dipulihkan).', icon:'warning', showCancelButton:true, confirmButtonColor:'#dc2626', cancelButtonColor:'#64748b', confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal' })
        .then(r => { if (r.isConfirmed) document.getElementById('delForm').submit(); });
    }
</script>
</x-app-layout>