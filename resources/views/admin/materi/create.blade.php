<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand: #1f63db; --brand-h: #3582f0; --brand-700: #1750c0;
        --brand-100: #d9ebff; --brand-50: #eef6ff;
        --surface: #fff; --surface2: #f8fafc; --surface3: #f1f5f9;
        --border: #e2e8f0; --border2: #cbd5e1;
        --text: #0f172a; --text2: #475569; --text3: #94a3b8;
        --red: #dc2626; --red-bg: #fee2e2; --red-border: #fecaca;
        --radius: 10px; --radius-sm: 7px;
    }
    .page { padding: 28px 28px 60px; max-width: 2000px; margin: 0 auto; }
    .breadcrumb { display: flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600; color: var(--text3); margin-bottom: 20px; }
    .breadcrumb a { color: var(--text3); text-decoration: none; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }
    .page-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 20px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s; white-space: nowrap; }
    .btn-back   { padding: 8px 14px; font-size: 13px; background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-back:hover { background: var(--surface3); }
    .btn-cancel { background: var(--surface); color: var(--text2); border: 1px solid var(--border); }
    .btn-cancel:hover { background: var(--surface3); }
    .btn-primary { background: var(--brand); color: #fff; }
    .btn-primary:hover { filter: brightness(.93); }
    .btn-primary:disabled { opacity: .6; cursor: not-allowed; filter: none; }
    .form-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .form-section { padding: 20px 24px 24px; }
    .section-divider { border: none; border-top: 1px solid var(--border); margin: 0; }
    .section-label { display: flex; align-items: center; gap: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); letter-spacing: .07em; text-transform: uppercase; margin-bottom: 16px; }
    .section-label-line { flex: 1; height: 1px; background: var(--border); }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .col-span-2 { grid-column: span 2; }
    .field { display: flex; flex-direction: column; gap: 6px; }
    .field label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2); }
    .field label .req { color: var(--brand); margin-left: 2px; }
    .field input, .field select, .field textarea { height: 38px; padding: 0 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); background: var(--surface2); width: 100%; outline: none; transition: border-color .15s, background .15s; }
    .field textarea { height: auto; padding: 10px 12px; resize: vertical; }
    .field input:focus, .field select:focus, .field textarea:focus { border-color: var(--brand-h); background: #fff; box-shadow: 0 0 0 3px rgba(53,130,240,.1); }
    .field input::placeholder, .field textarea::placeholder { color: var(--text3); }
    .field input.is-invalid, .field select.is-invalid { border-color: var(--red); background: #fff8f8; }
    .field-error { font-size: 12px; color: var(--red); }
    .field-hint  { font-size: 12px; color: var(--text3); }
    .jenis-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
    .jenis-card { border: 2px solid var(--border); border-radius: var(--radius-sm); padding: 14px 12px; cursor: pointer; text-align: center; transition: all .15s; background: var(--surface2); }
    .jenis-card:hover { border-color: var(--brand-h); background: var(--brand-50); }
    .jenis-card.selected { border-color: var(--brand); background: var(--brand-50); }
    .jenis-card input[type="radio"] { display: none; }
    .jenis-icon { margin: 0 auto 8px; width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
    .ji-file { background: var(--brand-50); } .ji-video { background: #faf5ff; } .ji-link { background: #f0fdf4; } .ji-teks { background: #fff7ed; }
    .jenis-lbl { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2); }
    .toggle-row { display: flex; align-items: center; gap: 12px; }
    .toggle-switch { position: relative; display: inline-block; width: 42px; height: 24px; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider { position: absolute; inset: 0; border-radius: 99px; background: var(--border2); cursor: pointer; transition: background .2s; }
    .toggle-slider::before { content: ''; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2); }
    .toggle-switch input:checked + .toggle-slider { background: var(--brand); }
    .toggle-switch input:checked + .toggle-slider::before { transform: translateX(18px); }
    .toggle-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; color: var(--text2); }
    .file-upload-area { border: 2px dashed var(--border2); border-radius: var(--radius-sm); padding: 24px; text-align: center; background: var(--surface2); cursor: pointer; transition: all .15s; position: relative; }
    .file-upload-area:hover { border-color: var(--brand-h); background: var(--brand-50); }
    .file-upload-area input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .fu-icon { margin: 0 auto 8px; }
    .fu-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text2); }
    .fu-sub   { font-size: 12px; color: var(--text3); margin-top: 3px; }
    .fu-info  { font-size: 12px; color: var(--brand-700); font-weight: 600; margin-top: 8px; display: none; }
    .form-footer { display: flex; align-items: center; justify-content: flex-end; gap: 10px; padding: 16px 24px; background: var(--surface2); border-top: 1px solid var(--border); }
    @media (max-width: 680px) { .page { padding: 16px 16px 40px; } .form-grid { grid-template-columns: 1fr; } .col-span-2 { grid-column: span 1; } .jenis-grid { grid-template-columns: 1fr 1fr; } }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.materi.index') }}">Materi Pelajaran</a>
        <span class="sep">›</span>
        <span class="current">Tambah Materi</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Materi Baru</h1>
            <p class="page-sub">Isi semua data dengan benar, lalu klik Simpan Materi</p>
        </div>
        <a href="{{ route('admin.materi.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.materi.store') }}" method="POST" enctype="multipart/form-data" id="materiForm">
        @csrf
        <div class="form-card">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    Informasi Materi
                    <span class="section-label-line"></span>
                </p>
                <div class="form-grid">
                    <div class="field col-span-2">
                        <label>Judul Materi <span class="req">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul') }}" placeholder="cth. Operasi Hitung Aljabar Kelas 8"
                            class="{{ $errors->has('judul') ? 'is-invalid' : '' }}">
                        @error('judul')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

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
                        <label>Mata Pelajaran <span class="req">*</span></label>
                        <select name="mata_pelajaran_id" class="{{ $errors->has('mata_pelajaran_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Mapel —</option>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id }}" {{ old('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                        @error('mata_pelajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label>Kelas <span class="req">*</span></label>
                        <select name="kelas_id" class="{{ $errors->has('kelas_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Kelas —</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                        @error('kelas_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label>Tahun Ajaran <span class="req">*</span></label>
                        <select name="tahun_ajaran_id" class="{{ $errors->has('tahun_ajaran_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Tahun —</option>
                            @foreach($tahunAjaran as $t)
                                <option value="{{ $t->id }}" {{ old('tahun_ajaran_id') == $t->id ? 'selected' : '' }}>{{ $t->tahun }}</option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label>Urutan</label>
                        <input type="number" name="urutan" value="{{ old('urutan', 0) }}" min="0" placeholder="0">
                        @error('urutan')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label>Status Publikasi</label>
                        <div class="toggle-row" style="margin-top:8px">
                            <label class="toggle-switch">
                                <input type="hidden" name="dipublikasikan" value="0">
                                <input type="checkbox" name="dipublikasikan" value="1" id="pubToggle"
                                    {{ old('dipublikasikan') == '1' ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label" id="pubLabel">Draft</span>
                        </div>
                    </div>

                    <div class="field col-span-2">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" rows="4" placeholder="Deskripsi singkat materi pembelajaran..."
                            class="{{ $errors->has('deskripsi') ? 'is-invalid' : '' }}">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Jenis & Konten Materi
                    <span class="section-label-line"></span>
                </p>

                <div class="field" style="margin-bottom:20px">
                    <label>Jenis Materi <span class="req">*</span></label>
                    <div class="jenis-grid" style="margin-top:4px">
                        @foreach($jenisMateri as $j)
                        <label class="jenis-card {{ old('jenis','file') == $j ? 'selected' : '' }}" id="jcard-{{ $j }}">
                            <input type="radio" name="jenis" value="{{ $j }}"
                                {{ old('jenis','file') == $j ? 'checked' : '' }}
                                onchange="onJenisChange('{{ $j }}')">
                            <div class="jenis-icon ji-{{ $j }}">
                                @if($j=='file') <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                @elseif($j=='video') <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                                @elseif($j=='link') <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                                @else <svg width="18" height="18" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                @endif
                            </div>
                            <p class="jenis-lbl">{{ ucfirst($j) }}</p>
                        </label>
                        @endforeach
                    </div>
                    @error('jenis')<span class="field-error" style="display:block;margin-top:4px">{{ $message }}</span>@enderror
                </div>

                <div id="section-file" style="{{ old('jenis','file') == 'file' ? '' : 'display:none' }}">
                    <div class="field">
                        <label>Upload File Materi</label>
                        <div class="file-upload-area">
                            <input type="file" name="path_file" onchange="onFileChange(this,'fileInfo')">
                            <div class="fu-icon"><svg width="28" height="28" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg></div>
                            <p class="fu-title">Klik atau seret file ke sini</p>
                            <p class="fu-sub">PDF, DOC, PPT, XLS, ZIP — maks. 50 MB</p>
                            <p class="fu-info" id="fileInfo"></p>
                        </div>
                        @error('path_file')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div id="section-link" style="{{ in_array(old('jenis'), ['video','link']) ? '' : 'display:none' }}">
                    <div class="field">
                        <label>URL Eksternal <span class="req">*</span></label>
                        <input type="url" name="url_eksternal" value="{{ old('url_eksternal') }}" placeholder="https://..."
                            class="{{ $errors->has('url_eksternal') ? 'is-invalid' : '' }}">
                        @error('url_eksternal')<span class="field-error">{{ $message }}</span>@enderror
                        <span class="field-hint" id="urlHint">Masukkan URL video YouTube / Google Drive / link eksternal</span>
                    </div>
                </div>

                <div id="section-teks" style="{{ old('jenis') == 'teks' ? '' : 'display:none' }}">
                    <div class="field">
                        <label>Konten Teks</label>
                        <textarea name="konten" rows="8" placeholder="Tulis materi pembelajaran di sini...">{{ old('konten') }}</textarea>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Thumbnail
                    <span class="section-label-line"></span>
                </p>
                <div class="field" style="max-width:400px">
                    <label>Gambar Thumbnail</label>
                    <div class="file-upload-area">
                        <input type="file" name="thumbnail" accept="image/*" onchange="onFileChange(this,'thumbInfo')">
                        <div class="fu-icon"><svg width="28" height="28" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
                        <p class="fu-title">Upload thumbnail</p>
                        <p class="fu-sub">JPG / PNG, maks. 2 MB</p>
                        <p class="fu-info" id="thumbInfo"></p>
                    </div>
                    @error('thumbnail')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.materi.index') }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Materi
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if($errors->any())
    Swal.fire({ icon:'error', title:'Terdapat {{ $errors->count() }} Kesalahan', html:`<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`, confirmButtonColor:'#1f63db' });
    @endif

    const pubToggle = document.getElementById('pubToggle');
    const pubLabel  = document.getElementById('pubLabel');
    pubLabel.textContent = pubToggle.checked ? 'Dipublikasikan' : 'Draft';
    pubToggle.addEventListener('change', () => { pubLabel.textContent = pubToggle.checked ? 'Dipublikasikan' : 'Draft'; });

    function onJenisChange(jenis) {
        ['file','link','teks'].forEach(s => {
            const el = document.getElementById('section-' + s);
            if (el) el.style.display = 'none';
        });
        document.querySelectorAll('.jenis-card').forEach(c => c.classList.remove('selected'));
        document.getElementById('jcard-' + jenis).classList.add('selected');
        if (jenis === 'file') document.getElementById('section-file').style.display = '';
        if (jenis === 'link' || jenis === 'video') {
            document.getElementById('section-link').style.display = '';
            document.getElementById('urlHint').textContent = jenis === 'video'
                ? 'Masukkan URL video YouTube / Vimeo'
                : 'Masukkan URL link eksternal';
        }
        if (jenis === 'teks') document.getElementById('section-teks').style.display = '';
    }

    function onFileChange(input, infoId) {
        const file = input.files[0];
        if (!file) return;
        const info = document.getElementById(infoId);
        info.textContent = `${file.name} — ${(file.size/1024/1024).toFixed(2)} MB`;
        info.style.display = 'block';
    }

    document.getElementById('materiForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>