<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap');
    :root{
        --brand:#7c3aed;--brand-50:#faf5ff;--brand-100:#ede9fe;--brand-600:#7c3aed;--brand-700:#6d28d9;--brand-800:#5b21b6;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--surface4:#e8edf5;
        --border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:14px;--radius-sm:9px;--radius-xs:6px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);
        --shadow:0 4px 16px rgba(0,0,0,.07),0 1px 3px rgba(0,0,0,.04);
        --ringan-bg:#dbeafe;--ringan-text:#1d4ed8;--ringan-border:#bfdbfe;
        --sedang-bg:#fef3c7;--sedang-text:#92400e;--sedang-border:#fde68a;
        --berat-bg:#fee2e2;--berat-text:#dc2626;--berat-border:#fecaca;
        --selesai-bg:#dcfce7;--selesai-text:#15803d;--selesai-border:#bbf7d0;
        --proses-bg:#fef3c7;--proses-text:#92400e;--proses-border:#fde68a;
        --banding-bg:#ede9fe;--banding-text:#6d28d9;--banding-border:#c4b5fd;
        --dibatalkan-bg:#f1f5f9;--dibatalkan-text:#94a3b8;--dibatalkan-border:#e2e8f0;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    .page{padding:28px 28px 72px;max-width:1440px;margin:0 auto;font-family:'DM Sans',sans-serif}

    /* ── Header ── */
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px;gap:16px;flex-wrap:wrap}
    .header-left{}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:800;color:var(--text);letter-spacing:-.02em}
    .page-sub{font-size:13px;color:var(--text3);margin-top:4px}
    .header-badge{display:inline-flex;align-items:center;gap:6px;background:var(--brand-100);color:var(--brand-700);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;padding:6px 12px;border-radius:99px;border:1.5px solid #c4b5fd}

    /* ── Anak selector ── */
    .anak-selector{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:22px}
    .anak-chip{display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:99px;border:1.5px solid var(--border);background:var(--surface);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);text-decoration:none;transition:all .18s;box-shadow:var(--shadow-sm)}
    .anak-chip:hover{border-color:var(--brand-600);color:var(--brand-700);box-shadow:0 0 0 3px var(--brand-100)}
    .anak-chip.active{background:var(--brand-700);border-color:var(--brand-700);color:#fff;box-shadow:0 4px 12px rgba(109,40,217,.35)}
    .anak-avatar{width:24px;height:24px;border-radius:50%;background:var(--brand-100);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:var(--brand-700);flex-shrink:0}
    .anak-chip.active .anak-avatar{background:rgba(255,255,255,.25);color:#fff}

    /* ── Summary grid ── */
    .summary-grid{display:grid;grid-template-columns:1.1fr 1fr 1fr;gap:16px;margin-bottom:22px}
    .summary-hero{background:linear-gradient(140deg,#5b21b6 0%,#7c3aed 45%,#a855f7 100%);border-radius:var(--radius);padding:24px 26px;color:#fff;position:relative;overflow:hidden;box-shadow:0 8px 32px rgba(109,40,217,.3)}
    .sh-deco1{position:absolute;right:-28px;bottom:-28px;width:130px;height:130px;border-radius:50%;background:rgba(255,255,255,.07)}
    .sh-deco2{position:absolute;right:30px;top:-40px;width:90px;height:90px;border-radius:50%;background:rgba(255,255,255,.05)}
    .sh-year{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;opacity:.75;letter-spacing:.1em;text-transform:uppercase;margin-bottom:8px;display:flex;align-items:center;gap:6px}
    .sh-year::before{content:'';width:6px;height:6px;border-radius:50%;background:rgba(255,255,255,.6);display:block}
    .sh-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:52px;font-weight:800;line-height:1;letter-spacing:-.04em}
    .sh-label{font-size:13px;opacity:.8;margin-top:6px;font-weight:500}
    .sh-divider{border:none;border-top:1px solid rgba(255,255,255,.15);margin:14px 0}
    .sh-meta{font-size:12.5px;opacity:.75;display:flex;align-items:center;gap:6px}

    .rekap-col{display:flex;flex-direction:column;gap:12px}
    .rekap-mini{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 18px;display:flex;align-items:center;gap:13px;flex:1;box-shadow:var(--shadow-sm);transition:box-shadow .18s}
    .rekap-mini:hover{box-shadow:var(--shadow)}
    .rekap-mini-icon{width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
    .rekap-mini-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em}
    .rekap-mini-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;font-weight:800;color:var(--text);line-height:1.1;margin-top:2px}

    /* ── Kategori rekap ── */
    .kategori-rekap{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:18px 22px;margin-bottom:16px;box-shadow:var(--shadow-sm)}
    .section-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:12px;display:flex;align-items:center;gap:8px}
    .section-title::after{content:'';flex:1;height:1px;background:var(--border)}
    .kategori-pills{display:flex;gap:8px;flex-wrap:wrap}
    .kategori-pill{display:inline-flex;align-items:center;gap:8px;padding:7px 14px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;border:1.5px solid;transition:transform .15s}
    .kategori-pill:hover{transform:translateY(-1px)}
    .kp-count{display:inline-flex;align-items:center;justify-content:center;min-width:20px;height:20px;padding:0 5px;border-radius:99px;background:rgba(0,0,0,.12);font-size:11px;font-weight:800}

    /* ── Filter ── */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:18px 22px;margin-bottom:16px;box-shadow:var(--shadow-sm)}
    .filter-row{display:flex;align-items:flex-end;gap:10px;flex-wrap:wrap}
    .filter-group{display:flex;flex-direction:column;gap:5px}
    .filter-label-txt{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em}
    .filter-input,.filter-select{height:38px;padding:0 12px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s,box-shadow .15s;min-width:160px}
    .filter-input:focus,.filter-select:focus{border-color:var(--brand-600);box-shadow:0 0 0 3px var(--brand-100)}
    .filter-actions{display:flex;gap:8px;align-items:flex-end}
    .btn{height:38px;padding:0 18px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;display:inline-flex;align-items:center;gap:6px;white-space:nowrap;text-decoration:none;transition:all .15s}
    .btn-primary{background:var(--brand-700);color:#fff;box-shadow:0 2px 8px rgba(109,40,217,.25)}
    .btn-primary:hover{background:var(--brand-800);box-shadow:0 4px 12px rgba(109,40,217,.35)}
    .btn-ghost{background:var(--surface2);color:var(--text2);border:1.5px solid var(--border)}
    .btn-ghost:hover{background:var(--surface3);border-color:var(--border2)}

    /* ── Table card ── */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-sm)}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:16px 22px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text)}
    .table-info-sub{font-size:12.5px;font-weight:400;color:var(--text3);margin-left:8px}
    .table-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch}
    table{width:100%;border-collapse:collapse;font-size:13.5px;min-width:860px}
    thead tr{background:var(--surface2);border-bottom:1.5px solid var(--border)}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.06em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid var(--surface3);transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:var(--brand-50)}
    td{padding:13px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    td.muted{color:var(--text3);font-size:12.5px}

    /* ── Badges ── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;border:1px solid}
    .b-ringan{background:var(--ringan-bg);color:var(--ringan-text);border-color:var(--ringan-border)}
    .b-sedang{background:var(--sedang-bg);color:var(--sedang-text);border-color:var(--sedang-border)}
    .b-berat{background:var(--berat-bg);color:var(--berat-text);border-color:var(--berat-border)}
    .b-selesai{background:var(--selesai-bg);color:var(--selesai-text);border-color:var(--selesai-border)}
    .b-proses,.b-pending,.b-diproses{background:var(--proses-bg);color:var(--proses-text);border-color:var(--proses-border)}
    .b-banding{background:var(--banding-bg);color:var(--banding-text);border-color:var(--banding-border)}
    .b-dibatalkan{background:var(--dibatalkan-bg);color:var(--dibatalkan-text);border-color:var(--dibatalkan-border)}

    .poin-chip{display:inline-flex;align-items:center;justify-content:center;min-width:34px;height:27px;padding:0 9px;border-radius:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;border:1px solid}
    .poin-ringan{background:var(--ringan-bg);color:var(--ringan-text);border-color:var(--ringan-border)}
    .poin-sedang{background:var(--sedang-bg);color:var(--sedang-text);border-color:var(--sedang-border)}
    .poin-berat{background:var(--berat-bg);color:var(--berat-text);border-color:var(--berat-border)}

    /* ── Kolom ── */
    .kat-dot{width:9px;height:9px;border-radius:50%;display:inline-block;flex-shrink:0;box-shadow:0 0 0 2px rgba(0,0,0,.06)}
    .kat-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text)}
    .tanggal-main{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text);white-space:nowrap}
    .tanggal-hari{font-size:11.5px;color:var(--text3);margin-top:2px;white-space:nowrap}
    .desc-col{max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--text2);display:block;font-size:13px}
    .tindakan-col{max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--text3);font-style:italic;display:block;font-size:12.5px}
    .pencatat{display:flex;align-items:center;gap:7px}
    .pencatat-avatar{width:26px;height:26px;border-radius:50%;background:var(--surface3);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:var(--text2);flex-shrink:0;border:1px solid var(--border)}
    .pencatat-name{font-size:12.5px;color:var(--text2);white-space:nowrap}

    /* ── No. row ── */
    .no-chip{display:inline-flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:6px;background:var(--surface3);font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3)}

    /* ── Pagination ── */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 22px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px;background:var(--surface2)}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px}
    .pag-btn{height:32px;min-width:32px;padding:0 9px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1.5px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s;cursor:pointer}
    .pag-btn:hover{background:var(--surface3);border-color:var(--border2)}
    .pag-btn.active{background:var(--brand-700);border-color:var(--brand-700);color:#fff;box-shadow:0 2px 8px rgba(109,40,217,.25)}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;display:flex;align-items:center;height:32px}

    /* ── Empty state ── */
    .empty-state{padding:64px 24px;text-align:center}
    .empty-icon{font-size:48px;margin-bottom:14px;display:block}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:16px;color:var(--text);margin-bottom:6px}
    .empty-sub{font-size:13.5px;color:var(--text3);max-width:340px;margin:0 auto;line-height:1.6}

    /* ── Nav tabs (jika ada halaman lain) ── */
    .nav-tabs{display:flex;gap:2px;background:var(--surface3);padding:4px;border-radius:10px;margin-bottom:22px;width:fit-content}
    .nav-tab{display:inline-flex;align-items:center;gap:7px;padding:8px 16px;border-radius:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);text-decoration:none;transition:all .18s;border:none;cursor:pointer;background:transparent}
    .nav-tab:hover{color:var(--text)}
    .nav-tab.active{background:var(--surface);color:var(--brand-700);box-shadow:var(--shadow-sm);font-weight:700}

    /* ── Responsive ── */
    @media(max-width:1024px){.summary-grid{grid-template-columns:1fr 1fr}}
    @media(max-width:900px){.summary-grid{grid-template-columns:1fr}.rekap-col{flex-direction:row}}
    @media(max-width:640px){.page{padding:16px 14px}.rekap-col{flex-direction:column}.filter-row{flex-direction:column;align-items:stretch}.filter-input,.filter-select{min-width:unset;width:100%}.filter-actions{flex-direction:row}}
</style>

<div class="page">

    {{-- ── Page header ── --}}
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Kedisiplinan Anak</h1>
            <p class="page-sub">Riwayat pelanggaran dan catatan kedisiplinan tahun {{ now()->year }}</p>
        </div>
        <div class="header-badge">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Data Real-time
        </div>
    </div>

    {{-- ── Nav tabs ── --}}
    <div class="nav-tabs">
        <a href="{{ route('ortu.kedisiplinan.riwayat', array_filter(['siswa_id' => $anak->id])) }}"
           class="nav-tab active">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Riwayat
        </a>
        <a href="{{ route('ortu.kedisiplinan.total-poin', array_filter(['siswa_id' => $anak->id])) }}"
           class="nav-tab">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Total Poin
        </a>
        <a href="{{ route('ortu.kedisiplinan.status', array_filter(['siswa_id' => $anak->id])) }}"
           class="nav-tab">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
            Status Aktif
        </a>
    </div>

    {{-- ── Selector anak (hanya jika > 1 anak) ── --}}
    @if($anakList->count() > 1)
    <div class="anak-selector">
        @foreach($anakList as $a)
        @php
            $params = array_filter([
                'siswa_id'       => $a->id,
                'kategori_id'    => request('kategori_id'),
                'tanggal_dari'   => request('tanggal_dari'),
                'tanggal_sampai' => request('tanggal_sampai'),
                'tingkat'        => request('tingkat'),
                'status'         => request('status'),
            ]);
        @endphp
        <a href="{{ route('ortu.kedisiplinan.riwayat', $params) }}"
           class="anak-chip {{ $anak->id === $a->id ? 'active' : '' }}">
            <div class="anak-avatar">{{ strtoupper(mb_substr($a->nama_lengkap, 0, 1)) }}</div>
            {{ $a->nama_lengkap }}
            @if($a->kelas)
                <span style="font-size:11px;opacity:.7">· {{ $a->kelas->nama_kelas }}</span>
            @endif
        </a>
        @endforeach
    </div>
    @endif

    {{-- ── Summary grid ── --}}
    <div class="summary-grid">
        <div class="summary-hero">
            <div class="sh-deco1"></div>
            <div class="sh-deco2"></div>
            <p class="sh-year">Total Poin {{ now()->year }}</p>
            <p class="sh-val">{{ $totalPoin }}</p>
            <p class="sh-label">Poin Pelanggaran Aktif</p>
            <hr class="sh-divider">
            <p class="sh-meta">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                {{ $anak->nama_lengkap }}
                @if($anak->kelas)
                &nbsp;·&nbsp; {{ $anak->kelas->nama_kelas }}
                @endif
            </p>
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

    {{-- ── Rekap per kategori ── --}}
    @if($rekapKategori->isNotEmpty())
    <div class="kategori-rekap">
        <p class="section-title">Rekap per Kategori ({{ now()->year }})</p>
        <div class="kategori-pills">
            @foreach($rekapKategori as $rek)
            @php
                $tingkat   = $rek['tingkat'] ?? 'ringan';
                $bgMap     = ['ringan'=>'var(--ringan-bg)',   'sedang'=>'var(--sedang-bg)',   'berat'=>'var(--berat-bg)'];
                $colorMap  = ['ringan'=>'var(--ringan-text)', 'sedang'=>'var(--sedang-text)', 'berat'=>'var(--berat-text)'];
                $borderMap = ['ringan'=>'var(--ringan-border)','sedang'=>'var(--sedang-border)','berat'=>'var(--berat-border)'];
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

    {{-- ── Filter ── --}}
    <div class="filter-card">
        <p class="section-title" style="margin-bottom:14px">Filter & Pencarian</p>
        <form method="GET" action="{{ route('ortu.kedisiplinan.riwayat') }}">
            {{-- Preserve siswa_id melalui hidden field --}}
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
                    <label class="filter-label-txt">Tingkat</label>
                    <select name="tingkat" class="filter-select" style="min-width:130px">
                        <option value="">Semua Tingkat</option>
                        <option value="ringan" {{ request('tingkat') === 'ringan' ? 'selected' : '' }}>Ringan</option>
                        <option value="sedang" {{ request('tingkat') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="berat"  {{ request('tingkat') === 'berat'  ? 'selected' : '' }}>Berat</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label-txt">Status</label>
                    <select name="status" class="filter-select" style="min-width:140px">
                        <option value="">Semua Status</option>
                        <option value="pending"    {{ request('status') === 'pending'    ? 'selected' : '' }}>Pending</option>
                        <option value="diproses"   {{ request('status') === 'diproses'   ? 'selected' : '' }}>Diproses</option>
                        <option value="banding"    {{ request('status') === 'banding'    ? 'selected' : '' }}>Banding</option>
                        <option value="selesai"    {{ request('status') === 'selesai'    ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
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

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Filter
                    </button>
                    @if(request()->hasAny(['kategori_id','tanggal_dari','tanggal_sampai','tingkat','status']))
                    <a href="{{ route('ortu.kedisiplinan.riwayat', array_filter(['siswa_id' => request('siswa_id')])) }}"
                       class="btn btn-ghost">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Reset
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- ── Tabel ── --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Riwayat Pelanggaran
                @if($pelanggaran->total() > 0)
                <span class="table-info-sub">— {{ $pelanggaran->firstItem() }}–{{ $pelanggaran->lastItem() }} dari {{ $pelanggaran->total() }} data</span>
                @else
                <span class="table-info-sub">— Tidak ada data</span>
                @endif
            </p>
            @if(request()->hasAny(['kategori_id','tanggal_dari','tanggal_sampai','tingkat','status']))
            <span class="badge b-banding" style="font-size:12px">
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                Filter aktif
            </span>
            @endif
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
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
                        // Gunakan accessor warna_hex dari model (bukan properti DB langsung)
                        $tingkat      = $p->kategori?->tingkat ?? 'ringan';
                        $tingkatLabel = ['ringan'=>'Ringan','sedang'=>'Sedang','berat'=>'Berat'][$tingkat] ?? ucfirst($tingkat);
                        $warnaHex     = $p->kategori?->warna_hex ?? '#6d28d9';
                        // Poin: dari kolom poin record dulu, fallback ke poin_default kategori
                        $poinTampil   = $p->poin ?? $p->kategori?->poin_default ?? 0;
                        $nomor        = $pelanggaran->firstItem() + $idx;

                        // Label status menggunakan konstanta model
                        $statusLabel  = match($p->status) {
                            \App\Models\Pelanggaran::STATUS_SELESAI     => 'Selesai',
                            \App\Models\Pelanggaran::STATUS_DIBATALKAN  => 'Dibatalkan',
                            \App\Models\Pelanggaran::STATUS_DIPROSES    => 'Diproses',
                            \App\Models\Pelanggaran::STATUS_BANDING     => 'Banding',
                            default                                      => 'Pending',
                        };
                        $statusClass  = match($p->status) {
                            \App\Models\Pelanggaran::STATUS_SELESAI     => 'b-selesai',
                            \App\Models\Pelanggaran::STATUS_DIBATALKAN  => 'b-dibatalkan',
                            \App\Models\Pelanggaran::STATUS_BANDING     => 'b-banding',
                            \App\Models\Pelanggaran::STATUS_DIPROSES    => 'b-diproses',
                            default                                      => 'b-pending',
                        };
                    @endphp
                    <tr>
                        <td>
                            <span class="no-chip">{{ $nomor }}</span>
                        </td>
                        <td>
                            <p class="tanggal-main">{{ $p->tanggal->translatedFormat('d M Y') }}</p>
                            <p class="tanggal-hari">{{ $p->tanggal->translatedFormat('l') }}</p>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px">
                                <span class="kat-dot" style="background:{{ $warnaHex }}"></span>
                                <span class="kat-name">{{ $p->kategori?->nama ?? '—' }}</span>
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
                            <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                        </td>
                        <td>
                            @if($p->dicatatOleh)
                            <div class="pencatat">
                                <div class="pencatat-avatar">{{ strtoupper(mb_substr($p->dicatatOleh->name, 0, 1)) }}</div>
                                <span class="pencatat-name">{{ $p->dicatatOleh->name }}</span>
                            </div>
                            @else
                            <span class="muted">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <span class="empty-icon">🎉</span>
                                <p class="empty-title">Tidak ada catatan pelanggaran</p>
                                <p class="empty-sub">
                                    @if(request()->hasAny(['kategori_id','tanggal_dari','tanggal_sampai','tingkat','status']))
                                        Tidak ada data yang cocok dengan filter yang dipilih. Coba ubah atau reset kriteria pencarian.
                                    @else
                                        {{ $anak->nama_lengkap }} tidak memiliki catatan pelanggaran. Terus pertahankan prestasi ini!
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Pagination ── --}}
        @if($pelanggaran->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $pelanggaran->firstItem() }}–{{ $pelanggaran->lastItem() }} dari {{ $pelanggaran->total() }} data</p>
            <div class="pag-btns">
                {{-- Previous --}}
                @if($pelanggaran->onFirstPage())
                    <span class="pag-btn disabled" aria-disabled="true">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $pelanggaran->previousPageUrl() }}" class="pag-btn" aria-label="Halaman sebelumnya">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                {{-- Page numbers dengan ellipsis yang benar --}}
                @php
                    $current  = $pelanggaran->currentPage();
                    $last     = $pelanggaran->lastPage();
                    $window   = 2; // halaman di sekitar current
                    $shown    = [];
                    // Selalu tampilkan: 1, last, dan window di sekitar current
                    for ($i = 1; $i <= $last; $i++) {
                        if ($i === 1 || $i === $last || abs($i - $current) <= $window) {
                            $shown[] = $i;
                        }
                    }
                    $shown = array_unique($shown);
                    sort($shown);
                @endphp

                @php $prev = null; @endphp
                @foreach($shown as $page)
                    @if($prev !== null && $page - $prev > 1)
                        <span class="pag-ellipsis">…</span>
                    @endif
                    @if($page === $current)
                        <span class="pag-btn active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $pelanggaran->url($page) }}" class="pag-btn">{{ $page }}</a>
                    @endif
                    @php $prev = $page; @endphp
                @endforeach

                {{-- Next --}}
                @if($pelanggaran->hasMorePages())
                    <a href="{{ $pelanggaran->nextPageUrl() }}" class="pag-btn" aria-label="Halaman berikutnya">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                @else
                    <span class="pag-btn disabled" aria-disabled="true">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </span>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>
</x-app-layout>