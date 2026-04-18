<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;--radius:10px;--radius-sm:7px;}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand);}
    .breadcrumb .sep{color:var(--border2);}.breadcrumb .current{color:var(--text2);}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}.btn-back:hover{background:var(--surface3);}
    .btn-cancel{background:var(--surface);color:var(--text2);border:1px solid var(--border);}.btn-cancel:hover{background:var(--surface3);}
    .btn-primary{background:var(--brand);color:#fff;}.btn-primary:hover{filter:brightness(.93);}.btn-primary:disabled{opacity:.6;cursor:not-allowed;filter:none;}
    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;background:var(--red-bg);color:var(--red);border:1px solid var(--red-border);}
    .form-layout{display:grid;grid-template-columns:1fr 360px;gap:20px;align-items:start;}
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .form-section{padding:20px 24px 24px;}
    .section-divider{border:none;border-top:1px solid var(--border);margin:0;}
    .section-label{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.07em;text-transform:uppercase;margin-bottom:16px;}
    .section-label-line{flex:1;height:1px;background:var(--border);}
    .field{display:flex;flex-direction:column;gap:6px;margin-bottom:16px;}
    .field:last-child{margin-bottom:0;}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);}
    .field label .req{color:var(--red);margin-left:2px;}
    .field input,.field select,.field textarea{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none;transition:border-color .15s;box-sizing:border-box;}
    .field textarea{height:120px;padding:10px 12px;resize:vertical;}
    .field input:focus,.field select:focus,.field textarea:focus{border-color:var(--brand-h);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1);}
    .field input.is-invalid,.field select.is-invalid,.field textarea.is-invalid{border-color:var(--red);background:#fff8f8;}
    .field-error{font-size:12px;color:var(--red);font-family:'DM Sans',sans-serif;}
    .field-hint{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;}
    .recipient-wrap{border:1px solid var(--border);border-radius:var(--radius-sm);overflow:hidden;background:var(--surface2);}
    .recipient-search{padding:10px 12px;border-bottom:1px solid var(--border);}
    .recipient-search input{width:100%;height:32px;padding:0 10px;border:1px solid var(--border);border-radius:6px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:#fff;outline:none;box-sizing:border-box;}
    .recipient-search input:focus{border-color:var(--brand-h);}
    .recipient-list{max-height:240px;overflow-y:auto;padding:6px 0;}
    .recipient-item{display:flex;align-items:center;gap:10px;padding:8px 14px;cursor:pointer;transition:background .1s;}
    .recipient-item:hover{background:#f0f6ff;}
    .recipient-item input[type="checkbox"]{width:15px;height:15px;accent-color:var(--brand);flex-shrink:0;cursor:pointer;}
    .recipient-name{font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);}
    .recipient-role{font-size:11px;color:var(--text3);margin-top:1px;}
    .recipient-footer{padding:10px 14px;border-top:1px solid var(--border);display:flex;gap:8px;align-items:center;}
    .btn-sel{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--brand);background:none;border:none;cursor:pointer;padding:0;}
    .btn-sel:hover{text-decoration:underline;}
    .sel-count{font-size:12px;color:var(--text3);margin-left:auto;}
    .info-box{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm);padding:14px 16px;}
    .info-box-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--brand);margin-bottom:8px;display:flex;align-items:center;gap:6px;}
    .info-box p{font-size:12.5px;color:#1d4ed8;font-family:'DM Sans',sans-serif;line-height:1.6;}
    .preview-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:20px;}
    .preview-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:14px;}
    .notif-preview{background:var(--surface2);border:1px solid var(--border);border-radius:9px;padding:14px 16px;}
    .notif-preview-head{display:flex;align-items:center;gap:8px;margin-bottom:8px;}
    .notif-icon{width:32px;height:32px;border-radius:8px;background:var(--brand-50);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .notif-preview-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .notif-preview-pesan{font-size:12.5px;color:var(--text2);line-height:1.5;}
    .notif-preview-meta{font-size:11.5px;color:var(--text3);margin-top:8px;}
    .form-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:16px 24px;background:var(--surface2);border-top:1px solid var(--border);}
    @media(max-width:900px){.form-layout{grid-template-columns:1fr;}.page{padding:16px 16px 40px;}}
    @keyframes spin{to{transform:rotate(360deg);}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.notifikasi.index') }}">Notifikasi</a>
        <span class="sep">›</span>
        <span class="current">Kirim Notifikasi</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Kirim Notifikasi</h1>
            <p class="page-sub">Broadcast atau kirim notifikasi in-app ke satu atau banyak pengguna</p>
        </div>
        <a href="{{ route('admin.notifikasi.index') }}" class="btn btn-back">
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

    <form action="{{ route('admin.notifikasi.store') }}" method="POST" id="notifForm">
        @csrf
        <div class="form-layout">
            <div>
                <div class="form-card">
                    <div class="form-section">
                        <p class="section-label">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                            Isi Notifikasi
                            <span class="section-label-line"></span>
                        </p>

                        <div class="field">
                            <label>Judul <span class="req">*</span></label>
                            <input type="text" name="judul" id="inputJudul" value="{{ old('judul') }}"
                                placeholder="cth. Pengingat Tugas Matematika" maxlength="150"
                                class="{{ $errors->has('judul') ? 'is-invalid' : '' }}" oninput="updatePreview()">
                            @error('judul')<span class="field-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="field">
                            <label>Pesan <span class="req">*</span></label>
                            <textarea name="pesan" id="inputPesan" placeholder="Tulis isi pesan notifikasi..."
                                class="{{ $errors->has('pesan') ? 'is-invalid' : '' }}" oninput="updatePreview()">{{ old('pesan') }}</textarea>
                            @error('pesan')<span class="field-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="field">
                            <label>Jenis Notifikasi <span class="req">*</span></label>
                            <select name="jenis" id="inputJenis" class="{{ $errors->has('jenis') ? 'is-invalid' : '' }}" onchange="updatePreview()">
                                <option value="">— Pilih Jenis —</option>
                                @foreach(['info' => 'Info','peringatan' => 'Peringatan','pelanggaran' => 'Pelanggaran','absensi' => 'Absensi','nilai' => 'Nilai','pengumuman' => 'Pengumuman','tugas' => 'Tugas','ujian' => 'Ujian'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('jenis') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('jenis')<span class="field-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="field">
                            <label>URL Tujuan</label>
                            <input type="url" name="url_tujuan" value="{{ old('url_tujuan') }}"
                                placeholder="https://... (opsional)"
                                class="{{ $errors->has('url_tujuan') ? 'is-invalid' : '' }}">
                            <span class="field-hint">Jika diisi, notifikasi bisa diklik untuk membuka halaman ini.</span>
                            @error('url_tujuan')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <hr class="section-divider">

                    <div class="form-section">
                        <p class="section-label">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            Penerima <span style="color:var(--red);margin-left:2px">*</span>
                            <span class="section-label-line"></span>
                        </p>

                        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px">
                            @foreach(['admin' => 'Admin','guru' => 'Guru','siswa' => 'Siswa','orang_tua' => 'Orang Tua'] as $role => $label)
                            <button type="button" class="btn" style="padding:5px 12px;font-size:12px;background:var(--surface2);color:var(--text2);border:1px solid var(--border)" onclick="selectByRole('{{ $role }}')">
                                Semua {{ $label }}
                            </button>
                            @endforeach
                            <button type="button" class="btn" style="padding:5px 12px;font-size:12px;background:#eff6ff;color:var(--brand);border:1px solid var(--brand-100)" onclick="selectAll()">Semua Pengguna</button>
                        </div>

                        <div class="recipient-wrap" style="{{ $errors->has('pengguna_ids') ? 'border-color:#dc2626' : '' }}">
                            <div class="recipient-search">
                                <input type="text" id="recipientSearch" placeholder="Cari nama pengguna..." oninput="filterRecipients(this.value)">
                            </div>
                            <div class="recipient-list" id="recipientList">
                                @foreach($pengguna as $p)
                                <label class="recipient-item" data-name="{{ strtolower($p->name) }}" data-role="{{ $p->role ?? '' }}">
                                    <input type="checkbox" name="pengguna_ids[]" value="{{ $p->id }}"
                                        {{ is_array(old('pengguna_ids')) && in_array($p->id, old('pengguna_ids')) ? 'checked' : '' }}
                                        onchange="updateSelCount()">
                                    <div>
                                        <p class="recipient-name">{{ $p->name }}</p>
                                        <p class="recipient-role">{{ ucfirst(str_replace('_', ' ', $p->role ?? '')) }} · {{ $p->email }}</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            <div class="recipient-footer">
                                <button type="button" class="btn-sel" onclick="selectAll()">Pilih Semua</button>
                                <button type="button" class="btn-sel" style="color:#dc2626" onclick="deselectAll()">Hapus Semua</button>
                                <span class="sel-count" id="selCountCreate">0 dipilih</span>
                            </div>
                        </div>
                        @error('pengguna_ids')<span class="field-error" style="margin-top:4px;display:block">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-footer">
                        <a href="{{ route('admin.notifikasi.index') }}" class="btn btn-cancel">Batal</a>
                        <button type="button" class="btn btn-primary" id="btnSubmit" onclick="confirmSend()">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                            Kirim Notifikasi
                        </button>
                    </div>
                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:16px">
                <div class="preview-card">
                    <p class="preview-title">Preview Notifikasi</p>
                    <div class="notif-preview">
                        <div class="notif-preview-head">
                            <div class="notif-icon">
                                <svg width="16" height="16" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                            </div>
                            <p class="notif-preview-judul" id="previewJudul" style="color:var(--text3)">Judul notifikasi...</p>
                        </div>
                        <p class="notif-preview-pesan" id="previewPesan" style="color:var(--text3)">Isi pesan akan muncul di sini.</p>
                        <p class="notif-preview-meta">Jenis: <span id="previewJenis" style="font-weight:600">-</span> · Baru saja</p>
                    </div>
                </div>

                <div class="info-box">
                    <p class="info-box-title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Cara Kerja
                    </p>
                    <p>Notifikasi akan masuk ke in-app notification setiap penerima yang dipilih. Gunakan <strong>Pilih Semua</strong> untuk broadcast ke seluruh pengguna, atau filter berdasarkan role.</p>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if($errors->any())
    Swal.fire({icon:'error',title:'Terdapat {{ $errors->count() }} Kesalahan',html:`<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`,confirmButtonColor:'#1f63db'});
    @endif

    function updatePreview() {
        const j = document.getElementById('inputJudul').value;
        const p = document.getElementById('inputPesan').value;
        const jenis = document.getElementById('inputJenis').value;
        const pj = document.getElementById('previewJudul');
        const pp = document.getElementById('previewPesan');
        pj.textContent = j || 'Judul notifikasi...';
        pj.style.color = j ? 'var(--text)' : 'var(--text3)';
        pp.textContent = p || 'Isi pesan akan muncul di sini.';
        pp.style.color = p ? 'var(--text2)' : 'var(--text3)';
        document.getElementById('previewJenis').textContent = jenis || '-';
    }

    function updateSelCount() {
        const c = document.querySelectorAll('input[name="pengguna_ids[]"]:checked').length;
        document.getElementById('selCountCreate').textContent = c + ' dipilih';
    }

    function selectAll() {
        document.querySelectorAll('input[name="pengguna_ids[]"]').forEach(el => el.checked = true);
        updateSelCount();
    }

    function deselectAll() {
        document.querySelectorAll('input[name="pengguna_ids[]"]').forEach(el => el.checked = false);
        updateSelCount();
    }

    function selectByRole(role) {
        deselectAll();
        document.querySelectorAll('.recipient-item').forEach(item => {
            if (item.dataset.role === role) item.querySelector('input').checked = true;
        });
        updateSelCount();
    }

    function filterRecipients(q) {
        document.querySelectorAll('.recipient-item').forEach(item => {
            item.style.display = item.dataset.name.includes(q.toLowerCase()) ? 'flex' : 'none';
        });
    }

    function confirmSend() {
        const cnt = document.querySelectorAll('input[name="pengguna_ids[]"]:checked').length;
        const judul = document.getElementById('inputJudul').value;
        if (!judul.trim()) {
            Swal.fire({icon:'warning',title:'Judul Kosong',text:'Isi judul notifikasi terlebih dahulu.',confirmButtonColor:'#1f63db'});
            return;
        }
        if (cnt === 0) {
            Swal.fire({icon:'warning',title:'Penerima Belum Dipilih',text:'Pilih minimal satu penerima.',confirmButtonColor:'#1f63db'});
            return;
        }
        Swal.fire({
            title:'Kirim Notifikasi?',
            html:`Notifikasi <strong>"${judul}"</strong> akan dikirim ke <strong>${cnt} pengguna</strong>.`,
            icon:'question',showCancelButton:true,
            confirmButtonColor:'#1f63db',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Kirim!',cancelButtonText:'Batal',
        }).then(r => {
            if (r.isConfirmed) {
                const btn = document.getElementById('btnSubmit');
                btn.disabled = true;
                btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Mengirim…`;
                document.getElementById('notifForm').submit();
            }
        });
    }

    updateSelCount();
</script>
</x-app-layout>