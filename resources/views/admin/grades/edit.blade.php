<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
    @endif
</script>

<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand:      #1f63db; --brand-h: #3582f0; --brand-50: #eef6ff;
        --brand-100:  #d9ebff; --brand-700: #1750c0;
        --surface:    #fff; --surface2: #f8fafc; --surface3: #f1f5f9;
        --border:     #e2e8f0; --border2: #cbd5e1;
        --text:       #0f172a; --text2: #475569; --text3: #94a3b8;
        --radius:     10px; --radius-sm: 7px;
        --danger:     #dc2626; --danger-50: #fee2e2; --danger-100: #fecaca;
        --success:    #16a34a; --warn: #d97706;
    }

    .page { padding: 28px 28px 60px; max-width: 5000px; margin: 0 auto; }

    .breadcrumb { display: flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600; color: var(--text3); margin-bottom: 20px; }
    .breadcrumb a { color: var(--text3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }

    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }

    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: background .15s; white-space: nowrap; }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { background: var(--brand-h); }
    .btn-primary:disabled { opacity: .6; cursor: not-allowed; }
    .btn-ghost { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface3); }

    .alert-error { background: var(--danger-50); border: 1px solid var(--danger-100); border-radius: var(--radius-sm); padding: 12px 16px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 10px; }
    .alert-error-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--danger); }
    .alert-error ul { margin: 4px 0 0 0; padding-left: 16px; font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--danger); }

    .preview-card { background: var(--brand-50); border: 1px solid var(--brand-100); border-radius: var(--radius); padding: 16px 20px; margin-bottom: 20px; display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
    .preview-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--brand-700); text-transform: uppercase; letter-spacing: .06em; }
    .preview-value { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 32px; font-weight: 800; color: var(--brand); line-height: 1; }
    .preview-formula { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--brand-700); margin-top: 2px; }
    .preview-badge { display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 20px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; margin-left: auto; }

    .form-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; margin-bottom: 16px; }
    .form-card-header { display: flex; align-items: center; gap: 10px; padding: 14px 20px; border-bottom: 1px solid var(--border); background: var(--surface2); }
    .form-card-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--text3); letter-spacing: .07em; text-transform: uppercase; }
    .form-card-body { padding: 24px 20px; }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .form-grid.col-3 { grid-template-columns: 1fr 1fr 1fr; }

    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2); }
    .form-label .req { color: var(--danger); margin-left: 2px; }
    .form-hint { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: -2px; }

    .form-input, .form-select { font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); background: var(--surface2); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 9px 13px; outline: none; transition: border-color .15s, box-shadow .15s; width: 100%; box-sizing: border-box; }
    .form-input:focus, .form-select:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(31,99,219,.08); }
    .form-input.is-invalid, .form-select.is-invalid { border-color: var(--danger); box-shadow: 0 0 0 3px rgba(220,38,38,.08); }
    select.form-select { appearance: none; cursor: pointer; background-image: url("data:image/svg+xml,%3Csvg width='12' height='12' fill='none' stroke='%2394a3b8' stroke-width='2' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 32px; }
    .form-error { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--danger); display: flex; align-items: center; gap: 4px; margin-top: 2px; }

    .nilai-input-wrap { position: relative; }
    .nilai-input-wrap .form-input { padding-right: 48px; font-weight: 700; }
    .nilai-badge { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 5px; pointer-events: none; }

    .form-footer { display: flex; align-items: center; justify-content: flex-end; gap: 10px; padding: 16px 20px; border-top: 1px solid var(--border); background: var(--surface2); }

    @media(max-width:640px) { .form-grid, .form-grid.col-3 { grid-template-columns: 1fr; } .page { padding: 16px 16px 40px; } }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="page">

    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.grades.index') }}">Nilai Siswa</a>
        <span class="sep">›</span>
        <span class="current">Edit Nilai</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Nilai</h1>
            <p class="page-sub">{{ $grade->student->name ?? '—' }} · {{ $grade->subject->nama_mapel ?? '—' }}</p>
        </div>
        <div style="display:flex;gap:8px">
            <a href="{{ route('admin.grades.show', $grade->id) }}" class="btn btn-ghost">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                </svg>
                Lihat Detail
            </a>
            <a href="{{ route('admin.grades.index') }}" class="btn btn-ghost">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert-error">
            <svg width="16" height="16" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>
                <p class="alert-error-title">Terdapat {{ $errors->count() }} kesalahan:</p>
                <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        </div>
    @endif

    <div class="preview-card">
        <div>
            <p class="preview-label">Preview Nilai Akhir</p>
            <p class="preview-value" id="prevValue">{{ number_format($grade->nilai_akhir ?? 0, 2) }}</p>
            <p class="preview-formula">30% Tugas + 30% UTS + 40% UAS</p>
        </div>
        <span class="preview-badge" id="prevBadge"></span>
    </div>

    <form method="POST" action="{{ route('admin.grades.update', $grade->id) }}" id="gradeForm">
        @csrf @method('PUT')

        <div class="form-card">
            <div class="form-card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                <p class="form-card-title">Informasi Relasi</p>
            </div>
            <div class="form-card-body">
                <div class="form-grid col-3">
                    <div class="form-group">
                        <label class="form-label" for="student_id">Siswa <span class="req">*</span></label>
                        <select id="student_id" name="student_id" class="form-select {{ $errors->has('student_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Siswa —</option>
                            @foreach($students as $s)
                                <option value="{{ $s->id }}" {{ old('student_id', $grade->student_id) == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }} — {{ $s->class->nama_kelas ?? '—' }}
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="subject_id">Mata Pelajaran <span class="req">*</span></label>
                        <select id="subject_id" name="subject_id" class="form-select {{ $errors->has('subject_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Mapel —</option>
                            @foreach($subjects as $s)
                                <option value="{{ $s->id }}" {{ old('subject_id', $grade->subject_id) == $s->id ? 'selected' : '' }}>{{ $s->nama_mapel }}</option>
                            @endforeach
                        </select>
                        @error('subject_id')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="teacher_id">Guru <span class="req">*</span></label>
                        <select id="teacher_id" name="teacher_id" class="form-select {{ $errors->has('teacher_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Guru —</option>
                            @foreach($teachers as $t)
                                <option value="{{ $t->id }}" {{ old('teacher_id', $grade->teacher_id) == $t->id ? 'selected' : '' }}>{{ $t->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        @error('teacher_id')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <svg width="13" height="13" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                </svg>
                <p class="form-card-title">Input Nilai</p>
            </div>
            <div class="form-card-body">
                <div class="form-grid col-3">
                    <div class="form-group">
                        <label class="form-label" for="nilai_tugas">Nilai Tugas</label>
                        <p class="form-hint">Bobot 30% · Rentang 0–100</p>
                        <div class="nilai-input-wrap">
                            <input type="number" id="nilai_tugas" name="nilai_tugas" min="0" max="100" step="0.01"
                                class="form-input {{ $errors->has('nilai_tugas') ? 'is-invalid' : '' }}"
                                value="{{ old('nilai_tugas', $grade->nilai_tugas) }}"
                                placeholder="0 – 100" oninput="recalc()">
                            <span class="nilai-badge" id="badge_tugas"></span>
                        </div>
                        @error('nilai_tugas')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="nilai_uts">Nilai UTS</label>
                        <p class="form-hint">Bobot 30% · Rentang 0–100</p>
                        <div class="nilai-input-wrap">
                            <input type="number" id="nilai_uts" name="nilai_uts" min="0" max="100" step="0.01"
                                class="form-input {{ $errors->has('nilai_uts') ? 'is-invalid' : '' }}"
                                value="{{ old('nilai_uts', $grade->nilai_uts) }}"
                                placeholder="0 – 100" oninput="recalc()">
                            <span class="nilai-badge" id="badge_uts"></span>
                        </div>
                        @error('nilai_uts')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="nilai_uas">Nilai UAS</label>
                        <p class="form-hint">Bobot 40% · Rentang 0–100</p>
                        <div class="nilai-input-wrap">
                            <input type="number" id="nilai_uas" name="nilai_uas" min="0" max="100" step="0.01"
                                class="form-input {{ $errors->has('nilai_uas') ? 'is-invalid' : '' }}"
                                value="{{ old('nilai_uas', $grade->nilai_uas) }}"
                                placeholder="0 – 100" oninput="recalc()">
                            <span class="nilai-badge" id="badge_uas"></span>
                        </div>
                        @error('nilai_uas')<span class="form-error"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.grades.index') }}" class="btn btn-ghost">Batal</a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function scoreColor(v) {
        if (v >= 90) return { bg: '#f0fdf4', color: '#16a34a', border: '#dcfce7', label: 'A' };
        if (v >= 75) return { bg: '#eef6ff', color: '#1f63db', border: '#d9ebff', label: 'B' };
        if (v >= 60) return { bg: '#fffbeb', color: '#d97706', border: '#fef3c7', label: 'C' };
        return { bg: '#fee2e2', color: '#dc2626', border: '#fecaca', label: 'D' };
    }

    function setBadge(id, val) {
        const el = document.getElementById(id);
        if (val === '' || val === null || val === undefined) { el.style.display = 'none'; return; }
        const v = parseFloat(val);
        if (isNaN(v)) { el.style.display = 'none'; return; }
        const c = scoreColor(v);
        el.style.display = 'inline-block';
        el.style.background = c.bg;
        el.style.color = c.color;
        el.style.border = `1px solid ${c.border}`;
        el.textContent = c.label;
    }

    function recalc() {
        const t  = parseFloat(document.getElementById('nilai_tugas').value) || 0;
        const u  = parseFloat(document.getElementById('nilai_uts').value)   || 0;
        const ua = parseFloat(document.getElementById('nilai_uas').value)   || 0;
        const na = (t * 0.30) + (u * 0.30) + (ua * 0.40);
        document.getElementById('prevValue').textContent = na.toFixed(2);
        setBadge('badge_tugas', document.getElementById('nilai_tugas').value);
        setBadge('badge_uts',   document.getElementById('nilai_uts').value);
        setBadge('badge_uas',   document.getElementById('nilai_uas').value);
        const badge = document.getElementById('prevBadge');
        const c = scoreColor(na);
        badge.style.background = c.bg;
        badge.style.color = c.color;
        badge.style.border = `1px solid ${c.border}`;
        badge.textContent = na >= 75 ? 'Lulus' : 'Tidak Lulus';
    }

    document.getElementById('gradeForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = `<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="animation:spin .8s linear infinite"><circle cx="12" cy="12" r="10" stroke-opacity=".25"/><path d="M12 2a10 10 0 0 1 10 10"/></svg> Menyimpan…`;
    });

    recalc();
</script>
</x-app-layout>