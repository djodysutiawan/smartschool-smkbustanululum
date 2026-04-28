<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    /* ── Layout ── */
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    /* ── Buttons ── */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}

    /* ── Stats ── */
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.blue{background:#eff6ff}
    .stat-icon.green{background:#f0fdf4}
    .stat-icon.red{background:#fff0f0}
    .stat-icon.yellow{background:#fefce8}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    /* ── Info alert ── */
    .alert{display:flex;align-items:flex-start;gap:10px;padding:11px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600}
    .alert-info{background:#eff6ff;border:1px solid #bfdbfe;color:#1e40af}
    .alert-warning{background:#fffbeb;border:1px solid #fde68a;color:#92400e}

    /* ── Layout grid: form kiri, tabel kanan ── */
    .main-grid{display:grid;grid-template-columns:320px 1fr;gap:16px;align-items:start}

    /* ── Form card ── */
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;position:sticky;top:16px}
    .form-card-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;background:var(--surface2)}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .form-card-body{padding:20px}
    .field{display:flex;flex-direction:column;gap:5px;margin-bottom:14px}
    .field:last-of-type{margin-bottom:0}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text2)}
    .field label .req{color:#dc2626}
    .field select,.field input[type=time]{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%}
    .field select:focus,.field input[type=time]:focus{border-color:var(--brand-500);background:#fff}
    .field-hint{font-size:11.5px;color:var(--text3);margin-top:2px}
    .toggle-wrap{display:flex;align-items:center;justify-content:space-between;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:10px 14px}
    .toggle-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .toggle-sub{font-size:11.5px;color:var(--text3);margin-top:1px}
    .toggle-switch{position:relative;width:40px;height:22px;flex-shrink:0}
    .toggle-switch input{opacity:0;width:0;height:0}
    .toggle-slider{position:absolute;inset:0;background:var(--border2);border-radius:99px;cursor:pointer;transition:background .2s}
    .toggle-slider:before{content:'';position:absolute;width:16px;height:16px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:transform .2s}
    .toggle-switch input:checked + .toggle-slider{background:#15803d}
    .toggle-switch input:checked + .toggle-slider:before{transform:translateX(18px)}
    .form-divider{border:none;border-top:1px solid var(--border);margin:16px 0}
    .btn-submit{width:100%;height:38px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;display:flex;align-items:center;justify-content:center;gap:6px}
    .btn-submit:hover{background:var(--brand-700)}

    /* ── Weekly panel ── */
    .hari-section{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:12px}
    .hari-section:last-child{margin-bottom:0}
    .hari-head{display:flex;align-items:center;justify-content:space-between;padding:12px 18px;background:var(--surface2);border-bottom:1px solid var(--border);cursor:pointer;user-select:none}
    .hari-head-left{display:flex;align-items:center;gap:10px}
    .hari-dot{width:8px;height:8px;border-radius:50%;background:var(--text3)}
    .hari-dot.has-data{background:#15803d}
    .hari-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);text-transform:capitalize}
    .hari-count-pill{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);background:var(--surface3);padding:2px 9px;border-radius:99px}
    .hari-count-pill.has-data{background:#dcfce7;color:#15803d}
    .hari-chevron{transition:transform .2s;color:var(--text3)}
    .hari-body{padding:14px 18px;display:flex;flex-direction:column;gap:10px}
    .hari-body.collapsed{display:none}

    /* ── Slot card ── */
    .slot-card{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm);padding:12px 14px;display:flex;align-items:center;justify-content:space-between;gap:12px}
    .slot-card.tidak-tersedia{background:var(--surface2);border-color:var(--border);opacity:.8}
    .slot-left{display:flex;align-items:center;gap:10px}
    .slot-time-badge{background:var(--brand-600);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;padding:5px 10px;border-radius:6px;white-space:nowrap}
    .slot-card.tidak-tersedia .slot-time-badge{background:var(--text3)}
    .slot-dur{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3)}
    .slot-actions{display:flex;gap:5px;align-items:center}

    /* ── Slot empty ── */
    .slot-empty{padding:16px 0;text-align:center;font-size:12.5px;color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600}

    /* ── Modal edit ── */
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:300;align-items:center;justify-content:center}
    .modal-overlay.active{display:flex}
    .modal{background:var(--surface);border-radius:var(--radius);width:400px;max-width:calc(100vw - 32px);box-shadow:0 20px 60px rgba(0,0,0,.15);overflow:hidden}
    .modal-header{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border)}
    .modal-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text)}
    .modal-close{width:28px;height:28px;display:flex;align-items:center;justify-content:center;border:none;background:var(--surface2);border-radius:6px;cursor:pointer;color:var(--text3)}
    .modal-close:hover{background:var(--surface3)}
    .modal-body{padding:20px}
    .modal-footer{display:flex;gap:8px;justify-content:flex-end;padding:14px 20px;border-top:1px solid var(--border);background:var(--surface2)}

    /* ── Badges ── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%}
    .badge-tersedia{background:#dcfce7;color:#15803d} .badge-tersedia .badge-dot{background:#15803d}
    .badge-tidak{background:var(--surface3);color:var(--text2)} .badge-tidak .badge-dot{background:var(--text3)}

    @media(max-width:900px){
        .main-grid{grid-template-columns:1fr}
        .form-card{position:static}
        .stats-strip{grid-template-columns:1fr 1fr}
        .page{padding:16px}
    }
</style>

<div class="page">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Ketersediaan Saya</h1>
            <p class="page-sub">Atur slot waktu ketersediaan mengajar Anda setiap minggu</p>
        </div>
    </div>

    {{-- ── Stats ── --}}
    @php
        $allSlot      = $ketersediaan->flatten();
        $totalSlot    = $allSlot->count();
        $totalTersedia= $allSlot->where('tersedia', true)->count();
        $totalTidak   = $allSlot->where('tersedia', false)->count();
        $totalHari    = $ketersediaan->keys()->count();
    @endphp
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Slot</p>
                <p class="stat-val">{{ $totalSlot }}</p>
                <p class="stat-sub">semua hari</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Tersedia</p>
                <p class="stat-val">{{ $totalTersedia }}</p>
                <p class="stat-sub">slot aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div>
                <p class="stat-label">Tidak Tersedia</p>
                <p class="stat-val">{{ $totalTidak }}</p>
                <p class="stat-sub">slot diblokir</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Hari Diisi</p>
                <p class="stat-val">{{ $totalHari }}</p>
                <p class="stat-sub">dari 6 hari</p>
            </div>
        </div>
    </div>

    {{-- ── Tip ── --}}
    <div class="alert alert-info">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>Data ketersediaan ini digunakan admin untuk menyusun jadwal mengajar. Pastikan slot yang Anda isi sudah sesuai dengan waktu luang Anda.</span>
    </div>

    <div class="main-grid">

        {{-- ══ Form Tambah (kiri) ══ --}}
        <div>
            <div class="form-card">
                <div class="form-card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    <span class="form-card-title">Tambah Slot Ketersediaan</span>
                </div>
                <div class="form-card-body">
                    <form action="{{ route('guru.ketersediaan.store') }}" method="POST">
                        @csrf

                        <div class="field">
                            <label>Hari <span class="req">*</span></label>
                            <select name="hari" required>
                                <option value="">— Pilih Hari —</option>
                                @foreach($hariList as $h)
                                    <option value="{{ $h }}" {{ old('hari') === $h ? 'selected' : '' }}>
                                        {{ ucfirst($h) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label>Jam Mulai <span class="req">*</span></label>
                            <input type="time" name="jam_mulai" value="{{ old('jam_mulai', '07:00') }}" required>
                        </div>

                        <div class="field">
                            <label>Jam Selesai <span class="req">*</span></label>
                            <input type="time" name="jam_selesai" value="{{ old('jam_selesai', '08:00') }}" required>
                            <span class="field-hint">Harus setelah jam mulai</span>
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
                                           {{ old('tersedia', '1') == '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                        <hr class="form-divider">

                        <button type="submit" class="btn-submit">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah Slot
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ══ Daftar Per Hari (kanan) ══ --}}
        <div>
            @if($ketersediaan->isEmpty() && $totalSlot === 0)
                <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:60px 20px;text-align:center">
                    <div style="width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px">
                        <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px">Belum ada slot ketersediaan</p>
                    <p style="font-size:13px;color:var(--text3)">Tambahkan slot menggunakan form di samping</p>
                </div>
            @else
                @foreach($hariList as $hari)
                    @php $slots = $ketersediaan->get($hari, collect()); @endphp
                    <div class="hari-section">
                        <div class="hari-head" onclick="toggleHari('{{ $hari }}')">
                            <div class="hari-head-left">
                                <span class="hari-dot {{ $slots->count() > 0 ? 'has-data' : '' }}"></span>
                                <span class="hari-name">{{ ucfirst($hari) }}</span>
                                <span class="hari-count-pill {{ $slots->count() > 0 ? 'has-data' : '' }}">
                                    {{ $slots->count() }} slot
                                </span>
                            </div>
                            <svg class="hari-chevron" id="chevron-{{ $hari }}" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>

                        <div class="hari-body" id="body-{{ $hari }}">
                            @forelse($slots as $slot)
                                @php
                                    $dur = \Carbon\Carbon::parse($slot->jam_mulai)->diffInMinutes(\Carbon\Carbon::parse($slot->jam_selesai));
                                @endphp
                                <div class="slot-card {{ $slot->tersedia ? '' : 'tidak-tersedia' }}">
                                    <div class="slot-left">
                                        <span class="slot-time-badge">
                                            {{ \Carbon\Carbon::parse($slot->jam_mulai)->format('H:i') }}
                                            –
                                            {{ \Carbon\Carbon::parse($slot->jam_selesai)->format('H:i') }}
                                        </span>
                                        <div>
                                            <p class="slot-dur">{{ $dur }} menit</p>
                                            @if($slot->tersedia)
                                                <span class="badge badge-tersedia" style="margin-top:3px"><span class="badge-dot"></span>Tersedia</span>
                                            @else
                                                <span class="badge badge-tidak" style="margin-top:3px"><span class="badge-dot"></span>Tidak Tersedia</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="slot-actions">
                                        <button type="button"
                                            class="btn btn-sm btn-edit"
                                            onclick="openEdit({{ $slot->id }}, '{{ $slot->hari }}', '{{ \Carbon\Carbon::parse($slot->jam_mulai)->format('H:i') }}', '{{ \Carbon\Carbon::parse($slot->jam_selesai)->format('H:i') }}', {{ $slot->tersedia ? 'true' : 'false' }})">
                                            Edit
                                        </button>
                                        <form action="{{ route('guru.ketersediaan.destroy', $slot->id) }}" method="POST"
                                              id="del-{{ $slot->id }}" style="display:inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-del"
                                                onclick="confirmDelete(
                                                    document.getElementById('del-{{ $slot->id }}'),
                                                    '{{ ucfirst($slot->hari) }}',
                                                    '{{ \Carbon\Carbon::parse($slot->jam_mulai)->format('H:i') }}'
                                                )">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="slot-empty">Tidak ada slot untuk hari ini</p>
                            @endforelse

                            {{-- Quick-add link ke form --}}
                            <button type="button"
                                class="btn btn-secondary btn-sm"
                                style="align-self:flex-start;margin-top:2px"
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
<div class="modal-overlay" id="editModal">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Edit Slot Ketersediaan</span>
            <button type="button" class="modal-close" onclick="closeEdit()">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="field">
                    <label>Hari <span class="req">*</span></label>
                    <select name="hari" id="editHari" required>
                        @foreach($hariList as $h)
                            <option value="{{ $h }}">{{ ucfirst($h) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Jam Mulai <span class="req">*</span></label>
                    <input type="time" name="jam_mulai" id="editMulai" required>
                </div>
                <div class="field">
                    <label>Jam Selesai <span class="req">*</span></label>
                    <input type="time" name="jam_selesai" id="editSelesai" required>
                    <span class="field-hint">Harus setelah jam mulai</span>
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
                <button type="submit" class="btn btn-primary">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
/* ── Toast / error notifications ── */
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif
@if($errors->any())
Swal.fire({ icon:'warning', title:'Perhatian!', html:`{!! implode('<br>', $errors->all()) !!}`, confirmButtonColor:'#1f63db' });
@endif

/* ── Accordion hari ── */
const openHari = new Set();

function toggleHari(hari) {
    const body    = document.getElementById('body-' + hari);
    const chevron = document.getElementById('chevron-' + hari);
    if (openHari.has(hari)) {
        body.classList.add('collapsed');
        chevron.style.transform = '';
        openHari.delete(hari);
    } else {
        body.classList.remove('collapsed');
        chevron.style.transform = 'rotate(180deg)';
        openHari.add(hari);
    }
}

/* Auto-buka hari yang punya slot */
document.addEventListener('DOMContentLoaded', function () {
    @foreach($hariList as $h)
        @if($ketersediaan->has($h) && $ketersediaan->get($h)->count() > 0)
            toggleHari('{{ $h }}');
        @endif
    @endforeach
});

/* ── Prefill hari di form tambah ── */
function prefillHari(hari) {
    const sel = document.querySelector('select[name="hari"]');
    if (sel) {
        sel.value = hari;
        sel.scrollIntoView({ behavior: 'smooth', block: 'center' });
        sel.focus();
    }
}

/* ── Confirm delete ── */
function confirmDelete(form, hari, jam) {
    Swal.fire({
        title: 'Hapus Slot?',
        html: `Slot <strong>${hari}</strong> jam <strong>${jam}</strong> akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) form.submit(); });
}

/* ── Modal edit ── */
function openEdit(id, hari, mulai, selesai, tersedia) {
    document.getElementById('editForm').action = `/guru/ketersediaan/${id}`;
    document.getElementById('editHari').value     = hari;
    document.getElementById('editMulai').value    = mulai;
    document.getElementById('editSelesai').value  = selesai;
    document.getElementById('editTersedia').checked = tersedia;
    document.getElementById('editModal').classList.add('active');
}

function closeEdit() {
    document.getElementById('editModal').classList.remove('active');
}

document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEdit();
});
</script>
</x-app-layout>