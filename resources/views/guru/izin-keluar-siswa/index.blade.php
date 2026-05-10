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
        --green-bg:#f0fdf4;--green-txt:#15803d;--green-border:#bbf7d0;
        --yellow-bg:#fefce8;--yellow-txt:#a16207;--yellow-border:#fde68a;
        --blue-bg:#eff6ff;--blue-txt:#1d4ed8;--blue-border:#bfdbfe;
        --red-bg:#fee2e2;--red-txt:#dc2626;--red-border:#fecaca;
    }

    /* ── Layout ── */
    .page{padding:28px 28px 48px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:20px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    /* ── Buttons ── */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-detail{background:var(--blue-bg);color:var(--blue-txt);border:1px solid var(--blue-border)}
    .btn-detail:hover{background:#dbeafe;filter:none}

    /* ── Info Banner ── */
    .info-banner{display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;background:var(--blue-bg);border:1px solid var(--blue-border);color:var(--blue-txt)}

    /* ── Stats Strip ── */
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.07)}
    .stat-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.yellow{background:var(--yellow-bg)}
    .stat-icon.green{background:var(--green-bg)}
    .stat-icon.blue{background:var(--blue-bg)}
    .stat-icon.red{background:var(--red-bg)}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;font-weight:800;color:var(--text);line-height:1.1;margin-top:2px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    /* ── Filter Card ── */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:8px;align-items:center}
    .filter-row select,
    .filter-row input[type=date],
    .filter-row input[type=text]{height:36px;padding:0 11px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row input[type=text]{width:190px}
    .filter-row input[type=date]{width:145px}
    .filter-row select:focus,.filter-row input:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s}
    .btn-filter:hover{background:var(--brand-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:background .15s}
    .btn-reset:hover{background:var(--surface3)}

    /* ── Table Card ── */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:13px 18px;border-bottom:1px solid var(--border)}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:4px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.06em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    td.muted{color:var(--text3)}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)}

    /* ── Badges ── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-menunggu      {background:var(--yellow-bg);color:var(--yellow-txt)} .badge-menunggu  .badge-dot{background:var(--yellow-txt)}
    .badge-disetujui     {background:var(--green-bg);color:var(--green-txt)}   .badge-disetujui .badge-dot{background:var(--green-txt)}
    .badge-sudah_kembali {background:var(--blue-bg);color:var(--blue-txt)}     .badge-sudah_kembali .badge-dot{background:var(--blue-txt)}
    .badge-ditolak       {background:var(--red-bg);color:var(--red-txt)}       .badge-ditolak   .badge-dot{background:var(--red-txt)}
    .badge-kategori      {background:var(--surface3);color:var(--text2);border:1px solid var(--border)}

    /* ── Two-line cell ── */
    .two-line .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .two-line .secondary{font-size:11.5px;color:var(--text3);margin-top:1px}

    /* ── Tujuan cell ── */
    .tujuan-cell{font-size:12.5px;color:var(--text2);max-width:180px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;line-clamp:2}

    /* ── Action ── */
    .action-group{display:flex;align-items:center;gap:5px;justify-content:center}

    /* ── Empty state ── */
    .empty-state{padding:56px 20px;text-align:center}
    .empty-icon{width:52px;height:52px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14.5px;color:var(--text);margin-bottom:4px}
    .empty-sub{font-size:13px;color:var(--text3)}

    /* ── Pagination ── */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:13px 18px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px;align-items:center}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2);border-color:var(--border2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 2px}

    @media(max-width:900px){
        .stats-strip{grid-template-columns:1fr 1fr}
    }
    @media(max-width:640px){
        .page{padding:16px 16px 32px}
        .stats-strip{grid-template-columns:1fr 1fr}
        .filter-row input[type=text]{width:100%}
    }
</style>

<div class="page">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Izin Keluar Siswa</h1>
            <p class="page-sub">Data izin keluar siswa dari kelas yang Anda ampu</p>
        </div>
    </div>

    {{-- ── Info Banner ── --}}
    <div class="info-banner">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        Data yang ditampilkan hanya mencakup siswa dari kelas yang Anda ampu.
    </div>

    {{-- ── Stats Hari Ini ── --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Menunggu</p>
                <p class="stat-val">{{ $rekap['menunggu'] }}</p>
                <p class="stat-sub">hari ini</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Disetujui</p>
                <p class="stat-val">{{ $rekap['disetujui'] }}</p>
                <p class="stat-sub">hari ini</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Sudah Kembali</p>
                <p class="stat-val">{{ $rekap['sudah_kembali'] }}</p>
                <p class="stat-sub">hari ini</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Ditolak</p>
                <p class="stat-val">{{ $rekap['ditolak'] }}</p>
                <p class="stat-sub">hari ini</p>
            </div>
        </div>
    </div>

    {{-- ── Filter ── --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('guru.izin-keluar-siswa.index') }}">
            <div class="filter-row">

                <input type="text" name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama / NIS siswa…">

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
                    @foreach($statusList as $val => $label)
                        <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                <select name="kategori">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $val => $label)
                        <option value="{{ $val }}" {{ request('kategori') === $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                <input type="date" name="tanggal_dari"
                    value="{{ request('tanggal_dari') }}"
                    title="Dari tanggal">

                <input type="date" name="tanggal_sampai"
                    value="{{ request('tanggal_sampai') }}"
                    title="Sampai tanggal">

                <div class="filter-sep"></div>

                <a href="{{ route('guru.izin-keluar-siswa.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- ── Table ── --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Izin Keluar
                @if($izinList->total() > 0)
                    <span>— {{ $izinList->firstItem() }}–{{ $izinList->lastItem() }} dari {{ $izinList->total() }} data</span>
                @else
                    <span>— tidak ada data</span>
                @endif
            </p>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:44px">#</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th class="center">Status</th>
                        <th>Jam Keluar</th>
                        <th>Est. Kembali</th>
                        <th>Jam Aktual</th>
                        <th>Tujuan / Keperluan</th>
                        <th class="center" style="width:80px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($izinList as $index => $izin)
                    <tr>
                        <td><span class="no-col">{{ $izinList->firstItem() + $index }}</span></td>

                        {{-- Siswa --}}
                        <td>
                            <div class="two-line">
                                <p class="primary">{{ $izin->siswa->nama_lengkap ?? '—' }}</p>
                                <p class="secondary">NIS: {{ $izin->siswa->nis ?? '—' }}</p>
                            </div>
                        </td>

                        {{-- Kelas --}}
                        <td class="muted" style="font-size:12.5px;white-space:nowrap">
                            {{ $izin->siswa->kelas->nama_kelas ?? '—' }}
                        </td>

                        {{-- Tanggal --}}
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px;white-space:nowrap">
                            {{ \Carbon\Carbon::parse($izin->tanggal)->isoFormat('D MMM Y') }}
                        </td>

                        {{-- Kategori: gunakan KATEGORI_LIST agar label benar --}}
                        <td>
                            <span class="badge badge-kategori">
                                {{ \App\Models\IzinKeluarSiswa::KATEGORI_LIST[$izin->kategori] ?? ucfirst($izin->kategori) }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td class="center">
                            <span class="badge badge-{{ $izin->status }}">
                                <span class="badge-dot"></span>
                                {{ \App\Models\IzinKeluarSiswa::STATUS_LIST[$izin->status] ?? ucfirst($izin->status) }}
                            </span>
                        </td>

                        {{-- Jam keluar --}}
                        <td class="muted" style="font-size:13px;white-space:nowrap">
                            {{ $izin->jam_keluar ? substr($izin->jam_keluar, 0, 5) : '—' }}
                        </td>

                        {{-- Jam kembali (estimasi) --}}
                        <td class="muted" style="font-size:13px;white-space:nowrap">
                            {{ $izin->jam_kembali ? substr($izin->jam_kembali, 0, 5) : '—' }}
                        </td>

                        {{-- Jam kembali aktual --}}
                        <td style="font-size:13px;white-space:nowrap">
                            @if($izin->jam_kembali_aktual)
                                <span style="font-weight:700;color:#15803d">
                                    {{ substr($izin->jam_kembali_aktual, 0, 5) }}
                                </span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>

                        {{-- Tujuan: kolom yang benar di model adalah 'tujuan' --}}
                        <td>
                            <p class="tujuan-cell">{{ $izin->tujuan ?: '—' }}</p>
                        </td>

                        {{-- Aksi --}}
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('guru.izin-keluar-siswa.show', $izin->id) }}"
                                   class="btn btn-sm btn-detail">Detail</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                </div>
                                <p class="empty-title">Belum ada data izin keluar</p>
                                <p class="empty-sub">Coba ubah filter, atau belum ada pengajuan izin saat ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Pagination ── --}}
        @if($izinList->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">
                Menampilkan {{ $izinList->firstItem() }}–{{ $izinList->lastItem() }}
                dari {{ $izinList->total() }} izin
            </p>
            <div class="pag-btns">

                {{-- Prev --}}
                @if($izinList->onFirstPage())
                    <span class="pag-btn disabled">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $izinList->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                {{-- Pages --}}
                @php
                    $current  = $izinList->currentPage();
                    $last     = $izinList->lastPage();
                    $ellLeft  = false;
                    $ellRight = false;
                @endphp
                @foreach($izinList->getUrlRange(1, $last) as $page => $url)
                    @if($page === $current)
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page === 1 || $page === $last || abs($page - $current) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif($page < $current && !$ellLeft)
                        @php $ellLeft = true @endphp
                        <span class="pag-ellipsis">…</span>
                    @elseif($page > $current && !$ellRight)
                        @php $ellRight = true @endphp
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($izinList->hasMorePages())
                    <a href="{{ $izinList->nextPageUrl() }}" class="pag-btn">
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

{{-- Toast notifications --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({
    icon:'success', title:'Berhasil!',
    text: @json(session('success')),
    timer:2800, showConfirmButton:false,
    toast:true, position:'top-end'
});
@endif
@if(session('error'))
Swal.fire({
    icon:'error', title:'Gagal!',
    text: @json(session('error')),
    confirmButtonColor:'#1f63db'
});
@endif
</script>
</x-app-layout>