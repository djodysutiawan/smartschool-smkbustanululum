<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{
        --brand:#1f63db;--brand-h:#3582f0;--brand-700:#1750c0;--brand-50:#eef6ff;--brand-100:#d9ebff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:28px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}

    /* Profile hero */
    .profile-hero{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:20px;}
    .hero-cover{
        height:130px;
        background:linear-gradient(135deg,#1750c0 0%,#1f63db 40%,#3582f0 70%,#7c3aed 100%);
        position:relative;
    }
    .hero-cover-pattern{
        position:absolute;inset:0;
        background-image:radial-gradient(circle at 20% 50%, rgba(255,255,255,.08) 0%, transparent 50%),
                         radial-gradient(circle at 80% 20%, rgba(255,255,255,.06) 0%, transparent 40%);
    }
    .hero-avatar-row{
        padding:0 28px;
        display:flex;
        align-items:flex-end;
        gap:18px;
        margin-top:-44px;
        position:relative;
        z-index:2;
    }
    .avatar-img{
        width:88px;height:88px;
        border-radius:50%;
        border:4px solid #fff;
        object-fit:cover;
        background:var(--surface2);
        flex-shrink:0;
        box-shadow:0 4px 14px rgba(0,0,0,.12);
    }
    .avatar-placeholder{
        width:88px;height:88px;
        border-radius:50%;
        border:4px solid #fff;
        background:linear-gradient(135deg,#dbeafe,#bfdbfe);
        display:flex;align-items:center;justify-content:center;
        flex-shrink:0;
        box-shadow:0 4px 14px rgba(0,0,0,.12);
    }
    .avatar-placeholder span{font-family:'Plus Jakarta Sans',sans-serif;font-size:30px;font-weight:800;color:#1d4ed8;}
    .hero-info-body{
        padding:0 28px 20px;
        margin-top:12px;
    }
    .hero-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:19px;font-weight:800;color:var(--text);line-height:1.2;}
    .hero-meta{font-size:12.5px;color:var(--text3);margin-top:4px;display:flex;align-items:center;gap:8px;flex-wrap:wrap;}
    .hero-meta-sep{width:3px;height:3px;border-radius:50%;background:var(--border2);}
    .hero-badges{display:flex;gap:6px;margin-top:10px;flex-wrap:wrap;}
    .hero-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;}
    .badge-active{background:#dcfce7;color:#15803d;}
    .badge-role{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}
    .hero-divider{height:1px;background:var(--border);margin:0 28px;}
    .hero-stats{display:flex;gap:0;padding:0 28px;}
    .hero-stat{padding:14px 20px 14px 0;display:flex;flex-direction:column;gap:2px;border-right:1px solid var(--border);margin-right:20px;}
    .hero-stat:last-child{border-right:none;}
    .hero-stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;}
    .hero-stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text);}

    /* Section cards */
    .section-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px;}
    .section-header{padding:16px 24px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px;}
    .section-icon{width:32px;height:32px;border-radius:8px;background:var(--brand-50);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .section-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);}
    .section-sub{font-size:12px;color:var(--text3);margin-top:1px;}
    .section-body{padding:22px 24px;}
    .section-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:14px 24px;background:var(--surface2);border-top:1px solid var(--border);}

    /* Form */
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .col-span-2{grid-column:span 2;}
    .field{display:flex;flex-direction:column;gap:6px;}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);}
    .field label .req{color:var(--red);margin-left:2px;}
    .field input,.field select,.field textarea{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none;transition:border-color .15s;box-sizing:border-box;}
    .field input:focus,.field select:focus{border-color:var(--brand-h);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1);}
    .field input.is-invalid{border-color:var(--red);background:#fff8f8;}
    .field-error{font-size:12px;color:var(--red);font-family:'DM Sans',sans-serif;}
    .field-hint{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;}

    /* Avatar upload */
    .avatar-upload-row{display:flex;align-items:center;gap:16px;padding:14px 0;}
    .avatar-current{width:64px;height:64px;border-radius:50%;object-fit:cover;border:2px solid var(--border);flex-shrink:0;}
    .avatar-current-placeholder{width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,var(--brand-50),var(--brand-100));display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid var(--border);}
    .avatar-current-placeholder span{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--brand);}
    .avatar-upload-btn{display:inline-flex;align-items:center;gap:7px;padding:8px 16px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);background:var(--surface2);cursor:pointer;transition:background .15s;}
    .avatar-upload-btn:hover{background:var(--surface3);}
    #avatarInput{display:none;}

    /* Btn */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand);color:#fff;}
    .btn-primary:disabled{opacity:.6;cursor:not-allowed;filter:none;}
    .btn-cancel{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
    .btn-danger{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border);}

    /* Success toast */
    .toast-success{display:flex;align-items:center;gap:10px;padding:12px 16px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:#15803d;margin-bottom:16px;}

    /* Delete zone */
    .danger-zone{background:var(--surface);border:1.5px solid var(--red-border);border-radius:var(--radius);overflow:hidden;}
    .danger-header{padding:16px 24px;border-bottom:1px solid var(--red-border);background:#fff8f8;display:flex;align-items:center;gap:8px;}
    .danger-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--red);}
    .danger-body{padding:20px 24px;}
    .danger-desc{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text2);line-height:1.6;margin-bottom:16px;}

    /* Modal */
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.5);z-index:999;align-items:center;justify-content:center;}
    .modal-overlay.open{display:flex;}
    .modal{background:#fff;border-radius:var(--radius);width:100%;max-width:460px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.2);}
    .modal-header{padding:18px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
    .modal-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text);}
    .modal-close{background:none;border:none;cursor:pointer;color:var(--text3);}
    .modal-body{padding:22px;}
    .modal-footer{padding:14px 22px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;gap:8px;}

    /* Password strength */
    .strength-bar{height:4px;border-radius:2px;background:var(--surface3);margin-top:6px;overflow:hidden;}
    .strength-fill{height:100%;border-radius:2px;transition:width .3s,background .3s;}

    @media(max-width:680px){
        .page{padding:16px;}
        .form-grid{grid-template-columns:1fr;}
        .col-span-2{grid-column:span 1;}
        .hero-avatar-row{padding:0 16px;}
        .hero-info-body{padding:0 16px 18px;}
        .hero-stats{padding:0 16px;flex-wrap:wrap;gap:12px;}
        .hero-stat{border-right:none;padding:10px 0 0;margin-right:0;}
        .hero-divider{margin:0 16px;}
    }
    @keyframes spin{to{transform:rotate(360deg);}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Profil Saya</h1>
            <p class="page-sub">Kelola informasi akun, foto profil, dan keamanan akun Anda</p>
        </div>
    </div>

    @if(session('status') === 'profile-updated')
        <div class="toast-success">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            Profil berhasil diperbarui.
        </div>
    @endif
    @if(session('status') === 'password-updated')
        <div class="toast-success">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            Password berhasil diperbarui.
        </div>
    @endif

    {{-- Hero Card --}}
    <div class="profile-hero">
        <div class="hero-cover">
            <div class="hero-cover-pattern"></div>
        </div>

        <div class="hero-avatar-row">
            @if($user->avatar)
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="avatar-img">
            @else
                <div class="avatar-placeholder">
                    <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                </div>
            @endif
        </div>

        <div class="hero-info-body">
            <p class="hero-name">{{ $user->name }}</p>
            <div class="hero-meta">
                <span>{{ $user->email }}</span>
                @if($user->no_hp)
                    <span class="hero-meta-sep"></span>
                    <span>{{ $user->no_hp }}</span>
                @endif
            </div>
            <div class="hero-badges">
                <span class="hero-badge badge-role">
                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                </span>
                @if($user->is_active)
                    <span class="hero-badge badge-active">✓ Aktif</span>
                @endif
                @if($user->last_login_at)
                    <span style="font-size:11.5px;color:var(--text3);display:inline-flex;align-items:center;gap:4px">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Login terakhir: {{ $user->last_login_at->diffForHumans() }}
                    </span>
                @endif
            </div>
        </div>

        @php
            $statItems = [];
            if ($user->guru) {
                $statItems[] = ['label' => 'NIP', 'val' => $user->guru->nip ?? '—'];
                $statItems[] = ['label' => 'Status', 'val' => $user->guru->label_status_kepegawaian ?? '—'];
            } elseif ($user->siswa) {
                $statItems[] = ['label' => 'NIS', 'val' => $user->siswa->nis ?? '—'];
                $statItems[] = ['label' => 'Kelas', 'val' => $user->siswa->kelas->nama_kelas ?? '—'];
                $statItems[] = ['label' => 'Status', 'val' => $user->siswa->label_status ?? '—'];
            } elseif ($user->orangTua) {
                $statItems[] = ['label' => 'Pekerjaan', 'val' => $user->orangTua->pekerjaan ?? '—'];
                $statItems[] = ['label' => 'Jumlah Anak', 'val' => $user->orangTua->siswa->count() . ' siswa'];
            }
            $statItems[] = ['label' => 'Bergabung', 'val' => $user->created_at->format('M Y')];
        @endphp

        @if(count($statItems))
        <div class="hero-divider"></div>
        <div class="hero-stats">
            @foreach($statItems as $stat)
            <div class="hero-stat">
                <span class="hero-stat-label">{{ $stat['label'] }}</span>
                <span class="hero-stat-val">{{ $stat['val'] }}</span>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Update Profile Info --}}
    @include('profile.partials.update-profile-information-form')

    {{-- Update Password --}}
    @include('profile.partials.update-password-form')

    {{-- Delete Account --}}
    @include('profile.partials.delete-user-form')

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('status') === 'profile-updated')
    Swal.fire({icon:'success',title:'Profil Diperbarui',text:'Informasi profil Anda berhasil disimpan.',timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
    @endif
    @if(session('status') === 'password-updated')
    Swal.fire({icon:'success',title:'Password Diperbarui',text:'Password baru Anda sudah aktif.',timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
    @endif
</script>
</x-app-layout>