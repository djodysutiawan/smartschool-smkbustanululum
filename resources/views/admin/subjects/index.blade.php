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
        --success:    #16a34a;
        --success-50: #f0fdf4;
        --success-100:#dcfce7;
    }

    .page { padding: 28px 28px 60px; max-width: 5000px; margin: 0 auto; }

    /* Breadcrumb */
    .breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600;
        color: var(--text3); margin-bottom: 20px;
    }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    /* Page header */
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }

    /* Buttons */
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: background .15s; white-space: nowrap;
    }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { background: var(--brand-h); }
    .btn-ghost { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }
    .btn-danger-soft { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .btn-danger-soft:hover { background: var(--danger-100); }
    .btn-sm { padding: 6px 12px; font-size: 12px; }
    .btn-icon { padding: 6px; border-radius: var(--radius-sm); }

    /* Flash message */
    .flash {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px;
        font-size: 13px; font-family: 'DM Sans', sans-serif;
    }
    .flash-success { background: var(--success-50); color: var(--success); border: 1px solid var(--success-100); }
    .flash-error   { background: var(--danger-50);  color: var(--danger);  border: 1px solid var(--danger-100); }

    /* Toolbar */
    .toolbar {
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 16px; flex-wrap: wrap;
    }
    .search-wrap {
        position: relative; flex: 1; min-width: 200px; max-width: 320px;
    }
    .search-wrap svg {
        position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
        pointer-events: none;
    }
    .search-input {
        width: 100%; box-sizing: border-box;
        padding: 8px 12px 8px 34px;
        font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text);
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius-sm); outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .search-input:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(31,99,219,.1);
    }
    .search-input::placeholder { color: var(--text3); }

    /* Bulk action bar */
    .bulk-bar {
        display: none; align-items: center; gap: 10px;
        background: var(--brand-50); border: 1px solid var(--brand-100);
        border-radius: var(--radius-sm); padding: 10px 16px; margin-bottom: 14px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--brand-700);
    }
    .bulk-bar.visible { display: flex; }
    .bulk-bar-count { margin-right: auto; }

    /* Table card */
    .table-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
    }
    .table-wrap { overflow-x: auto; }

    table { width: 100%; border-collapse: collapse; }
    thead th {
        padding: 11px 16px; text-align: left;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px;
        font-weight: 700; color: var(--text3); letter-spacing: .06em; text-transform: uppercase;
        background: var(--surface2); border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }
    thead th.center { text-align: center; }
    tbody td {
        padding: 12px 16px; font-family: 'DM Sans', sans-serif;
        font-size: 13.5px; color: var(--text);
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: var(--surface2); }

    /* Checkbox */
    .cb {
        width: 15px; height: 15px; accent-color: var(--brand); cursor: pointer;
    }

    /* Subject icon */
    .subject-icon {
        width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
        background: var(--brand-50); border: 1px solid var(--brand-100);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px;
        font-weight: 800; color: var(--brand-700);
    }
    .with-icon { display: flex; align-items: center; gap: 10px; }
    .subject-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--text); }
    .subject-code { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: 2px; }

    /* Badge */
    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 20px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
        letter-spacing: .04em;
    }
    .badge-brand   { background: var(--brand-50);  color: var(--brand-700); border: 1px solid var(--brand-100); }
    .badge-neutral { background: var(--surface3);  color: var(--text3);     border: 1px solid var(--border); }

    /* Row actions */
    .row-actions { display: flex; align-items: center; gap: 6px; justify-content: flex-end; }
    .action-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: var(--radius-sm);
        border: 1px solid var(--border); background: var(--surface2);
        color: var(--text2); cursor: pointer; text-decoration: none;
        transition: all .15s;
    }
    .action-btn:hover { background: var(--surface3); border-color: var(--border2); }
    .action-btn.danger:hover { background: var(--danger-50); border-color: var(--danger-100); color: var(--danger); }

    /* Empty state */
    .empty-state { padding: 60px 24px; text-align: center; }
    .empty-icon {
        width: 56px; height: 56px; border-radius: 14px;
        background: var(--surface3); border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 14px;
    }
    .empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 800; color: var(--text2); }
    .empty-sub   { font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text3); margin-top: 6px; }
    .empty-action { margin-top: 18px; }

    /* Pagination */
    .pagination-wrap {
        display: flex; align-items: center; justify-content: space-between;
        padding: 14px 18px; border-top: 1px solid var(--border);
        background: var(--surface2); gap: 12px; flex-wrap: wrap;
    }
    .pagination-info {
        font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--text3);
    }
    .pagination { display: flex; gap: 4px; align-items: center; }
    .page-link {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 32px; height: 32px; padding: 0 8px;
        border-radius: var(--radius-sm); border: 1px solid var(--border);
        background: var(--surface); color: var(--text2); text-decoration: none;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600;
        transition: all .15s;
    }
    .page-link:hover   { background: var(--surface3); border-color: var(--border2); }
    .page-link.active  { background: var(--brand); color: #fff; border-color: var(--brand); }
    .page-link.disabled { opacity: .4; pointer-events: none; }

    /* Delete modal */
    .modal-overlay {
        display: none; position: fixed; inset: 0; z-index: 100;
        background: rgba(15,23,42,.45); backdrop-filter: blur(3px);
        align-items: center; justify-content: center;
    }
    .modal-overlay.open { display: flex; }
    .modal {
        background: var(--surface); border-radius: var(--radius);
        border: 1px solid var(--border); padding: 28px 28px 24px;
        width: 100%; max-width: 400px; margin: 16px;
        box-shadow: 0 20px 40px rgba(0,0,0,.12);
    }
    .modal-icon {
        width: 48px; height: 48px; border-radius: 12px; margin-bottom: 16px;
        background: var(--danger-50); border: 1px solid var(--danger-100);
        display: flex; align-items: center; justify-content: center;
    }
    .modal-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-weight: 800; color: var(--text); }
    .modal-body  { font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text2); margin-top: 8px; line-height: 1.6; }
    .modal-body strong { color: var(--text); }
    .modal-footer { display: flex; gap: 10px; justify-content: flex-end; margin-top: 22px; }

    @media (max-width: 600px) {
        .page { padding: 16px 16px 40px; }
        .row-actions { gap: 4px; }
        .pagination-wrap { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <span class="current">Data Mata Pelajaran</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Data Mata Pelajaran</h1>
            <p class="page-sub">Kelola seluruh mata pelajaran yang tersedia di sekolah</p>
        </div>
        <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Tambah Mata Pelajaran
        </a>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="flash flash-success">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flash flash-error">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Toolbar --}}
    <div class="toolbar">
        {{-- Search --}}
        <form method="GET" action="{{ route('admin.subjects.index') }}" style="display:contents">
            <div class="search-wrap">
                <svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input
                    type="text" name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama atau kode mapel…"
                    class="search-input"
                    oninput="this.form.submit()"
                >
            </div>
        </form>

        <div style="margin-left:auto;display:flex;gap:8px">
            {{-- Reset filter --}}
            @if(request('search'))
                <a href="{{ route('admin.subjects.index') }}" class="btn btn-ghost btn-sm">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    Reset
                </a>
            @endif

            {{-- Total info --}}
            <span style="display:inline-flex;align-items:center;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3);gap:4px">
                <strong style="color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif">{{ $subjects->total() }}</strong> mata pelajaran
            </span>
        </div>
    </div>

    {{-- Bulk action bar --}}
    <div class="bulk-bar" id="bulkBar">
        <span class="bulk-bar-count" id="bulkCount">0 dipilih</span>
        <button class="btn btn-danger-soft btn-sm" onclick="openBulkModal()">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
            </svg>
            Hapus yang Dipilih
        </button>
        <button class="btn btn-ghost btn-sm" onclick="clearSelection()">Batal</button>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:40px">
                            <input type="checkbox" class="cb" id="checkAll" onchange="toggleAll(this)">
                        </th>
                        <th style="width:40px">#</th>
                        <th>Mata Pelajaran</th>
                        <th>Kode</th>
                        <th class="center">Digunakan di Jadwal</th>
                        <th style="width:100px"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $i => $subject)
                        <tr>
                            {{-- Checkbox --}}
                            <td>
                                <input
                                    type="checkbox" class="cb row-cb"
                                    value="{{ $subject->id }}"
                                    onchange="updateBulk()"
                                >
                            </td>

                            {{-- No --}}
                            <td style="color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600">
                                {{ $subjects->firstItem() + $i }}
                            </td>

                            {{-- Nama mapel --}}
                            <td>
                                <div class="with-icon">
                                    <div class="subject-icon">
                                        {{ strtoupper(substr($subject->kode_mapel ?? $subject->nama_mapel, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="subject-name">{{ $subject->nama_mapel }}</p>
                                        <p class="subject-code">{{ $subject->kode_mapel }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Kode --}}
                            <td>
                                <span class="badge badge-brand">{{ $subject->kode_mapel }}</span>
                            </td>

                            {{-- Jumlah jadwal --}}
                            <td style="text-align:center">
                                @if($subject->schedules_count > 0)
                                    <span class="badge badge-brand">
                                        {{ $subject->schedules_count }} jadwal
                                    </span>
                                @else
                                    <span class="badge badge-neutral">Belum dipakai</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div class="row-actions">
                                    <a href="{{ route('admin.subjects.show', $subject->id) }}"
                                       class="action-btn" title="Lihat Detail">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.subjects.edit', $subject->id) }}"
                                       class="action-btn" title="Edit">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </a>
                                    <button
                                        class="action-btn danger" title="Hapus"
                                        onclick="openDeleteModal({{ $subject->id }}, '{{ addslashes($subject->nama_mapel) }}')">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                            <path d="M10 11v6M14 11v6"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                        </svg>
                                    </div>
                                    @if(request('search'))
                                        <p class="empty-title">Tidak ada hasil untuk "{{ request('search') }}"</p>
                                        <p class="empty-sub">Coba kata kunci lain atau reset pencarian.</p>
                                        <div class="empty-action">
                                            <a href="{{ route('admin.subjects.index') }}" class="btn btn-ghost btn-sm">Reset Pencarian</a>
                                        </div>
                                    @else
                                        <p class="empty-title">Belum ada mata pelajaran</p>
                                        <p class="empty-sub">Tambahkan mata pelajaran pertama untuk mulai mengatur jadwal.</p>
                                        <div class="empty-action">
                                            <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary btn-sm">
                                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <line x1="12" y1="5" x2="12" y2="19"/>
                                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                                </svg>
                                                Tambah Sekarang
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($subjects->hasPages())
            <div class="pagination-wrap">
                <p class="pagination-info">
                    Menampilkan {{ $subjects->firstItem() }}–{{ $subjects->lastItem() }}
                    dari {{ $subjects->total() }} mata pelajaran
                </p>
                <div class="pagination">
                    {{-- Prev --}}
                    @if($subjects->onFirstPage())
                        <span class="page-link disabled">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                        </span>
                    @else
                        <a href="{{ $subjects->previousPageUrl() }}" class="page-link">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                        </a>
                    @endif

                    {{-- Pages --}}
                    @foreach($subjects->getUrlRange(1, $subjects->lastPage()) as $page => $url)
                        @if($page == $subjects->currentPage())
                            <span class="page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if($subjects->hasMorePages())
                        <a href="{{ $subjects->nextPageUrl() }}" class="page-link">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    @else
                        <span class="page-link disabled">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>

</div>

{{-- Single Delete Modal --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-icon">
            <svg width="22" height="22" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                <path d="M10 11v6M14 11v6"/>
                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
            </svg>
        </div>
        <p class="modal-title">Hapus Mata Pelajaran?</p>
        <p class="modal-body">
            Anda akan menghapus mata pelajaran <strong id="deleteSubjectName">—</strong>.
            Jika mata pelajaran ini sedang digunakan di jadwal, data jadwal terkait juga akan terpengaruh.
            Tindakan ini tidak dapat dibatalkan.
        </p>
        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeDeleteModal()">Batal</button>
            <form id="deleteForm" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger-soft">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

{{-- Bulk Delete Modal --}}
<div class="modal-overlay" id="bulkModal">
    <div class="modal">
        <div class="modal-icon">
            <svg width="22" height="22" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                <path d="M10 11v6M14 11v6"/>
            </svg>
        </div>
        <p class="modal-title">Hapus Mata Pelajaran Terpilih?</p>
        <p class="modal-body">
            Anda akan menghapus <strong id="bulkCountText">0</strong> mata pelajaran sekaligus.
            Data jadwal yang menggunakan mata pelajaran ini juga akan terpengaruh.
            Tindakan ini tidak dapat dibatalkan.
        </p>
        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeBulkModal()">Batal</button>
            <form id="bulkDeleteForm" method="POST" action="{{ route('admin.subjects.bulkDelete') }}" style="display:inline">
                @csrf
                @method('DELETE')
                <div id="bulkInputs"></div>
                <button type="submit" class="btn btn-danger-soft">Ya, Hapus Semua</button>
            </form>
        </div>
    </div>
</div>

<script>
    /* ── Single delete ── */
    function openDeleteModal(id, name) {
        document.getElementById('deleteSubjectName').textContent = name;
        document.getElementById('deleteForm').action = '/admin/subjects/' + id;
        document.getElementById('deleteModal').classList.add('open');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('open');
    }

    /* ── Bulk select ── */
    function toggleAll(cb) {
        document.querySelectorAll('.row-cb').forEach(c => c.checked = cb.checked);
        updateBulk();
    }

    function updateBulk() {
        const checked = document.querySelectorAll('.row-cb:checked');
        const bar     = document.getElementById('bulkBar');
        document.getElementById('bulkCount').textContent = checked.length + ' dipilih';
        bar.classList.toggle('visible', checked.length > 0);

        /* Sync check-all */
        const all = document.querySelectorAll('.row-cb');
        document.getElementById('checkAll').checked        = all.length > 0 && checked.length === all.length;
        document.getElementById('checkAll').indeterminate  = checked.length > 0 && checked.length < all.length;
    }

    function clearSelection() {
        document.querySelectorAll('.row-cb, #checkAll').forEach(c => c.checked = false);
        document.getElementById('checkAll').indeterminate = false;
        updateBulk();
    }

    /* ── Bulk delete modal ── */
    function openBulkModal() {
        const checked = document.querySelectorAll('.row-cb:checked');
        document.getElementById('bulkCountText').textContent = checked.length;

        /* Build hidden inputs */
        const container = document.getElementById('bulkInputs');
        container.innerHTML = '';
        checked.forEach(cb => {
            const inp = document.createElement('input');
            inp.type  = 'hidden';
            inp.name  = 'ids[]';
            inp.value = cb.value;
            container.appendChild(inp);
        });

        document.getElementById('bulkModal').classList.add('open');
    }
    function closeBulkModal() {
        document.getElementById('bulkModal').classList.remove('open');
    }

    /* ── Close modal on backdrop click ── */
    ['deleteModal', 'bulkModal'].forEach(id => {
        document.getElementById(id).addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('open');
        });
    });
</script>

</x-app-layout>