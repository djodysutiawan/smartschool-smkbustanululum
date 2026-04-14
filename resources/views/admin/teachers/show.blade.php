<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success', title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500, showConfirmButton: false,
            toast: true, position: 'top-end',
        });
    @endif
</script>

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
        --radius:     10px;
        --radius-sm:  7px;
    }

    /* ── Layout ── */
    .page { padding: 28px 28px 60px; max-width: 2000px; margin: 0 auto; }

    /* ── Breadcrumb ── */
    .breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600;
        color: var(--text3); margin-bottom: 20px;
    }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    /* ── Page header ── */
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .header-actions { display: flex; gap: 8px; flex-wrap: wrap; }

    /* ── Buttons ── */
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: filter .15s, background .15s; white-space: nowrap;
    }
    .btn-back { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-back:hover { background: var(--surface3); }
    .btn-edit { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover { background: var(--brand-100); }

    /* ── Alert ── */
    .alert-success {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px;
        font-size: 13.5px; font-family: 'DM Sans', sans-serif;
        background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;
    }

    /* ── Profile hero card ── */
    .profile-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 16px;
    }
    .profile-banner {
        height: 80px;
        background: linear-gradient(135deg, #1f63db 0%, #3582f0 50%, #60a5fa 100%);
    }
    .profile-body {
        padding: 0 24px 24px;
        display: flex; align-items: flex-end; gap: 20px; flex-wrap: wrap;
    }
    .profile-avatar-wrap {
        margin-top: -40px; flex-shrink: 0;
        width: 80px; height: 80px; border-radius: 16px;
        border: 3px solid #fff; overflow: hidden; background: var(--surface2);
        box-shadow: 0 4px 12px rgba(0,0,0,.12);
        display: flex; align-items: center; justify-content: center;
    }
    .profile-avatar-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .profile-initial {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 28px; font-weight: 800; color: var(--brand);
    }
    .profile-info { flex: 1; padding-top: 12px; min-width: 0; }
    .profile-name {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 20px; font-weight: 800; color: var(--text);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .profile-meta {
        display: flex; align-items: center; gap: 12px;
        flex-wrap: wrap; margin-top: 4px;
    }
    .profile-meta-item {
        display: flex; align-items: center; gap: 4px;
        font-size: 12.5px; color: var(--text3); font-family: 'DM Sans', sans-serif;
    }
    .profile-meta-item svg { flex-shrink: 0; }
    .profile-badges { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 10px; }

    /* ── Badges ── */
    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
    }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-aktif       { background: #dcfce7; color: #15803d; }
    .badge-aktif       .badge-dot { background: #15803d; }
    .badge-tidak_aktif { background: #fee2e2; color: #dc2626; }
    .badge-tidak_aktif .badge-dot { background: #dc2626; }
    .badge-kelas       { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .badge-gender-l    { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .badge-gender-p    { background: #fdf2f8; color: #9d174d; border: 1px solid #fbcfe8; }
    .badge-neutral     { background: var(--surface3); color: var(--text2); }

    /* ── Cards grid ── */
    .cards-grid        { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }

    .info-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }

    .card-header {
        display: flex; align-items: center; gap: 8px;
        padding: 14px 18px; border-bottom: 1px solid var(--border); background: var(--surface2);
    }
    .card-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px; font-weight: 700; color: var(--text3);
        letter-spacing: .07em; text-transform: uppercase;
    }
    .card-body    { padding: 18px; }
    .card-divider { border: none; border-top: 1px solid var(--border); margin: 16px 0; }

    /* ── Data rows ── */
    .data-grid        { display: grid; grid-template-columns: 1fr 1fr; gap: 14px 20px; }
    .data-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px; font-weight: 700; color: var(--text3);
        letter-spacing: .05em; text-transform: uppercase; margin-bottom: 3px;
    }
    .data-value { font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); font-weight: 500; }
    .data-value.empty { color: var(--text3); font-style: italic; }

    /* ── Classes list ── */
    .classes-list { display: flex; gap: 6px; flex-wrap: wrap; }

    /* ── Responsive ── */
    @media (max-width: 680px) {
        .page { padding: 16px 16px 40px; }
        .cards-grid { grid-template-columns: 1fr; }
        .data-grid  { grid-template-columns: 1fr; }
        .profile-body { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.teachers.index') }}">Manajemen Guru</a>
        <span class="sep">›</span>
        <span class="current">Detail Guru</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Guru</h1>
            <p class="page-sub">Informasi lengkap data guru</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit Data
            </a>
            <a href="{{ route('admin.teachers.index') }}" class="btn btn-back">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Profile hero --}}
    <div class="profile-card">
        <div class="profile-banner"></div>
        <div class="profile-body">
            <div class="profile-avatar-wrap">
                @if($teacher->foto)
                    <img src="{{ asset('storage/' . $teacher->foto) }}" alt="{{ $teacher->nama_lengkap }}">
                @else
                    <span class="profile-initial">{{ strtoupper(substr($teacher->nama_lengkap, 0, 1)) }}</span>
                @endif
            </div>
            <div class="profile-info">
                <p class="profile-name">{{ $teacher->nama_lengkap }}</p>
                <div class="profile-meta">
                    <span class="profile-meta-item">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="2" y="3" width="20" height="18" rx="2"/><path d="M8 10h8M8 14h5"/>
                        </svg>
                        NIP: <strong>{{ $teacher->nip }}</strong>
                    </span>
                    @if($teacher->user)
                        <span class="profile-meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            {{ $teacher->user->email }}
                        </span>
                    @endif
                    @if($teacher->no_hp)
                        <span class="profile-meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6.13 6.13l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            {{ $teacher->no_hp }}
                        </span>
                    @endif
                </div>
                <div class="profile-badges">
                    <span class="badge badge-{{ $teacher->status }}">
                        <span class="badge-dot"></span>
                        {{ $teacher->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                    <span class="badge {{ $teacher->jenis_kelamin === 'L' ? 'badge-gender-l' : 'badge-gender-p' }}">
                        {{ $teacher->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </span>
                    @if($teacher->agama)
                        <span class="badge badge-neutral">{{ $teacher->agama }}</span>
                    @endif
                    @if($teacher->classes && $teacher->classes->count())
                        @foreach($teacher->classes->take(3) as $class)
                            <span class="badge badge-kelas">{{ $class->nama_kelas }}</span>
                        @endforeach
                        @if($teacher->classes->count() > 3)
                            <span class="badge badge-neutral">+{{ $teacher->classes->count() - 3 }} kelas</span>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Row 1: Identitas + Akun & Kelas --}}
    <div class="cards-grid">

        {{-- Identitas --}}
        <div class="info-card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="2" y="3" width="20" height="18" rx="2"/><path d="M8 10h8M8 14h5"/>
                </svg>
                <p class="card-title">Identitas Guru</p>
            </div>
            <div class="card-body">
                <div class="data-grid">
                    <div class="data-item">
                        <p class="data-label">NIP</p>
                        <p class="data-value">{{ $teacher->nip }}</p>
                    </div>
                    <div class="data-item">
                        <p class="data-label">Jenis Kelamin</p>
                        <p class="data-value">{{ $teacher->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div class="data-item">
                        <p class="data-label">Tempat Lahir</p>
                        <p class="data-value {{ !$teacher->tempat_lahir ? 'empty' : '' }}">
                            {{ $teacher->tempat_lahir ?? '—' }}
                        </p>
                    </div>
                    <div class="data-item">
                        <p class="data-label">Tanggal Lahir</p>
                        <p class="data-value {{ !$teacher->tanggal_lahir ? 'empty' : '' }}">
                            {{ $teacher->tanggal_lahir
                                ? \Carbon\Carbon::parse($teacher->tanggal_lahir)->translatedFormat('d F Y')
                                : '—' }}
                        </p>
                    </div>
                    <div class="data-item">
                        <p class="data-label">Agama</p>
                        <p class="data-value {{ !$teacher->agama ? 'empty' : '' }}">
                            {{ $teacher->agama ?? '—' }}
                        </p>
                    </div>
                    <div class="data-item">
                        <p class="data-label">No. HP</p>
                        <p class="data-value {{ !$teacher->no_hp ? 'empty' : '' }}">
                            {{ $teacher->no_hp ?? '—' }}
                        </p>
                    </div>
                    <div class="data-item" style="grid-column:span 2">
                        <p class="data-label">Alamat</p>
                        <p class="data-value {{ !$teacher->alamat ? 'empty' : '' }}">
                            {{ $teacher->alamat ?? '—' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Akun + Kelas (stacked) --}}
        <div style="display:flex;flex-direction:column;gap:16px">

            {{-- Akun Login --}}
            <div class="info-card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                    <p class="card-title">Akun Login</p>
                </div>
                <div class="card-body">
                    <div class="data-grid">
                        <div class="data-item">
                            <p class="data-label">Nama User</p>
                            <p class="data-value {{ !$teacher->user ? 'empty' : '' }}">
                                {{ $teacher->user->name ?? '—' }}
                            </p>
                        </div>
                        <div class="data-item">
                            <p class="data-label">Email</p>
                            <p class="data-value {{ !$teacher->user ? 'empty' : '' }}">
                                {{ $teacher->user->email ?? '—' }}
                            </p>
                        </div>
                        <div class="data-item">
                            <p class="data-label">Status</p>
                            <span class="badge badge-{{ $teacher->status }}">
                                <span class="badge-dot"></span>
                                {{ $teacher->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kelas yang Diajar --}}
            <div class="info-card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3.33 1.67 8.67 1.67 12 0v-5"/>
                    </svg>
                    <p class="card-title">Kelas yang Diajar</p>
                </div>
                <div class="card-body">
                    @if($teacher->classes && $teacher->classes->count())
                        <div class="classes-list">
                            @foreach($teacher->classes as $class)
                                <span class="badge badge-kelas">{{ $class->nama_kelas }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="data-value empty">Belum ada kelas yang ditugaskan</p>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>{{-- /.page --}}

</x-app-layout>