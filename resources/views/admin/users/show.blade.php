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

    .breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600;
        color: var(--text3); margin-bottom: 20px;
    }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .header-actions { display: flex; gap: 8px; flex-wrap: wrap; }

    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: filter .15s; white-space: nowrap;
    }
    .btn:hover { filter: brightness(.93); }
    .btn-back   { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); padding: 8px 14px; font-size: 13px; }
    .btn-back:hover { background: var(--surface3); filter: none; }
    .btn-edit   { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover { background: var(--brand-100); filter: none; }
    .btn-danger { background: #fff0f0; color: var(--red); border: 1px solid var(--red-border); }
    .btn-danger:hover { background: var(--red-bg); filter: none; }
    .btn-warning{ background: #fefce8; color: #a16207; border: 1px solid #fde68a; }
    .btn-warning:hover { background: #fef9c3; filter: none; }
    .btn-success{ background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .btn-success:hover { background: #dcfce7; filter: none; }

    .layout-grid { display: grid; grid-template-columns: 280px 1fr; gap: 20px; align-items: start; }

    /* Profile Card */
    .profile-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; position: sticky; top: 20px;
    }
    .profile-header {
        padding: 28px 24px 20px; text-align: center;
        border-bottom: 1px solid var(--border); background: var(--surface2);
    }
    .profile-avatar {
        width: 90px; height: 90px; border-radius: 18px; overflow: hidden;
        border: 3px solid var(--border); margin: 0 auto 14px;
        display: flex; align-items: center; justify-content: center;
        background: var(--brand-50); flex-shrink: 0;
    }
    .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .profile-avatar-initial {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 32px;
        font-weight: 800; color: var(--brand);
    }
    .profile-name {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px;
        font-weight: 800; color: var(--text); margin-bottom: 4px;
    }
    .profile-email { font-size: 12.5px; color: var(--text3); margin-bottom: 10px; }

    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11.5px; font-weight: 700;
    }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-aktif    { background: #dcfce7; color: #15803d; }
    .badge-aktif    .badge-dot { background: #15803d; }
    .badge-nonaktif { background: var(--red-bg); color: var(--red); }
    .badge-nonaktif .badge-dot { background: var(--red); }

    .role-pill {
        display: inline-block; padding: 3px 10px; border-radius: 5px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
    }
    .role-admin       { background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; }
    .role-guru        { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .role-siswa       { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .role-orang_tua   { background: #fdf4ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .role-guru_piket  { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }

    .profile-meta { padding: 16px 20px; }
    .meta-row {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 10px 0; border-bottom: 1px solid var(--surface3);
    }
    .meta-row:last-child { border-bottom: none; }
    .meta-icon { color: var(--text3); flex-shrink: 0; margin-top: 1px; }
    .meta-key  { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .04em; }
    .meta-val  { font-size: 13px; color: var(--text); margin-top: 2px; }

    .profile-actions { padding: 16px 20px; border-top: 1px solid var(--border); display: flex; flex-direction: column; gap: 8px; }

    /* Detail Cards */
    .detail-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 16px;
    }
    .detail-card:last-child { margin-bottom: 0; }
    .detail-header {
        display: flex; align-items: center; gap: 8px;
        padding: 14px 20px; border-bottom: 1px solid var(--border);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text);
    }
    .detail-header svg { color: var(--text3); }
    .detail-body { padding: 20px; }

    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .info-item { display: flex; flex-direction: column; gap: 4px; }
    .info-label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px;
        font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .04em;
    }
    .info-val { font-size: 13.5px; color: var(--text); }
    .info-val.muted { color: var(--text3); }

    /* Reset password form */
    .pw-reset-form { display: flex; flex-direction: column; gap: 14px; }
    .pw-reset-form .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .field { display: flex; flex-direction: column; gap: 6px; }
    .field label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2); }
    .field label .req { color: var(--brand); margin-left: 2px; }
    .field input {
        height: 38px; padding: 0 12px;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif; font-size: 13.5px;
        color: var(--text); background: var(--surface2); width: 100%;
        outline: none; transition: border-color .15s;
    }
    .field input:focus { border-color: var(--brand-h); background: #fff; box-shadow: 0 0 0 3px rgba(53,130,240,.1); }
    .field-error { font-size: 12px; color: var(--red); }

    /* Notif list */
    .notif-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px; }
    .notif-item {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 10px 14px; border-radius: var(--radius-sm);
        background: var(--surface2); border: 1px solid var(--border);
    }
    .notif-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--brand); flex-shrink: 0; margin-top: 5px; }
    .notif-dot.read { background: var(--border2); }
    .notif-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .notif-time  { font-size: 12px; color: var(--text3); margin-top: 2px; }

    .empty-box {
        text-align: center; padding: 32px 20px; color: var(--text3);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600;
    }

    @media (max-width: 860px) {
        .layout-grid { grid-template-columns: 1fr; }
        .profile-card { position: static; }
        .info-grid { grid-template-columns: 1fr; }
        .pw-reset-form .form-row { grid-template-columns: 1fr; }
    }
</style>

<div class="page">

    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.users.index') }}">Manajemen Pengguna</a>
        <span class="sep">›</span>
        <span class="current">{{ $user->name }}</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Pengguna</h1>
            <p class="page-sub">Informasi lengkap akun pengguna</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.users.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-edit">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
        </div>
    </div>

    <div class="layout-grid">

        {{-- Profile Sidebar --}}
        <div>
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        @if($user->avatar)
                            <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}">
                        @else
                            <span class="profile-avatar-initial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <p class="profile-name">{{ $user->name }}</p>
                    <p class="profile-email">{{ $user->email }}</p>
                    <div style="display:flex;align-items:center;justify-content:center;gap:6px;flex-wrap:wrap">
                        <span class="role-pill role-{{ $user->role }}">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
                        @if($user->is_active)
                            <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                        @else
                            <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                        @endif
                    </div>
                </div>
                <div class="profile-meta">
                    <div class="meta-row">
                        <svg class="meta-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.6 3.4 2 2 0 0 1 3.57 1.22h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.9a16 16 0 0 0 6.29 6.29l.91-.91a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <div>
                            <p class="meta-key">No. HP</p>
                            <p class="meta-val">{{ $user->no_hp ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="meta-row">
                        <svg class="meta-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <div>
                            <p class="meta-key">Bergabung</p>
                            <p class="meta-val">{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="meta-row">
                        <svg class="meta-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <div>
                            <p class="meta-key">Login Terakhir</p>
                            <p class="meta-val">{{ $user->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                <div class="profile-actions">
                    {{-- Toggle Status --}}
                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" id="toggleForm">
                        @csrf @method('PATCH')
                        <button type="button" class="btn {{ $user->is_active ? 'btn-warning' : 'btn-success' }}" style="width:100%;justify-content:center"
                            onclick="confirmToggle()">
                            @if($user->is_active)
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                Nonaktifkan
                            @else
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                Aktifkan
                            @endif
                        </button>
                    </form>

                    {{-- Hapus --}}
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" id="deleteForm">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-danger" style="width:100%;justify-content:center"
                            onclick="confirmDelete('{{ addslashes($user->name) }}')">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                            Hapus Pengguna
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Detail Content --}}
        <div>
            {{-- Info Umum --}}
            <div class="detail-card">
                <div class="detail-header">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="18" rx="2"/><path d="M8 10h8M8 14h5"/></svg>
                    Informasi Akun
                </div>
                <div class="detail-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Nama Lengkap</span>
                            <span class="info-val">{{ $user->name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-val">{{ $user->email }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Role</span>
                            <span class="info-val">
                                <span class="role-pill role-{{ $user->role }}">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">No. HP</span>
                            <span class="info-val {{ $user->no_hp ? '' : 'muted' }}">{{ $user->no_hp ?? 'Tidak diisi' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status</span>
                            <span class="info-val">
                                @if($user->is_active)
                                    <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                                @else
                                    <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                                @endif
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Terdaftar</span>
                            <span class="info-val">{{ $user->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Reset Password --}}
            <div class="detail-card">
                <div class="detail-header">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Reset Password
                </div>
                <div class="detail-body">
                    <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" id="resetPwForm">
                        @csrf
                        <div class="pw-reset-form">
                            <div class="form-row">
                                <div class="field">
                                    <label>Password Baru <span class="req">*</span></label>
                                    <input type="password" name="password" id="newPw" placeholder="Min. 8 karakter, huruf besar & angka"
                                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                                    @error('password')<span class="field-error">{{ $message }}</span>@enderror
                                </div>
                                <div class="field">
                                    <label>Konfirmasi Password <span class="req">*</span></label>
                                    <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
                                </div>
                            </div>
                            <div style="display:flex;justify-content:flex-end">
                                <button type="button" class="btn btn-warning" onclick="confirmResetPw()">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Profil Terkait --}}
            @if($user->guru || $user->siswa || $user->orangTua)
            <div class="detail-card">
                <div class="detail-header">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Profil Terkait
                </div>
                <div class="detail-body">
                    @if($user->guru)
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Nama Guru</span>
                            <span class="info-val">{{ $user->guru->nama_lengkap }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">NIP</span>
                            <span class="info-val {{ $user->guru->nip ? '' : 'muted' }}">{{ $user->guru->nip ?? 'Tidak ada' }}</span>
                        </div>
                    </div>
                    @elseif($user->siswa)
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Nama Siswa</span>
                            <span class="info-val">{{ $user->siswa->nama_lengkap }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">NIS</span>
                            <span class="info-val">{{ $user->siswa->nis }}</span>
                        </div>
                    </div>
                    @elseif($user->orangTua)
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Nama Orang Tua</span>
                            <span class="info-val">{{ $user->orangTua->nama_lengkap }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">No. HP</span>
                            <span class="info-val">{{ $user->orangTua->no_hp }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Notifikasi --}}
            <div class="detail-card">
                <div class="detail-header">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    Notifikasi Terbaru
                </div>
                <div class="detail-body">
                    @if($user->notifikasi && $user->notifikasi->count())
                        <ul class="notif-list">
                            @foreach($user->notifikasi as $n)
                            <li class="notif-item">
                                <span class="notif-dot {{ $n->read_at ? 'read' : '' }}"></span>
                                <div>
                                    <p class="notif-title">{{ $n->data['message'] ?? $n->type }}</p>
                                    <p class="notif-time">{{ $n->created_at->diffForHumans() }}</p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="empty-box">
                            <svg width="28" height="28" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 8px;display:block"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                            Belum ada notifikasi
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
    @if($errors->has('password'))
    Swal.fire({ icon:'error', title:'Gagal Reset Password', text:@json($errors->first('password')), confirmButtonColor:'#1f63db' });
    @endif

    function confirmToggle() {
        const aktif = {{ $user->is_active ? 'true' : 'false' }};
        Swal.fire({
            title: aktif ? 'Nonaktifkan Pengguna?' : 'Aktifkan Pengguna?',
            text: aktif
                ? 'Pengguna tidak akan bisa login setelah dinonaktifkan.'
                : 'Pengguna akan bisa login kembali.',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: aktif ? '#dc2626' : '#1f63db',
            cancelButtonColor: '#64748b',
            confirmButtonText: aktif ? 'Ya, Nonaktifkan!' : 'Ya, Aktifkan!',
            cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('toggleForm').submit(); });
    }
    function confirmDelete(nama) {
        Swal.fire({
            title: 'Hapus Pengguna?',
            text: `Akun "${nama}" akan dihapus. Bisa dipulihkan dari halaman daftar.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('deleteForm').submit(); });
    }
    function confirmResetPw() {
        const pw = document.getElementById('newPw').value;
        if (!pw) {
            Swal.fire({ icon:'warning', title:'Password Kosong', text:'Isi password baru terlebih dahulu.', confirmButtonColor:'#1f63db' });
            return;
        }
        Swal.fire({
            title: 'Reset Password?',
            text: 'Password lama pengguna akan digantikan dan tidak bisa dikembalikan.',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#a16207', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Reset!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('resetPwForm').submit(); });
    }
</script>
</x-app-layout>