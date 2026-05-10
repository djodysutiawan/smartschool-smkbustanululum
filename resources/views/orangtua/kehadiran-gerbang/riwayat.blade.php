<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root{
        --brand:#0f766e;--brand-50:#f0fdfa;--brand-100:#ccfbf1;--brand-600:#0d9488;--brand-700:#0f766e;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:12px;--radius-sm:8px;
        --masuk:#dcfce7;--masuk-text:#15803d;--masuk-border:#bbf7d0;
        --pulang:#dbeafe;--pulang-text:#1d4ed8;--pulang-border:#bfdbfe;
    }
    *{box-sizing:border-box}
    .page{padding:28px 28px 60px;max-width:1400px;margin:0 auto}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:13px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}

    /* Anak selector */
    .anak-selector{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px}
    .anak-chip{display:inline-flex;align-items:center;gap:8px;padding:7px 16px;border-radius:99px;border:1.5px solid var(--border);background:var(--surface);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);text-decoration:none;transition:all .15s}
    .anak-chip:hover{border-color:var(--brand-600);color:var(--brand-700)}
    .anak-chip.active{background:var(--brand-700);border-color:var(--brand-700);color:#fff}
    .anak-avatar{width:22px;height:22px;border-radius:50%;background:var(--brand-100);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:var(--brand-700);flex-shrink:0}
    .anak-chip.active .anak-avatar{background:rgba(255,255,255,.25);color:#fff}

    /* Rekap strip */
    .rekap-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px}
    .rekap-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px}
    .rekap-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
    .rekap-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase}
    .rekap-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;font-weight:800;line-height:1.1;margin-top:1px}

    /* Filter */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px}
    .filter-row{display:flex;align-items:flex-end;gap:12px;flex-wrap:wrap}
    .filter-group{display:flex;flex-direction:column;gap:5px}
    .filter-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .filter-input,.filter-select{height:36px;padding:0 12px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s;min-width:130px}
    .filter-input:focus,.filter-select:focus{border-color:var(--brand-600)}
    .btn-filter{height:36px;padding:0 18px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;background:var(--brand-700);color:#fff;display:inline-flex;align-items:center;gap:6px}
    .btn-filter:hover{filter:brightness(.93)}
    .btn-reset{background:var(--surface2);color:var(--text2);border:1.5px solid var(--border);text-decoration:none;height:36px;display:inline-flex;align-items:center;padding:0 14px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700}
    .btn-reset:hover{background:var(--surface3)}

    /* Table */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafffe}
    td{padding:12px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}

    /* Badge tipe */
    .badge-tipe{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .b-masuk{background:var(--masuk);color:var(--masuk-text)}
    .b-pulang{background:var(--pulang);color:var(--pulang-text)}

    /* Badge status */
    .badge-status{display:inline-flex;align-items:center;padding:2px 8px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700}
    .bs-normal{background:#dcfce7;color:#15803d}
    .bs-manual{background:#fef3c7;color:#b45309}
    .bs-koreksi{background:#ede9fe;color:#7c3aed}

    /* Pagination */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3);font-family:'DM Sans',sans-serif}
    .pag-btns{display:flex;gap:4px}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--brand-700);border-color:var(--brand-700);color:#fff}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;display:flex;align-items:center}

    /* Empty */
    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{font-size:36px;margin-bottom:12px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:4px}
    .empty-sub{font-size:13px;color:var(--text3);font-family:'DM Sans',sans-serif}

    @media(max-width:768px){.rekap-strip{grid-template-columns:1fr 1fr}.page{padding:16px}}
    @media(max-width:480px){.rekap-strip{grid-template-columns:1fr}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Gerbang</h1>
            <p class="page-sub">Log scan masuk & pulang {{ $anak->nama_lengkap }} di gerbang sekolah</p>
        </div>
        <a href="{{ route('ortu.kehadiran-gerbang.status-hari-ini', ['siswa_id' => $anak->id]) }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);background:var(--surface2);color:var(--text2);border:1.5px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;text-decoration:none">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Status Hari Ini
        </a>
    </div>

    {{-- Selector anak --}}
    @if($anakList->count() > 1)
    <div class="anak-selector">
        @foreach($anakList as $a)
        <a href="{{ route('ortu.kehadiran-gerbang.riwayat', ['siswa_id' => $a->id]) }}"
           class="anak-chip {{ $anak->id === $a->id ? 'active' : '' }}">
            <div class="anak-avatar">{{ strtoupper(substr($a->nama_lengkap, 0, 1)) }}</div>
            {{ $a->nama_lengkap }}
        </a>
        @endforeach
    </div>
    @endif

    {{-- Rekap total --}}
    <div class="rekap-strip">
        <div class="rekap-card">
            <div class="rekap-icon" style="background:var(--masuk)">🟢</div>
            <div>
                <p class="rekap-label">Hari Masuk</p>
                <p class="rekap-val" style="color:var(--masuk-text)">{{ $totalHariMasuk }}</p>
            </div>
        </div>
        <div class="rekap-card">
            <div class="rekap-icon" style="background:var(--pulang)">🔵</div>
            <div>
                <p class="rekap-label">Hari Pulang</p>
                <p class="rekap-val" style="color:var(--pulang-text)">{{ $totalHariPulang }}</p>
            </div>
        </div>
        <div class="rekap-card">
            <div class="rekap-icon" style="background:var(--surface3)">📋</div>
            <div>
                <p class="rekap-label">Total Scan</p>
                <p class="rekap-val" style="color:var(--text)">{{ $riwayat->total() }}</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('ortu.kehadiran-gerbang.riwayat') }}">
            @if(request('siswa_id'))
                <input type="hidden" name="siswa_id" value="{{ request('siswa_id') }}">
            @endif
            <div class="filter-row">
                <div class="filter-group">
                    <label class="filter-label">Tipe</label>
                    <select name="tipe" class="filter-select">
                        <option value="">Semua</option>
                        <option value="masuk"  {{ request('tipe') === 'masuk'  ? 'selected' : '' }}>Masuk</option>
                        <option value="pulang" {{ request('tipe') === 'pulang' ? 'selected' : '' }}>Pulang</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" class="filter-input" value="{{ request('tanggal_dari') }}">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" class="filter-input" value="{{ request('tanggal_sampai') }}">
                </div>
                <button type="submit" class="btn-filter">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Filter
                </button>
                @if(request()->hasAny(['tipe','tanggal_dari','tanggal_sampai']))
                <a href="{{ route('ortu.kehadiran-gerbang.riwayat', array_filter(['siswa_id' => request('siswa_id')])) }}"
                   class="btn-reset">Reset</a>
                @endif
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Log Scan Gerbang
                <span>— {{ $riwayat->firstItem() ?? 0 }}–{{ $riwayat->lastItem() ?? 0 }} dari {{ $riwayat->total() }} data</span>
            </p>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:44px">#</th>
                        <th>Tanggal</th>
                        <th>Hari</th>
                        <th class="center">Tipe</th>
                        <th>Waktu Scan</th>
                        <th>Sesi Gerbang</th>
                        <th class="center">Status</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $idx => $scan)
                    <tr>
                        <td><span class="no-col">{{ $riwayat->firstItem() + $idx }}</span></td>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;white-space:nowrap">
                            {{ $scan->tanggal_scan->translatedFormat('d M Y') }}
                        </td>
                        <td style="color:var(--text3);font-size:12.5px;font-family:'DM Sans',sans-serif">
                            {{ $scan->tanggal_scan->translatedFormat('l') }}
                        </td>
                        <td class="center">
                            <span class="badge-tipe b-{{ $scan->tipe }}">
                                {{ $scan->tipe === 'masuk' ? '🟢 Masuk' : '🔵 Pulang' }}
                            </span>
                        </td>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--text)">
                            {{ $scan->waktu_scan->format('H:i') }}
                            <span style="font-size:11px;font-weight:400;color:var(--text3)">WIB</span>
                        </td>
                        <td style="font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2)">
                            {{ $scan->sesiGerbang?->nama ?? '—' }}
                        </td>
                        <td class="center">
                            <span class="badge-status bs-{{ $scan->status }}">{{ $scan->label_status }}</span>
                        </td>
                        <td style="font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2);max-width:200px">
                            {{ $scan->catatan ? \Illuminate\Support\Str::limit($scan->catatan, 60) : '—' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">🏫</div>
                                <p class="empty-title">Tidak ada data scan gerbang</p>
                                <p class="empty-sub">Coba ubah filter atau pilih rentang tanggal yang berbeda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($riwayat->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $riwayat->firstItem() }}–{{ $riwayat->lastItem() }} dari {{ $riwayat->total() }}</p>
            <div class="pag-btns">
                @if($riwayat->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $riwayat->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
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
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
</x-app-layout>