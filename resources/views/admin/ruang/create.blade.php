<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand:      #1f63db;
        --brand-h:    #3582f0;
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

    .page { padding:28px 28px 60px; max-width:2000px; margin:0 auto; }
    .breadcrumb { display:flex; align-items:center; gap:6px; font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:600; color:var(--text3); margin-bottom:20px; }
    .breadcrumb a { color:var(--text3); text-decoration:none; transition:color .15s; }
    .breadcrumb a:hover { color:var(--brand); }
    .breadcrumb .sep { color:var(--border2); }
    .breadcrumb .current { color:var(--text2); }

    .page-header { display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:24px; flex-wrap:wrap; }
    .page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:20px; font-weight:800; color:var(--text); }
    .page-sub { font-size:12.5px; color:var(--text3); margin-top:3px; }

    .btn { display:inline-flex; align-items:center; gap:6px; padding:9px 20px; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13.5px; font-weight:700; cursor:pointer; border:none; text-decoration:none; transition:filter .15s, background .15s; white-space:nowrap; }
    .btn-back { padding:8px 14px; font-size:13px; background:var(--surface2); color:var(--text2); border:1px solid var(--border); }
    .btn-back:hover { background:var(--surface3); }
    .btn-cancel { background:var(--surface); color:var(--text2); border:1px solid var(--border); }
    .btn-cancel:hover { background:var(--surface3); }
    .btn-primary { background:var(--brand); color:#fff; }
    .btn-primary:hover { filter:brightness(.93); }
    .btn-primary:disabled { opacity:.6; cursor:not-allowed; filter:none; }

    .alert { display:flex; align-items:flex-start; gap:10px; padding:12px 16px; border-radius:var(--radius-sm); margin-bottom:20px; font-size:13.5px; background:var(--red-bg); color:var(--red); border:1px solid var(--red-border); }

    .form-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; }
    .form-section { padding:20px 24px 24px; }
    .section-divider { border:none; border-top:1px solid var(--border); margin:0; }
    .section-label { display:flex; align-items:center; gap:8px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; color:var(--text3); letter-spacing:.07em; text-transform:uppercase; margin-bottom:16px; }
    .section-label-line { flex:1; height:1px; background:var(--border); }

    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }

    .field { display:flex; flex-direction:column; gap:6px; }
    .field label { font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; color:var(--text2); }
    .field label .req { color:var(--brand); margin-left:2px; }
    .field input, .field select, .field textarea { height:38px; padding:0 12px; border:1px solid var(--border); border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:13.5px; color:var(--text); background:var(--surface2); width:100%; outline:none; transition:border-color .15s, background .15s; }
    .field textarea { height:auto; padding:10px 12px; resize:vertical; }
    .field input:focus, .field select:focus, .field textarea:focus { border-color:var(--brand-h); background:#fff; box-shadow:0 0 0 3px rgba(53,130,240,.1); }
    .field input::placeholder, .field textarea::placeholder { color:var(--text3); }
    .field input.is-invalid, .field select.is-invalid, .field textarea.is-invalid { border-color:var(--red); background:#fff8f8; }
    .field-error { font-size:12px; color:var(--red); font-family:'DM Sans',sans-serif; margin-top:-2px; }
    .field-hint  { font-size:12px; color:var(--text3); font-family:'DM Sans',sans-serif; margin-top:-2px; }

    .checkbox-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:10px; }
    .checkbox-item { display:flex; align-items:center; gap:8px; padding:10px 14px; border:1.5px solid var(--border); border-radius:var(--radius-sm); cursor:pointer; transition:border-color .15s, background .15s; }
    .checkbox-item:hover { border-color:var(--brand-h); background:var(--surface2); }
    .checkbox-item input[type="checkbox"] { width:16px; height:16px; accent-color:var(--brand); cursor:pointer; }
    .checkbox-item .cb-label { font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; color:var(--text2); }
    .checkbox-item.checked { border-color:#bfdbfe; background:#eff6ff; }
    .checkbox-item.checked .cb-label { color:var(--brand); }

    .form-footer { display:flex; align-items:center; justify-content:flex-end; gap:10px; padding:16px 24px; background:var(--surface2); border-top:1px solid var(--border); }

    @media (max-width:680px) {
        .page { padding:16px 16px 40px; }
        .form-grid { grid-template-columns:1fr; }
        .checkbox-grid { grid-template-columns:1fr 1fr; }
    }
    @keyframes spin { to { transform:rotate(360deg); } }
</style>

<div class="page">

    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ruang.index') }}">Manajemen Ruang</a>
        <span class="sep">›</span>
        <span class="current">Tambah Ruang</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Ruang Baru</h1>
            <p class="page-sub">Isi semua data dengan benar, lalu klik Simpan Data</p>
        </div>
        <a href="{{ route('admin.ruang.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.ruang.store') }}" method="POST" id="ruangForm">
        @csrf
        <div class="form-card">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                    Informasi Ruang
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Gedung <span class="req">*</span></label>
                        <select name="gedung_id" class="{{ $errors->has('gedung_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Gedung —</option>
                            @foreach($gedungs as $g)
                                <option value="{{ $g->id }}" {{ old('gedung_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_gedung }}</option>
                            @endforeach
                        </select>
                        @error('gedung_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Kode Ruang <span class="req">*</span></label>
                        <input type="text" name="kode_ruang" value="{{ old('kode_ruang') }}" placeholder="cth. R-101" maxlength="15" class="{{ $errors->has('kode_ruang') ? 'is-invalid' : '' }}">
                        @error('kode_ruang')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Nama Ruang <span class="req">*</span></label>
                        <input type="text" name="nama_ruang" value="{{ old('nama_ruang') }}" placeholder="cth. Ruang Kelas 1A" maxlength="100" class="{{ $errors->has('nama_ruang') ? 'is-invalid' : '' }}">
                        @error('nama_ruang')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Lantai <span class="req">*</span></label>
                        <input type="number" name="lantai" value="{{ old('lantai', 1) }}" min="1" class="{{ $errors->has('lantai') ? 'is-invalid' : '' }}">
                        @error('lantai')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Jenis Ruang <span class="req">*</span></label>
                        <select name="jenis_ruang" class="{{ $errors->has('jenis_ruang') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Jenis —</option>
                            @foreach($jenisOptions as $j)
                                <option value="{{ $j }}" {{ old('jenis_ruang') == $j ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$j)) }}</option>
                            @endforeach
                        </select>
                        @error('jenis_ruang')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Kapasitas <span class="req">*</span></label>
                        <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" min="1" max="500" placeholder="cth. 32" class="{{ $errors->has('kapasitas') ? 'is-invalid' : '' }}">
                        @error('kapasitas')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Status <span class="req">*</span></label>
                        <select name="status" class="{{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <option value="tersedia"       {{ old('status','tersedia')=='tersedia'       ? 'selected' : '' }}>Tersedia</option>
                            <option value="tidak_tersedia" {{ old('status')=='tidak_tersedia'            ? 'selected' : '' }}>Tidak Tersedia</option>
                            <option value="perbaikan"      {{ old('status')=='perbaikan'                 ? 'selected' : '' }}>Perbaikan</option>
                        </select>
                        @error('status')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" value="{{ old('keterangan') }}" placeholder="Opsional" maxlength="500">
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    Fasilitas Ruang
                    <span class="section-label-line"></span>
                </p>
                <div class="checkbox-grid">
                    @foreach([
                        ['ada_proyektor','Proyektor'],
                        ['ada_ac','AC'],
                        ['ada_wifi','WiFi'],
                        ['ada_komputer','Komputer'],
                    ] as [$name, $label])
                    <label class="checkbox-item {{ old($name) ? 'checked' : '' }}" id="wrap-{{ $name }}">
                        <input type="hidden" name="{{ $name }}" value="0">
                        <input type="checkbox" name="{{ $name }}" value="1" {{ old($name) ? 'checked' : '' }}
                            onchange="toggleCheck(this, 'wrap-{{ $name }}')">
                        <span class="cb-label">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
                <div class="field" style="margin-top:14px">
                    <label>Fasilitas Lain</label>
                    <input type="text" name="fasilitas_lain" value="{{ old('fasilitas_lain') }}" placeholder="cth. Papan tulis digital, Sound system" maxlength="500">
                    <span class="field-hint">Pisahkan dengan koma jika lebih dari satu</span>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.ruang.index') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Data
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if($errors->any())
    Swal.fire({
        icon:'error', title:'Terdapat {{ $errors->count() }} Kesalahan',
        html:`<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`,
        confirmButtonColor:'#1f63db',
    });
    @endif

    function toggleCheck(el, wrapId) {
        const wrap = document.getElementById(wrapId);
        if (el.checked) wrap.classList.add('checked');
        else wrap.classList.remove('checked');
    }

    document.getElementById('ruangForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>