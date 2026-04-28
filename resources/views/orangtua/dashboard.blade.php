<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{
        --brand:#1f63db;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 60px;max-width:1400px;margin:0 auto}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    /* Welcome Hero */
    .welcome-hero{background:linear-gradient(135deg,var(--brand) 0%,#3b82f6 100%);border-radius:var(--radius);padding:24px 28px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;gap:20px;flex-wrap:wrap}
    .welcome-text .wt-greeting{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:rgba(255,255,255,.75);margin-bottom:4px}
    .welcome-text .wt-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:#fff}
    .welcome-text .wt-date{font-size:12.5px;color:rgba(255,255,255,.65);margin-top:4px}
    .welcome-notif{background:rgba(255,255,255,.15);border-radius:var(--radius-sm);padding:10px 16px;display:flex;align-items:center;gap:10px;text-decoration:none}
    .welcome-notif-count{background:#fff;color:var(--brand-700);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;padding:2px 8px;border-radius:99px}
    .welcome-notif-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:#fff}
    /* Stats */
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .si-green{background:#f0fdf4}.si-yellow{background:#fef9c3}.si-red{background:#fff0f0}.si-blue{background:var(--brand-50)}.si-purple{background:#faf5ff}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    /* Grid Layout */
    .dash-grid{display:grid;grid-template-columns:1fr 360px;gap:16px}
    /* Cards */
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card:last-child{margin-bottom:0}
    .card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:7px}
    .card-link{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--brand);text-decoration:none}
    .card-link:hover{text-decoration:underline}
    /* Absensi strip */
    .absensi-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;padding:16px 20px}
    .abs-box{text-align:center;padding:12px 8px;border-radius:var(--radius-sm);border:1px solid var(--border)}
    .abs-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;font-weight:800;margin-bottom:3px}
    .abs-label{font-size:11px;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .abs-hadir{background:#f0fdf4;border-color:#bbf7d0}.abs-hadir .abs-val{color:#15803d}
    .abs-izin{background:#dbeafe;border-color:#bfdbfe}.abs-izin .abs-val{color:#1d4ed8}
    .abs-sakit{background:#faf5ff;border-color:#e9d5ff}.abs-sakit .abs-val{color:#6d28d9}
    .abs-alfa{background:#fff0f0;border-color:#fecaca}.abs-alfa .abs-val{color:#dc2626}
    /* Status hari ini */
    .status-today{padding:16px 20px;display:flex;align-items:center;gap:14px}
    .status-icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:20px}
    .status-desc .sd-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px}
    .status-desc .sd-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:800;color:var(--text)}
    .status-desc .sd-time{font-size:12.5px;color:var(--text3);margin-top:2px}
    /* Badge */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%}
    .b-hadir{background:#dcfce7;color:#15803d}.b-hadir .badge-dot{background:#15803d}
    .b-telat{background:#fef9c3;color:#a16207}.b-telat .badge-dot{background:#a16207}
    .b-izin{background:#dbeafe;color:#1d4ed8}.b-izin .badge-dot{background:#1d4ed8}
    .b-sakit{background:#f3e8ff;color:#6d28d9}.b-sakit .badge-dot{background:#6d28d9}
    .b-alfa{background:#fee2e2;color:#dc2626}.b-alfa .badge-dot{background:#dc2626}
    .b-belum{background:var(--surface3);color:var(--text3)}.b-belum .badge-dot{background:var(--text3)}
    /* Tugas list */
    .tugas-item{display:flex;align-items:flex-start;padding:12px 20px;border-bottom:1px solid var(--border);gap:12px}
    .tugas-item:last-child{border-bottom:none}
    .tugas-dot{width:8px;height:8px;border-radius:50%;background:var(--brand);flex-shrink:0;margin-top:5px}
    .tugas-dot.telat{background:#dc2626}
    .tugas-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}
    .tugas-meta{font-size:12px;color:var(--text3);margin-top:2px}
    .tugas-deadline{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;margin-left:auto;flex-shrink:0;padding:2px 8px;border-radius:5px}
    .td-ok{background:var(--surface3);color:var(--text2)}.td-warn{background:#fff3cd;color:#a16207}.td-late{background:#fee2e2;color:#dc2626}
    /* Anak card */
    .anak-card{display:flex;align-items:center;gap:14px;padding:14px 20px;border-bottom:1px solid var(--border);text-decoration:none;transition:background .1s}
    .anak-card:last-child{border-bottom:none}
    .anak-card:hover{background:var(--brand-50)}
    .anak-avatar{width:42px;height:42px;border-radius:11px;background:var(--brand);color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;flex-shrink:0}
    .anak-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .anak-kelas{font-size:12px;color:var(--text3);margin-top:2px}
    /* Nilai bar */
    .nilai-bar-wrap{padding:16px 20px}
    .nilai-bar-label{display:flex;justify-content:space-between;margin-bottom:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px}
    .nilai-bar-label .nbl-name{font-weight:600;color:var(--text2)}
    .nilai-bar-label .nbl-val{font-weight:800;color:var(--text)}
    .nilai-bar-track{height:8px;background:var(--surface3);border-radius:99px;overflow:hidden}
    .nilai-bar-fill{height:100%;border-radius:99px;background:var(--brand);transition:width .4s}
    .nilai-bar-fill.sangat-baik{background:#15803d}
    .nilai-bar-fill.baik{background:var(--brand)}
    .nilai-bar-fill.cukup{background:#a16207}
    .nilai-bar-fill.kurang{background:#dc2626}
    /* Empty */
    .empty-inline{padding:28px 20px;text-align:center;color:var(--text3);font-size:13px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand);color:#fff}
    .btn-sm{padding:5px 12px;font-size:12px}
    @media(max-width:1024px){.dash-grid{grid-template-columns:1fr}.stats-strip{grid-template-columns:1fr 1fr}.page{padding:16px 16px 40px}}
    @media(max-width:480px){.stats-strip{grid-template-columns:1fr 1fr}.absensi-strip{grid-template-columns:1fr 1fr}}
</style>

<div class="page">
    {{-- Welcome Hero --}}
    <div class="welcome-hero">
        <div class="welcome-text">
            <p class="wt-greeting">Selamat datang,</p>
            <p class="wt-name">{{ $orangTua->nama_lengkap ?? Auth::user()->name }}</p>
            <p class="wt-date">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        @if($unreadNotifikasi > 0)
        <a href="{{ route('ortu.notifikasi.index') }}" class="welcome-notif">
            <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            <span class="welcome-notif-count">{{ $unreadNotifikasi }}</span>
            <span class="welcome-notif-label">notifikasi baru</span>
        </a>
        @endif
    </div>

    {{-- Stats Strip --}}
    @if($anak)
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon si-green"><svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
            <div>
                <p class="stat-label">Hadir Bulan Ini</p>
                <p class="stat-val">{{ $rekapAbsensi[$anak->id]['hadir'] ?? 0 }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-blue"><svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
            <div>
                <p class="stat-label">Rata-rata Nilai</p>
                <p class="stat-val">{{ $rataRataNilai ? number_format($rataRataNilai, 1) : '—' }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-yellow"><svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
            <div>
                <p class="stat-label">Tugas Pending</p>
                <p class="stat-val">{{ $tugasBelumDikumpulkan->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-red"><svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
            <div>
                <p class="stat-label">Pelanggaran (Tahun Ini)</p>
                <p class="stat-val">{{ $totalPelanggaran }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="dash-grid">
        {{-- Kolom Kiri --}}
        <div>
            {{-- Status Kehadiran Hari Ini --}}
            @if($anak)
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Kehadiran Hari Ini — {{ $anak->nama_lengkap }}
                    </span>
                    <a href="{{ route('ortu.absensi.status-hari-ini') }}" class="card-link">Detail →</a>
                </div>
                @if($absensiHariIni)
                <div class="status-today">
                    @php
                        $icons = ['hadir'=>'✅','telat'=>'⏰','izin'=>'📄','sakit'=>'🤒','alfa'=>'❌'];
                        $bgs   = ['hadir'=>'#dcfce7','telat'=>'#fef9c3','izin'=>'#dbeafe','sakit'=>'#f3e8ff','alfa'=>'#fee2e2'];
                    @endphp
                    <div class="status-icon" style="background:{{ $bgs[$absensiHariIni->status] ?? '#f1f5f9' }}">
                        {{ $icons[$absensiHariIni->status] ?? '?' }}
                    </div>
                    <div class="status-desc">
                        <p class="sd-label">Status Kehadiran</p>
                        <p class="sd-val">{{ ucfirst($absensiHariIni->status) }}</p>
                        <p class="sd-time">
                            @if($absensiHariIni->jam_masuk) Masuk: {{ $absensiHariIni->jam_masuk }} @endif
                            @if($absensiHariIni->jam_keluar) · Keluar: {{ $absensiHariIni->jam_keluar }} @endif
                        </p>
                    </div>
                </div>
                @else
                <div class="status-today">
                    <div class="status-icon" style="background:#f1f5f9">❓</div>
                    <div class="status-desc">
                        <p class="sd-label">Status Kehadiran</p>
                        <p class="sd-val" style="color:var(--text3)">Belum tercatat</p>
                        <p class="sd-time">Data belum masuk untuk hari ini</p>
                    </div>
                </div>
                @endif
            </div>
            @endif

            {{-- Rekap Absensi Bulan Ini --}}
            @foreach($rekapAbsensi as $siswaId => $rekap)
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Rekap Absensi {{ now()->translatedFormat('F Y') }} — {{ $rekap['nama'] }}
                    </span>
                    <a href="{{ route('ortu.absensi.rekap') }}" class="card-link">Lihat Rekap →</a>
                </div>
                <div class="absensi-strip">
                    <div class="abs-box abs-hadir"><p class="abs-val">{{ $rekap['hadir'] }}</p><p class="abs-label">Hadir</p></div>
                    <div class="abs-box abs-izin"><p class="abs-val">{{ $rekap['izin'] }}</p><p class="abs-label">Izin</p></div>
                    <div class="abs-box abs-sakit"><p class="abs-val">{{ $rekap['sakit'] }}</p><p class="abs-label">Sakit</p></div>
                    <div class="abs-box abs-alfa"><p class="abs-val">{{ $rekap['alfa'] }}</p><p class="abs-label">Alfa</p></div>
                </div>
            </div>
            @endforeach

            {{-- Tugas Belum Dikumpulkan --}}
            @if($anak)
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        Tugas Belum Dikumpulkan
                    </span>
                    <a href="{{ route('ortu.akademik.tugas') }}" class="card-link">Semua Tugas →</a>
                </div>
                @forelse($tugasBelumDikumpulkan as $t)
                @php
                    $sisa = now()->diffInDays($t->batas_waktu, false);
                    $dcClass = $sisa > 3 ? 'td-ok' : ($sisa >= 0 ? 'td-warn' : 'td-late');
                    $dcLabel = $sisa < 0 ? 'Terlambat' : "Sisa {$sisa} hari";
                @endphp
                <div class="tugas-item">
                    <div class="tugas-dot {{ $sisa < 0 ? 'telat' : '' }}"></div>
                    <div style="flex:1;min-width:0">
                        <p class="tugas-title">{{ $t->judul }}</p>
                        <p class="tugas-meta">{{ $t->mataPelajaran->nama_mapel ?? '—' }} · Batas: {{ $t->batas_waktu->translatedFormat('d M Y, H:i') }}</p>
                    </div>
                    <span class="tugas-deadline {{ $dcClass }}">{{ $dcLabel }}</span>
                </div>
                @empty
                <div class="empty-inline">🎉 Semua tugas sudah dikumpulkan</div>
                @endforelse
            </div>
            @endif
        </div>

        {{-- Kolom Kanan / Sidebar --}}
        <div>
            {{-- Daftar Anak --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        Data Anak
                    </span>
                    <a href="{{ route('ortu.profil-anak.index') }}" class="card-link">Lihat Profil →</a>
                </div>
                @forelse($anakList as $a)
                @php $inisial = collect(explode(' ', $a->nama_lengkap))->map(fn($w) => strtoupper($w[0]))->take(2)->implode(''); @endphp
                <a href="{{ route('ortu.profil-anak.show', $a->id) }}" class="anak-card">
                    <div class="anak-avatar">{{ $inisial }}</div>
                    <div>
                        <p class="anak-name">{{ $a->nama_lengkap }}</p>
                        <p class="anak-kelas">{{ $a->kelas->nama_kelas ?? '—' }} · NIS: {{ $a->nis ?? '—' }}</p>
                    </div>
                    <svg style="margin-left:auto;color:var(--text3)" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
                @empty
                <div class="empty-inline">Belum ada data anak terhubung</div>
                @endforelse
            </div>

            {{-- Nilai per Mapel --}}
            @if($anak && $rataRataNilai)
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        Rata-rata Nilai
                    </span>
                    <a href="{{ route('ortu.akademik.nilai') }}" class="card-link">Detail →</a>
                </div>
                <div style="padding:16px 20px 6px">
                    <div style="text-align:center;margin-bottom:16px">
                        <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:40px;font-weight:800;color:{{ $rataRataNilai >= 80 ? '#15803d' : ($rataRataNilai >= 70 ? '#1f63db' : ($rataRataNilai >= 60 ? '#a16207' : '#dc2626')) }}">
                            {{ number_format($rataRataNilai, 1) }}
                        </div>
                        <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em">
                            Nilai Rata-rata
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Pelanggaran --}}
            @if($totalPelanggaran > 0)
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        Pelanggaran Tahun Ini
                    </span>
                    <a href="{{ route('ortu.kedisiplinan.riwayat') }}" class="card-link">Detail →</a>
                </div>
                <div style="padding:16px 20px;text-align:center">
                    <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:36px;font-weight:800;color:#dc2626">{{ $totalPelanggaran }}</div>
                    <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em">Catatan Pelanggaran</div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});@endif
</script>
</x-app-layout>