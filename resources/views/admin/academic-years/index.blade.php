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
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}', confirmButtonColor: '#1f63db' });
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
        --red:        #dc2626;
        --red-bg:     #fee2e2;
        --red-border: #fecaca;
        --radius:     10px;
        --radius-sm:  7px;
    }

    /* ── Layout ── */
    .page { padding: 28px 28px 60px; max-width: 2000px; margin: 0 auto; }

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
        transition: filter .15s, background .15s; white-space: nowrap;
    }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { filter: brightness(.93); }
    .btn-outline { background: var(--surface); color: var(--text2); border: 1px solid var(--border); }
    .btn-outline:hover { background: var(--surface3); }

    /* ── Stats row ── */
    .stats-row { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 20px; }
    .stat-card {
        flex: 1; min-width: 130px;
        background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius);
        padding: 14px 18px; display: flex; align-items: center; gap: 12px;
    }
    .stat-icon {
        width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .stat-icon-blue   { background: var(--brand-50); }
    .stat-icon-green  { background: #dcfce7; }
    .stat-icon-yellow { background: #fef9c3; }
    .stat-icon-red    { background: #fee2e2; }
    .stat-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: var(--text); line-height: 1; }
    .stat-lbl { font-size: 11.5px; color: var(--text3); font-family: 'DM Sans', sans-serif; margin-top: 2px; }

    /* ── Filter bar ── */
    .filter-bar {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 14px 18px;
        display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
        margin-bottom: 16px;
    }
    .filter-bar input,
    .filter-bar select {
        height: 36px; padding: 0 12px;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text);
        background: var(--surface2); outline: none;
        transition: border-color .15s, background .15s;
    }
    .filter-bar input { min-width: 200px; flex: 1; }
    .filter-bar input:focus,
    .filter-bar select:focus { border-color: var(--brand-h); background: #fff; box-shadow: 0 0 0 3px rgba(53,130,240,.1); }
    .filter-bar input::placeholder { color: var(--text3); }
    .filter-bar .filter-sep { width: 1px; height: 24px; background: var(--border); flex-shrink: 0; }

    /* ── Cards grid ── */
    .years-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 14px;
        margin-bottom: 16px;
    }

    /* ── Year card ── */
    .year-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
        transition: border-color .15s, box-shadow .15s;
        position: relative;
    }
    .year-card:hover { border-color: var(--border2); box-shadow: 0 2px 12px rgba(0,0,0,.06); }
    .year-card.is-active { border-color: #22c55e; }
    .year-card.is-active .year-card-header { background: #f0fdf4; border-bottom-color: #bbf7d0; }

    .active-ribbon {
        position: absolute; top: 12px; right: 12px;
        display: flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 99px;
        background: #dcfce7; color: #15803d;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
        border: 1px solid #bbf7d0;
    }
    .active-ribbon-dot { width: 5px; height: 5px; border-radius: 50%; background: #15803d; }

    .year-card-header {
        padding: 18px 20px 14px;
        border-bottom: 1px solid var(--border);
        background: var(--surface2);
    }
    .year-tahun {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 18px; font-weight: 800; color: var(--text);
        margin-bottom: 4px;
    }
    .year-semester {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 2px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
    }
    .semester-ganjil { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .semester-genap  { background: #f3e8ff; color: #7c3aed; border: 1px solid #e9d5ff; }

    .year-card-body { padding: 14px 20px; }
    .year-stats {
        display: flex; gap: 16px; margin-bottom: 14px;
    }
    .year-stat-item { display: flex; flex-direction: column; gap: 2px; }
    .year-stat-val {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 20px; font-weight: 800; color: var(--text); line-height: 1;
    }
    .year-stat-lbl { font-size: 11px; color: var(--text3); font-family: 'DM Sans', sans-serif; }

    .year-card-footer {
        display: flex; align-items: center; gap: 6px;
        padding: 12px 20px; border-top: 1px solid var(--border);
        background: var(--surface2); flex-wrap: wrap;
    }
    .year-card-footer-right { margin-left: auto; display: flex; gap: 6px; }

    /* ── Action buttons ── */
    .action-btn {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 5px 10px; border-radius: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: background .15s; white-space: nowrap;
    }
    .action-activate { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .action-activate:hover { background: #bbf7d0; }
    .action-edit     { background: var(--brand-50); color: var(--brand-700); }
    .action-edit:hover { background: var(--brand-100); }
    .action-delete   { background: var(--red-bg); color: var(--red); }
    .action-delete:hover { background: #fecaca; }

    /* ── Empty state ── */
    .empty-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 60px 24px;
        display: flex; flex-direction: column; align-items: center; gap: 12px;
        grid-column: 1 / -1;
    }
    .empty-icon {
        width: 56px; height: 56px; border-radius: 16px;
        background: var(--surface3); display: flex; align-items: center; justify-content: center;
    }
    .empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 700; color: var(--text2); }
    .empty-sub   { font-size: 13px; color: var(--text3); font-family: 'DM Sans', sans-serif; }

    /* ── Pagination ── */
    .pagination-wrap {
        display: flex; align-items: center; justify-content: space-between;
        padding: 14px 0; gap: 10px; flex-wrap: wrap;
    }
    .pagination-info { font-size: 12.5px; color: var(--text3); font-family: 'DM Sans', sans-serif; }
    .pagination-links { display: flex; gap: 4px; align-items: center; }
    .page-link {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 32px; height: 32px; padding: 0 8px;
        border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px; font-weight: 700; text-decoration: none; transition: background .15s;
        border: 1px solid transparent; color: var(--text2);
    }
    .page-link:hover    { background: var(--surface3); }
    .page-link.active   { background: var(--brand); color: #fff; border-color: var(--brand); }
    .page-link.disabled { opacity: .4; pointer-events: none; }

    /* ── Responsive ── */
    @media (max-width: 680px) {
        .page { padding: 16px 16px 40px; }
        .years-grid { grid-template-columns: 1fr; }
        .stats-row .stat-card { min-width: 120px; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <span class="current">Tahun Ajaran</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Tahun Ajaran</h1>
            <p class="page-sub">Kelola tahun ajaran dan semester yang aktif di sistem</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.academic-years.create') }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Tahun Ajaran
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon stat-icon-blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div>
                <p class="stat-val">{{ $years->total() }}</p>
                <p class="stat-lbl">Total Tahun Ajaran</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon-green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <div>
                <p class="stat-val">{{ $years->getCollection()->where('status','aktif')->count() }}</p>
                <p class="stat-lbl">Sedang Aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon-yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c3.33 1.67 8.67 1.67 12 0v-5"/>
                </svg>
            </div>
            <div>
                <p class="stat-val">{{ $years->getCollection()->sum('students_count') }}</p>
                <p class="stat-lbl">Total Siswa (halaman ini)</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon-blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
                </svg>
            </div>
            <div>
                <p class="stat-val">{{ $years->getCollection()->where('semester','Ganjil')->count() }}</p>
                <p class="stat-lbl">Semester Ganjil</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.academic-years.index') }}" id="filterForm">
        <div class="filter-bar">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari tahun ajaran, cth. 2024/2025…">
            <div class="filter-sep"></div>
            <select name="semester" onchange="document.getElementById('filterForm').submit()">
                <option value="">Semua Semester</option>
                <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="Genap"  {{ request('semester') == 'Genap'  ? 'selected' : '' }}>Genap</option>
            </select>
            <select name="status" onchange="document.getElementById('filterForm').submit()">
                <option value="">Semua Status</option>
                <option value="aktif"       {{ request('status') == 'aktif'       ? 'selected' : '' }}>Aktif</option>
                <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            <button type="submit" class="btn btn-outline">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Cari
            </button>
            @if(request()->hasAny(['search','semester','status']))
                <a href="{{ route('admin.academic-years.index') }}" class="btn btn-outline">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- Cards grid --}}
    <div class="years-grid">
        @forelse($years as $year)
            <div class="year-card {{ $year->status === 'aktif' ? 'is-active' : '' }}">

                {{-- Ribbon aktif --}}
                @if($year->status === 'aktif')
                    <div class="active-ribbon">
                        <span class="active-ribbon-dot"></span>
                        Aktif
                    </div>
                @endif

                {{-- Header --}}
                <div class="year-card-header">
                    <p class="year-tahun">{{ $year->tahun }}</p>
                    <span class="year-semester semester-{{ strtolower($year->semester) }}">
                        Semester {{ $year->semester }}
                    </span>
                </div>

                {{-- Body --}}
                <div class="year-card-body">
                    <div class="year-stats">
                        <div class="year-stat-item">
                            <p class="year-stat-val">{{ $year->students_count }}</p>
                            <p class="year-stat-lbl">Siswa Terdaftar</p>
                        </div>
                        <div class="year-stat-item">
                            <p class="year-stat-val" style="{{ $year->status === 'aktif' ? 'color:#15803d' : 'color:var(--text3)' }}">
                                {{ $year->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                            </p>
                            <p class="year-stat-lbl">Status</p>
                        </div>
                        <div class="year-stat-item">
                            <p class="year-stat-val" style="font-size:14px;font-weight:600;color:var(--text2);padding-top:3px">
                                {{ $year->created_at->format('Y') }}
                            </p>
                            <p class="year-stat-lbl">Dibuat</p>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="year-card-footer">
                    {{-- Tombol Aktifkan (hanya jika tidak aktif) --}}
                    @if($year->status !== 'aktif')
                        <form method="POST"
                            action="{{ route('admin.academic-years.setActive', $year->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="action-btn action-activate">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                Jadikan Aktif
                            </button>
                        </form>
                    @else
                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:#15803d;display:flex;align-items:center;gap:4px">
                            <svg width="12" height="12" fill="none" stroke="#15803d" stroke-width="2.5" viewBox="0 0 24 24">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Tahun ajaran aktif
                        </span>
                    @endif

                    <div class="year-card-footer-right">
                        <a href="{{ route('admin.academic-years.show', $year->id) }}" class="action-btn" style="background:var(--surface3);color:var(--text2)">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            Detail
                        </a>
                        <a href="{{ route('admin.academic-years.edit', $year->id) }}" class="action-btn action-edit">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            Edit
                        </a>
                        <button type="button" class="action-btn action-delete"
                            onclick="confirmDelete({{ $year->id }}, '{{ addslashes($year->tahun) }}', '{{ $year->semester }}', {{ $year->status === 'aktif' ? 'true' : 'false' }})">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                                <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                            </svg>
                            Hapus
                        </button>

                        {{-- Hidden delete form --}}
                        <form id="deleteForm-{{ $year->id }}"
                            action="{{ route('admin.academic-years.destroy', $year->id) }}"
                            method="POST" style="display:none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>

            </div>
        @empty
            <div class="empty-card">
                <div class="empty-icon">
                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <p class="empty-title">Tidak ada tahun ajaran</p>
                <p class="empty-sub">
                    @if(request()->hasAny(['search','semester','status']))
                        Coba ubah filter pencarian Anda
                    @else
                        Klik "Tambah Tahun Ajaran" untuk menambahkan data baru
                    @endif
                </p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($years->hasPages())
        <div class="pagination-wrap">
            <p class="pagination-info">
                Halaman {{ $years->currentPage() }} dari {{ $years->lastPage() }}
            </p>
            <div class="pagination-links">
                <a href="{{ $years->previousPageUrl() }}"
                    class="page-link {{ $years->onFirstPage() ? 'disabled' : '' }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </a>
                @foreach($years->getUrlRange(max(1, $years->currentPage()-2), min($years->lastPage(), $years->currentPage()+2)) as $page => $url)
                    <a href="{{ $url }}" class="page-link {{ $page == $years->currentPage() ? 'active' : '' }}">
                        {{ $page }}
                    </a>
                @endforeach
                <a href="{{ $years->nextPageUrl() }}"
                    class="page-link {{ !$years->hasMorePages() ? 'disabled' : '' }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </a>
            </div>
        </div>
    @endif

</div>{{-- /.page --}}

<script>
    /* ── Single delete ── */
    function confirmDelete(id, tahun, semester, isActive) {
        const warningHtml = isActive
            ? `<p style="margin:4px 0 0;font-size:13px;color:#dc2626;font-family:'DM Sans',sans-serif">
                ⚠️ Tahun ajaran ini <strong>sedang aktif</strong>. Pastikan sudah ada penggantinya.
               </p>`
            : '';

        Swal.fire({
            icon: 'warning',
            title: 'Hapus Tahun Ajaran?',
            html: `<p style="font-family:'DM Sans',sans-serif;font-size:14px">
                        <strong>${tahun}</strong> — Semester ${semester}
                        akan dihapus permanen.
                   </p>${warningHtml}`,
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
        }).then(result => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm-' + id).submit();
            }
        });
    }
</script>

</x-app-layout>