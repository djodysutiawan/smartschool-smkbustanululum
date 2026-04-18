<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand:      #1f63db;
        --brand-h:    #3582f0;
        --brand-50:   #eef6ff;
        --brand-100:  #d9ebff;
        --brand-700:  #1750c0;
        --surface:    #fff;
        --surface2:   #f8fafc;
        --surface3:   #f1f5f9;
        --border:     #e2e8f0;
        --border2:    #cbd5e1;
        --text:       #0f172a;
        --text2:      #475569;
        --text3:      #94a3b8;
        --red:        #dc2626;
        --red-bg:     #fee2e2;
        --red-border: #fecaca;
        --radius:     10px;
        --radius-sm:  7px;
    }

    .page { padding: 28px 28px 60px; }

    .breadcrumb { display: flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600; color: var(--text3); margin-bottom: 20px; }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .header-actions { display: flex; gap: 8px; flex-wrap: wrap; }

    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s; white-space: nowrap; }
    .btn:hover { filter: brightness(.93); }
    .btn-back    { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-back:hover { background: var(--surface3); filter: none; }
    .btn-edit    { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover { background: var(--brand-100); filter: none; }
    .btn-danger  { background: #fff0f0; color: var(--red); border: 1px solid var(--red-border); }
    .btn-danger:hover { background: var(--red-bg); filter: none; }

    .layout-grid { display: grid; grid-template-columns: 280px 1fr; gap: 20px; align-items: start; }

    /* Profile card */
    .profile-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; position: sticky; top: 20px; }
    .profile-header { padding: 28px 24px 20px; text-align: center; border-bottom: 1px solid var(--border); background: var(--surface2); }
    .profile-avatar { width: 90px; height: 90px; border-radius: 18px; overflow: hidden; border: 3px solid var(--border); margin: 0 auto 14px; display: flex; align-items: center; justify-content: center; background: var(--brand-50); flex-shrink: 0; }
    .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .profile-avatar-initial { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 32px; font-weight: 800; color: var(--brand); }
    .profile-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 800; color: var(--text); margin-bottom: 4px; }
    .profile-nip  { font-size: 12.5px; color: var(--text3); margin-bottom: 10px; }

    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-aktif    { background: #dcfce7; color: #15803d; } .badge-aktif .badge-dot { background: #15803d; }
    .badge-cuti     { background: #fef9c3; color: #a16207; } .badge-cuti .badge-dot { background: #a16207; }
    .badge-nonaktif { background: var(--red-bg); color: var(--red); } .badge-nonaktif .badge-dot { background: var(--red); }

    .kepeg-pill { display: inline-block; padding: 3px 10px; border-radius: 5px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; }
    .kepeg-pns     { background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; }
    .kepeg-honorer { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .kepeg-kontrak { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }
    .kepeg-cpns    { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }

    .piket-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; background: #fdf4ff; color: #7c3aed; border: 1px solid #e9d5ff; }

    .profile-meta { padding: 16px 20px; }
    .meta-row { display: flex; align-items: flex-start; gap: 10px; padding: 10px 0; border-bottom: 1px solid var(--surface3); }
    .meta-row:last-child { border-bottom: none; }
    .meta-icon { color: var(--text3); flex-shrink: 0; margin-top: 1px; }
    .meta-key  { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .04em; }
    .meta-val  { font-size: 13px; color: var(--text); margin-top: 2px; }

    .profile-actions { padding: 16px 20px; border-top: 1px solid var(--border); display: flex; flex-direction: column; gap: 8px; }

    /* Stats bar */
    .stats-bar { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; margin-bottom: 16px; }
    .stat-mini { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 12px 16px; text-align: center; }
    .stat-mini-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .stat-mini-lbl { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 600; color: var(--text3); text-transform: uppercase; letter-spacing: .04em; margin-top: 2px; }

    /* Detail cards */
    .detail-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; margin-bottom: 16px; }
    .detail-card:last-child { margin-bottom: 0; }
    .detail-header { display: flex; align-items: center; gap: 8px; padding: 14px 20px; border-bottom: 1px solid var(--border); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .detail-header svg { color: var(--text3); }
    .detail-body { padding: 20px; }

    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .info-item { display: flex; flex-direction: column; gap: 4px; }
    .info-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .04em; }
    .info-val { font-size: 13.5px; color: var(--text); }
    .info-val.muted { color: var(--text3); }

    /* Jadwal table */
    .jadwal-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .jadwal-table thead tr { background: var(--surface2); }
    .jadwal-table th { padding: 9px 12px; text-align: left; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .05em; border-bottom: 1px solid var(--border); }
    .jadwal-table td { padding: 9px 12px; border-bottom: 1px solid #f1f5f9; color: var(--text); }
    .jadwal-table tr:last-child td { border-bottom: none; }

    .empty-box { text-align: center; padding: 28px 20px; color: var(--text3); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; }

    @media (max-width: 860px) {
        .layout-grid { grid-template-columns: 1fr; }
        .profile-card { position: static; }
        .info-grid { grid-template-columns: 1fr; }
        .stats-bar { grid-template-columns: 1fr 1fr; }
    }
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.guru.index') }}">Data Guru</a>
        <span class="sep">›</span>
        <span class="current">{{ $guru->nama_lengkap }}</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Guru</h1>
            <p class="page-sub">Informasi lengkap profil guru</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.guru.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.guru.edit', $guru->id) }}" class="btn btn-edit">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
        </div>
    </div>

    <div class="layout-grid">
        {{-- Sidebar --}}
        <div>
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        @if($guru->foto)
                            <img src="{{ asset('storage/'.$guru->foto) }}" alt="{{ $guru->nama_lengkap }}">
                        @else
                            <span class="profile-avatar-initial">{{ strtoupper(substr($guru->nama_lengkap, 0, 1)) }}</span>
                        @endif
                    </div>
                    <p class="profile-name">{{ $guru->nama_lengkap }}</p>
                    <p class="profile-nip">{{ $guru->nip ?? 'NIP tidak ada' }}</p>
                    <div style="display:flex;align-items:center;justify-content:center;gap:6px;flex-wrap:wrap">
                        <span class="kepeg-pill kepeg-{{ $guru->status_kepegawaian }}">{{ strtoupper($guru->status_kepegawaian) }}</span>
                        @if($guru->status === 'aktif')
                            <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                        @elseif($guru->status === 'cuti')
                            <span class="badge badge-cuti"><span class="badge-dot"></span>Cuti</span>
                        @else
                            <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                        @endif
                        @if($guru->adalah_guru_piket)
                            <span class="piket-badge">
                                <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                Piket
                            </span>
                        @endif
                    </div>
                </div>
                <div class="profile-meta">
                    <div class="meta-row">
                        <svg class="meta-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.6 3.4 2 2 0 0 1 3.57 1.22h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.9a16 16 0 0 0 6.29 6.29l.91-.91a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <div>
                            <p class="meta-key">No. HP</p>
                            <p class="meta-val">{{ $guru->no_hp ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="meta-row">
                        <svg class="meta-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <div>
                            <p class="meta-key">Email</p>
                            <p class="meta-val">{{ $guru->email ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="meta-row">
                        <svg class="meta-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <div>
                            <p class="meta-key">Tanggal Masuk</p>
                            <p class="meta-val">{{ $guru->tanggal_masuk ? \Carbon\Carbon::parse($guru->tanggal_masuk)->format('d M Y') : '-' }}</p>
                        </div>
                    </div>
                    @if($guru->pengguna)
                    <div class="meta-row">
                        <svg class="meta-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        <div>
                            <p class="meta-key">Akun Sistem</p>
                            <p class="meta-val">{{ $guru->pengguna->email }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="profile-actions">
                    <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" id="deleteForm">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-danger" style="width:100%;justify-content:center"
                            onclick="confirmDelete('{{ addslashes($guru->nama_lengkap) }}')">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                            Hapus Data Guru
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Main content --}}
        <div>
            {{-- Stats --}}
            <div class="stats-bar">
                <div class="stat-mini">
                    <p class="stat-mini-val">{{ $stats['total_kelas_wali'] }}</p>
                    <p class="stat-mini-lbl">Kelas Wali</p>
                </div>
                <div class="stat-mini">
                    <p class="stat-mini-val">{{ $stats['total_jadwal'] }}</p>
                    <p class="stat-mini-lbl">Jadwal Aktif</p>
                </div>
                <div class="stat-mini">
                    <p class="stat-mini-val">{{ $stats['total_ketersediaan'] }}</p>
                    <p class="stat-mini-lbl">Slot Tersedia</p>
                </div>
            </div>

            {{-- Informasi Pribadi --}}
            <div class="detail-card">
                <div class="detail-header">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="18" rx="2"/><path d="M8 10h8M8 14h5"/></svg>
                    Informasi Pribadi
                </div>
                <div class="detail-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Nama Lengkap</span>
                            <span class="info-val">{{ $guru->nama_lengkap }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">NIP</span>
                            <span class="info-val {{ $guru->nip ? '' : 'muted' }}">{{ $guru->nip ?? 'Tidak ada' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Jenis Kelamin</span>
                            <span class="info-val">{{ $guru->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tempat, Tanggal Lahir</span>
                            <span class="info-val {{ $guru->tempat_lahir ? '' : 'muted' }}">
                                {{ $guru->tempat_lahir ? $guru->tempat_lahir.', '.\Carbon\Carbon::parse($guru->tanggal_lahir)->format('d M Y') : 'Tidak diisi' }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">No. HP</span>
                            <span class="info-val {{ $guru->no_hp ? '' : 'muted' }}">{{ $guru->no_hp ?? 'Tidak diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-val {{ $guru->email ? '' : 'muted' }}">{{ $guru->email ?? 'Tidak diisi' }}</span>
                        </div>
                        <div class="info-item" style="grid-column:span 2">
                            <span class="info-label">Alamat</span>
                            <span class="info-val {{ $guru->alamat ? '' : 'muted' }}">{{ $guru->alamat ?? 'Tidak diisi' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pendidikan & Kepegawaian --}}
            <div class="detail-card">
                <div class="detail-header">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    Pendidikan & Kepegawaian
                </div>
                <div class="detail-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Pendidikan Terakhir</span>
                            <span class="info-val {{ $guru->pendidikan_terakhir ? '' : 'muted' }}">{{ $guru->pendidikan_terakhir ?? 'Tidak diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Jurusan</span>
                            <span class="info-val {{ $guru->jurusan_pendidikan ? '' : 'muted' }}">{{ $guru->jurusan_pendidikan ?? 'Tidak diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Universitas</span>
                            <span class="info-val {{ $guru->universitas ? '' : 'muted' }}">{{ $guru->universitas ?? 'Tidak diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tahun Lulus</span>
                            <span class="info-val {{ $guru->tahun_lulus ? '' : 'muted' }}">{{ $guru->tahun_lulus ?? 'Tidak diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status Kepegawaian</span>
                            <span class="info-val"><span class="kepeg-pill kepeg-{{ $guru->status_kepegawaian }}">{{ strtoupper($guru->status_kepegawaian) }}</span></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tanggal Masuk</span>
                            <span class="info-val {{ $guru->tanggal_masuk ? '' : 'muted' }}">{{ $guru->tanggal_masuk ? \Carbon\Carbon::parse($guru->tanggal_masuk)->format('d M Y') : 'Tidak diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status</span>
                            <span class="info-val">
                                @if($guru->status === 'aktif')
                                    <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                                @elseif($guru->status === 'cuti')
                                    <span class="badge badge-cuti"><span class="badge-dot"></span>Cuti</span>
                                @else
                                    <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                                @endif
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Guru Piket</span>
                            <span class="info-val">
                                @if($guru->adalah_guru_piket)
                                    <span class="piket-badge"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>Ya, Guru Piket</span>
                                @else
                                    <span style="color:var(--text3)">Tidak</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kelas Wali --}}
            <div class="detail-card">
                <div class="detail-header">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Kelas yang Diwali
                </div>
                <div class="detail-body" style="padding:0">
                    @if($guru->kelasWali && $guru->kelasWali->count())
                    <table class="jadwal-table">
                        <thead><tr><th>Nama Kelas</th><th>Tahun Ajaran</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($guru->kelasWali as $k)
                            <tr>
                                <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">{{ $k->nama_kelas }}</td>
                                <td style="color:var(--text3)">{{ $k->tahunAjaran->tahun ?? '-' }}</td>
                                <td><span class="badge {{ $k->status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}"><span class="badge-dot"></span>{{ ucfirst($k->status) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-box">
                        <svg width="24" height="24" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 8px;display:block"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        Belum menjadi wali kelas
                    </div>
                    @endif
                </div>
            </div>

            {{-- Jadwal Pelajaran --}}
            <div class="detail-card">
                <div class="detail-header">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Jadwal Mengajar Aktif
                </div>
                <div class="detail-body" style="padding:0">
                    @if($guru->jadwalPelajaran && $guru->jadwalPelajaran->count())
                    <table class="jadwal-table">
                        <thead><tr><th>Mata Pelajaran</th><th>Kelas</th><th>Hari</th><th>Jam</th></tr></thead>
                        <tbody>
                            @foreach($guru->jadwalPelajaran as $j)
                            <tr>
                                <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">{{ $j->mataPelajaran->nama_mapel ?? '-' }}</td>
                                <td>{{ $j->kelas->nama_kelas ?? '-' }}</td>
                                <td style="text-transform:capitalize;color:var(--text3)">{{ ucfirst($j->hari ?? '-') }}</td>
                                <td style="color:var(--text3)">{{ $j->jam_mulai ?? '-' }} – {{ $j->jam_selesai ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-box">
                        <svg width="24" height="24" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 8px;display:block"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Belum ada jadwal mengajar aktif
                    </div>
                    @endif
                </div>
            </div>
        </div>
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

    function confirmDelete(nama) {
        Swal.fire({
            title: 'Hapus Data Guru?',
            html: `Data guru <strong>${nama}</strong> akan dihapus permanen. Pastikan guru tidak memiliki jadwal aktif.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('deleteForm').submit(); });
    }
</script>
</x-app-layout>