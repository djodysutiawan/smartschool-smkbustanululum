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
    .page{padding:24px 28px 64px;max-width:2000px;}

    /* ── Header ── */
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Outfit',sans-serif;font-size:22px;font-weight:900;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text4);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}

    /* ── Buttons ── */
    .btn{display:inline-flex;align-items:center;gap:7px;height:38px;padding:0 16px;border-radius:var(--radius-sm);font-family:'Outfit',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap;}
    .btn-primary{background:var(--s-600);color:#fff;}
    .btn-primary:hover{background:var(--s-700);}
    .btn-outline{background:var(--surface);color:var(--text2);border:1px solid var(--border);}
    .btn-outline:hover{background:var(--surface3);}
    .btn-success{background:var(--g-500);color:#fff;}
    .btn-success:hover{background:#059669;}
    .btn-sm{height:32px;padding:0 12px;font-size:12px;}

    /* ── Alert flash ── */
    .alert{display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13px;}
    .alert-success{background:var(--g-50);border:1px solid var(--g-100);color:#065f46;}
    .alert-warning{background:var(--a-50);border:1px solid var(--a-100);color:#92400e;}
    .alert-error{background:var(--r-50);border:1px solid var(--r-100);color:#991b1b;}

    /* ── Sesi gerbang banner ── */
    .sesi-banner{display:flex;align-items:center;gap:12px;padding:14px 18px;border-radius:var(--radius);margin-bottom:20px;border:1px solid;}
    .sesi-banner.masuk{background:var(--g-50);border-color:var(--g-100);}
    .sesi-banner.pulang{background:var(--s-50);border-color:var(--s-100);}
    .sesi-banner.none{background:var(--surface3);border-color:var(--border);}
    .sesi-banner-icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .sesi-banner.masuk .sesi-banner-icon{background:var(--g-100);}
    .sesi-banner.pulang .sesi-banner-icon{background:var(--s-100);}
    .sesi-banner.none .sesi-banner-icon{background:var(--border);}
    .sesi-banner-label{font-family:'Outfit',sans-serif;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--text4);margin-bottom:2px;}
    .sesi-banner-val{font-family:'Outfit',sans-serif;font-size:14px;font-weight:800;color:var(--text);}
    .sesi-dot{width:8px;height:8px;border-radius:50%;display:inline-block;margin-right:6px;}
    .sesi-dot.aktif{background:var(--g-500);animation:blink 1.4s infinite;}
    @keyframes blink{0%,100%{opacity:1}50%{opacity:.3}}

    /* ── Barcode card ── */
    .barcode-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-md);overflow:hidden;margin-bottom:20px;}
    .barcode-card-header{display:flex;align-items:center;justify-content:space-between;padding:18px 20px;border-bottom:1px solid var(--border);background:var(--surface2);}
    .barcode-card-title{font-family:'Outfit',sans-serif;font-size:15px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px;}
    .barcode-card-body{padding:28px 20px;display:flex;flex-direction:column;align-items:center;gap:16px;}
    .barcode-wrap{background:#fff;border:1px solid var(--border);border-radius:var(--radius-sm);padding:20px 24px;display:flex;flex-direction:column;align-items:center;gap:12px;box-shadow:var(--shadow-sm);}
    .barcode-kode{font-family:'Outfit',sans-serif;font-size:13px;font-weight:700;color:var(--text3);letter-spacing:.08em;margin-top:4px;}
    .barcode-info-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;width:100%;max-width:420px;}
    .barcode-info-item{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-xs);padding:10px 14px;}
    .barcode-info-label{font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;color:var(--text4);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;}
    .barcode-info-val{font-family:'Outfit',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .barcode-actions{display:flex;gap:8px;flex-wrap:wrap;justify-content:center;}

    /* ── Status badge ── */
    .status-badge{display:inline-flex;align-items:center;gap:4px;font-family:'Outfit',sans-serif;font-size:10.5px;font-weight:700;padding:3px 10px;border-radius:99px;}
    .status-badge-dot{width:5px;height:5px;border-radius:50%;}
    .status-badge.berlaku{background:var(--g-50);color:var(--g-500);border:1px solid var(--g-100);}
    .status-badge.berlaku .status-badge-dot{background:var(--g-500);animation:blink 1.4s infinite;}
    .status-badge.nonaktif{background:var(--surface3);color:var(--text4);border:1px solid var(--border);}
    .status-badge.kadaluarsa{background:var(--a-50);color:var(--a-500);border:1px solid var(--a-100);}

    /* ── Empty state ── */
    .empty-card{background:var(--surface);border:2px dashed var(--border);border-radius:var(--radius);padding:48px 32px;text-align:center;margin-bottom:20px;}
    .empty-icon{width:64px;height:64px;border-radius:16px;background:var(--surface3);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;}
    .empty-title{font-family:'Outfit',sans-serif;font-size:16px;font-weight:800;color:var(--text);margin-bottom:6px;}
    .empty-sub{font-size:13px;color:var(--text4);line-height:1.6;}

    /* ── Riwayat table ── */
    .riwayat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-sm);overflow:hidden;}
    .riwayat-header{padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
    .riwayat-title{font-family:'Outfit',sans-serif;font-size:13px;font-weight:800;color:var(--text);}
    table{width:100%;border-collapse:collapse;}
    thead th{padding:10px 16px;text-align:left;font-family:'Outfit',sans-serif;font-size:10.5px;font-weight:800;color:var(--text4);text-transform:uppercase;letter-spacing:.07em;background:var(--surface2);border-bottom:1px solid var(--border);}
    tbody tr{border-bottom:1px solid var(--border);}
    tbody tr:last-child{border-bottom:none;}
    tbody td{padding:11px 16px;font-size:12.5px;color:var(--text2);}
    .kode-mono{font-family:'Outfit',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;}

    @media(max-width:600px){
        .page{padding:14px 14px 56px;}
        .barcode-info-grid{grid-template-columns:1fr;}
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Barcode Gerbang Saya</h1>
            <p class="page-sub">Tunjukkan barcode ini saat scan masuk &amp; pulang di gerbang sekolah</p>
        </div>
        @if($barcodeGerbang)
            <div class="header-actions">
                <a href="{{ route('guru.barcode.gerbang') }}" class="btn btn-primary">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 14h.01M14 17h.01M17 14h.01M17 17h.01M20 14h.01M20 17h.01"/></svg>
                    Tampilkan Fullscreen
                </a>
                <a href="{{ route('guru.barcode.download') }}" class="btn btn-outline">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Download Kode
                </a>
            </div>
        @endif
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            {{ session('warning') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Sesi Gerbang Banner --}}
    @if($sesiGerbangAktif)
        @php $tipeSesi = $sesiGerbangAktif->tipe ?? 'masuk'; @endphp
        <div class="sesi-banner {{ $tipeSesi }}">
            <div class="sesi-banner-icon">
                @if($tipeSesi === 'pulang')
                    <svg width="18" height="18" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                @else
                    <svg width="18" height="18" fill="none" stroke="var(--g-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                @endif
            </div>
            <div>
                <p class="sesi-banner-label">Sesi Gerbang Aktif</p>
                <p class="sesi-banner-val">
                    <span class="sesi-dot aktif"></span>
                    {{ $tipeSesi === 'pulang' ? 'JAM PULANG' : 'JAM MASUK' }}
                    — Silakan scan barcode Anda di gerbang
                </p>
            </div>
        </div>
    @else
        <div class="sesi-banner none">
            <div class="sesi-banner-icon">
                <svg width="18" height="18" fill="none" stroke="var(--text4)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
                <p class="sesi-banner-label">Sesi Gerbang</p>
                <p class="sesi-banner-val" style="color:var(--text4)">Tidak ada sesi aktif saat ini</p>
            </div>
        </div>
    @endif

    {{-- Barcode Card --}}
    @if($barcodeGerbang)
        <div class="barcode-card">
            <div class="barcode-card-header">
                <span class="barcode-card-title">
                    <svg width="16" height="16" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 14h.01M14 17h.01M17 14h.01M17 17h.01M20 14h.01M20 17h.01"/></svg>
                    Barcode Gerbang
                </span>
                @if($barcodeGerbang->masih_berlaku)
                    <span class="status-badge berlaku"><span class="status-badge-dot"></span>Aktif & Berlaku</span>
                @elseif(!$barcodeGerbang->is_aktif)
                    <span class="status-badge nonaktif"><span class="status-badge-dot"></span>Nonaktif</span>
                @else
                    <span class="status-badge kadaluarsa"><span class="status-badge-dot"></span>Kadaluarsa</span>
                @endif
            </div>
            <div class="barcode-card-body">
                {{-- Barcode SVG --}}
                <div class="barcode-wrap">
                    <svg id="barcodeGerbang"></svg>
                    <p class="barcode-kode">{{ $barcodeGerbang->kode }}</p>
                </div>

                {{-- Info grid --}}
                <div class="barcode-info-grid">
                    <div class="barcode-info-item">
                        <p class="barcode-info-label">Nama</p>
                        <p class="barcode-info-val">{{ $guru->nama_lengkap }}</p>
                    </div>
                    <div class="barcode-info-item">
                        <p class="barcode-info-label">NIP</p>
                        <p class="barcode-info-val">{{ $guru->nip ?? '—' }}</p>
                    </div>
                    <div class="barcode-info-item">
                        <p class="barcode-info-label">Berlaku Mulai</p>
                        <p class="barcode-info-val">{{ $barcodeGerbang->berlaku_mulai?->format('d M Y') ?? '—' }}</p>
                    </div>
                    <div class="barcode-info-item">
                        <p class="barcode-info-label">Berlaku Sampai</p>
                        <p class="barcode-info-val">
                            {{ $barcodeGerbang->berlaku_sampai?->format('d M Y') ?? 'Selamanya' }}
                        </p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="barcode-actions">
                    <a href="{{ route('guru.barcode.gerbang') }}" class="btn btn-primary">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><polyline points="8 21 12 17 16 21"/></svg>
                        Tampilkan Fullscreen
                    </a>
                    <a href="{{ route('guru.barcode.download') }}" class="btn btn-outline">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Download Kode
                    </a>
                </div>
            </div>
        </div>
    @else
        {{-- Empty state --}}
        <div class="empty-card">
            <div class="empty-icon">
                <svg width="28" height="28" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 14h.01M14 17h.01M17 14h.01M17 17h.01M20 14h.01M20 17h.01"/></svg>
            </div>
            <p class="empty-title">Belum Ada Barcode Gerbang</p>
            <p class="empty-sub">
                Anda belum memiliki barcode gerbang aktif.<br>
                Silakan hubungi admin sekolah untuk mendapatkan barcode.
            </p>
        </div>
    @endif

    {{-- Riwayat Barcode --}}
    @if($riwayatBarcode->isNotEmpty())
        <div class="riwayat-card">
            <div class="riwayat-header">
                <span class="riwayat-title">Riwayat Barcode</span>
                <span style="font-size:12px;color:var(--text4)">{{ $riwayatBarcode->count() }} barcode</span>
            </div>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Berlaku Mulai</th>
                            <th>Berlaku Sampai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayatBarcode as $i => $rb)
                            <tr>
                                <td style="color:var(--text4);font-size:12px">{{ $i + 1 }}</td>
                                <td><span class="kode-mono">{{ $rb->kode }}</span></td>
                                <td>{{ $rb->berlaku_mulai?->format('d M Y') ?? '—' }}</td>
                                <td>{{ $rb->berlaku_sampai?->format('d M Y') ?? 'Selamanya' }}</td>
                                <td>
                                    @if($rb->trashed())
                                        <span class="status-badge nonaktif"><span class="status-badge-dot"></span>Dihapus</span>
                                    @elseif($rb->masih_berlaku)
                                        <span class="status-badge berlaku"><span class="status-badge-dot"></span>Berlaku</span>
                                    @elseif(!$rb->is_aktif)
                                        <span class="status-badge nonaktif"><span class="status-badge-dot"></span>Nonaktif</span>
                                    @else
                                        <span class="status-badge kadaluarsa"><span class="status-badge-dot"></span>Kadaluarsa</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

{{-- JsBarcode --}}
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script>
    @if($barcodeGerbang)
    JsBarcode("#barcodeGerbang", "{{ $barcodeGerbang->kode }}", {
        format:      "CODE128",
        width:       2,
        height:      72,
        displayValue: false,
        margin:      0,
        lineColor:   "#0f172a",
        background:  "#ffffff",
    });
    @endif
</script>
</x-app-layout>