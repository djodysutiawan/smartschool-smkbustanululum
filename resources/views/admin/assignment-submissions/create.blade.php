<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db; --brand-h:#3582f0; --brand-50:#eef6ff; --brand-100:#d9ebff; --brand-700:#1750c0;
        --surface:#fff; --surface2:#f8fafc; --surface3:#f1f5f9;
        --border:#e2e8f0; --border2:#cbd5e1;
        --text:#0f172a; --text2:#475569; --text3:#94a3b8;
        --radius:10px; --radius-sm:7px;
        --danger:#dc2626; --danger-50:#fee2e2; --danger-100:#fecaca;
        --success:#16a34a; --success-50:#dcfce7; --success-100:#bbf7d0;
        --purple:#7c3aed; --purple-50:#f3e8ff; --purple-100:#e9d5ff;
    }
    .page { padding:28px 28px 60px; max-width:800px; margin:0 auto; }
    .breadcrumb { display:flex; align-items:center; gap:6px; font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:600; color:var(--text3); margin-bottom:20px; }
    .breadcrumb a { color:var(--text3); text-decoration:none; transition:color .15s; }
    .breadcrumb a:hover { color:var(--brand); }
    .breadcrumb .sep { color:var(--border2); }
    .breadcrumb .current { color:var(--text2); }
    .page-header { margin-bottom:24px; }
    .page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:20px; font-weight:800; color:var(--text); }
    .page-sub   { font-size:12.5px; color:var(--text3); margin-top:3px; }

    .card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; margin-bottom:16px; }
    .card-header { padding:14px 20px; border-bottom:1px solid var(--border); background:var(--surface2); display:flex; align-items:center; gap:8px; }
    .card-title  { font-family:'Plus Jakarta Sans',sans-serif; font-size:12px; font-weight:700; color:var(--text3); letter-spacing:.07em; text-transform:uppercase; }
    .card-body   { padding:24px; }

    .form-group  { margin-bottom:18px; }
    .form-label  { display:block; font-family:'Plus Jakarta Sans',sans-serif; font-size:12px; font-weight:700; color:var(--text2); margin-bottom:7px; text-transform:uppercase; letter-spacing:.05em; }
    .form-label span { color:var(--danger); margin-left:2px; }
    .form-input, .form-select, .form-textarea {
        width:100%; font-family:'DM Sans',sans-serif; font-size:13.5px; color:var(--text);
        background:var(--surface2); border:1px solid var(--border); border-radius:var(--radius-sm);
        padding:10px 14px; outline:none; transition:border-color .15s; box-sizing:border-box;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus { border-color:var(--brand); background:var(--surface); }
    .form-input.is-invalid, .form-select.is-invalid { border-color:var(--danger); }
    .form-textarea { resize:vertical; min-height:100px; }
    .form-select { appearance:none; cursor:pointer; background-image:url("data:image/svg+xml,%3Csvg width='12' height='12' fill='none' stroke='%2394a3b8' stroke-width='2' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 12px center; padding-right:32px; }
    .form-hint  { font-family:'DM Sans',sans-serif; font-size:12px; color:var(--text3); margin-top:5px; }
    .error-msg  { font-family:'DM Sans',sans-serif; font-size:12px; color:var(--danger); margin-top:5px; }

    .form-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    @media (max-width:600px) { .form-grid-2 { grid-template-columns:1fr; } }

    /* File upload */
    .file-upload-area {
        border:2px dashed var(--border2); border-radius:var(--radius-sm); padding:24px;
        text-align:center; cursor:pointer; transition:border-color .15s, background .15s;
        background:var(--surface2);
    }
    .file-upload-area:hover { border-color:var(--brand); background:var(--brand-50); }
    .file-upload-area input { display:none; }
    .file-upload-icon { margin:0 auto 10px; width:38px; height:38px; border-radius:10px; background:var(--purple-50); border:1px solid var(--purple-100); display:flex; align-items:center; justify-content:center; }
    .file-upload-text { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; color:var(--text2); }
    .file-upload-sub  { font-size:12px; color:var(--text3); font-family:'DM Sans',sans-serif; margin-top:4px; }
    .file-selected    { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; color:var(--brand); margin-top:8px; }

    /* Action buttons */
    .form-actions { display:flex; gap:10px; justify-content:flex-end; margin-top:8px; }
    .btn { display:inline-flex; align-items:center; gap:6px; padding:10px 20px; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; border:none; text-decoration:none; transition:background .15s; white-space:nowrap; }
    .btn-primary { background:var(--brand); color:#fff; }
    .btn-primary:hover { background:var(--brand-h); }
    .btn-ghost   { background:var(--surface2); color:var(--text2); border:1px solid var(--border); }
    .btn-ghost:hover { background:var(--surface3); }

    /* Alert errors */
    .alert-error { background:var(--danger-50); border:1px solid var(--danger-100); border-radius:var(--radius-sm); padding:14px 16px; margin-bottom:20px; }
    .alert-error-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; color:var(--danger); margin-bottom:8px; }
    .alert-error ul { margin:0; padding-left:18px; }
    .alert-error li { font-family:'DM Sans',sans-serif; font-size:13px; color:var(--danger); }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.assignment-submissions.index') }}">Submission</a>
        <span class="sep">›</span>
        <span class="current">Tambah Submission</span>
    </nav>

    <div class="page-header">
        <h1 class="page-title">Tambah Submission</h1>
        <p class="page-sub">Tambahkan submission tugas secara manual</p>
    </div>

    {{-- Error bag --}}
    @if($errors->any())
        <div class="alert-error">
            <p class="alert-error-title">Terdapat {{ $errors->count() }} kesalahan:</p>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.assignment-submissions.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Tugas & Siswa --}}
        <div class="card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <p class="card-title">Informasi Submission</p>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Tugas <span>*</span></label>
                    <select name="assignment_id" class="form-select {{ $errors->has('assignment_id') ? 'is-invalid' : '' }}">
                        <option value="">— Pilih Tugas —</option>
                        @foreach($assignments as $assignment)
                            <option value="{{ $assignment->id }}" {{ (old('assignment_id', $assignment?->id ?? '') == $assignment->id) ? 'selected' : '' }}>
                                {{ $assignment->judul }}
                                @if($assignment->subject) ({{ $assignment->subject->nama_mapel }}) @endif
                            </option>
                        @endforeach
                    </select>
                    @error('assignment_id') <p class="error-msg">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Siswa <span>*</span></label>
                    <select name="student_id" class="form-select {{ $errors->has('student_id') ? 'is-invalid' : '' }}">
                        <option value="">— Pilih Siswa —</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->nama_lengkap }} ({{ $student->nisn ?? $student->nis }})
                            </option>
                        @endforeach
                    </select>
                    @error('student_id') <p class="error-msg">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- File --}}
        <div class="card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                <p class="card-title">File Submission</p>
            </div>
            <div class="card-body">
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Upload File</label>
                    <label class="file-upload-area" for="fileInput">
                        <input type="file" id="fileInput" name="file" accept=".pdf,.doc,.docx,.zip,.png,.jpg,.jpeg" onchange="showFileName(this)">
                        <div class="file-upload-icon">
                            <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        </div>
                        <p class="file-upload-text">Klik untuk upload file</p>
                        <p class="file-upload-sub">PDF, DOC, DOCX, ZIP, PNG, JPG (maks. 10MB)</p>
                        <p class="file-selected" id="fileName" style="display:none"></p>
                    </label>
                    @error('file') <p class="error-msg">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Penilaian --}}
        <div class="card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                <p class="card-title">Penilaian</p>
            </div>
            <div class="card-body">
                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Nilai (0–100)</label>
                        <input type="number" name="nilai" min="0" max="100" class="form-input {{ $errors->has('nilai') ? 'is-invalid' : '' }}"
                               value="{{ old('nilai') }}" placeholder="Kosongkan jika belum dinilai">
                        @error('nilai') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status <span>*</span></label>
                        <select name="status" class="form-select {{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <option value="submitted" {{ old('status','submitted') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                            <option value="graded"    {{ old('status') === 'graded'    ? 'selected' : '' }}>Graded</option>
                            <option value="returned"  {{ old('status') === 'returned'  ? 'selected' : '' }}>Returned</option>
                        </select>
                        @error('status') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">Waktu Pengumpulan</label>
                    <input type="datetime-local" name="submitted_at" class="form-input {{ $errors->has('submitted_at') ? 'is-invalid' : '' }}"
                           value="{{ old('submitted_at', now()->format('Y-m-d\TH:i')) }}">
                    <p class="form-hint">Biarkan jika ingin menggunakan waktu sekarang</p>
                    @error('submitted_at') <p class="error-msg">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="form-actions">
            <a href="{{ route('admin.assignment-submissions.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Submission
            </button>
        </div>
    </form>
</div>

<script>
    function showFileName(input) {
        const el = document.getElementById('fileName');
        if (input.files && input.files[0]) {
            el.textContent = '✓ ' + input.files[0].name;
            el.style.display = 'block';
        }
    }
</script>
</x-app-layout>