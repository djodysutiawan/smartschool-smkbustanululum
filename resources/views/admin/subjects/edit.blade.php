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
        --warning:    #d97706;
        --warning-50: #fffbeb;
        --warning-100:#fde68a;
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

    /* Edit badge */
    .edit-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--warning-50); color: var(--warning);
        border: 1px solid var(--warning-100); border-radius: 20px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
        padding: 3px 10px; margin-top: 6px; letter-spacing: .04em; text-transform: uppercase;
    }

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

    /* Edit info banner */
    .edit-info-banner {
        display: flex; align-items: center; gap: 12px;
        background: var(--warning-50); border: 1px solid var(--warning-100);
        border-radius: var(--radius-sm); padding: 12px 16px; margin-bottom: 20px;
    }
    .edit-info-icon {
        width: 38px; height: 38px; border-radius: 9px; flex-shrink: 0;
        background: var(--warning-100); border: 1px solid var(--warning-100);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px;
        font-weight: 800; color: var(--warning);
    }
    .edit-info-label { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--warning); }
    .edit-info-name  {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px;
        font-weight: 800; color: var(--warning);
    }

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

    /* Form */
    .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 18px; }
    .form-group:last-child { margin-bottom: 0; }

    .form-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11.5px; font-weight: 700; color: var(--text2);
        letter-spacing: .04em; text-transform: uppercase;
        display: flex; align-items: center; gap: 6px;
    }
    .form-label .req { color: var(--danger); }

    /* Changed dot */
    .changed-dot {
        display: inline-block; width: 6px; height: 6px; border-radius: 50%;
        background: var(--warning); flex-shrink: 0;
        opacity: 0; transition: opacity .2s;
    }
    .changed-dot.visible { opacity: 1; }

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

    .form-hint  { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); }
    .form-error {
        font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--danger);
        display: flex; align-items: center; gap: 4px;
    }

    /* Input with prefix */
    .input-group { display: flex; }
    .input-prefix {
        display: flex; align-items: center; padding: 9px 12px;
        background: var(--surface3); border: 1px solid var(--border);
        border-right: none; border-radius: var(--radius-sm) 0 0 var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px;
        font-weight: 700; color: var(--text3); white-space: nowrap; flex-shrink: 0;
    }
    .input-group .form-control {
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
    }

    /* Char counter */
    .char-row { display: flex; align-items: center; justify-content: space-between; }
    .char-counter {
        font-family: 'DM Sans', sans-serif; font-size: 11.5px; color: var(--text3);
        transition: color .15s;
    }
    .char-counter.warn { color: var(--danger); }

    /* Live preview */
    .preview-wrap {
        background: var(--brand-50); border: 1px solid var(--brand-100);
        border-radius: var(--radius-sm); padding: 16px 18px; margin-top: 20px;
        display: none;
    }
    .preview-wrap.visible { display: block; }
    .preview-label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 10.5px;
        font-weight: 700; letter-spacing: .08em; text-transform: uppercase;
        color: var(--brand-700); margin-bottom: 12px;
    }
    .preview-subject { display: flex; align-items: center; gap: 12px; }
    .preview-icon {
        width: 44px; height: 44px; border-radius: 10px; flex-shrink: 0;
        background: var(--brand-100); border: 1px solid var(--brand-100);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px;
        font-weight: 800; color: var(--brand-700); transition: all .2s;
    }
    .preview-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 800; color: var(--brand-700); }
    .preview-code {
        display: inline-flex; align-items: center; gap: 4px;
        font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--brand); margin-top: 4px;
    }

    /* Original value chip */
    .original-chip {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--surface3); border: 1px solid var(--border);
        border-radius: 6px; padding: 3px 8px; margin-top: 6px;
        font-family: 'DM Sans', sans-serif; font-size: 11.5px; color: var(--text3);
    }
    .original-chip strong { color: var(--text2); font-weight: 600; }

    /* Tips card */
    .tips-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 16px;
    }
    .tips-body { padding: 18px 20px; }
    .tip-item {
        display: flex; align-items: flex-start; gap: 10px;
        margin-bottom: 12px; font-family: 'DM Sans', sans-serif;
        font-size: 13px; color: var(--text2); line-height: 1.5;
    }
    .tip-item:last-child { margin-bottom: 0; }
    .tip-dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: var(--warning); margin-top: 7px; flex-shrink: 0;
    }

    /* Diff card — perubahan yang terdeteksi */
    .diff-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
        display: none;
    }
    .diff-card.visible { display: block; }
    .diff-body { padding: 16px 20px; }
    .diff-empty {
        font-family: 'DM Sans', sans-serif; font-size: 13px;
        color: var(--text3); font-style: italic; text-align: center; padding: 8px 0;
    }
    .diff-row {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 9px 0; border-bottom: 1px solid var(--border);
        font-family: 'DM Sans', sans-serif; font-size: 12.5px;
    }
    .diff-row:last-child { border-bottom: none; padding-bottom: 0; }
    .diff-field {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px;
        font-weight: 700; color: var(--text3); text-transform: uppercase;
        letter-spacing: .04em; min-width: 90px; padding-top: 1px;
    }
    .diff-old { color: var(--danger); text-decoration: line-through; flex: 1; }
    .diff-arrow { color: var(--text3); flex-shrink: 0; }
    .diff-new { color: var(--success, #16a34a); font-weight: 600; flex: 1; }

    /* Layout */
    .layout { display: grid; grid-template-columns: 2fr 1fr; gap: 16px; align-items: start; }

    /* Form footer */
    .form-footer {
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
        padding: 16px 24px; border-top: 1px solid var(--border); background: var(--surface2);
    }

    @media (max-width: 768px) {
        .page { padding: 16px 16px 40px; }
        .layout { grid-template-columns: 1fr; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.subjects.index') }}">Data Mata Pelajaran</a>
        <span class="sep">›</span>
        <span class="current">Edit Mata Pelajaran</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Mata Pelajaran</h1>
            <p class="page-sub">Perbarui informasi mata pelajaran yang sudah ada</p>
            <span class="edit-badge">
                <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Mode Edit
            </span>
        </div>
        <a href="{{ route('admin.subjects.index') }}" class="btn btn-ghost">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Edit info banner --}}
    <div class="edit-info-banner">
        <div class="edit-info-icon">
            {{ strtoupper(substr($subject->kode_mapel, 0, 2)) }}
        </div>
        <div>
            <p class="edit-info-label">Sedang mengedit mata pelajaran</p>
            <p class="edit-info-name">{{ $subject->nama_mapel }} · {{ $subject->kode_mapel }}</p>
        </div>
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

    <div class="layout">

        {{-- Kolom kiri: form --}}
        <div>
            <form method="POST" action="{{ route('admin.subjects.update', $subject->id) }}">
                @csrf
                @method('PUT')

                <div class="form-card">
                    <div class="card-header">
                        <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                        </svg>
                        <p class="card-title">Informasi Mata Pelajaran</p>
                    </div>
                    <div class="card-body">

                        {{-- Nama Mapel --}}
                        <div class="form-group">
                            <label class="form-label" for="nama_mapel">
                                Nama Mata Pelajaran <span class="req">*</span>
                                <span class="changed-dot" id="dotNama"></span>
                            </label>
                            <input
                                type="text"
                                id="nama_mapel"
                                name="nama_mapel"
                                value="{{ old('nama_mapel', $subject->nama_mapel) }}"
                                placeholder="Contoh: Matematika, Bahasa Indonesia, Fisika…"
                                maxlength="255"
                                class="form-control {{ $errors->has('nama_mapel') ? 'is-invalid' : '' }}"
                                oninput="onNamaInput(this); updatePreview(); trackChange('nama_mapel', 'dotNama')"
                                autocomplete="off"
                                data-original="{{ $subject->nama_mapel }}"
                            >
                            <div class="char-row" style="margin-top:4px">
                                <span>
                                    @error('nama_mapel')
                                        <p class="form-error">
                                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="10"/>
                                                <line x1="12" y1="8" x2="12" y2="12"/>
                                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @else
                                        <span class="form-hint">Nama lengkap mata pelajaran.</span>
                                    @enderror
                                </span>
                                <span class="char-counter" id="namaCounter">0 / 255</span>
                            </div>
                            {{-- Original value chip --}}
                            <div class="original-chip" id="chipNama" style="display:none">
                                <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <polyline points="9 14 4 9 9 4"/><path d="M20 20v-7a4 4 0 0 0-4-4H4"/>
                                </svg>
                                Semula: <strong>{{ $subject->nama_mapel }}</strong>
                            </div>
                        </div>

                        {{-- Kode Mapel --}}
                        <div class="form-group">
                            <label class="form-label" for="kode_mapel">
                                Kode Mata Pelajaran <span class="req">*</span>
                                <span class="changed-dot" id="dotKode"></span>
                            </label>
                            <div class="input-group">
                                <span class="input-prefix">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-right:5px">
                                        <polyline points="16 18 22 12 16 6"/>
                                        <polyline points="8 6 2 12 8 18"/>
                                    </svg>
                                    KODE
                                </span>
                                <input
                                    type="text"
                                    id="kode_mapel"
                                    name="kode_mapel"
                                    value="{{ old('kode_mapel', $subject->kode_mapel) }}"
                                    placeholder="MTK, B.IND, FIS…"
                                    maxlength="20"
                                    class="form-control {{ $errors->has('kode_mapel') ? 'is-invalid' : '' }}"
                                    oninput="onKodeInput(this); updatePreview(); trackChange('kode_mapel', 'dotKode')"
                                    autocomplete="off"
                                    style="text-transform:uppercase"
                                    data-original="{{ $subject->kode_mapel }}"
                                >
                            </div>
                            <div class="char-row" style="margin-top:4px">
                                <span>
                                    @error('kode_mapel')
                                        <p class="form-error">
                                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="10"/>
                                                <line x1="12" y1="8" x2="12" y2="12"/>
                                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @else
                                        <span class="form-hint">Kode unik, maks. 20 karakter. Mengubah kode akan mempengaruhi tampilan jadwal.</span>
                                    @enderror
                                </span>
                                <span class="char-counter" id="kodeCounter">0 / 20</span>
                            </div>
                            {{-- Original value chip --}}
                            <div class="original-chip" id="chipKode" style="display:none">
                                <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <polyline points="9 14 4 9 9 4"/><path d="M20 20v-7a4 4 0 0 0-4-4H4"/>
                                </svg>
                                Semula: <strong>{{ $subject->kode_mapel }}</strong>
                            </div>
                        </div>

                        {{-- Live preview --}}
                        <div class="preview-wrap visible" id="previewWrap">
                            <p class="preview-label">Preview tampilan</p>
                            <div class="preview-subject">
                                <div class="preview-icon" id="previewIcon">
                                    {{ strtoupper(substr($subject->kode_mapel, 0, 3)) }}
                                </div>
                                <div>
                                    <p class="preview-name" id="previewName">{{ $subject->nama_mapel }}</p>
                                    <p class="preview-code">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <polyline points="16 18 22 12 16 6"/>
                                            <polyline points="8 6 2 12 8 18"/>
                                        </svg>
                                        <span id="previewCode">{{ $subject->kode_mapel }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="form-footer">
                        <a href="{{ route('admin.subjects.index') }}" class="btn btn-ghost">Batal</a>
                        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>

            </form>
        </div>

        {{-- Kolom kanan: diff + tips --}}
        <div>

            {{-- Perubahan terdeteksi --}}
            <div class="diff-card tips-card" id="diffCard">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <p class="card-title" style="color:var(--warning)">Perubahan Terdeteksi</p>
                </div>
                <div class="diff-body" id="diffBody">
                    <p class="diff-empty">Belum ada perubahan.</p>
                </div>
            </div>

            {{-- Tips --}}
            <div class="tips-card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <p class="card-title">Catatan Edit</p>
                </div>
                <div class="tips-body">
                    <div class="tip-item">
                        <div class="tip-dot"></div>
                        <span>Tombol <strong>Simpan Perubahan</strong> hanya aktif jika ada field yang diubah dari nilai aslinya.</span>
                    </div>
                    <div class="tip-item">
                        <div class="tip-dot"></div>
                        <span>Mengubah <strong>Kode Mapel</strong> akan mempengaruhi tampilan di seluruh jadwal yang menggunakan mata pelajaran ini.</span>
                    </div>
                    <div class="tip-item">
                        <div class="tip-dot"></div>
                        <span>Kode mapel harus <strong>unik</strong> — sistem akan menolak jika kode sudah dipakai mata pelajaran lain.</span>
                    </div>
                    <div class="tip-item">
                        <div class="tip-dot"></div>
                        <span>Kode otomatis diubah ke <strong>huruf kapital</strong> saat mengetik.</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
    /* ── Nilai original dari server ── */
    const original = {
        nama_mapel: '{{ addslashes($subject->nama_mapel) }}',
        kode_mapel: '{{ addslashes($subject->kode_mapel) }}',
    };

    /* ── Char counter nama ── */
    function onNamaInput(el) {
        const len = el.value.length;
        const counter = document.getElementById('namaCounter');
        counter.textContent = len + ' / 255';
        counter.classList.toggle('warn', len > 235);
    }

    /* ── Char counter + uppercase kode ── */
    function onKodeInput(el) {
        el.value = el.value.toUpperCase();
        const len = el.value.length;
        const counter = document.getElementById('kodeCounter');
        counter.textContent = len + ' / 20';
        counter.classList.toggle('warn', len >= 17);
    }

    /* ── Live preview ── */
    function updatePreview() {
        const nama = document.getElementById('nama_mapel').value.trim();
        const kode = document.getElementById('kode_mapel').value.trim();
        const wrap = document.getElementById('previewWrap');

        if (!nama && !kode) { wrap.classList.remove('visible'); return; }

        const iconText = kode ? kode.substring(0, 3) : nama.substring(0, 2).toUpperCase();
        document.getElementById('previewIcon').textContent = iconText || '—';
        document.getElementById('previewName').textContent = nama || '—';
        document.getElementById('previewCode').textContent = kode || '—';
        wrap.classList.add('visible');
    }

    /* ── Track perubahan per field ── */
    function trackChange(fieldId, dotId) {
        const el  = document.getElementById(fieldId);
        const dot = document.getElementById(dotId);
        const changed = el.value !== original[fieldId];
        if (dot) dot.classList.toggle('visible', changed);

        /* Tampilkan/sembunyikan chip nilai asli */
        const chipId = fieldId === 'nama_mapel' ? 'chipNama' : 'chipKode';
        const chip = document.getElementById(chipId);
        if (chip) chip.style.display = changed ? 'inline-flex' : 'none';

        updateDiff();
        updateSubmitBtn();
    }

    /* ── Update diff panel ── */
    function updateDiff() {
        const fields = [
            { id: 'nama_mapel', label: 'Nama Mapel' },
            { id: 'kode_mapel', label: 'Kode Mapel' },
        ];

        const changes = fields.filter(f => {
            const el = document.getElementById(f.id);
            return el && el.value !== original[f.id];
        });

        const card = document.getElementById('diffCard');
        const body = document.getElementById('diffBody');
        card.classList.toggle('visible', true); /* selalu tampil */

        if (changes.length === 0) {
            body.innerHTML = '<p class="diff-empty">Belum ada perubahan.</p>';
            return;
        }

        body.innerHTML = changes.map(f => {
            const el    = document.getElementById(f.id);
            const oldVal = original[f.id] || '—';
            const newVal = el.value || '—';
            return `
                <div class="diff-row">
                    <span class="diff-field">${f.label}</span>
                    <span class="diff-old">${escHtml(oldVal)}</span>
                    <span class="diff-arrow">→</span>
                    <span class="diff-new">${escHtml(newVal)}</span>
                </div>
            `;
        }).join('');
    }

    /* ── Tombol submit hanya aktif jika ada perubahan ── */
    function updateSubmitBtn() {
        const fields   = ['nama_mapel', 'kode_mapel'];
        const hasChange = fields.some(id => {
            const el = document.getElementById(id);
            return el && el.value !== original[id];
        });
        document.getElementById('submitBtn').disabled = !hasChange;
    }

    function escHtml(str) {
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    /* ── Init on load ── */
    document.addEventListener('DOMContentLoaded', function () {
        const nama = document.getElementById('nama_mapel');
        const kode = document.getElementById('kode_mapel');

        onNamaInput(nama);
        onKodeInput(kode);
        updatePreview();
        updateDiff();
        updateSubmitBtn();

        /* Jika ada old() setelah validation error, tandai perubahan */
        ['nama_mapel', 'kode_mapel'].forEach(id => {
            const el = document.getElementById(id);
            if (el && el.value !== original[id]) {
                const dotId = id === 'nama_mapel' ? 'dotNama' : 'dotKode';
                trackChange(id, dotId);
            }
        });
    });
</script>

</x-app-layout>