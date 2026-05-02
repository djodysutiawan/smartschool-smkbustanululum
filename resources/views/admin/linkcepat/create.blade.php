<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        --brand-700: #1750c0;
        --brand-600: #1f63db;
        --brand-500: #3582f0;
        --brand-100: #d9ebff;
        --brand-50:  #eef6ff;
        --surface:   #fff;
        --surface2:  #f8fafc;
        --surface3:  #f1f5f9;
        --border:    #e2e8f0;
        --border2:   #cbd5e1;
        --text:      #0f172a;
        --text2:     #475569;
        --text3:     #94a3b8;
        --red:       #dc2626;
        --red-bg:    #fff0f0;
        --red-border:#fecaca;
        --green:     #15803d;
        --green-bg:  #f0fdf4;
        --green-border:#bbf7d0;
        --amber:     #a16207;
        --amber-bg:  #fefce8;
        --amber-border:#fde68a;
        --radius:    10px;
        --radius-sm: 7px;
        --radius-lg: 14px;
    }

    .page { padding: 28px 28px 60px; max-width: 2000px; }

    /* Breadcrumb */
    .bc { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text3); margin-bottom: 20px; }
    .bc a { color: var(--text2); text-decoration: none; }
    .bc a:hover { color: var(--brand-600); }

    /* Header */
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2; }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; }

    /* Buttons */
    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none;
        transition: filter .15s; white-space: nowrap;
    }
    .btn:hover { filter: brightness(.93); }
    .btn-primary  { background: var(--brand-600); color: #fff; }
    .btn-sm       { padding: 6px 12px; font-size: 12px; border-radius: 6px; }
    .btn-secondary { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-secondary:hover { background: var(--surface3); filter: none; }

    /* Form grid */
    .form-grid { display: grid; grid-template-columns: 1fr 300px; gap: 16px; align-items: start; }
    @media (max-width: 700px) { .form-grid { grid-template-columns: 1fr; } }

    /* Card */
    .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; }
    .card + .card { margin-top: 14px; }
    .card-head {
        padding: 13px 18px; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 10px;
        background: var(--surface2);
    }
    .card-head-icon {
        width: 30px; height: 30px; border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .card-head-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--text); }
    .card-head-sub   { font-size: 11.5px; color: var(--text3); margin-top: 1px; }
    .card-body { padding: 18px; }

    /* Form elements */
    .fg { margin-bottom: 16px; }
    .fg:last-child { margin-bottom: 0; }
    .flabel {
        display: flex; align-items: center; gap: 6px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px; font-weight: 700; color: var(--text2); margin-bottom: 6px;
    }
    .req { color: var(--red); font-size: 10px; background: var(--red-bg); border-radius: 4px; padding: 1px 5px; font-weight: 700; }
    .opt { color: var(--text3); font-weight: 400; font-size: 11.5px; }
    .finput, .fselect {
        width: 100%; height: 38px; padding: 0 12px;
        border: 1px solid var(--border2); border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif; font-size: 13px;
        color: var(--text); background: var(--surface2); outline: none;
        transition: border-color .15s, box-shadow .15s;
        box-sizing: border-box;
    }
    .finput:focus, .fselect:focus { border-color: var(--brand-500); background: #fff; box-shadow: 0 0 0 3px rgba(53,130,240,.1); }
    .finput.err { border-color: var(--red); }
    .fhint { font-size: 11.5px; color: var(--text3); margin-top: 5px; display: flex; align-items: center; gap: 4px; }
    .ferr  { font-size: 11.5px; color: var(--red);   margin-top: 5px; display: flex; align-items: center; gap: 4px; }

    /* URL input */
    .url-wrap { display: flex; align-items: stretch; border: 1px solid var(--border2); border-radius: var(--radius-sm); overflow: hidden; transition: border-color .15s, box-shadow .15s; }
    .url-wrap:focus-within { border-color: var(--brand-500); box-shadow: 0 0 0 3px rgba(53,130,240,.1); }
    .url-prefix { display: flex; align-items: center; padding: 0 10px; background: var(--surface3); border-right: 1px solid var(--border2); color: var(--text3); font-size: 12px; white-space: nowrap; font-family: monospace; }
    .url-wrap .finput { border: none; border-radius: 0; box-shadow: none !important; background: var(--surface2); }
    .url-wrap:focus-within .finput { background: #fff; }

    /* Ikon grid */
    .ikon-grid { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
    .ikon-btn {
        width: 38px; height: 38px; border-radius: var(--radius-sm);
        border: 1px solid var(--border); background: var(--surface);
        font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center;
        transition: all .15s;
    }
    .ikon-btn:hover { border-color: var(--brand-100); background: var(--brand-50); transform: scale(1.08); }
    .ikon-btn.selected { border-color: var(--brand-500); background: var(--brand-50); box-shadow: 0 0 0 2px rgba(53,130,240,.15); }

    /* Color swatches */
    .color-grid { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
    .cswatch { width: 26px; height: 26px; border-radius: 6px; cursor: pointer; border: 2px solid transparent; transition: all .15s; }
    .cswatch:hover { transform: scale(1.15); }
    .cswatch.sel   { border-color: var(--text); transform: scale(1.1); box-shadow: 0 0 0 2px rgba(0,0,0,.12); }
    .color-custom-row { display: flex; align-items: center; gap: 8px; margin-top: 8px; }
    .color-custom-row input[type="color"] { width: 34px; height: 34px; border-radius: var(--radius-sm); border: 1px solid var(--border2); padding: 2px; cursor: pointer; }
    .color-hex { width: 110px !important; font-family: monospace; font-size: 12px; text-transform: uppercase; }

    /* Toggle */
    .toggle-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 14px; border-radius: var(--radius-sm);
        background: var(--surface2); border: 1px solid var(--border);
        transition: all .15s;
    }
    .toggle-row:has(.ti:checked) { background: var(--brand-50); border-color: var(--brand-100); }
    .tl-wrap { display: flex; flex-direction: column; gap: 2px; }
    .tl { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text); }
    .td { font-size: 11.5px; color: var(--text3); }
    .toggle-ui-wrap { position: relative; flex-shrink: 0; }
    .ti { position: absolute; opacity: 0; width: 0; height: 0; }
    .tui { display: block; width: 40px; height: 22px; background: var(--border2); border-radius: 99px; cursor: pointer; position: relative; transition: background .15s; }
    .tui::after { content: ''; position: absolute; top: 3px; left: 3px; width: 16px; height: 16px; background: #fff; border-radius: 50%; box-shadow: 0 1px 3px rgba(0,0,0,.2); transition: transform .15s; }
    .ti:checked ~ .tui { background: var(--brand-600); }
    .ti:checked ~ .tui::after { transform: translateX(18px); }

    /* Stepper */
    .stepper { display: flex; align-items: center; gap: 8px; }
    .step-btn {
        width: 32px; height: 32px; border-radius: var(--radius-sm);
        border: 1px solid var(--border2); background: var(--surface);
        cursor: pointer; font-size: 16px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        color: var(--text2); transition: all .15s;
    }
    .step-btn:hover { background: var(--brand-50); border-color: var(--brand-100); color: var(--brand-600); }
    .stepper .finput { width: 72px; text-align: center; }

    /* Preview */
    .preview-wrap {
        border: 1px solid var(--border); border-radius: var(--radius);
        padding: 20px; background: var(--surface2);
        display: flex; flex-direction: column; align-items: center; gap: 10px; text-align: center;
    }
    .preview-btn-el {
        width: 68px; height: 68px; border-radius: var(--radius);
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 4px; font-size: 26px; border: 2px solid transparent; transition: all .15s; cursor: default;
    }
    .preview-lbl  { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text2); max-width: 80px; line-height: 1.3; word-break: break-word; }
    .preview-url  { font-size: 10.5px; color: var(--text3); font-family: monospace; max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .preview-tab  { font-size: 10.5px; color: var(--text3); display: flex; align-items: center; gap: 4px; }

    /* Tips */
    .tips-box { margin-top: 14px; padding: 14px 16px; background: var(--brand-50); border: 1px solid var(--brand-100); border-radius: var(--radius); font-size: 12px; color: var(--brand-700); line-height: 1.7; }
    .tips-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; margin-bottom: 6px; display: flex; align-items: center; gap: 5px; }
    .tips-box ul { margin: 0; padding-left: 16px; }

    /* Alert */
    .alert { padding: 12px 14px; border-radius: var(--radius-sm); border: 1px solid; display: flex; align-items: flex-start; gap: 8px; font-size: 13px; margin-bottom: 18px; }
    .alert-error { background: var(--red-bg); color: #991b1b; border-color: var(--red-border); }

    /* Action bar */
    .action-bar {
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; padding: 14px 18px;
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius-lg); margin-top: 18px;
        position: sticky; bottom: 20px; z-index: 10;
        box-shadow: 0 4px 20px rgba(0,0,0,.08);
        flex-wrap: wrap;
    }
    .action-bar-info { font-size: 12.5px; color: var(--text3); display: flex; align-items: center; gap: 6px; }
    .action-bar-btns { display: flex; gap: 8px; }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="bc">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.link-cepat.index') }}">Link Cepat</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
        <span>Tambah Baru</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Link Cepat</h1>
            <p class="page-sub">Shortcut tautan baru di halaman beranda</p>
        </div>
        <a href="{{ route('admin.link-cepat.index') }}" class="btn btn-secondary btn-sm">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 19l-7-7 7-7M3 12h18"/></svg>
            Kembali
        </a>
    </div>

    {{-- Error alert --}}
    @if($errors->any())
    <div class="alert alert-error">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
        <div>
            <div style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;margin-bottom:4px">{{ $errors->count() }} kesalahan ditemukan:</div>
            <ul style="margin:0;padding-left:16px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.link-cepat.store') }}" method="POST" id="lc-form">
        @csrf
        <div class="form-grid">

            {{-- KIRI --}}
            <div>

                {{-- Informasi Tautan --}}
                <div class="card">
                    <div class="card-head">
                        <div class="card-head-icon" style="background:var(--brand-50);color:var(--brand-600)">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
                        </div>
                        <div>
                            <div class="card-head-title">Informasi Tautan</div>
                            <div class="card-head-sub">Label, URL, dan konfigurasi dasar</div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="fg">
                            <label class="flabel" for="label">Label Tombol <span class="req">WAJIB</span></label>
                            <input type="text" id="label" name="label"
                                class="finput {{ $errors->has('label') ? 'err' : '' }}"
                                value="{{ old('label') }}"
                                placeholder="cth. PPDB Online, E-Rapor…"
                                maxlength="100" required autofocus>
                            @error('label')<div class="ferr"><svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>{{ $message }}</div>@enderror
                            <div class="fhint">Teks yang tampil di bawah ikon tombol</div>
                        </div>

                        <div class="fg">
                            <label class="flabel" for="url">URL Tujuan <span class="req">WAJIB</span></label>
                            <div class="url-wrap {{ $errors->has('url') ? 'err' : '' }}">
                                <span class="url-prefix">https://</span>
                                <input type="url" id="url" name="url"
                                    class="finput"
                                    value="{{ old('url') }}"
                                    placeholder="www.sekolah.sch.id/ppdb" required>
                            </div>
                            @error('url')<div class="ferr"><svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>{{ $message }}</div>@enderror
                        </div>

                        <div class="fg">
                            <div class="toggle-row">
                                <div class="tl-wrap">
                                    <span class="tl">Buka di tab baru</span>
                                    <span class="td">Link terbuka di jendela browser baru</span>
                                </div>
                                <label class="toggle-ui-wrap">
                                    <input type="hidden" name="buka_tab_baru" value="0">
                                    <input type="checkbox" name="buka_tab_baru" value="1"
                                        class="ti" id="buka_tab_baru"
                                        {{ old('buka_tab_baru') ? 'checked' : '' }}>
                                    <span class="tui"></span>
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Ikon & Warna --}}
                <div class="card">
                    <div class="card-head">
                        <div class="card-head-icon" style="background:#fdf4ff;color:#9333ea">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                        </div>
                        <div>
                            <div class="card-head-title">Ikon & Warna</div>
                            <div class="card-head-sub">Tampilan visual tombol di beranda</div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="fg">
                            <label class="flabel">Ikon Emoji <span class="opt">— opsional</span></label>
                            <div class="ikon-grid" id="ikon-grid">
                                @php $ikonList = ['📚','🎓','📝','📋','🗓️','🏫','💻','📊','🔔','📢','🏆','🤝','💰','📞','✉️','🌐','📱','🎨','⚽','🔬']; @endphp
                                @foreach($ikonList as $ikon)
                                    <button type="button" class="ikon-btn {{ old('ikon') === $ikon ? 'selected' : '' }}" data-ikon="{{ $ikon }}">{{ $ikon }}</button>
                                @endforeach
                            </div>
                            <div style="display:flex;align-items:center;gap:8px;margin-top:10px">
                                <input type="text" class="finput" id="ikon-custom"
                                    placeholder="Ketik emoji lain…" maxlength="4" style="width:140px;height:36px">
                            </div>
                            <input type="hidden" name="ikon" id="ikon-hidden" value="{{ old('ikon') }}">
                        </div>

                        <div class="fg">
                            <label class="flabel">Warna Tema <span class="opt">— opsional</span></label>
                            @php $colors = ['#1f63db','#6366f1','#8b5cf6','#ec4899','#f43f5e','#f59e0b','#15803d','#14b8a6','#f97316','#84cc16','#06b6d4','#64748b']; @endphp
                            <div class="color-grid" id="color-grid">
                                @foreach($colors as $c)
                                    <button type="button" class="cswatch {{ old('warna') === $c ? 'sel' : '' }}"
                                        data-color="{{ $c }}" style="background:{{ $c }}" title="{{ $c }}"></button>
                                @endforeach
                            </div>
                            <div class="color-custom-row">
                                <input type="color" id="cpicker" value="{{ old('warna', '#1f63db') }}">
                                <input type="text" class="finput color-hex" id="chex"
                                    placeholder="#1f63db" maxlength="7" value="{{ old('warna') }}">
                            </div>
                            <input type="hidden" name="warna" id="warna-hidden" value="{{ old('warna') }}">
                        </div>

                    </div>
                </div>

            </div>{{-- /kiri --}}

            {{-- KANAN --}}
            <div>

                {{-- Preview --}}
                <div class="card">
                    <div class="card-head">
                        <div class="card-head-icon" style="background:var(--amber-bg);color:var(--amber)">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div>
                            <div class="card-head-title">Preview</div>
                            <div class="card-head-sub">Tampilan di beranda</div>
                        </div>
                    </div>
                    <div class="card-body" style="display:flex;justify-content:center;padding:24px 18px">
                        <div class="preview-wrap" style="width:100%;max-width:180px">
                            <div class="preview-btn-el" id="preview-btn"
                                style="background:#eef6ff20;border-color:#d9ebff;color:#1f63db">
                                <span id="preview-icon">🔗</span>
                            </div>
                            <div class="preview-lbl" id="preview-lbl">Nama Link</div>
                            <div class="preview-url" id="preview-url">—</div>
                            <div class="preview-tab" id="preview-tab"></div>
                        </div>
                    </div>
                </div>

                {{-- Publikasi --}}
                <div class="card">
                    <div class="card-head">
                        <div class="card-head-icon" style="background:var(--green-bg);color:var(--green)">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div>
                            <div class="card-head-title">Publikasi</div>
                            <div class="card-head-sub">Visibilitas link di website</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="toggle-row">
                            <div class="tl-wrap">
                                <span class="tl">Publikasikan link</span>
                                <span class="td">Tampilkan di halaman beranda</span>
                            </div>
                            <label class="toggle-ui-wrap">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" name="is_published" value="1"
                                    class="ti" {{ old('is_published', true) ? 'checked' : '' }}>
                                <span class="tui"></span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Urutan --}}
                <div class="card">
                    <div class="card-head">
                        <div class="card-head-icon" style="background:var(--amber-bg);color:var(--amber)">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                        </div>
                        <div>
                            <div class="card-head-title">Urutan</div>
                            <div class="card-head-sub">Posisi tampil tombol</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="stepper">
                            <button type="button" class="step-btn" id="step-dec">−</button>
                            <input type="number" name="urutan" id="urutan"
                                class="finput" value="{{ old('urutan', 1) }}" min="0" max="999">
                            <button type="button" class="step-btn" id="step-inc">+</button>
                        </div>
                        <div class="fhint" style="margin-top:6px">Angka lebih kecil tampil lebih awal</div>
                    </div>
                </div>

                {{-- Tips --}}
                <div class="tips-box">
                    <div class="tips-title">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4m0-4h.01"/></svg>
                        Tips penggunaan
                    </div>
                    <ul>
                        <li>Gunakan emoji yang relevan agar mudah dikenali</li>
                        <li>Label singkat (maks 3 kata) lebih efektif</li>
                        <li>Aktifkan tab baru untuk link ke website luar</li>
                        <li>Gunakan warna berbeda tiap link agar mudah dibedakan</li>
                    </ul>
                </div>

            </div>{{-- /kanan --}}

        </div>

        {{-- Action bar --}}
        <div class="action-bar">
            <div class="action-bar-info">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4m0-4h.01"/></svg>
                Data akan tersimpan dan langsung aktif di beranda.
            </div>
            <div class="action-bar-btns">
                <a href="{{ route('admin.link-cepat.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Simpan Link
                </button>
            </div>
        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const labelInput = document.getElementById('label');
    const urlInput   = document.getElementById('url');
    const ikonHidden = document.getElementById('ikon-hidden');
    const ikonCustom = document.getElementById('ikon-custom');
    const warnaHidden= document.getElementById('warna-hidden');
    const cpicker    = document.getElementById('cpicker');
    const chex       = document.getElementById('chex');
    const tabToggle  = document.getElementById('buka_tab_baru');
    const prevBtn    = document.getElementById('preview-btn');
    const prevIcon   = document.getElementById('preview-icon');
    const prevLbl    = document.getElementById('preview-lbl');
    const prevUrl    = document.getElementById('preview-url');
    const prevTab    = document.getElementById('preview-tab');

    function updatePreview() {
        const label = labelInput.value.trim() || 'Nama Link';
        const url   = urlInput.value.trim()   || '—';
        const ikon  = ikonHidden.value         || '🔗';
        const color = warnaHidden.value        || '#1f63db';
        prevLbl.textContent  = label;
        prevUrl.textContent  = url.length > 32 ? url.slice(0,30)+'…' : url;
        prevIcon.textContent = ikon;
        prevBtn.style.background  = color + '18';
        prevBtn.style.borderColor = color + '50';
        prevBtn.style.color = color;
        prevTab.innerHTML = tabToggle.checked
            ? '<svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg> Tab baru' : '';
    }

    labelInput.addEventListener('input', updatePreview);
    urlInput.addEventListener('input', updatePreview);
    tabToggle.addEventListener('change', updatePreview);

    // Ikon grid
    document.querySelectorAll('.ikon-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.ikon-btn').forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
            ikonHidden.value = btn.dataset.ikon;
            ikonCustom.value = '';
            updatePreview();
        });
    });
    ikonCustom.addEventListener('input', () => {
        if (ikonCustom.value) {
            document.querySelectorAll('.ikon-btn').forEach(b => b.classList.remove('selected'));
            ikonHidden.value = ikonCustom.value;
            updatePreview();
        }
    });

    // Color
    function applyColor(hex) {
        warnaHidden.value = hex;
        chex.value = hex.toUpperCase();
        cpicker.value = hex;
        document.querySelectorAll('.cswatch').forEach(s => s.classList.toggle('sel', s.dataset.color === hex));
        updatePreview();
    }
    document.querySelectorAll('.cswatch').forEach(s => s.addEventListener('click', () => applyColor(s.dataset.color)));
    cpicker.addEventListener('input', () => applyColor(cpicker.value));
    chex.addEventListener('input', () => { if (/^#[0-9a-fA-F]{6}$/.test(chex.value)) applyColor(chex.value); });

    // Stepper
    const urutanInput = document.getElementById('urutan');
    document.getElementById('step-inc').addEventListener('click', () => urutanInput.value = parseInt(urutanInput.value||0) + 1);
    document.getElementById('step-dec').addEventListener('click', () => urutanInput.value = Math.max(0, parseInt(urutanInput.value||0) - 1));

    // Init
    if (warnaHidden.value) applyColor(warnaHidden.value);
    updatePreview();
});
</script>
</x-app-layout>