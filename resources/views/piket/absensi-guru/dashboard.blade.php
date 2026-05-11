<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#15803d;--yellow:#a16207;--blue:#1d4ed8;--purple:#7c3aed;--red:#dc2626;--orange:#c2410c;
        --radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 48px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-danger{background:#fff0f0;color:var(--red);border:1px solid #fecaca}
    .btn-danger:hover{background:#fee2e2;filter:none}
    .btn-sm{padding:5px 12px;font-size:12px;border-radius:6px}
    .btn-warning{background:#fefce8;color:var(--yellow);border:1px solid #fde68a}

    /* ── Stats grid ── */
    .stats-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:24px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:18px 16px;text-align:center;transition:box-shadow .2s,transform .15s;position:relative;overflow:hidden}
    .stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px}
    .stat-card.green::before{background:#15803d}
    .stat-card.yellow::before{background:#a16207}
    .stat-card.blue::before{background:#1d4ed8}
    .stat-card.purple::before{background:#7c3aed}
    .stat-card.red::before{background:#dc2626}
    .stat-card:hover{box-shadow:0 6px 20px rgba(0,0,0,.07);transform:translateY(-1px)}
    .stat-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:32px;font-weight:800;color:var(--text);line-height:1}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-top:6px}
    .stat-pct{font-size:12px;color:var(--text3);margin-top:3px}
    .stat-card.green .stat-num{color:var(--green)}
    .stat-card.yellow .stat-num{color:var(--yellow)}
    .stat-card.blue .stat-num{color:var(--blue)}
    .stat-card.purple .stat-num{color:var(--purple)}
    .stat-card.red .stat-num{color:var(--red)}

    /* ── Layout grid ── */
    .content-grid{display:grid;grid-template-columns:1fr 340px;gap:16px;align-items:start}

    /* ── Card ── */
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between;gap:10px}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px}
    .card-body{padding:0}

    /* ── QR sesi banner ── */
    .qr-banner{padding:16px 20px;display:flex;align-items:center;gap:14px;background:linear-gradient(135deg,#eef6ff 0%,#f0fdf4 100%);border-bottom:1px solid var(--border)}
    .qr-banner.inactive{background:var(--surface3)}
    .qr-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0}
    .qr-dot.on{background:#15803d;box-shadow:0 0 0 3px #bbf7d0;animation:pulse 2s infinite}
    .qr-dot.off{background:var(--text3)}
    @keyframes pulse{0%,100%{box-shadow:0 0 0 3px #bbf7d0}50%{box-shadow:0 0 0 6px #bbf7d080}}
    .qr-info{flex:1}
    .qr-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .qr-sub{font-size:12px;color:var(--text3);margin-top:2px}

    /* ── Table ── */
    table{width:100%;border-collapse:collapse}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;vertical-align:middle}
    td.center{text-align:center}
    .name-col{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}
    .sub-col{font-size:11.5px;color:var(--text3);margin-top:1px}
    .time-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);white-space:nowrap}

    /* ── Badge ── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-hadir {background:#dcfce7;color:var(--green)} .badge-hadir  .badge-dot{background:var(--green)}
    .badge-telat {background:#fefce8;color:var(--yellow)} .badge-telat  .badge-dot{background:var(--yellow)}
    .badge-izin  {background:#eff6ff;color:var(--blue)}  .badge-izin   .badge-dot{background:#3b82f6}
    .badge-sakit {background:#fdf4ff;color:var(--purple)} .badge-sakit  .badge-dot{background:#a855f7}
    .badge-alfa  {background:#fee2e2;color:var(--red)}   .badge-alfa   .badge-dot{background:var(--red)}
    .badge-cuti  {background:#fff7ed;color:var(--orange)} .badge-cuti   .badge-dot{background:#ea580c}
    .badge-dinas_luar{background:#f0fdf4;color:#065f46}   .badge-dinas_luar .badge-dot{background:#059669}
    .badge-qr    {background:#ecfdf5;color:#065f46}
    .badge-manual{background:var(--surface3);color:var(--text2)}
    .badge-piket {background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}

    /* ── Belum hadir list ── */
    .belum-item{display:flex;align-items:center;gap:10px;padding:10px 20px;border-bottom:1px solid #f1f5f9;transition:background .1s}
    .belum-item:last-child{border-bottom:none}
    .belum-item:hover{background:#fafbff}
    .belum-avatar{width:32px;height:32px;border-radius:99px;background:var(--surface3);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;color:var(--text2);flex-shrink:0}
    .belum-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .belum-nip{font-size:11.5px;color:var(--text3)}

    /* ── Piket jadwal ── */
    .piket-item{display:flex;align-items:center;gap:10px;padding:12px 20px;border-bottom:1px solid #f1f5f9}
    .piket-item:last-child{border-bottom:none}
    .piket-badge{display:inline-flex;padding:2px 8px;border-radius:4px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}

    /* ── Empty state ── */
    .empty-state{padding:40px 20px;text-align:center}
    .empty-icon{width:48px;height:48px;background:var(--surface2);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--text);margin-bottom:4px}
    .empty-sub{font-size:12.5px;color:var(--text3)}

    /* ── Progress bar ── */
    .progress-wrap{background:var(--surface3);border-radius:99px;height:6px;overflow:hidden;margin-top:4px}
    .progress-bar{height:100%;border-radius:99px;background:var(--brand-600);transition:width .3s}

    @media(max-width:1100px){.content-grid{grid-template-columns:1fr}}
    @media(max-width:768px){.stats-grid{grid-template-columns:repeat(3,1fr)}}
    @media(max-width:540px){.stats-grid{grid-template-columns:repeat(2,1fr)}.page{padding:16px}}
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard Absensi Guru</h1>
            <p class="page-sub">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }} · Pantau kehadiran guru hari ini</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('piket.absensi-guru.export-pdf', ['tanggal' => today()->toDateString()]) }}"
               class="btn btn-secondary" target="_blank">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export PDF
            </a>
            <a href="{{ route('piket.absensi-guru.massal.form') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Catat Absensi
            </a>
        </div>
    </div>

    {{-- Stats --}}
    @php
        $pctHadir = $totalGuru > 0 ? round($rekapHariIni['hadir'] / $totalGuru * 100) : 0;
    @endphp
    <div class="stats-grid">
        <div class="stat-card green">
            <p class="stat-num">{{ $rekapHariIni['hadir'] }}</p>
            <p class="stat-label">Hadir</p>
            <p class="stat-pct">dari {{ $totalGuru }} guru</p>
        </div>
        <div class="stat-card yellow">
            <p class="stat-num">{{ $rekapHariIni['telat'] }}</p>
            <p class="stat-label">Telat</p>
            <p class="stat-pct">termasuk hadir</p>
        </div>
        <div class="stat-card blue">
            <p class="stat-num">{{ $rekapHariIni['izin'] }}</p>
            <p class="stat-label">Izin</p>
            <p class="stat-pct">&nbsp;</p>
        </div>
        <div class="stat-card purple">
            <p class="stat-num">{{ $rekapHariIni['sakit'] }}</p>
            <p class="stat-label">Sakit</p>
            <p class="stat-pct">&nbsp;</p>
        </div>
        <div class="stat-card red">
            <p class="stat-num">{{ $rekapHariIni['alfa'] }}</p>
            <p class="stat-label">Alfa</p>
            <p class="stat-pct">&nbsp;</p>
        </div>
    </div>

    {{-- Progress kehadiran ── --}}
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:20px;display:flex;align-items:center;gap:16px;flex-wrap:wrap">
        <div style="flex:1;min-width:200px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px">
                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)">Tingkat Kehadiran Hari Ini</span>
                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:800;color:{{ $pctHadir >= 80 ? 'var(--green)' : ($pctHadir >= 60 ? 'var(--yellow)' : 'var(--red)') }}">{{ $pctHadir }}%</span>
            </div>
            <div class="progress-wrap">
                <div class="progress-bar" style="width:{{ $pctHadir }}%;background:{{ $pctHadir >= 80 ? '#15803d' : ($pctHadir >= 60 ? '#a16207' : '#dc2626') }}"></div>
            </div>
        </div>
        <div style="display:flex;gap:16px;flex-shrink:0;flex-wrap:wrap">
            <div style="text-align:center">
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--text)">{{ $absensiHariIni->count() }}</p>
                <p style="font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em">Sudah Tercatat</p>
            </div>
            <div style="text-align:center">
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--red)">{{ $guruBelumAbsen->count() }}</p>
                <p style="font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em">Belum Tercatat</p>
            </div>
            <div style="text-align:center">
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--text)">{{ $totalGuru }}</p>
                <p style="font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em">Total Guru</p>
            </div>
        </div>
    </div>

    {{-- Sesi QR Banner --}}
    <div class="card" style="margin-bottom:20px">
        <div class="qr-banner {{ $sesiQrAktif ? '' : 'inactive' }}">
            <span class="qr-dot {{ $sesiQrAktif ? 'on' : 'off' }}"></span>
            <div class="qr-info">
                @if($sesiQrAktif)
                    <p class="qr-title">Sesi QR Guru Sedang Aktif</p>
                    <p class="qr-sub">
                        Berlaku hingga {{ $sesiQrAktif->kadaluarsa_pada ? \Carbon\Carbon::parse($sesiQrAktif->kadaluarsa_pada)->format('H:i') : '—' }}
                        · {{ $sesiQrAktif->jumlah_scan ?? 0 }} guru sudah scan
                    </p>
                @else
                    <p class="qr-title" style="color:var(--text2)">Tidak Ada Sesi QR Aktif</p>
                    <p class="qr-sub">Buka sesi QR agar guru bisa melakukan absensi mandiri</p>
                @endif
            </div>
            @if($sesiQrAktif)
                <a href="{{ route('piket.sesi-qr-guru.index') }}" class="btn btn-sm btn-secondary">Kelola QR</a>
            @else
                <a href="{{ route('piket.sesi-qr-guru.index') }}" class="btn btn-sm btn-primary">Buka Sesi QR</a>
            @endif
        </div>
    </div>

    <div class="content-grid">

        {{-- Kiri: Absensi hari ini + Belum absen --}}
        <div>
            {{-- Tabel absensi hari ini --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Absensi Tercatat Hari Ini
                        <span style="background:var(--surface3);color:var(--text3);font-size:11px;padding:2px 8px;border-radius:99px;font-weight:700">{{ $absensiHariIni->count() }}</span>
                    </span>
                    <a href="{{ route('piket.absensi-guru.riwayat') }}" class="btn btn-sm btn-secondary" style="font-size:11.5px">Lihat Semua</a>
                </div>
                <div class="card-body" style="overflow-x:auto">
                    @if($absensiHariIni->count())
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Guru</th>
                                <th class="center">Status</th>
                                <th>Jam Masuk</th>
                                <th>Metode</th>
                                <th>Pencatat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absensiHariIni as $i => $a)
                            <tr>
                                <td style="font-size:12px;color:var(--text3);font-weight:700">{{ $i + 1 }}</td>
                                <td>
                                    <p class="name-col">{{ $a->guru->nama_lengkap ?? '—' }}</p>
                                    <p class="sub-col">{{ $a->guru->nip ?? 'NIP tidak ada' }}</p>
                                </td>
                                <td class="center">
                                    <span class="badge badge-{{ $a->status }}">
                                        <span class="badge-dot"></span>{{ ucfirst($a->status) }}
                                    </span>
                                </td>
                                <td class="time-col">{{ $a->jam_masuk ? \Carbon\Carbon::parse($a->jam_masuk)->format('H:i') : '—' }}</td>
                                <td>
                                    @if($a->metode === 'qr')
                                        <span class="badge badge-qr"><span class="badge-dot"></span>QR</span>
                                    @else
                                        <span class="badge badge-manual"><span class="badge-dot"></span>Manual</span>
                                    @endif
                                </td>
                                <td style="font-size:12px;color:var(--text3)">{{ $a->pencatat->name ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </div>
                        <p class="empty-title">Belum ada absensi tercatat</p>
                        <p class="empty-sub">Guru belum ada yang absen hari ini</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kanan: Belum absen + Guru piket --}}
        <div>
            {{-- Guru belum absen --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Belum Tercatat
                        @if($guruBelumAbsen->count())
                        <span style="background:#fee2e2;color:#dc2626;font-size:11px;padding:2px 8px;border-radius:99px;font-weight:700">{{ $guruBelumAbsen->count() }}</span>
                        @endif
                    </span>
                    <a href="{{ route('piket.absensi-guru.massal.form') }}" class="btn btn-sm btn-primary" style="font-size:11.5px">Catat</a>
                </div>
                <div class="card-body" style="max-height:320px;overflow-y:auto">
                    @forelse($guruBelumAbsen as $g)
                    <div class="belum-item">
                        <div class="belum-avatar">{{ strtoupper(substr($g->nama_lengkap, 0, 1)) }}</div>
                        <div style="flex:1;min-width:0">
                            <p class="belum-name" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $g->nama_lengkap }}</p>
                            <p class="belum-nip">{{ $g->nip ?: 'NIP—' }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state" style="padding:28px 20px">
                        <div class="empty-icon" style="background:#f0fdf4">
                            <svg width="22" height="22" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <p class="empty-title" style="color:#15803d">Semua guru sudah tercatat!</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Guru piket hari ini --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Piket Hari Ini
                    </span>
                </div>
                <div class="card-body">
                    @forelse($guruPiketHariIni as $p)
                    <div class="piket-item">
                        <div class="belum-avatar" style="background:var(--brand-50);color:var(--brand-700)">
                            {{ strtoupper(substr($p->guru->nama_lengkap ?? 'P', 0, 1)) }}
                        </div>
                        <div style="flex:1;min-width:0">
                            <p class="belum-name" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                                {{ $p->guru->nama_lengkap ?? '—' }}
                            </p>
                            <p class="belum-nip">
                                {{ $p->jam_mulai ? \Carbon\Carbon::parse($p->jam_mulai)->format('H:i') : '' }}
                                @if($p->jam_selesai)–{{ \Carbon\Carbon::parse($p->jam_selesai)->format('H:i') }}@endif
                            </p>
                        </div>
                        <span class="piket-badge">Piket</span>
                    </div>
                    @empty
                    <div class="empty-state" style="padding:24px 20px">
                        <p class="empty-sub">Tidak ada jadwal piket hari ini</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:3000,showConfirmButton:false,toast:true,position:'top-end'});
@endif
@if(session('error'))
Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
@endif
@if(session('warning'))
Swal.fire({icon:'warning',title:'Perhatian!',text:@json(session('warning')),confirmButtonColor:'#1f63db'});
@endif
</script>
</x-app-layout>