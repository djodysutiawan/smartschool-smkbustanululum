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
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}', confirmButtonColor: '#1f63db' });
    @endif
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Terdapat {{ $errors->count() }} Kesalahan',
            html: `<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>`,
            confirmButtonColor: '#1f63db',
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
        --red:        #dc2626;
        --red-bg:     #fee2e2;
        --red-border: #fecaca;
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
        display: flex; align-items: center; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }

    /* ── Buttons ── */
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
    .btn-primary:disabled { opacity: .6; cursor: not-allowed; filter: none; }
    .btn-add-row {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 14px; border-radius: var(--radius-sm);
        background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700;
        cursor: pointer; transition: background .15s;
    }
    .btn-add-row:hover { background: var(--brand-100); }

    /* ── Alert ── */
    .alert {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px;
        font-size: 13.5px; background: var(--red-bg); color: var(--red); border: 1px solid var(--red-border);
    }
    .alert svg { flex-shrink: 0; margin-top: 1px; }

    /* ── Form card ── */
    .form-card       { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .form-section    { padding: 20px 24px 24px; }
    .section-divider { border: none; border-top: 1px solid var(--border); margin: 0; }

    .section-label {
        display: flex; align-items: center; gap: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
        color: var(--text3); letter-spacing: .07em; text-transform: uppercase; margin-bottom: 16px;
    }
    .section-label-line { flex: 1; height: 1px; background: var(--border); }

    /* ── Grids ── */
    .form-grid  { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .col-span-2 { grid-column: span 2; }

    /* ── Fields ── */
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
    .field input:focus,
    .field select:focus,
    .field textarea:focus {
        border-color: var(--brand-h); background: #fff;
        box-shadow: 0 0 0 3px rgba(53,130,240,.1);
    }
    .field input::placeholder,
    .field textarea::placeholder { color: var(--text3); }
    .field input.is-invalid,
    .field select.is-invalid,
    .field textarea.is-invalid { border-color: var(--red); background: #fff8f8; }
    .field-error { font-size: 12px; color: var(--red); font-family: 'DM Sans', sans-serif; margin-top: -2px; }
    .field-hint  { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; margin-top: -2px; }

    /* ── Password ── */
    .pw-wrap { position: relative; }
    .pw-wrap input { padding-right: 40px; }
    .pw-toggle {
        position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer; color: var(--text3);
        display: flex; align-items: center; transition: color .15s;
    }
    .pw-toggle:hover { color: var(--text2); }

    /* ── Student rows ── */
    .student-rows { display: flex; flex-direction: column; gap: 10px; margin-bottom: 14px; }
    .student-row {
        display: grid; grid-template-columns: 1fr 180px 36px; gap: 10px; align-items: center;
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 10px 12px;
    }
    .student-row select,
    .student-row input {
        height: 36px; padding: 0 10px;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif; font-size: 13px;
        color: var(--text); background: var(--surface); width: 100%;
        outline: none; transition: border-color .15s;
    }
    .student-row select:focus,
    .student-row input:focus { border-color: var(--brand-h); box-shadow: 0 0 0 3px rgba(53,130,240,.1); }
    .btn-remove-row {
        width: 36px; height: 36px; border-radius: var(--radius-sm);
        background: var(--red-bg); color: var(--red); border: 1px solid var(--red-border);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: background .15s; flex-shrink: 0;
    }
    .btn-remove-row:hover { background: #fecaca; }
    .student-row-header {
        display: grid; grid-template-columns: 1fr 180px 36px; gap: 10px;
        padding: 0 12px; margin-bottom: 6px;
    }
    .student-row-header span {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px;
        font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .05em;
    }
    .empty-students {
        padding: 16px; text-align: center;
        font-size: 13px; color: var(--text3); font-family: 'DM Sans', sans-serif;
        background: var(--surface2); border: 1px dashed var(--border2);
        border-radius: var(--radius-sm); font-style: italic;
    }

    /* ── Form footer ── */
    .form-footer {
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
        padding: 16px 24px; background: var(--surface2); border-top: 1px solid var(--border);
    }

    /* ── Responsive ── */
    @media (max-width: 680px) {
        .page { padding: 16px 16px 40px; }
        .form-grid { grid-template-columns: 1fr; }
        .col-span-2 { grid-column: span 1; }
        .student-row { grid-template-columns: 1fr 36px; }
        .student-row input[placeholder="cth. Ayah"] { display: none; }
        .student-row-header { grid-template-columns: 1fr 36px; }
        .student-row-header span:nth-child(2) { display: none; }
    }

    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.parents.index') }}">Manajemen Orang Tua</a>
        <span class="sep">›</span>
        <span class="current">Edit Orang Tua</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Data Orang Tua</h1>
            <p class="page-sub">{{ $parent->nama_lengkap }} &mdash; {{ $parent->no_hp }}</p>
        </div>
        <a href="{{ route('admin.parents.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Inline alerts (fallback) --}}
    @if(session('error'))
        <div class="alert">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>
                <strong style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">
                    Terdapat {{ $errors->count() }} kesalahan:
                </strong>
                <ul style="margin:6px 0 0 16px;display:flex;flex-direction:column;gap:2px">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.parents.update', $parent->id) }}" method="POST" id="parentForm">
        @csrf
        @method('PUT')
        <div class="form-card">

            {{-- ═══ 1. AKUN LOGIN ═══ --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                    Akun Login
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field col-span-2">
                        <label>Nama Lengkap <span class="req">*</span></label>
                        <input type="text" name="nama_lengkap"
                            value="{{ old('nama_lengkap', $parent->nama_lengkap) }}"
                            placeholder="cth. Budi Santoso"
                            class="{{ $errors->has('nama_lengkap') ? 'is-invalid' : '' }}">
                        @error('nama_lengkap')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Email <span class="req">*</span></label>
                        <input type="email" name="email"
                            value="{{ old('email', $parent->user->email ?? $parent->email) }}"
                            placeholder="cth. orangtua@email.com"
                            class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>No. HP <span class="req">*</span></label>
                        <input type="text" name="no_hp"
                            value="{{ old('no_hp', $parent->no_hp) }}"
                            placeholder="cth. 08123456789" inputmode="numeric"
                            class="{{ $errors->has('no_hp') ? 'is-invalid' : '' }}">
                        @error('no_hp')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Password Baru</label>
                        <div class="pw-wrap">
                            <input type="password" name="password" id="pwInput"
                                placeholder="Kosongkan jika tidak ingin mengubah"
                                class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                            <button type="button" class="pw-toggle" onclick="togglePw('pwInput','eyeShow','eyeHide')">
                                <svg id="eyeShow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                                <svg id="eyeHide" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                    <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Konfirmasi Password Baru</label>
                        <div class="pw-wrap">
                            <input type="password" name="password_confirmation" id="pwConfirmInput"
                                placeholder="Ulangi password baru">
                            <button type="button" class="pw-toggle" onclick="togglePw('pwConfirmInput','eyeShow2','eyeHide2')">
                                <svg id="eyeShow2" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                                <svg id="eyeHide2" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                    <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                            </button>
                        </div>
                        <span class="field-hint">Kosongkan jika tidak ingin mengubah password</span>
                    </div>
                    <div class="field col-span-2">
                        <label>Alamat</label>
                        <textarea name="alamat" rows="2"
                            placeholder="Jl. Merdeka No. 1, Bandung"
                            class="{{ $errors->has('alamat') ? 'is-invalid' : '' }}">{{ old('alamat', $parent->alamat) }}</textarea>
                        @error('alamat')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            {{-- ═══ 2. RELASI SISWA ═══ --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Relasi ke Siswa
                    <span class="section-label-line"></span>
                </p>
                <span class="field-hint" style="display:block;margin-bottom:14px">
                    Perubahan relasi siswa akan disinkronkan ulang (sync). Hapus baris untuk memutus relasi.
                </span>

                {{-- Header kolom --}}
                <div class="student-row-header" id="studentRowHeader" style="display:none">
                    <span>Siswa</span>
                    <span>Hubungan</span>
                    <span></span>
                </div>

                {{-- Dynamic rows --}}
                <div class="student-rows" id="studentRows">
                    @php
                        {{-- Prioritaskan old() saat validasi gagal, fallback ke data tersimpan --}}
                        $existingStudents = old('students')
                            ? collect(old('students'))->map(fn($id, $i) => [
                                'id'       => $id,
                                'hubungan' => old('hubungan')[$i] ?? '',
                              ])
                            : $parent->students->map(fn($s) => [
                                'id'       => $s->id,
                                'hubungan' => $s->pivot->hubungan ?? '',
                              ]);
                    @endphp

                    @foreach($existingStudents as $item)
                        <div class="student-row">
                            <select name="students[]">
                                <option value="">— Pilih Siswa —</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}"
                                        {{ $item['id'] == $student->id ? 'selected' : '' }}>
                                        {{ $student->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="text" name="hubungan[]"
                                value="{{ $item['hubungan'] }}"
                                placeholder="cth. Ayah">
                            <button type="button" class="btn-remove-row" onclick="removeRow(this)">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                {{-- Empty placeholder --}}
                <div class="empty-students" id="emptyStudents">
                    Belum ada siswa yang dihubungkan. Klik tombol di bawah untuk menambahkan.
                </div>

                <button type="button" class="btn-add-row" onclick="addStudentRow()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Tambah Siswa
                </button>

                {{-- Students data for JS --}}
                <script id="studentsData" type="application/json">
                    @json($students->map(fn($s) => ['id' => $s->id, 'nama' => $s->nama_lengkap]))
                </script>
            </div>

            {{-- ═══ FOOTER ═══ --}}
            <div class="form-footer">
                <a href="{{ route('admin.parents.index') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>

        </div>{{-- /.form-card --}}
    </form>

</div>{{-- /.page --}}

<script>
    /* ── Password toggle (reusable) ── */
    function togglePw(inputId, showId, hideId) {
        const input  = document.getElementById(inputId);
        const isText = input.type === 'text';
        input.type = isText ? 'password' : 'text';
        document.getElementById(showId).style.display = isText ? 'block' : 'none';
        document.getElementById(hideId).style.display = isText ? 'none'  : 'block';
    }

    /* ── Student rows ── */
    const students = JSON.parse(document.getElementById('studentsData').textContent);

    function buildOptions(selectedId = '') {
        let opts = `<option value="">— Pilih Siswa —</option>`;
        students.forEach(s => {
            opts += `<option value="${s.id}" ${s.id == selectedId ? 'selected' : ''}>${s.nama}</option>`;
        });
        return opts;
    }

    function syncUI() {
        const rows   = document.querySelectorAll('.student-row');
        const header = document.getElementById('studentRowHeader');
        const empty  = document.getElementById('emptyStudents');
        header.style.display = rows.length ? 'grid' : 'none';
        empty.style.display  = rows.length ? 'none' : 'block';
    }

    function addStudentRow(selectedId = '', hubungan = '') {
        const container = document.getElementById('studentRows');
        const row = document.createElement('div');
        row.className = 'student-row';
        row.innerHTML = `
            <select name="students[]">${buildOptions(selectedId)}</select>
            <input type="text" name="hubungan[]" value="${hubungan}" placeholder="cth. Ayah">
            <button type="button" class="btn-remove-row" onclick="removeRow(this)">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>`;
        container.appendChild(row);
        syncUI();
    }

    function removeRow(btn) {
        btn.closest('.student-row').remove();
        syncUI();
    }

    /* ── Init UI state ── */
    syncUI();

    /* ── Disable submit saat proses ── */
    document.getElementById('parentForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled  = true;
        btn.innerHTML = `
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                 style="animation:spin .7s linear infinite">
                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
            </svg>
            Menyimpan…`;
    });
</script>

</x-app-layout>