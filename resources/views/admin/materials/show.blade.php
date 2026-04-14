<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success', title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500, showConfirmButton: false,
            toast: true, position: 'top-end',
        });
    @endif
</script>

<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand:      #1f63db;
        --brand-h:    #3582f0;
        --brand-50:   #eef6ff;
        --brand-100:  #d9ebff;
        --brand-700:  #1750c0;
        --surface:    #fff;
        --surface2:   #f8fafc;
        --surface3:   #f1f5f9;
        --border:     #e2e8f0;
        --border2:    #cbd5e1;
        --text:       #0f172a;
        --text2:      #475569;
        --text3:      #94a3b8;
        --danger:     #dc2626;
        --danger-50:  #fee2e2;
        --danger-100: #fecaca;
        --radius:     10px;
        --radius-sm:  7px;
    }

    /* ── Layout ── */
    .page { padding: 28px 28px 60px; max-width: 5000px; margin: 0 auto; }

    /* ── Breadcrumb ── */
    .breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600;
        color: var(--text3); margin-bottom: 20px;
    }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    /* ── Page header ── */
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .header-actions { display: flex; gap: 8px; flex-wrap: wrap; }

    /* ── Buttons ── */
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: background .15s, filter .15s; white-space: nowrap;
    }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { filter: brightness(.93); }
    .btn-ghost   { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }
    .btn-danger  { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .btn-danger:hover { background: var(--danger-100); }

    /* ── Hero card ── */
    .hero-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 16px;
    }
    .hero-banner {
        height: 72px;
        background: linear-gradient(135deg, #1f63db 0%, #3582f0 50%, #60a5fa 100%);
    }
    .hero-body {
        padding: 0 24px 22px;
        display: flex; align-items: flex-end; gap: 18px; flex-wrap: wrap;
    }
    .hero-icon-wrap {
        margin-top: -30px; flex-shrink: 0;
        width: 64px; height: 64px; border-radius: 14px;
        border: 3px solid #fff; background: var(--brand-50);
        box-shadow: 0 4px 12px rgba(0,0,0,.1);
        display: flex; align-items: center; justify-content: center;
    }
    .hero-info { flex: 1; padding-top: 10px; min-width: 0; }
    .hero-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 18px; font-weight: 800; color: var(--text);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .hero-meta {
        display: flex; align-items: center; gap: 12px;
        flex-wrap: wrap; margin-top: 5px;
    }
    .hero-meta-item {
        display: flex; align-items: center; gap: 4px;
        font-size: 12.5px; color: var(--text3); font-family: 'DM Sans', sans-serif;
    }
    .hero-meta-item svg { flex-shrink: 0; }
    .hero-badges { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px; }

    /* ── Badges ── */
    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
    }
    .badge-blue   { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .badge-purple { background: #f3e8ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .badge-green  { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-gray   { background: var(--surface3); color: var(--text2); }

    /* ── Layout grid ── */
    .detail-grid { display: grid; grid-template-columns: 1fr 340px; gap: 16px; align-items: start; }

    /* ── Cards ── */
    .info-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 16px;
    }
    .info-card:last-child { margin-bottom: 0; }
    .card-header {
        display: flex; align-items: center; gap: 8px;
        padding: 13px 18px; border-bottom: 1px solid var(--border); background: var(--surface2);
    }
    .card-title {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
        color: var(--text3); letter-spacing: .07em; text-transform: uppercase;
    }
    .card-body { padding: 18px; }

    /* ── Data rows ── */
    .data-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px 20px; }
    .data-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px; font-weight: 700; color: var(--text3);
        letter-spacing: .05em; text-transform: uppercase; margin-bottom: 3px;
    }
    .data-value { font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); font-weight: 500; }
    .data-value.empty { color: var(--text3); font-style: italic; }
    .data-value.prose { line-height: 1.7; white-space: pre-wrap; }

    /* ── File card ── */
    .file-block {
        display: flex; align-items: center; gap: 14px;
        padding: 14px 16px; border-radius: var(--radius-sm);
        background: var(--brand-50); border: 1px solid var(--brand-100);
    }
    .file-block-icon {
        width: 42px; height: 42px; border-radius: 10px; flex-shrink: 0;
        background: var(--surface); border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
    }
    .file-block-info { flex: 1; min-width: 0; }
    .file-block-name {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        color: var(--brand-700); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .file-block-ext {
        font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: 1px;
    }
    .file-block-actions { display: flex; gap: 6px; flex-shrink: 0; }
    .file-action-btn {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 12px; border-radius: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
        cursor: pointer; text-decoration: none; transition: background .15s; border: none;
    }
    .file-action-download { background: var(--brand); color: #fff; }
    .file-action-download:hover { filter: brightness(.93); }
    .file-action-preview  { background: var(--surface); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .file-action-preview:hover { background: var(--brand-100); }

    .file-empty {
        display: flex; flex-direction: column; align-items: center;
        padding: 24px 16px; gap: 8px;
        background: var(--surface2); border: 1px dashed var(--border2);
        border-radius: var(--radius-sm); text-align: center;
    }
    .file-empty-text { font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text3); font-style: italic; }

    /* ── Meta sidebar ── */
    .meta-row {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 8px; padding: 10px 0; border-bottom: 1px solid var(--border);
        font-family: 'DM Sans', sans-serif; font-size: 13px;
    }
    .meta-row:last-child { border-bottom: none; padding-bottom: 0; }
    .meta-key   { color: var(--text3); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; flex-shrink: 0; }
    .meta-val   { color: var(--text2); text-align: right; font-weight: 500; }

    /* ── Delete zone ── */
    .delete-zone {
        padding: 14px 18px;
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
        flex-wrap: wrap;
    }
    .delete-zone-text { font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--text3); }

    /* ── Responsive ── */
    @media (max-width: 900px) {
        .detail-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .page { padding: 16px 16px 40px; }
        .data-grid { grid-template-columns: 1fr; }
        .hero-body { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.materials.index') }}">Materi Pelajaran</a>
        <span class="sep">›</span>
        <span class="current">Detail Materi</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Materi</h1>
            <p class="page-sub">Informasi lengkap materi pelajaran</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.materials.edit', $material->id) }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit Materi
            </a>
            <a href="{{ route('admin.materials.index') }}" class="btn btn-ghost">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Hero card --}}
    <div class="hero-card">
        <div class="hero-banner"></div>
        <div class="hero-body">
            <div class="hero-icon-wrap">
                @php
                    $ext = $material->file_path
                        ? strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION))
                        : null;
                    $iconColors = [
                        'pdf'  => '#b91c1c', 'doc'  => '#1d4ed8', 'docx' => '#1d4ed8',
                        'ppt'  => '#c2410c', 'pptx' => '#c2410c',
                        'xls'  => '#15803d', 'xlsx' => '#15803d',
                        'zip'  => '#a16207',
                        'jpg'  => '#7c3aed', 'jpeg' => '#7c3aed', 'png'  => '#7c3aed',
                    ];
                    $iconColor = $iconColors[$ext] ?? '#1750c0';
                @endphp
                <svg width="26" height="26" fill="none" stroke="{{ $iconColor }}" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <div class="hero-info">
                <p class="hero-title">{{ $material->judul }}</p>
                <div class="hero-meta">
                    @if($material->teacher)
                        <span class="hero-meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                            </svg>
                            {{ $material->teacher->nama_lengkap }}
                        </span>
                    @endif
                    <span class="hero-meta-item">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        {{ $material->created_at->translatedFormat('d F Y') }}
                    </span>
                </div>
                <div class="hero-badges">
                    @if($material->subject)
                        <span class="badge badge-blue">{{ $material->subject->nama_mapel }}</span>
                    @endif
                    @if($material->class)
                        <span class="badge badge-purple">{{ $material->class->nama_kelas }}</span>
                    @endif
                    @if($material->file_path)
                        <span class="badge badge-green">
                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Ada File
                        </span>
                    @else
                        <span class="badge badge-gray">Tanpa File</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Detail grid --}}
    <div class="detail-grid">

        {{-- Kolom kiri: konten utama --}}
        <div>

            {{-- Informasi Materi --}}
            <div class="info-card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                    <p class="card-title">Informasi Materi</p>
                </div>
                <div class="card-body">
                    <div class="data-grid" style="margin-bottom:16px">
                        <div class="data-item">
                            <p class="data-label">Mata Pelajaran</p>
                            <p class="data-value {{ !$material->subject ? 'empty' : '' }}">
                                {{ $material->subject->nama_mapel ?? '—' }}
                            </p>
                        </div>
                        <div class="data-item">
                            <p class="data-label">Kelas</p>
                            <p class="data-value {{ !$material->class ? 'empty' : '' }}">
                                {{ $material->class->nama_kelas ?? '—' }}
                            </p>
                        </div>
                        <div class="data-item">
                            <p class="data-label">Guru Pengampu</p>
                            <p class="data-value {{ !$material->teacher ? 'empty' : '' }}">
                                {{ $material->teacher->nama_lengkap ?? '—' }}
                            </p>
                        </div>
                        <div class="data-item">
                            <p class="data-label">Terakhir Diperbarui</p>
                            <p class="data-value">
                                {{ $material->updated_at->translatedFormat('d F Y, H:i') }}
                            </p>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <p class="data-label">Deskripsi</p>
                        @if($material->deskripsi)
                            <p class="data-value prose" style="margin-top:6px">{{ $material->deskripsi }}</p>
                        @else
                            <p class="data-value empty" style="margin-top:6px">Tidak ada deskripsi</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- File Materi --}}
            <div class="info-card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    <p class="card-title">File Materi</p>
                </div>
                <div class="card-body">
                    @if($material->file_path)
                        @php
                            $filename = basename($material->file_path);
                            $fileExt  = strtoupper(pathinfo($filename, PATHINFO_EXTENSION));
                            $extColors = [
                                'PDF'  => '#b91c1c', 'DOC'  => '#1d4ed8', 'DOCX' => '#1d4ed8',
                                'PPT'  => '#c2410c', 'PPTX' => '#c2410c',
                                'XLS'  => '#15803d', 'XLSX' => '#15803d',
                                'ZIP'  => '#a16207',
                                'JPG'  => '#7c3aed', 'JPEG' => '#7c3aed', 'PNG'  => '#7c3aed',
                            ];
                            $extColor = $extColors[$fileExt] ?? '#94a3b8';
                        @endphp
                        <div class="file-block">
                            <div class="file-block-icon">
                                <svg width="18" height="18" fill="none" stroke="{{ $extColor }}" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                            </div>
                            <div class="file-block-info">
                                <p class="file-block-name">{{ $filename }}</p>
                                <p class="file-block-ext">{{ $fileExt }} &middot; Klik untuk mengunduh</p>
                            </div>
                            <div class="file-block-actions">
                                @if(in_array(strtolower($fileExt), ['pdf', 'jpg', 'jpeg', 'png']))
                                    <a href="{{ asset('storage/' . $material->file_path) }}"
                                        target="_blank" class="file-action-btn file-action-preview">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        Lihat
                                    </a>
                                @endif
                                <a href="{{ asset('storage/' . $material->file_path) }}"
                                    download class="file-action-btn file-action-download">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                        <polyline points="7 10 12 15 17 10"/>
                                        <line x1="12" y1="15" x2="12" y2="3"/>
                                    </svg>
                                    Unduh
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="file-empty">
                            <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                            <p class="file-empty-text">Tidak ada file yang diunggah untuk materi ini</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- Kolom kanan: sidebar meta + aksi --}}
        <div>

            {{-- Meta info --}}
            <div class="info-card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <p class="card-title">Informasi Tambahan</p>
                </div>
                <div class="card-body" style="padding:14px 18px">
                    <div class="meta-row">
                        <span class="meta-key">ID</span>
                        <span class="meta-val">#{{ $material->id }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Dibuat</span>
                        <span class="meta-val">{{ $material->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Diperbarui</span>
                        <span class="meta-val">{{ $material->updated_at->translatedFormat('d M Y') }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">File</span>
                        <span class="meta-val">
                            @if($material->file_path)
                                <span class="badge badge-green" style="font-size:11px">Ada</span>
                            @else
                                <span class="badge badge-gray" style="font-size:11px">Tidak Ada</span>
                            @endif
                        </span>
                    </div>
                    @if($material->file_path)
                        <div class="meta-row">
                            <span class="meta-key">Format</span>
                            <span class="meta-val" style="text-transform:uppercase;font-weight:700;color:var(--text)">
                                {{ strtoupper(pathinfo($material->file_path, PATHINFO_EXTENSION)) }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Aksi cepat --}}
            <div class="info-card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/>
                    </svg>
                    <p class="card-title">Aksi</p>
                </div>
                <div class="card-body" style="display:flex;flex-direction:column;gap:8px;padding:14px 18px">
                    <a href="{{ route('admin.materials.edit', $material->id) }}"
                        class="btn btn-primary" style="width:100%;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Edit Materi
                    </a>
                    <button type="button"
                        class="btn btn-danger" style="width:100%;justify-content:center"
                        onclick="confirmDelete({{ $material->id }}, '{{ addslashes($material->judul) }}')">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                            <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                        </svg>
                        Hapus Materi
                    </button>

                    {{-- Hidden delete form --}}
                    <form id="deleteForm"
                        action="{{ route('admin.materials.destroy', $material->id) }}"
                        method="POST" style="display:none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>{{-- /.page --}}

<script>
    function confirmDelete(id, judul) {
        Swal.fire({
            icon: 'warning',
            title: 'Hapus Materi?',
            html: `<p style="font-family:'DM Sans',sans-serif;font-size:14px">
                        Materi <strong>${judul}</strong> beserta file yang diunggah
                        akan dihapus permanen.
                   </p>`,
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
        }).then(result => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm').submit();
            }
        });
    }
</script>

</x-app-layout>