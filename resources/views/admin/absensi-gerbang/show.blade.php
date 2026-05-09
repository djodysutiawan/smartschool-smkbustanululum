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

    .page{padding:28px 28px 40px;max-width:1100px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--text3);margin-bottom:6px;flex-wrap:wrap}
    .breadcrumb a{color:var(--text3);text-decoration:none;transition:color .15s}
    .breadcrumb a:hover{color:var(--text2)}
    .breadcrumb-sep{color:var(--border2)}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}
    .btn-warn{background:#fffbeb;color:#a16207;border:1px solid #fde68a}
    .btn-warn:hover{background:#fef9c3;filter:none}

    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    .grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}

    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .card-header{display:flex;align-items:center;gap:10px;padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .card-icon{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .card-icon.blue{background:#eff6ff}
    .card-icon.green{background:#f0fdf4}
    .card-icon.purple{background:#faf5ff}
    .card-icon.orange{background:#fff7ed}
    .card-icon.red{background:#fff0f0}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .card-body{padding:20px}

    .dl{display:grid;grid-template-columns:auto 1fr;gap:10px 20px;align-items:start}
    .dl dt{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;white-space:nowrap;padding-top:1px}
    .dl dd{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);margin:0}
    .dl dd.bold{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700}
    .dl dd.muted{color:var(--text3)}
    .divider{border:none;border-top:1px solid var(--border);margin:14px 0}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-masuk   {background:#dcfce7;color:#15803d} .badge-masuk    .badge-dot{background:#15803d}
    .badge-pulang  {background:#dbeafe;color:#1d4ed8} .badge-pulang   .badge-dot{background:#1d4ed8}
    .badge-normal  {background:#f0fdf4;color:#166534} .badge-normal   .badge-dot{background:#166534}
    .badge-duplikat{background:#fefce8;color:#854d0e} .badge-duplikat .badge-dot{background:#854d0e}
    .badge-koreksi {background:#ede9fe;color:#6d28d9} .badge-koreksi  .badge-dot{background:#6d28d9}
    .badge-manual  {background:#fff7ed;color:#c2410c} .badge-manual   .badge-dot{background:#c2410c}
    .badge-unknown {background:var(--surface2);color:var(--text3)}

    .siswa-card{display:flex;align-items:center;gap:14px;padding:16px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm)}
    .siswa-avatar{width:48px;height:48px;border-radius:12px;background:var(--brand-50);border:2px solid var(--brand-100);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:16px;color:var(--brand-700)}
    .siswa-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text)}
    .siswa-meta{font-size:12.5px;color:var(--text3);margin-top:2px}

    .timeline{display:flex;flex-direction:column;gap:0}
    .tl-item{display:flex;gap:12px;position:relative}
    .tl-item:not(:last-child)::before{content:'';position:absolute;left:15px;top:32px;bottom:-8px;width:1px;background:var(--border)}
    .tl-dot{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid var(--border);background:var(--surface)}
    .tl-dot.green{background:#f0fdf4;border-color:#bbf7d0}
    .tl-dot.blue{background:#eff6ff;border-color:var(--brand-100)}
    .tl-dot.purple{background:#faf5ff;border-color:#e9d5ff}
    .tl-dot.gray{background:var(--surface2)}
    .tl-body{padding-bottom:20px}
    .tl-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .tl-meta{font-size:12px;color:var(--text3);margin-top:2px}

    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);border:1px solid;margin-bottom:16px;font-size:13px}
    .alert-warn{background:#fffbeb;border-color:#fde68a;color:#92400e}
    .alert-info{background:#eff6ff;border-color:var(--brand-100);color:#1e40af}
    .alert-success{background:#f0fdf4;border-color:#bbf7d0;color:#166534}

    code.scan-code{font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2);background:var(--surface2);padding:6px 12px;border-radius:6px;border:1px solid var(--border);display:inline-block;letter-spacing:.05em}

    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:300;align-items:center;justify-content:center}
    .modal-overlay.active{display:flex}
    .modal{background:var(--surface);border-radius:var(--radius);width:420px;max-width:calc(100vw - 32px);box-shadow:0 20px 60px rgba(0,0,0,.15);overflow:hidden}
    .modal-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border)}
    .modal-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text)}
    .modal-close{width:28px;height:28px;display:flex;align-items:center;justify-content:center;border:none;background:var(--surface2);border-radius:6px;cursor:pointer;color:var(--text3)}
    .modal-close:hover{background:var(--surface3);color:var(--text)}
    .modal-body{padding:20px}
    .modal-footer{display:flex;gap:8px;justify-content:flex-end;padding:14px 20px;border-top:1px solid var(--border);background:var(--surface2)}
    .field{display:flex;flex-direction:column;gap:4px;margin-bottom:14px}
    .field:last-child{margin-bottom:0}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text2)}
    .field select,.field input,.field textarea{padding:8px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .field select:focus,.field input:focus,.field textarea:focus{border-color:var(--brand-500);background:#fff}
    .field textarea{resize:vertical;min-height:72px}
    .info-block{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:10px 14px;margin-bottom:16px;font-size:12.5px;color:var(--text2);line-height:1.6}
    .info-block strong{font-weight:700;color:var(--text)}

    @media(max-width:768px){.grid-2,.grid-3{grid-template-columns:1fr}.page{padding:16px}}
</style>

<div class="page">

    {{-- ── Header ──────────────────────────────────────────────────────── --}}
    <div class="page-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.absensi-gerbang.index') }}">Log Absensi Gerbang</a>
                <span class="breadcrumb-sep">/</span>
                <span>Detail Scan #{{ $absensiGerbang->id }}</span>
            </div>
            <h1 class="page-title">Detail Record Scan</h1>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.absensi-gerbang.index', ['tanggal' => $absensiGerbang->tanggal_scan]) }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>

            @if($absensiGerbang->is_valid && !$absensiGerbang->hasilKoreksi)
            <button type="button" class="btn btn-warn"
                    onclick="openKoreksiModal({{ $absensiGerbang->id }}, '{{ addslashes($absensiGerbang->siswa?->nama_lengkap ?? '—') }}', '{{ $absensiGerbang->tipe }}', '{{ $absensiGerbang->label_tipe }}')">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                Koreksi
            </button>
            @endif

            @if(!$absensiGerbang->hasilKoreksi)
            <form action="{{ route('admin.absensi-gerbang.destroy', $absensiGerbang) }}" method="POST" id="formHapus" style="display:inline">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmHapus()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    Hapus
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- ── Alert status khusus ─────────────────────────────────────────── --}}
    @if($absensiGerbang->status === 'duplikat')
    <div class="alert alert-warn">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>Record ini berstatus <strong>duplikat</strong> — siswa sudah tercatat pada tipe dan sesi yang sama sebelumnya.</span>
    </div>
    @endif

    @if($absensiGerbang->koreksiDari)
    <div class="alert alert-info">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><polyline points="12 8 12 12 14 14"/></svg>
        <span>Record ini merupakan <strong>hasil koreksi</strong> dari
            <a href="{{ route('admin.absensi-gerbang.show', $absensiGerbang->koreksiDari) }}" style="color:var(--brand-600);font-weight:700">
                scan #{{ $absensiGerbang->koreksiDari->id }}
            </a>.
        </span>
    </div>
    @endif

    @if($absensiGerbang->hasilKoreksi)
    <div class="alert alert-success">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span>Record ini sudah dikoreksi. Lihat
            <a href="{{ route('admin.absensi-gerbang.show', $absensiGerbang->hasilKoreksi) }}" style="color:#15803d;font-weight:700">
                record koreksi #{{ $absensiGerbang->hasilKoreksi->id }}
            </a>.
        </span>
    </div>
    @endif

    <div class="grid-2" style="margin-bottom:16px">

        {{-- ── Info Siswa ──────────────────────────────────────────────── --}}
        <div class="card">
            <div class="card-header">
                <div class="card-icon blue">
                    <svg width="16" height="16" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                </div>
                <span class="card-title">Informasi Siswa</span>
            </div>
            <div class="card-body">
                @if($absensiGerbang->siswa)
                <div class="siswa-card" style="margin-bottom:16px">
                    <div class="siswa-avatar">{{ strtoupper(substr($absensiGerbang->siswa->nama_lengkap, 0, 1)) }}</div>
                    <div>
                        <p class="siswa-name">{{ $absensiGerbang->siswa->nama_lengkap }}</p>
                        <p class="siswa-meta">NIS: {{ $absensiGerbang->siswa->nis }} &middot; {{ $absensiGerbang->siswa->kelas?->nama_kelas ?? '—' }}</p>
                    </div>
                </div>
                <dl class="dl">
                    <dt>Kelas</dt>
                    <dd class="bold">{{ $absensiGerbang->siswa->kelas?->nama_kelas ?? '—' }}</dd>
                    <dt>NIS</dt>
                    <dd>{{ $absensiGerbang->siswa->nis }}</dd>
                    <dt>Status Siswa</dt>
                    <dd>
                        <span class="badge" style="background:#f0fdf4;color:#166534">Aktif</span>
                    </dd>
                </dl>
                @else
                <div style="text-align:center;padding:20px 0;color:var(--text3)">
                    <svg width="36" height="36" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 8px;display:block"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/><line x1="17" y1="11" x2="22" y2="11"/></svg>
                    <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text2)">Siswa Tidak Dikenal</p>
                    <p style="font-size:12px;margin-top:4px">Kode barcode tidak terdaftar dalam sistem</p>
                </div>
                @endif
            </div>
        </div>

        {{-- ── Info Scan ───────────────────────────────────────────────── --}}
        <div class="card">
            <div class="card-header">
                <div class="card-icon green">
                    <svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M7 7h.01M7 12h.01M7 17h.01M12 7h5M12 12h5M12 17h5"/></svg>
                </div>
                <span class="card-title">Data Scan</span>
            </div>
            <div class="card-body">
                <dl class="dl">
                    <dt>Tanggal</dt>
                    <dd class="bold">{{ \Carbon\Carbon::parse($absensiGerbang->tanggal_scan)->isoFormat('dddd, D MMMM Y') }}</dd>
                    <dt>Waktu Scan</dt>
                    <dd class="bold" style="font-size:16px;color:var(--brand-600)">{{ $absensiGerbang->waktu_scan->format('H:i:s') }}</dd>
                    <dt>Tipe</dt>
                    <dd>
                        <span class="badge badge-{{ $absensiGerbang->tipe }}">
                            <span class="badge-dot"></span>
                            {{ $absensiGerbang->label_tipe }}
                        </span>
                    </dd>
                    <dt>Status</dt>
                    <dd>
                        @php $sc = in_array($absensiGerbang->status, ['normal','duplikat','koreksi','manual']) ? $absensiGerbang->status : 'unknown'; @endphp
                        <span class="badge badge-{{ $sc }}">
                            <span class="badge-dot"></span>
                            {{ $absensiGerbang->label_status }}
                        </span>
                    </dd>
                    <dt>Input Metode</dt>
                    <dd>{{ $absensiGerbang->is_manual ? 'Manual (Piket)' : 'Otomatis (Scanner)' }}</dd>
                </dl>
                <hr class="divider">
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;margin-bottom:8px">Kode Barcode</p>
                <code class="scan-code">{{ $absensiGerbang->kode_scan }}</code>
            </div>
        </div>
    </div>

    <div class="grid-2" style="margin-bottom:16px">

        {{-- ── Info Sesi ───────────────────────────────────────────────── --}}
        <div class="card">
            <div class="card-header">
                <div class="card-icon purple">
                    <svg width="16" height="16" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <span class="card-title">Sesi Gerbang</span>
            </div>
            <div class="card-body">
                @if($absensiGerbang->sesiGerbang)
                <dl class="dl">
                    <dt>Sesi ID</dt>
                    <dd>
                        <a href="{{ route('admin.sesi-gerbang.show', $absensiGerbang->sesiGerbang) }}"
                           style="color:var(--brand-600);font-weight:700;text-decoration:none">
                            #{{ $absensiGerbang->sesiGerbang->id }} — {{ $absensiGerbang->sesiGerbang->label_tipe }}
                        </a>
                    </dd>
                    <dt>Tanggal Sesi</dt>
                    <dd>{{ \Carbon\Carbon::parse($absensiGerbang->sesiGerbang->tanggal)->isoFormat('D MMMM Y') }}</dd>
                    <dt>Dibuka Pukul</dt>
                    <dd>{{ $absensiGerbang->sesiGerbang->dibuka_pada->format('H:i') }}</dd>
                    <dt>Ditutup Pukul</dt>
                    <dd>{{ $absensiGerbang->sesiGerbang->ditutup_pada?->format('H:i') ?? '—' }}</dd>
                    <dt>Dibuka Oleh</dt>
                    <dd>{{ $absensiGerbang->sesiGerbang->dibukaOleh?->name ?? '—' }}</dd>
                    <dt>Status Sesi</dt>
                    <dd>
                        @if($absensiGerbang->sesiGerbang->status === 'aktif')
                            <span class="badge" style="background:#dcfce7;color:#15803d"><span class="badge-dot" style="background:#15803d"></span>Aktif</span>
                        @else
                            <span class="badge badge-unknown">Ditutup</span>
                        @endif
                    </dd>
                </dl>
                @else
                <p class="muted" style="font-size:13px;color:var(--text3)">— Data sesi tidak tersedia —</p>
                @endif
            </div>
        </div>

        {{-- ── Dicatat Oleh ────────────────────────────────────────────── --}}
        <div class="card">
            <div class="card-header">
                <div class="card-icon orange">
                    <svg width="16" height="16" fill="none" stroke="#c2410c" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                </div>
                <span class="card-title">Catatan &amp; Petugas</span>
            </div>
            <div class="card-body">
                <dl class="dl">
                    <dt>Dicatat Oleh</dt>
                    <dd class="bold">{{ $absensiGerbang->inputOleh?->name ?? 'Sistem (Otomatis)' }}</dd>
                    <dt>Dibuat Pada</dt>
                    <dd>{{ $absensiGerbang->created_at->isoFormat('D MMM Y, HH:mm:ss') }}</dd>
                    <dt>Diperbarui</dt>
                    <dd>{{ $absensiGerbang->updated_at->isoFormat('D MMM Y, HH:mm:ss') }}</dd>
                </dl>

                @if($absensiGerbang->catatan)
                <hr class="divider">
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;margin-bottom:8px">Catatan</p>
                <p style="font-size:13.5px;color:var(--text2);line-height:1.6;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:10px 14px">
                    {{ $absensiGerbang->catatan }}
                </p>
                @endif

                @if($absensiGerbang->barcodeGerbang)
                <hr class="divider">
                <dl class="dl">
                    <dt>Barcode ID</dt>
                    <dd>{{ $absensiGerbang->barcodeGerbang->id }}</dd>
                    <dt>Tipe Barcode</dt>
                    <dd>{{ $absensiGerbang->barcodeGerbang->tipe ?? '—' }}</dd>
                </dl>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Riwayat Koreksi ─────────────────────────────────────────────── --}}
    @if($absensiGerbang->koreksiDari || $absensiGerbang->hasilKoreksi)
    <div class="card">
        <div class="card-header">
            <div class="card-icon purple">
                <svg width="16" height="16" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.56"/></svg>
            </div>
            <span class="card-title">Riwayat Koreksi</span>
        </div>
        <div class="card-body">
            <div class="timeline">
                @if($absensiGerbang->koreksiDari)
                <div class="tl-item">
                    <div class="tl-dot blue">
                        <svg width="13" height="13" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 8 12 12 14 14"/></svg>
                    </div>
                    <div class="tl-body">
                        <p class="tl-label">
                            Record asal:
                            <a href="{{ route('admin.absensi-gerbang.show', $absensiGerbang->koreksiDari) }}"
                               style="color:var(--brand-600);text-decoration:none">
                                Scan #{{ $absensiGerbang->koreksiDari->id }}
                            </a>
                        </p>
                        <p class="tl-meta">
                            Tipe asal: {{ $absensiGerbang->koreksiDari->label_tipe }}
                            &middot; {{ $absensiGerbang->koreksiDari->waktu_scan->format('H:i:s') }}
                        </p>
                    </div>
                </div>
                @endif

                <div class="tl-item">
                    <div class="tl-dot green">
                        <svg width="13" height="13" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <div class="tl-body">
                        <p class="tl-label">Record saat ini: Scan #{{ $absensiGerbang->id }}</p>
                        <p class="tl-meta">
                            Tipe: {{ $absensiGerbang->label_tipe }}
                            &middot; Status: {{ $absensiGerbang->label_status }}
                            &middot; {{ $absensiGerbang->waktu_scan->format('H:i:s') }}
                        </p>
                    </div>
                </div>

                @if($absensiGerbang->hasilKoreksi)
                <div class="tl-item">
                    <div class="tl-dot purple">
                        <svg width="13" height="13" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                    </div>
                    <div class="tl-body">
                        <p class="tl-label">
                            Dikoreksi ke:
                            <a href="{{ route('admin.absensi-gerbang.show', $absensiGerbang->hasilKoreksi) }}"
                               style="color:#7c3aed;text-decoration:none">
                                Scan #{{ $absensiGerbang->hasilKoreksi->id }}
                            </a>
                        </p>
                        <p class="tl-meta">
                            Tipe baru: {{ $absensiGerbang->hasilKoreksi->label_tipe }}
                            @if($absensiGerbang->hasilKoreksi->catatan)
                                &middot; "{{ $absensiGerbang->hasilKoreksi->catatan }}"
                            @endif
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

</div>

{{-- ── Modal Koreksi ────────────────────────────────────────────────────── --}}
<div class="modal-overlay" id="koreksiModal">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Koreksi Tipe Scan</span>
            <button type="button" class="modal-close" onclick="closeKoreksiModal()">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" id="koreksiForm" action="">
            @csrf @method('PATCH')
            <div class="modal-body">
                <div class="info-block" id="koreksiInfo"></div>
                <div class="field">
                    <label>Tipe Baru <span style="color:#dc2626">*</span></label>
                    <select name="tipe_baru" id="koreksiTipeBaru" required></select>
                </div>
                <div class="field">
                    <label>Catatan (opsional)</label>
                    <textarea name="catatan" placeholder="Alasan koreksi…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeKoreksiModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Koreksi</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif
    @if($errors->any())
    Swal.fire({ icon:'warning', title:'Perhatian!', html:@json(implode('<br>', $errors->all())), confirmButtonColor:'#1f63db' });
    @endif

    function confirmHapus() {
        Swal.fire({
            title: 'Hapus Record Scan?',
            text: 'Record ini akan dihapus permanen.',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('formHapus').submit(); });
    }

    const koreksiRouteTemplate = @json(route('admin.absensi-gerbang.koreksi', ['absensiGerbang' => '__ID__']));

    function openKoreksiModal(id, nama, tipe, labelTipe) {
        document.getElementById('koreksiForm').action = koreksiRouteTemplate.replace('__ID__', id);
        document.getElementById('koreksiInfo').innerHTML =
            `Siswa: <strong>${nama}</strong><br>Tipe saat ini: <strong>${labelTipe}</strong>`;
        document.getElementById('koreksiTipeBaru').innerHTML = tipe === 'masuk'
            ? '<option value="pulang">Pulang</option>'
            : '<option value="masuk">Masuk</option>';
        document.getElementById('koreksiModal').classList.add('active');
    }
    function closeKoreksiModal() {
        document.getElementById('koreksiModal').classList.remove('active');
    }
    document.getElementById('koreksiModal').addEventListener('click', function(e) {
        if (e.target === this) closeKoreksiModal();
    });
</script>
</x-app-layout>