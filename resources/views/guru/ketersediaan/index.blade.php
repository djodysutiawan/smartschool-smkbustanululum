<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);
        --shadow:0 4px 16px rgba(0,0,0,.07);
    }

    .page{padding:28px 28px 48px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s,box-shadow .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff;box-shadow:0 2px 8px rgba(31,99,219,.22)}
    .btn-primary:hover{filter:brightness(.92);box-shadow:0 4px 12px rgba(31,99,219,.3)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 12px;font-size:12px;border-radius:6px}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}

    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 18px;display:flex;align-items:center;gap:14px;transition:box-shadow .2s,transform .2s;cursor:default;box-shadow:var(--shadow-sm)}
    .stat-card:hover{box-shadow:var(--shadow);transform:translateY(-1px)}
    .stat-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.blue  {background:#eff6ff}
    .stat-icon.green {background:#f0fdf4}
    .stat-icon.red   {background:#fff0f0}
    .stat-icon.yellow{background:#fefce8}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;font-weight:800;color:var(--text);line-height:1.1;margin-top:2px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:2px;font-family:'DM Sans',sans-serif}

    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:18px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;line-height:1.5}
    .alert-info{background:#eff6ff;border:1px solid #bfdbfe;color:#1e40af}

    .main-grid{display:grid;grid-template-columns:320px 1fr;gap:16px;align-items:start}

    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;position:sticky;top:16px;box-shadow:var(--shadow-sm)}
    .form-card-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;background:var(--surface2)}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .form-card-body{padding:20px}
    .field{display:flex;flex-direction:column;gap:5px;margin-bottom:14px}
    .field:last-of-type{margin-bottom:0}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text2)}
    .field label .req{color:#dc2626}
    .field select,.field input[type=time]{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s,box-shadow .15s;width:100%;box-sizing:border-box}
    .field select:focus,.field input[type=time]:focus{border-color:var(--brand-500);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1)}
    .field-hint{font-size:11.5px;color:var(--text3);margin-top:2px;font-family:'DM Sans',sans-serif}
    .field-error{font-size:11.5px;color:#dc2626;margin-top:2px;font-family:'DM Sans',sans-serif}

    .toggle-wrap{display:flex;align-items:center;justify-content:space-between;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:10px 14px;transition:border-color .15s}
    .toggle-wrap:has(input[type=checkbox]:checked){border-color:#bbf7d0;background:#f0fdf4}
    .toggle-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .toggle-sub{font-size:11.5px;color:var(--text3);margin-top:1px;font-family:'DM Sans',sans-serif}
    .toggle-switch{position:relative;width:40px;height:22px;flex-shrink:0}
    .toggle-switch input{opacity:0;width:0;height:0;position:absolute}
    .toggle-slider{position:absolute;inset:0;background:var(--border2);border-radius:99px;cursor:pointer;transition:background .2s}
    .toggle-slider:before{content:'';position:absolute;width:16px;height:16px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.15)}
    .toggle-switch input[type=checkbox]:checked + .toggle-slider{background:#15803d}
    .toggle-switch input[type=checkbox]:checked + .toggle-slider:before{transform:translateX(18px)}
    .form-divider{border:none;border-top:1px solid var(--border);margin:16px 0}
    .btn-submit{width:100%;height:40px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s,box-shadow .15s;display:flex;align-items:center;justify-content:center;gap:6px;box-shadow:0 2px 8px rgba(31,99,219,.2)}
    .btn-submit:hover{background:var(--brand-700);box-shadow:0 4px 12px rgba(31,99,219,.3)}
    .btn-submit:disabled{opacity:.6;cursor:not-allowed;box-shadow:none}

    .hari-section{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:10px;box-shadow:var(--shadow-sm)}
    .hari-section:last-child{margin-bottom:0}
    .hari-head{display:flex;align-items:center;justify-content:space-between;padding:13px 18px;background:var(--surface2);border-bottom:1px solid transparent;cursor:pointer;user-select:none;transition:background .15s}
    .hari-head:hover{background:var(--surface3)}
    .hari-section.open .hari-head{border-bottom-color:var(--border)}
    .hari-head-left{display:flex;align-items:center;gap:10px}
    .hari-dot{width:8px;height:8px;border-radius:50%;background:var(--border2);transition:background .2s;flex-shrink:0}
    .hari-dot.has-data{background:#15803d}
    .hari-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);text-transform:capitalize}
    .hari-count-pill{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);background:var(--surface3);border:1px solid var(--border);padding:2px 9px;border-radius:99px}
    .hari-count-pill.has-data{background:#dcfce7;color:#15803d;border-color:#bbf7d0}
    .hari-chevron{transition:transform .25s;color:var(--text3);flex-shrink:0}
    .hari-section.open .hari-chevron{transform:rotate(180deg)}
    .hari-body{padding:14px 18px;display:flex;flex-direction:column;gap:10px}
    .hari-body.collapsed{display:none}

    .slot-card{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm);padding:12px 14px;display:flex;align-items:center;justify-content:space-between;gap:12px;transition:box-shadow .15s,border-color .15s}
    .slot-card:hover{box-shadow:0 2px 8px rgba(31,99,219,.12);border-color:var(--brand-500)}
    .slot-card.tidak-tersedia{background:var(--surface2);border-color:var(--border)}
    .slot-card.tidak-tersedia:hover{box-shadow:0 2px 8px rgba(0,0,0,.06);border-color:var(--border2)}
    .slot-left{display:flex;align-items:center;gap:10px;min-width:0}
    .slot-time-badge{background:var(--brand-600);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;padding:6px 11px;border-radius:7px;white-space:nowrap;flex-shrink:0}
    .slot-card.tidak-tersedia .slot-time-badge{background:var(--text3)}
    .slot-meta{min-width:0}
    .slot-dur{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3)}
    .slot-actions{display:flex;gap:5px;align-items:center;flex-shrink:0}

    .slot-empty{padding:14px 0;text-align:center;font-size:12.5px;color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-style:italic}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-tersedia{background:#dcfce7;color:#15803d}
    .badge-tersedia .badge-dot{background:#15803d}
    .badge-tidak{background:var(--surface3);color:var(--text2);border:1px solid var(--border)}
    .badge-tidak .badge-dot{background:var(--text3)}

    .empty-full{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:60px 20px;text-align:center;box-shadow:var(--shadow-sm)}
    .empty-full-icon{width:60px;height:60px;background:var(--surface2);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px}
    .empty-full-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:15px;color:var(--text);margin-bottom:6px}
    .empty-full-sub{font-size:13px;color:var(--text3);font-family:'DM Sans',sans-serif}

    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.5);z-index:300;align-items:center;justify-content:center;padding:16px;backdrop-filter:blur(2px)}
    .modal-overlay.active{display:flex}
    .modal{background:var(--surface);border-radius:14px;width:420px;max-width:100%;box-shadow:0 24px 64px rgba(0,0,0,.18);overflow:hidden;animation:modalIn .2s ease}
    @keyframes modalIn{from{opacity:0;transform:translateY(12px) scale(.97)}to{opacity:1;transform:none}}
    .modal-header{display:flex;align-items:center;justify-content:space-between;padding:16px 22px;border-bottom:1px solid var(--border)}
    .modal-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text)}
    .modal-close{width:30px;height:30px;display:flex;align-items:center;justify-content:center;border:none;background:var(--surface2);border-radius:7px;cursor:pointer;color:var(--text3);transition:background .15s,color .15s}
    .modal-close:hover{background:var(--surface3);color:var(--text)}
    .modal-body{padding:22px}
    .modal-footer{display:flex;gap:8px;justify-content:flex-end;padding:14px 22px;border-top:1px solid var(--border);background:var(--surface2)}

    @keyframes spin{to{transform:rotate(360deg)}}

    @media(max-width:900px){
        .main-grid{grid-template-columns:1fr}
        .form-card{position:static}
        .stats-strip{grid-template-columns:1fr 1fr}
    }
    @media(max-width:640px){
        .page{padding:16px 14px 40px}
        .stats-strip{grid-template-columns:1fr 1fr;gap:8px}
        .stat-val{font-size:20px}
    }
</style>

{{-- ══ CSRF token untuk JS ══ --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Ketersediaan Saya</h1>
            <p class="page-sub">Atur slot waktu ketersediaan mengajar Anda setiap minggu</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Slot</p>
                <p class="stat-val">{{ $stats['total'] }}</p>
                <p class="stat-sub">semua hari</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Tersedia</p>
                <p class="stat-val">{{ $stats['tersedia'] }}</p>
                <p class="stat-sub">slot aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div>
                <p class="stat-label">Tidak Tersedia</p>
                <p class="stat-val">{{ $stats['tidak'] }}</p>
                <p class="stat-sub">slot diblokir</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Hari Diisi</p>
                <p class="stat-val">{{ $stats['hari_diisi'] }}</p>
                <p class="stat-sub">dari {{ count($hariList) }} hari</p>
            </div>
        </div>
    </div>

    {{-- Info tip --}}
    <div class="alert alert-info">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>Data ketersediaan ini digunakan admin untuk menyusun jadwal mengajar. Pastikan slot yang Anda isi sudah sesuai dengan waktu luang Anda.</span>
    </div>

    <div class="main-grid">

        {{-- ══ Form Tambah (kiri, sticky) ══ --}}
        <div>
            <div class="form-card" id="formCard">
                <div class="form-card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    <span class="form-card-title">Tambah Slot Ketersediaan</span>
                </div>
                <div class="form-card-body">
                    <form action="{{ route('guru.ketersediaan.store') }}" method="POST"
                          id="formTambah" onsubmit="return handleSubmitTambah(this)">
                        @csrf

                        <div class="field">
                            <label for="hariSelect">Hari <span class="req">*</span></label>
                            <select name="hari" id="hariSelect" required>
                                <option value="">— Pilih Hari —</option>
                                @foreach($hariList as $h)
                                    <option value="{{ $h }}" {{ old('hari') === $h ? 'selected' : '' }}>
                                        {{ ucfirst($h) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hari')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="jamMulai">Jam Mulai <span class="req">*</span></label>
                            <input type="time" name="jam_mulai" id="jamMulai"
                                   value="{{ old('jam_mulai', '07:00') }}" required>
                            @error('jam_mulai')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="jamSelesai">Jam Selesai <span class="req">*</span></label>
                            <input type="time" name="jam_selesai" id="jamSelesai"
                                   value="{{ old('jam_selesai', '08:00') }}" required>
                            <span class="field-hint">Harus setelah jam mulai</span>
                            @error('jam_selesai')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="field">
                            <div class="toggle-wrap">
                                <div>
                                    <p class="toggle-label">Tersedia</p>
                                    <p class="toggle-sub">Aktifkan jika slot ini tersedia</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="hidden" name="tersedia" value="0">
                                    <input type="checkbox" name="tersedia" value="1"
                                           id="tersediaCheck"
                                           {{ old('tersedia', '1') == '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                        <hr class="form-divider">

                        <button type="submit" class="btn-submit" id="btnTambah">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah Slot
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ══ Daftar Per Hari (kanan) ══ --}}
        <div id="daftarHari">

            @if(! $adaSlot)
                <div class="empty-full">
                    <div class="empty-full-icon">
                        <svg width="26" height="26" fill="none" stroke="#94a3b8" stroke-width="1.6" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <p class="empty-full-title">Belum ada slot ketersediaan</p>
                    <p class="empty-full-sub">Tambahkan slot menggunakan form di samping</p>
                </div>
            @else
                @foreach($hariList as $hari)
                    @php
                        $slots   = $ketersediaan->get($hari, collect());
                        $hasData = $slots->count() > 0;
                    @endphp
                    <div class="hari-section {{ $hasData ? 'open' : '' }}" id="section-{{ $hari }}">

                        <div class="hari-head"
                             onclick="toggleHari('{{ $hari }}')"
                             role="button"
                             tabindex="0"
                             aria-expanded="{{ $hasData ? 'true' : 'false' }}"
                             aria-controls="body-{{ $hari }}"
                             onkeydown="if(event.key==='Enter'||event.key===' ')toggleHari('{{ $hari }}')">
                            <div class="hari-head-left">
                                <span class="hari-dot {{ $hasData ? 'has-data' : '' }}"></span>
                                <span class="hari-name">{{ ucfirst($hari) }}</span>
                                <span class="hari-count-pill {{ $hasData ? 'has-data' : '' }}"
                                      id="pill-{{ $hari }}">
                                    {{ $slots->count() }} slot
                                </span>
                            </div>
                            <svg class="hari-chevron"
                                 width="14" height="14" fill="none" stroke="currentColor"
                                 stroke-width="2.5" viewBox="0 0 24 24"
                                 style="{{ $hasData ? 'transform:rotate(180deg)' : '' }}">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </div>

                        <div class="hari-body {{ $hasData ? '' : 'collapsed' }}" id="body-{{ $hari }}">

                            @forelse($slots->sortBy('jam_mulai') as $slot)
                                @php
                                    $mulaiFormatted   = \Carbon\Carbon::parse($slot->jam_mulai)->format('H:i');
                                    $selesaiFormatted = \Carbon\Carbon::parse($slot->jam_selesai)->format('H:i');
                                    $dur = \Carbon\Carbon::parse($slot->jam_mulai)
                                               ->diffInMinutes(\Carbon\Carbon::parse($slot->jam_selesai));
                                @endphp
                                <div class="slot-card {{ $slot->tersedia ? '' : 'tidak-tersedia' }}">
                                    <div class="slot-left">
                                        <span class="slot-time-badge">
                                            {{ $mulaiFormatted }} – {{ $selesaiFormatted }}
                                        </span>
                                        <div class="slot-meta">
                                            <p class="slot-dur">{{ $dur }} menit</p>
                                            @if($slot->tersedia)
                                                <span class="badge badge-tersedia" style="margin-top:3px">
                                                    <span class="badge-dot"></span>Tersedia
                                                </span>
                                            @else
                                                <span class="badge badge-tidak" style="margin-top:3px">
                                                    <span class="badge-dot"></span>Tidak Tersedia
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="slot-actions">
                                        {{-- Tombol Edit --}}
                                        <button type="button"
                                                class="btn btn-sm btn-edit"
                                                data-id="{{ $slot->id }}"
                                                data-hari="{{ $slot->hari }}"
                                                data-mulai="{{ $mulaiFormatted }}"
                                                data-selesai="{{ $selesaiFormatted }}"
                                                data-tersedia="{{ $slot->tersedia ? '1' : '0' }}"
                                                onclick="openEdit(this)">
                                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4Z"/></svg>
                                            Edit
                                        </button>

                                        {{--
                                            FIX BUG DELETE:
                                            Tidak lagi menggunakan <form> + getElementById().submit().
                                            Semua data disimpan di data-* attribute tombol.
                                            JS akan membuat form baru secara programatik dan submit-nya.
                                            Ini menghilangkan risiko:
                                            1. ID form bentrok antar-slot
                                            2. getElementById gagal menemukan form karena DOM issue
                                            3. _method DELETE tidak terkirim
                                        --}}
                                        <button type="button"
                                                class="btn btn-sm btn-del"
                                                data-id="{{ $slot->id }}"
                                                data-hari="{{ ucfirst($slot->hari) }}"
                                                data-jam="{{ $mulaiFormatted }}"
                                                data-url="{{ route('guru.ketersediaan.destroy', $slot->id) }}"
                                                onclick="confirmDelete(this)">
                                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <p class="slot-empty">Tidak ada slot untuk hari ini</p>
                            @endforelse

                            <button type="button"
                                    class="btn btn-secondary btn-sm"
                                    style="align-self:flex-start;margin-top:4px"
                                    onclick="prefillHari('{{ $hari }}')">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                Tambah slot {{ ucfirst($hari) }}
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</div>

{{-- ══ Modal Edit ══ --}}
<div class="modal-overlay" id="editModal" role="dialog" aria-modal="true" aria-labelledby="editModalTitle">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title" id="editModalTitle">Edit Slot Ketersediaan</span>
            <button type="button" class="modal-close" onclick="closeEdit()" aria-label="Tutup">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="editForm" method="POST" onsubmit="return handleSubmitEdit(this)">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="field">
                    <label for="editHari">Hari <span class="req">*</span></label>
                    <select name="hari" id="editHari" required>
                        @foreach($hariList as $h)
                            <option value="{{ $h }}">{{ ucfirst($h) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="editMulai">Jam Mulai <span class="req">*</span></label>
                    <input type="time" name="jam_mulai" id="editMulai" required>
                </div>
                <div class="field">
                    <label for="editSelesai">Jam Selesai <span class="req">*</span></label>
                    <input type="time" name="jam_selesai" id="editSelesai" required>
                    <span class="field-hint">Harus setelah jam mulai</span>
                    <span class="field-error" id="editTimeError" style="display:none"></span>
                </div>
                <div class="field" style="margin-bottom:0">
                    <div class="toggle-wrap">
                        <div>
                            <p class="toggle-label">Tersedia</p>
                            <p class="toggle-sub">Aktifkan jika slot ini tersedia</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="hidden" name="tersedia" value="0">
                            <input type="checkbox" name="tersedia" id="editTersedia" value="1">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEdit()">Batal</button>
                <button type="submit" class="btn btn-primary" id="btnSimpanEdit">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SweetAlert2 HARUS di-load sebelum script inline --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
/* ── Helper: ambil CSRF token dari meta tag ──────────────────────────────── */
function getCsrf() {
    var meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

/* ── Flash notifications (jalankan setelah DOM ready) ───────────────────── */
document.addEventListener('DOMContentLoaded', function () {

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: @json(session('success')),
        timer: 2800,
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
        timerProgressBar: true,
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: @json(session('error')),
        confirmButtonColor: '#1f63db',
    });
    @endif

    @if($errors->any())
    Swal.fire({
        icon: 'warning',
        title: 'Perhatian!',
        html: @json('<ul style="text-align:left;padding-left:16px">' . implode('', array_map(fn($e) => '<li>' . e($e) . '</li>', $errors->all())) . '</ul>'),
        confirmButtonColor: '#1f63db',
    });
    @endif

});

/* ── Accordion ────────────────────────────────────────────────────────────── */
function toggleHari(hari) {
    var section = document.getElementById('section-' + hari);
    var body    = document.getElementById('body-' + hari);
    var head    = section.querySelector('.hari-head');
    var isOpen  = section.classList.contains('open');

    section.classList.toggle('open', !isOpen);
    body.classList.toggle('collapsed', isOpen);
    head.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
}

/* ── Prefill hari & scroll ke form ───────────────────────────────────────── */
function prefillHari(hari) {
    var sel = document.getElementById('hariSelect');
    if (sel) {
        sel.value = hari;
        var formCard = document.getElementById('formCard');
        if (formCard) {
            formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        setTimeout(function () { sel.focus(); }, 400);
    }
}

/* ── FIX: Confirm + Delete menggunakan form programatik ─────────────────── */
/*
    KENAPA INI FIX-NYA?
    Versi lama menggunakan getElementById('del-X').submit() yang bisa gagal karena:
    1. SweetAlert2 memindahkan fokus DOM, terkadang menyebabkan referensi form hilang
    2. Urutan load script membuat Swal belum siap saat onclick dipanggil
    3. Form dengan @method('DELETE') di dalam loop forelse bisa punya ID yang
       tidak ter-render dengan benar jika ada error Blade sebelumnya

    Solusi: buat form baru secara programatik di dalam callback .then(),
    inject _token dan _method sebagai hidden input, lalu append ke body dan submit.
    Form ini 100% fresh, tidak bergantung pada DOM yang sudah ada di halaman.
*/
function confirmDelete(btn) {
    var hari = btn.getAttribute('data-hari');
    var jam  = btn.getAttribute('data-jam');
    var url  = btn.getAttribute('data-url');

    Swal.fire({
        title: 'Hapus Slot?',
        html: 'Slot <strong>' + hari + '</strong> jam <strong>' + jam +
              '</strong> akan dihapus permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
    }).then(function (result) {
        if (!result.isConfirmed) return;

        /* Buat form baru secara programatik */
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = url;
        form.style.display = 'none';

        /* _token (CSRF) */
        var inputToken = document.createElement('input');
        inputToken.type  = 'hidden';
        inputToken.name  = '_token';
        inputToken.value = getCsrf();
        form.appendChild(inputToken);

        /* _method spoofing DELETE untuk Laravel */
        var inputMethod = document.createElement('input');
        inputMethod.type  = 'hidden';
        inputMethod.name  = '_method';
        inputMethod.value = 'DELETE';
        form.appendChild(inputMethod);

        /* Append ke body, submit, lalu bersihkan */
        document.body.appendChild(form);
        form.submit();
    });
}

/* ── Modal Edit ──────────────────────────────────────────────────────────── */
function openEdit(btn) {
    var id       = btn.getAttribute('data-id');
    var hari     = btn.getAttribute('data-hari');
    var mulai    = btn.getAttribute('data-mulai');
    var selesai  = btn.getAttribute('data-selesai');
    var tersedia = btn.getAttribute('data-tersedia') === '1';

    /* Set action URL ke route update dengan ID yang benar */
    var baseUrl = '{{ rtrim(url("guru/ketersediaan"), "/") }}/';
    document.getElementById('editForm').action = baseUrl + id;

    document.getElementById('editHari').value              = hari;
    document.getElementById('editMulai').value             = mulai;
    document.getElementById('editSelesai').value           = selesai;
    document.getElementById('editTersedia').checked        = tersedia;
    document.getElementById('editTimeError').style.display = 'none';

    var btn2 = document.getElementById('btnSimpanEdit');
    btn2.disabled = false;
    btn2.innerHTML =
        '<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">' +
        '<path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>' +
        '<polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>' +
        ' Simpan Perubahan';
    btn2.style.opacity = '1';

    document.getElementById('editModal').classList.add('active');
    setTimeout(function () { document.getElementById('editHari').focus(); }, 100);
}

function closeEdit() {
    document.getElementById('editModal').classList.remove('active');
}

/* Tutup saat klik overlay */
document.getElementById('editModal').addEventListener('click', function (e) {
    if (e.target === this) closeEdit();
});

/* Tutup saat tekan Escape */
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeEdit();
});

/* ── Validasi client-side form edit ─────────────────────────────────────── */
function handleSubmitEdit(form) {
    var mulai   = document.getElementById('editMulai').value;
    var selesai = document.getElementById('editSelesai').value;
    var errEl   = document.getElementById('editTimeError');

    if (mulai && selesai && selesai <= mulai) {
        errEl.textContent   = 'Jam selesai harus setelah jam mulai.';
        errEl.style.display = 'block';
        document.getElementById('editSelesai').focus();
        return false;
    }

    errEl.style.display = 'none';
    var btn = document.getElementById('btnSimpanEdit');
    btn.disabled  = true;
    btn.innerHTML =
        '<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" ' +
        'viewBox="0 0 24 24" style="animation:spin .8s linear infinite">' +
        '<path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan\u2026';
    btn.style.opacity = '0.8';
    return true;
}

/* ── Validasi client-side form tambah ───────────────────────────────────── */
function handleSubmitTambah(form) {
    var mulai   = document.getElementById('jamMulai').value;
    var selesai = document.getElementById('jamSelesai').value;

    if (mulai && selesai && selesai <= mulai) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian!',
            text: 'Jam selesai harus setelah jam mulai.',
            confirmButtonColor: '#1f63db',
        });
        return false;
    }

    var btn = document.getElementById('btnTambah');
    btn.disabled  = true;
    btn.innerHTML =
        '<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" ' +
        'viewBox="0 0 24 24" style="animation:spin .8s linear infinite">' +
        '<path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan\u2026';
    btn.style.opacity = '0.8';
    return true;
}
</script>
</x-app-layout>