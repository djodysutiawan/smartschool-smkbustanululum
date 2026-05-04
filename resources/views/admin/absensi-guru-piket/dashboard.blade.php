<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand);color:#fff}
    .btn-green{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}.btn-green:hover{background:#dcfce7;filter:none}
    .btn-purple{background:#faf5ff;color:#6d28d9;border:1px solid #e9d5ff}.btn-purple:hover{background:#f3e8ff;filter:none}
    .btn-outline{background:var(--surface);color:var(--text2);border:1px solid var(--border)}.btn-outline:hover{background:var(--surface2);filter:none}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px}
    .stats-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.green{background:#f0fdf4}.stat-icon.yellow{background:#fef9c3}.stat-icon.blue{background:#eff6ff}.stat-icon.red{background:#fff0f0}.stat-icon.gray{background:var(--surface3)}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .grid-layout{display:grid;grid-template-columns:1fr 360px;gap:16px}
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .card-subtitle{font-size:12px;color:var(--text3)}
    .card-body{padding:0}
    .guru-item{display:flex;align-items:center;padding:10px 20px;border-bottom:1px solid #f1f5f9;gap:12px;transition:background .1s}
    .guru-item:last-child{border-bottom:none}
    .guru-item:hover{background:#fafbff}
    .guru-avatar{width:36px;height:36px;border-radius:9px;background:var(--brand-50);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:13px;color:var(--brand-700)}
    .guru-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}
    .guru-nip{font-size:11.5px;color:var(--text3)}
    .guru-status{margin-left:auto;flex-shrink:0}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%}
    .b-hadir{background:#dcfce7;color:#15803d}.b-hadir .badge-dot{background:#15803d}
    .b-telat{background:#fef9c3;color:#a16207}.b-telat .badge-dot{background:#a16207}
    .b-izin{background:#dbeafe;color:#1d4ed8}.b-izin .badge-dot{background:#1d4ed8}
    .b-sakit{background:#f3e8ff;color:#6d28d9}.b-sakit .badge-dot{background:#6d28d9}
    .b-alfa{background:#fee2e2;color:#dc2626}.b-alfa .badge-dot{background:#dc2626}
    .b-belum{background:var(--surface3);color:var(--text3)}.b-belum .badge-dot{background:var(--text3)}
    .action-btn{padding:5px 10px;border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;text-decoration:none;white-space:nowrap;border:none;cursor:pointer;transition:filter .15s}
    .action-btn:hover{filter:brightness(.93)}
    .ab-absen{background:var(--brand);color:#fff}
    .ab-done{background:var(--surface3);color:var(--text3);cursor:not-allowed}
    .sidebar-section{margin-bottom:16px}
    .qr-alert{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px}
    .qr-alert-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--brand-700);margin-bottom:4px}
    .qr-alert-sub{font-size:12.5px;color:var(--brand-700);opacity:.8}
    .piket-list{padding:0}
    .piket-item{padding:10px 20px;border-bottom:1px solid #f1f5f9;font-size:13px;color:var(--text)}
    .piket-item:last-child{border-bottom:none}
    .today-chip{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;background:var(--brand);color:#fff;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700}
    @media(max-width:1024px){.grid-layout{grid-template-columns:1fr}.stats-strip{grid-template-columns:repeat(3,1fr)}.page{padding:16px}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard Piket Guru</h1>
            <p class="page-sub">
                <span class="today-chip">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}
                </span>
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.absensi-guru-piket.massal.form') }}" class="btn btn-green">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Absen Massal
            </a>
            <a href="{{ route('admin.absensi-guru-piket.scan-qr') }}" class="btn btn-purple">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><line x1="14" y1="14" x2="14" y2="14"/><line x1="21" y1="14" x2="21" y2="14"/><line x1="14" y1="21" x2="14" y2="21"/><line x1="21" y1="21" x2="21" y2="21"/></svg>
                Scan QR
            </a>
            <a href="{{ route('admin.absensi-guru-piket.riwayat') }}" class="btn btn-outline">Riwayat</a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon green"><svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
            <div><p class="stat-label">Hadir</p><p class="stat-val">{{ $rekap['hadir'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow"><svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
            <div><p class="stat-label">Izin</p><p class="stat-val">{{ $rekap['izin'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div>
            <div><p class="stat-label">Sakit</p><p class="stat-val">{{ $rekap['sakit'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red"><svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg></div>
            <div><p class="stat-label">Alfa</p><p class="stat-val">{{ $rekap['alfa'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon gray"><svg width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
            <div><p class="stat-label">Belum Absen</p><p class="stat-val">{{ $rekap['belum_absen'] }}</p></div>
        </div>
    </div>

    <div class="grid-layout">
        {{-- Daftar Guru --}}
        <div class="card">
            <div class="card-header">
                <div>
                    <p class="card-title">Daftar Kehadiran Guru</p>
                    <p class="card-subtitle">{{ count($guruList) }} guru aktif terdaftar</p>
                </div>
            </div>
            <div class="card-body">
                @forelse($guruList as $item)
                @php
                    $inisial = collect(explode(' ', $item['guru']->nama_lengkap))->map(fn($w) => strtoupper($w[0]))->take(2)->implode('');
                    $badgeClass = match($item['status']) {
                        'hadir' => 'b-hadir', 'telat' => 'b-telat', 'izin' => 'b-izin',
                        'sakit' => 'b-sakit', 'alfa'  => 'b-alfa', default => 'b-belum'
                    };
                    $badgeLabel = $item['status'] == 'belum' ? 'Belum Absen' : ucfirst($item['status']);
                @endphp
                <div class="guru-item">
                    <div class="guru-avatar">{{ $inisial }}</div>
                    <div>
                        <p class="guru-name">{{ $item['guru']->nama_lengkap }}</p>
                        <p class="guru-nip">{{ $item['guru']->nip ?? 'NIP tidak tersedia' }}</p>
                    </div>
                    <div class="guru-status">
                        <span class="badge {{ $badgeClass }}"><span class="badge-dot"></span>{{ $badgeLabel }}</span>
                    </div>
                    @if(!$item['sudah_absen'])
                    <a href="{{ route('admin.absensi-guru-piket.manual.form', $item['guru']->id) }}" class="action-btn ab-absen">
                        Absen
                    </a>
                    @else
                    <span class="action-btn ab-done">Selesai</span>
                    @endif
                </div>
                @empty
                <div style="padding:40px 20px;text-align:center;color:var(--text3)">Tidak ada guru aktif</div>
                @endforelse
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            @if($sesiQrAktif)
            <div class="qr-alert">
                <p class="qr-alert-title">✅ Sesi QR Aktif</p>
                <p class="qr-alert-sub">Berlaku hingga: {{ \Carbon\Carbon::parse($sesiQrAktif->kadaluarsa_pada)->format('H:i') }} WIB</p>
                <div style="margin-top:10px">
                    <a href="{{ route('admin.absensi-guru-piket.scan-qr') }}" class="btn btn-primary btn-sm">Buka Scanner QR</a>
                </div>
            </div>
            @else
            <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:var(--radius);padding:16px 20px;margin-bottom:16px">
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:#c2410c;margin-bottom:4px">⚠ Tidak Ada Sesi QR</p>
                <p style="font-size:12px;color:#c2410c;opacity:.8">Buat sesi QR untuk mengaktifkan absensi via QR code</p>
                <div style="margin-top:10px">
                    <a href="{{ route('admin.sesi-qr-guru.create') }}" class="btn btn-outline btn-sm">Buat Sesi QR</a>
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <p class="card-title">Guru Piket Hari Ini</p>
                </div>
                <div class="piket-list">
                    @forelse($jadwalPiketHariIni as $jp)
                    <div class="piket-item">
                        <strong>{{ $jp->guru->nama_lengkap ?? '—' }}</strong>
                        <div style="font-size:12px;color:var(--text3);margin-top:2px">
                            {{ ucfirst($jp->hari ?? '—') }}
                        </div>
                    </div>
                    @empty
                    <div class="piket-item" style="color:var(--text3)">Tidak ada jadwal piket hari ini</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});@endif
    @if(session('error'))Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});@endif
    @if(session('info'))Swal.fire({icon:'info',title:'Info',text:@json(session('info')),confirmButtonColor:'#1f63db'});@endif
</script>
</x-app-layout>