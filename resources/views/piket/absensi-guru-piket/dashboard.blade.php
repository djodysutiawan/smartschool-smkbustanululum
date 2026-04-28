<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --pk-900:#0c1f3f;--pk-800:#122a54;--pk-700:#1750c0;--pk-600:#1f63db;
        --pk-500:#3582f0;--pk-400:#60a5fa;--pk-100:#d9ebff;--pk-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    /* ── Layout ── */
    .page{padding:28px 28px 48px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}
    .header-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap}

    /* ── Buttons ── */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap}
    .btn-primary{background:var(--pk-600);color:#fff}
    .btn-primary:hover{background:var(--pk-700)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3)}
    .btn-ghost-scan{background:#ecfdf5;color:#065f46;border:1px solid #bbf7d0}
    .btn-ghost-scan:hover{background:#dcfce7}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}

    /* ── Stats strip ── */
    .stats-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:15px 18px;display:flex;align-items:center;gap:13px;transition:box-shadow .2s,transform .2s}
    .stat-card:hover{box-shadow:0 4px 18px rgba(0,0,0,.07);transform:translateY(-1px)}
    .stat-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .si-slate{background:var(--surface3)}
    .si-green{background:#f0fdf4}
    .si-amber{background:#fffbeb}
    .si-blue{background:#eff6ff}
    .si-red{background:#fff0f0}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;font-weight:800;color:var(--text);line-height:1;margin-top:2px}
    .stat-note{font-size:11px;color:var(--text3);margin-top:2px;font-family:'DM Sans',sans-serif}

    /* ── Progress card ── */
    .progress-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:18px;display:flex;align-items:center;gap:20px}
    .progress-main{flex:1}
    .progress-head{display:flex;justify-content:space-between;align-items:baseline;margin-bottom:7px}
    .progress-head-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
    .progress-head-pct{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--pk-600)}
    .progress-bar{height:9px;background:var(--surface3);border-radius:99px;overflow:hidden}
    .progress-fill{height:100%;background:linear-gradient(90deg,var(--pk-500),var(--pk-600));border-radius:99px;transition:width .8s cubic-bezier(.4,0,.2,1)}
    .progress-foot{font-family:'DM Sans',sans-serif;font-size:11.5px;color:var(--text3);margin-top:5px}
    .progress-action{flex-shrink:0}

    /* ── Two-col grid ── */
    .two-col{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}

    /* ── Cards ── */
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .card-hd{display:flex;align-items:center;justify-content:space-between;padding:13px 18px;border-bottom:1px solid var(--border)}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:7px}
    .pill{display:inline-flex;align-items:center;padding:2px 9px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700}
    .pill-red{background:#fee2e2;color:#dc2626}
    .pill-blue{background:var(--pk-50);color:var(--pk-700)}
    .pill-green{background:#dcfce7;color:#15803d}

    /* ── Guru list (belum absen) ── */
    .guru-scroll{max-height:300px;overflow-y:auto}
    .guru-scroll::-webkit-scrollbar{width:4px}
    .guru-scroll::-webkit-scrollbar-track{background:transparent}
    .guru-scroll::-webkit-scrollbar-thumb{background:var(--border);border-radius:4px}
    .guru-item{display:flex;align-items:center;gap:11px;padding:10px 18px;border-bottom:1px solid #f1f5f9;transition:background .1s}
    .guru-item:last-child{border-bottom:none}
    .guru-item:hover{background:#fafbff}
    .guru-avatar{width:34px;height:34px;border-radius:9px;background:var(--pk-50);border:1px solid var(--pk-100);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:800;color:var(--pk-600);flex-shrink:0;text-transform:uppercase}
    .guru-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .guru-meta{font-size:11.5px;color:var(--text3);margin-top:1px;font-family:'DM Sans',sans-serif}

    /* ── Piket list ── */
    .piket-item{display:flex;align-items:center;gap:11px;padding:11px 18px;border-bottom:1px solid #f1f5f9}
    .piket-item:last-child{border-bottom:none}
    .piket-indicator{width:9px;height:9px;border-radius:50%;background:var(--pk-500);flex-shrink:0;box-shadow:0 0 0 3px var(--pk-50)}

    /* ── Table card (absensi hari ini) ── */
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13px}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;background:var(--surface2);border-bottom:1px solid var(--border);white-space:nowrap}
    thead th.c{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;vertical-align:middle;color:var(--text)}
    td.c{text-align:center}
    td.muted{color:var(--text3);font-family:'DM Sans',sans-serif}
    .two-line .prim{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}
    .two-line .sec{font-size:11.5px;color:var(--text3);margin-top:1px;font-family:'DM Sans',sans-serif}

    /* ── Badges ── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .bd{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .b-hadir{background:#dcfce7;color:#15803d} .b-hadir .bd{background:#15803d}
    .b-telat{background:#fefce8;color:#a16207} .b-telat .bd{background:#a16207}
    .b-izin{background:#eff6ff;color:#1d4ed8} .b-izin .bd{background:#1d4ed8}
    .b-sakit{background:#fdf4ff;color:#7c3aed} .b-sakit .bd{background:#7c3aed}
    .b-alfa{background:#fee2e2;color:#dc2626} .b-alfa .bd{background:#dc2626}
    .b-qr{background:#ecfdf5;color:#065f46} .b-qr .bd{background:#065f46}
    .b-manual{background:var(--surface3);color:var(--text2)} .b-manual .bd{background:var(--text3)}

    /* ── Alert ── */
    .alert{display:flex;align-items:flex-start;gap:10px;padding:11px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600}
    .a-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d}
    .a-warning{background:#fffbeb;border:1px solid #fde68a;color:#92400e}
    .a-error{background:#fff0f0;border:1px solid #fecaca;color:#dc2626}

    /* ── Empty ── */
    .empty{padding:36px 16px;text-align:center}
    .empty p{font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text3)}
    .empty .ok{color:#15803d;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px}

    /* ── No number ── */
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)}

    @media(max-width:900px){.two-col{grid-template-columns:1fr}.stats-strip{grid-template-columns:repeat(3,1fr)}}
    @media(max-width:640px){.page{padding:16px}.stats-strip{grid-template-columns:1fr 1fr}}
</style>

<div class="page">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard Absensi Guru</h1>
            <p class="page-sub">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }} &nbsp;·&nbsp; Pantau kehadiran guru hari ini</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('piket.absensi-guru.massal.form') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Absen Massal
            </a>
            <a href="{{ route('piket.absensi-guru.scan-qr') }}" class="btn btn-ghost-scan">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Scan QR
            </a>
            <a href="{{ route('piket.absensi-guru.riwayat') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
                Riwayat Saya
            </a>
        </div>
    </div>

    {{-- ── Flash alerts ── --}}
    @foreach(['success' => 'a-success','warning' => 'a-warning','error' => 'a-error'] as $type => $cls)
        @if(session($type))
        <div class="alert {{ $cls }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                @if($type === 'success') <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                @else <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                @endif
            </svg>
            {{ session($type) }}
            <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;cursor:pointer;color:inherit;font-size:16px;line-height:1">&times;</button>
        </div>
        @endif
    @endforeach

    {{-- ── Stats ── --}}
    @php $totalAbsen = collect($rekapHariIni)->sum(); @endphp
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon si-slate">
                <svg width="18" height="18" fill="none" stroke="#475569" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Guru</p>
                <p class="stat-val">{{ $totalGuru }}</p>
                <p class="stat-note">guru aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Hadir</p>
                <p class="stat-val">{{ $rekapHariIni['hadir'] }}</p>
                <p class="stat-note">hari ini</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-amber">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Izin</p>
                <p class="stat-val">{{ $rekapHariIni['izin'] }}</p>
                <p class="stat-note">hari ini</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            </div>
            <div>
                <p class="stat-label">Sakit</p>
                <p class="stat-val">{{ $rekapHariIni['sakit'] }}</p>
                <p class="stat-note">hari ini</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div>
                <p class="stat-label">Alfa</p>
                <p class="stat-val">{{ $rekapHariIni['alfa'] }}</p>
                <p class="stat-note">hari ini</p>
            </div>
        </div>
    </div>

    {{-- ── Progress bar ── --}}
    @if($totalGuru > 0)
    @php $pct = round(($rekapHariIni['hadir'] / $totalGuru) * 100); @endphp
    <div class="progress-card">
        <div class="progress-main">
            <div class="progress-head">
                <span class="progress-head-label">Progress Kehadiran Hari Ini</span>
                <span class="progress-head-pct">{{ $pct }}%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" style="width:{{ $pct }}%"></div>
            </div>
            <p class="progress-foot">{{ $rekapHariIni['hadir'] }} dari {{ $totalGuru }} guru telah tercatat hadir · {{ $guruBelumAbsen->count() }} belum tercatat</p>
        </div>
        @if($guruBelumAbsen->count() > 0)
        <div class="progress-action">
            <a href="{{ route('piket.absensi-guru.massal.form') }}" class="btn btn-primary btn-sm">
                Input Sekarang
            </a>
        </div>
        @endif
    </div>
    @endif

    {{-- ── Two-col: Belum absen + Guru piket ── --}}
    <div class="two-col">

        {{-- Guru belum absen --}}
        <div class="card">
            <div class="card-hd">
                <span class="card-title">
                    <svg width="13" height="13" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Belum Tercatat
                    <span class="pill pill-red">{{ $guruBelumAbsen->count() }}</span>
                </span>
            </div>
            <div class="guru-scroll">
                @forelse($guruBelumAbsen as $g)
                <div class="guru-item">
                    <div class="guru-avatar">{{ mb_substr($g->nama_lengkap, 0, 2) }}</div>
                    <div>
                        <p class="guru-name">{{ $g->nama_lengkap }}</p>
                        <p class="guru-meta">NIP: {{ $g->nip ?? '—' }}</p>
                    </div>
                </div>
                @empty
                <div class="empty">
                    <svg width="28" height="28" fill="none" stroke="#86efac" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 8px;display:block"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <p class="ok">Semua guru sudah tercatat!</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Guru piket hari ini --}}
        <div class="card">
            <div class="card-hd">
                <span class="card-title">
                    <svg width="13" height="13" fill="none" stroke="var(--pk-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Guru Piket Hari Ini
                    <span class="pill pill-blue">{{ $guruPiketHariIni->count() }}</span>
                </span>
            </div>
            @forelse($guruPiketHariIni as $jp)
            <div class="piket-item">
                <div class="piket-indicator"></div>
                <div>
                    <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)">{{ $jp->guru->nama_lengkap ?? '—' }}</p>
                    <p style="font-size:11.5px;color:var(--text3);font-family:'DM Sans',sans-serif">{{ ucfirst($jp->hari ?? '') }}</p>
                </div>
            </div>
            @empty
            <div class="empty">
                <p>Tidak ada jadwal piket hari ini.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- ── Tabel absensi hari ini ── --}}
    <div class="card">
        <div class="card-hd">
            <span class="card-title">
                <svg width="13" height="13" fill="none" stroke="var(--pk-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Absensi Guru Hari Ini
                <span class="pill pill-green">{{ $absensiHariIni->count() }} tercatat</span>
            </span>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:40px">#</th>
                        <th>Nama Guru</th>
                        <th>NIP</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th class="c">Status</th>
                        <th class="c">Metode</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensiHariIni as $i => $a)
                    <tr>
                        <td><span class="no-col">{{ $i + 1 }}</span></td>
                        <td>
                            <div class="two-line">
                                <p class="prim">{{ $a->guru->nama_lengkap ?? '—' }}</p>
                            </div>
                        </td>
                        <td class="muted">{{ $a->guru->nip ?? '—' }}</td>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px">
                            {{ $a->jam_masuk ? \Carbon\Carbon::parse($a->jam_masuk)->format('H:i') : '—' }}
                        </td>
                        <td class="muted">{{ $a->jam_keluar ? \Carbon\Carbon::parse($a->jam_keluar)->format('H:i') : '—' }}</td>
                        <td class="c">
                            <span class="badge b-{{ $a->status }}"><span class="bd"></span>{{ ucfirst($a->status) }}</span>
                        </td>
                        <td class="c">
                            @if($a->metode === 'qr')
                                <span class="badge b-qr"><span class="bd"></span>QR</span>
                            @else
                                <span class="badge b-manual"><span class="bd"></span>Manual</span>
                            @endif
                        </td>
                        <td style="font-size:12.5px;color:var(--text2);max-width:180px">
                            <p style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">{{ $a->keterangan ?? '—' }}</p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty">
                                <svg width="28" height="28" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 8px;display:block"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <p>Belum ada absensi tercatat hari ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2800,showConfirmButton:false,toast:true,position:'top-end'});
@endif
@if(session('error'))
Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
@endif
@if(session('warning'))
Swal.fire({icon:'warning',title:'Perhatian!',text:@json(session('warning')),confirmButtonColor:'#1f63db'});
@endif
</script>
</x-app-layout>