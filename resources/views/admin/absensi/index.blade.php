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

    /* ── Layout ── */
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    /* ── Buttons ── */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-detail:hover{background:#dcfce7;filter:none}

    /* ── Dropdown ── */
    .dropdown{position:relative;display:inline-flex}
    .dropdown-menu{display:none;position:absolute;top:calc(100% + 6px);right:0;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);box-shadow:0 8px 28px rgba(0,0,0,.1);min-width:200px;z-index:200;overflow:hidden}
    .dropdown.open .dropdown-menu{display:block}
    .dropdown-item{display:flex;align-items:center;gap:8px;padding:9px 14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text2);text-decoration:none;background:none;border:none;width:100%;cursor:pointer;transition:background .12s;text-align:left}
    .dropdown-item:hover{background:var(--surface2);color:var(--text)}
    .dropdown-divider{border:none;border-top:1px solid var(--border);margin:4px 0}
    .dropdown-section-label{padding:6px 14px 3px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:700;color:var(--text3);letter-spacing:.06em;text-transform:uppercase}

    /* ── Stats ── */
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.green{background:#f0fdf4}
    .stat-icon.yellow{background:#fefce8}
    .stat-icon.blue{background:#eff6ff}
    .stat-icon.red{background:#fff0f0}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    /* ── Rekap panel ── */
    .rekap-panel{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;border-left:3px solid var(--brand-500)}
    .rekap-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);margin-bottom:12px;display:flex;align-items:center;gap:8px}
    .rekap-form-row{display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end}
    .field{display:flex;flex-direction:column;gap:4px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text2)}
    .field select,.field input{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .field select:focus,.field input:focus{border-color:var(--brand-500);background:#fff}

    /* ── Alert toast ── */
    .alert{display:flex;align-items:center;gap:10px;padding:11px 16px;border-radius:var(--radius-sm);margin-bottom:14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600}
    .alert-warning{background:#fffbeb;border:1px solid #fde68a;color:#92400e}
    .alert-info{background:#eff6ff;border:1px solid #bfdbfe;color:#1e40af}

    /* ── Filter card ── */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row input[type=date]{height:36px;padding:0 10px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;width:148px}
    .filter-row select:focus,.filter-row input:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s}
    .btn-filter:hover{background:var(--brand-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:background .15s}
    .btn-reset:hover{background:var(--surface3)}

    /* ── Table card ── */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border)}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    td.muted{color:var(--text3)}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}

    /* ── Badges ── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-hadir {background:#dcfce7;color:#15803d} .badge-hadir  .badge-dot{background:#15803d}
    .badge-telat {background:#fefce8;color:#a16207} .badge-telat  .badge-dot{background:#a16207}
    .badge-izin  {background:#eff6ff;color:#1d4ed8} .badge-izin   .badge-dot{background:#1d4ed8}
    .badge-sakit {background:#fdf4ff;color:#7c3aed} .badge-sakit  .badge-dot{background:#7c3aed}
    .badge-alfa  {background:#fee2e2;color:#dc2626} .badge-alfa   .badge-dot{background:#dc2626}
    .badge-manual{background:var(--surface3);color:var(--text2)} .badge-manual .badge-dot{background:var(--text3)}
    .badge-qr    {background:#ecfdf5;color:#065f46} .badge-qr     .badge-dot{background:#065f46}

    /* ── Two-line cell ── */
    .two-line .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .two-line .secondary{font-size:12px;color:var(--text3);margin-top:1px}

    /* ── Action group ── */
    .action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap}

    /* ── Empty state ── */
    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    /* ── Pagination ── */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px;align-items:center}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2);border-color:var(--border2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}

    /* ── Import modal ── */
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:300;align-items:center;justify-content:center}
    .modal-overlay.active{display:flex}
    .modal{background:var(--surface);border-radius:var(--radius);width:440px;max-width:calc(100vw - 32px);box-shadow:0 20px 60px rgba(0,0,0,.15);overflow:hidden}
    .modal-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border)}
    .modal-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text)}
    .modal-close{width:28px;height:28px;display:flex;align-items:center;justify-content:center;border:none;background:var(--surface2);border-radius:6px;cursor:pointer;color:var(--text3)}
    .modal-close:hover{background:var(--surface3);color:var(--text)}
    .modal-body{padding:20px}
    .modal-footer{display:flex;gap:8px;justify-content:flex-end;padding:14px 20px;border-top:1px solid var(--border);background:var(--surface2)}
    .upload-area{border:2px dashed var(--border2);border-radius:var(--radius-sm);padding:24px;text-align:center;background:var(--surface2);cursor:pointer;transition:border-color .15s,background .15s}
    .upload-area:hover{border-color:var(--brand-500);background:#f8fbff}
    .upload-area input[type=file]{display:none}
    .upload-area-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);margin-bottom:4px}
    .upload-area-hint{font-size:12px;color:var(--text3)}
    .upload-area-filename{font-size:12.5px;color:var(--brand-600);margin-top:8px;font-weight:600}

    @media(max-width:640px){
        .stats-strip{grid-template-columns:1fr 1fr}
        .page{padding:16px}
        .header-actions{width:100%}
    }
</style>

<div class="page">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Data Absensi Siswa</h1>
            <p class="page-sub">Kelola dan pantau kehadiran siswa setiap hari</p>
        </div>
        <div class="header-actions">

            {{-- Catat Absensi --}}
            <a href="{{ route('admin.absensi.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Catat Absensi
            </a>

            {{-- Rekap Kelas --}}
            <button type="button" onclick="toggleRekap()" class="btn btn-secondary" id="rekapBtn">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                Rekap Kelas
            </button>

            {{-- Export dropdown --}}
            <div class="dropdown" id="exportDropdown">
                <button type="button" class="btn btn-secondary" onclick="toggleDropdown('exportDropdown')">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="dropdown-menu">

                    {{-- Export data tabel (mengikuti filter aktif) --}}
                    <div class="dropdown-section-label">Data Absensi</div>
                    <a href="{{ route('admin.absensi.export.pdf', request()->query()) }}" class="dropdown-item">
                        <svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Export PDF
                    </a>
                    <a href="{{ route('admin.absensi.export.excel', request()->query()) }}" class="dropdown-item">
                        <svg width="14" height="14" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Export Excel
                    </a>

                    <hr class="dropdown-divider">

                    {{--
                        Export Rekap — hanya aktif kalau ada parameter rekap.
                        Link diarahkan ke route rekap-kelas.export.pdf / excel
                        yang menerima kelas_id + tanggal_dari + tanggal_sampai via GET.
                        Jika parameter belum diisi, gunakan JS untuk tampilkan rekap panel dulu.
                    --}}
                    <div class="dropdown-section-label">Rekap Per Kelas</div>
                    @if(request()->filled('kelas_id') && request()->filled('tanggal_dari') && request()->filled('tanggal_sampai'))
                        <a href="{{ route('admin.absensi.rekap-kelas.export.pdf', [
                                'kelas_id'       => request('kelas_id'),
                                'tanggal_dari'   => request('tanggal_dari'),
                                'tanggal_sampai' => request('tanggal_sampai'),
                            ]) }}" class="dropdown-item">
                            <svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                            Export Rekap PDF
                        </a>
                        <a href="{{ route('admin.absensi.rekap-kelas.export.excel', [
                                'kelas_id'       => request('kelas_id'),
                                'tanggal_dari'   => request('tanggal_dari'),
                                'tanggal_sampai' => request('tanggal_sampai'),
                            ]) }}" class="dropdown-item">
                            <svg width="14" height="14" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                            Export Rekap Excel
                        </a>
                    @else
                        {{-- Belum ada parameter rekap → arahkan user isi form rekap dulu --}}
                        <button type="button" class="dropdown-item" onclick="onRekapExportClick()">
                            <svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                            Export Rekap PDF
                        </button>
                        <button type="button" class="dropdown-item" onclick="onRekapExportClick()">
                            <svg width="14" height="14" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                            Export Rekap Excel
                        </button>
                    @endif
                </div>
            </div>

            {{-- Import dropdown --}}
            <div class="dropdown" id="importDropdown">
                <button type="button" class="btn btn-secondary" onclick="toggleDropdown('importDropdown')">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Import
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="dropdown-menu">
                    <a href="{{ route('admin.absensi.import.template') }}" class="dropdown-item">
                        <svg width="14" height="14" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Download Template
                    </a>
                    <button type="button" class="dropdown-item" onclick="openImportModal()">
                        <svg width="14" height="14" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        Upload File Excel
                    </button>
                </div>
            </div>

        </div>
    </div>

    {{-- ── Rekap alert jika parameter belum terisi ── --}}
    {{-- Hanya muncul bila ada session hint --}}
    @if(session('rekap_hint'))
    <div class="alert alert-warning" id="rekapAlert">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('rekap_hint') }}
        <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;cursor:pointer;color:inherit;font-size:15px;line-height:1">&times;</button>
    </div>
    @endif

    {{-- ── Stats Hari Ini ── --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Hadir</p>
                <p class="stat-val">{{ $rekap['hadir'] }}</p>
                <p class="stat-sub">hari ini</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Izin</p>
                <p class="stat-val">{{ $rekap['izin'] }}</p>
                <p class="stat-sub">hari ini</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            </div>
            <div>
                <p class="stat-label">Sakit</p>
                <p class="stat-val">{{ $rekap['sakit'] }}</p>
                <p class="stat-sub">hari ini</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div>
                <p class="stat-label">Alfa</p>
                <p class="stat-val">{{ $rekap['alfa'] }}</p>
                <p class="stat-sub">hari ini</p>
            </div>
        </div>
    </div>

    {{-- ── Rekap Kelas Form ── --}}
    {{-- Panel ini muncul/sembunyi via JS, dan auto-tampil kalau URL punya parameter rekap --}}
    <div class="rekap-panel" id="rekapPanel" style="display:none">
        <p class="rekap-title">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            Filter Rekap Absensi Per Kelas
        </p>

        {{--
            FIX PENTING: method GET agar query string tersedia di request()
            sehingga link export rekap bisa baca parameter tanpa session/POST.
            Route admin.absensi.rekap-kelas menggunakan GET (sudah diperbaiki di controller).
        --}}
        <form action="{{ route('admin.absensi.rekap-kelas') }}" method="GET" id="rekapForm">
            <div class="rekap-form-row">
                <div class="field">
                    <label>Kelas <span style="color:#dc2626">*</span></label>
                    <select name="kelas_id" required style="min-width:180px">
                        <option value="">— Pilih Kelas —</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Dari Tanggal <span style="color:#dc2626">*</span></label>
                    <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" required>
                </div>
                <div class="field">
                    <label>Sampai Tanggal <span style="color:#dc2626">*</span></label>
                    <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" required>
                </div>
                <div style="display:flex;gap:8px;align-items:flex-end">
                    <button type="submit" class="btn-filter">
                        Lihat Rekap &amp; Aktifkan Export
                    </button>
                    <button type="button" onclick="closeRekap()" class="btn-reset">Tutup</button>
                </div>
            </div>
        </form>

        {{-- Jika sudah ada hasil rekap, tampilkan link export langsung di panel --}}
        @if(request()->filled('kelas_id') && request()->filled('tanggal_dari') && request()->filled('tanggal_sampai'))
        <div style="margin-top:12px;padding-top:12px;border-top:1px solid var(--border);display:flex;gap:8px;flex-wrap:wrap;align-items:center">
            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)">Export rekap ini:</span>
            <a href="{{ route('admin.absensi.rekap-kelas.export.pdf', [
                    'kelas_id'       => request('kelas_id'),
                    'tanggal_dari'   => request('tanggal_dari'),
                    'tanggal_sampai' => request('tanggal_sampai'),
                ]) }}" class="btn btn-sm" style="background:#fff0f0;color:#dc2626;border:1px solid #fecaca">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg>
                PDF
            </a>
            <a href="{{ route('admin.absensi.rekap-kelas.export.excel', [
                    'kelas_id'       => request('kelas_id'),
                    'tanggal_dari'   => request('tanggal_dari'),
                    'tanggal_sampai' => request('tanggal_sampai'),
                ]) }}" class="btn btn-sm" style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg>
                Excel
            </a>
            <a href="{{ route('admin.absensi.rekap-kelas', [
                    'kelas_id'       => request('kelas_id'),
                    'tanggal_dari'   => request('tanggal_dari'),
                    'tanggal_sampai' => request('tanggal_sampai'),
                ]) }}" class="btn btn-sm btn-detail">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Lihat Halaman Rekap
            </a>
        </div>
        @endif
    </div>

    {{-- ── Filter ── --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.absensi.index') }}">
            <div class="filter-row">
                <select name="kelas_id">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <select name="status">
                    <option value="">Semua Status</option>
                    @foreach($statusList as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>

                <select name="metode">
                    <option value="">Semua Metode</option>
                    @foreach($metodeList as $m)
                        <option value="{{ $m }}" {{ request('metode') == $m ? 'selected' : '' }}>
                            {{ $m === 'qr' ? 'QR Code' : 'Manual' }}
                        </option>
                    @endforeach
                </select>

                <input type="date" name="tanggal_dari"   value="{{ request('tanggal_dari') }}"   placeholder="Dari tanggal">
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" placeholder="Sampai tanggal">

                <div class="filter-sep"></div>

                <a href="{{ route('admin.absensi.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- ── Table ── --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Absensi
                @if($absensi->total() > 0)
                    <span>— menampilkan {{ $absensi->firstItem() }}–{{ $absensi->lastItem() }} dari {{ $absensi->total() }} data</span>
                @else
                    <span>— tidak ada data</span>
                @endif
            </p>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th class="center">Status</th>
                        <th class="center">Metode</th>
                        <th>Jam Masuk</th>
                        <th>Keterangan</th>
                        <th class="center" style="width:190px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $index => $a)
                    <tr>
                        <td><span class="no-col">{{ $absensi->firstItem() + $index }}</span></td>

                        <td>
                            <div class="two-line">
                                <p class="primary">{{ $a->siswa->nama_lengkap ?? '—' }}</p>
                                <p class="secondary">NIS: {{ $a->siswa->nis ?? '—' }}</p>
                            </div>
                        </td>

                        <td class="muted" style="font-size:12.5px">{{ $a->kelas->nama_kelas ?? '—' }}</td>

                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px">
                            {{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}
                        </td>

                        <td class="center">
                            <span class="badge badge-{{ $a->status }}">
                                <span class="badge-dot"></span>
                                {{ ucfirst($a->status) }}
                            </span>
                        </td>

                        <td class="center">
                            @if($a->metode === 'qr')
                                <span class="badge badge-qr">
                                    <span class="badge-dot"></span>QR Code
                                </span>
                            @elseif($a->metode === 'manual')
                                <span class="badge badge-manual">
                                    <span class="badge-dot"></span>Manual
                                </span>
                            @else
                                <span class="muted" style="font-size:12px">—</span>
                            @endif
                        </td>

                        <td class="muted" style="font-size:13px">
                            {{ $a->jam_masuk ? \Carbon\Carbon::parse($a->jam_masuk)->format('H:i') : '—' }}
                        </td>

                        <td style="font-size:12.5px;color:var(--text2);max-width:160px">
                            <p style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                                {{ $a->keterangan ?? '—' }}
                            </p>
                        </td>

                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.absensi.show', $a->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('admin.absensi.edit', $a->id) }}"  class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('admin.absensi.destroy', $a->id) }}" method="POST"
                                      id="delAbsensi-{{ $a->id }}" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(
                                            document.getElementById('delAbsensi-{{ $a->id }}'),
                                            '{{ addslashes($a->siswa->nama_lengkap ?? '') }}',
                                            '{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}'
                                        )">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                </div>
                                <p class="empty-title">Belum ada data absensi</p>
                                <p class="empty-sub">Coba ubah filter atau catat absensi baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($absensi->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">
                Menampilkan {{ $absensi->firstItem() }} – {{ $absensi->lastItem() }}
                dari {{ $absensi->total() }} absensi
            </p>
            <div class="pag-btns">
                @if($absensi->onFirstPage())
                    <span class="pag-btn disabled">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $absensi->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                @foreach($absensi->getUrlRange(1, $absensi->lastPage()) as $page => $url)
                    @if($page == $absensi->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $absensi->lastPage() || abs($page - $absensi->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $absensi->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                @if($absensi->hasMorePages())
                    <a href="{{ $absensi->nextPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                @else
                    <span class="pag-btn disabled">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- ── Import Modal ── --}}
<div class="modal-overlay" id="importModal">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Import Data Absensi</span>
            <button type="button" class="modal-close" onclick="closeImportModal()">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.absensi.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="alert alert-info" style="margin-bottom:16px">
                    💡 Pastikan format file sesuai template.
                    <a href="{{ route('admin.absensi.import.template') }}" style="color:#1750c0;text-decoration:underline;margin-left:4px">Download template</a>
                </div>
                <div class="upload-area" onclick="document.getElementById('importFileInput').click()">
                    <input type="file" name="file" id="importFileInput" accept=".xlsx,.xls"
                           onchange="onFileChange(this)">
                    <svg width="32" height="32" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 8px"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    <p class="upload-area-label">Klik untuk pilih file Excel</p>
                    <p class="upload-area-hint">.xlsx atau .xls — maks. 5 MB</p>
                    <p id="importFilename" class="upload-area-filename" style="display:none"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeImportModal()">Batal</button>
                <button type="submit" class="btn btn-primary" id="importSubmitBtn" disabled>
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Proses Import
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
/* ── Toast notifications ── */
@if(session('success'))
Swal.fire({
    icon: 'success', title: 'Berhasil!',
    text: @json(session('success')),
    timer: 2800, showConfirmButton: false,
    toast: true, position: 'top-end'
});
@endif
@if(session('error'))
Swal.fire({
    icon: 'error', title: 'Gagal!',
    text: @json(session('error')),
    confirmButtonColor: '#1f63db'
});
@endif
@if($errors->any())
Swal.fire({
    icon: 'warning', title: 'Perhatian!',
    html: `{!! implode('<br>', $errors->all()) !!}`,
    confirmButtonColor: '#1f63db'
});
@endif

/* ── Confirm delete ── */
function confirmDelete(form, nama, tanggal) {
    Swal.fire({
        title: 'Hapus Absensi?',
        html: `Absensi <strong>${nama}</strong> tanggal <strong>${tanggal}</strong> akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) form.submit(); });
}

/* ── Rekap panel toggle ── */
const REKAP_HAS_PARAMS = {{ (request()->filled('kelas_id') && request()->filled('tanggal_dari') && request()->filled('tanggal_sampai')) ? 'true' : 'false' }};

function toggleRekap() {
    const panel = document.getElementById('rekapPanel');
    const isVisible = panel.style.display !== 'none';
    panel.style.display = isVisible ? 'none' : 'block';
    if (!isVisible) panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function closeRekap() {
    document.getElementById('rekapPanel').style.display = 'none';
}

/* Auto-buka rekap panel kalau URL sudah punya parameter rekap */
if (REKAP_HAS_PARAMS) {
    document.getElementById('rekapPanel').style.display = 'block';
}

/* Kalau user klik export rekap tapi parameter belum ada */
function onRekapExportClick() {
    document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
    document.getElementById('rekapPanel').style.display = 'block';
    document.getElementById('rekapPanel').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    Swal.fire({
        icon: 'info',
        title: 'Isi Filter Rekap Dulu',
        text: 'Pilih kelas dan rentang tanggal, lalu klik "Lihat Rekap & Aktifkan Export" untuk mengaktifkan export rekap.',
        confirmButtonColor: '#1f63db',
        confirmButtonText: 'Mengerti',
    });
}

/* ── Dropdown helper ── */
function toggleDropdown(id) {
    const el = document.getElementById(id);
    const isOpen = el.classList.contains('open');
    document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
    if (!isOpen) el.classList.add('open');
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
    }
});

/* ── Import modal ── */
function openImportModal() {
    document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
    document.getElementById('importModal').classList.add('active');
}

function closeImportModal() {
    document.getElementById('importModal').classList.remove('active');
}

document.getElementById('importModal').addEventListener('click', function(e) {
    if (e.target === this) closeImportModal();
});

function onFileChange(input) {
    const name     = input.files[0]?.name || '';
    const label    = document.getElementById('importFilename');
    const submitBtn = document.getElementById('importSubmitBtn');
    label.textContent = name;
    label.style.display = name ? 'block' : 'none';
    submitBtn.disabled = !name;
}
</script>
</x-app-layout>