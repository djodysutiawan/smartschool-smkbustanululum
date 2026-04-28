<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root{
        --brand:#7c3aed;--brand-50:#faf5ff;--brand-100:#ede9fe;--brand-600:#7c3aed;--brand-700:#6d28d9;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:12px;--radius-sm:8px;
        --ringan-bg:#dbeafe;--ringan-text:#1d4ed8;--ringan-border:#bfdbfe;
        --sedang-bg:#fff3cd;--sedang-text:#a16207;--sedang-border:#fde68a;
        --berat-bg:#fee2e2;--berat-text:#dc2626;--berat-border:#fecaca;
        --selesai-bg:#dcfce7;--selesai-text:#15803d;
        --proses-bg:#fff3cd;--proses-text:#a16207;
        --dibatalkan-bg:#f1f5f9;--dibatalkan-text:#94a3b8;
    }
    *{box-sizing:border-box}
    .page{padding:28px 28px 60px;max-width:1400px;margin:0 auto}
    .page-header{margin-bottom:24px}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:13px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}

    .anak-selector{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px}
    .anak-chip{display:inline-flex;align-items:center;gap:8px;padding:7px 16px;border-radius:99px;border:1.5px solid var(--border);background:var(--surface);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);text-decoration:none;transition:all .15s}
    .anak-chip:hover{border-color:var(--brand-600);color:var(--brand-700)}
    .anak-chip.active{background:var(--brand-700);border-color:var(--brand-700);color:#fff}
    .anak-avatar{width:22px;height:22px;border-radius:50%;background:var(--brand-100);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:var(--brand-700);flex-shrink:0}
    .anak-chip.active .anak-avatar{background:rgba(255,255,255,.25);color:#fff}

    .summary-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:20px}
    .summary-hero{background:linear-gradient(135deg,var(--brand-700) 0%,#a855f7 100%);border-radius:var(--radius);padding:22px 24px;color:#fff;position:relative;overflow:hidden}
    .sh-deco{position:absolute;right:-24px;bottom:-24px;width:110px;height:110px;border-radius:50%;background:rgba(255,255,255,.08)}
    .sh-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;opacity:.8;letter-spacing:.07em;text-transform:uppercase;margin-bottom:6px}
    .sh-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:44px;font-weight:800;line-height:1}
    .sh-sub{font-size:12.5px;opacity:.8;margin-top:6px;font-family:'DM Sans',sans-serif}
    .rekap-col{display:flex;flex-direction:column;gap:10px}
    .rekap-mini{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;flex:1}
    .rekap-mini-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0}
    .rekap-mini-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:600;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .rekap-mini-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}

    .kategori-rekap{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px}
    .kategori-rekap-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.06em;margin-bottom:12px}
    .kategori-pills{display:flex;gap:8px;flex-wrap:wrap}
    .kategori-pill{display:inline-flex;align-items:center;gap:8px;padding:7px 14px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;border:1.5px solid}
    .kp-count{display:inline-flex;align-items:center;justify-content:center;width:20px;height:20px;border-radius:50%;background:rgba(0,0,0,.12);font-size:11px;font-weight:800}

    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px}
    .filter-row{display:flex;align-items:flex-end;gap:12px;flex-wrap:wrap}
    .filter-group{display:flex;flex-direction:column;gap:5px}
    .filter-label-txt{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .filter-input,.filter-select{height:36px;padding:0 12px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s;min-width:160px}
    .filter-input:focus,.filter-select:focus{border-color:var(--brand-600)}
    .btn-filter{height:36px;padding:0 18px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;background:var(--brand-700);color:#fff;display:inline-flex;align-items:center;gap:6px;white-space:nowrap;text-decoration:none}
    .btn-filter:hover{filter:brightness(.93)}
    .btn-reset{background:var(--surface2);color:var(--text2);border:1.5px solid var(--border)}
    .btn-reset:hover{background:var(--surface3);filter:none}

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
    tbody tr:hover{background:#fdfaff}
    td{padding:12px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    td.muted{color:var(--text3);font-size:12.5px;font-family:'DM Sans',sans-serif}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .b-ringan{background:var(--ringan-bg);color:var(--ringan-text)}
    .b-sedang{background:var(--sedang-bg);color:var(--sedang-text)}
    .b-berat{background:var(--berat-bg);color:var(--berat-text)}
    .b-selesai{background:var(--selesai-bg);color:var(--selesai-text)}
    .b-proses{background:var(--proses-bg);color:var(--proses-text)}
    .b-dibatalkan{background:var(--dibatalkan-bg);color:var(--dibatalkan-text)}

    .poin-chip{display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:26px;padding:0 8px;border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:800}
    .poin-ringan{background:var(--ringan-bg);color:var(--ringan-text)}
    .poin-sedang{background:var(--sedang-bg);color:var(--sedang-text)}
    .poin-berat{background:var(--berat-bg);color:var(--berat-text)}

    .kat-dot{width:8px;height:8px;border-radius:50%;display:inline-block;flex-shrink:0}
    .desc-col{max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2);display:block}
    .tindakan-col{max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3);font-style:italic;display:block}

    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3);font-family:'DM Sans',sans-serif}
    .pag-btns{display:flex;gap:4px}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--brand-700);border-color:var(--brand-700);color:#fff}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;display:flex;align-items:center}

    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{font-size:44px;margin-bottom:12px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:4px}
    .empty-sub{font-size:13px;color:var(--text3);font-family:'DM Sans',sans-serif;max-width:320px;margin:0 auto}

    @media(max-width:900px){.summary-grid{grid-template-columns:1fr}.rekap-col{flex-direction:row}}
    @media(max-width:640px){.page{padding:16px}.rekap-col{flex-direction:column}}
</style>

<div class="page">
    <div class="page-header">
        <h1 class="page-title">Kedisiplinan Anak</h1>
        <p class="page-sub">Riwayat pelanggaran dan catatan kedisiplinan tahun {{ now()->year }}</p>
    </div>

    {{-- Selector anak --}}
    @if($anakList->count() > 1)
    <div class="anak-selector">
        @foreach($anakList as $a)
        <a href="{{ route('ortu.kedisiplinan.riwayat', ['siswa_id' => $a->id]) }}"
           class="anak-chip {{ $anak->id === $a->id ? 'active' : '' }}">
            <div class="anak-avatar">{{ strtoupper(substr($a->nama_lengkap, 0, 1)) }}</div>
            {{ $a->nama_lengkap }}
            @if($a->kelas)
                <span style="font-size:11px;opacity:.75">{{ $a->kelas->nama_kelas }}</span>
            @endif
        </a>
        @endforeach
    </div>
    @endif

    {{-- Summary --}}
    <div class="summary-grid">
        <div class="summary-hero">
            <div class="sh-deco"></div>
            <p class="sh-label">Total Poin Pelanggaran {{ now()->year }}</p>
            <p class="sh-val">{{ $totalPoin ?? 0 }}</p>
            <p class="sh-sub">{{ $anak->nama_lengkap }} · {{ $anak->kelas->nama_kelas ?? '—' }}</p>
        </div>
        <div class="rekap-col">
            <div class="rekap-mini">
                <div class="rekap-mini-icon" style="background:var(--berat-bg)">⚠️</div>
                <div>
                    <p class="rekap-mini-label">Pelanggaran Berat</p>
                    <p class="rekap-mini-val" style="color:var(--berat-text)">{{ $totalBerat }}</p>
                </div>
            </div>
            <div class="rekap-mini">
                <div class="rekap-mini-icon" style="background:var(--sedang-bg)">⚡</div>
                <div>
                    <p class="rekap-mini-label">Pelanggaran Sedang</p>
                    <p class="rekap-mini-val" style="color:var(--sedang-text)">{{ $totalSedang }}</p>
                </div>
            </div>
        </div>
        <div class="rekap-col">
            <div class="rekap-mini">
                <div class="rekap-mini-icon" style="background:var(--ringan-bg)">💬</div>
                <div>
                    <p class="rekap-mini-label">Pelanggaran Ringan</p>
                    <p class="rekap-mini-val" style="color:var(--ringan-text)">{{ $totalRingan }}</p>
                </div>
            </div>
            <div class="rekap-mini">
                <div class="rekap-mini-icon" style="background:var(--surface3)">📋</div>
                <div>
                    <p class="rekap-mini-label">Total Kejadian</p>
                    <p class="rekap-mini-val">{{ $pelanggaran->total() }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Rekap per kategori --}}
    @if($rekapKategori->isNotEmpty())
    <div class="kategori-rekap">
        <p class="kategori-rekap-title">Rekap per Kategori ({{ now()->year }})</p>
        <div class="kategori-pills">
            @foreach($rekapKategori as $rek)
            @php
                $tingkat   = $rek['tingkat'] ?? 'ringan';
                $bgMap     = ['ringan' => 'var(--ringan-bg)',  'sedang' => 'var(--sedang-bg)',  'berat' => 'var(--berat-bg)'];
                $colorMap  = ['ringan' => 'var(--ringan-text)','sedang' => 'var(--sedang-text)','berat' => 'var(--berat-text)'];
                $borderMap = ['ringan' => 'var(--ringan-border)','sedang' => 'var(--sedang-border)','berat' => 'var(--berat-border)'];
            @endphp
            <div class="kategori-pill"
                 style="background:{{ $bgMap[$tingkat] ?? 'var(--surface2)' }};color:{{ $colorMap[$tingkat] ?? 'var(--text2)' }};border-color:{{ $borderMap[$tingkat] ?? 'var(--border)' }}">
                {{ $rek['nama'] }}
                <span class="kp-count">{{ $rek['total'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('ortu.kedisiplinan.riwayat') }}">
            @if(request('siswa_id'))
                <input type="hidden" name="siswa_id" value="{{ request('siswa_id') }}">
            @endif
            <div class="filter-row">
                <div class="filter-group">
                    <label class="filter-label-txt">Kategori</label>
                    <select name="kategori_id" class="filter-select">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoriList as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label-txt">Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" class="filter-input" value="{{ request('tanggal_dari') }}">
                </div>
                <div class="filter-group">
                    <label class="filter-label-txt">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" class="filter-input" value="{{ request('tanggal_sampai') }}">
                </div>
                <button type="submit" class="btn-filter">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Filter
                </button>
                @if(request()->hasAny(['kategori_id','tanggal_dari','tanggal_sampai']))
                <a href="{{ route('ortu.kedisiplinan.riwayat', array_filter(['siswa_id' => request('siswa_id')])) }}"
                   class="btn-filter btn-reset">Reset</a>
                @endif
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Riwayat Pelanggaran
                <span>— {{ $pelanggaran->firstItem() ?? 0 }}–{{ $pelanggaran->lastItem() ?? 0 }} dari {{ $pelanggaran->total() }} data</span>
            </p>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:44px">#</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th class="center">Tingkat</th>
                        <th class="center">Poin</th>
                        <th>Deskripsi</th>
                        <th>Tindakan</th>
                        <th class="center">Status</th>
                        <th>Dicatat Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggaran as $idx => $p)
                    @php
                        $tingkat      = $p->kategori?->tingkat ?? 'ringan';
                        $tingkatLabel = ['ringan' => 'Ringan','sedang' => 'Sedang','berat' => 'Berat'][$tingkat] ?? ucfirst($tingkat);
                        $warnaHex     = $p->kategori?->warna_hex ?? '#6d28d9';
                        $poinTampil   = $p->poin ?? $p->kategori?->poin_default ?? 0;
                    @endphp
                    <tr>
                        <td class="muted">{{ $pelanggaran->firstItem() + $idx }}</td>
                        <td style="white-space:nowrap">
                            <div style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)">
                                {{ $p->tanggal->translatedFormat('d M Y') }}
                            </div>
                            <div style="font-size:11.5px;color:var(--text3);font-family:'DM Sans',sans-serif">
                                {{ $p->tanggal->translatedFormat('l') }}
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:7px">
                                <span class="kat-dot" style="background:{{ $warnaHex }}"></span>
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text)">
                                    {{ $p->kategori?->nama ?? '—' }}
                                </span>
                            </div>
                        </td>
                        <td class="center">
                            <span class="badge b-{{ $tingkat }}">{{ $tingkatLabel }}</span>
                        </td>
                        <td class="center">
                            <span class="poin-chip poin-{{ $tingkat }}">{{ $poinTampil }}</span>
                        </td>
                        <td>
                            @if($p->deskripsi)
                                <span class="desc-col" title="{{ $p->deskripsi }}">{{ $p->deskripsi }}</span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($p->tindakan)
                                <span class="tindakan-col" title="{{ $p->tindakan }}">{{ $p->tindakan }}</span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>
                        <td class="center">
                            @if($p->status === 'selesai')
                                <span class="badge b-selesai">Selesai</span>
                            @elseif($p->status === 'dibatalkan')
                                <span class="badge b-dibatalkan">Dibatalkan</span>
                            @else
                                <span class="badge b-proses">Dalam Proses</span>
                            @endif
                        </td>
                        <td class="muted">{{ $p->dicatatOleh?->name ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">🎉</div>
                                <p class="empty-title">Tidak ada catatan pelanggaran</p>
                                <p class="empty-sub">
                                    @if(request()->hasAny(['kategori_id','tanggal_dari','tanggal_sampai']))
                                        Tidak ada data yang cocok dengan filter. Coba ubah kriteria pencarian.
                                    @else
                                        {{ $anak->nama_lengkap }} tidak memiliki catatan pelanggaran. Pertahankan prestasi ini!
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pelanggaran->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $pelanggaran->firstItem() }}–{{ $pelanggaran->lastItem() }} dari {{ $pelanggaran->total() }}</p>
            <div class="pag-btns">
                @if($pelanggaran->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $pelanggaran->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif
                @foreach($pelanggaran->getUrlRange(1, $pelanggaran->lastPage()) as $page => $url)
                    @if($page == $pelanggaran->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $pelanggaran->lastPage() || abs($page - $pelanggaran->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $pelanggaran->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($pelanggaran->hasMorePages())
                    <a href="{{ $pelanggaran->nextPageUrl() }}" class="pag-btn">
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