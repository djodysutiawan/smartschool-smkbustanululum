<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db;--brand-h:#3582f0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;--radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand)}
    .breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn-back{padding:8px 14px;font-size:13px;background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-back:hover{background:var(--surface3)}
    .btn-cancel{background:var(--surface);color:var(--text2);border:1px solid var(--border)}
    .btn-cancel:hover{background:var(--surface3)}
    .btn-primary{background:var(--brand);color:#fff}
    .btn-primary:hover{filter:brightness(.93)}
    .btn-primary:disabled{opacity:.6;cursor:not-allowed;filter:none}
    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .form-section{padding:20px 24px 24px}
    .section-divider{border:none;border-top:1px solid var(--border);margin:0}
    .section-label{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.07em;text-transform:uppercase;margin-bottom:16px}
    .section-label-line{flex:1;height:1px;background:var(--border)}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    .form-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}
    .col-span-2{grid-column:span 2}.col-span-3{grid-column:span 3}
    .field{display:flex;flex-direction:column;gap:6px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
    .field label .req{color:var(--brand);margin-left:2px}
    .field input,.field select,.field textarea{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none;transition:border-color .15s,background .15s}
    .field textarea{height:auto;padding:10px 12px;resize:vertical}
    .field input:focus,.field select:focus,.field textarea:focus{border-color:var(--brand-h);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1)}
    .field input::placeholder,.field textarea::placeholder{color:var(--text3)}
    .field input.is-invalid,.field select.is-invalid,.field textarea.is-invalid{border-color:var(--red);background:#fff8f8}
    .field-error{font-size:12px;color:var(--red);font-family:'DM Sans',sans-serif;margin-top:-2px}
    .field-hint{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;margin-top:-2px}
    .info-banner{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:16px;display:flex;align-items:center;gap:10px;font-size:13px;color:var(--text2)}
    .info-banner strong{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text)}
    .upload-wrap{border:1.5px dashed var(--border2);border-radius:var(--radius-sm);padding:16px;background:var(--surface2);position:relative}
    .upload-inner{display:flex;align-items:center;gap:12px}
    .upload-icon{width:40px;height:40px;background:var(--surface3);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .upload-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);margin-bottom:3px}
    .upload-hint{font-size:12px;color:var(--text3)}
    .upload-input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
    .upload-filename{font-size:12.5px;color:var(--brand);font-family:'DM Sans',sans-serif;margin-top:6px;display:none}
    .existing-file{display:flex;align-items:center;gap:8px;padding:8px 12px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);margin-top:8px}
    .existing-file a{font-size:12.5px;color:var(--brand);font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;text-decoration:none}
    .existing-file a:hover{text-decoration:underline}
    .form-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border)}
    @keyframes spin{to{transform:rotate(360deg)}}
    @media(max-width:680px){.page{padding:16px 16px 40px}.form-grid,.form-grid-3{grid-template-columns:1fr}.col-span-2,.col-span-3{grid-column:span 1}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.absensi.index') }}">Data Absensi</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.absensi.show', $absensi->id) }}">Detail</a>
        <span class="sep">›</span>
        <span class="current">Edit</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Data Absensi</h1>
            <p class="page-sub">Perbarui status kehadiran — {{ $absensi->siswa->nama_lengkap ?? '—' }}, {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}</p>
        </div>
        <a href="{{ route('admin.absensi.show', $absensi->id) }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <div class="info-banner">
        <svg width="16" height="16" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Siswa: <strong>{{ $absensi->siswa->nama_lengkap ?? '—' }}</strong> &nbsp;|&nbsp;
        Kelas: <strong>{{ $absensi->kelas->nama_kelas ?? '—' }}</strong> &nbsp;|&nbsp;
        Tanggal: <strong>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d F Y') }}</strong>
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

    <form action="{{ route('admin.absensi.update', $absensi->id) }}" method="POST" enctype="multipart/form-data" id="absensiForm">
        @csrf @method('PUT')
        <div class="form-card">
            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Status & Waktu Kehadiran
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid-3">
                    <div class="field">
                        <label>Status Kehadiran <span class="req">*</span></label>
                        <select name="status" id="statusSelect" class="{{ $errors->has('status') ? 'is-invalid' : '' }}" onchange="handleStatus(this.value)">
                            @foreach($statusList as $st)
                                <option value="{{ $st }}" {{ old('status', $absensi->status) == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                            @endforeach
                        </select>
                        @error('status')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Metode</label>
                        {{--
                            FIX: loop dari $metodeList (['manual','qr']) yang dikirim controller.
                            Tidak lagi hardcode 'qr_code' yang tidak ada di enum.
                        --}}
                        <select name="metode">
                            @foreach($metodeList as $m)
                                <option value="{{ $m }}" {{ old('metode', $absensi->metode) == $m ? 'selected' : '' }}>
                                    {{ $m === 'qr' ? 'QR Code' : ucfirst($m) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field"></div>
                    <div class="field">
                        <label>Jam Masuk</label>
                        <input type="time" name="jam_masuk"
                               value="{{ old('jam_masuk', $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') : '') }}"
                               class="{{ $errors->has('jam_masuk') ? 'is-invalid' : '' }}">
                        @error('jam_masuk')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Jam Keluar</label>
                        <input type="time" name="jam_keluar"
                               value="{{ old('jam_keluar', $absensi->jam_keluar ? \Carbon\Carbon::parse($absensi->jam_keluar)->format('H:i') : '') }}"
                               class="{{ $errors->has('jam_keluar') ? 'is-invalid' : '' }}">
                        @error('jam_keluar')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field"></div>
                    <div class="field col-span-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" rows="2">{{ old('keterangan', $absensi->keterangan) }}</textarea>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            {{--
                SURAT IZIN — FIX: tampil/sembunyikan berdasarkan status.
                Di view lama section ini selalu tampil tanpa kondisi.
            --}}
            <div class="form-section" id="suratIzinSection">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
                    Surat Keterangan
                    <span class="section-label-line"></span>
                </p>
                <div class="field" style="max-width:500px">
                    <label>Upload Surat Baru (opsional)</label>
                    @if($absensi->path_surat_izin)
                    <div class="existing-file">
                        <svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
                        <span style="font-size:12.5px;color:var(--text3);font-family:'DM Sans',sans-serif">File saat ini:</span>
                        <a href="{{ asset('storage/'.$absensi->path_surat_izin) }}" target="_blank">Lihat file</a>
                    </div>
                    @endif
                    <div class="upload-wrap" style="margin-top:8px">
                        <div class="upload-inner">
                            <div class="upload-icon">
                                <svg width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            </div>
                            <div>
                                <p class="upload-label">Pilih file baru</p>
                                <p class="upload-hint">PDF, JPG, PNG — maks. 2 MB</p>
                            </div>
                        </div>
                        <input type="file" name="path_surat_izin" class="upload-input" accept=".pdf,.jpg,.jpeg,.png"
                               onchange="document.getElementById('suratFilename').textContent=this.files[0]?.name||'';document.getElementById('suratFilename').style.display=this.files[0]?'block':'none'">
                        <p id="suratFilename" class="upload-filename"></p>
                    </div>
                    @error('path_surat_izin')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.absensi.show', $absensi->id) }}" class="btn btn-cancel">Batal</a>
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
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif
    @if($errors->any())
    Swal.fire({
        icon:'error', title:'Terdapat {{ $errors->count() }} Kesalahan',
        html:`<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`,
        confirmButtonColor:'#1f63db',
    });
    @endif

    /**
     * FIX: handleStatus juga ada di halaman edit.
     * Sebelumnya section surat izin selalu tampil tanpa kondisi status.
     * Sekarang: tampil hanya jika status 'izin' atau 'sakit'.
     */
    function handleStatus(val) {
        const sec = document.getElementById('suratIzinSection');
        sec.style.display = (val === 'izin' || val === 'sakit') ? 'block' : 'none';
    }
    // Jalankan saat halaman load dengan nilai yang sudah tersimpan
    handleStatus('{{ old("status", $absensi->status) }}');

    document.getElementById('absensiForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>