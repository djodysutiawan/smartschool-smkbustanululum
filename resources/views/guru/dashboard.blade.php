<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-detail:hover{background:#dcfce7;filter:none}
    .btn-primary{background:var(--brand-600);color:#fff}

    /* Stats */
    .stats-strip{display:grid;grid-template-columns:repeat(6,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;display:flex;align-items:center;gap:11px;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .stat-icon{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.green{background:#f0fdf4}
    .stat-icon.yellow{background:#fefce8}
    .stat-icon.blue{background:#eff6ff}
    .stat-icon.red{background:#fff0f0}
    .stat-icon.purple{background:#fdf4ff}
    .stat-icon.orange{background:#fff7ed}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    /* Greeting */
    .greeting-card{background:linear-gradient(135deg,var(--brand-600) 0%,var(--brand-700) 100%);border-radius:var(--radius);padding:20px 24px;margin-bottom:20px;color:#fff;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px}
    .greeting-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:800;margin-bottom:3px}
    .greeting-sub{font-size:13px;opacity:.8}
    .greeting-right{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;opacity:.85;text-align:right}

    /* Two-col grid */
    .two-col{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}

    /* Panel card */
    .panel{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .panel-header{display:flex;align-items:center;justify-content:space-between;padding:14px 18px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .panel-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:7px}
    .panel-body{padding:0}

    /* Jadwal list */
    .jadwal-item{display:flex;align-items:flex-start;gap:12px;padding:12px 18px;border-bottom:1px solid #f1f5f9;transition:background .1s}
    .jadwal-item:last-child{border-bottom:none}
    .jadwal-item:hover{background:#fafbff}
    .jadwal-time{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);white-space:nowrap;min-width:80px;padding-top:1px}
    .jadwal-info .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .jadwal-info .secondary{font-size:12px;color:var(--text3);margin-top:2px}
    .jadwal-badge{display:inline-flex;align-items:center;padding:2px 8px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;background:var(--brand-50);color:var(--brand-700);margin-top:4px}

    /* Pengumpulan list */
    .pengumpulan-item{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:11px 18px;border-bottom:1px solid #f1f5f9;transition:background .1s}
    .pengumpulan-item:last-child{border-bottom:none}
    .pengumpulan-item:hover{background:#fafbff}
    .peng-info .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}
    .peng-info .secondary{font-size:12px;color:var(--text3);margin-top:1px}

    /* Jurnal list */
    .jurnal-item{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:11px 18px;border-bottom:1px solid #f1f5f9;transition:background .1s}
    .jurnal-item:last-child{border-bottom:none}
    .jurnal-item:hover{background:#fafbff}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-dikumpulkan{background:#eff6ff;color:#1d4ed8} .badge-dikumpulkan .badge-dot{background:#1d4ed8}
    .badge-terlambat   {background:#fff0f0;color:#dc2626} .badge-terlambat   .badge-dot{background:#dc2626}

    .empty-inline{padding:28px 18px;text-align:center;font-size:13px;color:var(--text3)}

    @media(max-width:900px){
        .stats-strip{grid-template-columns:repeat(3,1fr)}
        .two-col{grid-template-columns:1fr}
    }
    @media(max-width:580px){
        .stats-strip{grid-template-columns:repeat(2,1fr)}
        .page{padding:16px}
    }
</style>

<div class="page">

    {{-- Greeting --}}
    <div class="greeting-card">
        <div>
            <p class="greeting-title">Selamat datang, {{ $guru->nama_lengkap }} 👋</p>
            <p class="greeting-sub">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
        </div>
        <div class="greeting-right">
            <p>{{ $jadwalHariIni->count() }} jadwal hari ini</p>
            @if($unreadNotifikasi > 0)
            <p style="margin-top:3px">{{ $unreadNotifikasi }} notifikasi baru</p>
            @endif
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="17" height="17" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Jadwal</p>
                <p class="stat-val">{{ $jadwalHariIni->count() }}</p>
                <p class="stat-sub">hari ini</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="17" height="17" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Tugas</p>
                <p class="stat-val">{{ $totalTugas }}</p>
                <p class="stat-sub">dibuat</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="17" height="17" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div>
                <p class="stat-label">Belum Dinilai</p>
                <p class="stat-val">{{ $tugasBelumNilai }}</p>
                <p class="stat-sub">pengumpulan</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="17" height="17" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Ujian Aktif</p>
                <p class="stat-val">{{ $ujianAktif }}</p>
                <p class="stat-sub">berlangsung</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="17" height="17" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            </div>
            <div>
                <p class="stat-label">Jurnal Bulan</p>
                <p class="stat-val">{{ $jurnalBulanIni }}</p>
                <p class="stat-sub">{{ now()->locale('id')->isoFormat('MMMM') }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="17" height="17" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <p class="stat-label">Absensi</p>
                <p class="stat-val">{{ $absensiHariIni }}</p>
                <p class="stat-sub">hari ini</p>
            </div>
        </div>
    </div>

    {{-- Main Content: Two Column --}}
    <div class="two-col">

        {{-- Jadwal Hari Ini --}}
        <div class="panel">
            <div class="panel-header">
                <p class="panel-title">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Jadwal Hari Ini
                </p>
                <a href="{{ route('guru.jadwal.index') }}" class="btn btn-sm btn-detail">Lihat Semua</a>
            </div>
            <div class="panel-body">
                @forelse($jadwalHariIni as $j)
                <div class="jadwal-item">
                    <div class="jadwal-time">
                        {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}<br>
                        <span style="font-weight:400">{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</span>
                    </div>
                    <div class="jadwal-info">
                        <p class="primary">{{ $j->mataPelajaran->nama_mata_pelajaran ?? '—' }}</p>
                        <p class="secondary">{{ $j->kelas->nama_kelas ?? '—' }} · {{ $j->ruang->nama_ruang ?? '—' }}</p>
                        <span class="jadwal-badge">{{ ucfirst($j->hari) }}</span>
                    </div>
                </div>
                @empty
                <p class="empty-inline">Tidak ada jadwal hari ini</p>
                @endforelse
            </div>
        </div>

        {{-- Pengumpulan Perlu Dinilai --}}
        <div class="panel">
            <div class="panel-header">
                <p class="panel-title">
                    <svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Perlu Dinilai
                    @if($tugasBelumNilai > 0)
                        <span style="background:#fee2e2;color:#dc2626;font-size:11px;padding:1px 7px;border-radius:99px">{{ $tugasBelumNilai }}</span>
                    @endif
                </p>
                <a href="{{ route('guru.pengumpulan-tugas.index') }}" class="btn btn-sm btn-detail">Lihat Semua</a>
            </div>
            <div class="panel-body">
                @forelse($pengumpulanTerbaru as $pt)
                <div class="pengumpulan-item">
                    <div class="peng-info">
                        <p class="primary">{{ $pt->siswa->nama_lengkap ?? '—' }}</p>
                        <p class="secondary">{{ $pt->tugas->judul ?? '—' }}</p>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;flex-shrink:0">
                        <span class="badge badge-{{ $pt->status }}">
                            <span class="badge-dot"></span>{{ ucfirst($pt->status) }}
                        </span>
                        <a href="{{ route('guru.pengumpulan-tugas.show', $pt->id) }}" class="btn btn-sm btn-detail">Nilai</a>
                    </div>
                </div>
                @empty
                <p class="empty-inline">Tidak ada pengumpulan yang perlu dinilai</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Jurnal Terbaru --}}
    <div class="panel">
        <div class="panel-header">
            <p class="panel-title">
                <svg width="14" height="14" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                Jurnal Mengajar Terbaru
            </p>
            <a href="{{ route('guru.jurnal-mengajar.index') }}" class="btn btn-sm btn-detail">Lihat Semua</a>
        </div>
        <div class="panel-body">
            @forelse($jurnalTerbaru as $j)
            <div class="jurnal-item">
                <div>
                    <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)">
                        {{ $j->mataPelajaran->nama_mata_pelajaran ?? '—' }}
                    </p>
                    <p style="font-size:12px;color:var(--text3);margin-top:2px">
                        {{ $j->kelas->nama_kelas ?? '—' }} · {{ \Carbon\Carbon::parse($j->tanggal)->locale('id')->isoFormat('D MMM Y') }}
                    </p>
                </div>
                <a href="{{ route('guru.jurnal-mengajar.show', $j->id) }}" class="btn btn-sm btn-detail">Detail</a>
            </div>
            @empty
            <p class="empty-inline">Belum ada jurnal mengajar</p>
            @endforelse
        </div>
    </div>

</div>
</x-app-layout>