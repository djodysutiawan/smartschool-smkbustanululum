<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --piket-700:#b45309;--piket-600:#d97706;--piket-100:#fef3c7;--piket-50:#fffbeb;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
        --green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fff0f0;--red-border:#fecaca;
    }
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-detail{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}
    .btn-detail:hover{background:#dcfce7;filter:none}

    /* ── Banner Belum Check-In ── */
    .checkin-banner{background:linear-gradient(135deg,#fffbeb,#fef9c3);border:1.5px solid #fde68a;border-radius:var(--radius);padding:20px 24px;margin-bottom:20px;display:flex;gap:16px;align-items:flex-start}
    .checkin-banner-icon{width:44px;height:44px;background:#fef3c7;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .checkin-banner-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:#92400e;margin-bottom:4px}
    .checkin-banner-desc{font-size:13px;color:#a16207;line-height:1.5}
    .checkin-banner-action{margin-top:12px}

    /* Stats */
    .stats-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.green{background:var(--green-bg)} .stat-icon.blue{background:#eff6ff} .stat-icon.amber{background:var(--piket-50)}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    /* Today card */
    .today-card{background:linear-gradient(135deg,var(--brand-600),var(--brand-700));border-radius:var(--radius);padding:18px 22px;color:#fff;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap}
    .today-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;opacity:.75;letter-spacing:.05em;text-transform:uppercase;margin-bottom:4px}
    .today-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:800}
    .today-sub{font-size:12px;opacity:.8;margin-top:2px}
    .today-right{display:flex;gap:8px;flex-wrap:wrap}
    .today-pill{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.25);text-decoration:none}

    /* Filter */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end}
    .filter-field{display:flex;flex-direction:column;gap:4px}
    .filter-field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text2)}
    .filter-field select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none}
    .filter-field select:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center}

    /* Jadwal cards grid */
    .jadwal-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:12px;margin-bottom:16px}
    .jadwal-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:box-shadow .2s,transform .2s}
    .jadwal-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.08);transform:translateY(-1px)}
    .jadwal-card.today-jadwal{border-color:var(--brand-500);border-width:2px}
    .jadwal-card.inactive{opacity:.6}
    .jadwal-card-header{display:flex;align-items:center;gap:10px;padding:14px 16px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .hari-badge{display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:10px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;flex-shrink:0}
    .hari-badge.today{background:var(--brand-600);color:#fff}
    .hari-badge.normal{background:var(--surface3);color:var(--text2)}
    .jadwal-card-hari{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text)}
    .jadwal-card-tanggal{font-size:11.5px;color:var(--text3);margin-top:1px}
    .jadwal-today-chip{margin-left:auto;display:inline-flex;align-items:center;gap:4px;padding:2px 9px;border-radius:99px;font-size:11px;font-weight:700;background:var(--brand-50);color:var(--brand-700)}
    .jadwal-card-body{padding:14px 16px}
    .jadwal-time-row{display:flex;align-items:center;gap:8px;margin-bottom:10px}
    .jadwal-time{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .jadwal-time-sep{color:var(--text3);font-size:13px}
    .jadwal-meta-row{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px}
    .meta-chip{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .meta-chip.aktif{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}
    .meta-chip.nonaktif{background:var(--surface3);color:var(--text3);border:1px solid var(--border)}
    .jadwal-catatan{font-size:12.5px;color:var(--text2);line-height:1.5;margin-bottom:12px;font-family:'DM Sans',sans-serif}
    .jadwal-card-footer{display:flex;justify-content:flex-end;gap:6px}

    /* Rekap log */
    .rekap-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:18px 20px;margin-bottom:16px}
    .rekap-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);margin-bottom:14px;display:flex;align-items:center;gap:7px}
    .log-list{display:flex;flex-direction:column;gap:8px}
    .log-item{display:flex;align-items:center;gap:12px;padding:10px 14px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm)}
    .log-tanggal{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text);min-width:90px}
    .log-masuk{font-size:12px;color:var(--green);font-family:'Plus Jakarta Sans',sans-serif;font-weight:700}
    .log-keluar{font-size:12px;color:var(--text3)}
    .log-durasi{margin-left:auto;font-size:11.5px;color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600}

    /* Empty */
    .empty-state{padding:60px 20px;text-align:center;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius)}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    /* Pagination */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 0;flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}

    @media(max-width:768px){.stats-strip{grid-template-columns:1fr 1fr}.page{padding:16px}.jadwal-grid{grid-template-columns:1fr}.checkin-banner{flex-direction:column}}
</style>

<div class="page">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Jadwal Piket Saya</h1>
            <p class="page-sub">Daftar hari dan jam piket yang dijadwalkan untuk Anda</p>
        </div>
        @if(!$belumCheckin)
        <a href="{{ route('piket.log.checkin') }}" class="btn btn-primary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Check-In Piket
        </a>
        @endif
    </div>

    {{-- ── Banner: Belum Check-In ── --}}
    @if($belumCheckin)
    <div class="checkin-banner">
        <div class="checkin-banner-icon">
            <svg width="22" height="22" fill="none" stroke="#b45309" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <div style="flex:1">
            <p class="checkin-banner-title">Silakan Check-In Terlebih Dahulu</p>
            <p class="checkin-banner-desc">
                Jadwal dan riwayat piket Anda hanya dapat ditampilkan setelah melakukan check-in.
                Silakan lakukan check-in untuk mengakses halaman ini secara penuh.
            </p>
            <div class="checkin-banner-action">
                <a href="{{ route('piket.log.checkin') }}" class="btn btn-primary">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Check-In Sekarang
                </a>
            </div>
        </div>
    </div>
    @endif

    {{-- ── Stats Strip ── --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="17" height="17" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Jadwal</p>
                <p class="stat-val">{{ $belumCheckin ? '—' : $jadwal->total() }}</p>
                <p class="stat-sub">aktif & nonaktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="17" height="17" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Hadir Bulan Ini</p>
                <p class="stat-val">{{ $rekapBulanIni['hadir'] }}</p>
                <p class="stat-sub">dari {{ $rekapBulanIni['total'] }} log</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber">
                <svg width="17" height="17" fill="none" stroke="#b45309" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Jadwal Hari Ini</p>
                @if($jadwalHariIni)
                    <p class="stat-val">{{ \Carbon\Carbon::parse($jadwalHariIni->jam_mulai)->format('H:i') }}</p>
                    <p class="stat-sub">s/d {{ \Carbon\Carbon::parse($jadwalHariIni->jam_selesai)->format('H:i') }}</p>
                @else
                    <p class="stat-val" style="font-size:14px;color:var(--text3)">
                        {{ $belumCheckin ? '—' : 'Tidak ada' }}
                    </p>
                    <p class="stat-sub">{{ $belumCheckin ? 'belum check-in' : 'jadwal hari ini' }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Jadwal hari ini banner (hanya jika sudah check-in dan ada jadwal) ── --}}
    @if(!$belumCheckin && $jadwalHariIni)
    <div class="today-card">
        <div>
            <p class="today-label">Jadwal Piket Hari Ini</p>
            <p class="today-val">{{ ucfirst($jadwalHariIni->hari) }}, {{ now()->locale('id')->isoFormat('D MMMM Y') }}</p>
            <p class="today-sub">{{ \Carbon\Carbon::parse($jadwalHariIni->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($jadwalHariIni->jam_selesai)->format('H:i') }}</p>
        </div>
        <div class="today-right">
            <a href="{{ route('piket.log.checkin') }}" class="today-pill">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Check-In Sekarang
            </a>
            <a href="{{ route('piket.jadwal.show', $jadwalHariIni->id) }}" class="today-pill">
                Detail Jadwal
            </a>
        </div>
    </div>
    @endif

    {{-- ── Filter (hanya tampil jika sudah check-in) ── --}}
    @if(!$belumCheckin)
    <div class="filter-card">
        <form method="GET" action="{{ route('piket.jadwal.index') }}">
            <div class="filter-row">
                {{-- Filter Tahun Ajaran --}}
                @if(isset($tahunAjaranList) && $tahunAjaranList->count())
                <div class="filter-field">
                    <label>Tahun Ajaran</label>
                    <select name="tahun_ajaran_id">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunAjaranList as $ta)
                        <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                            {{ $ta->tahun }} / {{ $ta->semester }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endif

                {{-- Filter Status --}}
                <div class="filter-field">
                    <label>Status</label>
                    <select name="is_active">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="filter-sep"></div>
                <a href="{{ route('piket.jadwal.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>
    @endif

    {{-- ── Jadwal Grid ── --}}
    @if(!$belumCheckin && $jadwal->count())
    <div class="jadwal-grid">
        @php
            $hariIniStr = strtolower(\Carbon\Carbon::now()->locale('id')->isoFormat('dddd'));
            $hariMap = ['senin'=>'SEN','selasa'=>'SEL','rabu'=>'RAB','kamis'=>'KAM','jumat'=>'JUM','sabtu'=>'SAB'];
        @endphp
        @foreach($jadwal as $j)
        @php $isToday = $j->hari === $hariIniStr; @endphp
        <div class="jadwal-card {{ $isToday ? 'today-jadwal' : '' }} {{ !$j->is_active ? 'inactive' : '' }}">
            <div class="jadwal-card-header">
                <div class="hari-badge {{ $isToday ? 'today' : 'normal' }}">
                    {{ $hariMap[$j->hari] ?? strtoupper(substr($j->hari,0,3)) }}
                </div>
                <div style="flex:1">
                    <p class="jadwal-card-hari">{{ ucfirst($j->hari) }}</p>
                    <p class="jadwal-card-tanggal">
                        {{ $j->tahunAjaran->tahun ?? '—' }}
                        @if($j->tahunAjaran) / {{ $j->tahunAjaran->semester ?? '' }} @endif
                    </p>
                </div>
                @if($isToday)
                    <span class="jadwal-today-chip">
                        <svg width="7" height="7" fill="var(--brand-600)" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5"/></svg>
                        Hari ini
                    </span>
                @endif
            </div>
            <div class="jadwal-card-body">
                <div class="jadwal-time-row">
                    <p class="jadwal-time">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}</p>
                    <span class="jadwal-time-sep">—</span>
                    <p class="jadwal-time">{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</p>
                </div>
                <div class="jadwal-meta-row">
                    <span class="meta-chip {{ $j->is_active ? 'aktif' : 'nonaktif' }}">
                        {{ $j->is_active ? '● Aktif' : '○ Nonaktif' }}
                    </span>
                </div>
                @if($j->catatan)
                <p class="jadwal-catatan">{{ $j->catatan }}</p>
                @endif
                <div class="jadwal-card-footer">
                    <a href="{{ route('piket.jadwal.show', $j->id) }}" class="btn btn-sm btn-detail">Lihat Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($jadwal->hasPages())
    <div class="pag-wrap">
        <p class="pag-info">Menampilkan {{ $jadwal->firstItem() }}–{{ $jadwal->lastItem() }} dari {{ $jadwal->total() }}</p>
        <div class="pag-btns">
            @if($jadwal->onFirstPage())
                <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
            @else
                <a href="{{ $jadwal->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
            @endif
            @foreach($jadwal->getUrlRange(1,$jadwal->lastPage()) as $page => $url)
                @if($page == $jadwal->currentPage())
                    <span class="pag-btn active">{{ $page }}</span>
                @elseif($page == 1 || $page == $jadwal->lastPage() || abs($page - $jadwal->currentPage()) <= 1)
                    <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                @elseif(abs($page - $jadwal->currentPage()) == 2)
                    <span class="pag-ellipsis">…</span>
                @endif
            @endforeach
            @if($jadwal->hasMorePages())
                <a href="{{ $jadwal->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
            @else
                <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
            @endif
        </div>
    </div>
    @endif

    {{-- Rekap Log Bulan Ini --}}
    @if($logBulanIni->count())
    <div class="rekap-card">
        <p class="rekap-title">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Riwayat Check-In Bulan Ini
        </p>
        <div class="log-list">
            @foreach($logBulanIni->take(10) as $log)
            @php
                $durMenit = ($log->masuk_pada && $log->keluar_pada)
                    ? \Carbon\Carbon::parse($log->masuk_pada)->diffInMinutes(\Carbon\Carbon::parse($log->keluar_pada))
                    : null;
            @endphp
            <div class="log-item">
                <p class="log-tanggal">{{ \Carbon\Carbon::parse($log->tanggal)->locale('id')->isoFormat('ddd, D MMM') }}</p>
                <p class="log-masuk">Masuk {{ $log->masuk_pada ? \Carbon\Carbon::parse($log->masuk_pada)->format('H:i') : '—' }}</p>
                <p class="log-keluar">{{ $log->keluar_pada ? '→ Keluar '.\Carbon\Carbon::parse($log->keluar_pada)->format('H:i') : 'Belum checkout' }}</p>
                @if($durMenit)
                <p class="log-durasi">{{ intdiv($durMenit,60) }}j {{ $durMenit%60 }}m</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @elseif(!$belumCheckin)
    {{-- Sudah check-in tapi tidak ada jadwal --}}
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <p class="empty-title">Belum ada jadwal piket</p>
        <p class="empty-sub">Jadwal piket Anda akan muncul di sini setelah ditambahkan oleh admin</p>
    </div>
    @endif

</div>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Swal !== 'undefined') {
        Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
    }
});
</script>
@endif
@if(session('warning'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Swal !== 'undefined') {
        Swal.fire({ icon:'warning', title:'Perhatian', text:@json(session('warning')), confirmButtonColor:'#1f63db' });
    }
});
</script>
@endif
</x-app-layout>