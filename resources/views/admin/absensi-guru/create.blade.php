<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--red:#dc2626;--radius:10px;--radius-sm:7px}
    .page{padding:28px 28px 60px;max-width:860px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none;transition:color .15s}.breadcrumb a:hover{color:var(--brand)}.breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn-back{padding:8px 14px;font-size:13px;background:var(--surface2);color:var(--text2);border:1px solid var(--border)}.btn-back:hover{background:var(--surface3)}
    .btn-cancel{background:var(--surface);color:var(--text2);border:1px solid var(--border)}.btn-cancel:hover{background:var(--surface3)}
    .btn-primary{background:var(--brand);color:#fff}.btn-primary:hover{filter:brightness(.93)}.btn-primary:disabled{opacity:.6;cursor:not-allowed;filter:none}
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .form-section{padding:20px 24px 24px}
    .section-divider{border:none;border-top:1px solid var(--border);margin:0}
    .section-label{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.07em;text-transform:uppercase;margin-bottom:16px}
    .section-label-line{flex:1;height:1px;background:var(--border)}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    .col-span-2{grid-column:span 2}
    .field{display:flex;flex-direction:column;gap:6px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
    .field label .req{color:var(--brand);margin-left:2px}
    .field input,.field select,.field textarea{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none;transition:border-color .15s,background .15s;box-sizing:border-box}
    .field textarea{height:auto;padding:10px 12px;resize:vertical}
    .field input[type="file"]{height:auto;padding:8px 12px}
    .field input:focus,.field select:focus,.field textarea:focus{border-color:var(--brand-h);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1)}
    .field input::placeholder,.field textarea::placeholder{color:var(--text3)}
    .field input.is-invalid,.field select.is-invalid,.field textarea.is-invalid{border-color:var(--red);background:#fff8f8}
    .field-error{font-size:12px;color:var(--red);font-family:'DM Sans',sans-serif;margin-top:-2px}
    .field-hint{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;margin-top:-2px}
    .form-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border)}
    @keyframes spin{to{transform:rotate(360deg)}}
    @media(max-width:680px){.page{padding:16px 16px 40px}.form-grid{grid-template-columns:1fr}.col-span-2{grid-column:span 1}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a><span class="sep">›</span>
        <a href="{{ route('admin.absensi-guru.index') }}">Absensi Guru</a><span class="sep">›</span>
        <span class="current">Tambah</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Absensi Guru</h1>
            <p class="page-sub">Kolom bertanda <span style="color:var(--brand)">*</span> wajib diisi.</p>
        </div>
        <a href="{{ route('admin.absensi-guru.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.absensi-guru.store') }}" method="POST" enctype="multipart/form-data" id="absenForm">
        @csrf
        <div class="form-card">
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Informasi Absensi
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Guru <span class="req">*</span></label>
                        <select name="guru_id" class="{{ $errors->has('guru_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Guru —</option>
                            @foreach($guruList as $g)
                                <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        @error('guru_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tanggal <span class="req">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', today()->format('Y-m-d')) }}"
                            class="{{ $errors->has('tanggal') ? 'is-invalid' : '' }}">
                        @error('tanggal')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Status Kehadiran <span class="req">*</span></label>
                        <select name="status" class="{{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Status —</option>
                            @foreach($statusList as $s)
                                <option value="{{ $s }}" {{ old('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        @error('status')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Metode</label>
                        <select name="metode" class="{{ $errors->has('metode') ? 'is-invalid' : '' }}">
                            @foreach($metodeList as $m)
                                <option value="{{ $m }}" {{ old('metode','manual') == $m ? 'selected' : '' }}>{{ ucfirst($m) }}</option>
                            @endforeach
                        </select>
                        @error('metode')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Jam Masuk</label>
                        <input type="time" name="jam_masuk" value="{{ old('jam_masuk') }}"
                            class="{{ $errors->has('jam_masuk') ? 'is-invalid' : '' }}">
                        @error('jam_masuk')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Jam Keluar</label>
                        <input type="time" name="jam_keluar" value="{{ old('jam_keluar') }}"
                            class="{{ $errors->has('jam_keluar') ? 'is-invalid' : '' }}">
                        @error('jam_keluar')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Jadwal Piket</label>
                        <select name="jadwal_piket_id" class="{{ $errors->has('jadwal_piket_id') ? 'is-invalid' : '' }}">
                            <option value="">— Tidak Ada —</option>
                            @foreach($jadwalList as $j)
                                <option value="{{ $j->id }}" {{ old('jadwal_piket_id') == $j->id ? 'selected' : '' }}>
                                    {{ ucfirst($j->hari) }} – {{ $j->guru->nama_lengkap ?? '—' }}
                                </option>
                            @endforeach
                        </select>
                        @error('jadwal_piket_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Surat Izin / Dokumen</label>
                        <input type="file" name="path_surat_izin" accept=".pdf,.jpg,.jpeg,.png"
                            class="{{ $errors->has('path_surat_izin') ? 'is-invalid' : '' }}">
                        <span class="field-hint">PDF/JPG/PNG maks. 2MB (opsional)</span>
                        @error('path_surat_izin')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field col-span-2">
                        <label>Keterangan</label>
                        <textarea name="keterangan" rows="3" placeholder="Catatan tambahan (opsional)..."
                            class="{{ $errors->has('keterangan') ? 'is-invalid' : '' }}">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="form-footer">
                <a href="{{ route('admin.absensi-guru.index') }}" class="btn btn-cancel">Batal</a>
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
    @if(session('error'))Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});@endif
    @if($errors->any())
    Swal.fire({icon:'error',title:'Terdapat {{ $errors->count() }} Kesalahan',
        html:`<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`,
        confirmButtonColor:'#1f63db'});
    @endif
    document.getElementById('absenForm').addEventListener('submit',function(){
        const btn=document.getElementById('btnSubmit');btn.disabled=true;
        btn.innerHTML=`<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>