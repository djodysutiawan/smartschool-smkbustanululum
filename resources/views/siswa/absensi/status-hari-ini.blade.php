<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 48px}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;margin-bottom:20px}

    .tab-nav{display:flex;gap:4px;margin-bottom:20px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);padding:4px;width:fit-content;flex-wrap:wrap}
    .tab-link{padding:7px 18px;border-radius:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text3);text-decoration:none;transition:all .15s}
    .tab-link.active{background:var(--surface);color:var(--brand-600);box-shadow:0 1px 3px rgba(0,0,0,.08)}
    .tab-link:hover:not(.active){color:var(--text2)}

    /* Info bar */
    .info-bar{background:#eff6ff;border:1px solid #bfdbfe;border-radius:var(--radius-sm);padding:11px 16px;display:flex;align-items:center;gap:8px;margin-bottom:20px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:#1d4ed8}

    /* Summary pills */
    .summary-strip{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:20px}
    .sum-pill{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;border:1px solid var(--border);background:var(--surface);box-shadow:0 1px 3px rgba(0,0,0,.07)}
    .sum-dot{width:8px;height:8px;border-radius:50%}

    /* Timeline card */
    .timeline-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.07)}
    .timeline-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .timeline-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .timeline-count{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;background:var(--brand-600);color:#fff;padding:2px 8px;border-radius:99px;margin-left:auto}

    /* Jadwal row */
    .jadwal-row{display:grid;grid-template-columns:80px 1fr auto;align-items:center;gap:16px;padding:14px 20px;border-bottom:1px solid var(--border)}
    .jadwal-row:last-child{border-bottom:none}
    .jam-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-align:right;white-space:nowrap}
    .jam-col .jam-mulai{font-size:15px;color:var(--text2);display:block}
    .mapel-col{}
    .mapel-nama{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text)}
    .mapel-meta{font-size:11.5px;color:var(--text3);margin-top:3px;display:flex;gap:6px;align-items:center;flex-wrap:wrap}
    .status-col{display:flex;flex-direction:column;align-items:flex-end;gap:4px}

    /* Status badge */
    .sbadge{display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .sbadge-hadir{background:#dcfce7;color:#15803d}
    .sbadge-telat{background:#fef9c3;color:#a16207}
    .sbadge-izin{background:#eff6ff;color:#1d4ed8}
    .sbadge-sakit{background:#fdf4ff;color:#7c3aed}
    .sbadge-alfa{background:#fee2e2;color:#dc2626}
    .sbadge-belum{background:var(--surface3);color:var(--text3)}

    /* Dot separator */
    .dot-sep{display:flex;align-items:center;justify-content:center;width:24px}
    .dot-line{width:2px;background:var(--border);flex:1;margin:0 auto}
    .dot-circle{width:10px;height:10px;border-radius:50%;border:2px solid var(--border);background:var(--surface);flex-shrink:0}
    .dot-circle.hadir{border-color:#15803d;background:#dcfce7}
    .dot-circle.telat{border-color:#a16207;background:#fef9c3}
    .dot-circle.alfa{border-color:#dc2626;background:#fee2e2}
    .dot-circle.belum{border-color:var(--border);background:var(--surface)}

    /* Empty state */
    .empty-state{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    @media(max-width:600px){
        .page{padding:16px}
        .tab-nav{width:100%}
        .tab-link{flex:1;text-align:center;padding:7px 10px}
        .jadwal-row{grid-template-columns:60px 1fr auto;gap:10px;padding:12px 14px}
    }
</style>

<div class="page">
    <h1 class="page-title">Status Hari Ini</h1>
    <p class="page-sub">
        {{ now()->locale('id')->translatedFormat('l, d F Y') }}
        &nbsp;·&nbsp; Kelas {{ $siswa->kelas->nama_kelas ?? '-' }}
    </p>

    <div class="tab-nav">
        <a href="{{ route('siswa.absensi.scan') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.scan') ? 'active' : '' }}">
            Scan QR
        </a>
        <a href="{{ route('siswa.absensi.jadwal') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.jadwal') ? 'active' : '' }}">
            QR Per Pelajaran
        </a>
        <a href="{{ route('siswa.absensi.riwayat') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.riwayat') ? 'active' : '' }}">
            Riwayat
        </a>
        <a href="{{ route('siswa.absensi.rekap') }}"
           class="tab-link {{ request()->routeIs('siswa.absensi.rekap') ? 'active' : '' }}">
            Rekap
        </a>
    </div>

    @php
        $totalJadwal  = $jadwalHariIni->count();
        $totalAbsensi = $absensiHariIni->count();
        $sudahHadir   = $absensiHariIni->whereIn('status', ['hadir', 'telat'])->count();
        $belumAbsen   = $jadwalHariIni->filter(fn($j) => ! $absensiMap->has($j->id))->count();
    @endphp

    {{-- Info bar --}}
    <div class="info-bar">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        {{ $totalJadwal }} pelajaran hari ini
        &nbsp;·&nbsp; {{ $totalAbsensi }} sudah tercatat
        @if($belumAbsen > 0)
            &nbsp;·&nbsp; <span style="color:#dc2626">{{ $belumAbsen }} belum absen</span>
        @else
            &nbsp;·&nbsp; <span style="color:#15803d">Semua sudah ✓</span>
        @endif
    </div>

    {{-- Summary pills --}}
    @if($totalAbsensi > 0)
    @php
        $hitungStatus = [
            'hadir' => $absensiHariIni->where('status', 'hadir')->count(),
            'telat' => $absensiHariIni->where('status', 'telat')->count(),
            'izin'  => $absensiHariIni->where('status', 'izin')->count(),
            'sakit' => $absensiHariIni->where('status', 'sakit')->count(),
            'alfa'  => $absensiHariIni->where('status', 'alfa')->count(),
        ];
    @endphp
    <div class="summary-strip">
        @if($hitungStatus['hadir'] > 0)
            <span class="sum-pill"><span class="sum-dot" style="background:#16a34a"></span>{{ $hitungStatus['hadir'] }} Hadir</span>
        @endif
        @if($hitungStatus['telat'] > 0)
            <span class="sum-pill"><span class="sum-dot" style="background:#ca8a04"></span>{{ $hitungStatus['telat'] }} Telat</span>
        @endif
        @if($hitungStatus['izin'] > 0)
            <span class="sum-pill" style="color:#1d4ed8"><span class="sum-dot" style="background:#3b82f6"></span>{{ $hitungStatus['izin'] }} Izin</span>
        @endif
        @if($hitungStatus['sakit'] > 0)
            <span class="sum-pill" style="color:#7e22ce"><span class="sum-dot" style="background:#a855f7"></span>{{ $hitungStatus['sakit'] }} Sakit</span>
        @endif
        @if($hitungStatus['alfa'] > 0)
            <span class="sum-pill" style="color:#dc2626"><span class="sum-dot" style="background:#dc2626"></span>{{ $hitungStatus['alfa'] }} Alfa</span>
        @endif
        @if($belumAbsen > 0)
            <span class="sum-pill" style="color:var(--text3)"><span class="sum-dot" style="background:var(--border)"></span>{{ $belumAbsen }} Belum</span>
        @endif
    </div>
    @endif

    {{-- Timeline jadwal --}}
    @if($jadwalHariIni->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <p class="empty-title">Tidak ada jadwal hari ini</p>
            <p class="empty-sub">Nikmati hari libur Anda!</p>
        </div>
    @else
        <div class="timeline-card">
            <div class="timeline-header">
                <svg width="14" height="14" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <span class="timeline-title">Jadwal & Status Hari Ini</span>
                <span class="timeline-count">{{ $totalJadwal }} mapel</span>
            </div>

            @foreach($jadwalHariIni as $jadwal)
            @php
                $absensi      = $absensiMap->get($jadwal->id);
                $status       = $absensi?->status ?? null;
                $dotClass     = match($status) {
                    'hadir'  => 'hadir',
                    'telat'  => 'telat',
                    'alfa'   => 'alfa',
                    null     => 'belum',
                    default  => 'belum',
                };
                $badgeClass   = match($status) {
                    'hadir'  => 'sbadge-hadir',
                    'telat'  => 'sbadge-telat',
                    'izin'   => 'sbadge-izin',
                    'sakit'  => 'sbadge-sakit',
                    'alfa'   => 'sbadge-alfa',
                    default  => 'sbadge-belum',
                };
                $badgeLabel   = match($status) {
                    'hadir'  => '✓ Hadir',
                    'telat'  => '⚠ Telat',
                    'izin'   => 'Izin',
                    'sakit'  => 'Sakit',
                    'alfa'   => '✗ Alfa',
                    default  => 'Belum absen',
                };
                $sedang       = $jadwal->isSedangBerlangsung();
            @endphp
            <div class="jadwal-row" style="{{ $sedang ? 'background:#fafbff;border-left:3px solid #3582f0;' : '' }}">
                {{-- Kolom jam --}}
                <div class="jam-col">
                    <span class="jam-mulai">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</span>
                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                    @if($sedang)
                        <span style="display:block;font-size:9.5px;color:#3582f0;margin-top:2px;font-weight:800;letter-spacing:.04em">BERLANGSUNG</span>
                    @endif
                </div>

                {{-- Kolom mapel --}}
                <div class="mapel-col">
                    <p class="mapel-nama">{{ $jadwal->mataPelajaran->nama_mapel ?? 'Mata Pelajaran' }}</p>
                    <div class="mapel-meta">
                        @if($jadwal->guru)
                            <span>{{ $jadwal->guru->nama_lengkap }}</span>
                        @endif
                        @if($absensi?->jam_masuk)
                            <span>·</span>
                            <span style="color:#16a34a;font-weight:600">
                                Masuk {{ \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Kolom status --}}
                <div class="status-col">
                    <span class="sbadge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                    @if($status === null && $sedang)
                        <a href="{{ route('siswa.absensi.jadwal') }}"
                           style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--brand-600);text-decoration:none">
                            → Lihat QR
                        </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
</x-app-layout>