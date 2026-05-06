<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand)}
    .breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px;flex-wrap:wrap}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .live-badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:99px;background:#fee2e2;color:#dc2626;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;border:1px solid #fecaca}
    .live-dot{width:6px;height:6px;border-radius:50%;background:#dc2626;animation:pulse 1.2s ease-in-out infinite}
    @keyframes pulse{0%,100%{opacity:1}50%{opacity:.3}}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}.btn-back:hover{background:var(--surface3);filter:none}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}.btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}.btn-del:hover{background:#fee2e2;filter:none}
    .btn-toggle{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa}.btn-toggle:hover{background:#ffedd5;filter:none}
    .btn-qr{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}.btn-qr:hover{background:#dcfce7;filter:none}
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:16px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;margin-bottom:5px}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:23px;font-weight:800;color:var(--text);line-height:1.1}
    .stat-sub{font-size:12px;color:var(--text3);margin-top:3px}
    .alert-box{display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-family:'DM Sans',sans-serif;font-size:13px;border:1px solid}
    .alert-success{background:#f0fdf4;color:#15803d;border-color:#bbf7d0}
    .alert-warning{background:#fff7ed;color:#c2410c;border-color:#fed7aa}
    .kap-bar-wrap{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px}
    .kap-bar-hdr{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px}
    .kap-bar-track{width:100%;height:7px;background:var(--surface3);border-radius:99px;overflow:hidden}
    .kap-bar-fill{height:100%;border-radius:99px}
    .layout-2col{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}
    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .detail-header{padding:12px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px}
    .detail-header-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .detail-header-sub{font-weight:400;color:var(--text3)}
    .drow{padding:10px 18px;border-bottom:1px solid #f8fafc;display:flex;flex-direction:column;gap:3px}
    .drow:last-child{border-bottom:none}
    .dlabel{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .dval{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text)}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%}
    .badge-aktif{background:#dcfce7;color:#15803d}.badge-aktif .badge-dot{background:#15803d}
    .badge-nonaktif{background:#fee2e2;color:#dc2626}.badge-nonaktif .badge-dot{background:#dc2626}
    .hari-pill{display:inline-block;padding:3px 12px;border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700}
    .hari-senin{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
    .hari-selasa{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .hari-rabu{background:#fefce8;color:#a16207;border:1px solid #fde68a}
    .hari-kamis{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa}
    .hari-jumat{background:#fdf4ff;color:#7c3aed;border:1px solid #e9d5ff}
    .hari-sabtu{background:#f0f9ff;color:#0369a1;border:1px solid #bae6fd}
    .hari-default{background:var(--surface3);color:var(--text2);border:1px solid var(--border2)}
    .jam-display{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text)}
    .jam-sep{color:var(--text3);margin:0 6px}
    .sesi-table{width:100%;border-collapse:collapse;font-size:13px}
    .sesi-table thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    .sesi-table thead th{padding:9px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em}
    .sesi-table tbody tr{border-bottom:1px solid #f1f5f9}
    .sesi-table tbody tr:last-child{border-bottom:none}
    .sesi-table td{padding:9px 14px;color:var(--text)}
    .empty-state{padding:32px 20px;text-align:center;color:var(--text3);font-size:13px}
    @media(max-width:768px){.layout-2col{grid-template-columns:1fr}.stats-strip{grid-template-columns:1fr 1fr}.page{padding:16px}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.jadwal-pelajaran.index') }}">Jadwal Pelajaran</a>
        <span class="sep">›</span>
        <span class="current">Detail Jadwal</span>
    </nav>

    <div class="page-header">
        <div>
            <div class="page-title">
                {{ optional($jadwalPelajaran->mataPelajaran)->nama_mapel ?? 'Detail Jadwal' }}
                @if($jadwalPelajaran->isSedangBerlangsung())
                    <span class="live-badge">
                        <span class="live-dot"></span>
                        Sedang Berlangsung
                    </span>
                @endif
            </div>
            <p class="page-sub">
                {{ optional($jadwalPelajaran->kelas)->nama_kelas ?? '—' }}
                — {{ ucfirst($jadwalPelajaran->hari) }}
                {{ \Carbon\Carbon::parse($jadwalPelajaran->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($jadwalPelajaran->jam_selesai)->format('H:i') }}
                ({{ $jadwalPelajaran->durasi_menit }} menit)
            </p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            @if($jadwalPelajaran->is_active)
            <a href="{{ route('admin.jadwal-pelajaran.generate-qr', $jadwalPelajaran->id) }}" class="btn btn-qr">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="5" height="5"/><rect x="16" y="3" width="5" height="5"/><rect x="3" y="16" width="5" height="5"/><path d="M21 16h-3a2 2 0 0 0-2 2v3"/><path d="M21 21v.01"/></svg>
                {{ $stats['ada_sesi_aktif'] ? 'Lihat QR Aktif' : 'Generate QR' }}
            </a>
            @endif
            <form action="{{ route('admin.jadwal-pelajaran.toggle-status', $jadwalPelajaran->id) }}" method="POST" id="toggleForm" style="display:inline">
                @csrf @method('PATCH')
                <button type="button" class="btn btn-toggle"
                    onclick="confirmToggle(document.getElementById('toggleForm'), '{{ $jadwalPelajaran->is_active ? 'nonaktifkan' : 'aktifkan' }}')">
                    {{ $jadwalPelajaran->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </form>
            <a href="{{ route('admin.jadwal-pelajaran.edit', $jadwalPelajaran->id) }}" class="btn btn-edit">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.jadwal-pelajaran.destroy', $jadwalPelajaran->id) }}" method="POST" id="delForm" style="display:inline">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    Hapus
                </button>
            </form>
            <a href="{{ route('admin.jadwal-pelajaran.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    @if($stats['ada_sesi_aktif'])
    <div class="alert-box alert-success">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        Sudah ada sesi QR aktif hari ini untuk jadwal ini. Klik <strong style="margin:0 3px;">Lihat QR Aktif</strong> untuk mengaksesnya.
    </div>
    @elseif($jadwalPelajaran->isSedangBerlangsung() && $jadwalPelajaran->is_active)
    <div class="alert-box alert-warning">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Jadwal ini sedang berlangsung namun belum ada sesi QR hari ini. Klik <strong style="margin:0 3px;">Generate QR</strong> untuk memulai absensi.
    </div>
    @endif

    {{--
        FIX 1: Tetapkan $persen di sini, satu kali, agar bisa dipakai
        di stats strip DAN di progress bar tanpa risiko Undefined variable.
    --}}
    @php $persen = $stats['persen_kehadiran']; @endphp

    <div class="stats-strip">
        <div class="stat-card">
            <p class="stat-label">Total Pertemuan</p>
            {{-- FIX 2: Gunakan $stats['total_pertemuan'] dari controller (query count
                 sesungguhnya), bukan $jadwalPelajaran->sesiQr->count() yang dibatasi limit(10) --}}
            <p class="stat-val">{{ $stats['total_pertemuan'] }}</p>
            <p class="stat-sub">sesi QR tercatat</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Total Hadir</p>
            <p class="stat-val">{{ $stats['total_hadir'] }}</p>
            <p class="stat-sub">dari {{ $stats['total_absensi'] }} absensi</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Kehadiran Kelas</p>
            <p class="stat-val" style="color:{{ $persen >= 80 ? '#15803d' : ($persen >= 60 ? '#f97316' : '#dc2626') }};">
                {{ $persen }}%
            </p>
            <p class="stat-sub">rata-rata kehadiran</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Durasi / Sesi</p>
            <p class="stat-val">{{ $jadwalPelajaran->durasi_menit }}</p>
            <p class="stat-sub">menit per pertemuan</p>
        </div>
    </div>

    @if($stats['total_absensi'] > 0)
    @php
        $barColor = $persen >= 80 ? '#22c55e' : ($persen >= 60 ? '#f97316' : '#dc2626');
    @endphp
    <div class="kap-bar-wrap">
        <div class="kap-bar-hdr">
            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);">Tingkat Kehadiran Kelas</span>
            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);">
                {{ $stats['total_hadir'] }}/{{ $stats['total_absensi'] }} absensi ({{ $persen }}%)
            </span>
        </div>
        <div class="kap-bar-track">
            <div class="kap-bar-fill" style="width:{{ min(100, $persen) }}%;background:{{ $barColor }};"></div>
        </div>
    </div>
    @endif

    <div class="layout-2col">
        <div class="detail-card">
            <div class="detail-header">
                <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <p class="detail-header-title">Informasi Jadwal</p>
            </div>
            <div class="drow">
                <span class="dlabel">Hari & Jam</span>
                <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-top:2px;">
                    {{-- FIX 3: Tambah fallback class .hari-default agar tidak patah jika hari di luar 6 opsi --}}
                    <span class="hari-pill {{ in_array($jadwalPelajaran->hari, ['senin','selasa','rabu','kamis','jumat','sabtu']) ? 'hari-'.$jadwalPelajaran->hari : 'hari-default' }}">
                        {{ ucfirst($jadwalPelajaran->hari) }}
                    </span>
                    <span>
                        <span class="jam-display">{{ \Carbon\Carbon::parse($jadwalPelajaran->jam_mulai)->format('H:i') }}</span>
                        <span class="jam-sep">–</span>
                        <span class="jam-display">{{ \Carbon\Carbon::parse($jadwalPelajaran->jam_selesai)->format('H:i') }}</span>
                    </span>
                    <span style="font-size:12px;color:var(--text3);">({{ $jadwalPelajaran->durasi_menit }} menit)</span>
                </div>
            </div>
            <div class="drow">
                <span class="dlabel">Mata Pelajaran</span>
                <span class="dval" style="font-weight:700;">{{ optional($jadwalPelajaran->mataPelajaran)->nama_mapel ?? '—' }}</span>
            </div>
            <div class="drow">
                <span class="dlabel">Kelas</span>
                <span class="dval">
                    {{ optional($jadwalPelajaran->kelas)->nama_kelas ?? '—' }}
                    @if($jadwalPelajaran->kelas?->jurusan)
                        <span style="color:var(--text3);font-size:12px;"> — {{ $jadwalPelajaran->kelas->jurusan->nama }}</span>
                    @endif
                </span>
            </div>
            <div class="drow">
                <span class="dlabel">Ruang</span>
                <span class="dval">
                    @if($jadwalPelajaran->ruang)
                        {{ $jadwalPelajaran->ruang->nama_ruang }}
                        @if($jadwalPelajaran->ruang->gedung)
                            <span style="color:var(--text3);font-size:12px;"> — {{ $jadwalPelajaran->ruang->gedung->nama_gedung }}</span>
                        @endif
                    @else
                        —
                    @endif
                </span>
            </div>
            @if($jadwalPelajaran->pertemuan_ke)
            <div class="drow">
                <span class="dlabel">Pertemuan Ke</span>
                <span class="dval">{{ $jadwalPelajaran->pertemuan_ke }}</span>
            </div>
            @endif
            <div class="drow">
                <span class="dlabel">Status</span>
                <span class="dval">
                    @if($jadwalPelajaran->is_active)
                        <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                    @else
                        <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                    @endif
                </span>
            </div>
        </div>

        <div class="detail-card">
            <div class="detail-header">
                <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                <p class="detail-header-title">Guru & Tahun Ajaran</p>
            </div>
            <div class="drow">
                <span class="dlabel">Nama Guru</span>
                <span class="dval" style="font-weight:700;">{{ optional($jadwalPelajaran->guru)->nama_lengkap ?? '—' }}</span>
            </div>
            <div class="drow">
                <span class="dlabel">NIP</span>
                <span class="dval" style="color:var(--text2);">{{ optional($jadwalPelajaran->guru)->nip ?? '—' }}</span>
            </div>
            <div class="drow">
                <span class="dlabel">Tahun Ajaran</span>
                <span class="dval">{{ optional($jadwalPelajaran->tahunAjaran)->tahun ?? '—' }}</span>
            </div>
            <div class="drow">
                <span class="dlabel">Sumber Jadwal</span>
                <span class="dval" style="text-transform:capitalize;">{{ $jadwalPelajaran->sumber_jadwal ?? 'Manual' }}</span>
            </div>
            <div class="drow">
                <span class="dlabel">Dibuat</span>
                <span class="dval" style="color:var(--text2);">{{ $jadwalPelajaran->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="drow">
                <span class="dlabel">Terakhir Diperbarui</span>
                <span class="dval" style="color:var(--text2);">{{ $jadwalPelajaran->updated_at->format('d M Y, H:i') }}</span>
            </div>
        </div>
    </div>

    {{--
        FIX 4: Header tabel sekarang menampilkan total pertemuan sebenarnya
        ($stats['total_pertemuan']) dengan catatan "(10 terakhir ditampilkan)"
        jika ada lebih dari 10 sesi, agar tidak menyesatkan user.
    --}}
    <div class="detail-card">
        <div class="detail-header">
            <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="5" height="5"/><rect x="16" y="3" width="5" height="5"/><rect x="3" y="16" width="5" height="5"/><path d="M21 16h-3a2 2 0 0 0-2 2v3"/><path d="M21 21v.01"/></svg>
            <p class="detail-header-title">
                Riwayat Sesi QR
                <span class="detail-header-sub">
                    ({{ $stats['total_pertemuan'] }} total
                    @if($stats['total_pertemuan'] > 10)
                        — 10 terakhir ditampilkan
                    @endif
                    )
                </span>
            </p>
        </div>
        @if($jadwalPelajaran->sesiQr->count() > 0)
        <div style="overflow-x:auto;">
            <table class="sesi-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Berlaku Mulai</th>
                        <th>Berlaku Sampai</th>
                        <th>Total Hadir</th>
                        <th>Tidak Hadir</th>
                        <th>Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwalPelajaran->sesiQr as $i => $sesi)
                    @php
                        {{--
                            FIX 5 (UTAMA — N+1 killer): Hitung hadir/tidak-hadir dari
                            relasi yang SUDAH di-eager-load di controller, bukan dengan
                            memanggil $sesi->absensi()->whereIn(...)->count() per baris
                            (yang menyebabkan 2 query DB tambahan per iterasi loop).

                            Controller sudah eager-load:
                                'sesiQr' => fn($q) => $q->with([
                                    'absensi' => fn($qa) => $qa->select('id','sesi_qr_id','status'),
                                ])->latest()->limit(10),

                            Jadi kita cukup pakai $sesi->absensi (collection),
                            bukan $sesi->absensi() (query builder baru).
                        --}}
                        $hadirSesi   = $sesi->absensi->whereIn('status', ['hadir', 'telat'])->count();
                        $tidakHadir  = $sesi->absensi->whereNotIn('status', ['hadir', 'telat'])->count();
                    @endphp
                    <tr>
                        <td style="color:var(--text3);font-size:12px;">{{ $i + 1 }}</td>
                        <td style="font-weight:600;">{{ \Carbon\Carbon::parse($sesi->tanggal)->translatedFormat('d M Y') }}</td>
                        <td style="color:var(--text2);font-size:12.5px;">{{ $sesi->berlaku_mulai ? \Carbon\Carbon::parse($sesi->berlaku_mulai)->format('H:i') : '—' }}</td>
                        <td style="color:var(--text2);font-size:12.5px;">{{ $sesi->berlaku_sampai ? \Carbon\Carbon::parse($sesi->berlaku_sampai)->format('H:i') : '—' }}</td>
                        <td style="color:#15803d;font-weight:700;">{{ $hadirSesi }}</td>
                        <td style="color:{{ $tidakHadir > 0 ? '#dc2626' : 'var(--text3)' }};font-weight:{{ $tidakHadir > 0 ? '700' : '400' }};">{{ $tidakHadir }}</td>
                        <td>
                            @if($sesi->is_active)
                                <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                            @else
                                <span class="badge" style="background:#f1f5f9;color:#64748b;">Selesai</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            <a href="{{ route('admin.sesi-qr.show', $sesi->id) }}"
                               style="font-size:12px;color:var(--brand);font-weight:700;text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;">
                                Lihat
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <svg width="32" height="32" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 8px;display:block;"><rect x="3" y="3" width="5" height="5"/><rect x="16" y="3" width="5" height="5"/><rect x="3" y="16" width="5" height="5"/><path d="M21 16h-3a2 2 0 0 0-2 2v3"/></svg>
            Belum ada sesi QR untuk jadwal ini.
            @if($jadwalPelajaran->is_active)
                <br><a href="{{ route('admin.jadwal-pelajaran.generate-qr', $jadwalPelajaran->id) }}"
                       style="color:var(--brand);font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;">
                    Generate QR sekarang
                </a>
            @endif
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
    @endif
    @if(session('error'))
    Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
    @endif
    @if(session('info'))
    Swal.fire({icon:'info',title:'Info',text:@json(session('info')),confirmButtonColor:'#1f63db'});
    @endif

    function confirmDelete() {
        Swal.fire({
            title:'Hapus Jadwal?',
            text:'Jadwal ini akan dihapus permanen. Pastikan tidak ada sesi QR atau data absensi terkait.',
            icon:'warning',showCancelButton:true,
            confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal',
        }).then(r => { if(r.isConfirmed) document.getElementById('delForm').submit(); });
    }

    function confirmToggle(form, aksi) {
        Swal.fire({
            title:`${aksi.charAt(0).toUpperCase()+aksi.slice(1)} Jadwal?`,
            text:`Jadwal ini akan di${aksi}.`,
            icon:'question',showCancelButton:true,
            confirmButtonColor:'#1f63db',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Lanjutkan!',cancelButtonText:'Batal',
        }).then(r => { if(r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>