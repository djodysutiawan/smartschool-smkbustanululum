<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success', title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500, showConfirmButton: false,
            toast: true, position: 'top-end',
        });
    @endif
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
    .page { padding: 28px 28px 60px; max-width: 2000px; margin: 0 auto; }

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

    /* ── Alert ── */
    .alert {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px;
        font-size: 13.5px; background: var(--red-bg); color: var(--red); border: 1px solid var(--red-border);
    }
    .alert svg { flex-shrink: 0; margin-top: 1px; }

    /* ── Info banner (data lama) ── */
    .info-banner {
        display: flex; align-items: center; gap: 12px;
        padding: 14px 18px; border-radius: var(--radius-sm);
        background: var(--brand-50); border: 1px solid var(--brand-100);
        margin-bottom: 20px;
    }
    .info-banner-icon {
        width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
        background: var(--brand-100); display: flex; align-items: center; justify-content: center;
    }
    .info-banner-body { flex: 1; }
    .info-banner-title {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px;
        font-weight: 700; color: var(--brand-700); margin-bottom: 2px;
    }
    .info-banner-meta {
        display: flex; gap: 12px; flex-wrap: wrap;
        font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--text2);
    }
    .info-banner-meta span { display: flex; align-items: center; gap: 4px; }

    /* ── Form card ── */
    .form-card       { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .form-section    { padding: 20px 24px 24px; }
    .section-divider { border: none; border-top: 1px solid var(--border); margin: 0; }

    .section-label {
        display: flex; align-items: center; gap: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
        color: var(--text3); letter-spacing: .07em; text-transform: uppercase; margin-bottom: 16px;
    }
    .section-label-line { flex: 1; height: 1px; background: var(--border); }

    /* ── Grids ── */
    .form-grid        { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-grid.cols-3 { grid-template-columns: 1fr 1fr 1fr; }
    .col-span-2       { grid-column: span 2; }

    /* ── Fields ── */
    .field { display: flex; flex-direction: column; gap: 6px; }
    .field label {
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px;
        font-weight: 700; color: var(--text2);
    }
    .field label .req { color: var(--brand); margin-left: 2px; }
    .field input,
    .field select {
        height: 38px; padding: 0 12px;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif; font-size: 13.5px;
        color: var(--text); background: var(--surface2); width: 100%;
        outline: none; transition: border-color .15s, background .15s;
    }
    .field input[type="time"] { padding: 0 10px; cursor: pointer; }
    .field input:focus,
    .field select:focus {
        border-color: var(--brand-h); background: #fff;
        box-shadow: 0 0 0 3px rgba(53,130,240,.1);
    }
    .field input.is-invalid,
    .field select.is-invalid { border-color: var(--red); background: #fff8f8; }
    .field-error { font-size: 12px; color: var(--red); font-family: 'DM Sans', sans-serif; margin-top: -2px; }
    .field-hint  { font-size: 12px; color: var(--text3); font-family: 'DM Sans', sans-serif; margin-top: -2px; }

    /* ── Hari pills ── */
    .hari-group { display: flex; gap: 8px; flex-wrap: wrap; }
    .hari-item  { position: relative; }
    .hari-item input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
    .hari-item label {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 72px; height: 38px; padding: 0 16px;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        color: var(--text2); background: var(--surface2); cursor: pointer;
        transition: all .15s; user-select: none;
    }
    .hari-item label:hover { background: var(--surface3); border-color: var(--border2); }
    .hari-item input[type="radio"]:checked + label {
        background: var(--brand); color: #fff; border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(53,130,240,.15);
    }

    /* ── Durasi preview ── */
    .durasi-preview {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 12px; border-radius: var(--radius-sm);
        background: #dcfce7; border: 1px solid #bbf7d0;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700;
        color: #15803d; transition: all .2s;
    }
    .durasi-preview.empty {
        background: var(--surface3); border-color: var(--border);
        color: var(--text3);
    }

    /* ── Form footer ── */
    .form-footer {
        display: flex; align-items: center; justify-content: flex-end; gap: 10px;
        padding: 16px 24px; background: var(--surface2); border-top: 1px solid var(--border);
    }

    /* ── Responsive ── */
    @media (max-width: 680px) {
        .page { padding: 16px 16px 40px; }
        .form-grid,
        .form-grid.cols-3 { grid-template-columns: 1fr; }
        .col-span-2 { grid-column: span 1; }
        .hari-group { gap: 6px; }
        .hari-item label { min-width: 60px; font-size: 12px; padding: 0 10px; }
    }

    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.piket-teachers.index') }}">Guru Piket</a>
        <span class="sep">›</span>
        <span class="current">Edit Jadwal</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Jadwal Guru Piket</h1>
            <p class="page-sub">Ubah data jadwal piket, lalu klik Simpan Perubahan</p>
        </div>
        <a href="{{ route('admin.piket-teachers.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Info banner — data lama --}}
    <div class="info-banner">
        <div class="info-banner-icon">
            <svg width="16" height="16" fill="none" stroke="#1750c0" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
        </div>
        <div class="info-banner-body">
            <p class="info-banner-title">Jadwal yang sedang diedit</p>
            <div class="info-banner-meta">
                <span>
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                    {{ $piketTeacher->teacher->nama_lengkap }}
                </span>
                <span>
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    {{ $piketTeacher->hari }}
                </span>
                <span>
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    {{ \Carbon\Carbon::parse($piketTeacher->jam_mulai)->format('H:i') }}
                    &ndash;
                    {{ \Carbon\Carbon::parse($piketTeacher->jam_selesai)->format('H:i') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Inline alerts (fallback) --}}
    @if(session('error'))
        <div class="alert">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
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

    <form action="{{ route('admin.piket-teachers.update', $piketTeacher->id) }}" method="POST"
          id="piketForm">
        @csrf
        @method('PUT')
        <div class="form-card">

            {{-- ═══ 1. GURU & HARI ═══ --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                    Guru &amp; Hari Piket
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid" style="gap:20px">
                    <div class="field col-span-2">
                        <label>Guru <span class="req">*</span></label>
                        <select name="teacher_id"
                            class="{{ $errors->has('teacher_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Guru —</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}"
                                    {{ old('teacher_id', $piketTeacher->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->nama_lengkap }}
                                    @if($teacher->nip) ({{ $teacher->nip }}) @endif
                                </option>
                            @endforeach
                        </select>
                        <span class="field-hint">Hanya menampilkan guru dengan status aktif</span>
                        @error('teacher_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field col-span-2">
                        <label>Hari <span class="req">*</span></label>
                        <div class="hari-group">
                            @foreach($hariList as $hari)
                                <div class="hari-item">
                                    <input type="radio" name="hari"
                                        id="hari_{{ $hari }}"
                                        value="{{ $hari }}"
                                        {{ old('hari', $piketTeacher->hari) == $hari ? 'checked' : '' }}>
                                    <label for="hari_{{ $hari }}">{{ $hari }}</label>
                                </div>
                            @endforeach
                        </div>
                        @error('hari')<span class="field-error" style="margin-top:4px;display:block">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            {{-- ═══ 2. JAM PIKET ═══ --}}
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    Jam Piket
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid cols-3">
                    <div class="field">
                        <label>Jam Mulai <span class="req">*</span></label>
                        <input type="time" name="jam_mulai" id="jamMulai"
                            value="{{ old('jam_mulai', \Carbon\Carbon::parse($piketTeacher->jam_mulai)->format('H:i')) }}"
                            class="{{ $errors->has('jam_mulai') ? 'is-invalid' : '' }}"
                            onchange="updateDurasi()">
                        @error('jam_mulai')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Jam Selesai <span class="req">*</span></label>
                        <input type="time" name="jam_selesai" id="jamSelesai"
                            value="{{ old('jam_selesai', \Carbon\Carbon::parse($piketTeacher->jam_selesai)->format('H:i')) }}"
                            class="{{ $errors->has('jam_selesai') ? 'is-invalid' : '' }}"
                            onchange="updateDurasi()">
                        <span class="field-hint">Harus lebih dari jam mulai</span>
                        @error('jam_selesai')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Durasi</label>
                        <div style="padding-top:4px">
                            <div class="durasi-preview empty" id="durasiPreview">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                <span id="durasiText">—</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ FOOTER ═══ --}}
            <div class="form-footer">
                <a href="{{ route('admin.piket-teachers.index') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>

        </div>{{-- /.form-card --}}
    </form>

</div>{{-- /.page --}}

<script>
    /* ── Hitung & tampilkan durasi ── */
    function updateDurasi() {
        const mulai   = document.getElementById('jamMulai').value;
        const selesai = document.getElementById('jamSelesai').value;
        const preview = document.getElementById('durasiPreview');
        const text    = document.getElementById('durasiText');

        if (!mulai || !selesai) {
            preview.className = 'durasi-preview empty';
            text.textContent  = '—';
            return;
        }

        const [hM, mM] = mulai.split(':').map(Number);
        const [hS, mS] = selesai.split(':').map(Number);
        const totalMin = (hS * 60 + mS) - (hM * 60 + mM);

        if (totalMin <= 0) {
            preview.className = 'durasi-preview empty';
            text.textContent  = 'Jam selesai harus lebih besar';
            preview.style.background   = '#fee2e2';
            preview.style.borderColor  = '#fecaca';
            preview.style.color        = '#dc2626';
            return;
        }

        preview.className             = 'durasi-preview';
        preview.style.background      = '';
        preview.style.borderColor     = '';
        preview.style.color           = '';

        const jam    = Math.floor(totalMin / 60);
        const menit  = totalMin % 60;
        text.textContent = jam > 0
            ? (menit > 0 ? `${jam} jam ${menit} menit` : `${jam} jam`)
            : `${menit} menit`;
    }

    /* ── Init durasi saat halaman load ── */
    updateDurasi();

    /* ── Disable submit saat proses ── */
    document.getElementById('piketForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled  = true;
        btn.innerHTML = `
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                 style="animation:spin .7s linear infinite">
                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
            </svg>
            Menyimpan…`;
    });
</script>

</x-app-layout>