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
    .section-divider{border:none;border-top:1px solid var(--border);margin:0;}
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
    .kategori-info{display:flex;align-items:center;gap:10px;padding:10px 14px;background:var(--surface2);border-radius:var(--radius-sm);border:1px solid var(--border);margin-top:4px;}
    .poin-big{font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;font-weight:800;color:var(--text);}
    .form-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border);}
    @media(max-width:680px){.page{padding:16px;}.form-grid{grid-template-columns:1fr;}.col-span-2{grid-column:span 1;}}
    @keyframes spin{to{transform:rotate(360deg);}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.pelanggaran.index') }}">Data Pelanggaran</a>
        <span class="sep">›</span>
        <span class="current">Catat Pelanggaran</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Catat Pelanggaran Baru</h1>
            <p class="page-sub">Isi data pelanggaran siswa dengan lengkap dan akurat</p>
        </div>
        <a href="{{ route('admin.pelanggaran.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.pelanggaran.store') }}" method="POST" id="pelForm">
        @csrf
        <div class="form-card">
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Data Siswa & Pelanggaran
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Siswa <span class="req">*</span></label>
                        <select name="siswa_id" class="{{ $errors->has('siswa_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Siswa —</option>
                            @foreach($siswaList as $s)
                            <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->nama_lengkap }} ({{ $s->nis }}) — {{ $s->kelas->nama_kelas ?? '' }}
                            </option>
                            @endforeach
                        </select>
                        @error('siswa_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Kategori Pelanggaran <span class="req">*</span></label>
                        <select name="kategori_pelanggaran_id" id="kategoriSelect"
                            class="{{ $errors->has('kategori_pelanggaran_id') ? 'is-invalid' : '' }}"
                            onchange="showKategoriInfo(this)">
                            <option value="">— Pilih Kategori —</option>
                            @foreach($kategoriList as $k)
                            <option value="{{ $k->id }}" data-poin="{{ $k->poin_default }}" data-tingkat="{{ $k->tingkat }}"
                                {{ old('kategori_pelanggaran_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }} ({{ $k->poin_default }} poin)
                            </option>
                            @endforeach
                        </select>
                        <div class="kategori-info" id="kategoriInfo" style="display:none">
                            <span class="poin-big" id="kategoriPoin">0</span>
                            <div>
                                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;">Poin Default</p>
                                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;color:var(--text2);" id="kategoriTingkat"></p>
                            </div>
                        </div>
                        @error('kategori_pelanggaran_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tanggal Kejadian <span class="req">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                            class="{{ $errors->has('tanggal') ? 'is-invalid' : '' }}">
                        @error('tanggal')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Poin Pelanggaran <span class="req">*</span></label>
                        <input type="number" name="poin" id="poinInput"
                            value="{{ old('poin') }}" min="1" max="100"
                            placeholder="Otomatis dari kategori"
                            class="{{ $errors->has('poin') ? 'is-invalid' : '' }}">
                        <span class="field-hint">Kosongkan untuk menggunakan poin default kategori.</span>
                        @error('poin')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Status <span class="req">*</span></label>
                        <select name="status" class="{{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <option value="pending"  {{ old('status','pending') == 'pending'  ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ old('status') == 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="selesai"  {{ old('status') == 'selesai'  ? 'selected' : '' }}>Selesai</option>
                            <option value="banding"  {{ old('status') == 'banding'  ? 'selected' : '' }}>Banding</option>
                        </select>
                        @error('status')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field col-span-2">
                        <label>Deskripsi Pelanggaran <span class="req">*</span></label>
                        <textarea name="deskripsi" rows="4" placeholder="Jelaskan kronologi dan detail pelanggaran yang terjadi..."
                            class="{{ $errors->has('deskripsi') ? 'is-invalid' : '' }}">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    Tindakan Lanjut
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field col-span-2">
                        <label>Tindakan yang Diambil</label>
                        <textarea name="tindakan" rows="3" placeholder="Tindakan yang sudah atau akan diambil oleh pihak sekolah...">{{ old('tindakan') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.pelanggaran.index') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Pelanggaran
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

    function showKategoriInfo(sel) {
        const opt  = sel.options[sel.selectedIndex];
        const info = document.getElementById('kategoriInfo');
        if (opt.value) {
            document.getElementById('kategoriPoin').textContent    = opt.dataset.poin;
            document.getElementById('kategoriTingkat').textContent = 'Tingkat: ' + ucfirstTingkat(opt.dataset.tingkat);
            info.style.display = 'flex';
            const poinInput = document.getElementById('poinInput');
            if (!poinInput.value) {
                poinInput.placeholder = 'Default: ' + opt.dataset.poin + ' poin';
                poinInput.value       = opt.dataset.poin;
            }
        } else {
            info.style.display = 'none';
        }
    }

    function ucfirstTingkat(s) {
        if (!s) return '';
        return s.charAt(0).toUpperCase() + s.slice(1);
    }

    window.addEventListener('load', function() {
        const sel = document.getElementById('kategoriSelect');
        if (sel.value) showKategoriInfo(sel);
    });

    document.getElementById('pelForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>