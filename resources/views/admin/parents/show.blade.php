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
        border: 3px solid #fff; overflow: hidden; background: var(--brand-50);
        box-shadow: 0 4px 12px rgba(0,0,0,.12);
        display: flex; align-items: center; justify-content: center;
    }
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
    .badge-student  { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .badge-hubungan { background: #f3e8ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .badge-neutral  { background: var(--surface3); color: var(--text2); }

    /* ── Cards grid ── */
    .cards-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }

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
    .card-badge {
        margin-left: auto;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
        color: var(--brand-700); background: var(--brand-50);
        border: 1px solid var(--brand-100); border-radius: 99px;
        padding: 2px 8px;
    }
    .card-body { padding: 18px; }

    /* ── Data rows ── */
    .data-grid        { display: grid; grid-template-columns: 1fr 1fr; gap: 14px 20px; }
    .data-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px; font-weight: 700; color: var(--text3);
        letter-spacing: .05em; text-transform: uppercase; margin-bottom: 3px;
    }
    .data-value { font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); font-weight: 500; }
    .data-value.empty { color: var(--text3); font-style: italic; }

    /* ── Students table ── */
    .students-table { width: 100%; border-collapse: collapse; }
    .students-table th {
        padding: 8px 12px; text-align: left;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px;
        font-weight: 700; color: var(--text3);
        letter-spacing: .06em; text-transform: uppercase;
        background: var(--surface2); border-bottom: 1px solid var(--border);
    }
    .students-table td {
        padding: 11px 12px;
        font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text);
        border-bottom: 1px solid var(--border);
    }
    .students-table tr:last-child td { border-bottom: none; }
    .students-table tr:hover td { background: var(--surface2); }
    .student-link {
        font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
        color: var(--text); text-decoration: none; font-size: 13.5px;
        transition: color .15s;
    }
    .student-link:hover { color: var(--brand); }
    .student-meta { font-size: 12px; color: var(--text3); margin-top: 1px; }
    .empty-state {
        display: flex; flex-direction: column; align-items: center;
        padding: 32px 16px; gap: 8px;
    }
    .empty-icon {
        width: 44px; height: 44px; border-radius: 12px;
        background: var(--surface3); display: flex; align-items: center; justify-content: center;
    }
    .empty-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--text2); }
    .empty-sub   { font-size: 12.5px; color: var(--text3); font-family: 'DM Sans', sans-serif; }

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
        <a href="{{ route('admin.parents.index') }}">Manajemen Orang Tua</a>
        <span class="sep">›</span>
        <span class="current">Detail Orang Tua</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Orang Tua</h1>
            <p class="page-sub">Informasi lengkap data orang tua / wali siswa</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.parents.edit', $parent->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit Data
            </a>
            <a href="{{ route('admin.parents.index') }}" class="btn btn-back">
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
                <span class="profile-initial">{{ strtoupper(substr($parent->nama_lengkap, 0, 1)) }}</span>
            </div>
            <div class="profile-info">
                <p class="profile-name">{{ $parent->nama_lengkap }}</p>
                <div class="profile-meta">
                    @if($parent->user)
                        <span class="profile-meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            {{ $parent->user->email }}
                        </span>
                    @endif
                    <span class="profile-meta-item">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6.13 6.13l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        {{ $parent->no_hp }}
                    </span>
                </div>
                <div class="profile-badges">
                    @if($parent->students->count())
                        <span class="badge badge-neutral">
                            {{ $parent->students->count() }} Siswa Terhubung
                        </span>
                        @foreach($parent->students as $student)
                            <span class="badge badge-student">
                                {{ $student->nama_lengkap }}
                                @if($student->pivot->hubungan)
                                    <span style="opacity:.6;font-weight:400">({{ $student->pivot->hubungan }})</span>
                                @endif
                            </span>
                        @endforeach
                    @else
                        <span class="badge badge-neutral" style="color:#dc2626;background:#fee2e2;border-color:#fecaca">
                            Belum terhubung ke siswa
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Row 1: Info + Akun --}}
    <div class="cards-grid">

        {{-- Informasi Pribadi --}}
        <div class="info-card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
                <p class="card-title">Informasi Pribadi</p>
            </div>
            <div class="card-body">
                <div class="data-grid">
                    <div class="data-item">
                        <p class="data-label">Nama Lengkap</p>
                        <p class="data-value">{{ $parent->nama_lengkap }}</p>
                    </div>
                    <div class="data-item">
                        <p class="data-label">No. HP</p>
                        <p class="data-value">{{ $parent->no_hp }}</p>
                    </div>
                    <div class="data-item" style="grid-column:span 2">
                        <p class="data-label">Alamat</p>
                        <p class="data-value {{ !$parent->alamat ? 'empty' : '' }}">
                            {{ $parent->alamat ?? '—' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Akun Login --}}
        <div class="info-card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <p class="card-title">Akun Login</p>
            </div>
            <div class="card-body">
                <div class="data-grid">
                    <div class="data-item">
                        <p class="data-label">Nama User</p>
                        <p class="data-value {{ !$parent->user ? 'empty' : '' }}">
                            {{ $parent->user->name ?? '—' }}
                        </p>
                    </div>
                    <div class="data-item">
                        <p class="data-label">Email</p>
                        <p class="data-value {{ !$parent->user ? 'empty' : '' }}">
                            {{ $parent->user->email ?? '—' }}
                        </p>
                    </div>
                    <div class="data-item">
                        <p class="data-label">Role</p>
                        <span class="badge" style="background:#f3e8ff;color:#7c3aed;border:1px solid #e9d5ff">
                            {{ $parent->user?->getRoleNames()->first() ?? 'parent' }}
                        </span>
                    </div>
                    <div class="data-item">
                        <p class="data-label">Terdaftar Sejak</p>
                        <p class="data-value {{ !$parent->user ? 'empty' : '' }}">
                            {{ $parent->user?->created_at?->translatedFormat('d F Y') ?? '—' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Row 2: Daftar Siswa --}}
    <div class="info-card">
        <div class="card-header">
            <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <p class="card-title">Siswa yang Dihubungkan</p>
            @if($parent->students->count())
                <span class="card-badge">{{ $parent->students->count() }} siswa</span>
            @endif
        </div>
        <div class="card-body" style="padding:0">
            @if($parent->students->count())
                <table class="students-table">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Hubungan</th>
                            <th>Kelas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($parent->students as $student)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.students.show', $student->id) }}" class="student-link">
                                        {{ $student->nama_lengkap }}
                                    </a>
                                    <p class="student-meta">NIS: {{ $student->nis }}</p>
                                </td>
                                <td>
                                    @if($student->pivot->hubungan)
                                        <span class="badge badge-hubungan">{{ $student->pivot->hubungan }}</span>
                                    @else
                                        <span style="color:var(--text3);font-style:italic;font-size:13px">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($student->class)
                                        <span class="badge badge-student">{{ $student->class->nama_kelas }}</span>
                                    @else
                                        <span style="color:var(--text3);font-style:italic;font-size:13px">—</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusMap = [
                                            'aktif'  => ['bg' => '#dcfce7', 'color' => '#15803d'],
                                            'lulus'  => ['bg' => '#dbeafe', 'color' => '#1d4ed8'],
                                            'pindah' => ['bg' => '#fef9c3', 'color' => '#a16207'],
                                        ];
                                        $s = $statusMap[$student->status] ?? ['bg' => '#f1f5f9', 'color' => '#475569'];
                                    @endphp
                                    <span class="badge" style="background:{{ $s['bg'] }};color:{{ $s['color'] }}">
                                        {{ match($student->status) {
                                            'aktif'  => 'Aktif',
                                            'lulus'  => 'Lulus',
                                            'pindah' => 'Pindah',
                                            default  => ucfirst($student->status)
                                        } }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="20" height="20" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                        </svg>
                    </div>
                    <p class="empty-title">Belum ada siswa terhubung</p>
                    <p class="empty-sub">Klik Edit Data untuk menghubungkan orang tua ini ke siswa</p>
                </div>
            @endif
        </div>
    </div>

</div>{{-- /.page --}}

</x-app-layout>