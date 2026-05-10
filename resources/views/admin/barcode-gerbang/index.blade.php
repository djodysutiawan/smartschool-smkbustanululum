<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Instrument+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --s-800:#0f2044;--s-700:#1a3a6b;--s-600:#1d4ed8;--s-500:#2563eb;--s-400:#3b82f6;
        --s-100:#dbeafe;--s-50:#eff6ff;
        --g-500:#10b981;--g-100:#d1fae5;--g-50:#ecfdf5;
        --a-500:#f59e0b;--a-100:#fef3c7;--a-50:#fffbeb;
        --r-500:#ef4444;--r-100:#fee2e2;--r-50:#fff5f5;
        --p-500:#8b5cf6;--p-100:#ede9fe;--p-50:#f5f3ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#334155;--text3:#64748b;--text4:#94a3b8;
        --radius:12px;--radius-sm:8px;--radius-xs:6px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.07);--shadow-md:0 4px 16px rgba(0,0,0,.08);
    }
    *{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:'Instrument Sans',sans-serif;}
    .page{padding:24px 28px 64px;}

    /* ── Header ── */
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Outfit',sans-serif;font-size:22px;font-weight:900;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text4);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}

    /* ── Buttons ── */
    .btn{display:inline-flex;align-items:center;gap:7px;height:38px;padding:0 16px;border-radius:var(--radius-sm);font-family:'Outfit',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap;}
    .btn-primary{background:var(--s-600);color:#fff;}
    .btn-primary:hover{background:var(--s-700);}
    .btn-success{background:var(--g-500);color:#fff;}
    .btn-success:hover{background:#059669;}
    .btn-purple{background:var(--p-500);color:#fff;}
    .btn-purple:hover{background:#7c3aed;}
    .btn-outline{background:var(--surface);color:var(--text2);border:1px solid var(--border);}
    .btn-outline:hover{background:var(--surface3);}
    .btn-sm{height:30px;padding:0 10px;font-size:11.5px;}

    /* ── Stats ── */
    .stats-row{display:grid;grid-template-columns:repeat(6,1fr);gap:12px;margin-bottom:24px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;box-shadow:var(--shadow-sm);}
    .stat-label{font-family:'Outfit',sans-serif;font-size:10.5px;font-weight:700;color:var(--text4);text-transform:uppercase;letter-spacing:.07em;margin-bottom:6px;}
    .stat-val{font-family:'Outfit',sans-serif;font-size:24px;font-weight:900;color:var(--text);line-height:1;}
    .stat-card.aktif .stat-val{color:var(--g-500);}
    .stat-card.nonaktif .stat-val{color:var(--text4);}
    .stat-card.hari-ini .stat-val{color:var(--s-500);}
    .stat-card.siswa .stat-val{color:var(--s-600);}
    .stat-card.guru .stat-val{color:var(--p-500);}

    /* ── Filter bar ── */
    .filter-bar{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;margin-bottom:16px;display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;box-shadow:var(--shadow-sm);}
    .filter-group{display:flex;flex-direction:column;gap:5px;}
    .filter-label{font-family:'Outfit',sans-serif;font-size:10.5px;font-weight:700;color:var(--text4);text-transform:uppercase;letter-spacing:.06em;}
    .filter-control{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-xs);font-family:'Instrument Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;min-width:140px;}
    .filter-control:focus{border-color:var(--s-400);box-shadow:0 0 0 3px rgba(59,130,246,.1);}
    .filter-search{min-width:220px;}
    .filter-actions{display:flex;gap:8px;align-items:flex-end;margin-left:auto;}

    /* ── Generate panel ── */
    .generate-panels{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px;}
    .gen-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 18px;box-shadow:var(--shadow-sm);}
    .gen-card-header{display:flex;align-items:center;gap:8px;margin-bottom:12px;}
    .gen-card-icon{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .gen-card-icon.siswa{background:var(--s-50);}
    .gen-card-icon.guru{background:var(--p-50);}
    .gen-card-title{font-family:'Outfit',sans-serif;font-size:13px;font-weight:800;color:var(--text);}
    .gen-card-sub{font-size:11.5px;color:var(--text4);margin-top:1px;}
    .gen-form{display:flex;gap:8px;flex-wrap:wrap;align-items:flex-end;}
    .gen-form-group{display:flex;flex-direction:column;gap:4px;}
    .gen-form-label{font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;color:var(--text4);text-transform:uppercase;letter-spacing:.06em;}
    .gen-form-control{height:34px;padding:0 10px;border:1px solid var(--border);border-radius:var(--radius-xs);font-family:'Instrument Sans',sans-serif;font-size:12.5px;color:var(--text);background:var(--surface2);outline:none;}
    .gen-form-control:focus{border-color:var(--s-400);}
    .gen-checkbox-wrap{display:flex;align-items:center;gap:6px;height:34px;}
    .gen-checkbox-wrap input[type=checkbox]{width:15px;height:15px;accent-color:var(--s-500);cursor:pointer;}
    .gen-checkbox-wrap label{font-size:12px;color:var(--text3);cursor:pointer;white-space:nowrap;}

    /* ── Table ── */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-sm);overflow:hidden;}
    .table-card-header{display:flex;align-items:center;justify-content:space-between;padding:14px 18px;border-bottom:1px solid var(--border);}
    .table-card-title{font-family:'Outfit',sans-serif;font-size:14px;font-weight:800;color:var(--text);}
    table{width:100%;border-collapse:collapse;}
    thead th{padding:11px 16px;text-align:left;font-family:'Outfit',sans-serif;font-size:10.5px;font-weight:800;color:var(--text4);text-transform:uppercase;letter-spacing:.07em;background:var(--surface2);border-bottom:1px solid var(--border);white-space:nowrap;}
    tbody tr{border-bottom:1px solid var(--border);transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:var(--s-50);}
    tbody td{padding:12px 16px;font-size:13px;color:var(--text2);vertical-align:middle;}

    /* ── Tipe badge ── */
    .tipe-badge{display:inline-flex;align-items:center;gap:4px;font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;padding:2px 8px;border-radius:99px;}
    .tipe-badge.siswa{background:var(--s-50);color:var(--s-600);border:1px solid var(--s-100);}
    .tipe-badge.guru{background:var(--p-50);color:var(--p-500);border:1px solid var(--p-100);}

    .status-badge{display:inline-flex;align-items:center;gap:4px;font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;padding:2px 8px;border-radius:99px;}
    .status-badge-dot{width:5px;height:5px;border-radius:50%;}
    .status-badge.aktif{background:var(--g-50);color:var(--g-500);border:1px solid var(--g-100);}
    .status-badge.aktif .status-badge-dot{background:var(--g-500);animation:pdot 1.4s infinite;}
    .status-badge.nonaktif{background:var(--surface3);color:var(--text4);border:1px solid var(--border);}
    .status-badge.nonaktif .status-badge-dot{background:var(--text4);}
    .status-badge.kadaluarsa{background:var(--a-50);color:var(--a-500);border:1px solid var(--a-100);}
    .status-badge.kadaluarsa .status-badge-dot{background:var(--a-500);}
    @keyframes pdot{0%,100%{opacity:1}50%{opacity:.3}}

    .nama-cell{font-family:'Outfit',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .meta-cell{font-size:11.5px;color:var(--text4);margin-top:2px;}
    .kode-cell{font-family:'Outfit',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;}

    .action-btns{display:flex;gap:6px;align-items:center;}

    /* ── Alert flash ── */
    .alert{display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-size:13px;}
    .alert-success{background:var(--g-50);border:1px solid var(--g-100);color:#065f46;}
    .alert-error{background:var(--r-50);border:1px solid var(--r-100);color:#991b1b;}

    /* ── Empty ── */
    .empty-row td{text-align:center;padding:48px 20px;color:var(--text4);}
    .empty-icon{width:56px;height:56px;border-radius:14px;background:var(--surface3);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;}

    /* ── Pagination ── */
    .pagination-wrap{padding:14px 18px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;}
    .pagination-info{font-size:12.5px;color:var(--text4);}

    /* ── Print actions bar ── */
    .print-bar{display:flex;gap:8px;flex-wrap:wrap;align-items:center;padding:12px 16px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);margin-bottom:16px;}
    .print-bar-label{font-family:'Outfit',sans-serif;font-size:12px;font-weight:700;color:var(--text3);}

    /* ── Modals ── */
    .modal-backdrop{position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:100;display:none;align-items:center;justify-content:center;}
    .modal-backdrop.open{display:flex;}
    .modal{background:var(--surface);border-radius:var(--radius);box-shadow:0 20px 60px rgba(0,0,0,.2);width:460px;max-width:95vw;overflow:hidden;}
    .modal-header{display:flex;align-items:center;justify-content:space-between;padding:18px 20px;border-bottom:1px solid var(--border);}
    .modal-title{font-family:'Outfit',sans-serif;font-size:16px;font-weight:800;color:var(--text);}
    .modal-close{cursor:pointer;color:var(--text4);background:none;border:none;line-height:1;}
    .modal-close:hover{color:var(--text);}
    .modal-body{padding:20px;}
    .modal-footer{padding:14px 20px;border-top:1px solid var(--border);display:flex;gap:8px;justify-content:flex-end;}

    .form-group{margin-bottom:14px;}
    .form-label{font-family:'Outfit',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:6px;}
    .form-label .req{color:var(--r-500);}
    .form-control{width:100%;height:40px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-xs);font-family:'Instrument Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;}
    .form-control:focus{border-color:var(--s-400);background:var(--surface);box-shadow:0 0 0 3px rgba(59,130,246,.1);}
    .form-hint{font-size:11.5px;color:var(--text4);margin-top:4px;}
    .checkbox-row{display:flex;align-items:center;gap:7px;margin-top:4px;}
    .checkbox-row input{width:15px;height:15px;accent-color:var(--s-500);}
    .checkbox-row label{font-size:13px;color:var(--text3);cursor:pointer;}

    @media(max-width:900px){
        .page{padding:14px 14px 56px;}
        .stats-row{grid-template-columns:repeat(3,1fr);}
        .generate-panels{grid-template-columns:1fr;}
    }
    @media(max-width:600px){
        .stats-row{grid-template-columns:repeat(2,1fr);}
        .filter-bar{flex-direction:column;align-items:stretch;}
        .filter-actions{margin-left:0;}
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Barcode Gerbang</h1>
            <p class="page-sub">Kelola barcode scan masuk &amp; pulang untuk siswa dan guru</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.barcode-gerbang.print-guru') }}" target="_blank" class="btn btn-purple">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
                Cetak Barcode Guru
            </a>
            <a href="{{ route('admin.barcode-gerbang.create') }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
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

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card">
            <p class="stat-label">Total</p>
            <p class="stat-val">{{ $stats['total'] }}</p>
        </div>
        <div class="stat-card aktif">
            <p class="stat-label">Aktif</p>
            <p class="stat-val">{{ $stats['aktif'] }}</p>
        </div>
        <div class="stat-card nonaktif">
            <p class="stat-label">Nonaktif</p>
            <p class="stat-val">{{ $stats['nonaktif'] }}</p>
        </div>
        <div class="stat-card hari-ini">
            <p class="stat-label">Berlaku Hari Ini</p>
            <p class="stat-val">{{ $stats['hari_ini'] }}</p>
        </div>
        <div class="stat-card siswa">
            <p class="stat-label">Total Siswa</p>
            <p class="stat-val">{{ $stats['total_siswa'] }}</p>
        </div>
        <div class="stat-card guru">
            <p class="stat-label">Total Guru</p>
            <p class="stat-val">{{ $stats['total_guru'] }}</p>
        </div>
    </div>

    {{-- Generate Massal Panels --}}
    <div class="generate-panels">
        {{-- Generate Siswa --}}
        <div class="gen-card">
            <div class="gen-card-header">
                <div class="gen-card-icon siswa">
                    <svg width="16" height="16" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <p class="gen-card-title">Generate Massal — Siswa</p>
                    <p class="gen-card-sub">Generate barcode untuk semua/per kelas</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.barcode-gerbang.generate-massal') }}">
                @csrf
                <div class="gen-form">
                    <div class="gen-form-group">
                        <label class="gen-form-label">Kelas (opsional)</label>
                        <select name="kelas_id" class="gen-form-control" id="genKelasId">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="gen-form-group">
                        <label class="gen-form-label">Berlaku Mulai <span style="color:var(--r-500)">*</span></label>
                        <input type="date" name="berlaku_mulai" class="gen-form-control" value="{{ today()->toDateString() }}" required>
                    </div>
                    <div class="gen-form-group">
                        <label class="gen-form-label">Berlaku Sampai</label>
                        <input type="date" name="berlaku_sampai" class="gen-form-control">
                    </div>
                    <div style="display:flex;flex-direction:column;gap:4px;">
                        <div class="gen-checkbox-wrap">
                            <input type="checkbox" name="overwrite" value="1" id="overwriteSiswa">
                            <label for="overwriteSiswa">Timpa yang sudah ada</label>
                        </div>
                        <div class="gen-checkbox-wrap">
                            <input type="checkbox" name="langsung_cetak" value="1" id="langsungCetakSiswa" onchange="toggleCetakNote()">
                            <label for="langsungCetakSiswa">Langsung cetak</label>
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;justify-content:flex-end;gap:6px;">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="5 12 12 5 19 12"/><line x1="12" y1="5" x2="12" y2="19"/></svg>
                            Generate
                        </button>
                    </div>
                </div>
                <p style="font-size:11px;color:var(--text4);margin-top:8px" id="cetakNote" style="display:none">
                    ⚠ Langsung cetak hanya berlaku jika memilih satu kelas.
                </p>
            </form>
        </div>

        {{-- Generate Guru --}}
        <div class="gen-card">
            <div class="gen-card-header">
                <div class="gen-card-icon guru">
                    <svg width="16" height="16" fill="none" stroke="var(--p-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div>
                    <p class="gen-card-title">Generate Massal — Guru</p>
                    <p class="gen-card-sub">Generate barcode untuk semua guru aktif</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.barcode-gerbang.generate-massal-guru') }}">
                @csrf
                <div class="gen-form">
                    <div class="gen-form-group">
                        <label class="gen-form-label">Berlaku Mulai <span style="color:var(--r-500)">*</span></label>
                        <input type="date" name="berlaku_mulai" class="gen-form-control" value="{{ today()->toDateString() }}" required>
                    </div>
                    <div class="gen-form-group">
                        <label class="gen-form-label">Berlaku Sampai</label>
                        <input type="date" name="berlaku_sampai" class="gen-form-control">
                    </div>
                    <div style="display:flex;flex-direction:column;gap:4px;">
                        <div class="gen-checkbox-wrap">
                            <input type="checkbox" name="overwrite" value="1" id="overwriteGuru">
                            <label for="overwriteGuru">Timpa yang sudah ada</label>
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;justify-content:flex-end;">
                        <button type="submit" class="btn btn-purple btn-sm">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="5 12 12 5 19 12"/><line x1="12" y1="5" x2="12" y2="19"/></svg>
                            Generate
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Print per kelas bar --}}
    <div class="print-bar">
        <span class="print-bar-label">Cetak per kelas:</span>
        @foreach($kelasList as $kelas)
            <a href="{{ route('admin.barcode-gerbang.print-kelas', $kelas) }}" target="_blank"
               class="btn btn-outline btn-sm">
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
                {{ $kelas->nama_kelas }}
            </a>
        @endforeach
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.barcode-gerbang.index') }}">
        <div class="filter-bar">
            <div class="filter-group">
                <span class="filter-label">Tipe Pemilik</span>
                <select name="tipe_pemilik" class="filter-control">
                    <option value="">Semua</option>
                    <option value="siswa" {{ request('tipe_pemilik') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="guru" {{ request('tipe_pemilik') === 'guru' ? 'selected' : '' }}>Guru</option>
                </select>
            </div>
            <div class="filter-group">
                <span class="filter-label">Kelas</span>
                <select name="kelas_id" class="filter-control">
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
                <select name="is_aktif" class="filter-control">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_aktif') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_aktif') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="filter-group">
                <span class="filter-label">Cari</span>
                <input type="text" name="search" class="filter-control filter-search"
                    placeholder="Kode, nama, NIS, NIP..."
                    value="{{ request('search') }}">
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary" style="height:36px">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Filter
                </button>
                @if(request()->hasAny(['tipe_pemilik','kelas_id','is_aktif','search']))
                    <a href="{{ route('admin.barcode-gerbang.index') }}" class="btn btn-outline" style="height:36px">Reset</a>
                @endif
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-card-header">
            <span class="table-card-title">Daftar Barcode</span>
            <span style="font-size:12px;color:var(--text4)">{{ $barcodeList->total() }} barcode ditemukan</span>
        </div>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipe</th>
                        <th>Nama</th>
                        <th>Kode Barcode</th>
                        <th>Berlaku</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barcodeList as $i => $bc)
                        <tr>
                            <td style="color:var(--text4);font-size:12px">{{ $barcodeList->firstItem() + $i }}</td>
                            <td>
                                @if($bc->tipe_pemilik === 'guru')
                                    <span class="tipe-badge guru">Guru</span>
                                @else
                                    <span class="tipe-badge siswa">Siswa</span>
                                @endif
                            </td>
                            <td>
                                @if($bc->tipe_pemilik === 'guru')
                                    <p class="nama-cell">{{ $bc->guru->nama_lengkap ?? '—' }}</p>
                                    <p class="meta-cell">NIP {{ $bc->guru->nip ?? '—' }} · {{ $bc->guru->status_kepegawaian ?? '—' }}</p>
                                @else
                                    <p class="nama-cell">{{ $bc->siswa->nama_lengkap ?? '—' }}</p>
                                    <p class="meta-cell">NIS {{ $bc->siswa->nis ?? '—' }} · {{ $bc->siswa->kelas->nama_kelas ?? '—' }}</p>
                                @endif
                            </td>
                            <td>
                                <span class="kode-cell">{{ $bc->kode }}</span>
                            </td>
                            <td style="font-size:12.5px;color:var(--text3)">
                                {{ $bc->berlaku_mulai?->format('d M Y') ?? '—' }}
                                @if($bc->berlaku_sampai)
                                    <br><span style="color:var(--text4);font-size:11px">s/d {{ $bc->berlaku_sampai->format('d M Y') }}</span>
                                @else
                                    <br><span style="color:var(--text4);font-size:11px">Selamanya</span>
                                @endif
                            </td>
                            <td>
                                @if($bc->trashed())
                                    <span class="status-badge nonaktif"><span class="status-badge-dot"></span>Dihapus</span>
                                @elseif($bc->masih_berlaku ?? ($bc->is_aktif && (!$bc->berlaku_sampai || $bc->berlaku_sampai->isFuture())))
                                    <span class="status-badge aktif"><span class="status-badge-dot"></span>Berlaku</span>
                                @elseif(!$bc->is_aktif)
                                    <span class="status-badge nonaktif"><span class="status-badge-dot"></span>Nonaktif</span>
                                @else
                                    <span class="status-badge kadaluarsa"><span class="status-badge-dot"></span>Kadaluarsa</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.barcode-gerbang.show', $bc) }}" class="btn btn-outline btn-sm">Detail</a>
                                    @if(!$bc->trashed())
                                        <a href="{{ route('admin.barcode-gerbang.print-satu', $bc) }}" target="_blank" class="btn btn-outline btn-sm" title="Cetak">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="7">
                                <div class="empty-icon">
                                    <svg width="26" height="26" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 9V5a2 2 0 0 1 2-2h4M3 15v4a2 2 0 0 0 2 2h4M21 9V5a2 2 0 0 0-2-2h-4M21 15v4a2 2 0 0 1-2 2h-4"/></svg>
                                </div>
                                <p style="font-family:'Outfit',sans-serif;font-weight:700;color:var(--text3);margin-bottom:4px">Tidak ada barcode ditemukan</p>
                                <p style="font-size:12.5px">Coba ubah filter atau buat barcode baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($barcodeList->hasPages())
            <div class="pagination-wrap">
                <span class="pagination-info">
                    Menampilkan {{ $barcodeList->firstItem() }}–{{ $barcodeList->lastItem() }} dari {{ $barcodeList->total() }}
                </span>
                {{ $barcodeList->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function toggleCetakNote() {
    const cb   = document.getElementById('langsungCetakSiswa');
    const note = document.getElementById('cetakNote');
    if (note) note.style.display = cb.checked ? 'block' : 'none';
}
</script>
</x-app-layout>