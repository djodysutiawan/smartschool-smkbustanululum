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

    .bc { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text3); margin-bottom: 20px; }
    .bc a { color: var(--text2); text-decoration: none; }
    .bc a:hover { color: var(--brand-600); }

    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2; }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .header-actions { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

    .badge-status {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700;
        border: 1px solid;
    }
    .badge-status .dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .badge-on  { background: var(--green-bg);  color: var(--green);  border-color: var(--green-border); }
    .badge-off { background: var(--surface2);  color: var(--text3);  border-color: var(--border); }

    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
        cursor: pointer; border: none; text-decoration: none; transition: filter .15s; white-space: nowrap;
    }
    .btn:hover { filter: brightness(.93); }
    .btn-primary   { background: var(--brand-600); color: #fff; }
    .btn-sm        { padding: 6px 12px; font-size: 12px; border-radius: 6px; }
    .btn-secondary { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-secondary:hover { background: var(--surface3); filter: none; }
    .btn-danger    { background: var(--red-bg); color: var(--red); border: 1px solid var(--red-border); }
    .btn-danger:hover { background: var(--red); color: #fff; filter: none; }
    .btn-ghost     { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); width: 100%; justify-content: center; }
    .btn-ghost:hover { background: var(--surface3); filter: none; }

    .form-grid { display: grid; grid-template-columns: 1fr 300px; gap: 16px; align-items: start; }
    @media (max-width: 700px) { .form-grid { grid-template-columns: 1fr; } }

    .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; }
    .card + .card { margin-top: 14px; }
    .card-head { padding: 13px 18px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 10px; background: var(--surface2); }
    .card-head-icon { width: 30px; height: 30px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .card-head-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--text); }
    .card-head-sub   { font-size: 11.5px; color: var(--text3); margin-top: 1px; }
    .card-body { padding: 18px; }

    .fg { margin-bottom: 16px; }
    .fg:last-child { margin-bottom: 0; }
    .flabel { display: flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text2); margin-bottom: 6px; }
    .req { color: var(--red); font-size: 10px; background: var(--red-bg); border-radius: 4px; padding: 1px 5px; font-weight: 700; }
    .opt { color: var(--text3); font-weight: 400; font-size: 11.5px; }
    .finput {
        width: 100%; height: 38px; padding: 0 12px;
        border: 1px solid var(--border2); border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif; font-size: 13px;
        color: var(--text); background: var(--surface2); outline: none;
        transition: border-color .15s, box-shadow .15s; box-sizing: border-box;
    }
    .finput:focus { border-color: var(--brand-500); background: #fff; box-shadow: 0 0 0 3px rgba(53,130,240,.1); }
    .finput.err { border-color: var(--red); }
    .fhint { font-size: 11.5px; color: var(--text3); margin-top: 5px; }
    .ferr  { font-size: 11.5px; color: var(--red); margin-top: 5px; display: flex; align-items: center; gap: 4px; }

    .url-wrap { display: flex; align-items: stretch; border: 1px solid var(--border2); border-radius: var(--radius-sm); overflow: hidden; transition: border-color .15s, box-shadow .15s; }
    .url-wrap:focus-within { border-color: var(--brand-500); box-shadow: 0 0 0 3px rgba(53,130,240,.1); }
    .url-prefix { display: flex; align-items: center; padding: 0 10px; background: var(--surface3); border-right: 1px solid var(--border2); color: var(--text3); font-size: 12px; white-space: nowrap; font-family: monospace; }
    .url-wrap .finput { border: none; border-radius: 0; box-shadow: none !important; background: var(--surface2); }
    .url-wrap:focus-within .finput { background: #fff; }

    .ikon-grid { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
    .ikon-btn { width: 38px; height: 38px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--surface); font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all .15s; }
    .ikon-btn:hover { border-color: var(--brand-100); background: var(--brand-50); transform: scale(1.08); }
    .ikon-btn.selected { border-color: var(--brand-500); background: var(--brand-50); box-shadow: 0 0 0 2px rgba(53,130,240,.15); }

    .color-grid { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
    .cswatch { width: 26px; height: 26px; border-radius: 6px; cursor: pointer; border: 2px solid transparent; transition: all .15s; }
    .cswatch:hover { transform: scale(1.15); }
    .cswatch.sel { border-color: var(--text); transform: scale(1.1); box-shadow: 0 0 0 2px rgba(0,0,0,.12); }
    .color-custom-row { display: flex; align-items: center; gap: 8px; margin-top: 8px; }
    .color-custom-row input[type="color"] { width: 34px; height: 34px; border-radius: var(--radius-sm); border: 1px solid var(--border2); padding: 2px; cursor: pointer; }
    .color-hex { width: 110px !important; font-family: monospace; font-size: 12px; text-transform: uppercase; }

    .toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; border-radius: var(--radius-sm); background: var(--surface2); border: 1px solid var(--border); transition: all .15s; }
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

    .stepper { display: flex; align-items: center; gap: 8px; }
    .step-btn { width: 32px; height: 32px; border-radius: var(--radius-sm); border: 1px solid var(--border2); background: var(--surface); cursor: pointer; font-size: 16px; font-weight: 700; display: flex; align-items: center; justify-content: center; color: var(--text2); transition: all .15s; }
    .step-btn:hover { background: var(--brand-50); border-color: var(--brand-100); color: var(--brand-600); }
    .stepper .finput { width: 72px; text-align: center; }

    .preview-wrap { border: 1px solid var(--border); border-radius: var(--radius); padding: 20px; background: var(--surface2); display: flex; flex-direction: column; align-items: center; gap: 10px; text-align: center; }
    .preview-btn-el { width: 68px; height: 68px; border-radius: var(--radius); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; font-size: 26px; border: 2px solid transparent; transition: all .15s; cursor: default; }
    .preview-lbl { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text2); max-width: 80px; line-height: 1.3; word-break: break-word; }
    .preview-url { font-size: 10.5px; color: var(--text3); font-family: monospace; max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .preview-tab { font-size: 10.5px; color: var(--text3); display: flex; align-items: center; gap: 4px; }

    /* Info list */
    .info-list { }
    .info-item { display: flex; flex-direction: column; gap: 2px; padding: 8px 0; border-bottom: 1px solid var(--border); }
    .info-item:last-child { border-bottom: none; padding-bottom: 0; }
    .info-item dt { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .05em; }
    .info-item dd { font-size: 12.5px; color: var(--text2); font-weight: 500; }

    /* Save indicator */
    .save-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--amber); display: inline-block; }
    .save-dot.blink { animation: blink 1.8s infinite; }
    .save-dot.saved { background: var(--green); animation: none; }
    @keyframes blink { 0%,100%{opacity:1}50%{opacity:.2} }

    .action-bar {
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; padding: 14px 18px;
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius-lg); margin-top: 18px;
        position: sticky; bottom: 20px; z-index: 10;
        box-shadow: 0 4px 20px rgba(0,0,0,.08); flex-wrap: wrap;
    }
    .action-bar-info { font-size: 12.5px; color: var(--text3); display: flex; align-items: center; gap: 6px; }
    .action-bar-btns { display: flex; gap: 8px; }

    .alert { padding: 12px 14px; border-radius: var(--radius-sm); border: 1px solid; display: flex; align-items: flex-start; gap: 8px; font-size: 13px; margin-bottom: 18px; }
    .alert-error   { background: var(--red-bg); color: #991b1b; border-color: var(--red-border); }
    .alert-success { background: var(--green-bg); color: var(--green); border-color: var(--green-border); }

    /* Danger zone */
    .danger-zone { border: 1px solid var(--red-border); border-radius: var(--radius-lg); overflow: hidden; margin-top: 24px; }
    .dz-head { background: var(--red-bg); padding: 12px 18px; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid var(--red-border); }
    .dz-head h3 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--red); }
    .dz-body { padding: 16px 18px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; background: var(--surface); }
    .dz-body p { font-size: 13px; color: var(--text2); line-height: 1.5; }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="bc">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.link-cepat.index') }}">Link Cepat</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
        <span>Edit</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Link Cepat</h1>
            <p class="page-sub">Mengubah <strong style="color:var(--text2)">{{ $linkCepat->label }}</strong></p>
        </div>
        <div class="header-actions">
            <span class="badge-status {{ $linkCepat->is_published ? 'badge-on' : 'badge-off' }}">
                <span class="dot"></span>{{ $linkCepat->is_published ? 'Aktif' : 'Nonaktif' }}
            </span>
            <a href="{{ $linkCepat->url }}" target="_blank" class="btn btn-secondary btn-sm">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Buka Link
            </a>
            <a href="{{ route('admin.link-cepat.index') }}" class="btn btn-secondary btn-sm">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 19l-7-7 7-7M3 12h18"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-error">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
        <div>
            <div style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;margin-bottom:4px">{{ $errors->count() }} kesalahan:</div>
            <ul style="margin:0;padding-left:16px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    </div>
    @endif

    @php $currentWarna = old('warna', $linkCepat->warna); @endphp

    <form action="{{ route('admin.link-cepat.update', $linkCepat) }}"
          method="POST" id="lc-form" autocomplete="off">
        @csrf @method('PUT')

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
                                value="{{ old('label', $linkCepat->label) }}"
                                maxlength="100" required>
                            @error('label')<div class="ferr"><svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>{{ $message }}</div>@enderror
                        </div>

                        <div class="fg">
                            <label class="flabel" for="url">URL Tujuan <span class="req">WAJIB</span></label>
                            <div class="url-wrap {{ $errors->has('url') ? 'err' : '' }}">
                                <span class="url-prefix">url</span>
                                <input type="url" id="url" name="url"
                                    class="finput"
                                    value="{{ old('url', $linkCepat->url) }}" required>
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
                                        {{ old('buka_tab_baru', $linkCepat->buka_tab_baru) ? 'checked' : '' }}>
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
                            @php $ikonList = ['📚','🎓','📝','📋','🗓️','🏫','💻','📊','🔔','📢','🏆','🤝','💰','📞','✉️','🌐','📱','🎨','⚽','🔬']; @endphp
                            <div class="ikon-grid" id="ikon-grid">
                                @foreach($ikonList as $ikon)
                                    <button type="button"
                                        class="ikon-btn {{ old('ikon', $linkCepat->ikon) === $ikon ? 'selected' : '' }}"
                                        data-ikon="{{ $ikon }}">{{ $ikon }}</button>
                                @endforeach
                            </div>
                            <div style="display:flex;align-items:center;gap:8px;margin-top:10px">
                                <input type="text" class="finput" id="ikon-custom"
                                    placeholder="Emoji lain…" maxlength="4" style="width:140px;height:36px"
                                    value="{{ !in_array(old('ikon', $linkCepat->ikon), $ikonList) ? old('ikon', $linkCepat->ikon) : '' }}">
                            </div>
                            <input type="hidden" name="ikon" id="ikon-hidden" value="{{ old('ikon', $linkCepat->ikon) }}">
                        </div>

                        <div class="fg">
                            <label class="flabel">Warna Tema <span class="opt">— opsional</span></label>
                            @php $colors = ['#1f63db','#6366f1','#8b5cf6','#ec4899','#f43f5e','#f59e0b','#15803d','#14b8a6','#f97316','#84cc16','#06b6d4','#64748b']; @endphp
                            <div class="color-grid" id="color-grid">
                                @foreach($colors as $c)
                                    <button type="button" class="cswatch {{ $currentWarna === $c ? 'sel' : '' }}"
                                        data-color="{{ $c }}" style="background:{{ $c }}" title="{{ $c }}"></button>
                                @endforeach
                            </div>
                            <div class="color-custom-row">
                                <input type="color" id="cpicker" value="{{ $currentWarna ?: '#1f63db' }}">
                                <input type="text" class="finput color-hex" id="chex"
                                    placeholder="#1f63db" maxlength="7" value="{{ $currentWarna }}">
                            </div>
                            <input type="hidden" name="warna" id="warna-hidden" value="{{ old('warna', $linkCepat->warna) }}">
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
                            <div class="card-head-title">Preview Live</div>
                            <div class="card-head-sub">Tampilan di beranda</div>
                        </div>
                    </div>
                    <div class="card-body" style="display:flex;justify-content:center;padding:24px 18px">
                        <div class="preview-wrap" style="width:100%;max-width:180px">
                            <div class="preview-btn-el" id="preview-btn"
                                style="background:{{ $currentWarna ? $currentWarna.'18' : '#eef6ff' }};border-color:{{ $currentWarna ? $currentWarna.'50' : '#d9ebff' }};color:{{ $currentWarna ?: '#1f63db' }}">
                                <span id="preview-icon">{{ $linkCepat->ikon ?: '🔗' }}</span>
                            </div>
                            <div class="preview-lbl" id="preview-lbl">{{ $linkCepat->label }}</div>
                            <div class="preview-url" id="preview-url">{{ $linkCepat->url }}</div>
                            <div class="preview-tab" id="preview-tab">
                                @if($linkCepat->buka_tab_baru)
                                    <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg> Tab baru
                                @endif
                            </div>
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
                            <div class="card-head-sub">Visibilitas di website</div>
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
                                    class="ti" id="is_published"
                                    {{ old('is_published', $linkCepat->is_published) ? 'checked' : '' }}>
                                <span class="tui"></span>
                            </label>
                        </div>
                        {{-- Quick toggle --}}
                        <form action="{{ route('admin.link-cepat.toggle', $linkCepat) }}" method="POST" style="margin-top:10px">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-ghost btn-sm">
                                @if($linkCepat->is_published)
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                    Sembunyikan Sekarang
                                @else
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Publikasikan Sekarang
                                @endif
                            </button>
                        </form>
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
                                class="finput" value="{{ old('urutan', $linkCepat->urutan) }}" min="0" max="999">
                            <button type="button" class="step-btn" id="step-inc">+</button>
                        </div>
                        <div class="fhint" style="margin-top:6px">Angka lebih kecil tampil lebih awal</div>
                    </div>
                </div>

                {{-- Info sistem --}}
                <div class="card">
                    <div class="card-head">
                        <div class="card-head-icon" style="background:var(--surface2);color:var(--text3)">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div>
                            <div class="card-head-title">Informasi</div>
                            <div class="card-head-sub">Data sistem</div>
                        </div>
                    </div>
                    <div class="card-body" style="padding-top:10px;padding-bottom:10px">
                        <dl class="info-list">
                            <div class="info-item"><dt>ID</dt><dd>#{{ $linkCepat->id }}</dd></div>
                            <div class="info-item"><dt>Dibuat</dt><dd>{{ $linkCepat->created_at->format('d M Y, H:i') }}</dd></div>
                            <div class="info-item"><dt>Diperbarui</dt><dd>{{ $linkCepat->updated_at->diffForHumans() }}</dd></div>
                        </dl>
                    </div>
                </div>

            </div>{{-- /kanan --}}

        </div>

        {{-- Action bar --}}
        <div class="action-bar">
            <div class="action-bar-info">
                <span class="save-dot blink" id="save-dot"></span>
                <span id="save-status">Ada perubahan belum disimpan</span>
            </div>
            <div class="action-bar-btns">
                <a href="{{ route('admin.link-cepat.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>

    </form>

    {{-- Danger zone --}}
    <div class="danger-zone">
        <div class="dz-head">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:var(--red)"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            <h3>Zona Berbahaya</h3>
        </div>
        <div class="dz-body">
            <p>Hapus link <strong>{{ $linkCepat->label }}</strong> secara permanen. Tindakan ini <strong>tidak bisa dibatalkan</strong>.</p>
            <form action="{{ route('admin.link-cepat.destroy', $linkCepat) }}" method="POST" id="del-form">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmHapus()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6m5 0V4a1 1 0 011-1h2a1 1 0 011 1v2"/></svg>
                    Hapus Link
                </button>
            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    const saveDot    = document.getElementById('save-dot');
    const saveStatus = document.getElementById('save-status');
    let isDirty = false;

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

    function markDirty() {
        isDirty = true;
        saveDot.classList.add('blink');
        saveDot.classList.remove('saved');
    }

    [labelInput, urlInput].forEach(el => el.addEventListener('input', () => { markDirty(); updatePreview(); }));
    tabToggle.addEventListener('change', () => { markDirty(); updatePreview(); });

    document.querySelectorAll('.ikon-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.ikon-btn').forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
            ikonHidden.value = btn.dataset.ikon;
            ikonCustom.value = '';
            markDirty(); updatePreview();
        });
    });
    ikonCustom.addEventListener('input', () => {
        if (ikonCustom.value) {
            document.querySelectorAll('.ikon-btn').forEach(b => b.classList.remove('selected'));
            ikonHidden.value = ikonCustom.value;
            markDirty(); updatePreview();
        }
    });

    function applyColor(hex) {
        warnaHidden.value = hex;
        chex.value = hex.toUpperCase();
        cpicker.value = hex;
        document.querySelectorAll('.cswatch').forEach(s => s.classList.toggle('sel', s.dataset.color === hex));
        markDirty(); updatePreview();
    }
    document.querySelectorAll('.cswatch').forEach(s => s.addEventListener('click', () => applyColor(s.dataset.color)));
    cpicker.addEventListener('input', () => applyColor(cpicker.value));
    chex.addEventListener('input', () => { if (/^#[0-9a-fA-F]{6}$/.test(chex.value)) applyColor(chex.value); });

    const urutanInput = document.getElementById('urutan');
    document.getElementById('step-inc').addEventListener('click', () => { urutanInput.value = parseInt(urutanInput.value||0)+1; markDirty(); });
    document.getElementById('step-dec').addEventListener('click', () => { urutanInput.value = Math.max(0,parseInt(urutanInput.value||0)-1); markDirty(); });

    document.getElementById('lc-form').addEventListener('submit', () => {
        isDirty = false;
        saveDot.classList.remove('blink');
        saveDot.classList.add('saved');
        saveStatus.textContent = 'Menyimpan…';
    });

    window.addEventListener('beforeunload', e => { if (isDirty) { e.preventDefault(); e.returnValue = ''; } });

    const initColor = warnaHidden.value;
    if (initColor) applyColor(initColor);
    updatePreview();
});

function confirmHapus() {
    Swal.fire({
        title: 'Hapus Link?',
        html: 'Link <strong>{{ addslashes($linkCepat->label) }}</strong> akan dihapus permanen dan tidak bisa dipulihkan.',
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) document.getElementById('del-form').submit(); });
}

@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
@endif
</script>
</x-app-layout>