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
    .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap;}
    .btn-back{padding:8px 14px;font-size:13px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
    .btn-back:hover{background:var(--surface3);}
    .btn-cancel{background:var(--surface);color:var(--text2);border:1px solid var(--border);}
    .btn-cancel:hover{background:var(--surface3);}
    .btn-primary{background:var(--brand);color:#fff;}
    .btn-primary:hover{filter:brightness(.93);}
    .btn-primary:disabled{opacity:.6;cursor:not-allowed;filter:none;}
    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;background:var(--red-bg);color:var(--red);border:1px solid var(--red-border);}
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px;}
    .form-section{padding:20px 24px 24px;}
    .section-divider{border:none;border-top:1px solid var(--border);margin:0;}
    .section-label{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.07em;text-transform:uppercase;margin-bottom:16px;}
    .section-label-line{flex:1;height:1px;background:var(--border);}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .form-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;}
    .col-span-2{grid-column:span 2;}
    .field{display:flex;flex-direction:column;gap:6px;}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);}
    .req{color:var(--brand);margin-left:2px;}
    .field input,.field select,.field textarea{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none;transition:border-color .15s,background .15s;}
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
    .toggle-switch input:checked+.toggle-slider{background:var(--brand);}
    .toggle-switch input:checked+.toggle-slider::before{transform:translateX(18px);}
    .toggle-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);}
    .form-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border);}
    @keyframes spin{to{transform:rotate(360deg);}}
    @media(max-width:680px){.page{padding:16px 16px 40px;}.form-grid,.form-grid-3{grid-template-columns:1fr;}.col-span-2{grid-column:span 1;}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ujian.index') }}">Data Ujian</a>
        <span class="sep">›</span>
        <span class="current">Tambah Ujian</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Ujian Baru</h1>
            <p class="page-sub">Isi semua data dengan benar, lalu klik Simpan Data</p>
        </div>
        <a href="{{ route('admin.ujian.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>
                <strong style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">Terdapat {{ $errors->count() }} kesalahan:</strong>
                <ul style="margin:6px 0 0 16px;display:flex;flex-direction:column;gap:2px">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.ujian.store') }}" method="POST" id="ujianForm">
        @csrf
        <div class="form-card">
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    Informasi Ujian
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field col-span-2">
                        <label>Judul Ujian <span class="req">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul') }}" placeholder="cth. Ulangan Harian Bab 3 — Aljabar" class="{{ $errors->has('judul')?'is-invalid':'' }}">
                        @error('judul')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Mata Pelajaran <span class="req">*</span></label>
                        <select name="mata_pelajaran_id" class="{{ $errors->has('mata_pelajaran_id')?'is-invalid':'' }}">
                            <option value="">— Pilih Mapel —</option>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id }}" {{ old('mata_pelajaran_id')==$m->id?'selected':'' }}>{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                        @error('mata_pelajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Jenis Ujian <span class="req">*</span></label>
                        <select name="jenis" class="{{ $errors->has('jenis')?'is-invalid':'' }}">
                            <option value="">— Pilih Jenis —</option>
                            @foreach($jenisList as $j)
                                <option value="{{ $j }}" {{ old('jenis')==$j?'selected':'' }}>{{ strtoupper(str_replace('_',' ',$j)) }}</option>
                            @endforeach
                        </select>
                        @error('jenis')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Kelas <span class="req">*</span></label>
                        <select name="kelas_id" class="{{ $errors->has('kelas_id')?'is-invalid':'' }}">
                            <option value="">— Pilih Kelas —</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id')==$k->id?'selected':'' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                        @error('kelas_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Guru Pengawas <span class="req">*</span></label>
                        <select name="guru_id" class="{{ $errors->has('guru_id')?'is-invalid':'' }}">
                            <option value="">— Pilih Guru —</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id }}" {{ old('guru_id')==$g->id?'selected':'' }}>{{ $g->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        @error('guru_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tahun Ajaran <span class="req">*</span></label>
                        <select name="tahun_ajaran_id" class="{{ $errors->has('tahun_ajaran_id')?'is-invalid':'' }}">
                            <option value="">— Pilih Tahun Ajaran —</option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id')==$ta->id?'selected':'' }}>{{ $ta->tahun }} - {{ ucfirst($ta->semester) }}</option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Jadwal & Durasi
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid-3">
                    <div class="field">
                        <label>Tanggal Ujian <span class="req">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="{{ $errors->has('tanggal')?'is-invalid':'' }}">
                        @error('tanggal')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Jam Mulai</label>
                        <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}" class="{{ $errors->has('jam_mulai')?'is-invalid':'' }}">
                        @error('jam_mulai')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Durasi (menit) <span class="req">*</span></label>
                        <input type="number" name="durasi_menit" value="{{ old('durasi_menit',90) }}" placeholder="cth. 90" min="1" max="480" class="{{ $errors->has('durasi_menit')?'is-invalid':'' }}">
                        @error('durasi_menit')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Nilai KKM</label>
                        <input type="number" name="nilai_kkm" value="{{ old('nilai_kkm',75) }}" placeholder="cth. 75" min="0" max="100" class="{{ $errors->has('nilai_kkm')?'is-invalid':'' }}">
                        @error('nilai_kkm')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Maks. Percobaan</label>
                        <input type="number" name="maks_percobaan" value="{{ old('maks_percobaan',1) }}" min="1" max="10" class="{{ $errors->has('maks_percobaan')?'is-invalid':'' }}">
                        @error('maks_percobaan')<span class="field-error">{{ $message }}</span>@enderror
                        <span class="field-hint">Berapa kali siswa boleh mengulang ujian ini</span>
                    </div>
                    <div class="field" style="grid-column:span 3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" rows="2" placeholder="Informasi tambahan mengenai ujian ini (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Pengaturan & Status
                    <span class="section-label-line"></span>
                </p>
                <div style="display:flex;flex-direction:column;gap:14px">
                    <div class="toggle-row">
                        <label class="toggle-switch">
                            <input type="hidden" name="acak_soal" value="0">
                            <input type="checkbox" name="acak_soal" value="1" {{ old('acak_soal') ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label">Acak urutan soal</span>
                    </div>
                    <div class="toggle-row">
                        <label class="toggle-switch">
                            <input type="hidden" name="acak_pilihan" value="0">
                            <input type="checkbox" name="acak_pilihan" value="1" {{ old('acak_pilihan') ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label">Acak urutan pilihan jawaban</span>
                    </div>
                    <div class="toggle-row">
                        <label class="toggle-switch">
                            <input type="hidden" name="tampilkan_nilai" value="0">
                            <input type="checkbox" name="tampilkan_nilai" value="1" {{ old('tampilkan_nilai',true) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label">Tampilkan nilai setelah ujian selesai</span>
                    </div>
                    <div class="toggle-row">
                        <label class="toggle-switch">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active',true) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label">Ujian aktif dan dapat diakses</span>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.ujian.index') }}" class="btn btn-cancel">Batal</a>
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
    Swal.fire({icon:'error',title:'Terdapat {{ $errors->count() }} Kesalahan',html:`<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`,confirmButtonColor:'#1f63db'});
    @endif

    document.getElementById('ujianForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>