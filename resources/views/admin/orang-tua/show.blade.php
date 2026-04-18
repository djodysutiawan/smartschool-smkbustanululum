<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand:      #1f63db;
        --brand-h:    #3582f0;
        --brand-700:  #1750c0;
        --brand-100:  #d9ebff;
        --brand-50:   #eef6ff;
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
        --radius:     10px;
        --radius-sm:  7px;
    }

    .page { padding: 28px 28px 60px; max-width: 2000px; margin: 0 auto; }

    .breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600;
        color: var(--text3); margin-bottom: 20px;
    }
    .breadcrumb a { color: var(--text3); text-decoration: none; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }

    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: filter .15s; white-space: nowrap;
    }
    .btn:hover { filter: brightness(.93); }
    .btn-back   { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); padding: 8px 14px; }
    .btn-back:hover { background: var(--surface3); filter:none; }
    .btn-edit   { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover { background: var(--brand-100); filter:none; }
    .btn-del    { background: #fff0f0; color: var(--red); border: 1px solid #fecaca; }
    .btn-del:hover { background: #fee2e2; filter:none; }
    .btn-sm     { padding: 6px 12px; font-size: 12px; border-radius: 6px; }
    .btn-danger { background: #fff0f0; color: var(--red); border: 1px solid #fecaca; }
    .btn-danger:hover { background: #fee2e2; filter:none; }
    .btn-primary { background: var(--brand); color: #fff; }

    .layout-grid { display: grid; grid-template-columns: 340px 1fr; gap: 20px; }

    /* Left card */
    .profile-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
    }
    .profile-header {
        background: linear-gradient(135deg, var(--brand-50) 0%, #e0f0ff 100%);
        padding: 28px 24px; text-align: center;
        border-bottom: 1px solid var(--border);
    }
    .profile-avatar {
        width: 80px; height: 80px; border-radius: 18px;
        background: var(--brand); display: flex; align-items: center;
        justify-content: center; margin: 0 auto 14px;
        border: 3px solid #fff; box-shadow: 0 4px 16px rgba(31,99,219,.25);
    }
    .profile-avatar span {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 30px; font-weight: 800; color: #fff;
    }
    .profile-name {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 17px;
        font-weight: 800; color: var(--text); margin-bottom: 4px;
    }
    .profile-sub { font-size: 12.5px; color: var(--text3); }

    .info-list { padding: 0; list-style: none; }
    .info-list li {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 13px 20px; border-bottom: 1px solid var(--border);
        font-size: 13px;
    }
    .info-list li:last-child { border-bottom: none; }
    .info-icon { width: 16px; flex-shrink: 0; margin-top: 1px; color: var(--text3); }
    .info-label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px;
        font-weight: 700; color: var(--text3); text-transform: uppercase;
        letter-spacing: .04em; margin-bottom: 2px;
    }
    .info-val { font-size: 13.5px; color: var(--text); font-family: 'DM Sans', sans-serif; }

    .card-actions { padding: 16px 20px; border-top: 1px solid var(--border); display: flex; gap: 8px; flex-wrap: wrap; }

    /* Right panels */
    .detail-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 20px;
    }
    .detail-card:last-child { margin-bottom: 0; }
    .detail-topbar {
        padding: 14px 20px; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
    }
    .detail-topbar-title {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px;
        font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 8px;
    }
    .detail-topbar-title .icon-wrap {
        width: 28px; height: 28px; border-radius: 7px;
        background: var(--brand-50); display: flex; align-items: center; justify-content: center;
    }

    /* Siswa cards */
    .siswa-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 12px; padding: 16px 20px; }
    .siswa-card {
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: 14px 16px; background: var(--surface2);
        transition: border-color .15s, box-shadow .15s;
    }
    .siswa-card:hover { border-color: var(--brand-100); box-shadow: 0 2px 8px rgba(31,99,219,.08); }
    .siswa-card-top { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    .siswa-ava {
        width: 38px; height: 38px; border-radius: 9px;
        background: #f0fdf4; border: 1px solid #bbf7d0;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .siswa-ava span {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 16px; font-weight: 800; color: #15803d;
    }
    .siswa-name {
        font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
        font-size: 13.5px; color: var(--text);
    }
    .siswa-nis { font-size: 12px; color: var(--text3); margin-top: 1px; }
    .siswa-meta { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 12px; }
    .meta-chip {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 9px; border-radius: 5px; font-size: 11.5px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
    }
    .chip-kelas   { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .chip-hub     { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .chip-kontak  { background: #fefce8; color: #a16207; border: 1px solid #fde68a; }
    .siswa-actions { display: flex; gap: 6px; }

    /* Link siswa form */
    .link-form {
        padding: 16px 20px; border-top: 1px solid var(--border);
        background: var(--surface2);
    }
    .link-form-title {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px;
        font-weight: 700; color: var(--text2); margin-bottom: 10px;
    }
    .link-form-row { display: flex; flex-wrap: wrap; gap: 8px; align-items: flex-end; }
    .link-form-row select,
    .link-form-row input {
        height: 36px; padding: 0 10px; border: 1px solid var(--border);
        border-radius: var(--radius-sm); background: var(--surface);
        font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text);
        outline: none;
    }
    .link-form-row select:focus,
    .link-form-row input:focus { border-color: var(--brand-h); }

    .empty-box {
        padding: 40px 20px; text-align: center; color: var(--text3);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px;
    }

    @media (max-width: 900px) {
        .layout-grid { grid-template-columns: 1fr; }
        .page { padding: 16px 16px 40px; }
    }
</style>

<div class="page">

    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.orang-tua.index') }}">Data Orang Tua</a>
        <span class="sep">›</span>
        <span class="current">{{ $orangTua->nama_lengkap }}</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Orang Tua / Wali</h1>
            <p class="page-sub">Informasi lengkap dan relasi dengan siswa</p>
        </div>
        <a href="{{ route('admin.orang-tua.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <div class="layout-grid">

        {{-- Left: Profile --}}
        <div>
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <span>{{ strtoupper(substr($orangTua->nama_lengkap, 0, 1)) }}</span>
                    </div>
                    <p class="profile-name">{{ $orangTua->nama_lengkap }}</p>
                    <p class="profile-sub">Orang Tua / Wali</p>
                </div>

                <ul class="info-list">
                    <li>
                        <svg class="info-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.63 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.54 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 8.91a16 16 0 0 0 5.99 6l.85-.85a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <div>
                            <p class="info-label">No. HP</p>
                            <p class="info-val">{{ $orangTua->no_hp }}</p>
                        </div>
                    </li>
                    <li>
                        <svg class="info-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <div>
                            <p class="info-label">Email</p>
                            <p class="info-val">{{ $orangTua->email ?? '—' }}</p>
                        </div>
                    </li>
                    <li>
                        <svg class="info-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        <div>
                            <p class="info-label">Pekerjaan</p>
                            <p class="info-val">{{ $orangTua->pekerjaan ?? '—' }}</p>
                        </div>
                    </li>
                    <li>
                        <svg class="info-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <div>
                            <p class="info-label">Alamat</p>
                            <p class="info-val">{{ $orangTua->alamat ?? '—' }}</p>
                        </div>
                    </li>
                    <li>
                        <svg class="info-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <div>
                            <p class="info-label">Akun Sistem</p>
                            <p class="info-val">
                                @if($orangTua->pengguna)
                                    <span style="color:#15803d">✓ {{ $orangTua->pengguna->email }}</span>
                                @else
                                    <span style="color:var(--text3)">Tidak ada akun</span>
                                @endif
                            </p>
                        </div>
                    </li>
                    <li>
                        <svg class="info-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <div>
                            <p class="info-label">Ditambahkan</p>
                            <p class="info-val">{{ $orangTua->created_at->format('d M Y') }}</p>
                        </div>
                    </li>
                </ul>

                <div class="card-actions">
                    <a href="{{ route('admin.orang-tua.edit', $orangTua->id) }}" class="btn btn-edit" style="flex:1;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit Data
                    </a>
                    <form action="{{ route('admin.orang-tua.destroy', $orangTua->id) }}" method="POST" id="mainDeleteForm">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-del"
                            onclick="confirmDelete(document.getElementById('mainDeleteForm'), '{{ addslashes($orangTua->nama_lengkap) }}')">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right: Siswa & Relations --}}
        <div>
            <div class="detail-card">
                <div class="detail-topbar">
                    <p class="detail-topbar-title">
                        <span class="icon-wrap">
                            <svg width="14" height="14" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        </span>
                        Siswa yang Terhubung
                        <span style="font-size:12px;font-weight:600;color:var(--text3);margin-left:4px">({{ $orangTua->siswa->count() }})</span>
                    </p>
                </div>

                @if($orangTua->siswa->isNotEmpty())
                <div class="siswa-grid">
                    @foreach($orangTua->siswa as $s)
                    <div class="siswa-card">
                        <div class="siswa-card-top">
                            <div class="siswa-ava">
                                <span>{{ strtoupper(substr($s->nama_lengkap, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="siswa-name">{{ $s->nama_lengkap }}</p>
                                <p class="siswa-nis">NIS: {{ $s->nis }}</p>
                            </div>
                        </div>
                        <div class="siswa-meta">
                            @if($s->kelas)
                                <span class="meta-chip chip-kelas">{{ $s->kelas->nama_kelas }}</span>
                            @endif
                            <span class="meta-chip chip-hub">{{ ucfirst($s->pivot->hubungan ?? 'orang_tua') }}</span>
                            @if($s->pivot->kontak_utama)
                                <span class="meta-chip chip-kontak">★ Kontak Utama</span>
                            @endif
                        </div>
                        <div class="siswa-actions">
                            <form action="{{ route('admin.orang-tua.unlink-siswa', [$orangTua->id, $s->id]) }}" method="POST" id="unlinkForm-{{ $s->id }}">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="confirmUnlink(document.getElementById('unlinkForm-{{ $s->id }}'), '{{ addslashes($s->nama_lengkap) }}')">
                                    Putus Relasi
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-box">
                    <svg width="32" height="32" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 8px;display:block"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Belum ada siswa yang terhubung dengan orang tua ini
                </div>
                @endif

                {{-- Link Siswa Form --}}
                <div class="link-form">
                    <p class="link-form-title">Tambah Relasi Siswa</p>
                    <form action="{{ route('admin.orang-tua.link-siswa', $orangTua->id) }}" method="POST" id="linkSiswaForm">
                        @csrf
                        <div class="link-form-row">
                            <div>
                                <label style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);display:block;margin-bottom:4px;text-transform:uppercase;letter-spacing:.04em">Siswa</label>
                                <select name="siswa_id" required style="width:200px">
                                    <option value="">— Pilih Siswa —</option>
                                    {{-- Hanya tampilkan siswa yang belum terhubung --}}
                                    @php $linkedIds = $orangTua->siswa->pluck('id')->toArray(); @endphp
                                    @foreach(\App\Models\Siswa::aktif()->orderBy('nama_lengkap')->get() as $sv)
                                        @if(!in_array($sv->id, $linkedIds))
                                            <option value="{{ $sv->id }}">{{ $sv->nama_lengkap }} ({{ $sv->nis }})</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);display:block;margin-bottom:4px;text-transform:uppercase;letter-spacing:.04em">Hubungan</label>
                                <select name="hubungan" required>
                                    <option value="ayah">Ayah</option>
                                    <option value="ibu">Ibu</option>
                                    <option value="wali">Wali</option>
                                    <option value="orang_tua" selected>Orang Tua</option>
                                </select>
                            </div>
                            <div style="display:flex;align-items:flex-end;gap:6px">
                                <label style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);display:flex;align-items:center;gap:5px;padding-bottom:8px">
                                    <input type="checkbox" name="kontak_utama" value="1"> Kontak Utama
                                </label>
                            </div>
                            <div style="display:flex;align-items:flex-end">
                                <button type="submit" class="btn btn-primary" style="height:36px;padding:0 16px;font-size:13px">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    Tambah
                                </button>
                            </div>
                        </div>
                    </form>
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

    function confirmDelete(form, nama) {
        Swal.fire({
            title: 'Hapus Data Orang Tua?',
            html: `Data <strong>${nama}</strong> beserta semua relasi siswa akan dihapus permanen.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }

    function confirmUnlink(form, nama) {
        Swal.fire({
            title: 'Putus Relasi?',
            html: `Relasi orang tua dengan siswa <strong>${nama}</strong> akan diputus.`,
            icon: 'question', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Putus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>