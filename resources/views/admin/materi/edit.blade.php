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
    .field label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2); display: flex; align-items: center; gap: 6px; }
    .field label .req { color: var(--brand); margin-left: 2px; }
    .field input, .field select, .field textarea { height: 38px; padding: 0 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); background: var(--surface2); width: 100%; outline: none; transition: border-color .15s, background .15s; }
    .field textarea { height: auto; padding: 10px 12px; resize: vertical; }
    .field input:focus, .field select:focus, .field textarea:focus { border-color: var(--brand-h); background: #fff; box-shadow: 0 0 0 3px rgba(53,130,240,.1); }
    .field input::placeholder, .field textarea::placeholder { color: var(--text3); }
    .field input.is-invalid, .field select.is-invalid { border-color: var(--red); background: #fff8f8; }
    .field select:disabled { opacity: .55; cursor: not-allowed; }
    .field-error { font-size: 12px; color: var(--red); }
    .field-hint  { font-size: 12px; color: var(--text3); }

    /* Cascade */
    .select-wrap { position: relative; }
    .select-wrap .spin-icon { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); display: none; pointer-events: none; }
    .select-wrap.loading .spin-icon { display: block; }
    .select-wrap.loading select { padding-right: 36px; }
    .cascade-hint { font-size: 11.5px; color: var(--brand); font-weight: 600; display: none; align-items: center; gap: 4px; }
    .cascade-hint.show { display: flex; }
    .cascade-badge { display: inline-flex; align-items: center; gap: 4px; background: var(--brand-50); border: 1px solid var(--brand-100); border-radius: 99px; padding: 2px 9px; font-size: 11px; font-weight: 700; color: var(--brand-700); font-family: 'Plus Jakarta Sans', sans-serif; }

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
    .fu-sub { font-size: 12px; color: var(--text3); margin-top: 3px; }
    .existing-file { display: inline-flex; align-items: center; gap: 8px; background: var(--surface3); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 8px 12px; font-size: 12.5px; color: var(--text2); font-family: 'DM Sans', sans-serif; margin-bottom: 8px; }
    .existing-thumb { width: 60px; height: 60px; border-radius: 6px; object-fit: cover; border: 1px solid var(--border); }
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
        <a href="{{ route('admin.materi.show', $materi->id) }}">{{ Str::limit($materi->judul, 30) }}</a>
        <span class="sep">›</span>
        <span class="current">Edit</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Materi</h1>
            <p class="page-sub">{{ $materi->judul }}</p>
        </div>
        <a href="{{ route('admin.materi.show', $materi->id) }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.materi.update', $materi->id) }}" method="POST" enctype="multipart/form-data" id="materiForm">
        @csrf @method('PUT')
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
                        <input type="text" name="judul" value="{{ old('judul', $materi->judul) }}"
                            class="{{ $errors->has('judul') ? 'is-invalid' : '' }}">
                        @error('judul')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- ① GURU --}}
                    <div class="field">
                        <label>Guru <span class="req">*</span></label>
                        <div class="select-wrap" id="wrapGuru">
                            {{-- Bug fix: simpan initial guru_id di data-* untuk deteksi perubahan guru --}}
                            <select name="guru_id" id="selGuru"
                                class="{{ $errors->has('guru_id') ? 'is-invalid' : '' }}"
                                data-initial="{{ old('guru_id', $materi->guru_id) }}"
                                onchange="onGuruChange(this.value)">
                                <option value="">— Pilih Guru —</option>
                                @foreach($guruList as $g)
                                    <option value="{{ $g->id }}"
                                        {{ old('guru_id', $materi->guru_id) == $g->id ? 'selected' : '' }}>
                                        {{ $g->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            <svg class="spin-icon" width="14" height="14" fill="none" stroke="#1f63db" stroke-width="2.5"
                                viewBox="0 0 24 24" style="animation:spin .6s linear infinite">
                                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                            </svg>
                        </div>
                        @error('guru_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- ② MATA PELAJARAN — pre-filled dari server --}}
                    <div class="field">
                        <label>
                            Mata Pelajaran <span class="req">*</span>
                            <span class="cascade-badge" id="mapelBadge">Auto</span>
                        </label>
                        <div class="select-wrap" id="wrapMapel">
                            <select name="mata_pelajaran_id" id="selMapel"
                                class="{{ $errors->has('mata_pelajaran_id') ? 'is-invalid' : '' }}">
                                <option value="">— Pilih Mapel —</option>
                                @foreach($mapelGuru as $m)
                                    <option value="{{ $m->id }}"
                                        {{ old('mata_pelajaran_id', $materi->mata_pelajaran_id) == $m->id ? 'selected' : '' }}>
                                        {{ $m->nama_mapel }}
                                    </option>
                                @endforeach
                            </select>
                            <svg class="spin-icon" width="14" height="14" fill="none" stroke="#1f63db" stroke-width="2.5"
                                viewBox="0 0 24 24" style="animation:spin .6s linear infinite">
                                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                            </svg>
                        </div>
                        @error('mata_pelajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                        <span class="cascade-hint show" id="mapelHint">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Menampilkan mapel yang diampu guru ini
                        </span>
                    </div>

                    {{-- ③ KELAS — pre-filled dari server --}}
                    <div class="field">
                        <label>
                            Kelas <span class="req">*</span>
                            <span class="cascade-badge" id="kelasBadge">Auto</span>
                        </label>
                        <div class="select-wrap" id="wrapKelas">
                            <select name="kelas_id" id="selKelas"
                                class="{{ $errors->has('kelas_id') ? 'is-invalid' : '' }}">
                                <option value="">— Pilih Kelas —</option>
                                @foreach($kelasGuru as $k)
                                    <option value="{{ $k->id }}"
                                        {{ old('kelas_id', $materi->kelas_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                            <svg class="spin-icon" width="14" height="14" fill="none" stroke="#1f63db" stroke-width="2.5"
                                viewBox="0 0 24 24" style="animation:spin .6s linear infinite">
                                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                            </svg>
                        </div>
                        @error('kelas_id')<span class="field-error">{{ $message }}</span>@enderror
                        <span class="cascade-hint show" id="kelasHint">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Menampilkan kelas yang diajar guru ini
                        </span>
                    </div>

                    {{-- ④ TAHUN AJARAN --}}
                    <div class="field">
                        <label>Tahun Ajaran <span class="req">*</span></label>
                        <select name="tahun_ajaran_id" class="{{ $errors->has('tahun_ajaran_id') ? 'is-invalid' : '' }}">
                            <option value="">— Pilih Tahun —</option>
                            @foreach($tahunAjaran as $t)
                                <option value="{{ $t->id }}"
                                    {{ old('tahun_ajaran_id', $materi->tahun_ajaran_id) == $t->id ? 'selected' : '' }}>
                                    {{ $t->label }}{{ $t->isAktif() ? ' ✓' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label>Urutan</label>
                        <input type="number" name="urutan" value="{{ old('urutan', $materi->urutan ?? 0) }}" min="0">
                        @error('urutan')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Bug fix: hidden field dipublikasikan=0 harus SEBELUM checkbox agar
                         nilai checkbox (1) menimpa hidden jika di-check --}}
                    <div class="field">
                        <label>Status Publikasi</label>
                        <div class="toggle-row" style="margin-top:8px">
                            <label class="toggle-switch">
                                <input type="hidden" name="dipublikasikan" value="0">
                                <input type="checkbox" name="dipublikasikan" value="1" id="pubToggle"
                                    {{ old('dipublikasikan', $materi->dipublikasikan ? '1' : '0') == '1' ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label" id="pubLabel">
                                {{ old('dipublikasikan', $materi->dipublikasikan ? '1' : '0') == '1' ? 'Dipublikasikan' : 'Draft' }}
                            </span>
                        </div>
                    </div>

                    <div class="field col-span-2">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" rows="4" placeholder="Tulis deskripsi materi...">{{ old('deskripsi', $materi->deskripsi) }}</textarea>
                        @error('deskripsi')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <div class="form-section">
                <p class="section-label">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Jenis & Konten
                    <span class="section-label-line"></span>
                </p>

                <div class="field" style="margin-bottom:20px">
                    <label>Jenis Materi <span class="req">*</span></label>
                    <div class="jenis-grid" style="margin-top:4px">
                        @foreach($jenisMateri as $j)
                        <label class="jenis-card {{ old('jenis', $materi->jenis) == $j ? 'selected' : '' }}" id="jcard-{{ $j }}">
                            <input type="radio" name="jenis" value="{{ $j }}"
                                {{ old('jenis', $materi->jenis) == $j ? 'checked' : '' }}
                                onchange="onJenisChange('{{ $j }}')">
                            <div class="jenis-icon ji-{{ $j }}">
                                @if($j=='file')
                                    <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                @elseif($j=='video')
                                    <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                                @elseif($j=='link')
                                    <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                                @else
                                    <svg width="18" height="18" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/></svg>
                                @endif
                            </div>
                            <p class="jenis-lbl">{{ ucfirst($j) }}</p>
                        </label>
                        @endforeach
                    </div>
                    @error('jenis')<span class="field-error" style="display:block;margin-top:4px">{{ $message }}</span>@enderror
                </div>

                {{-- Bug fix: section-file hanya untuk jenis 'file' --}}
                <div id="section-file" style="{{ old('jenis', $materi->jenis) == 'file' ? '' : 'display:none' }}">
                    @if($materi->path_file)
                    <div class="existing-file">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        File saat ini: {{ basename($materi->path_file) }}
                    </div>
                    @endif
                    <div class="field">
                        <label>Ganti File <span class="field-hint">(kosongkan jika tidak ingin mengganti)</span></label>
                        <div class="file-upload-area">
                            <input type="file" name="path_file">
                            <div class="fu-icon"><svg width="28" height="28" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg></div>
                            <p class="fu-title">Pilih file baru</p>
                            <p class="fu-sub">Maks. 50 MB</p>
                        </div>
                        @error('path_file')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                {{-- Bug fix: section-link dipakai oleh jenis 'link' DAN 'video' --}}
                <div id="section-link" style="{{ in_array(old('jenis', $materi->jenis), ['video', 'link']) ? '' : 'display:none' }}">
                    <div class="field">
                        <label>URL Eksternal</label>
                        <input type="url" name="url_eksternal"
                            value="{{ old('url_eksternal', $materi->url_eksternal) }}"
                            placeholder="https://..."
                            class="{{ $errors->has('url_eksternal') ? 'is-invalid' : '' }}">
                        @error('url_eksternal')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                {{-- section-teks: field 'deskripsi' digunakan sebagai konten teks panjang --}}
                {{-- Bug fix: model tidak punya kolom 'konten', gunakan 'deskripsi' --}}
                <div id="section-teks" style="{{ old('jenis', $materi->jenis) == 'teks' ? '' : 'display:none' }}">
                    <div class="field">
                        <label>Konten Teks</label>
                        <p class="field-hint">Isi konten teks di bawah ini. Nilai ini juga digunakan sebagai deskripsi materi.</p>
                        <textarea name="konten_teks" id="kontenTeks" rows="8"
                            placeholder="Tulis konten teks materi di sini...">{{ old('konten_teks', $materi->deskripsi) }}</textarea>
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
                    @if($materi->thumbnail)
                        <p class="field-hint" style="margin-bottom:8px">Thumbnail saat ini:</p>
                        <img src="{{ asset('storage/'.$materi->thumbnail) }}" alt="Thumbnail {{ $materi->judul }}" class="existing-thumb" style="margin-bottom:12px">
                    @endif
                    <label>Ganti Thumbnail <span class="field-hint">(kosongkan jika tidak ingin mengganti)</span></label>
                    <div class="file-upload-area">
                        <input type="file" name="thumbnail" accept="image/*">
                        <div class="fu-icon"><svg width="28" height="28" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
                        <p class="fu-title">Upload thumbnail baru</p>
                        <p class="fu-sub">JPG / PNG, maks. 2 MB</p>
                    </div>
                    @error('thumbnail')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.materi.show', $materi->id) }}" class="btn btn-cancel">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Perbarui Materi
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if($errors->any())
    Swal.fire({ icon:'error', title:'Terdapat {{ $errors->count() }} Kesalahan', html:`<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`, confirmButtonColor:'#1f63db' });
    @endif

    const AJAX_BASE     = '{{ url("admin/materi/ajax") }}';

    // Bug fix: gunakan data-* attribute yang sudah diset di HTML, bukan di JS setelah load
    // data-initial diset langsung di elemen select sehingga tersedia sejak halaman render

    // ── Cascade saat guru diganti ──────────────────────────────────────────────
    async function onGuruChange(guruId) {
        const selGuru   = document.getElementById('selGuru');
        const selMapel  = document.getElementById('selMapel');
        const selKelas  = document.getElementById('selKelas');
        const wrapMapel = document.getElementById('wrapMapel');
        const wrapKelas = document.getElementById('wrapKelas');
        const mapelHint = document.getElementById('mapelHint');
        const kelasHint = document.getElementById('kelasHint');

        if (!guruId) {
            setSelectEmpty(selMapel, '— Pilih Guru dulu —', true);
            setSelectEmpty(selKelas, '— Pilih Guru dulu —', true);
            mapelHint.classList.remove('show');
            kelasHint.classList.remove('show');
            return;
        }

        wrapMapel.classList.add('loading');
        wrapKelas.classList.add('loading');
        selMapel.disabled = true;
        selKelas.disabled = true;

        try {
            const [resMapel, resKelas] = await Promise.all([
                fetch(`${AJAX_BASE}/mapel-by-guru/${guruId}`).then(r => r.json()),
                fetch(`${AJAX_BASE}/kelas-by-guru/${guruId}`).then(r => r.json()),
            ]);

            // Bug fix: bandingkan guruId yang dipilih sekarang dengan initial dari data-*
            // Bukan dari dataset yang diset JS — itu menyebabkan race condition
            const initialGuru = selGuru.dataset.initial;
            const isInitialGuru = String(initialGuru) === String(guruId);

            // Pertahankan nilai lama hanya jika guru tidak berubah dari data asli materi
            const keepMapel = isInitialGuru ? '{{ old("mata_pelajaran_id", $materi->mata_pelajaran_id) }}' : '';
            const keepKelas = isInitialGuru ? '{{ old("kelas_id", $materi->kelas_id) }}' : '';

            populateSelect(selMapel, resMapel, 'nama_mapel', '— Pilih Mapel —', keepMapel);
            populateSelect(selKelas, resKelas, 'nama_kelas', '— Pilih Kelas —', keepKelas);

            selMapel.disabled = false;
            selKelas.disabled = false;
            mapelHint.classList.add('show');
            kelasHint.classList.add('show');

        } catch(e) {
            console.error('Cascade error:', e);
            selMapel.disabled = false;
            selKelas.disabled = false;
        } finally {
            wrapMapel.classList.remove('loading');
            wrapKelas.classList.remove('loading');
        }
    }

    function populateSelect(sel, items, labelKey, placeholder, selectedVal) {
        sel.innerHTML = `<option value="">${placeholder}</option>`;
        items.forEach(item => {
            const opt = document.createElement('option');
            opt.value = item.id;
            opt.textContent = item[labelKey];
            if (String(item.id) === String(selectedVal)) opt.selected = true;
            sel.appendChild(opt);
        });
    }

    function setSelectEmpty(sel, placeholder, disabled) {
        sel.innerHTML = `<option value="">${placeholder}</option>`;
        sel.disabled = !!disabled;
    }

    // ── Toggle publikasi ───────────────────────────────────────────────────────
    document.getElementById('pubToggle').addEventListener('change', function() {
        document.getElementById('pubLabel').textContent = this.checked ? 'Dipublikasikan' : 'Draft';
    });

    // ── Jenis materi ───────────────────────────────────────────────────────────
    // Bug fix: onJenisChange sekarang menangani semua 4 jenis dengan benar
    // 'video' dan 'link' sama-sama tampilkan section-link (url_eksternal)
    function onJenisChange(jenis) {
        document.getElementById('section-file').style.display = 'none';
        document.getElementById('section-link').style.display = 'none';
        document.getElementById('section-teks').style.display = 'none';

        document.querySelectorAll('.jenis-card').forEach(c => c.classList.remove('selected'));
        const card = document.getElementById('jcard-' + jenis);
        if (card) card.classList.add('selected');

        if (jenis === 'file')                   document.getElementById('section-file').style.display = '';
        if (jenis === 'link' || jenis === 'video') document.getElementById('section-link').style.display = '';
        if (jenis === 'teks')                   document.getElementById('section-teks').style.display = '';
    }

    // ── Submit guard ───────────────────────────────────────────────────────────
    document.getElementById('materiForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
    });
</script>
</x-app-layout>