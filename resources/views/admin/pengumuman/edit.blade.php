<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;--radius:10px;--radius-sm:7px;}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand);}
    .breadcrumb .sep{color:var(--border);}.breadcrumb .current{color:var(--text2);}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}.btn-back:hover{background:var(--surface3);}
    .btn-cancel{background:var(--surface);color:var(--text2);border:1px solid var(--border);}
    .btn-primary{background:var(--brand);color:#fff;}.btn-primary:hover{filter:brightness(.93);}.btn-primary:disabled{opacity:.6;cursor:not-allowed;filter:none;}
    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;background:var(--red-bg);color:var(--red);border:1px solid var(--red-border);}
    .warning-alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;}
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
    .field input,.field select,.field textarea{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none;transition:border-color .15s;box-sizing:border-box;}
    .field textarea{height:auto;padding:10px 12px;resize:vertical;}
    .field input:focus,.field select:focus,.field textarea:focus{border-color:var(--brand-h);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1);}
    .field input.is-invalid,.field select.is-invalid,.field textarea.is-invalid{border-color:var(--red);background:#fff8f8;}
    .field-error{font-size:12px;color:var(--red);font-family:'DM Sans',sans-serif;}
    .field-hint{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;}
    .isi-textarea{min-height:240px;font-size:14px;line-height:1.7;}
    .current-lampiran{display:flex;align-items:center;gap:10px;padding:10px 14px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);margin-bottom:8px;}
    .current-lampiran-icon{width:32px;height:32px;background:#fff;border:1px solid var(--border);border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .file-upload-wrap{position:relative;display:inline-block;width:100%;}
    .file-upload-wrap input[type="file"]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
    .file-upload-box{display:flex;align-items:center;gap:10px;padding:10px 14px;border:1.5px dashed var(--border2);border-radius:var(--radius-sm);background:var(--surface2);cursor:pointer;transition:border-color .15s;}
    .file-upload-box:hover{border-color:var(--brand-h);background:var(--brand-50);}
    .file-upload-icon{width:36px;height:36px;border-radius:8px;background:var(--surface3);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .file-upload-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text2);}
    .file-upload-sub{font-size:12px;color:var(--text3);margin-top:1px;}
    .file-info{display:none;align-items:center;gap:8px;margin-top:8px;}
    .toggle-row{display:flex;align-items:center;gap:12px;margin-top:6px;}
    .toggle-switch{position:relative;display:inline-block;width:42px;height:24px;}
    .toggle-switch input{opacity:0;width:0;height:0;}
    .toggle-slider{position:absolute;inset:0;border-radius:99px;background:var(--border2);cursor:pointer;transition:background .2s;}
    .toggle-slider::before{content:'';position:absolute;width:18px;height:18px;left:3px;top:3px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.2);}
    .toggle-switch input:checked + .toggle-slider{background:#a16207;}
    .toggle-switch input:checked + .toggle-slider::before{transform:translateX(18px);}
    .form-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border);}
    @media(max-width:680px){.page{padding:16px;}.form-grid{grid-template-columns:1fr;}.col-span-2{grid-column:span 1;}}
    @keyframes spin{to{transform:rotate(360deg);}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.pengumuman.index') }}">Pengumuman</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.pengumuman.show', $pengumuman->id) }}">Detail</a>
        <span class="sep">›</span>
        <span class="current">Edit</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Pengumuman</h1>
            <p class="page-sub">{{ Str::limit($pengumuman->judul, 60) }}</p>
        </div>
        <a href="{{ route('admin.pengumuman.show', $pengumuman->id) }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    @if($pengumuman->dipublikasikan_pada)
    <div class="warning-alert">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        <span>Pengumuman ini sudah dipublikasikan. Perubahan akan langsung terlihat oleh penerima.</span>
    </div>
    @endif

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

    <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data" id="formEdit">
        @csrf @method('PUT')
        <div class="form-card">
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Konten Pengumuman
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field col-span-2">
                        <label>Judul Pengumuman <span class="req">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul', $pengumuman->judul) }}"
                            placeholder="cth. Libur Hari Raya Idul Fitri"
                            class="{{ $errors->has('judul') ? 'is-invalid' : '' }}">
                        @error('judul')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field col-span-2">
                        <label>Isi Pengumuman <span class="req">*</span></label>
                        <textarea name="isi" class="isi-textarea {{ $errors->has('isi') ? 'is-invalid' : '' }}">{{ old('isi', $pengumuman->isi) }}</textarea>
                        @error('isi')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                    Pengaturan Distribusi
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field">
                        <label>Target Penerima <span class="req">*</span></label>
                        <select name="target_role" class="{{ $errors->has('target_role') ? 'is-invalid' : '' }}">
                            @foreach(['semua' => 'Semua Pengguna','guru' => 'Guru','siswa' => 'Siswa','orang_tua' => 'Orang Tua','guru_piket' => 'Guru Piket'] as $val => $label)
                                <option value="{{ $val }}" {{ old('target_role', $pengumuman->target_role) == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('target_role')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tanggal Kadaluarsa</label>
                        <input type="datetime-local" name="kadaluarsa_pada"
                            value="{{ old('kadaluarsa_pada', $pengumuman->kadaluarsa_pada ? \Carbon\Carbon::parse($pengumuman->kadaluarsa_pada)->format('Y-m-d\TH:i') : '') }}"
                            class="{{ $errors->has('kadaluarsa_pada') ? 'is-invalid' : '' }}">
                        <span class="field-hint">Kosongkan untuk tidak ada kadaluarsa.</span>
                        @error('kadaluarsa_pada')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Status Publikasi</label>
                        <div style="padding:10px 0">
                            @if($pengumuman->dipublikasikan_pada)
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:#15803d">
                                    ✓ Dipublikasikan pada {{ $pengumuman->dipublikasikan_pada->format('d M Y, H:i') }}
                                </span>
                            @else
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text3)">Draft — belum dipublikasikan</span>
                            @endif
                        </div>
                    </div>
                    <div class="field">
                        <label>Pin Pengumuman</label>
                        <div class="toggle-row">
                            <label class="toggle-switch">
                                <input type="checkbox" name="dipinned" value="1" id="pinnedToggle"
                                    {{ old('dipinned', $pengumuman->dipinned) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label" id="pinnedLabel">{{ $pengumuman->dipinned ? 'Dipinned' : 'Tidak Dipinned' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                    Lampiran
                    <span class="section-label-line"></span>
                </p>
                <div style="max-width:520px">
                    @if($pengumuman->path_lampiran)
                    <div class="current-lampiran">
                        <div class="current-lampiran-icon">
                            <svg width="16" height="16" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                        </div>
                        <div>
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text2)">Lampiran saat ini tersedia</p>
                            <a href="{{ asset('storage/'.$pengumuman->path_lampiran) }}" target="_blank" style="font-size:12px;color:var(--brand);text-decoration:none">Buka lampiran →</a>
                        </div>
                    </div>
                    <p class="field-hint" style="margin-bottom:8px">Upload file baru untuk mengganti lampiran yang ada.</p>
                    @endif
                    <div class="field">
                        <div class="file-upload-wrap">
                            <input type="file" name="lampiran" id="lampiranInput" accept=".pdf,.doc,.docx,.jpg,.png">
                            <div class="file-upload-box">
                                <div class="file-upload-icon">
                                    <svg width="16" height="16" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                </div>
                                <div>
                                    <p class="file-upload-text">{{ $pengumuman->path_lampiran ? 'Ganti file lampiran' : 'Klik untuk pilih file lampiran' }}</p>
                                    <p class="file-upload-sub">PDF, DOC, DOCX, JPG, PNG — maks. 5 MB</p>
                                </div>
                            </div>
                        </div>
                        <div class="file-info" id="fileInfo">
                            <span id="fileName" style="font-size:12.5px;color:var(--text2);font-family:'DM Sans',sans-serif"></span>
                            <span id="fileSize" style="font-size:11.5px;color:var(--text3);background:var(--surface3);border-radius:4px;padding:1px 6px"></span>
                            <button type="button" onclick="removeLampiran()" style="background:none;border:none;cursor:pointer;color:#dc2626;font-size:11.5px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;padding:2px 6px;border-radius:4px">✕ Hapus</button>
                        </div>
                        @error('lampiran')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.pengumuman.show', $pengumuman->id) }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
    @endif
    @if($errors->any())
    Swal.fire({icon:'error',title:'Terdapat {{ $errors->count() }} Kesalahan',html:`<ul style="text-align:left;padding-left:16px;margin:0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`,confirmButtonColor:'#1f63db'});
    @endif

    @if($pengumuman->dipublikasikan_pada)
    window.addEventListener('DOMContentLoaded', () => {
        Swal.fire({icon:'info',title:'Pengumuman Sudah Dipublikasikan',text:'Perubahan yang Anda simpan akan langsung terlihat oleh semua penerima.',confirmButtonColor:'#1f63db',confirmButtonText:'Mengerti, Lanjutkan'});
    });
    @endif

    document.getElementById('pinnedToggle').addEventListener('change', function() {
        document.getElementById('pinnedLabel').textContent = this.checked ? 'Dipinned' : 'Tidak Dipinned';
    });

    document.getElementById('lampiranInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        if (file.size > 5 * 1024 * 1024) {
            Swal.fire({icon:'warning',title:'File Terlalu Besar',text:'Ukuran file melebihi 5 MB.',confirmButtonColor:'#1f63db'});
            this.value = ''; return;
        }
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileSize').textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
        document.getElementById('fileInfo').style.display = 'flex';
    });

    function removeLampiran() {
        document.getElementById('lampiranInput').value = '';
        document.getElementById('fileInfo').style.display = 'none';
    }

    document.getElementById('formEdit').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>