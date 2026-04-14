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

    .page { padding: 28px 28px 60px; max-width: 5000px; margin: 0 auto; }

    /* Breadcrumb */
    .breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600;
        color: var(--text3); margin-bottom: 20px;
    }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    /* Page header */
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }

    /* Buttons */
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: background .15s; white-space: nowrap;
    }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { background: var(--brand-h); }
    .btn-ghost { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }

    /* Alert error */
    .alert-error {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px;
        font-size: 13px; font-family: 'DM Sans', sans-serif;
        background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100);
    }
    .alert-error ul { margin: 4px 0 0 16px; padding: 0; }
    .alert-error li { margin-bottom: 2px; }

    /* Form card */
    .form-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 16px;
    }
    .card-header {
        display: flex; align-items: center; gap: 8px;
        padding: 14px 18px; border-bottom: 1px solid var(--border); background: var(--surface2);
    }
    .card-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px; font-weight: 700; color: var(--text3);
        letter-spacing: .07em; text-transform: uppercase;
    }
    .card-body { padding: 22px 24px; }

    /* Form grid */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px 20px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.full { grid-column: span 2; }

    .form-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11.5px; font-weight: 700; color: var(--text2);
        letter-spacing: .04em; text-transform: uppercase;
    }
    .form-label .req { color: var(--danger); }

    .form-control {
        font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text);
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 9px 12px;
        outline: none; transition: border-color .15s, box-shadow .15s;
        width: 100%; box-sizing: border-box;
    }
    .form-control:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(31,99,219,.1);
    }
    .form-control.is-invalid { border-color: var(--danger); }
    .form-control.is-invalid:focus { box-shadow: 0 0 0 3px rgba(220,38,38,.1); }

    select.form-control {
        appearance: none; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg width='12' height='12' fill='none' stroke='%2394a3b8' stroke-width='2' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 12px center; padding-right: 32px;
    }

    .form-hint  { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); }
    .form-error {
        font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--danger);
        display: flex; align-items: center; gap: 4px;
    }

    /* Tingkat pill picker */
    .tingkat-picker { display: flex; gap: 8px; flex-wrap: wrap; }
    .tingkat-opt { display: none; }
    .tingkat-opt + label {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 70px; padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        border: 1.5px solid var(--border); background: var(--surface2); color: var(--text2);
        cursor: pointer; transition: all .15s;
    }
    .tingkat-opt + label:hover { background: var(--surface3); border-color: var(--border2); }
    .tingkat-opt:checked + label {
        background: var(--brand-50); color: var(--brand-700);
        border-color: var(--brand-100); border-width: 2px;
    }

    /* Preview card */
    .preview-card {
        display: none; align-items: center; gap: 14px;
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 14px 16px; margin-top: 12px;
    }
    .preview-card.visible { display: flex; }
    .preview-class-icon {
        width: 44px; height: 44px; border-radius: 10px; flex-shrink: 0;
        background: var(--brand-50); border: 1px solid var(--brand-100);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px;
        font-weight: 800; color: var(--brand-700);
    }
    .preview-class-name  { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 800; color: var(--text); }
    .preview-class-meta  { font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--text3); margin-top: 2px; }

    /* Wali kelas preview */
    .wali-preview {
        display: none; align-items: center; gap: 10px;
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 10px 14px; margin-top: 10px;
    }
    .wali-preview.visible { display: flex; }
    .wali-avatar {
        width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
        background: var(--surface3); border: 1px solid var(--border2);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px;
        font-weight: 800; color: var(--text2);
    }
    .wali-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .wali-nip  { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: 1px; }

    /* Form footer */
    .form-footer {
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
        padding: 16px 24px; border-top: 1px solid var(--border); background: var(--surface2);
    }

    /* Responsive */
    @media (max-width: 600px) {
        .page { padding: 16px 16px 40px; }
        .form-grid { grid-template-columns: 1fr; }
        .form-group.full { grid-column: span 1; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.classes.index') }}">Data Kelas</a>
        <span class="sep">›</span>
        <span class="current">Tambah Kelas</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Kelas Baru</h1>
            <p class="page-sub">Isi form di bawah untuk menambahkan kelas baru</p>
        </div>
        <a href="{{ route('admin.classes.index') }}" class="btn btn-ghost">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Validation errors --}}
    @if($errors->any())
        <div class="alert-error">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>
                <strong>Terdapat kesalahan pada form:</strong>
                <ul>
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.classes.store') }}">
        @csrf

        {{-- Section 1: Info Kelas --}}
        <div class="form-card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                <p class="card-title">Informasi Kelas</p>
            </div>
            <div class="card-body">
                <div class="form-grid">

                    {{-- Nama Kelas --}}
                    <div class="form-group full">
                        <label class="form-label" for="nama_kelas">
                            Nama Kelas <span class="req">*</span>
                        </label>
                        <input
                            type="text" id="nama_kelas" name="nama_kelas"
                            value="{{ old('nama_kelas') }}"
                            placeholder="Contoh: X RPL 1, XI IPA 2, XII IPS 3…"
                            class="form-control {{ $errors->has('nama_kelas') ? 'is-invalid' : '' }}"
                            oninput="updatePreview()"
                            autocomplete="off"
                        >
                        @error('nama_kelas')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Tingkat --}}
                    <div class="form-group">
                        <label class="form-label">
                            Tingkat <span class="req">*</span>
                        </label>
                        <div class="tingkat-picker">
                            @foreach(['X','XI','XII'] as $t)
                                <input
                                    type="radio" name="tingkat" id="tingkat_{{ $t }}"
                                    value="{{ $t }}" class="tingkat-opt"
                                    {{ old('tingkat') == $t ? 'checked' : '' }}
                                    onchange="updatePreview()"
                                >
                                <label for="tingkat_{{ $t }}">{{ $t }}</label>
                            @endforeach
                        </div>
                        @error('tingkat')
                            <p class="form-error" style="margin-top:4px">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Jurusan --}}
                    <div class="form-group">
                        <label class="form-label" for="jurusan">Jurusan</label>
                        <input
                            type="text" id="jurusan" name="jurusan"
                            value="{{ old('jurusan') }}"
                            placeholder="Contoh: IPA, IPS, RPL, TKJ…"
                            class="form-control {{ $errors->has('jurusan') ? 'is-invalid' : '' }}"
                            oninput="updatePreview()"
                            autocomplete="off"
                            list="jurusan-list"
                        >
                        <datalist id="jurusan-list">
                            <option value="IPA">
                            <option value="IPS">
                            <option value="Bahasa">
                            <option value="RPL">
                            <option value="TKJ">
                            <option value="Multimedia">
                            <option value="Akuntansi">
                            <option value="Pemasaran">
                        </datalist>
                        <p class="form-hint">Opsional. Kosongkan jika tidak ada jurusan.</p>
                        @error('jurusan')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                {{-- Preview kelas --}}
                <div class="preview-card" id="classPreview">
                    <div class="preview-class-icon" id="previewIcon">—</div>
                    <div>
                        <p class="preview-class-name" id="previewName">—</p>
                        <p class="preview-class-meta" id="previewMeta">—</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- Section 2: Wali Kelas --}}
        <div class="form-card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
                <p class="card-title">Wali Kelas</p>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="wali_kelas_id">Pilih Wali Kelas</label>
                    <select
                        name="wali_kelas_id" id="wali_kelas_id"
                        class="form-control {{ $errors->has('wali_kelas_id') ? 'is-invalid' : '' }}"
                        onchange="previewWali(this)"
                    >
                        <option value="">— Pilih guru sebagai wali kelas —</option>
                        @foreach($teachers as $teacher)
                            <option
                                value="{{ $teacher->id }}"
                                data-nama="{{ $teacher->nama_lengkap }}"
                                data-nip="{{ $teacher->nip }}"
                                {{ old('wali_kelas_id') == $teacher->id ? 'selected' : '' }}
                            >
                                {{ $teacher->nama_lengkap }} ({{ $teacher->nip }})
                            </option>
                        @endforeach
                    </select>
                    <p class="form-hint">Opsional. Wali kelas dapat ditentukan atau diubah nanti.</p>
                    @error('wali_kelas_id')
                        <p class="form-error">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror

                    {{-- Wali preview --}}
                    <div class="wali-preview" id="waliPreview">
                        <div class="wali-avatar" id="waliInitial">?</div>
                        <div>
                            <p class="wali-name" id="waliName">—</p>
                            <p class="wali-nip"  id="waliNip">NIP: —</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="form-footer">
                <a href="{{ route('admin.classes.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Simpan Kelas
                </button>
            </div>
        </div>

    </form>

</div>

<script>
    /* ── Class preview ── */
    function updatePreview() {
        const nama    = document.getElementById('nama_kelas').value.trim();
        const jurusan = document.getElementById('jurusan').value.trim();
        const tingkat = document.querySelector('input[name="tingkat"]:checked')?.value || '';
        const preview = document.getElementById('classPreview');

        if (!nama) { preview.classList.remove('visible'); return; }

        const initials = nama.substring(0, 2).toUpperCase();
        document.getElementById('previewIcon').textContent = initials;
        document.getElementById('previewName').textContent = nama;

        let meta = [];
        if (tingkat) meta.push('Tingkat ' + tingkat);
        if (jurusan)  meta.push(jurusan);
        document.getElementById('previewMeta').textContent = meta.length ? meta.join(' · ') : 'Kelas baru';

        preview.classList.add('visible');
    }

    /* ── Wali kelas preview ── */
    function previewWali(sel) {
        const preview = document.getElementById('waliPreview');
        if (!sel.value) { preview.classList.remove('visible'); return; }

        const opt  = sel.options[sel.selectedIndex];
        const nama = opt.dataset.nama || '—';
        const nip  = opt.dataset.nip  || '—';

        document.getElementById('waliInitial').textContent = nama.charAt(0).toUpperCase();
        document.getElementById('waliName').textContent    = nama;
        document.getElementById('waliNip').textContent     = 'NIP: ' + nip;
        preview.classList.add('visible');
    }

    /* ── Init on old() values ── */
    document.addEventListener('DOMContentLoaded', function () {
        updatePreview();
        const sel = document.getElementById('wali_kelas_id');
        if (sel && sel.value) previewWali(sel);
    });
</script>

</x-app-layout>