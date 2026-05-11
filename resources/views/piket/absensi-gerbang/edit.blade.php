<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
        --yellow-bg:#fefce8;--yellow-border:#fde68a;--yellow-text:#92400e;
        --green-bg:#f0fdf4;--green-border:#bbf7d0;--green-text:#15803d;
        --red-bg:#fef2f2;--red-border:#fecaca;--red-text:#dc2626;
        --purple-bg:#fdf4ff;--purple-border:#e9d5ff;--purple-text:#7c3aed;
    }

    .page { padding: 28px 28px 48px; max-width: 880px; }
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2; }
    .page-sub { font-size: 12.5px; color: var(--text3); margin-top: 3px; font-family: 'DM Sans', sans-serif; }

    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s, background .15s; white-space: nowrap; }
    .btn:hover { filter: brightness(.93); }
    .btn-primary { background: var(--brand-600); color: #fff; }
    .btn-secondary { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-secondary:hover { background: var(--surface3); filter: none; }
    .btn-purple { background: var(--purple-bg); color: var(--purple-text); border: 1px solid var(--purple-border); }
    .btn-purple:hover { background: #f3e8ff; filter: none; }

    /* Info card scan */
    .scan-info-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); margin-bottom: 16px; overflow: hidden; }
    .scan-info-head { display: flex; align-items: center; gap: 12px; padding: 16px 20px; border-bottom: 1px solid var(--border); background: var(--surface2); }
    .scan-avatar { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; font-weight: 800; color: #fff; }
    .scan-avatar.siswa { background: linear-gradient(135deg, #3582f0, #1750c0); }
    .scan-avatar.guru  { background: linear-gradient(135deg, #8b5cf6, #6d28d9); }
    .scan-avatar.unknown { background: linear-gradient(135deg, #94a3b8, #64748b); }
    .scan-info-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; font-weight: 800; color: var(--text); }
    .scan-info-meta { font-family: 'DM Sans', sans-serif; font-size: 12.5px; color: var(--text3); margin-top: 2px; }
    .scan-info-body { padding: 16px 20px; }

    /* Info grid */
    .info-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
    .info-item { }
    .info-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; color: var(--text3); letter-spacing: .04em; text-transform: uppercase; margin-bottom: 4px; }
    .info-val { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--text); }
    .info-val.muted { color: var(--text2); font-weight: 400; font-family: 'DM Sans', sans-serif; }

    /* Badges */
    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; white-space: nowrap; }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .badge-normal        { background: var(--green-bg); color: var(--green-text); }     .badge-normal .badge-dot        { background: var(--green-text); }
    .badge-manual        { background: #eff6ff; color: #1d4ed8; }                       .badge-manual .badge-dot        { background: #1d4ed8; }
    .badge-duplikat      { background: var(--yellow-bg); color: var(--yellow-text); }   .badge-duplikat .badge-dot      { background: #a16207; }
    .badge-koreksi       { background: var(--purple-bg); color: var(--purple-text); }   .badge-koreksi .badge-dot       { background: #7c3aed; }
    .badge-tidak_dikenal { background: var(--surface3); color: var(--text2); }          .badge-tidak_dikenal .badge-dot { background: var(--text3); }

    .badge-tipe-masuk  { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); padding: 2px 9px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; }
    .badge-tipe-pulang { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; padding: 2px 9px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; }

    /* Alert banner */
    .alert-banner { display: flex; align-items: flex-start; gap: 12px; padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 16px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600; line-height: 1.5; }
    .alert-banner.warning { background: var(--yellow-bg); border: 1px solid var(--yellow-border); color: var(--yellow-text); }
    .alert-banner.info    { background: var(--brand-50); border: 1px solid var(--brand-100); color: var(--brand-700); }
    .alert-banner svg { flex-shrink: 0; margin-top: 2px; }

    /* Form card */
    .form-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; margin-bottom: 16px; }
    .form-card-head { padding: 14px 20px; border-bottom: 1px solid var(--border); background: var(--surface2); }
    .form-card-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--text); }
    .form-card-sub { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: 2px; }
    .form-card-body { padding: 20px; }

    .form-group { margin-bottom: 16px; }
    .form-group:last-child { margin-bottom: 0; }
    .form-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--text2); margin-bottom: 6px; display: block; letter-spacing: .02em; }
    .form-label .req { color: var(--red-text); }
    .form-control { width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--text); background: var(--surface2); outline: none; transition: border-color .15s; box-sizing: border-box; }
    .form-control:focus { border-color: var(--brand-500); background: #fff; }
    .form-control[disabled] { opacity: .6; cursor: not-allowed; }
    textarea.form-control { min-height: 90px; resize: vertical; padding: 10px 12px; line-height: 1.5; }
    select.form-control { height: 40px; }

    .form-hint { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text3); margin-top: 5px; }
    .form-error { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--red-text); margin-top: 5px; }

    /* Form actions */
    .form-actions { display: flex; align-items: center; gap: 10px; padding: 16px 20px; border-top: 1px solid var(--border); background: var(--surface2); flex-wrap: wrap; }

    /* Koreksi section — divider */
    .section-divider { display: flex; align-items: center; gap: 12px; margin: 4px 0 16px; }
    .section-divider-line { flex: 1; height: 1px; background: var(--border); }
    .section-divider-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 700; color: var(--text3); letter-spacing: .05em; text-transform: uppercase; white-space: nowrap; }

    /* Koreksi history */
    .koreksi-item { display: flex; align-items: flex-start; gap: 12px; padding: 12px 16px; background: var(--purple-bg); border: 1px solid var(--purple-border); border-radius: var(--radius-sm); }
    .koreksi-icon { width: 32px; height: 32px; border-radius: 8px; background: var(--purple-text); display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
    .koreksi-body { flex: 1; }
    .koreksi-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--purple-text); }
    .koreksi-meta { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--text2); margin-top: 3px; }

    /* Tipe toggle */
    .tipe-group { display: flex; gap: 8px; }
    .tipe-option { flex: 1; }
    .tipe-option input[type=radio] { display: none; }
    .tipe-option label { display: flex; align-items: center; justify-content: center; gap: 6px; padding: 9px 12px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; color: var(--text2); cursor: pointer; transition: all .15s; background: var(--surface2); }
    .tipe-option input[type=radio]:checked + label { border-color: var(--brand-500); background: var(--brand-50); color: var(--brand-700); }
    .tipe-option label:hover { border-color: var(--border2); background: var(--surface3); }

    @media (max-width: 640px) {
        .page { padding: 16px; }
        .info-grid { grid-template-columns: 1fr 1fr; }
    }
</style>

<div class="page">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Scan Gerbang</h1>
            <p class="page-sub">
                ID #{{ $absensiGerbang->id }}
                &mdash; {{ $absensiGerbang->tanggal_scan->translatedFormat('d F Y') }}
            </p>
        </div>
        <a href="{{ route('piket.absensi-gerbang.rekap', ['tanggal' => $absensiGerbang->tanggal_scan->toDateString()]) }}"
           class="btn btn-secondary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali ke Rekap
        </a>
    </div>

    {{-- ── Info scan ── --}}
    <div class="scan-info-card">
        <div class="scan-info-head">
            {{-- Avatar --}}
            @if($absensiGerbang->siswa_id)
                <div class="scan-avatar siswa">
                    {{ strtoupper(substr($absensiGerbang->siswa->nama_lengkap ?? 'S', 0, 1)) }}
                </div>
                <div>
                    <p class="scan-info-name">{{ $absensiGerbang->siswa->nama_lengkap ?? '—' }}</p>
                    <p class="scan-info-meta">
                        NIS: {{ $absensiGerbang->siswa->nis ?? '—' }}
                        &bull; {{ $absensiGerbang->siswa->kelas->nama_kelas ?? 'Kelas tidak ditemukan' }}
                    </p>
                </div>
            @elseif($absensiGerbang->guru_id)
                <div class="scan-avatar guru">
                    {{ strtoupper(substr($absensiGerbang->guru->nama_lengkap ?? 'G', 0, 1)) }}
                </div>
                <div>
                    <p class="scan-info-name">{{ $absensiGerbang->guru->nama_lengkap ?? '—' }}</p>
                    <p class="scan-info-meta">NIP: {{ $absensiGerbang->guru->nip ?? '—' }} &bull; Guru</p>
                </div>
            @else
                <div class="scan-avatar unknown">?</div>
                <div>
                    <p class="scan-info-name" style="color:var(--text3);font-style:italic">Pemilik Tidak Dikenal</p>
                    <p class="scan-info-meta">Kode: {{ $absensiGerbang->kode_scan }}</p>
                </div>
            @endif

            {{-- Badge status --}}
            <div style="margin-left:auto;display:flex;align-items:center;gap:8px;flex-wrap:wrap">
                <span class="badge-tipe-{{ $absensiGerbang->tipe }}">
                    {{ ucfirst($absensiGerbang->tipe) }}
                </span>
                <span class="badge badge-{{ $absensiGerbang->status }}">
                    <span class="badge-dot"></span>
                    {{ ucfirst(str_replace('_', ' ', $absensiGerbang->status)) }}
                </span>
            </div>
        </div>

        <div class="scan-info-body">
            <div class="info-grid">
                <div class="info-item">
                    <p class="info-label">Kode Scan</p>
                    <p class="info-val" style="font-family:'DM Mono',monospace;letter-spacing:.03em">
                        {{ $absensiGerbang->kode_scan }}
                    </p>
                </div>
                <div class="info-item">
                    <p class="info-label">Waktu Scan</p>
                    <p class="info-val">{{ $absensiGerbang->waktu_scan->format('H:i:s') }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Sesi Gerbang</p>
                    <p class="info-val">
                        {{ $absensiGerbang->sesiGerbang?->label_tipe ?? ucfirst($absensiGerbang->sesiGerbang?->tipe ?? '—') }}
                    </p>
                </div>
                <div class="info-item">
                    <p class="info-label">Scan Manual</p>
                    <p class="info-val">{{ $absensiGerbang->is_manual ? 'Ya' : 'Tidak (Scanner)' }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Input Oleh</p>
                    <p class="info-val">
                        @if($absensiGerbang->is_manual)
                            {{ $absensiGerbang->inputOleh->name ?? '—' }}
                        @else
                            <span class="muted">Scanner Otomatis</span>
                        @endif
                    </p>
                </div>
                <div class="info-item">
                    <p class="info-label">Catatan Saat Ini</p>
                    <p class="info-val muted">{{ $absensiGerbang->catatan ?: '—' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Sudah dikoreksi ── --}}
    @if($absensiGerbang->hasilKoreksi->isNotEmpty())
        <div class="alert-banner warning" role="alert">
            <svg width="16" height="16" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>
                Record ini sudah pernah dikoreksi sebelumnya.
                Perubahan catatan masih bisa disimpan, namun koreksi tipe scan tidak tersedia lagi.
            </span>
        </div>

        @foreach($absensiGerbang->hasilKoreksi as $koreksi)
        <div class="koreksi-item" style="margin-bottom:12px">
            <div class="koreksi-icon">
                <svg width="15" height="15" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                    <polyline points="9 11 12 14 22 4"/>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                </svg>
            </div>
            <div class="koreksi-body">
                <p class="koreksi-title">
                    Dikoreksi: tipe diubah ke
                    <span class="badge-tipe-{{ $koreksi->tipe }}" style="margin-left:4px">
                        {{ ucfirst($koreksi->tipe) }}
                    </span>
                </p>
                <p class="koreksi-meta">
                    Scan baru ID #{{ $koreksi->id }}
                    &bull; {{ $koreksi->waktu_scan->format('H:i:s') }}
                    @if($koreksi->catatan)
                        &bull; Catatan: {{ $koreksi->catatan }}
                    @endif
                </p>
            </div>
        </div>
        @endforeach
    @endif

    {{-- ── Form 1: Edit Catatan ── --}}
    <div class="form-card">
        <div class="form-card-head">
            <p class="form-card-title">Edit Catatan Scan</p>
            <p class="form-card-sub">
                Ubah catatan tambahan pada record scan ini.
                Perubahan tipe scan (masuk/pulang) dilakukan lewat fitur Koreksi di bawah.
            </p>
        </div>
        <form action="{{ route('piket.absensi-gerbang.update', $absensiGerbang->id) }}"
              method="POST" id="form-edit">
            @csrf @method('PATCH')
            <div class="form-card-body">
                <div class="form-group">
                    <label class="form-label" for="catatan">Catatan</label>
                    <textarea name="catatan" id="catatan" class="form-control" maxlength="500"
                              placeholder="Tambahkan catatan untuk scan ini (opsional)…">{{ old('catatan', $absensiGerbang->catatan) }}</textarea>
                    <p class="form-hint">Maksimal 500 karakter.</p>
                    @error('catatan')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan Catatan
                </button>
                <a href="{{ route('piket.absensi-gerbang.rekap', ['tanggal' => $absensiGerbang->tanggal_scan->toDateString()]) }}"
                   class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

    {{-- ── Form 2: Koreksi Tipe ── --}}
    {{-- Hanya tampil jika belum dikoreksi dan bukan status duplikat/tidak_dikenal yang tidak punya siswa/guru --}}
    @if($absensiGerbang->hasilKoreksi->isEmpty() && ($absensiGerbang->siswa_id || $absensiGerbang->guru_id))
    <div class="form-card">
        <div class="form-card-head">
            <p class="form-card-title">Koreksi Tipe Scan</p>
            <p class="form-card-sub">
                Ubah tipe scan dari
                <strong>{{ ucfirst($absensiGerbang->tipe) }}</strong>
                ke tipe lainnya. Record lama tetap tersimpan untuk keperluan audit.
            </p>
        </div>
        <form action="{{ route('piket.absensi-gerbang.koreksi', $absensiGerbang->id) }}"
              method="POST" id="form-koreksi">
            @csrf @method('POST')
            <div class="form-card-body">

                <div class="alert-banner info" role="alert">
                    <svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1" x2="12.01" y2="16"/>
                    </svg>
                    <span>
                        Koreksi hanya bisa dilakukan satu kali per record. Pastikan tipe baru sudah benar sebelum menyimpan.
                    </span>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Tipe Scan Baru <span class="req">*</span>
                    </label>
                    <div class="tipe-group">
                        @foreach(['masuk', 'pulang'] as $tipeOption)
                        <div class="tipe-option">
                            <input type="radio" name="tipe_baru" id="tipe_{{ $tipeOption }}"
                                   value="{{ $tipeOption }}"
                                   {{ old('tipe_baru') === $tipeOption ? 'checked' : '' }}
                                   {{ $absensiGerbang->tipe === $tipeOption ? 'disabled' : '' }}>
                            <label for="tipe_{{ $tipeOption }}">
                                @if($tipeOption === 'masuk')
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                                        <polyline points="10 17 15 12 10 7"/>
                                        <line x1="15" y1="12" x2="3" y2="12"/>
                                    </svg>
                                @else
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                        <polyline points="16 17 21 12 16 7"/>
                                        <line x1="21" y1="12" x2="9" y2="12"/>
                                    </svg>
                                @endif
                                {{ ucfirst($tipeOption) }}
                                @if($absensiGerbang->tipe === $tipeOption)
                                    <span style="font-size:10.5px;font-weight:400;color:var(--text3)">(saat ini)</span>
                                @endif
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @error('tipe_baru')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="catatan_koreksi">Catatan Koreksi</label>
                    <textarea name="catatan" id="catatan_koreksi" class="form-control" maxlength="500"
                              placeholder="Alasan koreksi tipe scan (opsional)…">{{ old('catatan') }}</textarea>
                    <p class="form-hint">Maksimal 500 karakter.</p>
                    @error('catatan')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-purple" onclick="konfirmasiKoreksi()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Simpan Koreksi
                </button>
                <span style="font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text3)">
                    Tindakan ini tidak bisa dibatalkan
                </span>
            </div>
        </form>
    </div>
    @elseif($absensiGerbang->hasilKoreksi->isEmpty() && !$absensiGerbang->siswa_id && !$absensiGerbang->guru_id)
        <div class="alert-banner warning" role="alert">
            <svg width="16" height="16" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24">
                <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            <span>
                Koreksi tipe scan tidak tersedia untuk scan dengan pemilik tidak dikenal.
                Identifikasi pemilik terlebih dahulu melalui halaman admin.
            </span>
        </div>
    @endif

</div>{{-- /.page --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({
        icon:'success', title:'Berhasil!',
        text: @json(session('success')),
        timer:2800, showConfirmButton:false,
        toast:true, position:'top-end'
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon:'error', title:'Gagal!',
        text: @json(session('error')),
        confirmButtonColor:'#1f63db'
    });
    @endif

    function konfirmasiKoreksi() {
        // Validasi client-side: pastikan tipe baru dipilih
        const selected = document.querySelector('input[name="tipe_baru"]:checked:not(:disabled)');
        if (!selected) {
            Swal.fire({
                icon:'warning',
                title:'Pilih tipe baru',
                text:'Pilih tipe scan yang berbeda dari tipe saat ini.',
                confirmButtonColor:'#1f63db'
            });
            return;
        }

        const tipeBaru = selected.value;
        const tipeSaatIni = '{{ $absensiGerbang->tipe }}';
        const nama = '{{ addslashes($absensiGerbang->siswa?->nama_lengkap ?? $absensiGerbang->guru?->nama_lengkap ?? "Tidak dikenal") }}';

        Swal.fire({
            icon: 'warning',
            title: 'Konfirmasi Koreksi',
            html: `Tipe scan <strong>${nama}</strong> akan diubah dari <strong>${tipeSaatIni}</strong> ke <strong>${tipeBaru}</strong>.<br><br>
                   <small style="color:#64748b">Record ini tidak bisa dikoreksi lagi setelah disimpan.</small>`,
            showCancelButton: true,
            confirmButtonText: 'Ya, Koreksi',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#7c3aed',
            cancelButtonColor: '#94a3b8',
            reverseButtons: true,
        }).then(result => {
            if (result.isConfirmed) {
                document.getElementById('form-koreksi').submit();
            }
        });
    }
</script>
</x-app-layout>