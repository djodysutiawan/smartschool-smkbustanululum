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
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; margin-bottom: 24px; flex-wrap: wrap;
    }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }

    /* ── Buttons ── */
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

    /* ── Form card ── */
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

    /* ── Form grid ── */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px 20px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.full { grid-column: span 2; }

    .form-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11.5px; font-weight: 700; color: var(--text2);
        letter-spacing: .04em; text-transform: uppercase;
        display: flex; align-items: center; gap: 4px;
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

    .form-hint {
        font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: 2px;
    }
    .form-error {
        font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--danger); margin-top: 2px;
        display: flex; align-items: center; gap: 4px;
    }

    /* ── Select2-like styled select ── */
    select.form-control { appearance: none; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg width='12' height='12' fill='none' stroke='%2394a3b8' stroke-width='2' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 12px center; padding-right: 32px;
    }

    /* ── Day picker ── */
    .day-picker { display: flex; gap: 8px; flex-wrap: wrap; }
    .day-opt { display: none; }
    .day-opt + label {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 76px; padding: 8px 14px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700;
        border: 1.5px solid var(--border); background: var(--surface2); color: var(--text2);
        cursor: pointer; transition: all .15s;
    }
    .day-opt:checked + label { border-width: 2px; }
    /* Per-day colours */
    #hari_Senin:checked    + label { background: #dbeafe; color: #1d4ed8; border-color: #93c5fd; }
    #hari_Selasa:checked   + label { background: #dcfce7; color: #15803d; border-color: #86efac; }
    #hari_Rabu:checked     + label { background: #fef9c3; color: #a16207; border-color: #fde047; }
    #hari_Kamis:checked    + label { background: #ffedd5; color: #c2410c; border-color: #fdba74; }
    #hari_Jumat:checked    + label { background: #f3e8ff; color: #7c3aed; border-color: #c4b5fd; }
    #hari_Sabtu:checked    + label { background: #fce7f3; color: #be185d; border-color: #f9a8d4; }
    .day-opt + label:hover { background: var(--surface3); border-color: var(--border2); }

    /* ── Time row ── */
    .time-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 10px; align-items: end; }
    .time-sep {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        color: var(--text3); padding-bottom: 9px; text-align: center;
    }

    /* ── Duration preview ── */
    .duration-preview {
        display: none; align-items: center; gap: 8px;
        background: var(--brand-50); border: 1px solid var(--brand-100);
        border-radius: var(--radius-sm); padding: 9px 14px; margin-top: 12px;
    }
    .duration-preview.visible { display: flex; }
    .duration-text {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px;
        font-weight: 700; color: var(--brand-700);
    }

    /* ── Teacher preview card ── */
    .teacher-preview {
        display: none; align-items: center; gap: 12px;
        background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 12px 14px; margin-top: 10px;
    }
    .teacher-preview.visible { display: flex; }
    .preview-avatar {
        width: 38px; height: 38px; border-radius: 9px; flex-shrink: 0;
        background: var(--brand-50); border: 1px solid var(--brand-100);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px;
        font-weight: 800; color: var(--brand-700);
    }
    .preview-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--text); }
    .preview-nip  { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: 1px; }

    /* ── Form footer ── */
    .form-footer {
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
        padding: 16px 24px; border-top: 1px solid var(--border); background: var(--surface2);
    }

    /* ── Alert error ── */
    .alert-error {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px;
        font-size: 13px; font-family: 'DM Sans', sans-serif;
        background: var(--danger-50); color: var(--danger); border: 1px solid var(--danger-100);
    }
    .alert-error ul { margin: 4px 0 0 16px; padding: 0; }
    .alert-error li { margin-bottom: 2px; }

    /* ── Info tip ── */
    .info-tip {
        display: flex; align-items: flex-start; gap: 10px;
        background: var(--brand-50); border: 1px solid var(--brand-100);
        border-radius: var(--radius-sm); padding: 12px 14px; margin-bottom: 16px;
        font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--brand-700);
    }

    /* ── Responsive ── */
    @media (max-width: 600px) {
        .page { padding: 16px 16px 40px; }
        .form-grid { grid-template-columns: 1fr; }
        .form-group.full { grid-column: span 1; }
        .time-row { grid-template-columns: 1fr 1fr; }
        .time-sep { display: none; }
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.piket-teachers.index') }}">Guru Piket</a>
        <span class="sep">›</span>
        <span class="current">Tambah Jadwal</span>
    </nav>

    {{-- Page header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Jadwal Guru Piket</h1>
            <p class="page-sub">Isi form di bawah untuk menambahkan jadwal piket guru</p>
        </div>
        <a href="{{ route('admin.piket-teachers.index') }}" class="btn btn-ghost">
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

    {{-- Info tip --}}
    <div class="info-tip">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        Setiap guru hanya boleh memiliki satu jadwal piket per hari. Jika guru sudah terdaftar pada hari yang sama, sistem akan menolak.
    </div>

    <form method="POST" action="{{ route('admin.piket-teachers.store') }}">
        @csrf

        {{-- Section 1: Pilih Guru --}}
        <div class="form-card" style="margin-bottom:16px">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
                <p class="card-title">Data Guru</p>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="teacher_id">
                        Pilih Guru <span class="req">*</span>
                    </label>
                    <select
                        name="teacher_id" id="teacher_id"
                        class="form-control {{ $errors->has('teacher_id') ? 'is-invalid' : '' }}"
                        onchange="previewTeacher(this)"
                    >
                        <option value="">— Pilih guru —</option>
                        @foreach($teachers as $teacher)
                            <option
                                value="{{ $teacher->id }}"
                                data-nama="{{ $teacher->nama_lengkap }}"
                                data-nip="{{ $teacher->nip }}"
                                {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}
                            >
                                {{ $teacher->nama_lengkap }} ({{ $teacher->nip }})
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <p class="form-error">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror

                    {{-- Teacher preview --}}
                    <div class="teacher-preview" id="teacherPreview">
                        <div class="preview-avatar" id="previewInitial">?</div>
                        <div>
                            <p class="preview-name" id="previewName">—</p>
                            <p class="preview-nip" id="previewNip">NIP: —</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2: Jadwal --}}
        <div class="form-card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <p class="card-title">Jadwal Piket</p>
            </div>
            <div class="card-body">

                {{-- Hari --}}
                <div class="form-group" style="margin-bottom:20px">
                    <label class="form-label">
                        Hari <span class="req">*</span>
                    </label>
                    <div class="day-picker">
                        @foreach($hariList as $hari)
                            <input
                                type="radio" name="hari" id="hari_{{ $hari }}"
                                value="{{ $hari }}" class="day-opt"
                                {{ old('hari') == $hari ? 'checked' : '' }}
                            >
                            <label for="hari_{{ $hari }}">{{ $hari }}</label>
                        @endforeach
                    </div>
                    @error('hari')
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

                {{-- Jam --}}
                <div class="form-group">
                    <label class="form-label">
                        Jam Piket <span class="req">*</span>
                    </label>
                    <div class="time-row">
                        <div>
                            <label class="form-hint" style="margin-bottom:5px;display:block">Jam Mulai</label>
                            <input
                                type="time" name="jam_mulai" id="jam_mulai"
                                value="{{ old('jam_mulai') }}"
                                class="form-control {{ $errors->has('jam_mulai') ? 'is-invalid' : '' }}"
                                onchange="updateDuration()"
                            >
                            @error('jam_mulai')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="time-sep">→</div>
                        <div>
                            <label class="form-hint" style="margin-bottom:5px;display:block">Jam Selesai</label>
                            <input
                                type="time" name="jam_selesai" id="jam_selesai"
                                value="{{ old('jam_selesai') }}"
                                class="form-control {{ $errors->has('jam_selesai') ? 'is-invalid' : '' }}"
                                onchange="updateDuration()"
                            >
                            @error('jam_selesai')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Duration preview --}}
                    <div class="duration-preview" id="durationPreview">
                        <svg width="14" height="14" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <span class="duration-text" id="durationText">—</span>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="form-footer">
                <a href="{{ route('admin.piket-teachers.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Simpan Jadwal
                </button>
            </div>
        </div>

    </form>

</div>

<script>
    /* ── Teacher preview ── */
    function previewTeacher(sel) {
        const opt     = sel.options[sel.selectedIndex];
        const preview = document.getElementById('teacherPreview');
        if (!sel.value) { preview.classList.remove('visible'); return; }

        const nama = opt.dataset.nama || '—';
        const nip  = opt.dataset.nip  || '—';
        document.getElementById('previewInitial').textContent = nama.charAt(0).toUpperCase();
        document.getElementById('previewName').textContent    = nama;
        document.getElementById('previewNip').textContent     = 'NIP: ' + nip;
        preview.classList.add('visible');
    }

    /* ── Duration calculator ── */
    function updateDuration() {
        const mulai   = document.getElementById('jam_mulai').value;
        const selesai = document.getElementById('jam_selesai').value;
        const preview = document.getElementById('durationPreview');

        if (!mulai || !selesai) { preview.classList.remove('visible'); return; }

        const [mh, mm] = mulai.split(':').map(Number);
        const [sh, sm] = selesai.split(':').map(Number);
        const totalMulai   = mh * 60 + mm;
        const totalSelesai = sh * 60 + sm;
        const diff = totalSelesai - totalMulai;

        if (diff <= 0) {
            document.getElementById('durationText').textContent = '⚠ Jam selesai harus setelah jam mulai';
            preview.classList.add('visible');
            preview.style.background = '#fee2e2';
            preview.style.borderColor = '#fecaca';
            document.getElementById('durationText').style.color = '#dc2626';
            return;
        }

        preview.style.background   = '';
        preview.style.borderColor  = '';
        document.getElementById('durationText').style.color = '';

        const jam = Math.floor(diff / 60);
        const mnt = diff % 60;
        let str = 'Durasi piket: ';
        if (jam > 0) str += jam + ' jam ';
        if (mnt > 0) str += mnt + ' menit';
        document.getElementById('durationText').textContent = str;
        preview.classList.add('visible');
    }

    /* ── Init on old() values ── */
    document.addEventListener('DOMContentLoaded', function () {
        const sel = document.getElementById('teacher_id');
        if (sel && sel.value) previewTeacher(sel);
        updateDuration();
    });
</script>

</x-app-layout>