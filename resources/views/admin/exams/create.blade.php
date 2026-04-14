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

    /* Card */
    .form-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .form-card-header {
        display: flex; align-items: center; gap: 10px;
        padding: 14px 20px; border-bottom: 1px solid var(--border); background: var(--surface2);
    }
    .form-card-title {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
        color: var(--text3); letter-spacing: .07em; text-transform: uppercase;
    }
    .form-card-body { padding: 24px 20px; }

    /* Form layout */
    .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; }

    /* Form Group */
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2);
    }
    .form-label .req { color: var(--danger); margin-left: 2px; }
    .form-hint { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: -2px; }

    .form-input, .form-select {
        font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text);
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 9px 13px;
        outline: none; transition: border-color .15s, box-shadow .15s;
        width: 100%; box-sizing: border-box;
    }
    .form-input:focus, .form-select:focus {
        border-color: var(--brand); box-shadow: 0 0 0 3px rgba(31,99,219,.08);
    }
    .form-input.is-invalid, .form-select.is-invalid {
        border-color: var(--danger); box-shadow: 0 0 0 3px rgba(220,38,38,.08);
    }

    input[type="date"].form-input { cursor: pointer; color-scheme: light; }
    input[type="date"].form-input::-webkit-calendar-picker-indicator { opacity: .5; cursor: pointer; }

    select.form-select {
        appearance: none; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg width='12' height='12' fill='none' stroke='%2394a3b8' stroke-width='2' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 12px center; padding-right: 32px;
    }

    .form-error {
        font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--danger);
        display: flex; align-items: center; gap: 4px; margin-top: 2px;
    }

    /* Date status preview */
    .date-preview { display: none; align-items: center; gap: 8px; margin-top: 8px; }
    .date-preview.visible { display: flex; }
    .date-status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 11px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700;
    }
    .badge-upcoming { background: var(--brand-50);  color: var(--brand-700); border: 1px solid var(--brand-100); }
    .badge-today    { background: #dcfce7; color: #15803d;    border: 1px solid #bbf7d0; }
    .badge-past     { background: var(--surface3); color: var(--text3); border: 1px solid var(--border2); }
    .date-day-label { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); }

    /* Divider */
    .form-divider { height: 1px; background: var(--border); margin: 20px 0; }

    /* Alert */
    .alert-error {
        background: var(--danger-50); border: 1px solid var(--danger-100);
        border-radius: var(--radius-sm); padding: 12px 16px; margin-bottom: 20px;
        display: flex; align-items: flex-start; gap: 10px;
    }
    .alert-error-title {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--danger);
    }
    .alert-error ul { margin: 4px 0 0; padding-left: 16px; font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--danger); }

    /* Footer */
    .form-footer {
        display: flex; align-items: center; justify-content: flex-end;
        gap: 10px; padding: 16px 20px; border-top: 1px solid var(--border); background: var(--surface2);
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    @media (max-width: 640px) {
        .form-grid-3 { grid-template-columns: 1fr; }
        .page { padding: 16px 16px 40px; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.exams.index') }}">Ujian</a>
        <span class="sep">›</span>
        <span class="current">Tambah Ujian</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Ujian</h1>
            <p class="page-sub">Isi form di bawah untuk menambahkan jadwal ujian baru</p>
        </div>
        <a href="{{ route('admin.exams.index') }}" class="btn btn-ghost">
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
    <form method="POST" action="{{ route('admin.exams.store') }}" id="examForm">
        @csrf

        <div class="form-card">

            {{-- Section Header --}}
            <div class="form-card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 11l3 3L22 4"/>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                </svg>
                <p class="form-card-title">Informasi Ujian</p>
            </div>

            <div class="form-card-body">

                {{-- Judul --}}
                <div class="form-group" style="margin-bottom:18px">
                    <label class="form-label" for="judul">
                        Judul Ujian <span class="req">*</span>
                    </label>
                    <input type="text" id="judul" name="judul"
                           class="form-input {{ $errors->has('judul') ? 'is-invalid' : '' }}"
                           value="{{ old('judul') }}"
                           placeholder="Contoh: Ujian Tengah Semester Matematika Kelas X">
                    @error('judul')
                        <span class="form-error">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Tanggal Ujian --}}
                <div class="form-group" style="margin-bottom:18px">
                    <label class="form-label" for="tanggal">
                        Tanggal Ujian <span class="req">*</span>
                    </label>
                    <p class="form-hint">Pilih tanggal pelaksanaan ujian.</p>
                    <input type="date" id="tanggal" name="tanggal"
                           class="form-input {{ $errors->has('tanggal') ? 'is-invalid' : '' }}"
                           value="{{ old('tanggal') }}"
                           onchange="updateDatePreview(this.value)">

                    {{-- Status badge dinamis --}}
                    <div class="date-preview" id="datePreview">
                        <span class="date-status-badge" id="dateStatusBadge"></span>
                        <span class="date-day-label" id="dateDayLabel"></span>
                    </div>

                    @error('tanggal')
                        <span class="form-error">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-divider"></div>

                {{-- Relasi: Guru / Mapel / Kelas --}}
                <div class="form-grid-3">

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

                </div>{{-- /form-grid-3 --}}

            </div>{{-- /form-card-body --}}

            {{-- Footer --}}
            <div class="form-footer">
                <a href="{{ route('admin.exams.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan Ujian
                </button>
            </div>

        </div>{{-- /form-card --}}
    </form>

</div>

<script>
    const DAYS_ID = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const MONTHS_ID = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    function updateDatePreview(val) {
        const preview = document.getElementById('datePreview');
        const badge   = document.getElementById('dateStatusBadge');
        const dayLbl  = document.getElementById('dateDayLabel');

        if (!val) { preview.classList.remove('visible'); return; }

        /* Parsing manual untuk hindari timezone shift */
        const [y, m, d] = val.split('-').map(Number);
        const picked = new Date(y, m - 1, d);
        const today  = new Date(); today.setHours(0,0,0,0);

        const diff = picked - today;
        const dayName = DAYS_ID[picked.getDay()];
        const dateStr = `${dayName}, ${d} ${MONTHS_ID[m-1]} ${y}`;

        /* Badge status */
        badge.className = 'date-status-badge';
        if (diff === 0) {
            badge.classList.add('badge-today');
            badge.innerHTML = `<svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Hari Ini`;
        } else if (diff > 0) {
            const days = Math.round(diff / 86400000);
            badge.classList.add('badge-upcoming');
            badge.innerHTML = `<svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="5 12 12 5 19 12"/></svg> ${days} hari lagi`;
        } else {
            badge.classList.add('badge-past');
            badge.innerHTML = `<svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="19 12 12 19 5 12"/></svg> Sudah lewat`;
        }

        dayLbl.textContent = dateStr;
        preview.classList.add('visible');
    }

    /* Jalankan preview jika ada old() value (setelah validation error) */
    const existingDate = document.getElementById('tanggal').value;
    if (existingDate) updateDatePreview(existingDate);

    /* Submit loading state */
    document.getElementById('examForm').addEventListener('submit', function () {
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