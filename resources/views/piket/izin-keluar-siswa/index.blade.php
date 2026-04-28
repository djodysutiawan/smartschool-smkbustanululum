<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=JetBrains+Mono:wght@400;500;600&display=swap');

    :root {
        --brand-800:#0f3d8c;
        --brand-700:#1750c0;
        --brand-600:#1f63db;
        --brand-500:#3582f0;
        --brand-200:#bfdbfe;
        --brand-100:#dbeafe;
        --brand-50:#eff6ff;
        --surface:#ffffff;
        --surface2:#f8fafc;
        --surface3:#f1f5f9;
        --surface4:#e9eef5;
        --border:#e2e8f0;
        --border2:#cbd5e1;
        --text:#0f172a;
        --text2:#334155;
        --text3:#64748b;
        --text4:#94a3b8;
        --r:10px;
        --r-sm:7px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);
        --shadow:0 4px 12px rgba(0,0,0,.07),0 2px 4px rgba(0,0,0,.04);
        --shadow-md:0 8px 24px rgba(0,0,0,.09),0 2px 8px rgba(0,0,0,.05);
    }

    *, *::before, *::after { box-sizing: border-box; }

    /* ─── Layout ─── */
    .pg { padding: 28px 32px 48px; }
    .pg-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .pg-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 21px; font-weight: 800; color: var(--text); letter-spacing: -.3px; line-height: 1.2; }
    .pg-sub { font-size: 13px; color: var(--text4); margin-top: 4px; font-family: 'Plus Jakarta Sans', sans-serif; }
    .hdr-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }

    /* ─── Banner belum check-in ─── */
    .banner-checkin {
        display: flex; align-items: center; gap: 12px;
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border: 1px solid #fde68a; border-radius: var(--r);
        padding: 12px 18px; margin-bottom: 20px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; color: #92400e;
    }
    .banner-checkin a { color: var(--brand-600); text-decoration: underline; }

    /* ─── Stats ─── */
    .stats { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; margin-bottom: 20px; }
    .stat {
        background: var(--surface); border: 1px solid var(--border); border-radius: var(--r);
        padding: 16px 20px; display: flex; align-items: center; gap: 14px;
        box-shadow: var(--shadow-sm); transition: box-shadow .2s, transform .2s;
    }
    .stat:hover { box-shadow: var(--shadow); transform: translateY(-1px); }
    .stat-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .stat-icon.amber { background: #fef9c3; }
    .stat-icon.emerald { background: #dcfce7; }
    .stat-icon.sky { background: #e0f2fe; }
    .stat-lbl { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 10.5px; font-weight: 700; color: var(--text4); text-transform: uppercase; letter-spacing: .06em; }
    .stat-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 26px; font-weight: 800; color: var(--text); line-height: 1.1; margin-top: 1px; }
    .stat-sub { font-size: 11.5px; color: var(--text4); margin-top: 2px; font-family: 'Plus Jakarta Sans', sans-serif; }

    /* ─── Filter ─── */
    .filter-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r); padding: 14px 18px; margin-bottom: 16px; box-shadow: var(--shadow-sm); }
    .filter-row { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }
    .f-input, .f-select {
        height: 36px; padding: 0 12px; border: 1px solid var(--border);
        border-radius: var(--r-sm); font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px; color: var(--text); background: var(--surface2);
        outline: none; transition: border-color .15s, background .15s;
    }
    .f-input:focus, .f-select:focus { border-color: var(--brand-500); background: #fff; box-shadow: 0 0 0 3px rgba(53,130,240,.09); }
    .f-input.wide { min-width: 210px; }
    .f-input.date { width: 152px; }
    .f-sep { flex: 1; min-width: 4px; }
    .btn-filter { height: 36px; padding: 0 18px; background: var(--brand-600); color: #fff; border: none; border-radius: var(--r-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; cursor: pointer; transition: background .15s; }
    .btn-filter:hover { background: var(--brand-700); }
    .btn-reset { height: 36px; padding: 0 14px; background: var(--surface2); color: var(--text3); border: 1px solid var(--border); border-radius: var(--r-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; transition: background .15s; }
    .btn-reset:hover { background: var(--surface3); }

    /* ─── Buttons ─── */
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--r-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s, box-shadow .15s; white-space: nowrap; }
    .btn:hover { filter: brightness(.93); }
    .btn-primary { background: var(--brand-600); color: #fff; box-shadow: 0 1px 4px rgba(31,99,219,.25); }
    .btn-primary:hover { filter: none; background: var(--brand-700); }
    .btn-sm { padding: 5px 12px; font-size: 12px; border-radius: 6px; }
    .btn-detail { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-detail:hover { background: var(--brand-100); filter: none; }
    .btn-approve { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .btn-approve:hover { background: #dcfce7; filter: none; }
    .btn-tolak { background: #fff0f0; color: #dc2626; border: 1px solid #fecaca; }
    .btn-tolak:hover { background: #fee2e2; filter: none; }
    .btn-konfirmasi { background: #fdf4ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .btn-konfirmasi:hover { background: #f3e8ff; filter: none; }

    /* ─── Table card ─── */
    .tbl-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r); overflow: hidden; box-shadow: var(--shadow-sm); }
    .tbl-topbar { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--border); }
    .tbl-info { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .tbl-info span { font-weight: 500; color: var(--text4); margin-left: 6px; }
    .tbl-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    thead tr { background: var(--surface2); border-bottom: 1px solid var(--border); }
    thead th { padding: 11px 14px; text-align: left; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 10.5px; font-weight: 700; color: var(--text4); letter-spacing: .06em; text-transform: uppercase; white-space: nowrap; }
    th.center, td.center { text-align: center; }
    tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .1s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #f8fbff; }
    td { padding: 10px 14px; color: var(--text); vertical-align: middle; }
    .td-muted { color: var(--text4); font-size: 12px; }

    /* Two-line cell */
    .twoline .pri { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 13.5px; color: var(--text); }
    .twoline .sec { font-size: 11.5px; color: var(--text4); margin-top: 2px; }

    /* Nomor surat */
    .nsurat { font-family: 'JetBrains Mono', monospace; font-size: 11px; font-weight: 500; color: var(--text3); background: var(--surface3); padding: 2px 8px; border-radius: 5px; letter-spacing: .02em; display: inline-block; }

    /* Jam */
    .jam-val { font-family: 'JetBrains Mono', monospace; font-weight: 600; font-size: 13px; }
    .jam-sub { font-size: 10.5px; color: var(--text4); margin-top: 1px; }

    /* Action group */
    .act-group { display: flex; align-items: center; gap: 5px; justify-content: center; flex-wrap: wrap; }

    /* ─── Badges ─── */
    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; white-space: nowrap; letter-spacing: .02em; }
    .bdot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .b-menunggu      { background: #fefce8; color: #92400e; border: 1px solid #fde68a; } .b-menunggu .bdot      { background: #d97706; }
    .b-disetujui     { background: #dcfce7; color: #14532d; border: 1px solid #86efac; } .b-disetujui .bdot     { background: #16a34a; }
    .b-ditolak       { background: #fee2e2; color: #7f1d1d; border: 1px solid #fca5a5; } .b-ditolak .bdot       { background: #dc2626; }
    .b-sudah_kembali { background: #dbeafe; color: #1e3a8a; border: 1px solid #93c5fd; } .b-sudah_kembali .bdot { background: #2563eb; }

    /* ─── Row no ─── */
    .no-col { font-family: 'JetBrains Mono', monospace; font-size: 11.5px; font-weight: 500; color: var(--text4); }

    /* ─── Empty state ─── */
    .empty { padding: 60px 24px; text-align: center; }
    .empty-ico { width: 56px; height: 56px; background: var(--surface3); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
    .empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 15px; color: var(--text); margin-bottom: 5px; }
    .empty-sub { font-size: 13px; color: var(--text4); }

    /* ─── Pagination ─── */
    .pag { display: flex; align-items: center; justify-content: space-between; padding: 13px 20px; border-top: 1px solid var(--border); flex-wrap: wrap; gap: 10px; }
    .pag-info { font-size: 12px; color: var(--text4); font-family: 'Plus Jakarta Sans', sans-serif; }
    .pag-btns { display: flex; gap: 4px; align-items: center; }
    .pag-btn { height: 32px; min-width: 32px; padding: 0 8px; border-radius: 7px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border); background: var(--surface); color: var(--text3); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; cursor: pointer; transition: all .15s; text-decoration: none; }
    .pag-btn:hover { background: var(--surface2); border-color: var(--border2); }
    .pag-btn.active { background: var(--brand-600); border-color: var(--brand-600); color: #fff; }
    .pag-btn.disabled { opacity: .35; cursor: not-allowed; pointer-events: none; }
    .pag-dots { color: var(--text4); font-size: 13px; padding: 0 4px; display: flex; align-items: center; }

    @media(max-width:768px) {
        .stats { grid-template-columns: 1fr; }
        .pg { padding: 16px; }
        .hdr-actions { width: 100%; }
    }
</style>

<div class="pg">

    {{-- ── Banner Belum Check-in ── --}}
    @if(! $guruAktifId)
    <div class="banner-checkin">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Anda belum check-in sebagai petugas piket. Beberapa aksi (buat, setujui, tolak, konfirmasi) memerlukan check-in terlebih dahulu.
        <a href="{{ route('piket.absensi.index') }}">Check-in sekarang →</a>
    </div>
    @endif

    {{-- ── Header ── --}}
    <div class="pg-header">
        <div>
            <h1 class="pg-title">Izin Keluar Siswa</h1>
            <p class="pg-sub">Kelola permohonan izin keluar &amp; pemantauan kepulangan siswa</p>
        </div>
        <div class="hdr-actions">
            <a href="{{ route('piket.izin-keluar-siswa.create') }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buat Izin Baru
            </a>
        </div>
    </div>

    {{-- ── Stats ── --}}
    <div class="stats">
        <div class="stat">
            <div class="stat-icon amber">
                <svg width="20" height="20" fill="none" stroke="#d97706" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-lbl">Menunggu</p>
                <p class="stat-val">{{ $stats['menunggu'] }}</p>
                <p class="stat-sub">perlu diproses hari ini</p>
            </div>
        </div>
        <div class="stat">
            <div class="stat-icon emerald">
                <svg width="20" height="20" fill="none" stroke="#16a34a" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <p class="stat-lbl">Sedang Keluar</p>
                <p class="stat-val">{{ $stats['sedang_keluar'] }}</p>
                <p class="stat-sub">belum kembali hari ini</p>
            </div>
        </div>
        <div class="stat">
            <div class="stat-icon sky">
                <svg width="20" height="20" fill="none" stroke="#0284c7" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-lbl">Sudah Kembali</p>
                <p class="stat-val">{{ $stats['sudah_kembali'] }}</p>
                <p class="stat-sub">tercatat kembali hari ini</p>
            </div>
        </div>
    </div>

    {{-- ── Filter ── --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('piket.izin-keluar-siswa.index') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama siswa, tujuan, nomor surat…"
                    class="f-input wide">

                <select name="status" class="f-select">
                    <option value="">Semua Status</option>
                    @foreach(\App\Models\IzinKeluarSiswa::STATUS_LIST as $val => $label)
                        <option value="{{ $val }}" @selected(request('status') === $val)>{{ $label }}</option>
                    @endforeach
                </select>

                <select name="kategori" class="f-select">
                    <option value="">Semua Kategori</option>
                    @foreach(\App\Models\IzinKeluarSiswa::KATEGORI_LIST as $val => $label)
                        <option value="{{ $val }}" @selected(request('kategori') === $val)>{{ $label }}</option>
                    @endforeach
                </select>

                <input type="date" name="tanggal_dari"   value="{{ request('tanggal_dari') }}"   class="f-input date" title="Dari tanggal">
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="f-input date" title="Sampai tanggal">

                <div class="f-sep"></div>
                <a href="{{ route('piket.izin-keluar-siswa.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- ── Tabel ── --}}
    <div class="tbl-card">
        <div class="tbl-topbar">
            <p class="tbl-info">
                Daftar Izin Keluar
                @if($izins->total() > 0)
                    <span>— {{ $izins->firstItem() }}–{{ $izins->lastItem() }} dari {{ $izins->total() }} data</span>
                @else
                    <span>— tidak ada data</span>
                @endif
            </p>
        </div>

        <div class="tbl-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:44px">#</th>
                        <th>Siswa</th>
                        <th>Tanggal</th>
                        <th>Tujuan &amp; Kategori</th>
                        <th class="center">Jam Keluar</th>
                        <th class="center">Jam Kembali</th>
                        <th class="center">Status</th>
                        <th>No. Surat</th>
                        <th class="center" style="width:210px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($izins as $i => $izin)
                <tr>
                    <td><span class="no-col">{{ $izins->firstItem() + $i }}</span></td>

                    <td>
                        <div class="twoline">
                            <p class="pri">{{ $izin->siswa->nama_lengkap ?? '—' }}</p>
                            <p class="sec">{{ $izin->siswa->kelas->nama_kelas ?? '—' }}</p>
                        </div>
                    </td>

                    <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px;white-space:nowrap">
                        {{ $izin->tanggal->format('d M Y') }}
                    </td>

                    <td>
                        <div class="twoline">
                            <p class="pri" style="max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                {{ $izin->tujuan }}
                            </p>
                            <p class="sec">{{ $izin->kategori_label }}</p>
                        </div>
                    </td>

                    <td class="center">
                        <span class="jam-val">{{ \Carbon\Carbon::parse($izin->jam_keluar)->format('H:i') }}</span>
                    </td>

                    <td class="center">
                        @if($izin->jam_kembali_aktual)
                            <span class="jam-val" style="color:#16a34a">{{ \Carbon\Carbon::parse($izin->jam_kembali_aktual)->format('H:i') }}</span>
                            <p class="jam-sub">{{ $izin->durasi_formatted }}</p>
                        @elseif($izin->jam_kembali)
                            <span class="jam-val" style="color:var(--text4)">~{{ \Carbon\Carbon::parse($izin->jam_kembali)->format('H:i') }}</span>
                            <p class="jam-sub">estimasi</p>
                        @else
                            <span class="td-muted">—</span>
                        @endif
                    </td>

                    <td class="center">
                        <span class="badge b-{{ $izin->status }}">
                            <span class="bdot"></span>{{ $izin->status_label }}
                        </span>
                    </td>

                    <td>
                        @if($izin->nomor_surat)
                            <span class="nsurat">{{ $izin->nomor_surat }}</span>
                        @else
                            <span class="td-muted">—</span>
                        @endif
                    </td>

                    <td class="center">
                        <div class="act-group">
                            <a href="{{ route('piket.izin-keluar-siswa.show', $izin) }}" class="btn btn-sm btn-detail">Detail</a>

                            @if($izin->isMenunggu())
                                <button type="button" class="btn btn-sm btn-approve"
                                    onclick="doApprove({{ $izin->id }}, '{{ addslashes($izin->siswa->nama_lengkap ?? '') }}')">
                                    Setujui
                                </button>
                                <button type="button" class="btn btn-sm btn-tolak"
                                    onclick="doTolak({{ $izin->id }}, '{{ addslashes($izin->siswa->nama_lengkap ?? '') }}')">
                                    Tolak
                                </button>
                            @elseif($izin->isDisetujui())
                                <button type="button" class="btn btn-sm btn-konfirmasi"
                                    onclick="doKembali({{ $izin->id }}, '{{ addslashes($izin->siswa->nama_lengkap ?? '') }}')">
                                    Kembali
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty">
                            <div class="empty-ico">
                                <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            </div>
                            <p class="empty-title">Belum ada data izin keluar</p>
                            <p class="empty-sub">Coba ubah filter atau buat izin baru</p>
                        </div>
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($izins->hasPages())
        <div class="pag">
            <p class="pag-info">Menampilkan {{ $izins->firstItem() }}–{{ $izins->lastItem() }} dari {{ $izins->total() }} izin</p>
            <div class="pag-btns">
                @if($izins->onFirstPage())
                    <span class="pag-btn disabled">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $izins->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                @foreach($izins->getUrlRange(1, $izins->lastPage()) as $page => $url)
                    @if($page == $izins->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $izins->lastPage() || abs($page - $izins->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $izins->currentPage()) == 2)
                        <span class="pag-dots">…</span>
                    @endif
                @endforeach

                @if($izins->hasMorePages())
                    <a href="{{ $izins->nextPageUrl() }}" class="pag-btn">
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

{{-- Hidden forms – action diisi dinamis via JS --}}
<form id="formApprove" method="POST" style="display:none">
    @csrf @method('PATCH')
    <input type="hidden" name="catatan_piket" id="catatanApprove">
</form>
<form id="formTolak" method="POST" style="display:none">
    @csrf @method('PATCH')
    <input type="hidden" name="catatan_piket" id="catatanTolak">
</form>
<form id="formKembali" method="POST" style="display:none">
    @csrf @method('PATCH')
    <input type="hidden" name="jam_kembali_aktual" id="jamKembaliInput">
    <input type="hidden" name="catatan_piket"      id="catatanKembali">
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
/* ── Toast flash ── */
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif

/* ── Approve ── */
function doApprove(id, nama) {
    Swal.fire({
        title: 'Setujui Izin?',
        html: `Izin keluar <strong>${nama}</strong> akan disetujui dan nomor surat akan digenerate.`,
        icon: 'question',
        input: 'textarea',
        inputLabel: 'Catatan Piket (opsional)',
        inputPlaceholder: 'Tulis catatan jika perlu…',
        inputAttributes: { rows: 2, maxlength: 500 },
        showCancelButton: true,
        confirmButtonColor: '#15803d',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Setujui',
        cancelButtonText: 'Batal',
    }).then(r => {
        if (!r.isConfirmed) return;
        const form = document.getElementById('formApprove');
        form.action = `/piket/izin-keluar-siswa/${id}/approve`;
        document.getElementById('catatanApprove').value = r.value || '';
        form.submit();
    });
}

/* ── Tolak ── */
function doTolak(id, nama) {
    Swal.fire({
        title: 'Tolak Izin?',
        html: `Izin keluar <strong>${nama}</strong> akan ditolak.`,
        icon: 'warning',
        input: 'textarea',
        inputLabel: 'Alasan Penolakan (wajib diisi)',
        inputPlaceholder: 'Tulis alasan penolakan…',
        inputAttributes: { rows: 2, maxlength: 500 },
        inputValidator: v => !v?.trim() ? 'Alasan penolakan wajib diisi.' : null,
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Tolak',
        cancelButtonText: 'Batal',
    }).then(r => {
        if (!r.isConfirmed) return;
        const form = document.getElementById('formTolak');
        form.action = `/piket/izin-keluar-siswa/${id}/tolak`;
        document.getElementById('catatanTolak').value = r.value;
        form.submit();
    });
}

/* ── Konfirmasi Kembali ── */
function doKembali(id, nama) {
    const now = new Date();
    const hh  = String(now.getHours()).padStart(2,'0');
    const mm  = String(now.getMinutes()).padStart(2,'0');
    Swal.fire({
        title: 'Konfirmasi Kembali',
        html: `
            <p style="font-size:13.5px;color:#475569;margin-bottom:14px">
                Catat bahwa <strong>${nama}</strong> telah kembali ke sekolah.
            </p>
            <div style="text-align:left;margin-bottom:10px">
                <label style="font-size:12px;font-weight:700;color:#475569;display:block;margin-bottom:4px">
                    Jam Kembali Aktual <span style="color:#dc2626">*</span>
                </label>
                <input type="time" id="swalJam" value="${hh}:${mm}"
                    style="width:100%;height:38px;padding:0 12px;border:1px solid #e2e8f0;border-radius:7px;font-size:14px">
            </div>
            <div style="text-align:left">
                <label style="font-size:12px;font-weight:700;color:#475569;display:block;margin-bottom:4px">Catatan (opsional)</label>
                <textarea id="swalCatatan" rows="2" maxlength="500" placeholder="Tulis catatan jika perlu…"
                    style="width:100%;padding:8px 12px;border:1px solid #e2e8f0;border-radius:7px;font-size:13px;resize:none"></textarea>
            </div>`,
        showCancelButton: true,
        confirmButtonColor: '#7c3aed',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Konfirmasi Kembali',
        cancelButtonText: 'Batal',
        preConfirm: () => {
            const jam = document.getElementById('swalJam').value;
            if (!jam) { Swal.showValidationMessage('Jam kembali wajib diisi.'); return false; }
            return { jam, catatan: document.getElementById('swalCatatan').value };
        }
    }).then(r => {
        if (!r.isConfirmed) return;
        const form = document.getElementById('formKembali');
        form.action = `/piket/izin-keluar-siswa/${id}/konfirmasi-kembali`;
        document.getElementById('jamKembaliInput').value = r.value.jam;
        document.getElementById('catatanKembali').value  = r.value.catatan;
        form.submit();
    });
}
</script>
</x-app-layout>