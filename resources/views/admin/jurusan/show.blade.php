<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root {
    --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
    --brand-100:#d9ebff;--brand-50:#eef6ff;
    --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
    --border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
    --radius:10px;--radius-sm:7px;
}
.page { padding:28px 28px 40px; }
.breadcrumb { display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--text3);margin-bottom:20px; }
.breadcrumb a { color:var(--brand-600);text-decoration:none;font-weight:600; }
.page-header { display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap; }
.page-title { font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text); }
.page-sub { font-size:12.5px;color:var(--text3);margin-top:3px; }
.btn { display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap; }
.btn:hover { filter:brightness(.93); }
.btn-primary { background:var(--brand-600);color:#fff; }
.btn-edit { background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100); }
.btn-edit:hover { background:var(--brand-100);filter:none; }
.btn-secondary { background:var(--surface2);color:var(--text2);border:1px solid var(--border); }
.btn-secondary:hover { background:var(--surface3);filter:none; }
.btn-sm { padding:6px 12px;font-size:12px;border-radius:6px; }

.hero-card { background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:20px; }
.hero-cover { height:180px;background:linear-gradient(135deg,#1f63db,#3582f0);position:relative;overflow:hidden; }
.hero-cover img { width:100%;height:100%;object-fit:cover; }
.hero-cover-overlay { position:absolute;inset:0;background:linear-gradient(to top,rgba(15,23,42,.5),transparent); }
.hero-body { padding:20px 24px; display:flex;gap:20px;align-items:flex-start; }
.hero-logo { width:64px;height:64px;border-radius:12px;border:3px solid var(--surface);background:var(--surface2);overflow:hidden;flex-shrink:0;margin-top:-32px;position:relative;z-index:1;display:flex;align-items:center;justify-content:center; }
.hero-logo img { width:100%;height:100%;object-fit:cover; }
.hero-logo-initial { font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--brand-600); }
.hero-info { flex:1; }
.hero-name { font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--text); }
.hero-meta { display:flex;flex-wrap:wrap;gap:12px;margin-top:6px; }
.hero-meta-item { display:flex;align-items:center;gap:5px;font-size:12.5px;color:var(--text3); }
.badge { display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700; }
.badge-dot { width:5px;height:5px;border-radius:50%; }
.badge-published { background:#dcfce7;color:#15803d; }
.badge-published .badge-dot { background:#15803d; }
.badge-draft { background:#f1f5f9;color:#64748b; }
.badge-draft .badge-dot { background:#94a3b8; }
.badge-buka { background:#dbeafe;color:#1d4ed8; }
.badge-buka .badge-dot { background:#1d4ed8; }
.badge-tutup { background:#fff0f0;color:#dc2626; }
.badge-tutup .badge-dot { background:#dc2626; }

.stats-strip { display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px; }
.stat-card { background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px; }
.stat-icon { width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
.stat-icon.blue { background:var(--brand-50); }
.stat-icon.green { background:#f0fdf4; }
.stat-icon.purple { background:#fdf4ff; }
.stat-icon.orange { background:#fff7ed; }
.stat-label { font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase; }
.stat-val { font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px; }

.nav-tabs { display:flex;gap:2px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);padding:4px;margin-bottom:20px;overflow-x:auto; }
.nav-tab { padding:8px 16px;border-radius:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text2);text-decoration:none;white-space:nowrap;transition:all .15s; }
.nav-tab:hover { background:var(--surface);color:var(--text); }
.nav-tab.active { background:var(--surface);color:var(--brand-700);box-shadow:0 1px 3px rgba(0,0,0,.08); }

.info-grid { display:grid;grid-template-columns:1fr 1fr;gap:20px; }
.info-card { background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden; }
.info-card-header { padding:14px 18px;border-bottom:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px; }
.info-card-body { padding:16px 18px; }
.info-row { display:flex;justify-content:space-between;align-items:flex-start;padding:8px 0;border-bottom:1px solid #f1f5f9; }
.info-row:last-child { border-bottom:none; }
.info-key { font-size:12.5px;color:var(--text3);font-weight:500;min-width:140px; }
.info-val { font-size:13px;color:var(--text);font-weight:600;text-align:right; }

.module-link-grid { display:grid;grid-template-columns:repeat(2,1fr);gap:12px; }
.module-link { background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:18px;display:flex;align-items:center;gap:14px;text-decoration:none;transition:all .2s; }
.module-link:hover { border-color:var(--brand-500);box-shadow:0 2px 8px rgba(31,99,219,.1); }
.module-link-icon { width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
.module-link-name { font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text); }
.module-link-count { font-size:12px;color:var(--text3);margin-top:2px; }
.module-link-arrow { margin-left:auto;color:var(--text3); }

@media(max-width:768px) { .stats-strip{grid-template-columns:1fr 1fr;} .info-grid{grid-template-columns:1fr;} .module-link-grid{grid-template-columns:1fr;} }
@media(max-width:640px) { .page{padding:16px;} }
</style>

<div class="page">
    <div class="breadcrumb">
        <a href="{{ route('admin.jurusan.index') }}">Jurusan</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <span>{{ $jurusan->nama }}</span>
    </div>
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Jurusan</h1>
            <p class="page-sub">Informasi lengkap dan sub-modul jurusan {{ $jurusan->nama }}</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <a href="{{ route('admin.jurusan.edit', $jurusan->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <a href="{{ route('admin.jurusan.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Hero --}}
    <div class="hero-card">
        <div class="hero-cover">
            @if($jurusan->foto_cover_path)
                <img src="{{ Storage::url($jurusan->foto_cover_path) }}" alt="{{ $jurusan->nama }}">
            @elseif($jurusan->foto_cover_url)
                <img src="{{ $jurusan->foto_cover_url }}" alt="{{ $jurusan->nama }}">
            @endif
            <div class="hero-cover-overlay"></div>
        </div>
        <div class="hero-body">
            <div class="hero-logo">
                @if($jurusan->logo_path)
                    <img src="{{ Storage::url($jurusan->logo_path) }}" alt="logo">
                @elseif($jurusan->logo_url)
                    <img src="{{ $jurusan->logo_url }}" alt="logo">
                @else
                    <span class="hero-logo-initial">{{ strtoupper(substr($jurusan->singkatan ?? $jurusan->nama, 0, 2)) }}</span>
                @endif
            </div>
            <div class="hero-info">
                <h2 class="hero-name">{{ $jurusan->nama }}</h2>
                <div class="hero-meta">
                    @if($jurusan->singkatan)<span class="hero-meta-item"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>{{ $jurusan->singkatan }}</span>@endif
                    @if($jurusan->akreditasi)<span class="hero-meta-item"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>Akreditasi {{ $jurusan->akreditasi }}</span>@endif
                    @if($jurusan->lama_belajar)<span class="hero-meta-item"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>{{ $jurusan->lama_belajar }} Tahun</span>@endif
                    <span class="badge {{ $jurusan->is_published ? 'badge-published' : 'badge-draft' }}">
                        <span class="badge-dot"></span>{{ $jurusan->is_published ? 'Published' : 'Draft' }}
                    </span>
                    <span class="badge {{ $jurusan->is_penerimaan_buka ? 'badge-buka' : 'badge-tutup' }}">
                        <span class="badge-dot"></span>Penerimaan {{ $jurusan->is_penerimaan_buka ? 'Buka' : 'Tutup' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue"><svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></div>
            <div><p class="stat-label">Kurikulum</p><p class="stat-val">{{ $stats['kurikulum'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
            <div><p class="stat-label">Kompetensi</p><p class="stat-val">{{ $stats['kompetensi'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple"><svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
            <div><p class="stat-label">Fasilitas</p><p class="stat-val">{{ $stats['fasilitas'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange"><svg width="18" height="18" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 13.255A23.931 23.931 0 0 1 12 15c-3.183 0-6.22-.62-9-1.745M16 6l2 2-2 2M8 6L6 8l2 2"/></svg></div>
            <div><p class="stat-label">Prospek Kerja</p><p class="stat-val">{{ $stats['prospek_kerja'] }}</p></div>
        </div>
    </div>

    {{-- Info Detail --}}
    <div class="info-grid" style="margin-bottom:20px;">
        <div class="info-card">
            <div class="info-card-header">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Informasi Jurusan
            </div>
            <div class="info-card-body">
                <div class="info-row"><span class="info-key">Bidang Keahlian</span><span class="info-val">{{ $jurusan->bidang_keahlian ?? '-' }}</span></div>
                <div class="info-row"><span class="info-key">Program Keahlian</span><span class="info-val">{{ $jurusan->program_keahlian ?? '-' }}</span></div>
                <div class="info-row"><span class="info-key">Kompetensi Keahlian</span><span class="info-val">{{ $jurusan->kompetensi_keahlian ?? '-' }}</span></div>
                <div class="info-row"><span class="info-key">Akreditasi</span><span class="info-val">{{ $jurusan->akreditasi ?? '-' }}</span></div>
                <div class="info-row"><span class="info-key">Lama Belajar</span><span class="info-val">{{ $jurusan->lama_belajar ? $jurusan->lama_belajar.' Tahun' : '-' }}</span></div>
            </div>
        </div>
        <div class="info-card">
            <div class="info-card-header">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                Statistik & Kontak
            </div>
            <div class="info-card-body">
                <div class="info-row"><span class="info-key">Kapasitas/Kelas</span><span class="info-val">{{ $jurusan->kapasitas_per_kelas ?? '-' }} siswa</span></div>
                <div class="info-row"><span class="info-key">Kelas Aktif</span><span class="info-val">{{ $jurusan->jumlah_kelas_aktif ?? '-' }}</span></div>
                <div class="info-row"><span class="info-key">Total Siswa</span><span class="info-val">{{ $jurusan->total_siswa ?? '-' }}</span></div>
                <div class="info-row"><span class="info-key">Kepala Jurusan</span><span class="info-val">{{ $jurusan->nama_kajur ?? '-' }}</span></div>
                <div class="info-row"><span class="info-key">Dibuat oleh</span><span class="info-val">{{ $jurusan->createdBy?->name ?? '-' }}</span></div>
            </div>
        </div>
    </div>

    {{-- Deskripsi --}}
    @if($jurusan->deskripsi_singkat || $jurusan->deskripsi_lengkap)
    <div class="info-card" style="margin-bottom:20px;">
        <div class="info-card-header">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Deskripsi
        </div>
        <div class="info-card-body">
            @if($jurusan->deskripsi_singkat)
                <p style="font-size:13px;color:var(--text2);margin-bottom:10px;font-weight:500;">{{ $jurusan->deskripsi_singkat }}</p>
            @endif
            @if($jurusan->deskripsi_lengkap)
                <p style="font-size:13px;color:var(--text3);line-height:1.7;">{{ $jurusan->deskripsi_lengkap }}</p>
            @endif
        </div>
    </div>
    @endif

    {{-- Sub-modul navigasi --}}
    <div style="margin-bottom:12px;">
        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text2);text-transform:uppercase;letter-spacing:.05em;">Kelola Sub-Modul</p>
    </div>
    <div class="module-link-grid">
        <a href="{{ route('admin.jurusan.kurikulum.index', $jurusan->id) }}" class="module-link">
            <div class="module-link-icon" style="background:#eef6ff;"><svg width="20" height="20" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></div>
            <div>
                <p class="module-link-name">Kurikulum</p>
                <p class="module-link-count">{{ $stats['kurikulum'] }} mata pelajaran</p>
            </div>
            <svg class="module-link-arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        <a href="{{ route('admin.jurusan.kompetensi.index', $jurusan->id) }}" class="module-link">
            <div class="module-link-icon" style="background:#f0fdf4;"><svg width="20" height="20" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
            <div>
                <p class="module-link-name">Kompetensi</p>
                <p class="module-link-count">{{ $stats['kompetensi'] }} kompetensi</p>
            </div>
            <svg class="module-link-arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        <a href="{{ route('admin.jurusan.prospek-kerja.index', $jurusan->id) }}" class="module-link">
            <div class="module-link-icon" style="background:#fff7ed;"><svg width="20" height="20" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
            <div>
                <p class="module-link-name">Prospek Kerja</p>
                <p class="module-link-count">{{ $stats['prospek_kerja'] }} jabatan</p>
            </div>
            <svg class="module-link-arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        <a href="{{ route('admin.jurusan.fasilitas.index', $jurusan->id) }}" class="module-link">
            <div class="module-link-icon" style="background:#fdf4ff;"><svg width="20" height="20" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
            <div>
                <p class="module-link-name">Fasilitas</p>
                <p class="module-link-count">{{ $stats['fasilitas'] }} fasilitas</p>
            </div>
            <svg class="module-link-arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
@endif
</script>
</x-app-layout>