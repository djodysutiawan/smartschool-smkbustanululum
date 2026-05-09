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

    .page{padding:28px 28px 40px;max-width:2000px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:28px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    /* ── Warning banners ── */
    .warn-banner{display:flex;align-items:flex-start;gap:12px;padding:14px 18px;border-radius:var(--radius);margin-bottom:12px}
    .warn-banner.orange{background:#fff7ed;border:1px solid #fed7aa;color:#9a3412}
    .warn-banner.red{background:#fff0f0;border:1px solid #fecaca;color:#991b1b}
    .warn-banner-icon{flex-shrink:0;margin-top:1px}
    .warn-banner-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;margin-bottom:2px}
    .warn-banner-sub{font-size:12.5px;opacity:.85}

    /* ── Form card ── */
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .form-card-header{padding:18px 24px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text)}
    .form-card-sub{font-size:12px;color:var(--text3);margin-top:2px}
    .form-card-body{padding:24px}

    /* ── Tipe picker ── */
    .tipe-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px}
    .tipe-option{position:relative}
    .tipe-option input[type=radio]{position:absolute;opacity:0;pointer-events:none}
    .tipe-label{display:flex;flex-direction:column;align-items:center;gap:10px;padding:24px 16px;border-radius:var(--radius);border:2px solid var(--border);background:var(--surface2);cursor:pointer;transition:all .18s;text-align:center}
    .tipe-label:hover{border-color:var(--brand-500);background:var(--brand-50)}
    .tipe-option input:checked ~ .tipe-label{border-color:var(--brand-600);background:var(--brand-50);box-shadow:0 0 0 3px rgba(31,99,219,.12)}
    .tipe-icon{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;transition:background .18s}
    .tipe-option.masuk  .tipe-icon{background:#dbeafe}
    .tipe-option.pulang .tipe-icon{background:#ede9fe}
    .tipe-option input:checked ~ .tipe-label .tipe-icon{filter:brightness(.93)}
    .tipe-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text)}
    .tipe-desc{font-size:12px;color:var(--text3);margin-top:2px}
    .tipe-disabled-badge{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:99px;font-size:11px;font-weight:700;background:#fee2e2;color:#dc2626;margin-top:4px}

    /* ── Form field ── */
    .field{margin-bottom:16px}
    .field-label{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);margin-bottom:6px}
    .field-label .opt{font-weight:500;color:var(--text3);font-size:11.5px;margin-left:4px}
    textarea.field-input{height:90px;resize:vertical}
    .field-input{width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s;box-sizing:border-box}
    .field-input:focus{border-color:var(--brand-500);box-shadow:0 0 0 3px rgba(53,130,240,.1)}
    .field-hint{font-size:12px;color:var(--text3);margin-top:5px}
    .field-error{font-size:12px;color:#dc2626;margin-top:5px;font-weight:600}

    /* ── Info row ── */
    .info-row{display:flex;gap:16px;margin-bottom:20px;flex-wrap:wrap}
    .info-chip{display:flex;align-items:center;gap:7px;padding:8px 14px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;color:var(--text2);font-weight:600}
    .info-chip svg{flex-shrink:0}

    /* ── Submit bar ── */
    .submit-bar{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:18px 24px;border-top:1px solid var(--border);background:var(--surface2)}
    .btn-submit{display:inline-flex;align-items:center;gap:8px;padding:10px 24px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;cursor:pointer;transition:background .15s}
    .btn-submit:hover{background:var(--brand-700)}
    .btn-submit:disabled{opacity:.6;cursor:not-allowed}

    @media(max-width:640px){.tipe-grid{grid-template-columns:1fr};.page{padding:16px}}
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Buka Sesi Gerbang Baru</h1>
            <p class="page-sub">Scanner absensi hanya menerima scan saat ada sesi yang aktif</p>
        </div>
        <a href="{{ route('admin.sesi-gerbang.index') }}" class="btn btn-secondary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    {{-- Warning banners jika ada sesi aktif --}}
    @if($sesiAktifMasuk)
    <div class="warn-banner orange">
        <div class="warn-banner-icon">
            <svg width="18" height="18" fill="none" stroke="#c2410c" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <div>
            <p class="warn-banner-title">Sesi Masuk Pagi sedang aktif</p>
            <p class="warn-banner-sub">Dibuka pukul {{ $sesiAktifMasuk->dibuka_pada->format('H:i') }} oleh {{ $sesiAktifMasuk->dibukaOleh?->name }}. Tutup sesi tersebut sebelum membuka sesi Masuk baru.</p>
        </div>
    </div>
    @endif

    @if($sesiAktifPulang)
    <div class="warn-banner orange">
        <div class="warn-banner-icon">
            <svg width="18" height="18" fill="none" stroke="#c2410c" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <div>
            <p class="warn-banner-title">Sesi Pulang Sore sedang aktif</p>
            <p class="warn-banner-sub">Dibuka pukul {{ $sesiAktifPulang->dibuka_pada->format('H:i') }} oleh {{ $sesiAktifPulang->dibukaOleh?->name }}. Tutup sesi tersebut sebelum membuka sesi Pulang baru.</p>
        </div>
    </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('admin.sesi-gerbang.store') }}" id="formBukaSesi">
        @csrf

        <div class="form-card">
            <div class="form-card-header">
                <p class="form-card-title">Detail Sesi</p>
                <p class="form-card-sub">Pilih tipe sesi dan tambahkan catatan jika diperlukan</p>
            </div>
            <div class="form-card-body">

                {{-- Info waktu & tanggal --}}
                <div class="info-row">
                    <div class="info-chip">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <span>{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
                    </div>
                    <div class="info-chip" id="clockChip">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span id="clockVal">--:--</span>
                    </div>
                    <div class="info-chip">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                </div>

                {{-- Tipe Sesi --}}
                <div class="field">
                    <label class="field-label">Tipe Sesi <span style="color:#dc2626">*</span></label>
                    <div class="tipe-grid">

                        {{-- Masuk --}}
                        <div class="tipe-option masuk">
                            <input type="radio" name="tipe" id="tipe_masuk" value="masuk"
                                   {{ old('tipe','masuk') === 'masuk' ? 'checked' : '' }}
                                   {{ $sesiAktifMasuk ? 'disabled' : '' }}>
                            <label class="tipe-label" for="tipe_masuk" style="{{ $sesiAktifMasuk ? 'opacity:.55;cursor:not-allowed' : '' }}">
                                <div class="tipe-icon">
                                    <svg width="26" height="26" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                                </div>
                                <div>
                                    <p class="tipe-title">Masuk Pagi</p>
                                    <p class="tipe-desc">Scan kedatangan siswa di pagi hari</p>
                                    @if($sesiAktifMasuk)
                                        <span class="tipe-disabled-badge">
                                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                            Sedang aktif
                                        </span>
                                    @endif
                                </div>
                            </label>
                        </div>

                        {{-- Pulang --}}
                        <div class="tipe-option pulang">
                            <input type="radio" name="tipe" id="tipe_pulang" value="pulang"
                                   {{ old('tipe') === 'pulang' ? 'checked' : '' }}
                                   {{ $sesiAktifPulang ? 'disabled' : '' }}>
                            <label class="tipe-label" for="tipe_pulang" style="{{ $sesiAktifPulang ? 'opacity:.55;cursor:not-allowed' : '' }}">
                                <div class="tipe-icon">
                                    <svg width="26" height="26" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                </div>
                                <div>
                                    <p class="tipe-title">Pulang Sore</p>
                                    <p class="tipe-desc">Scan kepulangan siswa di sore hari</p>
                                    @if($sesiAktifPulang)
                                        <span class="tipe-disabled-badge">
                                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                            Sedang aktif
                                        </span>
                                    @endif
                                </div>
                            </label>
                        </div>

                    </div>
                    @error('tipe')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Catatan --}}
                <div class="field">
                    <label class="field-label" for="catatan">Catatan <span class="opt">(opsional)</span></label>
                    <textarea name="catatan" id="catatan" class="field-input" placeholder="Contoh: Sesi pengganti karena hujan, jadwal mundur 15 menit...">{{ old('catatan') }}</textarea>
                    <p class="field-hint">Catatan ini hanya terlihat oleh admin. Maksimal 500 karakter.</p>
                    @error('catatan')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

            </div>
            <div class="submit-bar">
                <a href="{{ route('admin.sesi-gerbang.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn-submit" id="btnSubmit"
                    {{ ($sesiAktifMasuk && $sesiAktifPulang) ? 'disabled' : '' }}>
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Buka Sesi Sekarang
                </button>
            </div>
        </div>

    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if($errors->any())
    Swal.fire({ icon:'warning', title:'Perhatian!', html:@json(implode('<br>', $errors->all())), confirmButtonColor:'#1f63db' });
    @endif

    // Live clock
    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2,'0');
        const m = String(now.getMinutes()).padStart(2,'0');
        const s = String(now.getSeconds()).padStart(2,'0');
        document.getElementById('clockVal').textContent = h+':'+m+':'+s;
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Disable submit if selected tipe is already active
    document.querySelectorAll('input[name=tipe]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            const btn = document.getElementById('btnSubmit');
            btn.disabled = this.disabled;
        });
    });

    // Confirm before submit
    document.getElementById('formBukaSesi').addEventListener('submit', function(e) {
        const tipe = document.querySelector('input[name=tipe]:checked');
        if (!tipe) {
            e.preventDefault();
            Swal.fire({ icon:'warning', title:'Pilih tipe sesi!', text:'Silakan pilih tipe sesi terlebih dahulu.', confirmButtonColor:'#1f63db' });
            return;
        }
        const label = tipe.value === 'masuk' ? 'Masuk Pagi' : 'Pulang Sore';
        e.preventDefault();
        Swal.fire({
            title: 'Buka Sesi ' + label + '?',
            text: 'Scanner akan mulai menerima scan absensi setelah sesi dibuka.',
            icon: 'question', showCancelButton: true,
            confirmButtonColor: '#1f63db', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Buka Sesi!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('formBukaSesi').submit(); });
    });
</script>
</x-app-layout>