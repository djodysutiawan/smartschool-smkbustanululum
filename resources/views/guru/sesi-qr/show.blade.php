<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-600:#1f63db;--brand-500:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#15803d;--green-bg:#dcfce7;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --yellow:#a16207;--yellow-bg:#fefce8;--yellow-border:#fde68a;
        --purple:#7c3aed;--purple-bg:#faf5ff;--purple-border:#e9d5ff;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    .page{padding:28px 28px 48px;font-family:'DM Sans',sans-serif}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--text3);margin-bottom:20px;flex-wrap:wrap}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand-600)}
    .breadcrumb-sep{color:var(--border)}

    /* Hero card */
    .hero{background:linear-gradient(135deg,#1750c0 0%,#1f63db 60%,#3582f0 100%);border-radius:var(--radius);padding:28px 28px 0;margin-bottom:20px;overflow:hidden;position:relative}
    .hero::before{content:'';position:absolute;right:-40px;top:-40px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,.06)}
    .hero::after{content:'';position:absolute;right:60px;bottom:-30px;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.04)}
    .hero-top{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:20px}
    .hero-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .hero-badge.aktif{background:rgba(34,197,94,.2);color:#86efac;border:1px solid rgba(34,197,94,.3)}
    .hero-badge.expired{background:rgba(239,68,68,.2);color:#fca5a5;border:1px solid rgba(239,68,68,.3)}
    .hero-badge-dot{width:5px;height:5px;border-radius:50%;background:currentColor}
    .hero-actions{display:flex;gap:8px;flex-wrap:wrap}
    .hero-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:#fff;line-height:1.2;margin-bottom:4px}
    .hero-mapel{font-size:14px;color:rgba(255,255,255,.7)}
    .hero-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:0;border-top:1px solid rgba(255,255,255,.12);margin:0 -28px}
    .hero-stat{padding:16px 20px;border-right:1px solid rgba(255,255,255,.12)}
    .hero-stat:last-child{border-right:none}
    .hero-stat-label{font-size:10.5px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.05em;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;margin-bottom:4px}
    .hero-stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:#fff}
    .hero-stat-sub{font-size:11px;color:rgba(255,255,255,.5);margin-top:2px}

    /* Btn */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-white{background:#fff;color:var(--brand-600)}
    .btn-white-outline{background:transparent;color:#fff;border:1px solid rgba(255,255,255,.35)}
    .btn-white-outline:hover{background:rgba(255,255,255,.1);filter:none}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-nonaktif{background:var(--yellow-bg);color:var(--yellow);border:1px solid var(--yellow-border)}
    .btn-nonaktif:hover{background:#fef9c3;filter:none}
    .btn-del{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}
    .btn-del:hover{background:#fecaca;filter:none}
    .btn-print{background:var(--purple-bg);color:var(--purple);border:1px solid var(--purple-border)}
    .btn-print:hover{background:#ede9fe;filter:none}
    .btn-tayangkan{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}
    .btn-tayangkan:hover{background:#bbf7d0;filter:none}

    /* Layout 2 col */
    .layout{display:grid;grid-template-columns:1fr 320px;gap:16px;align-items:start}
    
    /* Card */
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card:last-child{margin-bottom:0}
    .card-header{padding:14px 18px;border-bottom:1px solid var(--surface3);display:flex;align-items:center;justify-content:space-between;gap:10px}
    .card-header-left{display:flex;align-items:center;gap:10px}
    .card-icon{width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .card-sub{font-size:11.5px;color:var(--text3);margin-top:1px}
    .card-body{padding:18px}

    /* Info grid */
    .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .info-item{}
    .info-item-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:5px}
    .info-item-val{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);font-weight:500}
    .info-item-val.mono{font-family:monospace;font-size:12px;background:var(--surface2);padding:4px 8px;border-radius:5px;display:inline-block;border:1px solid var(--border)}
    .info-divider{grid-column:1/-1;height:1px;background:var(--surface3)}

    /* Progress */
    .progress-wrap{padding:14px 18px;border-top:1px solid var(--surface3)}
    .progress-label{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px}
    .progress-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .progress-pct{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--brand-600)}
    .progress-track{height:8px;background:var(--surface3);border-radius:99px;overflow:hidden}
    .progress-fill{height:100%;border-radius:99px;background:linear-gradient(90deg,var(--brand-500),#22c55e);transition:width .6s cubic-bezier(.4,0,.2,1)}
    .progress-sub{font-size:11px;color:var(--text3);margin-top:6px;font-family:'DM Sans',sans-serif}

    /* Table */
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-family:'DM Sans',sans-serif;font-size:13px}
    th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;background:var(--surface2);border-bottom:1px solid var(--border)}
    td{padding:11px 14px;color:var(--text2);border-bottom:1px solid var(--surface3)}
    tr:last-child td{border-bottom:none}
    tr:hover td{background:var(--surface2)}
    .td-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text);font-size:13px}
    .td-nis{font-size:11.5px;color:var(--text3);margin-top:1px}

    /* Status badges in table */
    .s-badge{display:inline-flex;align-items:center;gap:3px;padding:2px 9px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700}
    .s-valid{background:var(--green-bg);color:var(--green)}
    .s-invalid{background:var(--red-bg);color:var(--red)}

    /* Alert */
    .alert{padding:11px 14px;border-radius:var(--radius-sm);margin-bottom:14px;font-size:13px;font-family:'DM Sans',sans-serif;display:flex;align-items:center;gap:8px}
    .alert-success{background:#f0fdf4;border:1px solid var(--green-border);color:#166534}
    .alert-error{background:var(--red-bg);border:1px solid var(--red-border);color:#991b1b}

    /* Empty */
    .table-empty{padding:40px 20px;text-align:center}
    .table-empty p{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text3)}
    .table-empty small{font-size:12px;color:var(--text3)}

    @media(max-width:768px){
        .page{padding:16px}
        .layout{grid-template-columns:1fr}
        .hero-stats{grid-template-columns:repeat(2,1fr)}
        .hero-stat:nth-child(2){border-right:none}
        .hero-stat:nth-child(3){border-right:1px solid rgba(255,255,255,.12)}
        .info-grid{grid-template-columns:1fr}
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('guru.sesi-qr.index') }}">Sesi QR</a>
        <span class="breadcrumb-sep">/</span>
        <span>Detail Sesi</span>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Hero --}}
    @php
        $isExpired = $sesiQr->isKadaluarsa() || !$sesiQr->is_active;
        $totalSiswaKelas = $sesiQr->kelas?->siswa()->count() ?? 0;
        $validScans = $sesiQr->riwayatScan->where('status','valid');
        $allScans = $sesiQr->riwayatScan;
        $pct = $totalSiswaKelas > 0 ? round(($sudahScan / $totalSiswaKelas) * 100) : 0;
        $durasiMenit = \Carbon\Carbon::parse($sesiQr->berlaku_mulai)->diffInMinutes($sesiQr->kadaluarsa_pada);
    @endphp
    <div class="hero">
        <div class="hero-top">
            <div>
                <span class="hero-badge {{ $isExpired ? 'expired' : 'aktif' }}">
                    <span class="hero-badge-dot"></span>
                    {{ $isExpired ? 'Kedaluwarsa' : 'Aktif' }}
                </span>
                <h1 class="hero-title" style="margin-top:8px">{{ $sesiQr->kelas->nama_kelas ?? '—' }}</h1>
                <p class="hero-mapel">{{ $sesiQr->mataPelajaran->nama_mapel ?? 'Semua Mata Pelajaran' }}</p>
            </div>
            <div class="hero-actions">
                @if(!$isExpired)
                <a href="{{ route('guru.barcode-kelas.show-sesi', $sesiQr) }}" class="btn btn-white">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Tayangkan QR
                </a>
                <form action="{{ route('guru.sesi-qr.nonaktifkan', $sesiQr) }}" method="POST" style="display:inline">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-white-outline" onclick="return confirm('Nonaktifkan sesi QR ini sekarang?')">Nonaktifkan</button>
                </form>
                @endif
                <a href="{{ route('guru.sesi-qr.cetak-qr', $sesiQr) }}" target="_blank" class="btn btn-white-outline">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Cetak QR
                </a>
            </div>
        </div>
        <div class="hero-stats">
            <div class="hero-stat">
                <p class="hero-stat-label">Scan Valid</p>
                <p class="hero-stat-val">{{ $sudahScan }}</p>
                <p class="hero-stat-sub">dari {{ $totalSiswa }} siswa</p>
            </div>
            <div class="hero-stat">
                <p class="hero-stat-label">Kehadiran</p>
                <p class="hero-stat-val">{{ $pct }}%</p>
                <p class="hero-stat-sub">persentase</p>
            </div>
            <div class="hero-stat">
                <p class="hero-stat-label">Durasi</p>
                <p class="hero-stat-val">{{ $durasiMenit }}'</p>
                <p class="hero-stat-sub">menit</p>
            </div>
            <div class="hero-stat">
                <p class="hero-stat-label">Total Scan</p>
                <p class="hero-stat-val">{{ $allScans->count() }}</p>
                <p class="hero-stat-sub">semua percobaan</p>
            </div>
        </div>
    </div>

    <div class="layout">
        {{-- Kiri: Riwayat Scan --}}
        <div>
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-icon" style="background:var(--green-bg)">
                            <svg width="15" height="15" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <div>
                            <p class="card-title">Riwayat Scan Siswa</p>
                            <p class="card-sub">{{ $sudahScan }} scan valid dari {{ $totalSiswa }} siswa</p>
                        </div>
                    </div>
                </div>

                {{-- Progress --}}
                <div class="progress-wrap">
                    <div class="progress-label">
                        <span class="progress-title">Tingkat Kehadiran</span>
                        <span class="progress-pct">{{ $pct }}%</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width:{{ $pct }}%"></div>
                    </div>
                    <p class="progress-sub">{{ $sudahScan }} hadir · {{ $totalSiswa - $sudahScan }} belum scan</p>
                </div>

                <div class="table-wrap">
                    @php $riwayat = $sesiQr->riwayatScan->sortByDesc('dipindai_pada'); @endphp
                    @if($riwayat->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Waktu Scan</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayat as $r)
                            <tr>
                                <td>
                                    <p class="td-name">{{ $r->siswa->nama_lengkap ?? '—' }}</p>
                                    <p class="td-nis">{{ $r->siswa->nis ?? '—' }}</p>
                                </td>
                                <td style="white-space:nowrap;font-size:13px">
                                    {{ optional($r->dipindai_pada)->format('H:i:s') ?? '—' }}
                                </td>
                                <td>
                                    <span class="s-badge {{ $r->status === 'valid' ? 's-valid' : 's-invalid' }}">
                                        {{ $r->status === 'valid' ? 'Valid' : ucfirst($r->status) }}
                                    </span>
                                </td>
                                <td style="font-size:12px;color:var(--text3)">{{ $r->keterangan ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="table-empty">
                        <p>Belum ada siswa yang scan</p>
                        <small>Tayangkan QR ke siswa agar mereka bisa scan</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kanan: Info & Aksi --}}
        <div>
            {{-- Info Sesi --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-icon" style="background:#eff6ff">
                            <svg width="15" height="15" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="13"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        </div>
                        <p class="card-title">Informasi Sesi</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <p class="info-item-label">Tanggal</p>
                            <p class="info-item-val">{{ \Carbon\Carbon::parse($sesiQr->tanggal)->translatedFormat('d M Y') }}</p>
                        </div>
                        <div class="info-item">
                            <p class="info-item-label">Hari</p>
                            <p class="info-item-val">{{ ucfirst($sesiQr->jadwalPelajaran->hari ?? '—') }}</p>
                        </div>
                        <div class="info-divider"></div>
                        <div class="info-item">
                            <p class="info-item-label">Mulai</p>
                            <p class="info-item-val">{{ \Carbon\Carbon::parse($sesiQr->berlaku_mulai)->format('H:i') }}</p>
                        </div>
                        <div class="info-item">
                            <p class="info-item-label">Berakhir</p>
                            <p class="info-item-val">{{ \Carbon\Carbon::parse($sesiQr->kadaluarsa_pada)->format('H:i') }}</p>
                        </div>
                        <div class="info-divider"></div>
                        <div class="info-item">
                            <p class="info-item-label">Ruang</p>
                            <p class="info-item-val">{{ $sesiQr->jadwalPelajaran->ruang->nama_ruang ?? '—' }}</p>
                        </div>
                        <div class="info-item">
                            <p class="info-item-label">Radius</p>
                            <p class="info-item-val">{{ $sesiQr->radius_meter ? $sesiQr->radius_meter.' m' : 'Nonaktif' }}</p>
                        </div>
                        @if($sesiQr->latitude && $sesiQr->longitude)
                        <div class="info-divider"></div>
                        <div class="info-item" style="grid-column:1/-1">
                            <p class="info-item-label">Koordinat GPS</p>
                            <p class="info-item-val mono">{{ $sesiQr->latitude }}, {{ $sesiQr->longitude }}</p>
                        </div>
                        @endif
                        <div class="info-divider"></div>
                        <div class="info-item" style="grid-column:1/-1">
                            <p class="info-item-label">Kode QR</p>
                            <p class="info-item-val mono" style="word-break:break-all">{{ $sesiQr->kode_qr ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Aksi --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-icon" style="background:var(--surface2)">
                            <svg width="15" height="15" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                        </div>
                        <p class="card-title">Aksi</p>
                    </div>
                </div>
                <div class="card-body" style="display:flex;flex-direction:column;gap:8px">
                    @if(!$isExpired)
                    <a href="{{ route('guru.barcode-kelas.show-sesi', $sesiQr) }}" class="btn" style="background:var(--brand-600);color:#fff;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Tayangkan QR ke Siswa
                    </a>
                    @endif
                    <a href="{{ route('guru.sesi-qr.cetak-qr', $sesiQr) }}" target="_blank" class="btn btn-print" style="justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                        Cetak QR (PDF)
                    </a>
                    @if(!$isExpired)
                    <form action="{{ route('guru.sesi-qr.nonaktifkan', $sesiQr) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-nonaktif" style="width:100%;justify-content:center"
                            onclick="return confirm('Nonaktifkan sesi ini sekarang?')">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                            Nonaktifkan Sesi
                        </button>
                    </form>
                    @endif
                    <form action="{{ route('guru.sesi-qr.destroy', $sesiQr) }}" method="POST" id="delForm">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-del" style="width:100%;justify-content:center" onclick="confirmDel()">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            Hapus Sesi
                        </button>
                    </form>
                    <a href="{{ route('guru.sesi-qr.index') }}" class="btn btn-secondary" style="justify-content:center">
                        ← Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDel() {
    @php $isAktif = !$sesiQr->isKadaluarsa() && $sesiQr->is_active; @endphp
    @if($isAktif)
    Swal.fire({ icon: 'error', title: 'Tidak bisa dihapus', text: 'Nonaktifkan sesi terlebih dahulu sebelum menghapus.', confirmButtonColor: '#1f63db' });
    @else
    Swal.fire({
        title: 'Hapus Sesi QR?',
        html: 'Sesi ini beserta seluruh riwayat scan akan dihapus permanen.',
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) document.getElementById('delForm').submit(); });
    @endif
}
</script>
</x-app-layout>