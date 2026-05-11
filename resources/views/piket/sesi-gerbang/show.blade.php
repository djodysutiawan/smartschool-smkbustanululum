<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#15803d;--green-bg:#dcfce7;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --yellow:#a16207;--yellow-bg:#fefce8;--yellow-border:#fde68a;
        --purple:#7c3aed;--purple-bg:#faf5ff;--purple-border:#e9d5ff;
        --teal:#0f766e;--teal-bg:#f0fdfa;--teal-border:#99f6e4;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    .page{padding:28px 28px 48px;font-family:'DM Sans',sans-serif}
    .back-link{display:inline-flex;align-items:center;gap:6px;color:var(--text3);font-size:13px;text-decoration:none;margin-bottom:20px;transition:color .15s}
    .back-link:hover{color:var(--text2)}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:20px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:10px;flex-wrap:wrap}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:4px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;line-height:1}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-detail{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
    .btn-detail:hover{background:#dbeafe;filter:none}
    .btn-pdf{background:var(--purple-bg);color:var(--purple);border:1px solid var(--purple-border)}
    .btn-pdf:hover{background:#ede9fe;filter:none}
    .btn-tutup{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}
    .btn-tutup:hover{background:#fecaca;filter:none}
    .btn-buka{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}
    .btn-buka:hover{background:#bbf7d0;filter:none}
    .btn-edit{background:var(--yellow-bg);color:var(--yellow);border:1px solid var(--yellow-border)}
    .btn-edit:hover{background:#fef9c3;filter:none}

    .alert{padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-size:13px;display:flex;align-items:center;gap:8px}
    .alert-success{background:#f0fdf4;border:1px solid var(--green-border);color:#166534}
    .alert-error{background:var(--red-bg);border:1px solid var(--red-border);color:#991b1b}
    .alert-info{background:var(--brand-50);border:1px solid var(--brand-100);color:var(--brand-700)}

    /* Status badge */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;white-space:nowrap}
    .badge-dot{width:6px;height:6px;border-radius:50%}
    .badge-aktif{background:var(--green-bg);color:var(--green)}.badge-aktif .badge-dot{background:var(--green);animation:pulse 1.5s infinite}
    .badge-ditutup{background:var(--surface3);color:var(--text3)}.badge-ditutup .badge-dot{background:var(--text3)}
    .badge-masuk{background:var(--brand-50);color:var(--brand-600)}.badge-masuk .badge-dot{background:var(--brand-500)}
    .badge-pulang{background:var(--teal-bg);color:var(--teal)}.badge-pulang .badge-dot{background:var(--teal)}
    .badge-sm{font-size:11px;padding:2px 9px}
    @keyframes pulse{0%,100%{box-shadow:0 0 0 2px rgba(21,128,61,.2)}50%{box-shadow:0 0 0 4px rgba(21,128,61,.05)}}

    /* Stats strip */
    .stats-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:10px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;display:flex;align-items:center;gap:12px;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .stat-icon{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.blue{background:#eff6ff}.stat-icon.green{background:var(--green-bg)}.stat-icon.red{background:var(--red-bg)}.stat-icon.yellow{background:var(--yellow-bg)}.stat-icon.gray{background:var(--surface3)}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}

    /* Info panel */
    .detail-grid{display:grid;grid-template-columns:280px 1fr;gap:16px;align-items:start;margin-bottom:20px}
    .info-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .info-card-head{padding:13px 18px;border-bottom:1px solid var(--border);background:var(--surface2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;display:flex;align-items:center;gap:6px}
    .info-row{display:flex;align-items:flex-start;gap:10px;padding:12px 18px;border-bottom:1px solid var(--surface3)}
    .info-row:last-child{border-bottom:none}
    .info-icon{width:26px;height:26px;border-radius:6px;background:var(--surface2);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;margin-bottom:2px}
    .info-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text)}
    .info-sub{font-size:11.5px;color:var(--text3);margin-top:2px}

    /* Tutup form modal-style inline */
    .tutup-zone{background:var(--red-bg);border:1px solid var(--red-border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;display:none}
    .tutup-zone.open{display:block}
    .tutup-zone-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--red);margin-bottom:10px;display:flex;align-items:center;gap:7px}
    .form-control-small{width:100%;padding:8px 12px;border:1px solid var(--red-border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:#fff;outline:none;resize:vertical;min-height:60px}
    .tutup-actions{display:flex;gap:8px;margin-top:10px}

    /* Filter */
    .filter-bar{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px;align-items:center}
    .filter-bar select,.filter-bar input{height:34px;padding:0 10px;border:1px solid var(--border);border-radius:6px;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text);background:var(--surface2);outline:none}
    .btn-filter-sm{height:34px;padding:0 14px;background:var(--brand-600);color:#fff;border:none;border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer}
    .btn-reset-sm{height:34px;padding:0 12px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center}

    /* Scan table */
    .section-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .section-head{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;background:var(--surface2)}
    .section-head-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px}
    .scan-table{width:100%;border-collapse:collapse}
    .scan-table th{padding:9px 18px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid var(--border);white-space:nowrap}
    .scan-table td{padding:11px 18px;border-bottom:1px solid var(--surface3);font-size:13px;color:var(--text2);vertical-align:middle}
    .scan-table tr:last-child td{border-bottom:none}
    .scan-table tr:hover td{background:var(--surface2)}
    .siswa-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text);font-size:13px}
    .siswa-kelas{font-size:11.5px;color:var(--text3);margin-top:2px}
    .scan-status{display:inline-flex;align-items:center;gap:3px;padding:2px 9px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700}
    .scan-normal{background:var(--green-bg);color:var(--green)}
    .scan-manual{background:var(--brand-50);color:var(--brand-600)}
    .scan-koreksi{background:var(--yellow-bg);color:var(--yellow)}
    .scan-duplikat{background:var(--red-bg);color:var(--red)}
    .scan-time{font-family:'DM Mono',monospace;font-size:12px;color:var(--text3)}
    .action-cell{display:flex;gap:5px}

    /* Pagination */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 18px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12px;color:var(--text3)}
    .pag-btns{display:flex;gap:3px}
    .pag-btn{height:30px;min-width:30px;padding:0 7px;border-radius:6px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;text-decoration:none;transition:all .15s}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:12px;padding:0 3px;display:flex;align-items:center}

    /* Empty */
    .empty-cell{padding:40px 20px;text-align:center;color:var(--text3);font-size:13px}

    @media(max-width:1024px){.stats-strip{grid-template-columns:repeat(3,1fr)}}
    @media(max-width:900px){.detail-grid{grid-template-columns:1fr}.stats-strip{grid-template-columns:repeat(2,1fr)}}
    @media(max-width:640px){.page{padding:16px}.stats-strip{grid-template-columns:1fr 1fr}}
</style>

<div class="page">
    <a href="{{ route('piket.sesi-gerbang.index') }}" class="back-link">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Riwayat Sesi
    </a>

    <div class="page-header">
        <div>
            <h1 class="page-title">
                Detail Sesi Gerbang
                <span class="badge {{ $sesiGerbang->tipe === 'masuk' ? 'badge-masuk' : 'badge-pulang' }}">
                    <span class="badge-dot"></span>{{ $sesiGerbang->label_tipe }}
                </span>
                <span class="badge {{ $sesiGerbang->status === 'aktif' ? 'badge-aktif' : 'badge-ditutup' }}">
                    <span class="badge-dot"></span>{{ $sesiGerbang->status === 'aktif' ? 'Aktif' : 'Ditutup' }}
                </span>
            </h1>
            <p class="page-sub">
                {{ $sesiGerbang->tanggal->translatedFormat('l, d F Y') }} ·
                Dibuka {{ $sesiGerbang->dibuka_pada->format('H:i') }}
                @if($sesiGerbang->ditutup_pada)· Ditutup {{ $sesiGerbang->ditutup_pada->format('H:i') }}@endif
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('piket.sesi-gerbang.export-pdf', $sesiGerbang) }}" class="btn btn-pdf" target="_blank">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export PDF
            </a>
            @if($sesiGerbang->status === 'aktif')
            <a href="{{ route('piket.sesi-gerbang.edit', $sesiGerbang) }}" class="btn btn-edit">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit Catatan
            </a>
            <button class="btn btn-tutup" onclick="toggleTutupForm()">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Tutup Sesi
            </button>
            @else
            @if($sesiGerbang->tanggal->isToday())
            <form action="{{ route('piket.sesi-gerbang.buka', $sesiGerbang) }}" method="POST"
                onsubmit="return confirm('Buka kembali sesi ini?')">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-buka">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Buka Kembali
                </button>
            </form>
            @endif
            @endif
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif
    @if(session('info'))
    <div class="alert alert-info">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('info') }}
    </div>
    @endif

    {{-- Form Tutup Sesi (inline toggle) --}}
    @if($sesiGerbang->status === 'aktif')
    <div class="tutup-zone" id="tutupZone">
        <div class="tutup-zone-title">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Tutup Sesi Gerbang
        </div>
        <form action="{{ route('piket.sesi-gerbang.tutup', $sesiGerbang) }}" method="POST">
            @csrf @method('PATCH')
            <textarea name="catatan" class="form-control-small" placeholder="Catatan penutupan sesi (opsional)…">{{ old('catatan', $sesiGerbang->catatan) }}</textarea>
            <div class="tutup-actions">
                <button type="button" onclick="toggleTutupForm()" style="padding:7px 14px;background:#fff;color:var(--red);border:1px solid var(--red-border);border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;cursor:pointer">Batal</button>
                <button type="submit" class="btn btn-tutup" style="padding:7px 14px;font-size:12px">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/></svg>
                    Ya, Tutup Sesi
                </button>
            </div>
        </form>
    </div>
    @endif

    {{-- Statistik --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="17" height="17" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </div>
            <div>
                <div class="stat-label">Total Scan</div>
                <div class="stat-val">{{ number_format($statistik['total_scan']) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="17" height="17" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <div class="stat-label">Scan Valid</div>
                <div class="stat-val">{{ number_format($statistik['scan_valid']) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="17" height="17" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
            </div>
            <div>
                <div class="stat-label">Duplikat</div>
                <div class="stat-val">{{ number_format($statistik['scan_duplikat']) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="17" height="17" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <div class="stat-label">Manual</div>
                <div class="stat-val">{{ number_format($statistik['scan_manual']) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon gray">
                <svg width="17" height="17" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
                <div class="stat-label">Tidak Dikenal</div>
                <div class="stat-val">{{ number_format($statistik['tidak_dikenal']) }}</div>
            </div>
        </div>
    </div>

    {{-- Detail + scan --}}
    <div class="detail-grid">
        {{-- Info sesi --}}
        <div>
            <div class="info-card">
                <div class="info-card-head">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Info Sesi
                </div>
                <div class="info-row">
                    <div class="info-icon"><svg width="13" height="13" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                    <div>
                        <div class="info-label">Tanggal</div>
                        <div class="info-val">{{ $sesiGerbang->tanggal->translatedFormat('l, d M Y') }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-icon"><svg width="13" height="13" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                    <div>
                        <div class="info-label">Waktu Buka</div>
                        <div class="info-val">{{ $sesiGerbang->dibuka_pada->format('H:i:s') }}</div>
                        <div class="info-sub">oleh {{ $sesiGerbang->dibukaOleh?->name ?? '—' }}</div>
                    </div>
                </div>
                @if($sesiGerbang->ditutup_pada)
                <div class="info-row">
                    <div class="info-icon"><svg width="13" height="13" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                    <div>
                        <div class="info-label">Waktu Tutup</div>
                        <div class="info-val">{{ $sesiGerbang->ditutup_pada->format('H:i:s') }}</div>
                        <div class="info-sub">oleh {{ $sesiGerbang->ditutupOleh?->name ?? '—' }}</div>
                        <div class="info-sub">Durasi: {{ $sesiGerbang->dibuka_pada->diffForHumans($sesiGerbang->ditutup_pada, true) }}</div>
                    </div>
                </div>
                @else
                <div class="info-row">
                    <div class="info-icon"><svg width="13" height="13" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                    <div>
                        <div class="info-label">Durasi Berjalan</div>
                        <div class="info-val" id="durasi">{{ $sesiGerbang->dibuka_pada->diffForHumans(now(), true) }}</div>
                    </div>
                </div>
                @endif
                @if($sesiGerbang->catatan)
                <div class="info-row">
                    <div class="info-icon"><svg width="13" height="13" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/></svg></div>
                    <div>
                        <div class="info-label">Catatan</div>
                        <div style="font-size:13px;color:var(--text2);line-height:1.5;margin-top:2px">{{ $sesiGerbang->catatan }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Log scan --}}
        <div>
            <div class="section-card">
                <div class="section-head">
                    <div class="section-head-title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        Log Scan
                        <span style="padding:2px 9px;background:var(--surface3);border-radius:99px;font-size:11px;color:var(--text3);font-weight:700">{{ $scanList->total() }}</span>
                    </div>
                </div>

                {{-- Filter scan --}}
                <div style="padding:12px 18px;border-bottom:1px solid var(--border)">
                    <form method="GET" action="{{ route('piket.sesi-gerbang.show', $sesiGerbang) }}">
                        <div class="filter-bar">
                            <select name="status_scan">
                                <option value="">Semua Status</option>
                                <option value="normal"   {{ request('status_scan') === 'normal'   ? 'selected' : '' }}>Normal</option>
                                <option value="manual"   {{ request('status_scan') === 'manual'   ? 'selected' : '' }}>Manual</option>
                                <option value="koreksi"  {{ request('status_scan') === 'koreksi'  ? 'selected' : '' }}>Koreksi</option>
                                <option value="duplikat" {{ request('status_scan') === 'duplikat' ? 'selected' : '' }}>Duplikat</option>
                            </select>
                            <select name="tipe_scan">
                                <option value="">Semua Tipe</option>
                                <option value="masuk"  {{ request('tipe_scan') === 'masuk'  ? 'selected' : '' }}>Masuk</option>
                                <option value="pulang" {{ request('tipe_scan') === 'pulang' ? 'selected' : '' }}>Pulang</option>
                            </select>
                            <select name="kelas_id">
                                <option value="">Semua Kelas</option>
                                @foreach($kelasList as $k)
                                <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            <a href="{{ route('piket.sesi-gerbang.show', $sesiGerbang) }}" class="btn-reset-sm">Reset</a>
                            <button type="submit" class="btn-filter-sm">Filter</button>
                        </div>
                    </form>
                </div>

                @if($scanList->count() > 0)
                <table class="scan-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Waktu Scan</th>
                            <th>Status</th>
                            <th>Input Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scanList as $scan)
                        @php
                            $nama = $scan->siswa?->nama_lengkap ?? $scan->guru?->nama_lengkap ?? '— Tidak Dikenal —';
                            $kelas = $scan->siswa?->kelas?->nama_kelas ?? ($scan->guru ? 'Guru' : null);
                        @endphp
                        <tr>
                            <td>
                                <div class="siswa-name">{{ $nama }}</div>
                                @if($kelas)<div class="siswa-kelas">{{ $kelas }}</div>@endif
                            </td>
                            <td>
                                @if($scan->tipe)
                                <span class="badge {{ $scan->tipe === 'masuk' ? 'badge-masuk' : 'badge-pulang' }} badge-sm">
                                    {{ $scan->tipe === 'masuk' ? 'Masuk' : 'Pulang' }}
                                </span>
                                @else<span style="color:var(--text3);font-size:12px">—</span>@endif
                            </td>
                            <td>
                                <span class="scan-time">{{ $scan->waktu_scan?->format('H:i:s') ?? '—' }}</span>
                            </td>
                            <td>
                                @php
                                    $statusClass = match($scan->status) {
                                        'normal'   => 'scan-normal',
                                        'manual'   => 'scan-manual',
                                        'koreksi'  => 'scan-koreksi',
                                        'duplikat' => 'scan-duplikat',
                                        default    => 'scan-normal',
                                    };
                                    $statusLabel = match($scan->status) {
                                        'normal'   => 'Normal',
                                        'manual'   => 'Manual',
                                        'koreksi'  => 'Koreksi',
                                        'duplikat' => 'Duplikat',
                                        default    => ucfirst($scan->status),
                                    };
                                @endphp
                                <span class="scan-status {{ $statusClass }}">{{ $statusLabel }}</span>
                                @if($scan->is_manual)
                                <span class="scan-status scan-manual" style="margin-left:3px">Manual</span>
                                @endif
                            </td>
                            <td style="font-size:12px;color:var(--text3)">{{ $scan->inputOleh?->name ?? 'Sistem' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if($scanList->hasPages())
                <div class="pag-wrap">
                    <span class="pag-info">{{ $scanList->firstItem() }}–{{ $scanList->lastItem() }} dari {{ $scanList->total() }}</span>
                    <div class="pag-btns">
                        @if($scanList->onFirstPage())
                            <span class="pag-btn disabled"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                        @else
                            <a href="{{ $scanList->previousPageUrl() }}" class="pag-btn"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                        @endif
                        @foreach($scanList->getUrlRange(1, $scanList->lastPage()) as $page => $url)
                            @if($page == $scanList->currentPage())
                                <span class="pag-btn active">{{ $page }}</span>
                            @elseif($page == 1 || $page == $scanList->lastPage() || abs($page - $scanList->currentPage()) <= 1)
                                <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                            @elseif(abs($page - $scanList->currentPage()) == 2)
                                <span class="pag-ellipsis">…</span>
                            @endif
                        @endforeach
                        @if($scanList->hasMorePages())
                            <a href="{{ $scanList->nextPageUrl() }}" class="pag-btn"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                        @else
                            <span class="pag-btn disabled"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                        @endif
                    </div>
                </div>
                @endif

                @else
                <div class="empty-cell">
                    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 8px;display:block;opacity:.3"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Belum ada data scan di sesi ini
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function toggleTutupForm() {
    const z = document.getElementById('tutupZone');
    z.classList.toggle('open');
    if (z.classList.contains('open')) z.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}
</script>
</x-app-layout>