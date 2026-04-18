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
        --red-border: #fecaca;
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
        display: flex; align-items: center; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }

    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 20px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: filter .15s, background .15s; white-space: nowrap;
    }
    .btn-back    { padding: 8px 14px; font-size: 13px; background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-back:hover { background: var(--surface3); }
    .btn-cancel  { background: var(--surface); color: var(--text2); border: 1px solid var(--border); }
    .btn-cancel:hover { background: var(--surface3); }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { filter: brightness(.93); }
    .btn-primary:disabled { opacity: .6; cursor: not-allowed; }

    .alert {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px;
        font-size: 13.5px; background: var(--red-bg); color: var(--red); border: 1px solid var(--red-border);
    }

    .form-card   { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .form-section { padding: 20px 24px 24px; }
    .section-divider { border: none; border-top: 1px solid var(--border); margin: 0; }

    .section-label {
        display: flex; align-items: center; gap: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
        color: var(--text3); letter-spacing: .07em; text-transform: uppercase; margin-bottom: 16px;
    }
    .section-label-line { flex: 1; height: 1px; background: var(--border); }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .col-span-2 { grid-column: span 2; }

    .field { display: flex; flex-direction: column; gap: 6px; }
    .field label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px;
        font-weight: 700; color: var(--text2);
    }
    .field label .req { color: var(--brand); margin-left: 2px; }
    .field input,
    .field select,
    .field textarea {
        height: 38px; padding: 0 12px;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif; font-size: 13.5px;
        color: var(--text); background: var(--surface2); width: 100%;
        outline: none; transition: border-color .15s, background .15s;
    }
    .field textarea { height: auto; padding: 10px 12px; resize: vertical; }
    .field input:focus, .field select:focus, .field textarea:focus {
        border-color: var(--brand-h); background: #fff;
        box-shadow: 0 0 0 3px rgba(53,130,240,.1);
    }
    .field input::placeholder, .field textarea::placeholder { color: var(--text3); }
    .field input.is-invalid,
    .field select.is-invalid,
    .field textarea.is-invalid { border-color: var(--red); background: #fff8f8; }
    .field-error { font-size: 12px; color: var(--red); font-family: 'DM Sans', sans-serif; margin-top: -2px; }
    .field-hint  { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; margin-top: -2px; }

    /* Siswa table */
    .siswa-table-wrap {
        border: 1px solid var(--border); border-radius: var(--radius-sm); overflow: hidden;
    }
    .siswa-table-wrap table { font-size: 13px; width: 100%; border-collapse: collapse; }
    .siswa-table-wrap thead tr { background: var(--surface2); }
    .siswa-table-wrap th {
        padding: 9px 12px; font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px; font-weight: 700; color: var(--text3);
        text-transform: uppercase; letter-spacing: .05em; text-align: left;
        border-bottom: 1px solid var(--border);
    }
    .siswa-table-wrap td { padding: 8px 12px; border-top: 1px solid var(--border); }
    .siswa-table-wrap select {
        height: 32px; padding: 0 8px; font-size: 12.5px;
        border: 1px solid var(--border); border-radius: 6px;
        background: var(--surface2); font-family: 'DM Sans', sans-serif;
        color: var(--text); outline: none;
    }
    .empty-siswa {
        padding: 24px; text-align: center; color: var(--text3);
        font-size: 13px; font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .info-box {
        background: var(--brand-50); border: 1px solid var(--brand-100);
        border-radius: var(--radius-sm); padding: 12px 16px;
        font-size: 13px; color: var(--brand-700);
        font-family: 'DM Sans', sans-serif; margin-bottom: 16px;
        display: flex; align-items: flex-start; gap: 8px;
    }

    .acct-info-box {
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 14px 16px;
        display: flex; align-items: center; gap: 12px; margin-bottom: 12px;
    }
    .acct-icon {
        width: 36px; height: 36px; border-radius: 8px; background: var(--brand-50);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .acct-name { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 13px; color: var(--text); }
    .acct-email { font-size: 12px; color: var(--text3); }

    .form-footer {
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
        padding: 16px 24px; background: var(--surface2); border-top: 1px solid var(--border);
    }

    @media (max-width: 680px) {
        .page { padding: 16px 16px 40px; }
        .form-grid { grid-template-columns: 1fr; }
        .col-span-2 { grid-column: span 1; }
    }

    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="page">

    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.orang-tua.index') }}">Data Orang Tua</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.orang-tua.show', $orangTua->id) }}">{{ $orangTua->nama_lengkap }}</a>
        <span class="sep">›</span>
        <span class="current">Edit</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Data Orang Tua / Wali</h1>
            <p class="page-sub">Perbarui informasi <strong>{{ $orangTua->nama_lengkap }}</strong></p>
        </div>
        <a href="{{ route('admin.orang-tua.show', $orangTua->id) }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="alert">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>
                <strong style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">Terdapat {{ $errors->count() }} kesalahan:</strong>
                <ul style="margin:6px 0 0 16px;display:flex;flex-direction:column;gap:2px">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.orang-tua.update', $orangTua->id) }}" method="POST" id="editForm">
        @csrf @method('PUT')
        <div class="form-card">

            {{-- ═══ 1. DATA PRIBADI ═══ --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    Data Pribadi
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field col-span-2">
                        <label>Nama Lengkap <span class="req">*</span></label>
                        <input type="text" name="nama_lengkap"
                            value="{{ old('nama_lengkap', $orangTua->nama_lengkap) }}"
                            placeholder="Nama lengkap orang tua"
                            class="{{ $errors->has('nama_lengkap') ? 'is-invalid' : '' }}">
                        @error('nama_lengkap')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>No. HP <span class="req">*</span></label>
                        <input type="text" name="no_hp"
                            value="{{ old('no_hp', $orangTua->no_hp) }}"
                            placeholder="cth. 08123456789" inputmode="numeric"
                            class="{{ $errors->has('no_hp') ? 'is-invalid' : '' }}">
                        @error('no_hp')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Email</label>
                        <input type="email" name="email"
                            value="{{ old('email', $orangTua->email) }}"
                            placeholder="cth. email@domain.com"
                            class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Pekerjaan</label>
                        <input type="text" name="pekerjaan"
                            value="{{ old('pekerjaan', $orangTua->pekerjaan) }}"
                            placeholder="cth. Wiraswasta"
                            class="{{ $errors->has('pekerjaan') ? 'is-invalid' : '' }}">
                        @error('pekerjaan')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Alamat</label>
                        <textarea name="alamat" rows="3"
                            placeholder="Alamat lengkap..."
                            class="{{ $errors->has('alamat') ? 'is-invalid' : '' }}">{{ old('alamat', $orangTua->alamat) }}</textarea>
                        @error('alamat')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            {{-- ═══ 2. AKUN SISTEM ═══ --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Akun Sistem
                    <span class="section-label-line"></span>
                </p>

                @if($orangTua->pengguna)
                <div class="acct-info-box">
                    <div class="acct-icon">
                        <svg width="16" height="16" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <div>
                        <p class="acct-name">{{ $orangTua->pengguna->name }}</p>
                        <p class="acct-email">{{ $orangTua->pengguna->email }}</p>
                    </div>
                    <span style="margin-left:auto;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:#15803d;background:#dcfce7;border:1px solid #bbf7d0;padding:3px 10px;border-radius:99px">Aktif</span>
                </div>
                <p class="field-hint">Untuk mengubah email/password akun, gunakan menu Manajemen Pengguna.</p>
                @else
                <div class="info-box">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Orang tua ini belum memiliki akun login. Buat akun melalui menu Manajemen Pengguna.
                </div>
                @endif
            </div>

            <hr class="section-divider">

            {{-- ═══ 3. RELASI SISWA ═══ --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                    Relasi dengan Siswa
                    <span class="section-label-line"></span>
                </p>

                <div class="info-box">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Centang siswa yang ingin dihubungkan. Uncheck untuk memutus relasi.
                </div>

                @if($siswaAktif->isNotEmpty())
                <div class="siswa-table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:40px">Pilih</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Hubungan</th>
                                <th>Kontak Utama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $linkedSiswa   = $orangTua->siswa->keyBy('id');
                                $oldSiswaIds   = old('siswa_ids', $linkedSiswa->keys()->toArray());
                                $oldKontakUtama = old('kontak_utama', $orangTua->siswa->where('pivot.kontak_utama', true)->first()?->id);
                            @endphp
                            @foreach($siswaAktif as $s)
                            @php
                                $isLinked  = in_array($s->id, $oldSiswaIds);
                                $pivot     = $linkedSiswa->get($s->id)?->pivot;
                                $oldHub    = old("hubungan.{$s->id}", $pivot?->hubungan ?? 'orang_tua');
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" name="siswa_ids[]" value="{{ $s->id }}"
                                        id="chk-{{ $s->id }}"
                                        {{ $isLinked ? 'checked' : '' }}
                                        onchange="toggleSiswaRow({{ $s->id }})">
                                </td>
                                <td style="font-size:12px;color:var(--text3)">{{ $s->nis }}</td>
                                <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px">{{ $s->nama_lengkap }}</td>
                                <td style="font-size:12.5px;color:var(--text2)">{{ $s->kelas->nama_kelas ?? '-' }}</td>
                                <td>
                                    <select name="hubungan[{{ $s->id }}]"
                                        id="hubungan-{{ $s->id }}"
                                        style="{{ !$isLinked ? 'opacity:.4;pointer-events:none' : '' }}">
                                        <option value="ayah"      {{ $oldHub == 'ayah' ? 'selected' : '' }}>Ayah</option>
                                        <option value="ibu"       {{ $oldHub == 'ibu' ? 'selected' : '' }}>Ibu</option>
                                        <option value="wali"      {{ $oldHub == 'wali' ? 'selected' : '' }}>Wali</option>
                                        <option value="orang_tua" {{ $oldHub == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="radio" name="kontak_utama" value="{{ $s->id }}"
                                        id="kontak-{{ $s->id }}"
                                        {{ $oldKontakUtama == $s->id ? 'checked' : '' }}
                                        style="{{ !$isLinked ? 'opacity:.4;pointer-events:none' : '' }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-siswa">
                    <svg width="28" height="28" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 8px;display:block"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Tidak ada siswa aktif yang tersedia
                </div>
                @endif
            </div>

            {{-- Footer --}}
            <div class="form-footer">
                <a href="{{ route('admin.orang-tua.show', $orangTua->id) }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif
    @if($errors->any())
    Swal.fire({
        icon:'error', title:'Terdapat {{ $errors->count() }} Kesalahan',
        html:`<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`,
        confirmButtonColor:'#1f63db',
    });
    @endif

    function toggleSiswaRow(id) {
        const checked = document.getElementById('chk-' + id).checked;
        const hubEl   = document.getElementById('hubungan-' + id);
        const kontakEl = document.getElementById('kontak-' + id);
        if (hubEl) {
            hubEl.style.opacity = checked ? '1' : '.4';
            hubEl.style.pointerEvents = checked ? 'auto' : 'none';
        }
        if (kontakEl) {
            kontakEl.style.opacity = checked ? '1' : '.4';
            kontakEl.style.pointerEvents = checked ? 'auto' : 'none';
            if (!checked) kontakEl.checked = false;
        }
    }

    document.getElementById('editForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>