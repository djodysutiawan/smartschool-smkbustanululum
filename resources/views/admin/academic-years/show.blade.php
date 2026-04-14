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
        --radius:     10px;
        --radius-sm:  7px;
        --danger:     #dc2626;
        --danger-50:  #fee2e2;
        --danger-100: #fecaca;
    }

    .page { padding: 28px 28px 60px; max-width: 860px; margin: 0 auto; }

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
    .btn-edit    { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover { background: var(--brand-100); }
    .btn-ghost   { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }
    .btn-danger  { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .btn-danger:hover { background: var(--danger-100); }
    .btn-success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .btn-success:hover { background: #bbf7d0; }

    /* ── Hero card ── */
    .hero-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 16px;
    }
    .hero-banner {
        height: 80px;
        background: linear-gradient(135deg, #1f63db 0%, #3582f0 50%, #60a5fa 100%);
        position: relative;
    }
    .hero-banner-aktif {
        background: linear-gradient(135deg, #15803d 0%, #16a34a 50%, #4ade80 100%);
    }
    .hero-banner-label {
        position: absolute; top: 12px; right: 14px;
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(255,255,255,.18); backdrop-filter: blur(6px);
        border: 1px solid rgba(255,255,255,.3); border-radius: 99px;
        padding: 4px 12px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: #fff;
    }
    .hero-body {
        padding: 0 24px 24px;
        display: flex; align-items: flex-end; gap: 20px; flex-wrap: wrap;
    }
    .hero-icon-wrap {
        margin-top: -36px; flex-shrink: 0;
        width: 72px; height: 72px; border-radius: 16px;
        border: 3px solid #fff; overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,.12);
        display: flex; align-items: center; justify-content: center;
    }
    .hero-icon-wrap.aktif { background: #dcfce7; }
    .hero-icon-wrap.nonaktif { background: var(--brand-50); }
    .hero-info { flex: 1; padding-top: 14px; min-width: 0; }
    .hero-tahun {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 22px; font-weight: 800; color: var(--text);
    }
    .hero-meta {
        display: flex; align-items: center; gap: 10px;
        flex-wrap: wrap; margin-top: 6px;
    }
    .hero-meta-item {
        display: flex; align-items: center; gap: 4px;
        font-size: 12.5px; color: var(--text3); font-family: 'DM Sans', sans-serif;
    }
    .hero-badges { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 10px; }

    /* ── Badges ── */
    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 11px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
    }
    .badge-aktif    { background: #dcfce7; color: #15803d; }
    .badge-nonaktif { background: var(--surface3); color: var(--text2); border: 1px solid var(--border); }
    .badge-ganjil   { background: #dbeafe; color: #1d4ed8; }
    .badge-genap    { background: #f3e8ff; color: #7c3aed; }
    .badge-brand    { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }

    /* ── Stat cards row ── */
    .stats-row {
        display: grid; grid-template-columns: repeat(3, 1fr);
        gap: 12px; margin-bottom: 16px;
    }
    .stat-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 18px 20px;
        display: flex; align-items: center; gap: 14px;
    }
    .stat-icon {
        width: 42px; height: 42px; border-radius: 11px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .stat-num   { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 24px; font-weight: 800; color: var(--text); line-height: 1; }
    .stat-label { font-size: 12px; color: var(--text3); margin-top: 4px; font-family: 'DM Sans', sans-serif; }

    /* ── Info card ── */
    .info-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 16px;
    }
    .card-header {
        display: flex; align-items: center; gap: 8px;
        padding: 14px 18px; border-bottom: 1px solid var(--border); background: var(--surface2);
    }
    .card-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px; font-weight: 700; color: var(--text3);
        letter-spacing: .07em; text-transform: uppercase;
    }
    .card-body { padding: 20px 22px; }

    /* ── Data grid ── */
    .data-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px 24px; }
    .data-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px; font-weight: 700; color: var(--text3);
        letter-spacing: .05em; text-transform: uppercase; margin-bottom: 4px;
    }
    .data-value { font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); font-weight: 500; }
    .data-value.empty { color: var(--text3); font-style: italic; }

    /* ── Status visual ── */
    .status-visual {
        display: flex; align-items: center; gap: 10px;
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 14px 16px; margin-bottom: 16px;
    }
    .status-visual.aktif   { background: #f0fdf4; border-color: #bbf7d0; }
    .status-visual.nonaktif{ background: var(--surface2); }
    .status-dot {
        width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
    }
    .status-dot.aktif    { background: #16a34a; box-shadow: 0 0 0 3px rgba(22,163,74,.2); }
    .status-dot.nonaktif { background: var(--text3); }
    .status-text {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700;
    }
    .status-text.aktif    { color: #15803d; }
    .status-text.nonaktif { color: var(--text2); }
    .status-desc { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-left: auto; }

    /* ── Meta timestamps ── */
    .meta-row {
        display: flex; gap: 20px; flex-wrap: wrap;
        padding: 12px 22px; border-top: 1px solid var(--border);
        background: var(--surface2);
    }
    .meta-item { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); }
    .meta-item span { color: var(--text2); font-weight: 500; }

    /* ── Activate banner (jika nonaktif) ── */
    .activate-banner {
        display: flex; align-items: center; gap: 14px;
        background: #fffbeb; border: 1px solid #fde68a;
        border-radius: var(--radius-sm); padding: 14px 18px; margin-bottom: 16px;
        flex-wrap: wrap;
    }
    .activate-banner-text {
        flex: 1; font-family: 'DM Sans', sans-serif; font-size: 13px; color: #92400e; min-width: 200px;
    }
    .activate-banner-text strong {
        font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #78350f;
    }

    /* ── Responsive ── */
    @media (max-width: 640px) {
        .page { padding: 16px 16px 40px; }
        .stats-row { grid-template-columns: 1fr 1fr; }
        .data-grid  { grid-template-columns: 1fr; }
        .hero-body  { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.academic-years.index') }}">Tahun Ajaran</a>
        <span class="sep">›</span>
        <span class="current">Detail</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Tahun Ajaran</h1>
            <p class="page-sub">Informasi lengkap tahun ajaran</p>
        </div>
        <div class="header-actions">
            @if($year->status !== 'aktif')
                <form method="POST" action="{{ route('admin.academic-years.setActive', $year->id) }}" style="display:inline">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-success">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Aktifkan
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.academic-years.edit', $year->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit
            </a>
            <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6m4-6v6M9 6V4h6v2"/>
                </svg>
                Hapus
            </button>
            <a href="{{ route('admin.academic-years.index') }}" class="btn btn-ghost">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Hidden delete form --}}
    <form id="deleteForm" method="POST"
          action="{{ route('admin.academic-years.destroy', $year->id) }}" style="display:none">
        @csrf @method('DELETE')
    </form>

    {{-- Activate banner jika nonaktif --}}
    @if($year->status !== 'aktif')
        <div class="activate-banner">
            <svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            <p class="activate-banner-text">
                Tahun ajaran ini <strong>tidak aktif</strong>. Klik <strong>Aktifkan</strong> untuk menjadikannya tahun ajaran yang sedang berjalan.
            </p>
            <form method="POST" action="{{ route('admin.academic-years.setActive', $year->id) }}">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-success" style="padding:7px 14px;font-size:12.5px">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Aktifkan Sekarang
                </button>
            </form>
        </div>
    @endif

    {{-- Hero card --}}
    <div class="hero-card">
        <div class="hero-banner {{ $year->status === 'aktif' ? 'hero-banner-aktif' : '' }}">
            <span class="hero-banner-label">
                @if($year->status === 'aktif')
                    <svg width="10" height="10" fill="currentColor" viewBox="0 0 10 10">
                        <circle cx="5" cy="5" r="5"/>
                    </svg>
                    Tahun Ajaran Aktif
                @else
                    ○ Tidak Aktif
                @endif
            </span>
        </div>
        <div class="hero-body">
            <div class="hero-icon-wrap {{ $year->status === 'aktif' ? 'aktif' : 'nonaktif' }}">
                @if($year->status === 'aktif')
                    <svg width="32" height="32" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                @else
                    <svg width="32" height="32" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                @endif
            </div>
            <div class="hero-info">
                <p class="hero-tahun">{{ $year->tahun }}</p>
                <div class="hero-meta">
                    <span class="hero-meta-item">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Dibuat {{ $year->created_at?->translatedFormat('d F Y') ?? '—' }}
                    </span>
                    @if($year->students_count ?? 0)
                        <span class="hero-meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                            </svg>
                            {{ $year->students_count }} siswa terdaftar
                        </span>
                    @endif
                </div>
                <div class="hero-badges">
                    @if($year->semester === 'Ganjil')
                        <span class="badge badge-ganjil">Semester Ganjil</span>
                    @else
                        <span class="badge badge-genap">Semester Genap</span>
                    @endif
                    @if($year->status === 'aktif')
                        <span class="badge badge-aktif">● Aktif</span>
                    @else
                        <span class="badge badge-nonaktif">○ Tidak Aktif</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Stats row --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--brand-50)">
                <svg width="20" height="20" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div>
                <p class="stat-num">{{ $year->students_count ?? 0 }}</p>
                <p class="stat-label">Siswa Terdaftar</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:{{ $year->semester === 'Ganjil' ? '#dbeafe' : '#f3e8ff' }}">
                <svg width="20" height="20" fill="none"
                     stroke="{{ $year->semester === 'Ganjil' ? '#1d4ed8' : '#7c3aed' }}"
                     stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
                </svg>
            </div>
            <div>
                <p class="stat-num" style="font-size:16px;padding-top:4px">{{ $year->semester }}</p>
                <p class="stat-label">Semester</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:{{ $year->status === 'aktif' ? '#dcfce7' : 'var(--surface3)' }}">
                @if($year->status === 'aktif')
                    <svg width="20" height="20" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                @else
                    <svg width="20" height="20" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" y1="9" x2="9" y2="15"/>
                        <line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                @endif
            </div>
            <div>
                <p class="stat-num" style="font-size:16px;padding-top:4px;color:{{ $year->status === 'aktif' ? '#15803d' : 'var(--text2)' }}">
                    {{ $year->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}
                </p>
                <p class="stat-label">Status</p>
            </div>
        </div>
    </div>

    {{-- Detail info --}}
    <div class="info-card">
        <div class="card-header">
            <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <p class="card-title">Informasi Tahun Ajaran</p>
        </div>
        <div class="card-body">

            {{-- Status visual --}}
            <div class="status-visual {{ $year->status === 'aktif' ? 'aktif' : 'nonaktif' }}" style="margin-bottom:20px">
                <span class="status-dot {{ $year->status === 'aktif' ? 'aktif' : 'nonaktif' }}"></span>
                <span class="status-text {{ $year->status === 'aktif' ? 'aktif' : 'nonaktif' }}">
                    {{ $year->status === 'aktif' ? 'Tahun Ajaran Sedang Aktif' : 'Tahun Ajaran Tidak Aktif' }}
                </span>
                <span class="status-desc">
                    {{ $year->status === 'aktif' ? 'Digunakan sebagai referensi data saat ini' : 'Tidak digunakan sebagai referensi aktif' }}
                </span>
            </div>

            <div class="data-grid">
                <div>
                    <p class="data-label">Tahun Ajaran</p>
                    <p class="data-value">{{ $year->tahun }}</p>
                </div>
                <div>
                    <p class="data-label">Semester</p>
                    @if($year->semester === 'Ganjil')
                        <span class="badge badge-ganjil">Semester Ganjil</span>
                    @else
                        <span class="badge badge-genap">Semester Genap</span>
                    @endif
                </div>
                <div>
                    <p class="data-label">Status</p>
                    @if($year->status === 'aktif')
                        <span class="badge badge-aktif">● Aktif</span>
                    @else
                        <span class="badge badge-nonaktif">○ Tidak Aktif</span>
                    @endif
                </div>
                <div>
                    <p class="data-label">Jumlah Siswa</p>
                    <p class="data-value">
                        {{ $year->students_count ?? 0 }} siswa
                    </p>
                </div>
            </div>
        </div>
        <div class="meta-row">
            <p class="meta-item">Dibuat: <span>{{ $year->created_at?->translatedFormat('d F Y, H:i') ?? '—' }}</span></p>
            <p class="meta-item">Diperbarui: <span>{{ $year->updated_at?->translatedFormat('d F Y, H:i') ?? '—' }}</span></p>
        </div>
    </div>

</div>

<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Hapus Tahun Ajaran?',
            html: `Tahun ajaran <b>{{ $year->tahun }}</b> semester <b>{{ $year->semester }}</b> akan dihapus permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
        }).then(r => {
            if (r.isConfirmed) document.getElementById('deleteForm').submit();
        });
    }
</script>

</x-app-layout>