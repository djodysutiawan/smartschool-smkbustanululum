<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Instrument+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --s-800:#0f2044;--s-700:#1a3a6b;--s-600:#1d4ed8;--s-500:#2563eb;--s-400:#3b82f6;
        --s-100:#dbeafe;--s-50:#eff6ff;
        --g-500:#10b981;--g-100:#d1fae5;--g-50:#ecfdf5;
        --a-500:#f59e0b;--a-100:#fef3c7;--a-50:#fffbeb;
        --r-500:#ef4444;--r-100:#fee2e2;--r-50:#fff5f5;
        --p-500:#8b5cf6;--p-100:#ede9fe;--p-50:#f5f3ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#334155;--text3:#64748b;--text4:#94a3b8;
        --radius:12px;--radius-sm:8px;--radius-xs:6px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.07);--shadow-md:0 4px 16px rgba(0,0,0,.08);
    }
    *{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:'Instrument Sans',sans-serif;}
    .page{padding:24px 28px 64px;}

    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .header-left{display:flex;align-items:center;gap:14px;}
    .back-btn{display:inline-flex;align-items:center;gap:6px;height:36px;padding:0 14px;border-radius:var(--radius-sm);background:var(--surface);border:1px solid var(--border);font-family:'Outfit',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);text-decoration:none;transition:all .15s;flex-shrink:0;}
    .back-btn:hover{background:var(--surface3);color:var(--text);}
    .page-title{font-family:'Outfit',sans-serif;font-size:21px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text4);margin-top:3px;word-break:break-all;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center;}

    .btn{display:inline-flex;align-items:center;gap:7px;height:38px;padding:0 16px;border-radius:var(--radius-sm);font-family:'Outfit',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap;}
    .btn-outline{background:var(--surface);color:var(--text2);border:1px solid var(--border);}
    .btn-outline:hover{background:var(--surface3);}
    .btn-warning{background:var(--a-50);color:var(--a-500);border:1px solid var(--a-100);}
    .btn-warning:hover{background:var(--a-100);}
    .btn-danger{background:var(--r-50);color:var(--r-500);border:1px solid var(--r-100);}
    .btn-danger:hover{background:var(--r-100);}
    .btn-info{background:var(--s-50);color:var(--s-600);border:1px solid var(--s-100);}
    .btn-info:hover{background:var(--s-100);}

    .detail-grid{display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start;}

    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-sm);overflow:hidden;margin-bottom:20px;}
    .card:last-child{margin-bottom:0;}
    .card-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border);}
    .card-header-title{font-family:'Outfit',sans-serif;font-size:14px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px;}
    .card-body{padding:20px;}

    .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .info-label{font-family:'Outfit',sans-serif;font-size:11px;font-weight:700;color:var(--text4);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;}
    .info-value{font-size:14px;color:var(--text);font-weight:500;}

    /* ── Barcode preview card ── */
    .barcode-preview-card{border-radius:var(--radius);padding:24px 20px;text-align:center;position:relative;overflow:hidden;}
    .barcode-preview-card.siswa-bg{background:linear-gradient(145deg,var(--s-800),var(--s-700));}
    .barcode-preview-card.guru-bg{background:linear-gradient(145deg,#2d1b69,var(--p-500));}
    .barcode-preview-card::before{content:'';position:absolute;top:-30px;right:-30px;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.04);pointer-events:none;}
    .barcode-wrap-white{background:#fff;border-radius:10px;padding:16px 14px 10px;display:inline-block;width:100%;max-width:260px;}
    .barcode-wrap-white svg{width:100%;height:auto;display:block;}
    .barcode-kode-text{font-family:'Outfit',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);margin-top:8px;letter-spacing:.08em;}
    .barcode-owner-nama{font-family:'Outfit',sans-serif;font-size:15px;font-weight:800;color:#fff;margin-top:14px;}
    .barcode-owner-meta{font-size:12px;color:rgba(255,255,255,.5);margin-top:4px;}

    /* ── Tipe indicator ── */
    .tipe-pill{display:inline-flex;align-items:center;gap:5px;font-family:'Outfit',sans-serif;font-size:11px;font-weight:700;padding:3px 10px;border-radius:99px;margin-top:10px;}
    .tipe-pill.siswa{background:rgba(59,130,246,.2);color:#93c5fd;}
    .tipe-pill.guru{background:rgba(139,92,246,.2);color:#c4b5fd;}

    .badge{display:inline-flex;align-items:center;gap:5px;font-family:'Outfit',sans-serif;font-size:11px;font-weight:700;padding:3px 10px;border-radius:99px;}
    .badge-dot{width:6px;height:6px;border-radius:50%;}
    .badge.aktif{background:var(--g-50);color:var(--g-500);border:1px solid var(--g-100);}
    .badge.aktif .badge-dot{background:var(--g-500);animation:pulse-dot 1.4s infinite;}
    .badge.nonaktif{background:var(--surface3);color:var(--text4);border:1px solid var(--border);}
    .badge.kadaluarsa{background:var(--a-50);color:var(--a-500);border:1px solid var(--a-100);}
    @keyframes pulse-dot{0%,100%{opacity:1}50%{opacity:.4}}

    table{width:100%;border-collapse:collapse;}
    thead th{padding:10px 16px;text-align:left;font-family:'Outfit',sans-serif;font-size:11px;font-weight:800;color:var(--text4);text-transform:uppercase;letter-spacing:.07em;background:var(--surface2);border-bottom:1px solid var(--border);}
    tbody tr{border-bottom:1px solid var(--border);}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:var(--s-50);}
    tbody td{padding:11px 16px;font-size:13px;color:var(--text2);vertical-align:middle;}

    .status-scan{display:inline-flex;align-items:center;gap:4px;font-family:'Outfit',sans-serif;font-size:11px;font-weight:700;padding:2px 8px;border-radius:99px;}
    .status-scan.normal{background:var(--g-50);color:var(--g-500);}
    .status-scan.manual{background:var(--s-50);color:var(--s-500);}
    .status-scan.koreksi{background:var(--a-50);color:var(--a-500);}
    .status-scan.duplikat{background:var(--surface3);color:var(--text4);}

    .history-item{display:flex;align-items:center;gap:12px;padding:12px 0;border-bottom:1px solid var(--border);}
    .history-item:last-child{border-bottom:none;}
    .history-kode{font-family:'Outfit',sans-serif;font-size:12.5px;font-weight:700;color:var(--text);}
    .history-meta{font-size:11.5px;color:var(--text4);margin-top:2px;}
    .history-current{background:var(--s-50);border-radius:var(--radius-xs);padding:12px;border:1px solid var(--s-100);}

    .alert{display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-size:13px;}
    .alert-success{background:var(--g-50);border:1px solid var(--g-100);color:#065f46;}
    .alert-error{background:var(--r-50);border:1px solid var(--r-100);color:#991b1b;}

    .empty-scan{padding:32px 20px;text-align:center;color:var(--text4);font-size:13px;}

    @media(max-width:768px){
        .page{padding:14px 14px 56px;}
        .detail-grid{grid-template-columns:1fr;}
        .info-grid{grid-template-columns:1fr;}
    }
</style>

<div class="page">

    {{-- ── Header ── --}}
    <div class="page-header">
        <div class="header-left">
            <a href="{{ route('admin.barcode-gerbang.index') }}" class="back-btn">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <div>
                <h1 class="page-title">Detail Barcode Gerbang</h1>
                <p class="page-sub">
                    @if($barcodeGerbang->tipe_pemilik === 'guru')
                        {{ $barcodeGerbang->guru->nama_lengkap ?? '—' }}
                    @else
                        {{ $barcodeGerbang->siswa->nama_lengkap ?? '—' }}
                    @endif
                    · {{ $barcodeGerbang->kode }}
                </p>
            </div>
        </div>
        <div class="header-actions">
            {{-- Cetak (hanya jika berlaku) --}}
            @if($barcodeGerbang->masih_berlaku)
                <a href="{{ route('admin.barcode-gerbang.print-satu', $barcodeGerbang) }}" target="_blank" class="btn btn-info">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
                    Cetak
                </a>
            @endif

            {{-- Nonaktifkan (hanya jika aktif) --}}
            @if($barcodeGerbang->is_aktif)
                <form method="POST" action="{{ route('admin.barcode-gerbang.nonaktifkan', $barcodeGerbang) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-warning">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                        Nonaktifkan
                    </button>
                </form>
            @endif

            {{-- Hapus --}}
            <form method="POST" action="{{ route('admin.barcode-gerbang.destroy', $barcodeGerbang) }}"
                  onsubmit="return confirm('Hapus barcode ini? Tindakan tidak bisa dibatalkan.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="detail-grid">

        {{-- ── Kiri ── --}}
        <div>
            {{-- Info Barcode --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-header-title">
                        <svg width="14" height="14" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9V5a2 2 0 0 1 2-2h4M3 15v4a2 2 0 0 0 2 2h4M21 9V5a2 2 0 0 0-2-2h-4M21 15v4a2 2 0 0 1-2 2h-4"/></svg>
                        Informasi Barcode
                    </span>
                    @if($barcodeGerbang->masih_berlaku)
                        <span class="badge aktif"><span class="badge-dot"></span>Aktif &amp; Berlaku</span>
                    @elseif(! $barcodeGerbang->is_aktif)
                        <span class="badge nonaktif">Nonaktif</span>
                    @else
                        <span class="badge kadaluarsa">Kadaluarsa</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div>
                            <p class="info-label">Kode Barcode</p>
                            <p class="info-value" style="font-family:'Outfit',sans-serif;font-weight:800;letter-spacing:.06em;word-break:break-all">{{ $barcodeGerbang->kode }}</p>
                        </div>
                        <div>
                            <p class="info-label">Tipe Pemilik</p>
                            <p class="info-value" style="text-transform:capitalize">{{ $barcodeGerbang->tipe_pemilik }}</p>
                        </div>
                        <div>
                            <p class="info-label">Status</p>
                            <p class="info-value">{{ $barcodeGerbang->label_status ?? ($barcodeGerbang->is_aktif ? 'Aktif' : 'Nonaktif') }}</p>
                        </div>
                        <div>
                            <p class="info-label">Dibuat</p>
                            <p class="info-value">{{ $barcodeGerbang->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="info-label">Berlaku Mulai</p>
                            <p class="info-value">{{ $barcodeGerbang->berlaku_mulai?->format('d M Y') ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="info-label">Berlaku Sampai</p>
                            <p class="info-value">{{ $barcodeGerbang->berlaku_sampai?->format('d M Y') ?? 'Selamanya' }}</p>
                        </div>
                        @if($barcodeGerbang->keterangan)
                        <div style="grid-column:1/-1">
                            <p class="info-label">Keterangan</p>
                            <p class="info-value">{{ $barcodeGerbang->keterangan }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Info Pemilik (Siswa atau Guru) --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-header-title">
                        <svg width="14" height="14" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Data {{ $barcodeGerbang->tipe_pemilik === 'guru' ? 'Guru' : 'Siswa' }}
                    </span>
                </div>
                <div class="card-body">
                    @if($barcodeGerbang->tipe_pemilik === 'guru')
                        {{-- Data Guru --}}
                        <div class="info-grid">
                            <div>
                                <p class="info-label">Nama Lengkap</p>
                                <p class="info-value">{{ $barcodeGerbang->guru->nama_lengkap ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="info-label">NIP</p>
                                <p class="info-value">{{ $barcodeGerbang->guru->nip ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="info-label">Status Kepegawaian</p>
                                <p class="info-value">{{ $barcodeGerbang->guru->status_kepegawaian ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="info-label">Status</p>
                                <p class="info-value" style="text-transform:capitalize">{{ $barcodeGerbang->guru->status ?? '—' }}</p>
                            </div>
                        </div>
                    @else
                        {{-- Data Siswa --}}
                        <div class="info-grid">
                            <div>
                                <p class="info-label">Nama Lengkap</p>
                                <p class="info-value">{{ $barcodeGerbang->siswa->nama_lengkap ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="info-label">NIS</p>
                                <p class="info-value">{{ $barcodeGerbang->siswa->nis ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="info-label">NISN</p>
                                <p class="info-value">{{ $barcodeGerbang->siswa->nisn ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="info-label">Kelas</p>
                                <p class="info-value">{{ $barcodeGerbang->siswa->kelas->nama_kelas ?? '—' }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Riwayat Scan --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-header-title">
                        <svg width="14" height="14" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        Riwayat Scan (50 Terakhir)
                    </span>
                    <span style="font-size:12px;color:var(--text4)">{{ $barcodeGerbang->absensiGerbang->count() }} scan</span>
                </div>

                @if($barcodeGerbang->absensiGerbang->isEmpty())
                    <div class="empty-scan">Belum ada riwayat scan menggunakan barcode ini.</div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Waktu Scan</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barcodeGerbang->absensiGerbang as $scan)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($scan->waktu_scan)->format('d M Y, H:i:s') }}</td>
                                    <td style="font-family:'Outfit',sans-serif;font-weight:700">
                                        {{ $scan->tipe === 'masuk' ? '→ Masuk' : '← Pulang' }}
                                    </td>
                                    <td>
                                        <span class="status-scan {{ $scan->status }}">{{ ucfirst($scan->status) }}</span>
                                    </td>
                                    <td style="color:var(--text4)">{{ $scan->keterangan ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        {{-- ── Kanan ── --}}
        <div>
            {{-- Barcode Visual --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-header-title">Tampilan Barcode</span>
                    @if($barcodeGerbang->masih_berlaku)
                        <a href="{{ route('admin.barcode-gerbang.print-satu', $barcodeGerbang) }}" target="_blank"
                           class="btn btn-info" style="height:30px;padding:0 10px;font-size:11.5px">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
                            Cetak
                        </a>
                    @endif
                </div>
                <div class="card-body" style="padding:0">
                    <div class="barcode-preview-card {{ $barcodeGerbang->tipe_pemilik === 'guru' ? 'guru-bg' : 'siswa-bg' }}">
                        <div class="barcode-wrap-white">
                            <svg id="barcode-detail-svg"></svg>
                            <p class="barcode-kode-text">{{ $barcodeGerbang->kode }}</p>
                        </div>
                        @if($barcodeGerbang->tipe_pemilik === 'guru')
                            <p class="barcode-owner-nama">{{ $barcodeGerbang->guru->nama_lengkap ?? '—' }}</p>
                            <p class="barcode-owner-meta">NIP {{ $barcodeGerbang->guru->nip ?? '—' }}</p>
                        @else
                            <p class="barcode-owner-nama">{{ $barcodeGerbang->siswa->nama_lengkap ?? '—' }}</p>
                            <p class="barcode-owner-meta">{{ $barcodeGerbang->siswa->kelas->nama_kelas ?? '—' }}</p>
                        @endif
                        <div>
                            <span class="tipe-pill {{ $barcodeGerbang->tipe_pemilik }}">
                                {{ $barcodeGerbang->tipe_pemilik === 'guru' ? 'Guru / Staf' : 'Siswa' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Riwayat Barcode Pemilik --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-header-title">
                        <svg width="14" height="14" fill="none" stroke="var(--s-500)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Riwayat Barcode {{ $barcodeGerbang->tipe_pemilik === 'guru' ? 'Guru' : 'Siswa' }}
                    </span>
                </div>
                <div class="card-body">
                    @forelse($riwayatBarcode as $rb)
                        <div class="history-item {{ $rb->id === $barcodeGerbang->id ? 'history-current' : '' }}">
                            <div style="flex:1;min-width:0">
                                <p class="history-kode" style="word-break:break-all">{{ $rb->kode }}</p>
                                <p class="history-meta">
                                    {{ $rb->created_at->format('d M Y') }}
                                    @if($rb->id === $barcodeGerbang->id)
                                        · <strong style="color:var(--s-500)">Ini</strong>
                                    @endif
                                </p>
                            </div>
                            @if($rb->is_aktif && ! $rb->trashed())
                                <span class="badge aktif"><span class="badge-dot"></span>Aktif</span>
                            @else
                                <span class="badge nonaktif">Nonaktif</span>
                            @endif
                        </div>
                    @empty
                        <p style="font-size:13px;color:var(--text4);text-align:center;padding:20px 0">Belum ada riwayat.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script>
try {
    JsBarcode('#barcode-detail-svg', '{{ $barcodeGerbang->kode }}', {
        format: 'CODE128', width: 2, height: 70,
        displayValue: false, margin: 0, lineColor: '#0f172a',
    });
} catch(e) { console.warn('JsBarcode error:', e); }
</script>
</x-app-layout>