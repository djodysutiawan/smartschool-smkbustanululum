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
        --danger:     #dc2626;
        --danger-50:  #fee2e2;
        --danger-100: #fecaca;
    }

    /* ── Layout ── */
    .page { padding: 28px 28px 60px; max-width: 860px; margin: 0 auto; }

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
        transition: background .15s; white-space: nowrap;
    }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { background: var(--brand-h); }
    .btn-ghost   { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }
    .btn-edit    { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover { background: var(--brand-100); }
    .btn-danger  { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }
    .btn-danger:hover { background: var(--danger-100); }

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
    .profile-badges { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 10px; }

    /* ── Badges ── */
    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
    }
    .badge-aktif    { background: #dcfce7; color: #15803d; }
    .badge-nonaktif { background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100); }

    /* ── Day badge ── */
    .day-badge {
        display: inline-flex; align-items: center;
        padding: 4px 14px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
    }
    .day-Senin  { background: #dbeafe; color: #1d4ed8; }
    .day-Selasa { background: #dcfce7; color: #15803d; }
    .day-Rabu   { background: #fef9c3; color: #a16207; }
    .day-Kamis  { background: #ffedd5; color: #c2410c; }
    .day-Jumat  { background: #f3e8ff; color: #7c3aed; }
    .day-Sabtu  { background: #fce7f3; color: #be185d; }

    /* ── Cards ── */
    .info-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; margin-bottom: 16px; }
    .card-header {
        display: flex; align-items: center; gap: 8px;
        padding: 14px 18px; border-bottom: 1px solid var(--border); background: var(--surface2);
    }
    .card-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px; font-weight: 700; color: var(--text3);
        letter-spacing: .07em; text-transform: uppercase;
    }
    .card-body { padding: 20px 22px; }

    /* ── Data grid ── */
    .data-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px 24px; }
    .data-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px; font-weight: 700; color: var(--text3);
        letter-spacing: .05em; text-transform: uppercase; margin-bottom: 4px;
    }
    .data-value { font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); font-weight: 500; }
    .data-value.empty { color: var(--text3); font-style: italic; }

    /* ── Jadwal visual block ── */
    .jadwal-visual {
        display: flex; align-items: center; gap: 0;
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); overflow: hidden; margin-bottom: 20px;
    }
    .jadwal-segment {
        flex: 1; display: flex; flex-direction: column; align-items: center;
        padding: 16px 12px; gap: 4px;
    }
    .jadwal-segment-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10.5px; font-weight: 700; color: var(--text3);
        letter-spacing: .07em; text-transform: uppercase;
    }
    .jadwal-segment-time {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 22px; font-weight: 800; color: var(--text);
    }
    .jadwal-divider {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 4px; padding: 0 12px;
    }
    .jadwal-arrow { color: var(--text3); font-size: 18px; }
    .jadwal-duration {
        background: var(--brand); color: #fff;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
        padding: 3px 9px; border-radius: 99px;
    }
    .jadwal-day-wrap {
        display: flex; align-items: center; justify-content: center;
        padding: 16px 20px; border-left: 1px solid var(--border);
        flex-direction: column; gap: 6px;
    }
    .jadwal-day-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10.5px; font-weight: 700; color: var(--text3);
        letter-spacing: .07em; text-transform: uppercase;
    }

    /* ── Akun guru section ── */
    .akun-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px 24px; }

    /* ── Meta timestamps ── */
    .meta-row {
        display: flex; gap: 20px; flex-wrap: wrap;
        padding: 12px 22px; border-top: 1px solid var(--border);
        background: var(--surface2);
    }
    .meta-item { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); }
    .meta-item span { color: var(--text2); font-weight: 500; }

    /* ── Responsive ── */
    @media (max-width: 600px) {
        .page { padding: 16px 16px 40px; }
        .data-grid { grid-template-columns: 1fr; }
        .akun-grid { grid-template-columns: 1fr; }
        .jadwal-visual { flex-direction: column; }
        .jadwal-day-wrap { border-left: none; border-top: 1px solid var(--border); width: 100%; }
        .profile-body { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.piket-teachers.index') }}">Guru Piket</a>
        <span class="sep">›</span>
        <span class="current">Detail Jadwal</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Jadwal Piket</h1>
            <p class="page-sub">Informasi lengkap jadwal dan data guru piket</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.piket-teachers.edit', $piketTeacher->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit
            </a>
            <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6m4-6v6M9 6V4h6v2"/>
                </svg>
                Hapus
            </button>
            <a href="{{ route('admin.piket-teachers.index') }}" class="btn btn-ghost">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Hidden delete form --}}
    <form id="deleteForm" method="POST" action="{{ route('admin.piket-teachers.destroy', $piketTeacher->id) }}" style="display:none">
        @csrf @method('DELETE')
    </form>

    {{-- Profile hero --}}
    <div class="profile-card">
        <div class="profile-banner"></div>
        <div class="profile-body">
            <div class="profile-avatar-wrap">
                @if($piketTeacher->teacher?->foto)
                    <img src="{{ asset('storage/' . $piketTeacher->teacher->foto) }}" alt="">
                @else
                    <span class="profile-initial">
                        {{ strtoupper(substr($piketTeacher->teacher?->nama_lengkap ?? '?', 0, 1)) }}
                    </span>
                @endif
            </div>
            <div class="profile-info">
                <p class="profile-name">{{ $piketTeacher->teacher?->nama_lengkap ?? '—' }}</p>
                <div class="profile-meta">
                    <span class="profile-meta-item">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        NIP: {{ $piketTeacher->teacher?->nip ?? '—' }}
                    </span>
                    @if($piketTeacher->teacher?->no_hp)
                        <span class="profile-meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6.13 6.13l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            {{ $piketTeacher->teacher->no_hp }}
                        </span>
                    @endif
                    @if($piketTeacher->teacher?->user?->email)
                        <span class="profile-meta-item">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            {{ $piketTeacher->teacher->user->email }}
                        </span>
                    @endif
                </div>
                <div class="profile-badges">
                    <span class="day-badge day-{{ $piketTeacher->hari }}">{{ $piketTeacher->hari }}</span>
                    @if($piketTeacher->teacher?->status === 'aktif')
                        <span class="badge badge-aktif">Guru Aktif</span>
                    @else
                        <span class="badge badge-nonaktif">Guru Non-aktif</span>
                    @endif
                    @if($piketTeacher->teacher?->pendidikan_terakhir)
                        <span class="badge" style="background:var(--surface3);color:var(--text2)">
                            {{ $piketTeacher->teacher->pendidikan_terakhir }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Jadwal Visual --}}
    <div class="info-card">
        <div class="card-header">
            <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
            <p class="card-title">Jadwal Piket</p>
        </div>
        <div class="card-body">
            @php
                $mulai   = \Carbon\Carbon::createFromFormat('H:i:s', $piketTeacher->jam_mulai);
                $selesai = \Carbon\Carbon::createFromFormat('H:i:s', $piketTeacher->jam_selesai);
                $durMenit = $mulai->diffInMinutes($selesai);
                $durJam   = intdiv($durMenit, 60);
                $durSisa  = $durMenit % 60;
                $durStr   = ($durJam > 0 ? $durJam . ' jam ' : '') . ($durSisa > 0 ? $durSisa . ' menit' : '');
            @endphp

            <div class="jadwal-visual">
                <div class="jadwal-segment">
                    <p class="jadwal-segment-label">Mulai</p>
                    <p class="jadwal-segment-time">{{ $mulai->format('H:i') }}</p>
                </div>
                <div class="jadwal-divider">
                    <span class="jadwal-arrow">→</span>
                    <span class="jadwal-duration">{{ $durStr }}</span>
                </div>
                <div class="jadwal-segment">
                    <p class="jadwal-segment-label">Selesai</p>
                    <p class="jadwal-segment-time">{{ $selesai->format('H:i') }}</p>
                </div>
                <div class="jadwal-day-wrap">
                    <p class="jadwal-day-label">Hari</p>
                    <span class="day-badge day-{{ $piketTeacher->hari }}">{{ $piketTeacher->hari }}</span>
                </div>
            </div>

            {{-- Data grid detail --}}
            <div class="data-grid">
                <div>
                    <p class="data-label">Jam Mulai</p>
                    <p class="data-value">{{ $mulai->format('H:i') }} WIB</p>
                </div>
                <div>
                    <p class="data-label">Jam Selesai</p>
                    <p class="data-value">{{ $selesai->format('H:i') }} WIB</p>
                </div>
                <div>
                    <p class="data-label">Durasi</p>
                    <p class="data-value">{{ $durStr }}</p>
                </div>
                <div>
                    <p class="data-label">Hari Piket</p>
                    <span class="day-badge day-{{ $piketTeacher->hari }}" style="font-size:12px;padding:3px 10px">
                        {{ $piketTeacher->hari }}
                    </span>
                </div>
            </div>
        </div>
        <div class="meta-row">
            <p class="meta-item">Dibuat: <span>{{ $piketTeacher->created_at?->translatedFormat('d F Y, H:i') ?? '—' }}</span></p>
            <p class="meta-item">Diperbarui: <span>{{ $piketTeacher->updated_at?->translatedFormat('d F Y, H:i') ?? '—' }}</span></p>
        </div>
    </div>

    {{-- Info Guru --}}
    <div class="info-card">
        <div class="card-header">
            <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
            </svg>
            <p class="card-title">Informasi Guru</p>
        </div>
        <div class="card-body">
            <div class="data-grid">
                <div>
                    <p class="data-label">Nama Lengkap</p>
                    <p class="data-value">{{ $piketTeacher->teacher?->nama_lengkap ?? '—' }}</p>
                </div>
                <div>
                    <p class="data-label">NIP</p>
                    <p class="data-value">{{ $piketTeacher->teacher?->nip ?? '—' }}</p>
                </div>
                <div>
                    <p class="data-label">Jenis Kelamin</p>
                    <p class="data-value">
                        @php
                            $jk = $piketTeacher->teacher?->jenis_kelamin;
                        @endphp
                        {{ $jk === 'L' ? 'Laki-laki' : ($jk === 'P' ? 'Perempuan' : '—') }}
                    </p>
                </div>
                <div>
                    <p class="data-label">No. HP</p>
                    <p class="data-value {{ !$piketTeacher->teacher?->no_hp ? 'empty' : '' }}">
                        {{ $piketTeacher->teacher?->no_hp ?? '—' }}
                    </p>
                </div>
                <div>
                    <p class="data-label">Pendidikan Terakhir</p>
                    <p class="data-value {{ !$piketTeacher->teacher?->pendidikan_terakhir ? 'empty' : '' }}">
                        {{ $piketTeacher->teacher?->pendidikan_terakhir ?? '—' }}
                    </p>
                </div>
                <div>
                    <p class="data-label">Status</p>
                    @if($piketTeacher->teacher?->status === 'aktif')
                        <span class="badge badge-aktif">Aktif</span>
                    @else
                        <span class="badge badge-nonaktif">Non-aktif</span>
                    @endif
                </div>
                <div style="grid-column:span 2">
                    <p class="data-label">Alamat</p>
                    <p class="data-value {{ !$piketTeacher->teacher?->alamat ? 'empty' : '' }}">
                        {{ $piketTeacher->teacher?->alamat ?? '—' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Akun Login --}}
    @if($piketTeacher->teacher?->user)
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
                <div>
                    <p class="data-label">Nama User</p>
                    <p class="data-value">{{ $piketTeacher->teacher->user->name }}</p>
                </div>
                <div>
                    <p class="data-label">Email</p>
                    <p class="data-value">{{ $piketTeacher->teacher->user->email }}</p>
                </div>
                <div>
                    <p class="data-label">Role</p>
                    <span class="badge" style="background:#f3e8ff;color:#7c3aed;border:1px solid #e9d5ff">
                        {{ $piketTeacher->teacher->user->getRoleNames()->first() ?? 'teacher' }}
                    </span>
                </div>
                <div>
                    <p class="data-label">Terdaftar Sejak</p>
                    <p class="data-value">
                        {{ $piketTeacher->teacher->user->created_at?->translatedFormat('d F Y') ?? '—' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Hapus Jadwal?',
            html: `Jadwal piket <b>{{ addslashes($piketTeacher->teacher?->nama_lengkap) }}</b> hari <b>{{ $piketTeacher->hari }}</b> akan dihapus permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
        }).then(result => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm').submit();
            }
        });
    }
</script>

</x-app-layout>