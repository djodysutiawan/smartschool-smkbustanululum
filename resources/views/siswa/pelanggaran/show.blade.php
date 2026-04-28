<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 48px;max-width:2000px}
    .breadcrumb{display:flex;align-items:center;gap:6px;margin-bottom:20px;flex-wrap:wrap}
    .breadcrumb a{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--brand-600);text-decoration:none}
    .breadcrumb a:hover{text-decoration:underline}
    .breadcrumb-sep{color:var(--text3);font-size:12px}
    .breadcrumb-cur{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3)}

    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:20px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;white-space:nowrap}
    .badge-dot{width:6px;height:6px;border-radius:50%;flex-shrink:0}
    .badge-pending  {background:#fef9c3;color:#a16207}   .badge-pending  .badge-dot{background:#a16207}
    .badge-diproses {background:#eff6ff;color:#1d4ed8}   .badge-diproses .badge-dot{background:#1d4ed8}
    .badge-selesai  {background:#dcfce7;color:#15803d}   .badge-selesai  .badge-dot{background:#15803d}
    .badge-banding  {background:#fdf4ff;color:#7c3aed}   .badge-banding  .badge-dot{background:#7c3aed}

    .poin-big{display:inline-flex;align-items:center;justify-content:center;width:52px;height:52px;border-radius:12px;font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800}
    .poin-low  {background:#dcfce7;color:#15803d}
    .poin-mid  {background:#fef9c3;color:#a16207}
    .poin-high {background:#fee2e2;color:#dc2626}

    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card-header{padding:13px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .card-body{padding:20px}

    .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:0}
    .detail-item{padding:12px 0;border-bottom:1px solid var(--border)}
    .detail-item:nth-last-child(-n+2){border-bottom:none}
    .detail-item.col-span-2{grid-column:span 2}
    .detail-item.col-span-2:last-child{border-bottom:none}
    .detail-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:5px}
    .detail-value{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);font-weight:500}
    .detail-value.bold{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700}
    .detail-value.muted{color:var(--text3);font-style:italic}

    /* Poin akumulasi bar */
    .poin-acc-wrap{padding:14px 20px;background:var(--surface2);border-top:1px solid var(--border)}
    .poin-acc-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:6px}
    .poin-acc-row{display:flex;align-items:center;gap:10px}
    .poin-bar-track{flex:1;height:8px;background:var(--border);border-radius:99px;overflow:hidden}
    .poin-bar-fill{height:100%;border-radius:99px;transition:width .6s cubic-bezier(.4,0,.2,1)}
    .poin-acc-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;min-width:70px;text-align:right}

    /* Catatan tindakan box */
    .tindakan-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px;font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text2);line-height:1.65;white-space:pre-line}

    /* Timeline */
    .timeline{padding:4px 0}
    .tl-item{display:flex;gap:12px;padding:10px 0;position:relative}
    .tl-item:not(:last-child)::after{content:'';position:absolute;left:15px;top:34px;bottom:-10px;width:1px;background:var(--border)}
    .tl-dot{width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid var(--border)}
    .tl-dot.blue  {background:#eff6ff;border-color:#bfdbfe}
    .tl-dot.yellow{background:#fefce8;border-color:#fde68a}
    .tl-dot.green {background:#dcfce7;border-color:#bbf7d0}
    .tl-dot.purple{background:#fdf4ff;border-color:#e9d5ff}
    .tl-content{flex:1;padding-top:4px}
    .tl-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .tl-time{font-size:11.5px;color:var(--text3);margin-top:1px}
    .tl-desc{font-size:12.5px;color:var(--text2);margin-top:4px;padding:8px 10px;background:var(--surface2);border-radius:6px;border:1px solid var(--border)}

    @media(max-width:640px){
        .page{padding:16px}
        .detail-grid{grid-template-columns:1fr}
        .detail-item.col-span-2{grid-column:span 1}
        .detail-item:nth-last-child(-n+2){border-bottom:1px solid var(--border)}
        .detail-item:last-child{border-bottom:none}
    }
</style>

<div class="page">

    <div class="breadcrumb">
        <a href="{{ route('siswa.pelanggaran.index') }}">Kedisiplinan Saya</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-cur">Detail #{{ $pelanggaran->id }}</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Pelanggaran</h1>
            <p class="page-sub">
                Kejadian pada {{ \Carbon\Carbon::parse($pelanggaran->tanggal)->translatedFormat('l, d F Y') }}
            </p>
        </div>
        <a href="{{ route('siswa.pelanggaran.index') }}" class="btn btn-secondary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- ── Akumulasi poin siswa ── --}}
    @php
        $maxPoin   = 100;
        $poinPct   = min(100, ($totalPoinSiswa / $maxPoin) * 100);
        $poinColor = $totalPoinSiswa <= 30 ? '#15803d' : ($totalPoinSiswa <= 60 ? '#a16207' : '#dc2626');
    @endphp
    <div class="card">
        <div class="card-header">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
            <span class="card-title">Akumulasi Poin Saya Tahun {{ now()->year }}</span>
        </div>
        <div class="poin-acc-wrap">
            <p class="poin-acc-label">Total poin pelanggaran aktif</p>
            <div class="poin-acc-row">
                <div class="poin-bar-track">
                    <div class="poin-bar-fill" style="width:{{ $poinPct }}%;background:{{ $poinColor }}"></div>
                </div>
                <span class="poin-acc-val" style="color:{{ $poinColor }}">{{ $totalPoinSiswa }} poin</span>
            </div>
        </div>
    </div>

    {{-- ── Detail pelanggaran ── --}}
    <div class="card">
        <div class="card-header">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                <rect x="9" y="3" width="6" height="4" rx="1"/>
            </svg>
            <span class="card-title">Informasi Pelanggaran</span>
            <div style="margin-left:auto">
                <span class="badge badge-{{ $pelanggaran->status }}">
                    <span class="badge-dot"></span>
                    {{ ucfirst($pelanggaran->status) }}
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="detail-grid">

                <div class="detail-item">
                    <p class="detail-label">Kategori</p>
                    <p class="detail-value bold">{{ $pelanggaran->kategori->nama ?? '—' }}</p>
                </div>

                <div class="detail-item">
                    <p class="detail-label">Poin</p>
                    <div style="display:flex;align-items:center;gap:10px;margin-top:2px">
                        @php
                            $pc = $pelanggaran->poin <= 20 ? 'poin-low' : ($pelanggaran->poin <= 50 ? 'poin-mid' : 'poin-high');
                        @endphp
                        <span class="poin-big {{ $pc }}">{{ $pelanggaran->poin }}</span>
                        <span style="font-size:12px;color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600">
                            poin pelanggaran
                        </span>
                    </div>
                </div>

                <div class="detail-item">
                    <p class="detail-label">Tanggal Kejadian</p>
                    <p class="detail-value">
                        {{ \Carbon\Carbon::parse($pelanggaran->tanggal)->translatedFormat('d F Y') }}
                    </p>
                </div>

                <div class="detail-item">
                    <p class="detail-label">Dicatat Oleh</p>
                    <p class="detail-value bold">{{ $pelanggaran->dicatatOleh->name ?? '—' }}</p>
                </div>

                <div class="detail-item col-span-2">
                    <p class="detail-label">Deskripsi Pelanggaran</p>
                    <p class="detail-value" style="line-height:1.6;white-space:pre-line">
                        {{ $pelanggaran->deskripsi ?? '—' }}
                    </p>
                </div>

                @if($pelanggaran->tindakan)
                <div class="detail-item col-span-2" style="border-bottom:none">
                    <p class="detail-label">Tindakan yang Diambil</p>
                    <div class="tindakan-box">{{ $pelanggaran->tindakan }}</div>
                </div>
                @endif

            </div>
        </div>
    </div>

    {{-- ── Timeline status ── --}}
    <div class="card">
        <div class="card-header">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                <line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/>
                <line x1="6" y1="20" x2="6" y2="16"/>
            </svg>
            <span class="card-title">Riwayat Status</span>
        </div>
        <div class="card-body">
            <div class="timeline">

                <div class="tl-item">
                    <div class="tl-dot blue">
                        <svg width="13" height="13" fill="none" stroke="#1d4ed8" stroke-width="2.5" viewBox="0 0 24 24">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                    </div>
                    <div class="tl-content">
                        <p class="tl-title">Pelanggaran Dicatat</p>
                        <p class="tl-time">
                            {{ \Carbon\Carbon::parse($pelanggaran->created_at)->translatedFormat('d F Y, H:i') }}
                            &middot; oleh <strong>{{ $pelanggaran->dicatatOleh->name ?? '—' }}</strong>
                        </p>
                    </div>
                </div>

                @if(in_array($pelanggaran->status, ['diproses', 'selesai', 'banding']))
                <div class="tl-item">
                    <div class="tl-dot yellow">
                        <svg width="13" height="13" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <div class="tl-content">
                        <p class="tl-title">Sedang Diproses</p>
                        <p class="tl-time">Pelanggaran sedang ditindaklanjuti oleh pihak sekolah</p>
                    </div>
                </div>
                @endif

                @if($pelanggaran->status === 'banding')
                <div class="tl-item">
                    <div class="tl-dot purple">
                        <svg width="13" height="13" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <div class="tl-content">
                        <p class="tl-title">Dalam Proses Banding</p>
                        <p class="tl-time">Pelanggaran ini sedang dalam proses banding</p>
                    </div>
                </div>
                @endif

                @if($pelanggaran->status === 'selesai')
                <div class="tl-item">
                    <div class="tl-dot green">
                        <svg width="13" height="13" fill="none" stroke="#15803d" stroke-width="2.5" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <div class="tl-content">
                        <p class="tl-title">Pelanggaran Diselesaikan</p>
                        <p class="tl-time">
                            {{ \Carbon\Carbon::parse($pelanggaran->updated_at)->translatedFormat('d F Y, H:i') }}
                        </p>
                        @if($pelanggaran->tindakan)
                            <div class="tl-desc">{{ $pelanggaran->tindakan }}</div>
                        @endif
                    </div>
                </div>
                @endif

                @if($pelanggaran->status === 'pending')
                <div class="tl-item">
                    <div class="tl-dot yellow">
                        <svg width="13" height="13" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <div class="tl-content">
                        <p class="tl-title" style="color:var(--text3)">Menunggu tindak lanjut…</p>
                        <p class="tl-time">Pihak sekolah akan segera menindaklanjuti pelanggaran ini</p>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

</div>
</x-app-layout>