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
    .page{padding:28px 28px 60px;max-width:2000px;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand);}
    .breadcrumb .sep{color:var(--border2);}.breadcrumb .current{color:var(--text2);}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap;}
    .btn-back{padding:8px 14px;font-size:13px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
    .btn-back:hover{background:var(--surface3);}
    .btn-cancel{background:var(--surface);color:var(--text2);border:1px solid var(--border);}
    .btn-cancel:hover{background:var(--surface3);}
    .btn-primary{background:var(--brand);color:#fff;}
    .btn-primary:hover{filter:brightness(.93);}
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
    .field input,.field select{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none;transition:border-color .15s,background .15s;}
    .field input:focus,.field select:focus{border-color:var(--brand-h);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1);}
    .field input::placeholder{color:var(--text3);}
    .field input.is-invalid,.field select.is-invalid{border-color:var(--red);background:#fff8f8;}
    .field-error{font-size:12px;color:var(--red);font-family:'DM Sans',sans-serif;}
    .field-hint{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;}
    .form-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border);}
    @media(max-width:680px){.page{padding:16px;}.form-grid{grid-template-columns:1fr;}.col-span-2{grid-column:span 1;}}
    @keyframes spin{to{transform:rotate(360deg);}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.kelas.index') }}">Data Kelas</a>
        <span class="sep">›</span>
        <span class="current">Tambah Kelas</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Kelas Baru</h1>
            <p class="page-sub">Isi data kelas/rombongan belajar dengan lengkap</p>
        </div>
        <a href="{{ route('admin.kelas.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.kelas.store') }}" method="POST" id="kelasForm">
        @csrf
        <div class="form-card">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Informasi Kelas
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Nama Kelas <span class="req">*</span></label>
                        <input type="text" name="nama_kelas" value="{{ old('nama_kelas') }}"
                            placeholder="cth. X IPA 1"
                            class="{{ $errors->has('nama_kelas') ? 'is-invalid' : '' }}">
                        @error('nama_kelas')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Kode Kelas <span class="req">*</span></label>
                        <input type="text" name="kode_kelas" value="{{ old('kode_kelas') }}"
                            placeholder="cth. X-IPA-1"
                            class="{{ $errors->has('kode_kelas') ? 'is-invalid' : '' }}">
                        @error('kode_kelas')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tingkat <span class="req">*</span></label>
                        <select name="tingkat" class="{{ $errors->has('tingkat') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Tingkat —</option>
                            @foreach(['X','XI','XII'] as $t)
                            <option value="{{ $t }}" {{ old('tingkat') == $t ? 'selected' : '' }}>Tingkat {{ $t }}</option>
                            @endforeach
                        </select>
                        @error('tingkat')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Jurusan</label>
                        <input type="text" name="jurusan" value="{{ old('jurusan') }}"
                            placeholder="cth. IPA, IPS, Teknik Komputer...">
                        @error('jurusan')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Kapasitas Maks. <span class="req">*</span></label>
                        <input type="number" name="kapasitas_maks" value="{{ old('kapasitas_maks', 36) }}"
                            min="1" max="50" placeholder="36"
                            class="{{ $errors->has('kapasitas_maks') ? 'is-invalid' : '' }}">
                        @error('kapasitas_maks')<span class="field-error">{{ $message }}</span>@enderror
                        <span class="field-hint">Maksimal 50 siswa per kelas.</span>
                    </div>
                    <div class="field">
                        <label>Status <span class="req">*</span></label>
                        <select name="status" class="{{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Relasi Kelas
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Tahun Ajaran <span class="req">*</span></label>
                        <select name="tahun_ajaran_id" class="{{ $errors->has('tahun_ajaran_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Tahun Ajaran —</option>
                            @foreach($tahunAjarans as $ta)
                            <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                {{ $ta->tahun }}{{ $ta->status === 'aktif' ? ' (Aktif)' : '' }}
                            </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Wali Kelas</label>
                        <select name="wali_kelas_id" class="{{ $errors->has('wali_kelas_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Wali Kelas (opsional) —</option>
                            @foreach($gurus as $g)
                            <option value="{{ $g->id }}" {{ old('wali_kelas_id') == $g->id ? 'selected' : '' }}>
                                {{ $g->nama_lengkap }}
                            </option>
                            @endforeach
                        </select>
                        @error('wali_kelas_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field col-span-2">
                        <label>Ruang Kelas</label>
                        <select name="ruang_id" class="{{ $errors->has('ruang_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Ruangan (opsional) —</option>
                            @foreach($ruangs as $r)
                            <option value="{{ $r->id }}" {{ old('ruang_id') == $r->id ? 'selected' : '' }}>
                                {{ $r->nama_ruang }} — {{ $r->gedung->nama_gedung ?? '' }} (Kapasitas: {{ $r->kapasitas }})
                            </option>
                            @endforeach
                        </select>
                        @error('ruang_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-cancel">Batal</a>
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
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
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
    document.getElementById('kelasForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>