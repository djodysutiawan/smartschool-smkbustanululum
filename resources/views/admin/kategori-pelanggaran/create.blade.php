<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-h:#3582f0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;--radius:10px;--radius-sm:7px;}
    .page{padding:28px 28px 60px;max-width:2000px;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand);}
    .breadcrumb .sep{color:var(--border2);}.breadcrumb .current{color:var(--text2);}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap;}
    .btn-back{padding:8px 14px;font-size:13px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);}.btn-back:hover{background:var(--surface3);}
    .btn-cancel{background:var(--surface);color:var(--text2);border:1px solid var(--border);}.btn-cancel:hover{background:var(--surface3);}
    .btn-primary{background:var(--brand);color:#fff;}.btn-primary:hover{filter:brightness(.93);}
    .btn-primary:disabled{opacity:.6;cursor:not-allowed;filter:none;}
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .form-section{padding:20px 24px 24px;}
    .section-label{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.07em;text-transform:uppercase;margin-bottom:16px;}
    .section-label-line{flex:1;height:1px;background:var(--border);}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .col-span-2{grid-column:span 2;}
    .field{display:flex;flex-direction:column;gap:6px;}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);}
    .field label .req{color:var(--brand);margin-left:2px;}
    .field input,.field select,.field textarea{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none;transition:border-color .15s,background .15s;box-sizing:border-box;}
    .field textarea{height:auto;padding:10px 12px;resize:vertical;}
    .field input:focus,.field select:focus,.field textarea:focus{border-color:var(--brand-h);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1);}
    .field input::placeholder,.field textarea::placeholder{color:var(--text3);}
    .field input.is-invalid,.field select.is-invalid,.field textarea.is-invalid{border-color:var(--red);background:#fff8f8;}
    .field-error{font-size:12px;color:var(--red);font-family:'DM Sans',sans-serif;margin-top:-2px;}
    .field-hint{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;margin-top:-2px;}
    .toggle-row{display:flex;align-items:center;gap:12px;}
    .toggle-switch{position:relative;display:inline-block;width:42px;height:24px;}
    .toggle-switch input{opacity:0;width:0;height:0;}
    .toggle-slider{position:absolute;inset:0;border-radius:99px;background:var(--border2);cursor:pointer;transition:background .2s;}
    .toggle-slider::before{content:'';position:absolute;width:18px;height:18px;left:3px;top:3px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.2);}
    .toggle-switch input:checked + .toggle-slider{background:var(--brand);}
    .toggle-switch input:checked + .toggle-slider::before{transform:translateX(18px);}
    .toggle-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);}
    .poin-preview{display:flex;align-items:center;gap:8px;padding:10px 14px;background:var(--surface2);border-radius:var(--radius-sm);border:1px solid var(--border);}
    .poin-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:28px;font-weight:800;color:var(--text);}
    .poin-label-txt{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;color:var(--text3);}
    .color-row{display:flex;align-items:center;gap:10px;}
    .color-swatch{width:32px;height:32px;border-radius:7px;border:2px solid var(--border);flex-shrink:0;}
    .form-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border);}
    @media(max-width:680px){.page{padding:16px;}.form-grid{grid-template-columns:1fr;}.col-span-2{grid-column:span 1;}}
    @keyframes spin{to{transform:rotate(360deg);}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.kategori-pelanggaran.index') }}">Kategori Pelanggaran</a>
        <span class="sep">›</span>
        <span class="current">Tambah</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Kategori Pelanggaran</h1>
            <p class="page-sub">Definisikan kategori baru beserta bobot poin pelanggarannya</p>
        </div>
        <a href="{{ route('admin.kategori-pelanggaran.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.kategori-pelanggaran.store') }}" method="POST" id="katForm">
        @csrf
        <div class="form-card">
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    Data Kategori
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field col-span-2">
                        <label>Nama Kategori <span class="req">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}"
                            placeholder="cth. Membolos, Terlambat, Perkelahian..."
                            class="{{ $errors->has('nama') ? 'is-invalid' : '' }}">
                        @error('nama')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tingkat Pelanggaran <span class="req">*</span></label>
                        <select name="tingkat" class="{{ $errors->has('tingkat') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Tingkat —</option>
                            @foreach(['ringan'=>'Ringan','sedang'=>'Sedang','berat'=>'Berat'] as $val => $label)
                            <option value="{{ $val }}" {{ old('tingkat') == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('tingkat')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Poin Default <span class="req">*</span></label>
                        <input type="number" name="poin_default" id="poinDefault"
                            value="{{ old('poin_default', 5) }}" min="1" max="100"
                            class="{{ $errors->has('poin_default') ? 'is-invalid' : '' }}"
                            oninput="updatePoin(this.value)">
                        <span class="field-hint">Poin yang otomatis terisi saat mencatat pelanggaran.</span>
                        @error('poin_default')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Preview Poin</label>
                        <div class="poin-preview">
                            <span class="poin-val" id="poinPreview">{{ old('poin_default', 5) }}</span>
                            <span class="poin-label-txt">POIN PELANGGARAN</span>
                        </div>
                    </div>
                    <div class="field">
                        <label>Batas Poin Maksimum</label>
                        <input type="number" name="batas_poin" value="{{ old('batas_poin') }}"
                            min="1" placeholder="cth. 100"
                            class="{{ $errors->has('batas_poin') ? 'is-invalid' : '' }}">
                        <span class="field-hint">Batas akumulasi poin sebelum ada tindakan khusus. (opsional)</span>
                        @error('batas_poin')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Warna Indikator</label>
                        <div class="color-row">
                            <input type="color" name="warna" id="warnaInput"
                                value="{{ old('warna', '#3b82f6') }}"
                                style="height:38px;width:60px;padding:2px 4px;cursor:pointer;"
                                oninput="updateSwatch(this.value)">
                            <div class="color-swatch" id="colorSwatch" style="background:{{ old('warna','#3b82f6') }}"></div>
                            <span style="font-size:12.5px;color:var(--text3);">Pilih warna untuk tampilan UI</span>
                        </div>
                        @error('warna')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field" style="justify-content:flex-end;padding-bottom:4px">
                        <label>Status Aktif</label>
                        <div class="toggle-row" style="margin-top:8px">
                            <label class="toggle-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" id="isActiveToggle"
                                    {{ old('is_active','1') == '1' ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label" id="toggleLabel">Aktif</span>
                        </div>
                    </div>
                    <div class="field col-span-2">
                        <label>Deskripsi / Contoh Pelanggaran</label>
                        <textarea name="deskripsi" rows="3"
                            placeholder="Jelaskan contoh pelanggaran yang masuk kategori ini (opsional)..."
                            class="{{ $errors->has('deskripsi') ? 'is-invalid' : '' }}">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.kategori-pelanggaran.index') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Kategori
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if($errors->any())
    Swal.fire({ icon:'error', title:'Terdapat {{ $errors->count() }} Kesalahan',
        html:`<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`,
        confirmButtonColor:'#1f63db' });
    @endif
    function updatePoin(val) { document.getElementById('poinPreview').textContent = val || 0; }
    function updateSwatch(val) { document.getElementById('colorSwatch').style.background = val; }
    document.getElementById('isActiveToggle').addEventListener('change', function() {
        document.getElementById('toggleLabel').textContent = this.checked ? 'Aktif' : 'Nonaktif';
    });
    document.getElementById('katForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>