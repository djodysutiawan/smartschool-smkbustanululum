<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Instrument+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');

    :root {
        --s-800:#0f2044;--s-700:#1a3a6b;--s-600:#1d4ed8;--s-500:#2563eb;
        --s-400:#3b82f6;--s-300:#93c5fd;--s-100:#dbeafe;--s-50:#eff6ff;
        --g-500:#10b981;--g-400:#34d399;--g-100:#d1fae5;--g-50:#ecfdf5;
        --a-500:#f59e0b;--a-100:#fef3c7;--a-50:#fffbeb;
        --r-500:#ef4444;--r-100:#fee2e2;--r-50:#fff5f5;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#334155;--text3:#64748b;--text4:#94a3b8;
        --radius:12px;--radius-sm:8px;--radius-xs:6px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.07);--shadow-md:0 4px 16px rgba(0,0,0,.08);
    }
    *{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:'Instrument Sans',sans-serif;}
    .page{padding:24px 28px 64px;}

    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Outfit',sans-serif;font-size:21px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text4);margin-top:3px;}
    .header-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap;}

    .btn{display:inline-flex;align-items:center;gap:7px;height:38px;padding:0 16px;border-radius:var(--radius-sm);font-family:'Outfit',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;}
    .btn-primary{background:var(--s-600);color:#fff;}
    .btn-primary:hover{background:var(--s-700);}
    .btn-success{background:var(--g-500);color:#fff;}
    .btn-success:hover{background:#059669;}
    .btn-outline{background:var(--surface);color:var(--text2);border:1px solid var(--border);}
    .btn-outline:hover{background:var(--surface3);}
    .btn-sm{height:32px;padding:0 12px;font-size:12px;}
    .btn-danger{background:var(--r-50);color:var(--r-500);border:1px solid var(--r-100);}
    .btn-danger:hover{background:var(--r-100);}
    .btn-warning{background:var(--a-50);color:var(--a-500);border:1px solid var(--a-100);}
    .btn-warning:hover{background:var(--a-100);}
    .btn-info{background:var(--s-50);color:var(--s-600);border:1px solid var(--s-100);}
    .btn-info:hover{background:var(--s-100);}

    .stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 18px;box-shadow:var(--shadow-sm);}
    .stat-val{font-family:'Outfit',sans-serif;font-size:26px;font-weight:900;color:var(--text);}
    .stat-label{font-size:11.5px;color:var(--text4);margin-top:3px;text-transform:uppercase;letter-spacing:.05em;font-weight:600;}
    .stat-card.green .stat-val{color:var(--g-500);}
    .stat-card.red   .stat-val{color:var(--r-500);}
    .stat-card.amber .stat-val{color:var(--a-500);}
    .stat-card.blue  .stat-val{color:var(--s-500);}

    /* Print per kelas shortcut */
    .print-bar{background:var(--s-50);border:1px solid var(--s-100);border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:16px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;}
    .print-bar-label{font-family:'Outfit',sans-serif;font-size:12.5px;font-weight:700;color:var(--s-700);display:flex;align-items:center;gap:6px;}
    .print-bar select{height:34px;padding:0 10px;border:1px solid var(--s-200,#bfdbfe);border-radius:var(--radius-xs);font-family:'Instrument Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface);outline:none;}
    .print-bar select:focus{border-color:var(--s-400);}

    .filter-bar{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;margin-bottom:16px;display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;box-shadow:var(--shadow-sm);}
    .filter-group{display:flex;flex-direction:column;gap:5px;}
    .filter-label{font-family:'Outfit',sans-serif;font-size:11px;font-weight:700;color:var(--text4);text-transform:uppercase;letter-spacing:.06em;}
    .filter-input,.filter-select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-xs);font-family:'Instrument Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;min-width:160px;}
    .filter-input:focus,.filter-select:focus{border-color:var(--s-400);background:var(--surface);}
    .filter-actions{display:flex;gap:8px;margin-left:auto;align-items:flex-end;}

    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-sm);overflow:hidden;}
    .table-header{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);}
    .table-title{font-family:'Outfit',sans-serif;font-size:14px;font-weight:700;color:var(--text);}
    .table-count{font-size:12px;color:var(--text4);}

    table{width:100%;border-collapse:collapse;}
    thead th{padding:10px 16px;text-align:left;font-family:'Outfit',sans-serif;font-size:11px;font-weight:800;color:var(--text4);text-transform:uppercase;letter-spacing:.07em;background:var(--surface2);border-bottom:1px solid var(--border);}
    tbody tr{border-bottom:1px solid var(--border);transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:var(--s-50);}
    tbody td{padding:13px 16px;font-size:13px;color:var(--text2);vertical-align:middle;}

    .badge{display:inline-flex;align-items:center;gap:5px;font-family:'Outfit',sans-serif;font-size:11px;font-weight:700;padding:3px 10px;border-radius:99px;white-space:nowrap;}
    .badge-dot{width:6px;height:6px;border-radius:50%;}
    .badge.aktif{background:var(--g-50);color:var(--g-500);border:1px solid var(--g-100);}
    .badge.aktif .badge-dot{background:var(--g-500);animation:pulse-dot 1.4s infinite;}
    .badge.nonaktif{background:var(--surface3);color:var(--text4);border:1px solid var(--border);}
    .badge.kadaluarsa{background:var(--a-50);color:var(--a-500);border:1px solid var(--a-100);}
    .badge.deleted{background:var(--r-50);color:var(--r-500);border:1px solid var(--r-100);}
    @keyframes pulse-dot{0%,100%{opacity:1}50%{opacity:.4}}

    .siswa-cell{display:flex;align-items:center;gap:10px;}
    .siswa-avatar{width:34px;height:34px;border-radius:9px;flex-shrink:0;background:linear-gradient(135deg,var(--s-600),var(--s-400));display:flex;align-items:center;justify-content:center;font-family:'Outfit',sans-serif;font-size:13px;font-weight:800;color:#fff;}
    .siswa-nama{font-family:'Outfit',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .siswa-nis{font-size:11.5px;color:var(--text4);margin-top:2px;}
    .kode-cell{font-family:'Outfit',sans-serif;font-size:12px;font-weight:700;color:var(--text3);letter-spacing:.06em;}

    .action-group{display:flex;gap:6px;flex-wrap:wrap;}

    .alert{display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-size:13px;}
    .alert-success{background:var(--g-50);border:1px solid var(--g-100);color:#065f46;}
    .alert-error{background:var(--r-50);border:1px solid var(--r-100);color:#991b1b;}

    /* Modal */
    .modal-overlay{position:fixed;inset:0;background:rgba(15,32,68,.5);z-index:50;display:flex;align-items:center;justify-content:center;padding:20px;opacity:0;pointer-events:none;transition:opacity .2s;}
    .modal-overlay.open{opacity:1;pointer-events:all;}
    .modal{background:var(--surface);border-radius:16px;padding:28px;width:100%;max-width:500px;box-shadow:0 24px 80px rgba(0,0,0,.2);transform:translateY(16px);transition:transform .2s;}
    .modal-overlay.open .modal{transform:translateY(0);}
    .modal-title{font-family:'Outfit',sans-serif;font-size:17px;font-weight:800;color:var(--text);margin-bottom:4px;}
    .modal-sub{font-size:13px;color:var(--text4);margin-bottom:20px;}
    .form-group{margin-bottom:16px;}
    .form-label{font-family:'Outfit',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:6px;}
    .form-control{width:100%;height:40px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-xs);font-family:'Instrument Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;}
    .form-control:focus{border-color:var(--s-400);background:var(--surface);}
    .form-hint{font-size:11.5px;color:var(--text4);margin-top:4px;}
    .form-check{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--text2);margin-top:8px;cursor:pointer;}
    .form-check input{width:16px;height:16px;accent-color:var(--s-600);cursor:pointer;}
    .modal-footer{display:flex;gap:8px;justify-content:flex-end;margin-top:20px;padding-top:16px;border-top:1px solid var(--border);}

    /* Info box di modal */
    .info-box{background:var(--s-50);border:1px solid var(--s-100);border-radius:var(--radius-xs);padding:10px 13px;margin-bottom:14px;font-size:12px;color:var(--s-700);display:flex;align-items:flex-start;gap:7px;}

    .pagination-wrap{padding:14px 20px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;}

    .empty-state{padding:56px 20px;text-align:center;}
    .empty-icon{width:64px;height:64px;background:var(--surface3);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;}
    .empty-title{font-family:'Outfit',sans-serif;font-size:15px;font-weight:700;color:var(--text2);margin-bottom:6px;}
    .empty-sub{font-size:13px;color:var(--text4);}

    @media(max-width:768px){
        .page{padding:14px 14px 56px;}
        .stats-row{grid-template-columns:1fr 1fr;}
        table thead{display:none;}
        tbody td{display:block;padding:8px 16px;}
        tbody td:first-child{padding-top:14px;}
        tbody td:last-child{padding-bottom:14px;}
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Barcode Gerbang</h1>
            <p class="page-sub">Kelola barcode scan masuk &amp; pulang per siswa</p>
        </div>
        <div class="header-actions">
            <button class="btn btn-success" onclick="openMassal()">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Generate Massal
            </button>
            <a href="{{ route('admin.barcode-gerbang.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buat Barcode
            </a>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Stats (dari controller, bukan inline @php) --}}
    <div class="stats-row">
        <div class="stat-card blue">
            <div class="stat-val">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Barcode</div>
        </div>
        <div class="stat-card green">
            <div class="stat-val">{{ $stats['aktif'] }}</div>
            <div class="stat-label">Aktif</div>
        </div>
        <div class="stat-card">
            <div class="stat-val">{{ $stats['nonaktif'] }}</div>
            <div class="stat-label">Nonaktif</div>
        </div>
        <div class="stat-card amber">
            <div class="stat-val">{{ $stats['hari_ini'] }}</div>
            <div class="stat-label">Berlaku Hari Ini</div>
        </div>
    </div>

    {{-- Shortcut Print Per Kelas --}}
    <div class="print-bar">
        <span class="print-bar-label">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
            Cetak Barcode Per Kelas:
        </span>
        <select id="kelasPrintSelect">
            <option value="">— Pilih Kelas —</option>
            @foreach($kelasList as $kelas)
                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
            @endforeach
        </select>
        <button class="btn btn-info btn-sm" onclick="goPrintKelas()">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
            Buka Halaman Cetak
        </button>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.barcode-gerbang.index') }}">
        <div class="filter-bar">
            <div class="filter-group">
                <span class="filter-label">Cari</span>
                <input type="text" name="search" class="filter-input" placeholder="Nama / NIS / Kode..." value="{{ request('search') }}">
            </div>
            <div class="filter-group">
                <span class="filter-label">Kelas</span>
                <select name="kelas_id" class="filter-select">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <span class="filter-label">Status</span>
                <select name="is_aktif" class="filter-select" style="min-width:130px">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_aktif') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_aktif') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Filter
                </button>
                <a href="{{ route('admin.barcode-gerbang.index') }}" class="btn btn-outline">Reset</a>
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-header">
            <span class="table-title">Daftar Barcode Gerbang</span>
            <span class="table-count">{{ $barcodeList->total() }} data</span>
        </div>

        @if($barcodeList->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="28" height="28" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 9V5a2 2 0 0 1 2-2h4M3 15v4a2 2 0 0 0 2 2h4M21 9V5a2 2 0 0 0-2-2h-4M21 15v4a2 2 0 0 1-2 2h-4"/></svg>
                </div>
                <p class="empty-title">Belum ada barcode</p>
                <p class="empty-sub">Buat barcode untuk siswa atau gunakan Generate Massal.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Kode Barcode</th>
                        <th>Berlaku Mulai</th>
                        <th>Berlaku Sampai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barcodeList as $barcode)
                        <tr>
                            <td>
                                <div class="siswa-cell">
                                    <div class="siswa-avatar">
                                        {{ strtoupper(substr($barcode->siswa->nama_lengkap ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="siswa-nama">{{ $barcode->siswa->nama_lengkap ?? '—' }}</p>
                                        <p class="siswa-nis">{{ $barcode->siswa->nis ?? '—' }} · {{ $barcode->siswa->kelas->nama_kelas ?? '—' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="kode-cell">{{ $barcode->kode }}</span></td>
                            <td>{{ $barcode->berlaku_mulai?->format('d M Y') ?? '—' }}</td>
                            <td>{{ $barcode->berlaku_sampai?->format('d M Y') ?? 'Selamanya' }}</td>
                            <td>
                                @if($barcode->trashed())
                                    <span class="badge deleted">Dihapus</span>
                                @elseif(! $barcode->is_aktif)
                                    <span class="badge nonaktif">Nonaktif</span>
                                @elseif($barcode->masih_berlaku)
                                    <span class="badge aktif"><span class="badge-dot"></span>Aktif</span>
                                @else
                                    <span class="badge kadaluarsa">Kadaluarsa</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('admin.barcode-gerbang.show', $barcode) }}" class="btn btn-sm btn-outline">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        Detail
                                    </a>
                                    @if($barcode->masih_berlaku && ! $barcode->trashed())
                                        <a href="{{ route('admin.barcode-gerbang.print-satu', $barcode) }}" target="_blank" class="btn btn-sm btn-info">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
                                            Cetak
                                        </a>
                                    @endif
                                    @if($barcode->is_aktif && ! $barcode->trashed())
                                        <form method="POST" action="{{ route('admin.barcode-gerbang.nonaktifkan', $barcode) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-warning">Nonaktifkan</button>
                                        </form>
                                    @endif
                                    @if(! $barcode->trashed())
                                        <form method="POST" action="{{ route('admin.barcode-gerbang.destroy', $barcode) }}"
                                              onsubmit="return confirm('Hapus barcode ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($barcodeList->hasPages())
                <div class="pagination-wrap">
                    {{ $barcodeList->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

{{-- Modal Generate Massal --}}
<div class="modal-overlay" id="massalModal">
    <div class="modal">
        <h2 class="modal-title">Generate Barcode Massal</h2>
        <p class="modal-sub">Generate barcode untuk semua siswa aktif sekaligus.</p>

        <form method="POST" action="{{ route('admin.barcode-gerbang.generate-massal') }}">
            @csrf

            <div class="info-box">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span>Pilih kelas untuk generate barcode sekaligus &amp; langsung buka halaman cetak per kelas. Jika tidak pilih kelas, akan generate semua kelas aktif.</span>
            </div>

            <div class="form-group">
                <label class="form-label">Filter Kelas (opsional)</label>
                <select name="kelas_id" class="form-control" id="massalKelasId">
                    <option value="">Semua Kelas Aktif</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Berlaku Mulai <span style="color:var(--r-500)">*</span></label>
                <input type="date" name="berlaku_mulai" class="form-control" value="{{ today()->toDateString() }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Berlaku Sampai (opsional)</label>
                <input type="date" name="berlaku_sampai" class="form-control">
                <p class="form-hint">Kosongkan = berlaku selamanya selama aktif</p>
            </div>

            <label class="form-check">
                <input type="checkbox" name="overwrite" value="1">
                Timpa barcode yang sudah aktif
            </label>

            <label class="form-check" id="checkLangsungCetak" style="display:none">
                <input type="checkbox" name="langsung_cetak" value="1" checked>
                Langsung buka halaman cetak setelah generate
            </label>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeMassal()">Batal</button>
                <button type="submit" class="btn btn-success">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Generate Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Modal massal
function openMassal()  { document.getElementById('massalModal').classList.add('open'); }
function closeMassal() { document.getElementById('massalModal').classList.remove('open'); }
document.getElementById('massalModal').addEventListener('click', function(e) {
    if (e.target === this) closeMassal();
});

// Tampilkan opsi "langsung cetak" hanya jika kelas dipilih
document.getElementById('massalKelasId').addEventListener('change', function () {
    document.getElementById('checkLangsungCetak').style.display = this.value ? 'flex' : 'none';
});

// Shortcut print per kelas
const printRoutes = @json(
    $kelasList->mapWithKeys(fn ($k) => [$k->id => route('admin.barcode-gerbang.print-kelas', $k)])
);

function goPrintKelas() {
    const id = document.getElementById('kelasPrintSelect').value;
    if (!id) { alert('Pilih kelas terlebih dahulu.'); return; }
    window.open(printRoutes[id], '_blank');
}
</script>
</x-app-layout>