<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}
    .btn-toggle-on{background:#fefce8;color:#a16207;border:1px solid #fde68a}
    .btn-toggle-off{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}

    .layout{display:grid;grid-template-columns:1fr 300px;gap:16px;align-items:start}

    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .detail-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .detail-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .detail-card-body{padding:20px}

    .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:0}
    .info-row{display:flex;flex-direction:column;gap:3px;padding:12px 0;border-bottom:1px solid var(--surface3)}
    .info-row:last-child{border-bottom:none}
    .info-row.full{grid-column:span 2}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .info-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:600;color:var(--text)}
    .info-val.muted{color:var(--text3);font-weight:400}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-publish{background:#dcfce7;color:#15803d} .badge-publish .badge-dot{background:#15803d}
    .badge-draft  {background:#f1f5f9;color:#64748b} .badge-draft   .badge-dot{background:#94a3b8}
    .badge-file   {background:#eff6ff;color:#1d4ed8} .badge-file    .badge-dot{background:#3b82f6}
    .badge-video  {background:#fdf4ff;color:#7c3aed} .badge-video   .badge-dot{background:#a855f7}
    .badge-link   {background:#fefce8;color:#a16207} .badge-link    .badge-dot{background:#eab308}
    .badge-teks   {background:#f0fdf4;color:#15803d} .badge-teks    .badge-dot{background:#22c55e}

    .thumb-preview{width:100%;aspect-ratio:16/9;object-fit:cover;border-radius:var(--radius-sm);border:1px solid var(--border)}
    .thumb-placeholder{width:100%;aspect-ratio:16/9;background:var(--surface2);border-radius:var(--radius-sm);border:2px dashed var(--border);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px;color:var(--text3)}

    .file-preview-box{display:flex;align-items:center;gap:12px;padding:12px 14px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm)}
    .file-preview-icon{width:40px;height:40px;background:var(--brand-50);border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .file-preview-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text);overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .file-preview-sub{font-size:11.5px;color:var(--text3)}

    .desc-box{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text2);line-height:1.7;white-space:pre-wrap}

    @media(max-width:900px){.layout{grid-template-columns:1fr}}
    @media(max-width:640px){.page{padding:16px}.info-grid{grid-template-columns:1fr}.info-row.full{grid-column:span 1}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Materi</h1>
            <p class="page-sub">{{ $materi->judul }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.materi.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('guru.materi.edit', $materi->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('guru.materi.toggle-publish', $materi->id) }}" method="POST" style="display:inline">
                @csrf @method('PATCH')
                @if($materi->dipublikasikan)
                    <button type="submit" class="btn btn-toggle-on">Sembunyikan</button>
                @else
                    <button type="submit" class="btn btn-toggle-off">Publikasikan</button>
                @endif
            </form>
            <form action="{{ route('guru.materi.destroy', $materi->id) }}" method="POST" id="delForm" style="display:inline">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">Hapus</button>
            </form>
        </div>
    </div>

    <div class="layout">
        {{-- Kiri: detail info --}}
        <div>
            <div class="detail-card">
                <div class="detail-card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span class="detail-card-title">Informasi Materi</span>
                </div>
                <div class="detail-card-body">
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Kelas</span>
                            <span class="info-val">{{ $materi->kelas->nama_kelas ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Mata Pelajaran</span>
                            <span class="info-val">{{ $materi->mataPelajaran->nama_mapel ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tahun Ajaran</span>
                            <span class="info-val">{{ $materi->tahunAjaran->tahun ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Urutan</span>
                            <span class="info-val">{{ $materi->urutan ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Jenis</span>
                            <span class="info-val">
                                <span class="badge badge-{{ $materi->jenis }}">
                                    <span class="badge-dot"></span>{{ strtoupper($materi->jenis) }}
                                </span>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Status</span>
                            <span class="info-val">
                                @if($materi->dipublikasikan)
                                    <span class="badge badge-publish"><span class="badge-dot"></span>Dipublikasikan</span>
                                @else
                                    <span class="badge badge-draft"><span class="badge-dot"></span>Draft</span>
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Dibuat</span>
                            <span class="info-val">{{ $materi->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Dipublikasikan Pada</span>
                            <span class="info-val {{ !$materi->dipublikasikan_pada ? 'muted' : '' }}">
                                {{ $materi->dipublikasikan_pada ? \Carbon\Carbon::parse($materi->dipublikasikan_pada)->format('d M Y, H:i') : '—' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Deskripsi --}}
            @if($materi->deskripsi)
            <div class="detail-card">
                <div class="detail-card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg>
                    <span class="detail-card-title">Deskripsi</span>
                </div>
                <div class="detail-card-body">
                    <p class="desc-box">{{ $materi->deskripsi }}</p>
                </div>
            </div>
            @endif

            {{-- Konten Materi --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    <span class="detail-card-title">Konten Materi</span>
                </div>
                <div class="detail-card-body">
                    @if($materi->jenis === 'file' && $materi->path_file)
                        <div class="file-preview-box">
                            <div class="file-preview-icon">
                                <svg width="18" height="18" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div style="flex:1;overflow:hidden">
                                <p class="file-preview-name">{{ basename($materi->path_file) }}</p>
                                <p class="file-preview-sub">File materi</p>
                            </div>
                            <a href="{{ Storage::url($materi->path_file) }}" target="_blank" class="btn btn-secondary" style="padding:5px 12px;font-size:12px">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg>
                                Download
                            </a>
                        </div>

                    @elseif(in_array($materi->jenis, ['link','video']) && $materi->url_eksternal)
                        <div class="file-preview-box">
                            <div class="file-preview-icon">
                                @if($materi->jenis === 'video')
                                    <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                                @else
                                    <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                                @endif
                            </div>
                            <div style="flex:1;overflow:hidden">
                                <p class="file-preview-name">{{ $materi->url_eksternal }}</p>
                                <p class="file-preview-sub">{{ $materi->jenis === 'video' ? 'Video eksternal' : 'Tautan eksternal' }}</p>
                            </div>
                            <a href="{{ $materi->url_eksternal }}" target="_blank" class="btn btn-secondary" style="padding:5px 12px;font-size:12px">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                Buka
                            </a>
                        </div>

                    @elseif($materi->jenis === 'teks')
                        <p style="font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text3)">Materi teks tidak memiliki lampiran file.</p>
                    @else
                        <p style="font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text3)">Tidak ada konten yang dilampirkan.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kanan: sidebar --}}
        <div>
            {{-- Thumbnail --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <span class="detail-card-title">Thumbnail</span>
                </div>
                <div class="detail-card-body">
                    @if($materi->thumbnail)
                        <img src="{{ Storage::url($materi->thumbnail) }}" class="thumb-preview" alt="Thumbnail">
                    @else
                        <div class="thumb-placeholder">
                            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <span style="font-size:12px">Belum ada thumbnail</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Aksi Cepat --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                    <span class="detail-card-title">Aksi Cepat</span>
                </div>
                <div class="detail-card-body" style="display:flex;flex-direction:column;gap:8px">
                    <a href="{{ route('guru.materi.edit', $materi->id) }}" class="btn btn-edit" style="width:100%;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit Materi
                    </a>
                    <form action="{{ route('guru.materi.toggle-publish', $materi->id) }}" method="POST">
                        @csrf @method('PATCH')
                        @if($materi->dipublikasikan)
                            <button type="submit" class="btn btn-toggle-on" style="width:100%;justify-content:center">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                Sembunyikan
                            </button>
                        @else
                            <button type="submit" class="btn btn-toggle-off" style="width:100%;justify-content:center">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                Publikasikan
                            </button>
                        @endif
                    </form>
                    <button type="button" class="btn btn-del" style="width:100%;justify-content:center" onclick="confirmDelete()">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                        Hapus Materi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif

function confirmDelete() {
    Swal.fire({
        title: 'Hapus Materi?',
        html: `Materi <strong>{{ addslashes($materi->judul) }}</strong> akan dihapus permanen beserta filenya.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) document.getElementById('delForm').submit(); });
}
</script>
</x-app-layout>