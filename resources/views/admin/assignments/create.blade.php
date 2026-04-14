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
        transition: background .15s, filter .15s; white-space: nowrap;
    }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { filter: brightness(.93); }
    .btn-primary:disabled { opacity: .6; cursor: not-allowed; filter: none; }
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
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
        color: var(--text3); letter-spacing: .07em; text-transform: uppercase;
    }
    .card-body { padding: 22px 24px; }

    /* Form layout */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px 20px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.full { grid-column: span 2; }

    .form-label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
        color: var(--text2); letter-spacing: .04em; text-transform: uppercase;
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

    textarea.form-control { resize: vertical; min-height: 110px; line-height: 1.6; }

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

    /* Select preview cards */
    .select-preview {
        display: none; align-items: center; gap: 10px;
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 10px 14px; margin-top: 10px;
    }
    .select-preview.visible { display: flex; }
    .preview-avatar {
        width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 800;
    }
    .preview-avatar.teacher { background: var(--surface3); color: var(--text2); border: 1px solid var(--border2); }
    .preview-avatar.subject { background: #f3e8ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .preview-avatar.class   { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .preview-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .preview-sub  { font-family: 'DM Sans', sans-serif; font-size: 11.5px; color: var(--text3); margin-top: 1px; }

    /* Deadline countdown preview */
    .deadline-preview {
        display: none; align-items: center; gap: 8px;
        border-radius: var(--radius-sm); padding: 10px 14px; margin-top: 10px;
        border: 1px solid;
    }
    .deadline-preview.visible { display: flex; }
    .deadline-preview.ok      { background: var(--brand-50); border-color: var(--brand-100); }
    .deadline-preview.warn    { background: #fffbeb; border-color: #fde68a; }
    .deadline-preview.error   { background: var(--danger-50); border-color: var(--danger-100); }
    .deadline-text {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
    }
    .deadline-preview.ok    .deadline-text { color: var(--brand-700); }
    .deadline-preview.warn  .deadline-text { color: #92400e; }
    .deadline-preview.error .deadline-text { color: var(--danger); }

    /* Char counter */
    .char-counter {
        font-family: 'DM Sans', sans-serif; font-size: 11.5px; color: var(--text3);
        text-align: right; margin-top: 3px;
    }
    .char-counter.warn { color: #a16207; }
    .char-counter.over { color: var(--danger); }

    /* Summary card */
    .summary-card {
        display: none;
        background: var(--brand-50); border: 1px solid var(--brand-100);
        border-radius: var(--radius); padding: 16px 20px; margin-bottom: 16px;
    }
    .summary-card.visible { display: block; }
    .summary-title {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700;
        color: var(--brand-700); letter-spacing: .07em; text-transform: uppercase; margin-bottom: 12px;
        display: flex; align-items: center; gap: 6px;
    }
    .summary-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; }
    .summary-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 10.5px; font-weight: 700; color: var(--brand-700); text-transform: uppercase; letter-spacing: .05em; margin-bottom: 3px; }
    .summary-val   { font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text); font-weight: 500; }

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
        .summary-grid { grid-template-columns: 1fr 1fr; }
    }

    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.assignments.index') }}">Tugas</a>
        <span class="sep">›</span>
        <span class="current">Tambah Tugas</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Tugas Baru</h1>
            <p class="page-sub">Isi form di bawah untuk membuat tugas baru bagi siswa</p>
        </div>
        <a href="{{ route('admin.assignments.index') }}" class="btn btn-ghost">
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

    <form method="POST" action="{{ route('admin.assignments.store') }}" id="assignmentForm">
        @csrf

        {{-- Section 1: Info Tugas --}}
        <div class="form-card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
                <p class="card-title">Informasi Tugas</p>
            </div>
            <div class="card-body">
                <div class="form-grid">

                    {{-- Judul --}}
                    <div class="form-group full">
                        <label class="form-label" for="judul">
                            Judul Tugas <span class="req">*</span>
                        </label>
                        <input
                            type="text" id="judul" name="judul"
                            value="{{ old('judul') }}"
                            placeholder="Masukkan judul tugas yang jelas dan deskriptif…"
                            maxlength="255"
                            class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}"
                            oninput="countChars(this, 'judulCounter', 255); updateSummary()"
                            autocomplete="off"
                        >
                        <div class="char-counter" id="judulCounter">0 / 255</div>
                        @error('judul')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="form-group full">
                        <label class="form-label" for="deskripsi">Deskripsi / Instruksi Tugas</label>
                        <textarea
                            id="deskripsi" name="deskripsi"
                            placeholder="Tuliskan petunjuk pengerjaan, referensi, atau keterangan tambahan…"
                            class="form-control {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
                        >{{ old('deskripsi') }}</textarea>
                        <p class="form-hint">Opsional. Dapat berisi instruksi pengerjaan, referensi, atau format pengumpulan.</p>
                        @error('deskripsi')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- Section 2: Mata Pelajaran, Kelas, Guru --}}
        <div class="form-card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                </svg>
                <p class="card-title">Target & Pengajar</p>
            </div>
            <div class="card-body">
                <div class="form-grid">

                    {{-- Mata Pelajaran --}}
                    <div class="form-group">
                        <label class="form-label" for="subject_id">
                            Mata Pelajaran <span class="req">*</span>
                        </label>
                        <select name="subject_id" id="subject_id"
                            class="form-control {{ $errors->has('subject_id') ? 'is-invalid' : '' }}"
                            onchange="previewSelect('subject', this, 'nama_mapel', 'kode_mapel')">
                            <option value="">— Pilih mata pelajaran —</option>
                            @foreach($subjects as $subject)
                                <option
                                    value="{{ $subject->id }}"
                                    data-nama="{{ $subject->nama_mapel }}"
                                    data-sub="{{ $subject->kode_mapel ?? 'Tidak ada kode' }}"
                                    {{ old('subject_id') == $subject->id ? 'selected' : '' }}
                                >
                                    {{ $subject->nama_mapel }}
                                    @if($subject->kode_mapel) ({{ $subject->kode_mapel }}) @endif
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <div class="select-preview" id="subjectPreview">
                            <div class="preview-avatar subject" id="subjectInit">?</div>
                            <div>
                                <p class="preview-name" id="subjectName">—</p>
                                <p class="preview-sub"  id="subjectSub">—</p>
                            </div>
                        </div>
                    </div>

                    {{-- Kelas --}}
                    <div class="form-group">
                        <label class="form-label" for="class_id">
                            Kelas <span class="req">*</span>
                        </label>
                        <select name="class_id" id="class_id"
                            class="form-control {{ $errors->has('class_id') ? 'is-invalid' : '' }}"
                            onchange="previewSelect('class', this)">
                            <option value="">— Pilih kelas —</option>
                            @foreach($classes as $class)
                                <option
                                    value="{{ $class->id }}"
                                    data-nama="{{ $class->nama_kelas }}"
                                    data-sub="{{ trim(($class->tingkat ?? '') . ' ' . ($class->jurusan ?? '')) ?: 'Tidak ada info tambahan' }}"
                                    {{ old('class_id') == $class->id ? 'selected' : '' }}
                                >
                                    {{ $class->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <div class="select-preview" id="classPreview">
                            <div class="preview-avatar class" id="classInit">?</div>
                            <div>
                                <p class="preview-name" id="className">—</p>
                                <p class="preview-sub"  id="classSub">—</p>
                            </div>
                        </div>
                    </div>

                    {{-- Guru --}}
                    <div class="form-group full">
                        <label class="form-label" for="teacher_id">
                            Guru Pemberi Tugas <span class="req">*</span>
                        </label>
                        <select name="teacher_id" id="teacher_id"
                            class="form-control {{ $errors->has('teacher_id') ? 'is-invalid' : '' }}"
                            onchange="previewSelect('teacher', this)">
                            <option value="">— Pilih guru —</option>
                            @foreach($teachers as $teacher)
                                <option
                                    value="{{ $teacher->id }}"
                                    data-nama="{{ $teacher->nama_lengkap }}"
                                    data-sub="NIP: {{ $teacher->nip }}"
                                    {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}
                                >
                                    {{ $teacher->nama_lengkap }} ({{ $teacher->nip }})
                                </option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                            <p class="form-error">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <div class="select-preview" id="teacherPreview">
                            <div class="preview-avatar teacher" id="teacherInit">?</div>
                            <div>
                                <p class="preview-name" id="teacherName">—</p>
                                <p class="preview-sub"  id="teacherSub">—</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Section 3: Deadline --}}
        <div class="form-card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                <p class="card-title">Batas Waktu Pengumpulan</p>
            </div>
            <div class="card-body">
                <div class="form-group" style="max-width:340px">
                    <label class="form-label" for="deadline">
                        Deadline <span class="req">*</span>
                    </label>
                    <input
                        type="datetime-local" id="deadline" name="deadline"
                        value="{{ old('deadline') }}"
                        min="{{ now()->format('Y-m-d\TH:i') }}"
                        class="form-control {{ $errors->has('deadline') ? 'is-invalid' : '' }}"
                        onchange="previewDeadline()"
                    >
                    <p class="form-hint">Deadline harus setelah waktu sekarang.</p>
                    @error('deadline')
                        <p class="form-error">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </p>
                    @enderror

                    {{-- Deadline preview --}}
                    <div class="deadline-preview" id="deadlinePreview">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" id="deadlineIcon">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <span class="deadline-text" id="deadlineText">—</span>
                    </div>
                </div>

                {{-- Quick deadline buttons --}}
                <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:14px">
                    <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;align-self:center">
                        Cepat:
                    </p>
                    @foreach([
                        ['1 Hari',   1,  'day'],
                        ['3 Hari',   3,  'day'],
                        ['1 Minggu', 7,  'day'],
                        ['2 Minggu', 14, 'day'],
                        ['1 Bulan',  30, 'day'],
                    ] as [$label, $val, $unit])
                        <button type="button"
                                class="btn btn-ghost btn-sm"
                                onclick="setDeadline({{ $val }})">
                            + {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Footer --}}
            <div class="form-footer">
                <a href="{{ route('admin.assignments.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Simpan Tugas
                </button>
            </div>
        </div>

    </form>

    {{-- Summary card --}}
    <div class="summary-card" id="summaryCard">
        <p class="summary-title">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </svg>
            Ringkasan Tugas
        </p>
        <div class="summary-grid">
            <div style="grid-column:span 3">
                <p class="summary-label">Judul</p>
                <p class="summary-val" id="sumJudul">—</p>
            </div>
            <div>
                <p class="summary-label">Mata Pelajaran</p>
                <p class="summary-val" id="sumMapel">—</p>
            </div>
            <div>
                <p class="summary-label">Kelas</p>
                <p class="summary-val" id="sumKelas">—</p>
            </div>
            <div>
                <p class="summary-label">Guru</p>
                <p class="summary-val" id="sumGuru">—</p>
            </div>
            <div style="grid-column:span 3">
                <p class="summary-label">Deadline</p>
                <p class="summary-val" id="sumDeadline">—</p>
            </div>
        </div>
    </div>

</div>

<script>
    /* ── Generic select preview ── */
    function previewSelect(type, sel) {
        const preview = document.getElementById(type + 'Preview');
        if (!sel.value) { preview.classList.remove('visible'); updateSummary(); return; }
        const opt  = sel.options[sel.selectedIndex];
        const nama = opt.dataset.nama || '—';
        const sub  = opt.dataset.sub  || '—';
        document.getElementById(type + 'Init').textContent = nama.substring(0, type === 'teacher' ? 1 : 2).toUpperCase();
        document.getElementById(type + 'Name').textContent = nama;
        document.getElementById(type + 'Sub').textContent  = sub;
        preview.classList.add('visible');
        updateSummary();
    }

    /* ── Deadline preview ── */
    function previewDeadline() {
        const val     = document.getElementById('deadline').value;
        const preview = document.getElementById('deadlinePreview');
        if (!val) { preview.classList.remove('visible'); updateSummary(); return; }

        const chosen = new Date(val);
        const now    = new Date();
        const diffMs = chosen - now;
        const diffH  = diffMs / 1000 / 3600;

        preview.classList.remove('ok', 'warn', 'error');
        preview.classList.add('visible');

        if (diffMs <= 0) {
            preview.classList.add('error');
            document.getElementById('deadlineText').textContent = '⚠ Deadline sudah lewat, pilih waktu yang lebih lambat';
        } else if (diffH < 24) {
            preview.classList.add('warn');
            const h = Math.floor(diffH), m = Math.floor((diffH - h) * 60);
            document.getElementById('deadlineText').textContent =
                `⚠ Deadline sangat dekat: ${h > 0 ? h + ' jam ' : ''}${m} menit lagi`;
        } else {
            preview.classList.add('ok');
            const days = Math.floor(diffH / 24);
            const hrs  = Math.floor(diffH % 24);
            document.getElementById('deadlineText').textContent =
                `Tenggat waktu: ${days > 0 ? days + ' hari ' : ''}${hrs > 0 ? hrs + ' jam ' : ''}lagi`;
        }
        updateSummary();
    }

    /* ── Quick deadline setter ── */
    function setDeadline(days) {
        const d = new Date();
        d.setDate(d.getDate() + days);
        d.setHours(23, 59, 0, 0);
        const pad = n => String(n).padStart(2, '0');
        document.getElementById('deadline').value =
            `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
        previewDeadline();
    }

    /* ── Char counter ── */
    function countChars(el, counterId, max) {
        const len = el.value.length;
        const counter = document.getElementById(counterId);
        counter.textContent = len + ' / ' + max;
        counter.className = 'char-counter' + (len > max * 0.9 ? (len >= max ? ' over' : ' warn') : '');
    }

    /* ── Summary updater ── */
    function updateSummary() {
        const judul   = document.getElementById('judul').value.trim();
        const subSel  = document.getElementById('subject_id');
        const clsSel  = document.getElementById('class_id');
        const tchSel  = document.getElementById('teacher_id');
        const dlVal   = document.getElementById('deadline').value;

        const mapel   = subSel.value ? subSel.options[subSel.selectedIndex].dataset.nama : '';
        const kelas   = clsSel.value ? clsSel.options[clsSel.selectedIndex].dataset.nama  : '';
        const guru    = tchSel.value ? tchSel.options[tchSel.selectedIndex].dataset.nama  : '';

        const hasAny  = judul || mapel || kelas || guru || dlVal;
        const card    = document.getElementById('summaryCard');
        if (!hasAny) { card.classList.remove('visible'); return; }
        card.classList.add('visible');

        document.getElementById('sumJudul').textContent   = judul  || '—';
        document.getElementById('sumMapel').textContent   = mapel  || '—';
        document.getElementById('sumKelas').textContent   = kelas  || '—';
        document.getElementById('sumGuru').textContent    = guru   || '—';

        if (dlVal) {
            const d = new Date(dlVal);
            document.getElementById('sumDeadline').textContent =
                d.toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' })
                + ', ' + d.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' }) + ' WIB';
        } else {
            document.getElementById('sumDeadline').textContent = '—';
        }
    }

    /* ── Submit animation ── */
    document.getElementById('assignmentForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled  = true;
        btn.innerHTML = `
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                 style="animation:spin .7s linear infinite">
                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
            </svg>
            Menyimpan…`;
    });

    /* ── Init old() values ── */
    document.addEventListener('DOMContentLoaded', function () {
        const subSel = document.getElementById('subject_id');
        const clsSel = document.getElementById('class_id');
        const tchSel = document.getElementById('teacher_id');
        const judul  = document.getElementById('judul');

        if (subSel.value) previewSelect('subject', subSel);
        if (clsSel.value) previewSelect('class',   clsSel);
        if (tchSel.value) previewSelect('teacher',  tchSel);
        if (judul.value)  countChars(judul, 'judulCounter', 255);
        previewDeadline();
        updateSummary();
    });
</script>

</x-app-layout>