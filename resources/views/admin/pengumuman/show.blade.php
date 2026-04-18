<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand);}
    .breadcrumb .sep{color:var(--border2);}.breadcrumb .current{color:var(--text2);}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}.btn-back:hover{background:var(--surface3);filter:none;}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}.btn-edit:hover{background:var(--brand-100);filter:none;}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}.btn-del:hover{background:#fee2e2;filter:none;}
    .btn-publish{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}.btn-publish:hover{background:#dcfce7;filter:none;}
    .show-layout{display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start;}
    .main-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .main-card-header{padding:20px 24px;border-bottom:1px solid var(--border);}
    .main-card-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.3;margin-bottom:10px;}
    .main-card-meta{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
    .main-card-body{padding:24px;font-family:'DM Sans',sans-serif;font-size:14.5px;color:var(--text);line-height:1.8;white-space:pre-wrap;}
    .side-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .side-card-header{padding:13px 18px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:7px;}
    .side-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text);}
    .side-card-body{padding:16px 18px;}
    .info-row{display:flex;flex-direction:column;gap:3px;padding:9px 0;border-bottom:1px solid #f8fafc;}
    .info-row:last-child{border-bottom:none;}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;}
    .info-val{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-published{background:#dcfce7;color:#15803d;}.badge-published .badge-dot{background:#15803d;}
    .badge-draft{background:#f1f5f9;color:#64748b;}.badge-draft .badge-dot{background:#94a3b8;}
    .badge-pinned{background:#fef9c3;color:#a16207;border:1px solid #fde68a;}
    .role-pill{display:inline-block;padding:2px 10px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;}
    .role-semua{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;}
    .role-guru{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}
    .role-siswa{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .role-orang_tua{background:#fdf4ff;color:#7c3aed;border:1px solid #e9d5ff;}
    .role-guru_piket{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;}
    .lampiran-row{margin-top:16px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 16px;display:flex;align-items:center;gap:12px;}
    .lampiran-icon{width:40px;height:40px;border-radius:8px;background:#fff;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .published-banner{background:linear-gradient(135deg,#15803d,#16a34a);border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:16px;color:#fff;display:flex;align-items:center;gap:10px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;}
    .draft-banner{background:#f1f5f9;border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:16px;color:var(--text2);display:flex;align-items:center;gap:10px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;}
    @media(max-width:900px){.show-layout{grid-template-columns:1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.pengumuman.index') }}">Pengumuman</a>
        <span class="sep">›</span>
        <span class="current">Detail</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Pengumuman</h1>
            <p class="page-sub">{{ Str::limit($pengumuman->judul, 60) }}</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            @if(!$pengumuman->dipublikasikan_pada)
                <form action="{{ route('admin.pengumuman.publish', $pengumuman->id) }}" method="POST" id="pubForm">
                    @csrf @method('PATCH')
                    <button type="button" class="btn btn-publish" onclick="confirmPublish()">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="10 15 15 12 10 9 10 15"/></svg>
                        Publikasikan
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.pengumuman.edit', $pengumuman->id) }}" class="btn btn-edit">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.pengumuman.destroy', $pengumuman->id) }}" method="POST" id="delForm">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    @if($pengumuman->dipublikasikan_pada)
    <div class="published-banner">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        Dipublikasikan pada {{ $pengumuman->dipublikasikan_pada->format('d M Y, H:i') }}
    </div>
    @else
    <div class="draft-banner">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        Pengumuman ini masih berstatus <strong>Draft</strong> — belum terkirim ke pengguna.
    </div>
    @endif

    <div class="show-layout">
        <div>
            <div class="main-card">
                <div class="main-card-header">
                    <h2 class="main-card-judul">
                        @if($pengumuman->dipinned) 📌 @endif
                        {{ $pengumuman->judul }}
                    </h2>
                    <div class="main-card-meta">
                        @if($pengumuman->dipublikasikan_pada)
                            <span class="badge badge-published"><span class="badge-dot"></span>Dipublikasikan</span>
                        @else
                            <span class="badge badge-draft"><span class="badge-dot"></span>Draft</span>
                        @endif
                        @if($pengumuman->dipinned)
                            <span class="badge badge-pinned">📌 Dipinned</span>
                        @endif
                        <span class="role-pill role-{{ $pengumuman->target_role }}">
                            {{ ucfirst(str_replace('_',' ',$pengumuman->target_role)) }}
                        </span>
                        <span style="font-size:12.5px;color:var(--text3)">{{ $pengumuman->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
                <div class="main-card-body">{{ $pengumuman->isi }}</div>
            </div>

            @if($pengumuman->path_lampiran)
            <div class="lampiran-row" style="margin-top:16px">
                <div class="lampiran-icon">
                    <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                </div>
                <div>
                    <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)">Lampiran Pengumuman</p>
                    <a href="{{ asset('storage/'.$pengumuman->path_lampiran) }}" target="_blank" style="font-size:12px;color:var(--brand);text-decoration:none">Klik untuk buka / unduh lampiran →</a>
                </div>
            </div>
            @endif
        </div>

        <div>
            <div class="side-card">
                <div class="side-card-header">
                    <svg width="14" height="14" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <p class="side-card-title">Informasi Pengumuman</p>
                </div>
                <div class="side-card-body">
                    <div class="info-row">
                        <span class="info-label">Target Penerima</span>
                        <span class="info-val">
                            <span class="role-pill role-{{ $pengumuman->target_role }}">{{ ucfirst(str_replace('_',' ',$pengumuman->target_role)) }}</span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status</span>
                        <span class="info-val">
                            @if($pengumuman->dipublikasikan_pada)
                                <span class="badge badge-published"><span class="badge-dot"></span>Dipublikasikan</span>
                            @else
                                <span class="badge badge-draft"><span class="badge-dot"></span>Draft</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Dibuat Oleh</span>
                        <span class="info-val">{{ $pengumuman->dibuatOleh->name ?? '—' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tanggal Publikasi</span>
                        <span class="info-val">
                            @if($pengumuman->dipublikasikan_pada)
                                {{ $pengumuman->dipublikasikan_pada->format('d M Y, H:i') }}
                            @else
                                <span style="color:var(--text3)">Belum dipublikasikan</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kadaluarsa</span>
                        <span class="info-val">
                            @if($pengumuman->kadaluarsa_pada)
                                {{ $pengumuman->kadaluarsa_pada->format('d M Y, H:i') }}
                            @else
                                <span style="color:var(--text3)">Tidak ada</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Dipinned</span>
                        <span class="info-val">{{ $pengumuman->dipinned ? '📌 Ya' : 'Tidak' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Lampiran</span>
                        <span class="info-val">
                            @if($pengumuman->path_lampiran)
                                <a href="{{ asset('storage/'.$pengumuman->path_lampiran) }}" target="_blank" style="color:var(--brand);text-decoration:none;font-weight:600">Ada (Unduh)</a>
                            @else
                                <span style="color:var(--text3)">Tidak ada</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Dibuat</span>
                        <span class="info-val">{{ $pengumuman->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Diperbarui</span>
                        <span class="info-val">{{ $pengumuman->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
    @endif
    @if(session('error'))
    Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
    @endif

    function confirmPublish() {
        Swal.fire({
            title:'Publikasikan Pengumuman?',
            html:`Pengumuman ini akan langsung dikirim ke semua <strong>{{ ucfirst(str_replace('_',' ',$pengumuman->target_role)) }}</strong>.`,
            icon:'question',showCancelButton:true,
            confirmButtonColor:'#15803d',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Publikasikan!',cancelButtonText:'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('pubForm').submit(); });
    }

    function confirmDelete() {
        Swal.fire({
            title:'Hapus Pengumuman?',
            html:`Pengumuman ini akan dihapus permanen beserta lampirannya.`,
            icon:'warning',showCancelButton:true,
            confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('delForm').submit(); });
    }
</script>
</x-app-layout>