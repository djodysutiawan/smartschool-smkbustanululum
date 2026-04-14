<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
    .page { padding: 28px 28px 60px; max-width: 5000px; margin: 0 auto; }

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
    .header-actions { display: flex; gap: 8px; }

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
    .btn-danger  { background: var(--red-bg); color: var(--red); border: 1px solid var(--red-border); padding: 8px 14px; font-size: 13px; }
    .btn-danger:hover { background: var(--red-border); }

    /* ── Alert ── */
    .alert {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px;
        font-size: 13.5px; background: var(--red-bg); color: var(--red); border: 1px solid var(--red-border);
    }
    .alert svg { flex-shrink: 0; margin-top: 1px; }

    /* ── Warning banner ── */
    .warning-banner {
        display: flex; align-items: flex-start; gap: 12px;
        padding: 14px 18px; border-radius: var(--radius-sm);
        background: #fffbeb; border: 1px solid #fde68a;
        margin-bottom: 20px;
    }
    .warning-banner-text {
        font-family: 'DM Sans', sans-serif; font-size: 13px; color: #92400e; line-height: 1.6;
    }
    .warning-banner-text strong {
        font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #78350f;
    }

    /* ── Info banner (data saat ini) ── */
    .info-banner {
        display: flex; align-items: center; gap: 14px;
        padding: 14px 18px; border-radius: var(--radius-sm);
        background: var(--brand-50); border: 1px solid var(--brand-100);
        margin-bottom: 20px; flex-wrap: wrap;
    }
    .info-banner-icon {
        width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
        background: var(--brand-100); display: flex; align-items: center; justify-content: center;
    }
    .info-banner-label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
        color: var(--brand-700); letter-spacing: .06em; text-transform: uppercase; margin-bottom: 3px;
    }
    .info-banner-value {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 800; color: var(--text);
    }
    .info-banner-badges { display: flex; gap: 6px; margin-left: auto; flex-wrap: wrap; }
    .info-badge {
        display: inline-flex; align-items: center; padding: 3px 12px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
    }

    /* ── Form card ── */
    .form-card       { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .form-section    { padding: 20px 24px 24px; }

    .section-label {
        display: flex; align-items: center; gap: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
        color: var(--text3); letter-spacing: .07em; text-transform: uppercase; margin-bottom: 16px;
    }
    .section-label-line { flex: 1; height: 1px; background: var(--border); }

    /* ── Fields ── */
    .field { display: flex; flex-direction: column; gap: 6px; }
    .field label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px;
        font-weight: 700; color: var(--text2);
    }
    .field label .req { color: var(--brand); margin-left: 2px; }
    .field input {
        height: 38px; padding: 0 12px;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif; font-size: 13.5px;
        color: var(--text); background: var(--surface2); width: 100%;
        outline: none; transition: border-color .15s, background .15s;
    }
    .field input:focus {
        border-color: var(--brand-h); background: #fff;
        box-shadow: 0 0 0 3px rgba(53,130,240,.1);
    }
    .field input::placeholder { color: var(--text3); }
    .field input.is-invalid { border-color: var(--red); background: #fff8f8; }
    .field-error { font-size: 12px; color: var(--red); font-family: 'DM Sans', sans-serif; margin-top: -2px; }
    .field-hint  { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; margin-top: -2px; }

    /* ── Pill selectors ── */
    .pill-group { display: flex; gap: 10px; flex-wrap: wrap; }
    .pill-item  { position: relative; }
    .pill-item input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
    .pill-item label {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 20px; border-radius: var(--radius-sm);
        border: 1.5px solid var(--border); background: var(--surface2);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700;
        color: var(--text2); cursor: pointer; transition: all .15s; user-select: none;
        min-width: 140px;
    }
    .pill-item label:hover { background: var(--surface3); border-color: var(--border2); }
    .pill-item input[type="radio"]:checked + label {
        border-color: var(--brand); background: var(--brand-50);
        color: var(--brand-700); box-shadow: 0 0 0 3px rgba(53,130,240,.1);
    }
    .pill-item.status-aktif input[type="radio"]:checked + label {
        border-color: #16a34a; background: #f0fdf4;
        color: #15803d; box-shadow: 0 0 0 3px rgba(22,163,74,.1);
    }
    .pill-item.status-nonaktif input[type="radio"]:checked + label {
        border-color: var(--border2); background: var(--surface3);
        color: var(--text2); box-shadow: none;
    }
    .pill-icon {
        width: 28px; height: 28px; border-radius: 7px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }

    /* ── Preview card ── */
    .preview-card {
        background: var(--surface2); border: 1px dashed var(--border2);
        border-radius: var(--radius); padding: 16px 20px;
        display: flex; align-items: center; gap: 16px;
        margin-top: 20px; transition: all .2s;
    }
    .preview-card.has-data { background: var(--brand-50); border-color: var(--brand-100); border-style: solid; }
    .preview-icon {
        width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
        background: var(--brand-100); display: flex; align-items: center; justify-content: center;
    }
    .preview-tahun { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 17px; font-weight: 800; color: var(--text); }
    .preview-tahun.placeholder { color: var(--text3); font-weight: 600; font-size: 14px; }
    .preview-meta { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 4px; }
    .preview-badge {
        display: inline-flex; align-items: center; padding: 2px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
    }

    /* ── Form footer ── */
    .form-footer {
        display: flex; align-items: center; justify-content: space-between; gap: 10px;
        padding: 16px 24px; background: var(--surface2); border-top: 1px solid var(--border);
        flex-wrap: wrap;
    }
    .footer-right { display: flex; gap: 10px; }

    /* ── Responsive ── */
    @media (max-width: 680px) {
        .page { padding: 16px 16px 40px; }
        .pill-group { flex-direction: column; }
        .pill-item label { min-width: unset; width: 100%; }
        .form-footer { flex-direction: column; align-items: stretch; }
        .footer-right { flex-direction: column; }
    }

    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.academic-years.index') }}">Tahun Ajaran</a>
        <span class="sep">›</span>
        <span class="current">Edit Tahun Ajaran</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Tahun Ajaran</h1>
            <p class="page-sub">Perbarui data tahun ajaran, lalu klik Simpan Perubahan</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.academic-years.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Info banner: data saat ini --}}
    <div class="info-banner">
        <div class="info-banner-icon">
            <svg width="18" height="18" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
        </div>
        <div>
            <p class="info-banner-label">Data Saat Ini</p>
            <p class="info-banner-value">{{ $year->tahun }}</p>
        </div>
        <div class="info-banner-badges">
            @if($year->semester === 'Ganjil')
                <span class="info-badge" style="background:#dbeafe;color:#1d4ed8">Semester Ganjil</span>
            @else
                <span class="info-badge" style="background:#f3e8ff;color:#7c3aed">Semester Genap</span>
            @endif
            @if($year->status === 'aktif')
                <span class="info-badge" style="background:#dcfce7;color:#15803d">● Aktif</span>
            @else
                <span class="info-badge" style="background:var(--surface3);color:var(--text2)">○ Tidak Aktif</span>
            @endif
            @if(isset($year->students_count))
                <span class="info-badge" style="background:var(--brand-50);color:var(--brand-700)">
                    {{ $year->students_count }} siswa
                </span>
            @endif
        </div>
    </div>

    {{-- Warning banner --}}
    <div class="warning-banner">
        <svg width="16" height="16" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
            <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
        </svg>
        <p class="warning-banner-text">
            <strong>Perhatian:</strong> Jika status diubah ke <strong>Aktif</strong>,
            semua tahun ajaran lain akan otomatis dinonaktifkan. Pastikan data sudah benar sebelum menyimpan.
        </p>
    </div>

    {{-- Inline error fallback --}}
    @if($errors->any())
        <div class="alert">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
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

    <form action="{{ route('admin.academic-years.update', $year->id) }}" method="POST" id="yearForm">
        @csrf
        @method('PUT')

        <div class="form-card">

            {{-- ═══ DATA TAHUN AJARAN ═══ --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    Data Tahun Ajaran
                    <span class="section-label-line"></span>
                </p>

                {{-- Tahun --}}
                <div class="field" style="margin-bottom:20px">
                    <label>Tahun Ajaran <span class="req">*</span></label>
                    <input
                        type="text" name="tahun" id="inputTahun"
                        value="{{ old('tahun', $year->tahun) }}"
                        placeholder="cth. 2024/2025"
                        maxlength="20"
                        oninput="updatePreview()"
                        class="{{ $errors->has('tahun') ? 'is-invalid' : '' }}"
                        style="max-width:300px"
                    >
                    <span class="field-hint">Format: 2024/2025 atau 2024-2025</span>
                    @error('tahun')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                {{-- Semester --}}
                <div class="field" style="margin-bottom:20px">
                    <label>Semester <span class="req">*</span></label>
                    <div class="pill-group">
                        <div class="pill-item">
                            <input type="radio" name="semester" id="sem_ganjil" value="Ganjil"
                                {{ old('semester', $year->semester) === 'Ganjil' ? 'checked' : '' }}
                                onchange="updatePreview()">
                            <label for="sem_ganjil">
                                <div class="pill-icon" style="background:#dbeafe">
                                    <svg width="14" height="14" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                        <path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
                                    </svg>
                                </div>
                                Semester Ganjil
                            </label>
                        </div>
                        <div class="pill-item">
                            <input type="radio" name="semester" id="sem_genap" value="Genap"
                                {{ old('semester', $year->semester) === 'Genap' ? 'checked' : '' }}
                                onchange="updatePreview()">
                            <label for="sem_genap">
                                <div class="pill-icon" style="background:#f3e8ff">
                                    <svg width="14" height="14" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                        <path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
                                    </svg>
                                </div>
                                Semester Genap
                            </label>
                        </div>
                    </div>
                    @error('semester')<span class="field-error" style="margin-top:4px;display:block">{{ $message }}</span>@enderror
                </div>

                {{-- Status --}}
                <div class="field" style="margin-bottom:4px">
                    <label>Status <span class="req">*</span></label>
                    <div class="pill-group">
                        <div class="pill-item status-nonaktif">
                            <input type="radio" name="status" id="status_nonaktif" value="tidak_aktif"
                                {{ old('status', $year->status) === 'tidak_aktif' ? 'checked' : '' }}
                                onchange="updatePreview()">
                            <label for="status_nonaktif">
                                <div class="pill-icon" style="background:var(--surface3)">
                                    <svg width="14" height="14" fill="none" stroke="#475569" stroke-width="2" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="15" y1="9" x2="9" y2="15"/>
                                        <line x1="9" y1="9" x2="15" y2="15"/>
                                    </svg>
                                </div>
                                Tidak Aktif
                            </label>
                        </div>
                        <div class="pill-item status-aktif">
                            <input type="radio" name="status" id="status_aktif" value="aktif"
                                {{ old('status', $year->status) === 'aktif' ? 'checked' : '' }}
                                onchange="updatePreview()">
                            <label for="status_aktif">
                                <div class="pill-icon" style="background:#dcfce7">
                                    <svg width="14" height="14" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                </div>
                                Aktif
                            </label>
                        </div>
                    </div>
                    <span class="field-hint" style="margin-top:6px">
                        Hanya satu tahun ajaran yang bisa aktif dalam satu waktu
                    </span>
                    @error('status')<span class="field-error" style="margin-top:4px;display:block">{{ $message }}</span>@enderror
                </div>

                {{-- Live preview --}}
                <div class="preview-card has-data" id="previewCard">
                    <div class="preview-icon">
                        <svg width="20" height="20" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <div>
                        <p class="preview-tahun" id="previewTahun">{{ old('tahun', $year->tahun) }}</p>
                        <div class="preview-meta" id="previewMeta">
                            <span class="preview-badge" id="previewSemester"></span>
                            <span class="preview-badge" id="previewStatus"></span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ═══ FOOTER ═══ --}}
            <div class="form-footer">
                {{-- Hapus di kiri --}}
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14H6L5 6"/>
                        <path d="M10 11v6m4-6v6M9 6V4h6v2"/>
                    </svg>
                    Hapus
                </button>

                {{-- Simpan di kanan --}}
                <div class="footer-right">
                    <a href="{{ route('admin.academic-years.index') }}" class="btn btn-cancel">Batal</a>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>

        </div>
    </form>

    {{-- Hidden delete form --}}
    <form id="deleteForm" method="POST"
          action="{{ route('admin.academic-years.destroy', $year->id) }}" style="display:none">
        @csrf @method('DELETE')
    </form>

</div>

<script>
    /* ── Live preview ── */
    function updatePreview() {
        const tahun    = document.getElementById('inputTahun').value.trim();
        const semester = document.querySelector('input[name="semester"]:checked')?.value ?? '';
        const status   = document.querySelector('input[name="status"]:checked')?.value ?? '';
        const card     = document.getElementById('previewCard');
        const pTahun   = document.getElementById('previewTahun');
        const pMeta    = document.getElementById('previewMeta');
        const pSem     = document.getElementById('previewSemester');
        const pStatus  = document.getElementById('previewStatus');

        if (!tahun) {
            card.classList.remove('has-data');
            pTahun.textContent  = 'Tahun ajaran akan muncul di sini';
            pTahun.className    = 'preview-tahun placeholder';
            pMeta.style.display = 'none';
            return;
        }

        card.classList.add('has-data');
        pTahun.textContent  = tahun;
        pTahun.className    = 'preview-tahun';
        pMeta.style.display = 'flex';

        if (semester === 'Ganjil') {
            pSem.textContent      = 'Semester Ganjil';
            pSem.style.background = '#dbeafe';
            pSem.style.color      = '#1d4ed8';
        } else if (semester === 'Genap') {
            pSem.textContent      = 'Semester Genap';
            pSem.style.background = '#f3e8ff';
            pSem.style.color      = '#7c3aed';
        } else {
            pSem.textContent = '';
        }

        if (status === 'aktif') {
            pStatus.textContent      = '● Aktif';
            pStatus.style.background = '#dcfce7';
            pStatus.style.color      = '#15803d';
        } else {
            pStatus.textContent      = '○ Tidak Aktif';
            pStatus.style.background = 'var(--surface3)';
            pStatus.style.color      = 'var(--text2)';
        }
    }

    /* ── Init preview dengan data existing ── */
    updatePreview();

    /* ── Disable submit saat proses ── */
    document.getElementById('yearForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled  = true;
        btn.innerHTML = `
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                 style="animation:spin .7s linear infinite">
                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
            </svg>
            Menyimpan…`;
    });

    /* ── Konfirmasi hapus ── */
    function confirmDelete() {
        Swal.fire({
            title: 'Hapus Tahun Ajaran?',
            html: `Tahun ajaran <b>{{ $year->tahun }}</b> semester <b>{{ $year->semester }}</b> akan dihapus permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
        }).then(r => {
            if (r.isConfirmed) document.getElementById('deleteForm').submit();
        });
    }
</script>

</x-app-layout>