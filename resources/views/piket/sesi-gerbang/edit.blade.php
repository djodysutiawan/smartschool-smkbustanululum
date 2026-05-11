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

    .alert{padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-size:13px;display:flex;align-items:center;gap:8px}
    .alert-error{background:var(--red-bg);border:1px solid var(--red-border);color:#991b1b}

    /* Sesi summary */
    .sesi-summary{display:flex;align-items:center;gap:14px;padding:14px 18px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);margin-bottom:20px}
    .sesi-summary-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .sesi-summary-icon.masuk{background:var(--brand-50)}
    .sesi-summary-icon.pulang{background:var(--teal-bg)}
    .sesi-summary-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text)}
    .sesi-summary-meta{font-size:12px;color:var(--text3);margin-top:2px}
    .badge-aktif{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;background:var(--green-bg);color:var(--green);font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;margin-left:8px}
    .badge-dot-aktif{width:5px;height:5px;border-radius:50%;background:var(--green);animation:pulse 1.5s infinite}
    @keyframes pulse{0%,100%{opacity:1}50%{opacity:.4}}

    /* Form */
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:14px}
    .form-card-head{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:7px}
    .form-card-sub{font-size:12px;color:var(--text3);margin-top:2px}
    .form-card-body{padding:20px}
    .form-label{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);margin-bottom:6px}
    .form-control{width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s;resize:vertical;min-height:100px}
    .form-control:focus{border-color:var(--brand-500);box-shadow:0 0 0 3px rgba(53,130,240,.08)}
    .form-hint{font-size:11.5px;color:var(--text3);margin-top:5px;display:flex;justify-content:space-between}
    .invalid-feedback{font-size:11.5px;color:var(--red);margin-top:5px}
    .char-count{font-size:11.5px;color:var(--text3)}
    .form-actions{display:flex;gap:10px;justify-content:flex-end;margin-top:22px;padding-top:18px;border-top:1px solid var(--border)}
</style>

<div class="page">
    <a href="{{ route('piket.sesi-gerbang.show', $sesiGerbang) }}" class="back-link">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Detail Sesi
    </a>

    <h1 class="page-title">Edit Catatan Sesi</h1>
    <p class="page-sub">Hanya catatan yang dapat diubah pada sesi yang sedang aktif</p>

    {{-- Sesi summary --}}
    <div class="sesi-summary">
        <div class="sesi-summary-icon {{ $sesiGerbang->tipe }}">
            @if($sesiGerbang->tipe === 'masuk')
            <svg width="20" height="20" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/><path d="M21 3v18"/></svg>
            @else
            <svg width="20" height="20" fill="none" stroke="#0f766e" stroke-width="2" viewBox="0 0 24 24"><polyline points="14 7 9 12 14 17"/><line x1="9" y1="12" x2="21" y2="12"/><path d="M3 3v18"/></svg>
            @endif
        </div>
        <div>
            <div class="sesi-summary-label">
                {{ $sesiGerbang->label_tipe }}
                <span class="badge-aktif">
                    <span class="badge-dot-aktif"></span>Aktif
                </span>
            </div>
            <div class="sesi-summary-meta">
                {{ $sesiGerbang->tanggal->translatedFormat('l, d F Y') }} ·
                Dibuka {{ $sesiGerbang->dibuka_pada->format('H:i') }} oleh {{ $sesiGerbang->dibukaOleh?->name ?? '—' }}
            </div>
        </div>
    </div>

    @if(session('error'))
    <div class="alert alert-error">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('piket.sesi-gerbang.update', $sesiGerbang) }}" method="POST">
        @csrf @method('PATCH')

        <div class="form-card">
            <div class="form-card-head">
                <div class="form-card-title">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/></svg>
                    Catatan Sesi
                </div>
                <div class="form-card-sub">Informasi tambahan untuk keperluan laporan harian piket</div>
            </div>
            <div class="form-card-body">
                <label class="form-label">Catatan <span style="font-size:11px;font-weight:400;color:var(--text3)">(opsional)</span></label>
                <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror"
                    placeholder="Contoh: Cuaca hujan, scanner sempat error pukul 07.15 selama 5 menit..."
                    maxlength="500" oninput="updateCharCount(this)">{{ old('catatan', $sesiGerbang->catatan) }}</textarea>
                <div class="form-hint">
                    <span>Maksimal 500 karakter</span>
                    <span class="char-count" id="charCount">{{ strlen($sesiGerbang->catatan ?? '') }}/500</span>
                </div>
                @error('catatan')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('piket.sesi-gerbang.show', $sesiGerbang) }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Catatan
            </button>
        </div>
    </form>
</div>

<script>
function updateCharCount(el) {
    document.getElementById('charCount').textContent = el.value.length + '/500';
}
</script>
</x-app-layout>