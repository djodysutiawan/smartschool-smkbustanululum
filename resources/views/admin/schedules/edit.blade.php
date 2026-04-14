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
        --warning-50: #fffbeb;
        --warning-100:#fde68a;
        --warning-700:#a16207;
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
    .btn-primary:disabled { opacity: .6; cursor: not-allowed; }
    .btn-ghost { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }
    .btn-warning { background: var(--warning-50); color: var(--warning-700); border: 1px solid var(--warning-100); }
    .btn-warning:hover { background: #fef3c7; }

    /* Alert */
    .alert-error {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px;
        font-size: 13px; font-family: 'DM Sans', sans-serif;
        background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100);
    }
    .alert-error ul { margin: 4px 0 0 16px; padding: 0; }
    .alert-error li { margin-bottom: 2px; }

    /* Edit notice banner */
    .edit-notice {
        display: flex; align-items: center; gap: 12px;
        background: var(--warning-50); border: 1px solid var(--warning-100);
        border-radius: var(--radius-sm); padding: 12px 16px; margin-bottom: 20px;
        font-size: 13px; font-family: 'DM Sans', sans-serif; color: var(--warning-700);
    }
    .edit-notice strong {
        font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
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
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
        color: var(--text3); letter-spacing: .07em; text-transform: uppercase;
    }
    .card-body { padding: 22px 24px; }

    /* Form groups */
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

    /* Day pill picker */
    .day-picker { display: flex; gap: 8px; flex-wrap: wrap; }
    .day-opt { display: none; }
    .day-opt + label {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 74px; padding: 8px 14px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700;
        border: 1.5px solid var(--border); background: var(--surface2); color: var(--text2);
        cursor: pointer; transition: all .15s;
    }
    .day-opt + label:hover { background: var(--surface3); border-color: var(--border2); }
    #hari_Senin:checked  + label { background:#dbeafe;color:#1d4ed8;border-color:#93c5fd;border-width:2px; }
    #hari_Selasa:checked + label { background:#dcfce7;color:#15803d;border-color:#86efac;border-width:2px; }
    #hari_Rabu:checked   + label { background:#fef9c3;color:#a16207;border-color:#fde047;border-width:2px; }
    #hari_Kamis:checked  + label { background:#ffedd5;color:#c2410c;border-color:#fdba74;border-width:2px; }
    #hari_Jumat:checked  + label { background:#f3e8ff;color:#7c3aed;border-color:#c4b5fd;border-width:2px; }
    #hari_Sabtu:checked  + label { background:#fce7f3;color:#be185d;border-color:#f9a8d4;border-width:2px; }

    /* Time row */
    .time-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 10px; align-items: end; }
    .time-sep {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700;
        color: var(--text3); padding-bottom: 9px; text-align: center;
    }

    /* Duration preview */
    .duration-preview {
        display: none; align-items: center; gap: 8px;
        background: var(--brand-50); border: 1px solid var(--brand-100);
        border-radius: var(--radius-sm); padding: 9px 14px; margin-top: 12px;
    }
    .duration-preview.visible { display: flex; }
    .duration-preview.error { background: var(--danger-50); border-color: var(--danger-100); }
    .duration-text {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px;
        font-weight: 700; color: var(--brand-700);
    }
    .duration-preview.error .duration-text { color: var(--danger); }

    /* Select preview cards */
    .select-preview {
        display: none; align-items: center; gap: 10px;
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 10px 14px; margin-top: 10px;
    }
    .select-preview.visible { display: flex; }
    .preview-avatar {
        width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 800;
    }
    .preview-avatar.teacher { background: var(--surface3); color: var(--text2); border: 1px solid var(--border2); }
    .preview-avatar.subject { background: #f3e8ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .preview-avatar.class   { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .preview-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .preview-sub  { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: 1px; }

    /* Changed indicator */
    .changed-badge {
        display: none;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10px; font-weight: 700; letter-spacing: .05em;
        background: #fef3c7; color: #92400e; border: 1px solid #fde68a;
        border-radius: 99px; padding: 1px 8px; margin-left: 6px; vertical-align: middle;
    }
    .changed-badge.show { display: inline; }

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
    }
    .summary-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; }
    .summary-item-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 10.5px; font-weight: 700; color: var(--brand-700); text-transform: uppercase; letter-spacing: .05em; margin-bottom: 3px; }
    .summary-item-val   { font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text); font-weight: 500; }

    /* Form footer */
    .form-footer {
        display: flex; align-items: center; justify-content: space-between; gap: 10px;
        padding: 16px 24px; border-top: 1px solid var(--border); background: var(--surface2);
        flex-wrap: wrap;
    }
    .form-footer-right { display: flex; gap: 10px; align-items: center; }

    /* Responsive */
    @media (max-width: 600px) {
        .page { padding: 16px 16px 40px; }
        .form-grid { grid-template-columns: 1fr; }
        .form-group.full { grid-column: span 1; }
        .time-row { grid-template-columns: 1fr 1fr; }
        .time-sep { display: none; }
        .summary-grid { grid-template-columns: 1fr 1fr; }
        .form-footer { justify-content: flex-end; }
    }

    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.schedules.index') }}">Jadwal Pelajaran</a>
        <span class="sep">›</span>
        <span class="current">Edit Jadwal #{{ $schedule->id }}</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Jadwal Pelajaran</h1>
            <p class="page-sub">Perbarui data jadwal — perubahan akan langsung tersimpan setelah dikonfirmasi.</p>
        </div>
        <a href="{{ route('admin.schedules.index') }}" class="btn btn-ghost">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Edit notice --}}
    <div class="edit-notice">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <span>
            Anda sedang mengedit jadwal yang sudah ada.
            <strong>ID #{{ $schedule->id }}</strong> —
            dibuat pada {{ $schedule->created_at->format('d M Y, H:i') }}.
        </span>
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

    <form method="POST" action="{{ route('admin.schedules.update', $schedule->id) }}" id="scheduleForm">
        @csrf
        @method('PUT')

        {{-- Section 1: Mata Pelajaran, Kelas, Guru --}}
        <div class="form-card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                </svg>
                <p class="card-title">Data Pelajaran</p>
            </div>
            <div class="card-body">
                <div class="form-grid">

                    {{-- Mata Pelajaran --}}
                    <div class="form-group">
                        <label class="form-label" for="subject_id">
                            Mata Pelajaran <span class="req">*</span>
                            <span class="changed-badge" id="badge-subject">Diubah</span>
                        </label>
                        <select name="subject_id" id="subject_id"
                            class="form-control {{ $errors->has('subject_id') ? 'is-invalid' : '' }}"
                            onchange="previewSubject(this); markChanged('subject')">
                            <option value="">— Pilih mata pelajaran —</option>
                            @foreach($subjects as $subject)
                                <option
                                    value="{{ $subject->id }}"
                                    data-nama="{{ $subject->nama_mapel }}"
                                    data-kode="{{ $subject->kode_mapel ?? '' }}"
                                    {{ (old('subject_id', $schedule->subject_id) == $subject->id) ? 'selected' : '' }}
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
                            <div class="preview-avatar subject" id="subjectInitial">?</div>
                            <div>
                                <p class="preview-name" id="subjectName">—</p>
                                <p class="preview-sub"  id="subjectKode">—</p>
                            </div>
                        </div>
                    </div>

                    {{-- Kelas --}}
                    <div class="form-group">
                        <label class="form-label" for="class_id">
                            Kelas <span class="req">*</span>
                            <span class="changed-badge" id="badge-class">Diubah</span>
                        </label>
                        <select name="class_id" id="class_id"
                            class="form-control {{ $errors->has('class_id') ? 'is-invalid' : '' }}"
                            onchange="previewClass(this); markChanged('class')">
                            <option value="">— Pilih kelas —</option>
                            @foreach($classes as $class)
                                <option
                                    value="{{ $class->id }}"
                                    data-nama="{{ $class->nama_kelas }}"
                                    data-tingkat="{{ $class->tingkat ?? '' }}"
                                    data-jurusan="{{ $class->jurusan ?? '' }}"
                                    {{ (old('class_id', $schedule->class_id) == $class->id) ? 'selected' : '' }}
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
                            <div class="preview-avatar class" id="classInitial">?</div>
                            <div>
                                <p class="preview-name" id="className">—</p>
                                <p class="preview-sub"  id="classMeta">—</p>
                            </div>
                        </div>
                    </div>

                    {{-- Guru --}}
                    <div class="form-group full">
                        <label class="form-label" for="teacher_id">
                            Guru Pengajar <span class="req">*</span>
                            <span class="changed-badge" id="badge-teacher">Diubah</span>
                        </label>
                        <select name="teacher_id" id="teacher_id"
                            class="form-control {{ $errors->has('teacher_id') ? 'is-invalid' : '' }}"
                            onchange="previewTeacher(this); markChanged('teacher')">
                            <option value="">— Pilih guru pengajar —</option>
                            @foreach($teachers as $teacher)
                                <option
                                    value="{{ $teacher->id }}"
                                    data-nama="{{ $teacher->nama_lengkap }}"
                                    data-nip="{{ $teacher->nip }}"
                                    {{ (old('teacher_id', $schedule->teacher_id) == $teacher->id) ? 'selected' : '' }}
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
                            <div class="preview-avatar teacher" id="teacherInitial">?</div>
                            <div>
                                <p class="preview-name" id="teacherName">—</p>
                                <p class="preview-sub"  id="teacherNip">—</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Section 2: Hari & Jam --}}
        <div class="form-card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <p class="card-title">Waktu Pelaksanaan</p>
            </div>
            <div class="card-body">

                {{-- Hari --}}
                <div class="form-group" style="margin-bottom:20px">
                    <label class="form-label">
                        Hari <span class="req">*</span>
                        <span class="changed-badge" id="badge-hari">Diubah</span>
                    </label>
                    <div class="day-picker">
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                            <input type="radio" name="hari" id="hari_{{ $hari }}" value="{{ $hari }}"
                                class="day-opt"
                                onchange="updateSummary(); markChanged('hari')"
                                {{ (old('hari', $schedule->hari) == $hari) ? 'checked' : '' }}>
                            <label for="hari_{{ $hari }}">{{ $hari }}</label>
                        @endforeach
                    </div>
                    @error('hari')
                        <p class="form-error" style="margin-top:4px">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Jam --}}
                <div class="form-group">
                    <label class="form-label">
                        Jam Pelajaran <span class="req">*</span>
                        <span class="changed-badge" id="badge-jam">Diubah</span>
                    </label>
                    <div class="time-row">
                        <div>
                            <p class="form-hint" style="margin-bottom:5px">Jam Mulai</p>
                            <input type="time" name="jam_mulai" id="jam_mulai"
                                value="{{ old('jam_mulai', \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i')) }}"
                                class="form-control {{ $errors->has('jam_mulai') ? 'is-invalid' : '' }}"
                                onchange="updateDuration(); markChanged('jam')">
                            @error('jam_mulai')
                                <p class="form-error" style="margin-top:4px">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="time-sep">→</div>
                        <div>
                            <p class="form-hint" style="margin-bottom:5px">Jam Selesai</p>
                            <input type="time" name="jam_selesai" id="jam_selesai"
                                value="{{ old('jam_selesai', \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i')) }}"
                                class="form-control {{ $errors->has('jam_selesai') ? 'is-invalid' : '' }}"
                                onchange="updateDuration(); markChanged('jam')">
                            @error('jam_selesai')
                                <p class="form-error" style="margin-top:4px">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Duration preview --}}
                    <div class="duration-preview" id="durationPreview">
                        <svg width="14" height="14" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24" id="durIcon">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <span class="duration-text" id="durationText">—</span>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="form-footer">
                {{-- Kiri: hapus jadwal --}}
                <form method="POST" action="{{ route('admin.schedules.destroy', $schedule->id) }}"
                    onsubmit="return confirm('Yakin ingin menghapus jadwal ini? Tindakan ini tidak dapat dibatalkan.')"
                    style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-ghost" style="color:var(--danger);border-color:var(--danger-100)">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6"/><path d="M14 11v6"/>
                        </svg>
                        Hapus Jadwal
                    </button>
                </form>

                {{-- Kanan: batal + simpan --}}
                <div class="form-footer-right">
                    <a href="{{ route('admin.schedules.index') }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>

    </form>

    {{-- Summary card --}}
    <div class="summary-card visible" id="summaryCard">
        <p class="summary-title">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline;margin-right:4px">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </svg>
            Ringkasan Jadwal (Live Preview)
        </p>
        <div class="summary-grid">
            <div>
                <p class="summary-item-label">Mata Pelajaran</p>
                <p class="summary-item-val" id="sumMapel">{{ $schedule->subject->nama_mapel ?? '—' }}</p>
            </div>
            <div>
                <p class="summary-item-label">Kelas</p>
                <p class="summary-item-val" id="sumKelas">{{ $schedule->class->nama_kelas ?? '—' }}</p>
            </div>
            <div>
                <p class="summary-item-label">Guru</p>
                <p class="summary-item-val" id="sumGuru">{{ $schedule->teacher->nama_lengkap ?? '—' }}</p>
            </div>
            <div>
                <p class="summary-item-label">Hari</p>
                <p class="summary-item-val" id="sumHari">{{ $schedule->hari }}</p>
            </div>
            <div>
                <p class="summary-item-label">Jam</p>
                <p class="summary-item-val" id="sumJam">
                    {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }}
                    –
                    {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}
                </p>
            </div>
            <div>
                <p class="summary-item-label">Durasi</p>
                <p class="summary-item-val" id="sumDurasi">—</p>
            </div>
        </div>
    </div>

</div>

<script>
    /* ── Original values (untuk deteksi perubahan) ── */
    const ORIGINAL = {
        subject_id: '{{ $schedule->subject_id }}',
        class_id:   '{{ $schedule->class_id }}',
        teacher_id: '{{ $schedule->teacher_id }}',
        hari:       '{{ $schedule->hari }}',
        jam_mulai:  '{{ \Carbon\Carbon::parse($schedule->jam_mulai)->format("H:i") }}',
        jam_selesai:'{{ \Carbon\Carbon::parse($schedule->jam_selesai)->format("H:i") }}',
    };

    /* ── Mark changed badge ── */
    function markChanged(field) {
        let changed = false;
        if (field === 'subject') {
            changed = document.getElementById('subject_id').value !== ORIGINAL.subject_id;
            document.getElementById('badge-subject').classList.toggle('show', changed);
        } else if (field === 'class') {
            changed = document.getElementById('class_id').value !== ORIGINAL.class_id;
            document.getElementById('badge-class').classList.toggle('show', changed);
        } else if (field === 'teacher') {
            changed = document.getElementById('teacher_id').value !== ORIGINAL.teacher_id;
            document.getElementById('badge-teacher').classList.toggle('show', changed);
        } else if (field === 'hari') {
            const checked = document.querySelector('input[name="hari"]:checked')?.value || '';
            document.getElementById('badge-hari').classList.toggle('show', checked !== ORIGINAL.hari);
        } else if (field === 'jam') {
            const mulai   = document.getElementById('jam_mulai').value;
            const selesai = document.getElementById('jam_selesai').value;
            changed = mulai !== ORIGINAL.jam_mulai || selesai !== ORIGINAL.jam_selesai;
            document.getElementById('badge-jam').classList.toggle('show', changed);
        }
    }

    /* ── Subject preview ── */
    function previewSubject(sel) {
        const preview = document.getElementById('subjectPreview');
        if (!sel.value) { preview.classList.remove('visible'); updateSummary(); return; }
        const opt  = sel.options[sel.selectedIndex];
        const nama = opt.dataset.nama || '—';
        const kode = opt.dataset.kode || '';
        document.getElementById('subjectInitial').textContent = nama.substring(0,2).toUpperCase();
        document.getElementById('subjectName').textContent    = nama;
        document.getElementById('subjectKode').textContent    = kode ? 'Kode: ' + kode : 'Tidak ada kode';
        preview.classList.add('visible');
        updateSummary();
    }

    /* ── Class preview ── */
    function previewClass(sel) {
        const preview = document.getElementById('classPreview');
        if (!sel.value) { preview.classList.remove('visible'); updateSummary(); return; }
        const opt     = sel.options[sel.selectedIndex];
        const nama    = opt.dataset.nama    || '—';
        const tingkat = opt.dataset.tingkat || '';
        const jurusan = opt.dataset.jurusan || '';
        document.getElementById('classInitial').textContent = nama.substring(0,2).toUpperCase();
        document.getElementById('className').textContent    = nama;
        let meta = [];
        if (tingkat) meta.push('Tingkat ' + tingkat);
        if (jurusan) meta.push(jurusan);
        document.getElementById('classMeta').textContent = meta.join(' · ') || '—';
        preview.classList.add('visible');
        updateSummary();
    }

    /* ── Teacher preview ── */
    function previewTeacher(sel) {
        const preview = document.getElementById('teacherPreview');
        if (!sel.value) { preview.classList.remove('visible'); updateSummary(); return; }
        const opt  = sel.options[sel.selectedIndex];
        const nama = opt.dataset.nama || '—';
        const nip  = opt.dataset.nip  || '—';
        document.getElementById('teacherInitial').textContent = nama.charAt(0).toUpperCase();
        document.getElementById('teacherName').textContent    = nama;
        document.getElementById('teacherNip').textContent     = 'NIP: ' + nip;
        preview.classList.add('visible');
        updateSummary();
    }

    /* ── Duration calculator ── */
    function updateDuration() {
        const mulai   = document.getElementById('jam_mulai').value;
        const selesai = document.getElementById('jam_selesai').value;
        const preview = document.getElementById('durationPreview');

        if (!mulai || !selesai) { preview.classList.remove('visible'); updateSummary(); return; }

        const diff = toMin(selesai) - toMin(mulai);

        if (diff <= 0) {
            preview.classList.add('visible', 'error');
            document.getElementById('durationText').textContent = '⚠ Jam selesai harus setelah jam mulai';
            updateSummary(); return;
        }

        preview.classList.remove('error');
        preview.classList.add('visible');
        document.getElementById('durationText').textContent = 'Durasi pelajaran: ' + durStr(diff);
        updateSummary();
    }

    function toMin(t) {
        const [h, m] = t.split(':').map(Number);
        return h * 60 + m;
    }

    function durStr(mnt) {
        const j = Math.floor(mnt / 60), m = mnt % 60;
        return (j > 0 ? j + ' jam ' : '') + (m > 0 ? m + ' menit' : '');
    }

    /* ── Summary updater ── */
    function updateSummary() {
        const subjectSel = document.getElementById('subject_id');
        const classSel   = document.getElementById('class_id');
        const teacherSel = document.getElementById('teacher_id');
        const hari       = document.querySelector('input[name="hari"]:checked')?.value || '';
        const mulai      = document.getElementById('jam_mulai').value;
        const selesai    = document.getElementById('jam_selesai').value;

        const mapel = subjectSel.value ? subjectSel.options[subjectSel.selectedIndex].dataset.nama : '';
        const kelas = classSel.value   ? classSel.options[classSel.selectedIndex].dataset.nama    : '';
        const guru  = teacherSel.value ? teacherSel.options[teacherSel.selectedIndex].dataset.nama: '';

        document.getElementById('sumMapel').textContent = mapel || '—';
        document.getElementById('sumKelas').textContent = kelas || '—';
        document.getElementById('sumGuru').textContent  = guru  || '—';
        document.getElementById('sumHari').textContent  = hari  || '—';

        if (mulai && selesai) {
            const diff = toMin(selesai) - toMin(mulai);
            document.getElementById('sumJam').textContent    = mulai + ' – ' + selesai;
            document.getElementById('sumDurasi').textContent = diff > 0 ? durStr(diff) : '⚠ Invalid';
        } else {
            document.getElementById('sumJam').textContent    = (mulai || '?') + ' – ' + (selesai || '?');
            document.getElementById('sumDurasi').textContent = '—';
        }
    }

    /* ── Submit animation ── */
    document.getElementById('scheduleForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled  = true;
        btn.innerHTML = `
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                 style="animation:spin .7s linear infinite">
                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
            </svg>
            Menyimpan…`;
    });

    /* ── Init on page load — populate previews & duration from existing data ── */
    document.addEventListener('DOMContentLoaded', function () {
        const subSel = document.getElementById('subject_id');
        const clsSel = document.getElementById('class_id');
        const tchSel = document.getElementById('teacher_id');
        if (subSel.value)  previewSubject(subSel);
        if (clsSel.value)  previewClass(clsSel);
        if (tchSel.value)  previewTeacher(tchSel);
        updateDuration();
        updateSummary();
    });
</script>

</x-app-layout>