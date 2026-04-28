<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root{
        --brand:#0f766e;--brand-50:#f0fdfa;--brand-100:#ccfbf1;--brand-200:#99f6e4;--brand-600:#0d9488;--brand-700:#0f766e;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:12px;--radius-sm:8px;
        --hadir:#dcfce7;--hadir-text:#15803d;
        --telat:#fff3cd;--telat-text:#a16207;
        --izin:#dbeafe;--izin-text:#1d4ed8;
        --sakit:#fce7f3;--sakit-text:#be185d;
        --alfa:#fee2e2;--alfa-text:#dc2626;
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
    .rekap-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .rekap-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px}
    .rekap-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
    .rekap-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase}
    .rekap-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}

    /* Filter bar */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px}
    .filter-row{display:flex;align-items:flex-end;gap:12px;flex-wrap:wrap}
    .filter-group{display:flex;flex-direction:column;gap:5px;min-width:140px}
    .filter-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .filter-input,.filter-select{height:36px;padding:0 12px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s}
    .filter-input:focus,.filter-select:focus{border-color:var(--brand-600)}
    .btn-filter{height:36px;padding:0 18px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;background:var(--brand-700);color:#fff;display:inline-flex;align-items:center;gap:6px;text-decoration:none;white-space:nowrap}
    .btn-filter:hover{filter:brightness(.93)}
    .btn-reset{background:var(--surface2);color:var(--text2);border:1.5px solid var(--border)}
    .btn-reset:hover{background:var(--surface3);filter:none}

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
    td.muted{color:var(--text3);font-size:12.5px}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}

    /* Badge */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .b-hadir{background:var(--hadir);color:var(--hadir-text)}
    .b-telat{background:var(--telat);color:var(--telat-text)}
    .b-izin{background:var(--izin);color:var(--izin-text)}
    .b-sakit{background:var(--sakit);color:var(--sakit-text)}
    .b-alfa{background:var(--alfa);color:var(--alfa-text)}

    .keterangan-col{max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2)}

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
    .empty-icon{width:56px;height:56px;background:var(--brand-50);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:24px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:4px}
    .empty-sub{font-size:13px;color:var(--text3);font-family:'DM Sans',sans-serif}

    @media(max-width:768px){.rekap-strip{grid-template-columns:1fr 1fr}.page{padding:16px}}
    @media(max-width:480px){.rekap-strip{grid-template-columns:1fr 1fr}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Kehadiran</h1>
            <p class="page-sub">Rekap dan riwayat absensi {{ $anak->nama_lengkap }}</p>
        </div>
        <a href="{{ route('ortu.absensi.status-hari-ini', ['siswa_id' => $anak->id]) }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);background:var(--surface2);color:var(--text2);border:1.5px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;text-decoration:none">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Status Hari Ini
        </a>
    </div>

    {{-- Selector anak --}}
    @if($anakList->count() > 1)
    <div class="anak-selector">
        @foreach($anakList as $a)
        <a href="{{ route('ortu.absensi.riwayat', ['siswa_id' => $a->id]) }}"
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
            <div class="rekap-icon" style="background:var(--hadir)">✅</div>
            <div>
                <p class="rekap-label">Hadir</p>
                <p class="rekap-val" style="color:var(--hadir-text)">{{ $rekap['hadir'] }}</p>
            </div>
        </div>
        <div class="rekap-card">
            <div class="rekap-icon" style="background:var(--izin)">📋</div>
            <div>
                <p class="rekap-label">Izin</p>
                <p class="rekap-val" style="color:var(--izin-text)">{{ $rekap['izin'] }}</p>
            </div>
        </div>
        <div class="rekap-card">
            <div class="rekap-icon" style="background:var(--sakit)">🤒</div>
            <div>
                <p class="rekap-label">Sakit</p>
                <p class="rekap-val" style="color:var(--sakit-text)">{{ $rekap['sakit'] }}</p>
            </div>
        </div>
        <div class="rekap-card">
            <div class="rekap-icon" style="background:var(--alfa)">❌</div>
            <div>
                <p class="rekap-label">Alfa</p>
                <p class="rekap-val" style="color:var(--alfa-text)">{{ $rekap['alfa'] }}</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('ortu.absensi.riwayat') }}">
            @if(request('siswa_id'))
                <input type="hidden" name="siswa_id" value="{{ request('siswa_id') }}">
            @endif
            <div class="filter-row">
                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-select">
                        <option value="">Semua Status</option>
                        @foreach($statusList as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                        @endforeach
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
                @if(request()->hasAny(['status','tanggal_dari','tanggal_sampai']))
                <a href="{{ route('ortu.absensi.riwayat', ['siswa_id' => request('siswa_id')]) }}" class="btn-filter btn-reset">Reset</a>
                @endif
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Riwayat Absensi
                <span>— {{ $absensi->firstItem() ?? 0 }}–{{ $absensi->lastItem() ?? 0 }} dari {{ $absensi->total() }} data</span>
            </p>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:44px">#</th>
                        <th>Tanggal</th>
                        <th>Hari</th>
                        <th class="center">Status</th>
                        <th>Jam Masuk</th>
                        <th>Metode</th>
                        <th>Mata Pelajaran</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $idx => $a)
                    @php
                        $statusLabel = ['hadir'=>'Hadir','telat'=>'Telat','izin'=>'Izin','sakit'=>'Sakit','alfa'=>'Alfa'][$a->status] ?? $a->status;
                    @endphp
                    <tr>
                        <td><span class="no-col">{{ $absensi->firstItem() + $idx }}</span></td>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;white-space:nowrap">
                            {{ $a->tanggal->translatedFormat('d M Y') }}
                        </td>
                        <td class="muted">{{ $a->tanggal->translatedFormat('l') }}</td>
                        <td class="center">
                            <span class="badge b-{{ $a->status }}">{{ $statusLabel }}</span>
                        </td>
                        <td class="muted">
                            {{ $a->jam_masuk ? \Carbon\Carbon::parse($a->jam_masuk)->format('H:i') : '—' }}
                        </td>
                        <td class="muted">{{ $a->metode ? ucfirst($a->metode) : '—' }}</td>
                        <td style="font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2)">
                            {{ $a->jadwalPelajaran?->mataPelajaran?->nama_mapel ?? '—' }}
                        </td>
                        <td>
                            @if($a->keterangan)
                                <span class="keterangan-col" title="{{ $a->keterangan }}">{{ $a->keterangan }}</span>
                            @elseif($a->path_surat_izin)
                                <a href="{{ $a->surat_izin_url }}" target="_blank"
                                   style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--brand-700);text-decoration:none">
                                    Lihat Surat →
                                </a>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">📋</div>
                                <p class="empty-title">Tidak ada data absensi</p>
                                <p class="empty-sub">Coba ubah filter pencarian atau pilih rentang tanggal yang berbeda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($absensi->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $absensi->firstItem() }}–{{ $absensi->lastItem() }} dari {{ $absensi->total() }}</p>
            <div class="pag-btns">
                @if($absensi->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $absensi->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif
                @foreach($absensi->getUrlRange(1, $absensi->lastPage()) as $page => $url)
                    @if($page == $absensi->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $absensi->lastPage() || abs($page - $absensi->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $absensi->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($absensi->hasMorePages())
                    <a href="{{ $absensi->nextPageUrl() }}" class="pag-btn">
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