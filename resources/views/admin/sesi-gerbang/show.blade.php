<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}
    .btn-warn{background:#fffbeb;color:#a16207;border:1px solid #fde68a}
    .btn-warn:hover{background:#fef9c3;filter:none}
    .btn-purple{background:#faf5ff;color:#7c3aed;border:1px solid #e9d5ff}
    .btn-purple:hover{background:#f3e8ff;filter:none}

    /* ── Live banner ── */
    .live-banner{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:14px 20px;border-radius:var(--radius);border:1px solid #6ee7b7;background:linear-gradient(135deg,#ecfdf5,#d1fae5);margin-bottom:20px;flex-wrap:wrap}
    .live-banner-left{display:flex;align-items:center;gap:12px}
    .live-dot{display:inline-block;width:8px;height:8px;border-radius:50%;background:#22c55e;flex-shrink:0;animation:pulse-live 1.4s ease-in-out infinite}
    @keyframes pulse-live{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.45;transform:scale(1.5)}}
    .live-banner-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:#065f46}
    .live-banner-meta{font-size:12px;color:#059669;margin-top:2px}

    /* ── Info grid ── */
    .info-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .info-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 18px}
    .info-card-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:4px}
    .info-card-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.1}
    .info-card-sub{font-size:12px;color:var(--text3);margin-top:3px}

    /* ── Meta card ── */
    .meta-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:20px 24px;margin-bottom:16px}
    .meta-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
    .meta-item-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:5px}
    .meta-item-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text)}
    .meta-item-sub{font-size:12px;color:var(--text3);margin-top:1px}
    .meta-divider{border:none;border-top:1px solid var(--border);margin:16px 0}
    .catatan-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 16px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2);margin-top:8px}

    /* ── Badges ── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-aktif   {background:#dcfce7;color:#15803d} .badge-aktif    .badge-dot{background:#15803d}
    .badge-ditutup {background:#f1f5f9;color:#475569} .badge-ditutup  .badge-dot{background:#94a3b8}
    .badge-masuk   {background:#dbeafe;color:#1d4ed8} .badge-masuk    .badge-dot{background:#1d4ed8}
    .badge-pulang  {background:#ede9fe;color:#6d28d9} .badge-pulang   .badge-dot{background:#6d28d9}
    .badge-normal  {background:#dcfce7;color:#15803d} .badge-normal   .badge-dot{background:#15803d}
    .badge-duplikat{background:#fef9c3;color:#a16207} .badge-duplikat .badge-dot{background:#a16207}
    .badge-manual  {background:#ede9fe;color:#6d28d9} .badge-manual   .badge-dot{background:#6d28d9}
    .badge-koreksi {background:#dbeafe;color:#1d4ed8} .badge-koreksi  .badge-dot{background:#1d4ed8}
    .badge-error   {background:#fee2e2;color:#dc2626} .badge-error    .badge-dot{background:#dc2626}

    /* ── Stats mini ── */
    .stats-row{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:16px}
    .stat-mini{display:flex;align-items:center;gap:10px;padding:12px 16px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);flex:1;min-width:140px}
    .stat-mini-icon{width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-mini-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-mini-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.1}

    /* ── Filter ── */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:12px 16px;margin-bottom:14px}
    .filter-row{display:flex;flex-wrap:wrap;gap:8px;align-items:center}
    .filter-row select{height:34px;padding:0 10px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row select:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:34px;padding:0 16px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer}
    .btn-reset{height:34px;padding:0 12px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center}
    .btn-reset:hover{background:var(--surface3)}

    /* ── Table ── */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:8px}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:10px 13px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:9px 13px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    td.muted{color:var(--text3)}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)}
    .two-line .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}
    .two-line .secondary{font-size:11.5px;color:var(--text3);margin-top:1px}
    .manual-tag{display:inline-flex;align-items:center;gap:3px;padding:1px 6px;border-radius:4px;font-size:10.5px;font-weight:700;background:#f3e8ff;color:#6d28d9;margin-left:4px}

    /* ── Empty ── */
    .empty-state{padding:50px 20px;text-align:center}
    .empty-icon{width:52px;height:52px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--text);margin-bottom:4px}
    .empty-sub{font-size:12.5px;color:var(--text3)}

    /* ── Pag ── */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-top:1px solid var(--border);flex-wrap:wrap;gap:8px}
    .pag-info{font-size:12px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px}
    .pag-btn{height:30px;min-width:30px;padding:0 7px;border-radius:6px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:12px;padding:0 3px}

    @media(max-width:1100px){.info-grid{grid-template-columns:repeat(2,1fr)};.meta-grid{grid-template-columns:1fr 1fr}}
    @media(max-width:640px){.info-grid{grid-template-columns:1fr 1fr};.meta-grid{grid-template-columns:1fr};.page{padding:16px}}
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">
                Detail Sesi — {{ $sesiGerbang->label_tipe }}
                <span class="badge badge-{{ $sesiGerbang->status }}" style="font-size:13px;vertical-align:middle;margin-left:6px">
                    @if($sesiGerbang->status === 'aktif')
                        <span class="live-dot" style="width:5px;height:5px;margin-right:2px"></span>
                    @else
                        <span class="badge-dot"></span>
                    @endif
                    {{ ucfirst($sesiGerbang->status) }}
                </span>
            </h1>
            <p class="page-sub">{{ \Carbon\Carbon::parse($sesiGerbang->tanggal)->isoFormat('dddd, D MMMM Y') }}</p>
        </div>
        <div class="header-actions">
            @if($sesiGerbang->status === 'aktif')
                {{-- Toggle tipe (hanya jika belum ada scan) --}}
                @if($statistik['total_scan'] === 0)
                <form method="POST" action="{{ route('admin.sesi-gerbang.toggle-tipe', $sesiGerbang) }}" style="display:inline">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-purple"
                            onclick="return confirm('Ubah tipe sesi ini?')">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                        Ubah ke {{ $sesiGerbang->tipe === 'masuk' ? 'Pulang' : 'Masuk' }}
                    </button>
                </form>
                @endif

                <form method="POST" action="{{ route('admin.sesi-gerbang.tutup', $sesiGerbang) }}"
                      id="formTutup" style="display:inline">
                    @csrf @method('PATCH')
                    <button type="button" class="btn btn-warn"
                            onclick="confirmTutup()">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="9" y1="9" x2="15" y2="15"/><line x1="15" y1="9" x2="9" y2="15"/></svg>
                        Tutup Sesi
                    </button>
                </form>
            @endif

            <a href="{{ route('admin.sesi-gerbang.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Live Banner --}}
    @if($sesiGerbang->status === 'aktif')
    <div class="live-banner" style="margin-bottom:20px">
        <div class="live-banner-left">
            <span class="live-dot"></span>
            <div>
                <p class="live-banner-title">Sesi sedang berjalan</p>
                <p class="live-banner-meta">
                    Dibuka sejak {{ $sesiGerbang->dibuka_pada->format('H:i') }}
                    &middot; Sudah {{ $sesiGerbang->dibuka_pada->diffForHumans(null, true) }}
                    &middot; <span id="liveScanCount">{{ $statistik['scan_valid'] }}</span> scan valid
                </p>
            </div>
        </div>
    </div>
    @endif

    {{-- Statistik mini --}}
    <div class="stats-row">
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#eff6ff">
                <svg width="16" height="16" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
            </div>
            <div>
                <p class="stat-mini-label">Total Scan</p>
                <p class="stat-mini-val">{{ $statistik['total_scan'] }}</p>
            </div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#f0fdf4">
                <svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-mini-label">Scan Valid</p>
                <p class="stat-mini-val" id="statScanValid">{{ $statistik['scan_valid'] }}</p>
            </div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#fef9c3">
                <svg width="16" height="16" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div>
                <p class="stat-mini-label">Duplikat</p>
                <p class="stat-mini-val">{{ $statistik['scan_duplikat'] }}</p>
            </div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#faf5ff">
                <svg width="16" height="16" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div>
                <p class="stat-mini-label">Manual</p>
                <p class="stat-mini-val">{{ $statistik['scan_manual'] }}</p>
            </div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#fff0f0">
                <svg width="16" height="16" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
                <p class="stat-mini-label">Tdk Dikenal</p>
                <p class="stat-mini-val">{{ $statistik['tidak_dikenal'] }}</p>
            </div>
        </div>
    </div>

    {{-- Meta info sesi --}}
    <div class="meta-card" style="margin-bottom:16px">
        <div class="meta-grid">
            <div>
                <p class="meta-item-label">Tipe Sesi</p>
                <p class="meta-item-val">
                    <span class="badge badge-{{ $sesiGerbang->tipe }}">
                        <span class="badge-dot"></span>{{ $sesiGerbang->label_tipe }}
                    </span>
                </p>
            </div>
            <div>
                <p class="meta-item-label">Dibuka Pukul</p>
                <div class="two-line">
                    <p class="primary" style="font-family:'DM Sans',sans-serif;font-variant-numeric:tabular-nums;font-size:15px">{{ $sesiGerbang->dibuka_pada->format('H:i:s') }}</p>
                    <p class="secondary">oleh {{ $sesiGerbang->dibukaOleh?->name ?? '—' }}</p>
                </div>
            </div>
            <div>
                <p class="meta-item-label">Ditutup Pukul</p>
                @if($sesiGerbang->ditutup_pada)
                <div class="two-line">
                    <p class="primary" style="font-family:'DM Sans',sans-serif;font-variant-numeric:tabular-nums;font-size:15px">{{ $sesiGerbang->ditutup_pada->format('H:i:s') }}</p>
                    <p class="secondary">oleh {{ $sesiGerbang->ditutupOleh?->name ?? '—' }}</p>
                </div>
                @else
                <p class="meta-item-val" style="color:var(--text3)">— Belum ditutup</p>
                @endif
            </div>
            @if($sesiGerbang->ditutup_pada)
            <div>
                <p class="meta-item-label">Durasi Sesi</p>
                @php
                    $menit = $sesiGerbang->dibuka_pada->diffInMinutes($sesiGerbang->ditutup_pada);
                    $jam   = intdiv($menit, 60);
                    $sisa  = $menit % 60;
                @endphp
                <p class="meta-item-val">{{ $jam > 0 ? $jam.' jam ' : '' }}{{ $sisa }} menit</p>
            </div>
            @endif
        </div>

        @if($sesiGerbang->catatan)
        <hr class="meta-divider">
        <p class="meta-item-label">Catatan Sesi</p>
        <p class="catatan-box">{{ $sesiGerbang->catatan }}</p>
        @endif
    </div>

    {{-- Filter scan --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.sesi-gerbang.show', $sesiGerbang) }}">
            <div class="filter-row">
                <select name="status_scan" onchange="this.form.submit()">
                    <option value="">Semua Status Scan</option>
                    <option value="normal"   @selected(request('status_scan') === 'normal')>Normal</option>
                    <option value="duplikat" @selected(request('status_scan') === 'duplikat')>Duplikat</option>
                    <option value="manual"   @selected(request('status_scan') === 'manual')>Manual</option>
                    <option value="koreksi"  @selected(request('status_scan') === 'koreksi')>Koreksi</option>
                    <option value="error"    @selected(request('status_scan') === 'error')>Error</option>
                </select>
                <select name="tipe_scan" onchange="this.form.submit()">
                    <option value="">Semua Tipe Scan</option>
                    <option value="masuk"  @selected(request('tipe_scan') === 'masuk')>Masuk</option>
                    <option value="pulang" @selected(request('tipe_scan') === 'pulang')>Pulang</option>
                </select>
                <select name="kelas_id" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" @selected(request('kelas_id') == $kelas->id)>
                            {{ $kelas->tingkat }} {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                <div class="filter-sep"></div>
                @if(request()->hasAny(['status_scan','tipe_scan','kelas_id']))
                    <a href="{{ route('admin.sesi-gerbang.show', $sesiGerbang) }}" class="btn-reset">Reset</a>
                @endif
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- Table scan --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Log Scan
                @if($scanList->total() > 0)
                    <span>— {{ $scanList->firstItem() }}–{{ $scanList->lastItem() }} dari {{ $scanList->total() }} data</span>
                @else
                    <span>— tidak ada data</span>
                @endif
            </p>
            @if($sesiGerbang->status === 'aktif')
            <button type="button" class="btn btn-sm btn-primary" onclick="refreshPage()" id="btnRefresh">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                Refresh
            </button>
            @endif
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:42px">#</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th class="center">Status</th>
                        <th class="center">Tipe</th>
                        <th>Waktu Scan</th>
                        <th>Input Oleh</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($scanList as $index => $scan)
                    <tr>
                        <td><span class="no-col">{{ $scanList->firstItem() + $index }}</span></td>

                        {{-- Siswa --}}
                        <td>
                            @if($scan->siswa)
                            <div class="two-line">
                                <p class="primary">{{ $scan->siswa->nama_lengkap }}</p>
                                <p class="secondary">{{ $scan->siswa->nisn ?? $scan->rfid_tag ?? '—' }}</p>
                            </div>
                            @else
                            <div class="two-line">
                                <p class="primary" style="color:#dc2626">Tidak Dikenal</p>
                                <p class="secondary">{{ $scan->rfid_tag ?? '—' }}</p>
                            </div>
                            @endif
                        </td>

                        {{-- Kelas --}}
                        <td>
                            @if($scan->siswa?->kelas)
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700">
                                    {{ $scan->siswa->kelas->tingkat }} {{ $scan->siswa->kelas->nama_kelas }}
                                </span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="center">
                            <span class="badge badge-{{ $scan->status }}">
                                <span class="badge-dot"></span>
                                {{ ucfirst($scan->status) }}
                            </span>
                            @if($scan->is_manual)
                                <span class="manual-tag">Manual</span>
                            @endif
                        </td>

                        {{-- Tipe --}}
                        <td class="center">
                            <span class="badge badge-{{ $scan->tipe }}">
                                <span class="badge-dot"></span>
                                {{ ucfirst($scan->tipe) }}
                            </span>
                        </td>

                        {{-- Waktu --}}
                        <td>
                            <span style="font-family:'DM Sans',sans-serif;font-variant-numeric:tabular-nums;font-size:13px;font-weight:600">
                                {{ $scan->waktu_scan->format('H:i:s') }}
                            </span>
                        </td>

                        {{-- Input oleh --}}
                        <td>
                            <span style="font-size:12.5px;color:var(--text2)">
                                {{ $scan->inputOleh?->name ?? 'Sistem' }}
                            </span>
                        </td>

                        {{-- Keterangan --}}
                        <td>
                            <span style="font-size:12.5px;color:var(--text3)">
                                {{ $scan->keterangan ?? '—' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                                </div>
                                <p class="empty-title">Belum ada data scan</p>
                                <p class="empty-sub">
                                    @if($sesiGerbang->status === 'aktif')
                                        Menunggu scan dari alat gerbang...
                                    @else
                                        Tidak ada scan yang tercatat di sesi ini
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($scanList->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $scanList->firstItem() }}–{{ $scanList->lastItem() }} dari {{ $scanList->total() }} data</p>
            <div class="pag-btns">
                @if($scanList->onFirstPage())
                    <span class="pag-btn disabled"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $scanList->previousPageUrl() }}" class="pag-btn"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif

                @php $current = $scanList->currentPage(); $last = $scanList->lastPage(); @endphp
                @foreach($scanList->getUrlRange(1, $last) as $page => $url)
                    @php $nearCurrent = abs($page - $current) <= 1; $isEdge = $page === 1 || $page === $last; @endphp
                    @if($isEdge || $nearCurrent)
                        @if($page === $current)
                            <span class="pag-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                        @endif
                    @elseif($page === $current - 2 || $page === $current + 2)
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
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif

    function confirmTutup() {
        Swal.fire({
            title: 'Tutup Sesi {{ addslashes($sesiGerbang->label_tipe) }}?',
            text: 'Scanner tidak akan menerima scan baru setelah sesi ditutup.',
            icon: 'question', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Tutup Sesi', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('formTutup').submit(); });
    }

    function refreshPage() {
        window.location.reload();
    }

    @if($sesiGerbang->status === 'aktif')
    // Live-refresh scan count setiap 10 detik untuk sesi aktif
    (function () {
        setInterval(async function () {
            try {
                const res  = await fetch('{{ route('admin.sesi-gerbang.ajax.aktif') }}');
                const data = await res.json();
                if (!data.ada_sesi_aktif) return;
                const s = data.sesi.find(x => x.id === {{ $sesiGerbang->id }});
                if (s) {
                    const el1 = document.getElementById('liveScanCount');
                    const el2 = document.getElementById('statScanValid');
                    if (el1) el1.textContent = s.jumlah_scan;
                    if (el2) el2.textContent = s.jumlah_scan;
                }
            } catch (e) { /* silent */ }
        }, 10000);
    })();
    @endif
</script>
</x-app-layout>