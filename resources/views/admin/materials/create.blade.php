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
    .btn-ghost   { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }

    /* Card */
    .form-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
    }
    .form-card-header {
        display: flex; align-items: center; gap: 10px;
        padding: 14px 20px; border-bottom: 1px solid var(--border);
        background: var(--surface2);
    }
    .form-card-title {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
        color: var(--text3); letter-spacing: .07em; text-transform: uppercase;
    }
    .form-card-body { padding: 24px 20px; }

    /* Form Grid */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .form-grid.col-3 { grid-template-columns: 1fr 1fr 1fr; }
    .form-full { grid-column: 1 / -1; }

    /* Form Group */
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700;
        color: var(--text2);
    }
    .form-label .req { color: var(--danger); margin-left: 2px; }
    .form-hint { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: -2px; }

    .form-input, .form-select, .form-textarea {
        font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text);
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 9px 13px;
        outline: none; transition: border-color .15s, box-shadow .15s;
        width: 100%; box-sizing: border-box;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(31,99,219,.08);
    }
    .form-input.is-invalid, .form-select.is-invalid, .form-textarea.is-invalid {
        border-color: var(--danger);
        box-shadow: 0 0 0 3px rgba(220,38,38,.08);
    }
    .form-textarea { resize: vertical; min-height: 100px; line-height: 1.6; }
    select.form-select {
        appearance: none; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg width='12' height='12' fill='none' stroke='%2394a3b8' stroke-width='2' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 12px center; padding-right: 32px;
    }
    .form-error {
        font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--danger);
        display: flex; align-items: center; gap: 4px; margin-top: 2px;
    }

    /* File Upload */
    .file-drop {
        border: 2px dashed var(--border2); border-radius: var(--radius);
        padding: 28px 20px; text-align: center;
        cursor: pointer; transition: border-color .2s, background .2s;
        background: var(--surface2); position: relative;
    }
    .file-drop:hover, .file-drop.drag-over {
        border-color: var(--brand); background: var(--brand-50);
    }
    .file-drop input[type="file"] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .file-drop-icon {
        width: 44px; height: 44px; border-radius: 12px;
        background: var(--surface3); border: 1px solid var(--border2);
        display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;
    }
    .file-drop-title {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--text2);
    }
    .file-drop-sub {
        font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: 4px;
    }
    .file-preview {
        display: none; align-items: center; gap: 12px;
        background: var(--brand-50); border: 1px solid var(--brand-100);
        border-radius: var(--radius-sm); padding: 10px 14px; margin-top: 12px;
    }
    .file-preview.visible { display: flex; }
    .file-preview-icon {
        width: 32px; height: 32px; border-radius: 7px; flex-shrink: 0;
        background: var(--surface); border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
    }
    .file-preview-name {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700;
        color: var(--brand-700); flex: 1; text-align: left;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .file-preview-size {
        font-family: 'DM Sans', sans-serif; font-size: 11.5px; color: var(--text3); flex-shrink: 0;
    }
    .file-clear {
        background: none; border: none; cursor: pointer; color: var(--text3);
        padding: 2px; border-radius: 4px; transition: color .15s; flex-shrink: 0;
    }
    .file-clear:hover { color: var(--danger); }

    /* Divider */
    .form-divider {
        height: 1px; background: var(--border); margin: 20px 0;
    }

    /* Form footer */
    .form-footer {
        display: flex; align-items: center; justify-content: flex-end;
        gap: 10px; padding: 16px 20px; border-top: 1px solid var(--border);
        background: var(--surface2);
    }

    /* Alert error summary */
    .alert-error {
        background: var(--danger-50); border: 1px solid var(--danger-100);
        border-radius: var(--radius-sm); padding: 12px 16px; margin-bottom: 20px;
        display: flex; align-items: flex-start; gap: 10px;
    }
    .alert-error-title {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--danger);
    }
    .alert-error ul {
        margin: 4px 0 0 0; padding-left: 16px;
        font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--danger);
    }

    @media (max-width: 640px) {
        .form-grid, .form-grid.col-3 { grid-template-columns: 1fr; }
        .page { padding: 16px 16px 40px; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.materials.index') }}">Materi Pelajaran</a>
        <span class="sep">›</span>
        <span class="current">Tambah Materi</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Materi</h1>
            <p class="page-sub">Isi form di bawah untuk menambahkan materi pelajaran baru</p>
        </div>
        <a href="{{ route('admin.materials.index') }}" class="btn btn-ghost">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Error summary --}}
    @if($errors->any())
        <div class="alert-error">
            <svg width="16" height="16" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>
                <p class="alert-error-title">Terdapat {{ $errors->count() }} kesalahan pada form:</p>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('admin.materials.store') }}"
          enctype="multipart/form-data" id="materialForm">
        @csrf

        <div class="form-card">
            {{-- Section: Info Materi --}}
            <div class="form-card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                <p class="form-card-title">Informasi Materi</p>
            </div>

            <div class="form-card-body">

                {{-- Judul --}}
                <div class="form-group" style="margin-bottom:18px">
                    <label class="form-label" for="judul">
                        Judul Materi <span class="req">*</span>
                    </label>
                    <input type="text" id="judul" name="judul"
                           class="form-input {{ $errors->has('judul') ? 'is-invalid' : '' }}"
                           value="{{ old('judul') }}"
                           placeholder="Contoh: Pengantar Aljabar Linear">
                    @error('judul')
                        <span class="form-error">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="form-group" style="margin-bottom:18px">
                    <label class="form-label" for="deskripsi">Deskripsi</label>
                    <p class="form-hint">Opsional. Ringkasan singkat isi materi.</p>
                    <textarea id="deskripsi" name="deskripsi"
                              class="form-textarea {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
                              placeholder="Tuliskan deskripsi singkat materi ini…">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <span class="form-error">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-divider"></div>

                {{-- Relasi: Guru, Mapel, Kelas --}}
                <div class="form-grid col-3">

                    {{-- Guru --}}
                    <div class="form-group">
                        <label class="form-label" for="teacher_id">
                            Guru <span class="req">*</span>
                        </label>
                        <select id="teacher_id" name="teacher_id"
                                class="form-select {{ $errors->has('teacher_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Guru —</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}"
                                    {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                            <span class="form-error">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    {{-- Mata Pelajaran --}}
                    <div class="form-group">
                        <label class="form-label" for="subject_id">
                            Mata Pelajaran <span class="req">*</span>
                        </label>
                        <select id="subject_id" name="subject_id"
                                class="form-select {{ $errors->has('subject_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Mapel —</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}"
                                    {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <span class="form-error">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    {{-- Kelas --}}
                    <div class="form-group">
                        <label class="form-label" for="class_id">
                            Kelas <span class="req">*</span>
                        </label>
                        <select id="class_id" name="class_id"
                                class="form-select {{ $errors->has('class_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Kelas —</option>
                            @foreach($classes as $cls)
                                <option value="{{ $cls->id }}"
                                    {{ old('class_id') == $cls->id ? 'selected' : '' }}>
                                    {{ $cls->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <span class="form-error">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-divider"></div>

                {{-- Upload File --}}
                <div class="form-group">
                    <label class="form-label">Upload File</label>
                    <p class="form-hint">Opsional. Format: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, JPG, PNG. Maks. 20 MB.</p>

                    <div class="file-drop {{ $errors->has('file') ? 'is-invalid' : '' }}"
                         id="fileDrop"
                         ondragover="handleDragOver(event)"
                         ondragleave="handleDragLeave(event)"
                         ondrop="handleDrop(event)">
                        <input type="file" name="file" id="fileInput"
                               accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.jpg,.jpeg,.png"
                               onchange="handleFileChange(this)">
                        <div id="fileDropContent">
                            <div class="file-drop-icon">
                                <svg width="20" height="20" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                            </div>
                            <p class="file-drop-title">Klik atau seret file ke sini</p>
                            <p class="file-drop-sub">PDF, DOC, PPT, XLS, ZIP, JPG, PNG · maks. 20 MB</p>
                        </div>
                    </div>

                    {{-- Preview file terpilih --}}
                    <div class="file-preview" id="filePreview">
                        <div class="file-preview-icon" id="filePreviewIcon">
                            <svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <span class="file-preview-name" id="filePreviewName">—</span>
                        <span class="file-preview-size" id="filePreviewSize">—</span>
                        <button type="button" class="file-clear" onclick="clearFile()" title="Hapus file">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                        </button>
                    </div>

                    @error('file')
                        <span class="form-error">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

            </div>{{-- /form-card-body --}}

            {{-- Footer --}}
            <div class="form-footer">
                <a href="{{ route('admin.materials.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan Materi
                </button>
            </div>
        </div>

    </form>
</div>

<script>
    /* ── Drag & Drop ── */
    function handleDragOver(e) {
        e.preventDefault();
        document.getElementById('fileDrop').classList.add('drag-over');
    }
    function handleDragLeave(e) {
        document.getElementById('fileDrop').classList.remove('drag-over');
    }
    function handleDrop(e) {
        e.preventDefault();
        document.getElementById('fileDrop').classList.remove('drag-over');
        const files = e.dataTransfer.files;
        if (files.length) {
            const input = document.getElementById('fileInput');
            const dt = new DataTransfer();
            dt.items.add(files[0]);
            input.files = dt.files;
            showPreview(files[0]);
        }
    }

    /* ── File change ── */
    function handleFileChange(input) {
        if (input.files && input.files[0]) {
            showPreview(input.files[0]);
        }
    }

    /* ── Show preview ── */
    function showPreview(file) {
        const ext = file.name.split('.').pop().toLowerCase();
        const sizeStr = file.size < 1024 * 1024
            ? (file.size / 1024).toFixed(1) + ' KB'
            : (file.size / (1024 * 1024)).toFixed(2) + ' MB';

        document.getElementById('filePreviewName').textContent = file.name;
        document.getElementById('filePreviewSize').textContent = sizeStr;

        /* Icon warna per tipe */
        const iconMap = {
            pdf:  { color: '#b91c1c', path: '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>' },
            doc:  { color: '#1d4ed8', path: '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>' },
            docx: { color: '#1d4ed8', path: '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>' },
            ppt:  { color: '#c2410c', path: '<rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>' },
            pptx: { color: '#c2410c', path: '<rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>' },
            xls:  { color: '#15803d', path: '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="16" y2="17"/>' },
            xlsx: { color: '#15803d', path: '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="16" y2="17"/>' },
            zip:  { color: '#a16207', path: '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>' },
            jpg:  { color: '#7c3aed', path: '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>' },
            jpeg: { color: '#7c3aed', path: '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>' },
            png:  { color: '#7c3aed', path: '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>' },
        };

        const icon = iconMap[ext] || { color: '#94a3b8', path: '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>' };
        document.getElementById('filePreviewIcon').innerHTML =
            `<svg width="14" height="14" fill="none" stroke="${icon.color}" stroke-width="2" viewBox="0 0 24 24">${icon.path}</svg>`;

        document.getElementById('filePreview').classList.add('visible');
    }

    /* ── Clear file ── */
    function clearFile() {
        const input = document.getElementById('fileInput');
        input.value = '';
        document.getElementById('filePreview').classList.remove('visible');
    }

    /* ── Submit loading state ── */
    document.getElementById('materialForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = `
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                 style="animation:spin .8s linear infinite">
                <circle cx="12" cy="12" r="10" stroke-opacity=".25"/>
                <path d="M12 2a10 10 0 0 1 10 10" stroke-opacity="1"/>
            </svg>
            Menyimpan…`;
    });
</script>

<style>
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

</x-app-layout>