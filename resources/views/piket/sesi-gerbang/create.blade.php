<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#15803d;--green-bg:#dcfce7;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --yellow:#a16207;--yellow-bg:#fefce8;--yellow-border:#fde68a;
        --teal:#0f766e;--teal-bg:#f0fdfa;--teal-border:#99f6e4;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    .page{padding:28px 28px 48px;max-width:2000px;margin:0 auto;font-family:'DM Sans',sans-serif}
    .back-link{display:inline-flex;align-items:center;gap:6px;color:var(--text3);font-size:13px;text-decoration:none;margin-bottom:20px;transition:color .15s}
    .back-link:hover{color:var(--text2)}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;margin-bottom:24px}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    .alert{padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-size:13px;display:flex;align-items:flex-start;gap:8px}
    .alert-warning{background:var(--yellow-bg);border:1px solid var(--yellow-border);color:var(--yellow)}
    .alert-error{background:var(--red-bg);border:1px solid var(--red-border);color:#991b1b}

    /* Tipe selector */
    .tipe-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:4px}
    .tipe-option{position:relative}
    .tipe-option input[type=radio]{position:absolute;opacity:0;width:0;height:0}
    .tipe-card{display:flex;flex-direction:column;align-items:flex-start;gap:10px;padding:18px 20px;border:1.5px solid var(--border);border-radius:var(--radius);cursor:pointer;transition:all .2s;background:var(--surface)}
    .tipe-card:hover{border-color:var(--brand-500);background:var(--brand-50)}
    .tipe-option input:checked + .tipe-card{border-color:var(--brand-500);background:var(--brand-50);box-shadow:0 0 0 3px rgba(53,130,240,.08)}
    .tipe-card.tipe-masuk:hover,.tipe-option input:checked + .tipe-card.tipe-masuk{border-color:var(--brand-500);background:var(--brand-50)}
    .tipe-card.tipe-pulang:hover,.tipe-option input:checked + .tipe-card.tipe-pulang{border-color:var(--teal);background:var(--teal-bg)}
    .tipe-option input:checked + .tipe-card.tipe-pulang{box-shadow:0 0 0 3px rgba(15,118,110,.08)}
    .tipe-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center}
    .tipe-icon-masuk{background:var(--brand-50)}
    .tipe-icon-pulang{background:var(--teal-bg)}
    .tipe-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:14px;color:var(--text)}
    .tipe-desc{font-size:12px;color:var(--text3);margin-top:2px;line-height:1.5}
    .tipe-sudah-ada{display:inline-flex;align-items:center;gap:4px;padding:2px 9px;background:var(--yellow-bg);color:var(--yellow);border:1px solid var(--yellow-border);border-radius:99px;font-size:11px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;margin-top:6px}
    .tipe-option.disabled .tipe-card{opacity:.6;cursor:not-allowed}
    .tipe-option.disabled input{pointer-events:none}

    /* Form card */
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:14px}
    .form-card-head{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:7px}
    .form-card-sub{font-size:12px;color:var(--text3);margin-top:2px}
    .form-card-body{padding:20px}
    .form-group{margin-bottom:0}
    .form-label{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);margin-bottom:6px}
    .form-control{width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s;resize:vertical;min-height:80px}
    .form-control:focus{border-color:var(--brand-500);box-shadow:0 0 0 3px rgba(53,130,240,.08)}
    .form-hint{font-size:11.5px;color:var(--text3);margin-top:5px}
    .invalid-feedback{font-size:11.5px;color:var(--red);margin-top:5px}

    /* Info sesi aktif */
    .sesi-aktif-card{display:flex;align-items:flex-start;gap:12px;padding:13px 16px;border-radius:9px;border:1px solid;margin-bottom:14px}
    .sesi-aktif-card.masuk{background:var(--brand-50);border-color:var(--brand-100)}
    .sesi-aktif-card.pulang{background:var(--teal-bg);border-color:var(--teal-border)}
    .sesi-aktif-icon{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .sesi-aktif-info{flex:1;min-width:0}
    .sesi-aktif-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;color:var(--text)}
    .sesi-aktif-meta{font-size:12px;color:var(--text2);margin-top:2px}
    .sesi-aktif-action{text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;display:inline-flex;align-items:center;gap:4px;margin-top:6px}
    .sesi-aktif-action.masuk{color:var(--brand-600)}
    .sesi-aktif-action.pulang{color:var(--teal)}

    /* Jam sekarang */
    .jam-sekarang{display:flex;align-items:center;gap:8px;padding:10px 14px;background:var(--surface2);border:1px solid var(--border);border-radius:8px;margin-bottom:16px}
    .jam-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .jam-label{font-size:12px;color:var(--text3)}

    .form-actions{display:flex;gap:10px;justify-content:flex-end;margin-top:22px;padding-top:18px;border-top:1px solid var(--border)}

    @media(max-width:640px){.tipe-grid{grid-template-columns:1fr}.page{padding:16px}}
</style>

<div class="page">
    <a href="{{ route('piket.sesi-gerbang.index') }}" class="back-link">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Riwayat Sesi
    </a>

    <h1 class="page-title">Buka Sesi Gerbang</h1>
    <p class="page-sub">Buka sesi masuk atau pulang untuk mengaktifkan scanner gerbang hari ini</p>

    {{-- Info sesi aktif yang sudah ada --}}
    @if($sesiAktifMasuk)
    <div class="sesi-aktif-card masuk">
        <div class="sesi-aktif-icon" style="background:var(--brand-50)">
            <svg width="16" height="16" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        </div>
        <div class="sesi-aktif-info">
            <div class="sesi-aktif-label">Sesi Masuk Pagi sedang aktif</div>
            <div class="sesi-aktif-meta">
                Dibuka {{ $sesiAktifMasuk->dibuka_pada->format('H:i') }} oleh {{ $sesiAktifMasuk->dibukaOleh?->name ?? '—' }}
            </div>
            <a href="{{ route('piket.sesi-gerbang.show', $sesiAktifMasuk) }}" class="sesi-aktif-action masuk">
                Lihat sesi aktif →
            </a>
        </div>
    </div>
    @endif

    @if($sesiAktifPulang)
    <div class="sesi-aktif-card pulang">
        <div class="sesi-aktif-icon" style="background:var(--teal-bg)">
            <svg width="16" height="16" fill="none" stroke="#0f766e" stroke-width="2" viewBox="0 0 24 24"><polyline points="14 7 9 12 14 17"/><line x1="9" y1="12" x2="21" y2="12"/></svg>
        </div>
        <div class="sesi-aktif-info">
            <div class="sesi-aktif-label">Sesi Pulang Sore sedang aktif</div>
            <div class="sesi-aktif-meta">
                Dibuka {{ $sesiAktifPulang->dibuka_pada->format('H:i') }} oleh {{ $sesiAktifPulang->dibukaOleh?->name ?? '—' }}
            </div>
            <a href="{{ route('piket.sesi-gerbang.show', $sesiAktifPulang) }}" class="sesi-aktif-action pulang">
                Lihat sesi aktif →
            </a>
        </div>
    </div>
    @endif

    @error('tipe')
    <div class="alert alert-error">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ $message }}
    </div>
    @enderror

    {{-- Jam sekarang --}}
    <div class="jam-sekarang">
        <svg width="16" height="16" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <div>
            <div class="jam-val" id="jamSekarang">{{ now()->format('H:i:s') }}</div>
            <div class="jam-label">{{ now()->translatedFormat('l, d F Y') }}</div>
        </div>
    </div>

    <form action="{{ route('piket.sesi-gerbang.store') }}" method="POST">
        @csrf

        {{-- Pilih Tipe --}}
        <div class="form-card">
            <div class="form-card-head">
                <div class="form-card-title">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Pilih Tipe Sesi
                </div>
                <div class="form-card-sub">Pilih sesuai dengan waktu jaga piket sekarang</div>
            </div>
            <div class="form-card-body">
                <div class="tipe-grid">
                    {{-- Masuk --}}
                    <div class="tipe-option {{ $sesiAktifMasuk ? 'disabled' : '' }}">
                        <input type="radio" name="tipe" id="tipe_masuk" value="masuk"
                            {{ old('tipe', 'masuk') === 'masuk' ? 'checked' : '' }}
                            {{ $sesiAktifMasuk ? 'disabled' : '' }}>
                        <label class="tipe-card tipe-masuk" for="tipe_masuk">
                            <div class="tipe-icon tipe-icon-masuk">
                                <svg width="20" height="20" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/><path d="M21 3v18"/></svg>
                            </div>
                            <div>
                                <div class="tipe-name">Masuk Pagi</div>
                                <div class="tipe-desc">Untuk sesi absensi masuk siswa di gerbang pagi hari</div>
                                @if($sesiAktifMasuk)
                                <span class="tipe-sudah-ada">
                                    <svg width="9" height="9" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>
                                    Sudah aktif
                                </span>
                                @endif
                            </div>
                        </label>
                    </div>

                    {{-- Pulang --}}
                    <div class="tipe-option {{ $sesiAktifPulang ? 'disabled' : '' }}">
                        <input type="radio" name="tipe" id="tipe_pulang" value="pulang"
                            {{ old('tipe') === 'pulang' ? 'checked' : '' }}
                            {{ $sesiAktifPulang ? 'disabled' : '' }}>
                        <label class="tipe-card tipe-pulang" for="tipe_pulang">
                            <div class="tipe-icon tipe-icon-pulang">
                                <svg width="20" height="20" fill="none" stroke="#0f766e" stroke-width="2" viewBox="0 0 24 24"><polyline points="14 7 9 12 14 17"/><line x1="9" y1="12" x2="21" y2="12"/><path d="M3 3v18"/></svg>
                            </div>
                            <div>
                                <div class="tipe-name">Pulang Sore</div>
                                <div class="tipe-desc">Untuk sesi absensi kepulangan siswa di gerbang sore hari</div>
                                @if($sesiAktifPulang)
                                <span class="tipe-sudah-ada">
                                    <svg width="9" height="9" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>
                                    Sudah aktif
                                </span>
                                @endif
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Catatan --}}
        <div class="form-card">
            <div class="form-card-head">
                <div class="form-card-title">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    Catatan Sesi
                    <span style="font-size:11px;color:var(--text3);font-weight:400">(opsional)</span>
                </div>
                <div class="form-card-sub">Informasi tambahan untuk keperluan laporan piket</div>
            </div>
            <div class="form-card-body">
                <div class="form-group">
                    <textarea name="catatan" class="form-control" placeholder="Contoh: Cuaca hujan, beberapa siswa terlambat karena macet...">{{ old('catatan') }}</textarea>
                    <p class="form-hint">Maksimal 500 karakter</p>
                    @error('catatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('piket.sesi-gerbang.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary"
                {{ ($sesiAktifMasuk && $sesiAktifPulang) ? 'disabled style=opacity:.5;cursor:not-allowed' : '' }}>
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Buka Sesi Sekarang
            </button>
        </div>
    </form>
</div>

<script>
// Live clock
function tickClock() {
    const el = document.getElementById('jamSekarang');
    if (el) el.textContent = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
}
setInterval(tickClock, 1000);

// Highlight selected tipe card
document.querySelectorAll('input[name=tipe]').forEach(radio => {
    radio.addEventListener('change', () => {
        document.querySelectorAll('.tipe-card').forEach(c => c.style.borderWidth = '1.5px');
    });
});
</script>
</x-app-layout>