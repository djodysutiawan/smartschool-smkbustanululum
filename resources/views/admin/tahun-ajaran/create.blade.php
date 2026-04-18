<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db;--brand-h:#3582f0;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box;}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;}
    .breadcrumb a{color:var(--text3);text-decoration:none;transition:color .15s;}
    .breadcrumb a:hover{color:var(--brand);}
    .breadcrumb .sep{color:var(--border2);}
    .breadcrumb .current{color:var(--text2);}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
    .btn-back:hover{background:var(--surface3);filter:none;}
    .btn-cancel{background:var(--surface);color:var(--text2);border:1px solid var(--border);}
    .btn-cancel:hover{background:var(--surface3);filter:none;}
    .btn-primary{background:var(--brand);color:#fff;}
    .btn-primary:hover{filter:brightness(.93);}
    .btn-primary:disabled{opacity:.6;cursor:not-allowed;filter:none;}
    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;background:var(--red-bg);color:var(--red);border:1px solid var(--red-border);}
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .form-section{padding:20px 24px 24px;}
    .section-divider{border:none;border-top:1px solid var(--border);margin:0;}
    .section-label{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.07em;text-transform:uppercase;margin-bottom:16px;}
    .section-label-line{flex:1;height:1px;background:var(--border);}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .col-span-2{grid-column:span 2;}
    .field{display:flex;flex-direction:column;gap:6px;}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);}
    .field label .req{color:var(--red);margin-left:2px;}
    .field input,.field select,.field textarea{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none;transition:border-color .15s,background .15s;}
    .field textarea{height:auto;padding:10px 12px;resize:vertical;}
    .field input:focus,.field select:focus,.field textarea:focus{border-color:var(--brand-h);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1);}
    .field input::placeholder,.field textarea::placeholder{color:var(--text3);}
    .field input.is-invalid,.field select.is-invalid,.field textarea.is-invalid{border-color:var(--red);background:#fff8f8;}
    .field-error{font-size:12px;color:var(--red);font-family:'DM Sans',sans-serif;margin-top:-2px;}
    .field-hint{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;margin-top:-2px;}
    .info-box{background:#eef6ff;border:1px solid #d9ebff;border-radius:var(--radius-sm);padding:12px 16px;font-size:13px;color:#1750c0;font-family:'DM Sans',sans-serif;display:flex;align-items:flex-start;gap:8px;margin-bottom:20px;}
    .form-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border);}
    @media(max-width:680px){.page{padding:16px 16px 40px;}.form-grid{grid-template-columns:1fr;}.col-span-2{grid-column:span 1;}}
    @keyframes spin{to{transform:rotate(360deg);}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.tahun-ajaran.index') }}">Tahun Ajaran</a>
        <span class="sep">›</span>
        <span class="current">Tambah</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Tahun Ajaran</h1>
            <p class="page-sub">Isi data tahun ajaran dan semester dengan benar</p>
        </div>
        <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    @if($errors->any())
    <div class="alert">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            <strong style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;">Terdapat {{ $errors->count() }} kesalahan:</strong>
            <ul style="margin:6px 0 0 16px;display:flex;flex-direction:column;gap:2px;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.tahun-ajaran.store') }}" method="POST" id="taForm">
        @csrf
        <div class="form-card">
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Informasi Tahun Ajaran
                    <span class="section-label-line"></span>
                </p>

                <div class="form-grid">
                    <div class="field">
                        <label>Tahun Ajaran <span class="req">*</span></label>
                        <input type="text" name="tahun" value="{{ old('tahun') }}"
                            placeholder="cth. 2024/2025"
                            class="{{ $errors->has('tahun') ? 'is-invalid' : '' }}">
                        <span class="field-hint">Format: YYYY/YYYY, contoh 2024/2025</span>
                        @error('tahun')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Semester <span class="req">*</span></label>
                        <select name="semester" class="{{ $errors->has('semester') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Semester —</option>
                            <option value="ganjil" {{ old('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="genap"  {{ old('semester') == 'genap'  ? 'selected' : '' }}>Genap</option>
                        </select>
                        @error('semester')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tanggal Mulai <span class="req">*</span></label>
                        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                            class="{{ $errors->has('tanggal_mulai') ? 'is-invalid' : '' }}">
                        @error('tanggal_mulai')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tanggal Selesai <span class="req">*</span></label>
                        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                            class="{{ $errors->has('tanggal_selesai') ? 'is-invalid' : '' }}">
                        @error('tanggal_selesai')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Status <span class="req">*</span></label>
                        <select name="status" class="{{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <option value="tidak_aktif" {{ old('status', 'tidak_aktif') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        </select>
                        <span class="field-hint">Memilih "Aktif" akan menonaktifkan tahun ajaran lain secara otomatis.</span>
                        @error('status')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field col-span-2">
                        <label>Keterangan</label>
                        <textarea name="keterangan" rows="3"
                            placeholder="Catatan tambahan (opsional)..."
                            class="{{ $errors->has('keterangan') ? 'is-invalid' : '' }}">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn btn-cancel">Batal</a>
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
        icon: 'error',
        title: 'Terdapat {{ $errors->count() }} Kesalahan',
        html: `<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`,
        confirmButtonColor: '#1f63db',
    });
    @endif

    document.getElementById('taForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>