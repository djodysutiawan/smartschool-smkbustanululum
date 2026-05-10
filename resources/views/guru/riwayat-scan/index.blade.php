<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#15803d;--green-bg:#dcfce7;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --yellow:#a16207;--yellow-bg:#fefce8;--yellow-border:#fde68a;
        --orange:#c2410c;--orange-bg:#fff7ed;--orange-border:#fed7aa;
        --purple:#7c3aed;--purple-bg:#faf5ff;--purple-border:#e9d5ff;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    .page{padding:28px 28px 48px;font-family:'DM Sans',sans-serif}

    /* Header */
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    /* Stats */
    .stats-row{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 18px;display:flex;align-items:center;gap:12px}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon-blue{background:var(--brand-50)}
    .stat-icon-green{background:var(--green-bg)}
    .stat-icon-red{background:var(--red-bg)}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1}
    .stat-lbl{font-size:11.5px;color:var(--text3);margin-top:3px}

    /* Filter card */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px}
    .filter-grid{display:grid;grid-template-columns:1fr 1fr 1fr 180px auto;gap:10px;align-items:end}
    .filter-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:5px}
    .filter-input{width:100%;padding:8px 11px;border:1px solid var(--border);border-radius:var(--radius-sm);font-size:13px;font-family:'DM Sans',sans-serif;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s}
    .filter-input:focus{border-color:var(--brand-500)}
    .filter-input option{background:#fff}

    /* Btn */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap;line-height:1}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-detail{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
    .btn-detail:hover{background:#dbeafe;filter:none}
    .btn-reset{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}
    .btn-reset:hover{background:#fecaca;filter:none}

    /* Table card */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-head-row{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
    .table-head-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px}
    .table-head-badge{padding:3px 10px;background:var(--brand-50);color:var(--brand-600);border-radius:99px;font-size:11px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif}

    .data-table{width:100%;border-collapse:collapse}
    .data-table th{padding:10px 20px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid var(--border);background:var(--surface2);white-space:nowrap}
    .data-table td{padding:12px 20px;border-bottom:1px solid var(--surface3);font-size:13px;color:var(--text2);vertical-align:middle}
    .data-table tr:last-child td{border-bottom:none}
    .data-table tr:hover td{background:var(--surface2)}

    /* Badges */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-size:11px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;white-space:nowrap}
    .badge-green{background:var(--green-bg);color:var(--green)}
    .badge-red{background:var(--red-bg);color:var(--red)}
    .badge-yellow{background:var(--yellow-bg);color:var(--yellow)}
    .badge-orange{background:var(--orange-bg);color:var(--orange)}
    .badge-gray{background:var(--surface3);color:var(--text3)}
    .badge-purple{background:var(--purple-bg);color:var(--purple)}
    .status-dot{width:5px;height:5px;border-radius:50%;display:inline-block}

    /* Siswa info */
    .siswa-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text);font-size:13px}
    .siswa-nis{font-size:11.5px;color:var(--text3);margin-top:2px}

    /* Mapel info */
    .mapel-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;color:var(--text);font-size:13px}
    .mapel-kelas{font-size:11.5px;color:var(--text3);margin-top:2px}

    /* Time */
    .scan-time{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text);font-size:13px}
    .scan-date{font-size:11.5px;color:var(--text3);margin-top:2px}

    /* Empty */
    .empty-state{padding:48px 20px;text-align:center}
    .empty-icon{width:52px;height:52px;border-radius:14px;background:var(--surface2);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;opacity:.5}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text2);margin-bottom:4px}
    .empty-sub{font-size:12.5px;color:var(--text3)}

    /* Pagination */
    .pagination-wrap{padding:14px 20px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
    .pagination-info{font-size:12.5px;color:var(--text3)}
    .pagination-links{display:flex;gap:4px;flex-wrap:wrap}
    .pagination-links .page-item .page-link{display:inline-flex;align-items:center;justify-content:center;min-width:30px;height:30px;padding:0 8px;border-radius:6px;font-size:12px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;text-decoration:none;color:var(--text2);border:1px solid var(--border);background:var(--surface);transition:all .15s}
    .pagination-links .page-item.active .page-link{background:var(--brand-600);color:#fff;border-color:var(--brand-600)}
    .pagination-links .page-item.disabled .page-link{opacity:.4;pointer-events:none}
    .pagination-links .page-item .page-link:hover:not(.active){background:var(--surface2)}

    /* Alert */
    .alert{padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-size:13px;display:flex;align-items:center;gap:8px}
    .alert-success{background:#f0fdf4;border:1px solid var(--green-border);color:#166534}
    .alert-error{background:var(--red-bg);border:1px solid var(--red-border);color:#991b1b}

    /* Today rekap */
    .rekap-bar{display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap}
    .rekap-chip{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700}
    .rekap-chip-blue{background:var(--brand-50);color:var(--brand-600);border:1px solid var(--brand-100)}
    .rekap-chip-green{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}
    .rekap-chip-red{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}

    @media(max-width:900px){
        .stats-row{grid-template-columns:1fr 1fr}
        .filter-grid{grid-template-columns:1fr 1fr}
    }
    @media(max-width:640px){
        .page{padding:16px}
        .stats-row{grid-template-columns:1fr}
        .filter-grid{grid-template-columns:1fr}
        .data-table th:nth-child(3),.data-table td:nth-child(3){display:none}
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Scan QR</h1>
            <p class="page-sub">Log absensi siswa dari sesi QR yang Anda buat</p>
        </div>
        <a href="{{ route('guru.barcode-kelas.index') }}" class="btn btn-secondary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Barcode Kelas
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Stats hari ini --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon stat-icon-blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            </div>
            <div>
                <div class="stat-val">{{ $rekap['total'] }}</div>
                <div class="stat-lbl">Total scan hari ini</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon-green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <div class="stat-val" style="color:var(--green)">{{ $rekap['valid'] }}</div>
                <div class="stat-lbl">Scan valid hari ini</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon stat-icon-red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
                <div class="stat-val" style="color:var(--red)">{{ $rekap['ditolak'] }}</div>
                <div class="stat-lbl">Scan ditolak hari ini</div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('guru.riwayat-scan.index') }}">
            <div class="filter-grid">
                {{-- Search nama siswa --}}
                <div>
                    <div class="filter-label">Cari Siswa</div>
                    <input type="text" name="search" class="filter-input"
                        placeholder="Nama siswa..."
                        value="{{ request('search') }}">
                </div>

                {{-- Filter sesi QR --}}
                <div>
                    <div class="filter-label">Sesi QR</div>
                    <select name="sesi_qr_id" class="filter-input">
                        <option value="">Semua Sesi</option>
                        @foreach($sesiList as $sesi)
                        <option value="{{ $sesi->id }}" {{ request('sesi_qr_id') == $sesi->id ? 'selected' : '' }}>
                            {{ $sesi->mataPelajaran->nama_mapel ?? '—' }} — {{ $sesi->kelas->nama_kelas ?? '—' }}
                            ({{ \Carbon\Carbon::parse($sesi->tanggal)->format('d/m/Y') }})
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter status --}}
                <div>
                    <div class="filter-label">Status Scan</div>
                    <select name="status" class="filter-input">
                        <option value="">Semua Status</option>
                        @foreach($statusList as $val => $label)
                        <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter tanggal --}}
                <div>
                    <div class="filter-label">Tanggal</div>
                    <input type="date" name="tanggal" class="filter-input"
                        value="{{ request('tanggal') }}">
                </div>

                {{-- Tombol aksi --}}
                <div style="display:flex;gap:6px">
                    <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Filter
                    </button>
                    @if(request()->hasAny(['search','sesi_qr_id','status','tanggal','tanggal_dari','tanggal_sampai']))
                    <a href="{{ route('guru.riwayat-scan.index') }}" class="btn btn-reset">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </a>
                    @endif
                </div>
            </div>

            {{-- Filter tanggal range (tersembunyi, expandable jika perlu) --}}
            @if(request()->hasAny(['tanggal_dari','tanggal_sampai']))
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:10px">
                <div>
                    <div class="filter-label">Dari Tanggal</div>
                    <input type="date" name="tanggal_dari" class="filter-input" value="{{ request('tanggal_dari') }}">
                </div>
                <div>
                    <div class="filter-label">Sampai Tanggal</div>
                    <input type="date" name="tanggal_sampai" class="filter-input" value="{{ request('tanggal_sampai') }}">
                </div>
            </div>
            @endif
        </form>
    </div>

    {{-- Tabel riwayat --}}
    <div class="table-card">
        <div class="table-head-row">
            <div class="table-head-title">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                Log Scan
                <span class="table-head-badge">{{ $riwayats->total() }} data</span>
            </div>
            <div style="font-size:12px;color:var(--text3)">
                Hal {{ $riwayats->currentPage() }} / {{ $riwayats->lastPage() }}
            </div>
        </div>

        @if($riwayats->count() > 0)
        <div style="overflow-x:auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Sesi / Mata Pelajaran</th>
                        <th>Waktu Scan</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayats as $riwayat)
                    <tr>
                        {{-- Siswa --}}
                        <td>
                            <div class="siswa-name">{{ $riwayat->siswa->nama_lengkap ?? '—' }}</div>
                            <div class="siswa-nis">NIS: {{ $riwayat->siswa->nis ?? '-' }}</div>
                        </td>

                        {{-- Sesi / Mapel --}}
                        <td>
                            <div class="mapel-name">{{ $riwayat->sesiQr->mataPelajaran->nama_mapel ?? '—' }}</div>
                            <div class="mapel-kelas">
                                {{ $riwayat->sesiQr->kelas->nama_kelas ?? '—' }}
                                &middot;
                                {{ optional($riwayat->sesiQr->tanggal)->format('d/m/Y') }}
                            </div>
                        </td>

                        {{-- Waktu scan --}}
                        <td>
                            <div class="scan-time">
                                {{ optional($riwayat->di_scan_pada)->format('H:i:s') ?? '—' }}
                            </div>
                            <div class="scan-date">
                                {{ optional($riwayat->di_scan_pada)->translatedFormat('d M Y') ?? '' }}
                            </div>
                        </td>

                        {{-- Status --}}
                        <td>
                            @php
                                $statusMap = [
                                    'valid'                 => ['class' => 'badge-green', 'label' => 'Valid'],
                                    'ditolak_radius'        => ['class' => 'badge-orange', 'label' => 'Diluar Radius'],
                                    'ditolak_kadaluarsa'    => ['class' => 'badge-yellow', 'label' => 'Kadaluarsa'],
                                    'ditolak_nonaktif'      => ['class' => 'badge-gray',   'label' => 'Sesi Nonaktif'],
                                    'ditolak_duplikat'      => ['class' => 'badge-purple', 'label' => 'Duplikat'],
                                    'ditolak_bukan_anggota' => ['class' => 'badge-red',    'label' => 'Bukan Anggota'],
                                ];
                                $st = $statusMap[$riwayat->status] ?? ['class' => 'badge-gray', 'label' => $riwayat->status];
                            @endphp
                            <span class="badge {{ $st['class'] }}">
                                <span class="status-dot" style="background:currentColor"></span>
                                {{ $st['label'] }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td>
                            <a href="{{ route('guru.riwayat-scan.show', $riwayat) }}"
                               class="btn btn-sm btn-detail">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($riwayats->hasPages())
        <div class="pagination-wrap">
            <div class="pagination-info">
                Menampilkan {{ $riwayats->firstItem() }}–{{ $riwayats->lastItem() }}
                dari {{ $riwayats->total() }} data
            </div>
            <div class="pagination-links">
                {{ $riwayats->onEachSide(1)->links() }}
            </div>
        </div>
        @endif

        @else
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            </div>
            <div class="empty-title">Belum ada riwayat scan</div>
            <div class="empty-sub">
                @if(request()->hasAny(['search','sesi_qr_id','status','tanggal']))
                    Tidak ada data yang cocok dengan filter yang dipilih.
                @else
                    Riwayat scan akan muncul setelah siswa melakukan absensi via QR.
                @endif
            </div>
        </div>
        @endif
    </div>

</div>
</x-app-layout>