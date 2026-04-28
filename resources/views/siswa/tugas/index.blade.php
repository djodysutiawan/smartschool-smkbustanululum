<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --sk-700:#1750c0;--sk-600:#1f63db;--sk-500:#3582f0;--sk-100:#d9ebff;--sk-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 48px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}

    /* Filter */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:13px 18px;margin-bottom:20px}
    .filter-row{display:flex;flex-wrap:wrap;gap:9px;align-items:center}
    .filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row select:focus{border-color:var(--sk-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--sk-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer}
    .btn-filter:hover{background:var(--sk-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:background .15s}
    .btn-reset:hover{background:var(--surface3)}

    /* Status tabs */
    .status-tabs{display:flex;gap:6px;margin-bottom:16px;flex-wrap:wrap}
    .stab{display:inline-flex;align-items:center;gap:5px;padding:6px 14px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;text-decoration:none;border:1px solid var(--border);background:var(--surface);color:var(--text2);transition:all .15s}
    .stab:hover{background:var(--surface2)}
    .stab.active{background:var(--sk-600);border-color:var(--sk-600);color:#fff}

    /* Table card */
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
    td{padding:11px 14px;vertical-align:middle;color:var(--text)}
    td.c{text-align:center}

    .two-line .prim{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}
    .two-line .sec{font-size:11.5px;color:var(--text3);margin-top:2px;font-family:'DM Sans',sans-serif}

    /* Countdown */
    .countdown{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700}
    .cd-ok{color:#15803d}
    .cd-warn{color:#a16207}
    .cd-late{color:#dc2626}

    /* Badges */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .bd{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .b-sudah{background:#dcfce7;color:#15803d} .b-sudah .bd{background:#15803d}
    .b-belum{background:#eff6ff;color:#1d4ed8} .b-belum .bd{background:#1d4ed8}
    .b-terlambat{background:#fee2e2;color:#dc2626} .b-terlambat .bd{background:#dc2626}

    .btn-sm{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;text-decoration:none;transition:all .15s;white-space:nowrap}
    .bs-primary{background:var(--sk-600);color:#fff}
    .bs-primary:hover{background:var(--sk-700)}
    .bs-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .bs-secondary:hover{background:var(--surface3)}

    /* Empty */
    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:52px;height:52px;background:var(--surface2);border-radius:13px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14.5px;color:var(--text);margin-bottom:4px}
    .empty-sub{font-size:13px;color:var(--text3);font-family:'DM Sans',sans-serif}

    /* Pagination */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:13px 18px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif}
    .pag-btns{display:flex;gap:4px}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--sk-600);border-color:var(--sk-600);color:#fff}
    .pag-btn.disabled{opacity:.4;pointer-events:none}
    .pag-ellipsis{color:var(--text3);padding:0 4px}

    @media(max-width:640px){.page{padding:16px}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Tugas Saya</h1>
            <p class="page-sub">Daftar tugas yang diberikan untuk kelas Anda</p>
        </div>
    </div>

    {{-- Status tabs --}}
    <div class="status-tabs">
        <a href="{{ route('siswa.tugas.index') }}" class="stab {{ !request('status') ? 'active' : '' }}">Semua</a>
        <a href="{{ route('siswa.tugas.index', ['status' => 'belum']) }}" class="stab {{ request('status') === 'belum' ? 'active' : '' }}">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Belum Dikumpulkan
        </a>
        <a href="{{ route('siswa.tugas.index', ['status' => 'sudah']) }}" class="stab {{ request('status') === 'sudah' ? 'active' : '' }}">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            Sudah Dikumpulkan
        </a>
        <a href="{{ route('siswa.tugas.index', ['status' => 'terlambat']) }}" class="stab {{ request('status') === 'terlambat' ? 'active' : '' }}">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Terlambat
        </a>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('siswa.tugas.index') }}">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="filter-row">
                <select name="mapel_id">
                    <option value="">Semua Mata Pelajaran</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id }}" {{ request('mapel_id') == $m->id ? 'selected' : '' }}>
                            {{ $m->nama_mapel }}
                        </option>
                    @endforeach
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('siswa.tugas.index', request('status') ? ['status' => request('status')] : []) }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="tbl-card">
        <div class="tbl-topbar">
            <p class="tbl-info">
                Daftar Tugas
                <span>{{ $tugas->total() }} tugas</span>
            </p>
        </div>

        <div class="tbl-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:42px">#</th>
                        <th>Judul Tugas</th>
                        <th>Mata Pelajaran</th>
                        <th>Batas Waktu</th>
                        <th class="c">Status</th>
                        <th class="c">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tugas as $i => $t)
                    @php
                        $dikumpulkan = in_array($t->id, $sudahDikumpulkan);
                        $terlambat   = now()->gt($t->batas_waktu);
                        $sisaSaat    = now()->diffForHumans($t->batas_waktu, ['parts' => 2]);
                    @endphp
                    <tr>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)">
                            {{ $tugas->firstItem() + $i }}
                        </td>
                        <td>
                            <div class="two-line">
                                <p class="prim">{{ $t->judul }}</p>
                                <p class="sec">Nilai maks: {{ $t->nilai_maksimal ?? 100 }}</p>
                            </div>
                        </td>
                        <td style="font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2)">
                            {{ $t->mataPelajaran->nama_mapel ?? '—' }}
                        </td>
                        <td>
                            <div class="two-line">
                                <p class="prim" style="font-size:12.5px">{{ $t->batas_waktu->format('d M Y') }}</p>
                                <p class="sec">{{ $t->batas_waktu->format('H:i') }} WIB</p>
                            </div>
                            @if(!$dikumpulkan)
                                @if($terlambat)
                                    <span class="countdown cd-late">Sudah berakhir</span>
                                @elseif($t->batas_waktu->diffInHours(now()) < 24)
                                    <span class="countdown cd-warn">⚠ {{ $sisaSaat }}</span>
                                @else
                                    <span class="countdown cd-ok">{{ $sisaSaat }}</span>
                                @endif
                            @endif
                        </td>
                        <td class="c">
                            @if($dikumpulkan)
                                <span class="badge b-sudah"><span class="bd"></span>Dikumpulkan</span>
                            @elseif($terlambat && !$t->izinkan_terlambat)
                                <span class="badge b-terlambat"><span class="bd"></span>Terlambat</span>
                            @elseif($terlambat)
                                <span class="badge b-terlambat"><span class="bd"></span>Terlambat (boleh)</span>
                            @else
                                <span class="badge b-belum"><span class="bd"></span>Belum</span>
                            @endif
                        </td>
                        <td class="c">
                            <a href="{{ route('siswa.tugas.show', $t) }}" class="btn-sm bs-secondary">
                                Lihat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                </div>
                                <p class="empty-title">Tidak ada tugas</p>
                                <p class="empty-sub">Tugas yang diberikan guru akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tugas->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $tugas->firstItem() }}–{{ $tugas->lastItem() }} dari {{ $tugas->total() }} tugas</p>
            <div class="pag-btns">
                @if($tugas->onFirstPage())
                    <span class="pag-btn disabled"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $tugas->previousPageUrl() }}" class="pag-btn"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($tugas->getUrlRange(1, $tugas->lastPage()) as $page => $url)
                    @if($page == $tugas->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $tugas->lastPage() || abs($page - $tugas->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $tugas->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($tugas->hasMorePages())
                    <a href="{{ $tugas->nextPageUrl() }}" class="pag-btn"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn disabled"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>
</x-app-layout>