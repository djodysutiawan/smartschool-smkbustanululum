<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand:     #1f63db;
        --brand-50:  #eef6ff;
        --brand-100: #d9ebff;
        --brand-700: #1750c0;
        --surface:   #fff;
        --surface2:  #f8fafc;
        --surface3:  #f1f5f9;
        --border:    #e2e8f0;
        --border2:   #cbd5e1;
        --text:      #0f172a;
        --text2:     #475569;
        --text3:     #94a3b8;
        --red:       #dc2626;
        --red-bg:    #fee2e2;
        --radius:    10px;
        --radius-sm: 7px;
    }

    .page { padding: 28px 28px 60px; }
    .breadcrumb { display: flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600; color: var(--text3); margin-bottom: 20px; }
    .breadcrumb a { color: var(--text3); text-decoration: none; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }

    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s; white-space: nowrap; }
    .btn:hover { filter: brightness(.93); }
    .btn-back    { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-back:hover { background: var(--surface3); filter: none; }
    .btn-edit    { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover { background: var(--brand-100); filter: none; }
    .btn-del     { background: #fff0f0; color: var(--red); border: 1px solid #fecaca; }
    .btn-del:hover { background: var(--red-bg); filter: none; }
    .btn-pindah  { background: #fefce8; color: #a16207; border: 1px solid #fde68a; }
    .btn-pindah:hover { background: #fef9c3; filter: none; }
    .btn-primary { background: var(--brand); color: #fff; }

    .header-actions { display: flex; gap: 8px; flex-wrap: wrap; }

    .layout { display: grid; grid-template-columns: 280px 1fr; gap: 20px; align-items: start; }

    /* Profile card */
    .profile-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .profile-header { background: linear-gradient(135deg, #1f63db 0%, #3582f0 100%); padding: 24px 20px 20px; text-align: center; }
    .profile-avatar { width: 80px; height: 80px; border-radius: 16px; overflow: hidden; border: 3px solid rgba(255,255,255,.35); margin: 0 auto 12px; background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; }
    .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .profile-avatar-initial { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 28px; font-weight: 800; color: #fff; }
    .profile-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-weight: 800; color: #fff; margin-bottom: 4px; }
    .profile-nis  { font-size: 12.5px; color: rgba(255,255,255,.75); }
    .profile-body { padding: 16px 20px; }
    .profile-row { display: flex; align-items: flex-start; gap: 8px; padding: 8px 0; border-bottom: 1px solid var(--surface3); }
    .profile-row:last-child { border-bottom: none; }
    .profile-icon { width: 28px; height: 28px; border-radius: 7px; background: var(--surface2); display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
    .profile-key  { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .04em; }
    .profile-val  { font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text); margin-top: 1px; }

    /* Detail cards */
    .detail-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; margin-bottom: 16px; }
    .detail-header { display: flex; align-items: center; gap: 8px; padding: 14px 20px; border-bottom: 1px solid var(--border); background: var(--surface2); }
    .detail-header-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .detail-body { padding: 20px; }
    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .detail-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
    .detail-item { display: flex; flex-direction: column; gap: 3px; }
    .detail-key { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .05em; }
    .detail-val { font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); }
    .detail-val.muted { color: var(--text3); }

    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-aktif    { background: #dcfce7; color: #15803d; }
    .badge-aktif    .badge-dot { background: #15803d; }
    .badge-nonaktif { background: var(--red-bg); color: var(--red); }
    .badge-nonaktif .badge-dot { background: var(--red); }
    .badge-lulus    { background: #e0e7ff; color: #3730a3; }
    .badge-lulus    .badge-dot { background: #3730a3; }
    .badge-pindah   { background: #fef9c3; color: #a16207; }
    .badge-pindah   .badge-dot { background: #a16207; }
    .badge-keluar   { background: var(--red-bg); color: var(--red); }
    .badge-keluar   .badge-dot { background: var(--red); }

    .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 16px; }
    .stat-mini { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px 18px; }
    .stat-mini-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 24px; font-weight: 800; color: var(--text); }
    .stat-mini-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 600; color: var(--text3); margin-top: 2px; text-transform: uppercase; letter-spacing: .03em; }

    /* Absensi table */
    .mini-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .mini-table th { padding: 8px 12px; text-align: left; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .05em; background: var(--surface2); border-bottom: 1px solid var(--border); }
    .mini-table td { padding: 9px 12px; border-bottom: 1px solid var(--surface3); color: var(--text); vertical-align: middle; }
    .mini-table tr:last-child td { border-bottom: none; }
    .mini-table tr:hover td { background: #fafbff; }

    .status-hadir  { color: #15803d; font-weight: 700; }
    .status-sakit  { color: #d97706; font-weight: 700; }
    .status-izin   { color: #2563eb; font-weight: 700; }
    .status-alfa   { color: var(--red); font-weight: 700; }

    /* Pindah kelas modal */
    .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 999; display: flex; align-items: center; justify-content: center; opacity: 0; pointer-events: none; transition: opacity .2s; }
    .modal-overlay.show { opacity: 1; pointer-events: auto; }
    .modal-box { background: #fff; border-radius: var(--radius); padding: 28px; width: 100%; max-width: 400px; margin: 16px; box-shadow: 0 20px 60px rgba(0,0,0,.15); }
    .modal-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-weight: 800; color: var(--text); margin-bottom: 16px; }
    .modal-footer { display: flex; gap: 8px; justify-content: flex-end; margin-top: 20px; }

    @media (max-width: 768px) {
        .layout { grid-template-columns: 1fr; }
        .detail-grid, .detail-grid-3 { grid-template-columns: 1fr; }
        .stats-row { grid-template-columns: 1fr 1fr; }
    }
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.siswa.index') }}">Data Siswa</a>
        <span class="sep">›</span>
        <span class="current">Detail Siswa</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $siswa->nama_lengkap }}</h1>
            <p style="font-size:12.5px;color:var(--text3);margin-top:3px">NIS: {{ $siswa->nis }}{{ $siswa->nisn ? ' · NISN: '.$siswa->nisn : '' }}</p>
        </div>
        <div class="header-actions">
            <button type="button" class="btn btn-pindah" onclick="openPindahKelas()">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                Pindah Kelas
            </button>
            <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" id="deleteForm">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                    Hapus
                </button>
            </form>
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-back">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-mini">
            <p class="stat-mini-val" style="color:#1f63db">{{ number_format($stats['persentase_kehadiran'], 1) }}%</p>
            <p class="stat-mini-label">Kehadiran</p>
        </div>
        <div class="stat-mini">
            <p class="stat-mini-val" style="color:#dc2626">{{ $stats['total_poin_pelanggaran'] }}</p>
            <p class="stat-mini-label">Poin Pelanggaran</p>
        </div>
        <div class="stat-mini">
            <p class="stat-mini-val" style="color:#15803d">{{ $stats['total_nilai'] }}</p>
            <p class="stat-mini-label">Total Nilai</p>
        </div>
    </div>

    <div class="layout">
        {{-- Profile Sidebar --}}
        <div>
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        @if($siswa->foto)
                            <img src="{{ asset('storage/'.$siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}">
                        @else
                            <span class="profile-avatar-initial">{{ strtoupper(substr($siswa->nama_lengkap,0,1)) }}</span>
                        @endif
                    </div>
                    <p class="profile-name">{{ $siswa->nama_lengkap }}</p>
                    <p class="profile-nis">NIS: {{ $siswa->nis }}</p>
                </div>
                <div class="profile-body">
                    <div class="profile-row">
                        <div class="profile-icon">
                            <svg width="13" height="13" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                        </div>
                        <div>
                            <p class="profile-key">Kelas</p>
                            <p class="profile-val">{{ $siswa->kelas->nama_kelas ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="profile-row">
                        <div class="profile-icon">
                            <svg width="13" height="13" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div>
                            <p class="profile-key">Tahun Ajaran</p>
                            <p class="profile-val">{{ $siswa->kelas->tahunAjaran->tahun ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="profile-row">
                        <div class="profile-icon">
                            <svg width="13" height="13" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        </div>
                        <div>
                            <p class="profile-key">Status</p>
                            @php $st = $siswa->status; @endphp
                            <span class="badge badge-{{ $st == 'tidak_aktif' ? 'nonaktif' : $st }}">
                                <span class="badge-dot"></span>{{ ucfirst(str_replace('_',' ',$st)) }}
                            </span>
                        </div>
                    </div>
                    <div class="profile-row">
                        <div class="profile-icon">
                            <svg width="13" height="13" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <div>
                            <p class="profile-key">No. HP</p>
                            <p class="profile-val">{{ $siswa->no_hp ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="profile-row">
                        <div class="profile-icon">
                            <svg width="13" height="13" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <div>
                            <p class="profile-key">Email</p>
                            <p class="profile-val">{{ $siswa->email ?? '-' }}</p>
                        </div>
                    </div>
                    @if($siswa->pengguna)
                    <div class="profile-row">
                        <div class="profile-icon">
                            <svg width="13" height="13" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <div>
                            <p class="profile-key">Akun Login</p>
                            <p class="profile-val" style="font-size:12px">{{ $siswa->pengguna->email }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Detail Content --}}
        <div>
            {{-- Data Pribadi --}}
            <div class="detail-card">
                <div class="detail-header">
                    <svg width="15" height="15" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    <p class="detail-header-title">Data Pribadi</p>
                </div>
                <div class="detail-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-key">Jenis Kelamin</span>
                            <span class="detail-val">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-key">Tempat, Tanggal Lahir</span>
                            <span class="detail-val">
                                {{ $siswa->tempat_lahir ?? '-' }}{{ $siswa->tanggal_lahir ? ', '.date('d M Y', strtotime($siswa->tanggal_lahir)) : '' }}
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-key">Agama</span>
                            <span class="detail-val {{ !$siswa->agama ? 'muted' : '' }}">{{ $siswa->agama ?? '-' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-key">NISN</span>
                            <span class="detail-val {{ !$siswa->nisn ? 'muted' : '' }}">{{ $siswa->nisn ?? '-' }}</span>
                        </div>
                        <div class="detail-item" style="grid-column:span 2">
                            <span class="detail-key">Alamat</span>
                            <span class="detail-val {{ !$siswa->alamat ? 'muted' : '' }}">{{ $siswa->alamat ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Data Orang Tua --}}
            <div class="detail-card">
                <div class="detail-header">
                    <svg width="15" height="15" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <p class="detail-header-title">Data Orang Tua / Wali</p>
                </div>
                <div class="detail-body">
                    <div class="detail-grid-3" style="margin-bottom:16px">
                        <div class="detail-item"><span class="detail-key">Nama Ayah</span><span class="detail-val {{ !$siswa->nama_ayah ? 'muted' : '' }}">{{ $siswa->nama_ayah ?? '-' }}</span></div>
                        <div class="detail-item"><span class="detail-key">Pekerjaan Ayah</span><span class="detail-val {{ !$siswa->pekerjaan_ayah ? 'muted' : '' }}">{{ $siswa->pekerjaan_ayah ?? '-' }}</span></div>
                        <div class="detail-item"><span class="detail-key">No. HP Ayah</span><span class="detail-val {{ !$siswa->no_hp_ayah ? 'muted' : '' }}">{{ $siswa->no_hp_ayah ?? '-' }}</span></div>
                    </div>
                    <div class="detail-grid-3" style="margin-bottom:16px">
                        <div class="detail-item"><span class="detail-key">Nama Ibu</span><span class="detail-val {{ !$siswa->nama_ibu ? 'muted' : '' }}">{{ $siswa->nama_ibu ?? '-' }}</span></div>
                        <div class="detail-item"><span class="detail-key">Pekerjaan Ibu</span><span class="detail-val {{ !$siswa->pekerjaan_ibu ? 'muted' : '' }}">{{ $siswa->pekerjaan_ibu ?? '-' }}</span></div>
                        <div class="detail-item"><span class="detail-key">No. HP Ibu</span><span class="detail-val {{ !$siswa->no_hp_ibu ? 'muted' : '' }}">{{ $siswa->no_hp_ibu ?? '-' }}</span></div>
                    </div>
                    @if($siswa->nama_wali)
                    <div class="detail-grid-3">
                        <div class="detail-item"><span class="detail-key">Nama Wali</span><span class="detail-val">{{ $siswa->nama_wali }}</span></div>
                        <div class="detail-item"><span class="detail-key">Hubungan Wali</span><span class="detail-val {{ !$siswa->hubungan_wali ? 'muted' : '' }}">{{ $siswa->hubungan_wali ?? '-' }}</span></div>
                        <div class="detail-item"><span class="detail-key">No. HP Wali</span><span class="detail-val {{ !$siswa->no_hp_wali ? 'muted' : '' }}">{{ $siswa->no_hp_wali ?? '-' }}</span></div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Riwayat Absensi --}}
            <div class="detail-card">
                <div class="detail-header">
                    <svg width="15" height="15" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <p class="detail-header-title">Riwayat Absensi Terbaru</p>
                </div>
                <div style="overflow-x:auto">
                    <table class="mini-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Mata Pelajaran</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa->absensi as $a)
                            <tr>
                                <td>{{ date('d M Y', strtotime($a->tanggal)) }}</td>
                                <td>{{ $a->mataPelajaran->nama_mapel ?? '-' }}</td>
                                <td><span class="status-{{ $a->status }}">{{ ucfirst($a->status) }}</span></td>
                                <td style="color:var(--text3);font-size:12.5px">{{ $a->keterangan ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align:center;color:var(--text3);padding:24px">Belum ada data absensi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Nilai --}}
            <div class="detail-card">
                <div class="detail-header">
                    <svg width="15" height="15" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    <p class="detail-header-title">Nilai Mata Pelajaran</p>
                </div>
                <div style="overflow-x:auto">
                    <table class="mini-table">
                        <thead>
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>Tipe</th>
                                <th>Nilai</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa->nilai as $n)
                            <tr>
                                <td>{{ $n->mataPelajaran->nama_mapel ?? '-' }}</td>
                                <td style="font-size:12.5px;color:var(--text3)">{{ ucfirst($n->tipe_nilai ?? '-') }}</td>
                                <td><strong>{{ $n->nilai }}</strong></td>
                                <td style="color:var(--text3);font-size:12.5px">{{ $n->tanggal ? date('d M Y', strtotime($n->tanggal)) : '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align:center;color:var(--text3);padding:24px">Belum ada data nilai</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Pindah Kelas --}}
<div class="modal-overlay" id="modalPindah">
    <div class="modal-box">
        <p class="modal-title">Pindah Kelas Siswa</p>
        <form action="{{ route('admin.siswa.pindah-kelas', $siswa->id) }}" method="POST" id="pindahForm">
            @csrf @method('PATCH')
            <div class="field" style="margin-bottom:0">
                <label style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)">
                    Pilih Kelas Tujuan <span style="color:var(--brand)">*</span>
                </label>
                <select name="kelas_id" style="height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-size:13.5px;width:100%;margin-top:6px;background:var(--surface2)">
                    <option value="">— Pilih Kelas —</option>
                    @foreach(\App\Models\Kelas::aktif()->orderBy('nama_kelas')->get() as $k)
                        <option value="{{ $k->id }}" {{ $siswa->kelas_id == $k->id ? 'disabled' : '' }}>
                            {{ $k->nama_kelas }}{{ $siswa->kelas_id == $k->id ? ' (Kelas saat ini)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" style="background:var(--surface2);color:var(--text2);border:1px solid var(--border)" onclick="closePindahKelas()">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    Pindahkan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif

    function confirmDelete() {
        Swal.fire({
            title: 'Hapus Siswa?',
            text: 'Data "{{ addslashes($siswa->nama_lengkap) }}" akan dihapus (bisa dipulihkan).',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('deleteForm').submit(); });
    }
    function openPindahKelas()  { document.getElementById('modalPindah').classList.add('show'); }
    function closePindahKelas() { document.getElementById('modalPindah').classList.remove('show'); }
    document.getElementById('modalPindah').addEventListener('click', function(e) {
        if (e.target === this) closePindahKelas();
    });
</script>
</x-app-layout>