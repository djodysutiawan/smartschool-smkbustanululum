<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --pk-700:#1750c0;--pk-600:#1f63db;--pk-500:#3582f0;--pk-100:#d9ebff;--pk-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}
    .header-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap}
    .btn-primary{background:var(--pk-600);color:#fff}
    .btn-primary:hover{background:var(--pk-700)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3)}

    /* Filter */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:13px 18px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:9px;align-items:center}
    .filter-row select,.filter-row input[type=date]{height:36px;padding:0 11px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row select:focus,.filter-row input:focus{border-color:var(--pk-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--pk-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer}
    .btn-filter:hover{background:var(--pk-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:background .15s}
    .btn-reset:hover{background:var(--surface3)}

    /* Table */
    .tbl-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .tbl-topbar{display:flex;align-items:center;justify-content:space-between;padding:13px 18px;border-bottom:1px solid var(--border)}
    .tbl-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .tbl-info span{font-weight:400;color:var(--text3);margin-left:5px}
    .tbl-wrap{overflow-x:auto}

    table{width:100%;border-collapse:collapse;font-size:13px}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;background:var(--surface2);border-bottom:1px solid var(--border);white-space:nowrap}
    thead th.c{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;vertical-align:middle;color:var(--text)}
    td.c{text-align:center}
    td.muted{color:var(--text3);font-family:'DM Sans',sans-serif;font-size:12.5px}

    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)}
    .two-line .prim{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}
    .two-line .sec{font-size:11.5px;color:var(--text3);font-family:'DM Sans',sans-serif;margin-top:1px}

    /* Badges */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .bd{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .b-hadir{background:#dcfce7;color:#15803d} .b-hadir .bd{background:#15803d}
    .b-telat{background:#fefce8;color:#a16207} .b-telat .bd{background:#a16207}
    .b-izin{background:#eff6ff;color:#1d4ed8} .b-izin .bd{background:#1d4ed8}
    .b-sakit{background:#fdf4ff;color:#7c3aed} .b-sakit .bd{background:#7c3aed}
    .b-alfa{background:#fee2e2;color:#dc2626} .b-alfa .bd{background:#dc2626}
    .b-qr{background:#ecfdf5;color:#065f46} .b-qr .bd{background:#065f46}
    .b-manual{background:var(--surface3);color:var(--text2)} .b-manual .bd{background:var(--text3)}

    /* Empty */
    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:52px;height:52px;background:var(--surface2);border-radius:13px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14.5px;color:var(--text);margin-bottom:4px}
    .empty-sub{font-size:13px;color:var(--text3);font-family:'DM Sans',sans-serif}

    /* Pagination */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:13px 18px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif}
    .pag-btns{display:flex;gap:4px;align-items:center}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;text-decoration:none;transition:all .15s}
    .pag-btn:hover{background:var(--surface2);border-color:var(--border2)}
    .pag-btn.active{background:var(--pk-600);border-color:var(--pk-600);color:#fff}
    .pag-btn.disabled{opacity:.4;pointer-events:none;cursor:not-allowed}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}

    @media(max-width:640px){.page{padding:16px}}
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Absensi Saya</h1>
            <p class="page-sub">Daftar absensi guru yang Anda catat sebagai petugas piket</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('piket.absensi-guru.massal.form') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Input Absensi
            </a>
            <a href="{{ route('piket.absensi-guru.dashboard') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('piket.absensi-guru.riwayat') }}">
            <div class="filter-row">
                <select name="guru_id" style="min-width:190px">
                    <option value="">Semua Guru</option>
                    @foreach($guruList as $g)
                        <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>
                            {{ $g->nama_lengkap }}
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

                <input type="date" name="tanggal_dari"   value="{{ request('tanggal_dari') }}"   placeholder="Dari">
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" placeholder="Sampai">

                <div class="filter-sep"></div>

                <a href="{{ route('piket.absensi-guru.riwayat') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="tbl-card">
        <div class="tbl-topbar">
            <p class="tbl-info">
                Riwayat Absensi
                @if($riwayat->total() > 0)
                    <span>— {{ $riwayat->firstItem() }}–{{ $riwayat->lastItem() }} dari {{ $riwayat->total() }} data</span>
                @else
                    <span>— tidak ada data</span>
                @endif
            </p>
        </div>

        <div class="tbl-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:42px">#</th>
                        <th>Nama Guru</th>
                        <th>Tanggal</th>
                        <th class="c">Status</th>
                        <th class="c">Metode</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $i => $a)
                    <tr>
                        <td><span class="no-col">{{ $riwayat->firstItem() + $i }}</span></td>

                        <td>
                            <div class="two-line">
                                <p class="prim">{{ $a->guru->nama_lengkap ?? '—' }}</p>
                                <p class="sec">NIP: {{ $a->guru->nip ?? '—' }}</p>
                            </div>
                        </td>

                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px;white-space:nowrap">
                            {{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('D MMM Y') }}
                        </td>

                        <td class="c">
                            <span class="badge b-{{ $a->status }}">
                                <span class="bd"></span>{{ ucfirst($a->status) }}
                            </span>
                        </td>

                        <td class="c">
                            @if($a->metode === 'qr')
                                <span class="badge b-qr"><span class="bd"></span>QR</span>
                            @else
                                <span class="badge b-manual"><span class="bd"></span>Manual</span>
                            @endif
                        </td>

                        <td class="muted">{{ $a->jam_masuk ? \Carbon\Carbon::parse($a->jam_masuk)->format('H:i') : '—' }}</td>
                        <td class="muted">{{ $a->jam_keluar ? \Carbon\Carbon::parse($a->jam_keluar)->format('H:i') : '—' }}</td>

                        <td style="font-size:12.5px;color:var(--text2);max-width:160px">
                            <p style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                                {{ $a->keterangan ?? '—' }}
                            </p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                </div>
                                <p class="empty-title">Belum ada riwayat absensi</p>
                                <p class="empty-sub">Mulai catat absensi guru melalui form massal atau scan QR</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($riwayat->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">
                Menampilkan {{ $riwayat->firstItem() }}–{{ $riwayat->lastItem() }} dari {{ $riwayat->total() }} absensi
            </p>
            <div class="pag-btns">
                @if($riwayat->onFirstPage())
                    <span class="pag-btn disabled">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $riwayat->previousPageUrl() }}" class="pag-btn">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                @foreach($riwayat->getUrlRange(1, $riwayat->lastPage()) as $page => $url)
                    @if($page == $riwayat->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $riwayat->lastPage() || abs($page - $riwayat->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $riwayat->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                @if($riwayat->hasMorePages())
                    <a href="{{ $riwayat->nextPageUrl() }}" class="pag-btn">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                @else
                    <span class="pag-btn disabled">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2800,showConfirmButton:false,toast:true,position:'top-end'});
@endif
</script>
</x-app-layout>