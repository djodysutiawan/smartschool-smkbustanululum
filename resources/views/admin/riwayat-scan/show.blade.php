<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 60px;max-width:860px;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand);}
    .breadcrumb .sep{color:var(--border2);}.breadcrumb .current{color:var(--text2);}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}.btn-back:hover{background:var(--surface3);filter:none;}
    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px;}
    .detail-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;background:var(--surface2);}
    .detail-header-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:0;}
    .detail-item{padding:13px 20px;border-bottom:1px solid var(--border);display:flex;flex-direction:column;gap:4px;}
    .detail-item:nth-child(odd){border-right:1px solid var(--border);}
    .detail-item.full{grid-column:span 2;border-right:none;}
    .detail-item:last-child,.detail-item:nth-last-child(1){border-bottom:none;}
    .detail-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;}
    .detail-value{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);font-weight:500;}
    /* BUGFIX: badge sesuai enum berhasil|gagal_kadaluarsa|gagal_lokasi|gagal_duplikat */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-berhasil{background:#dcfce7;color:#15803d;}.badge-berhasil .badge-dot{background:#15803d;}
    .badge-gagal_kadaluarsa{background:#fef9c3;color:#a16207;}.badge-gagal_kadaluarsa .badge-dot{background:#a16207;}
    .badge-gagal_lokasi{background:#fee2e2;color:#dc2626;}.badge-gagal_lokasi .badge-dot{background:#dc2626;}
    .badge-gagal_duplikat{background:#fdf4ff;color:#7c3aed;}.badge-gagal_duplikat .badge-dot{background:#7c3aed;}
    .map-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:16px;display:flex;flex-direction:column;gap:8px;}
    .map-coords{font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2);font-weight:600;}
    .map-link{display:inline-flex;align-items:center;gap:5px;color:var(--brand);font-size:12.5px;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;text-decoration:none;margin-top:4px;}
    .map-link:hover{text-decoration:underline;}
    .device-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:10px 14px;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text2);line-height:1.5;word-break:break-all;}
    @media(max-width:640px){.page{padding:16px;}.detail-grid{grid-template-columns:1fr;}.detail-item:nth-child(odd){border-right:none;}.detail-item.full{grid-column:span 1;}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.riwayat-scan.index') }}">Riwayat Scan QR</a>
        <span class="sep">›</span>
        <span class="current">Detail #{{ $riwayatScan->id }}</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Scan QR</h1>
            <p class="page-sub">
                {{ $riwayatScan->siswa->nama_lengkap ?? '—' }}
                — {{ $riwayatScan->dipindai_pada?->translatedFormat('d F Y') ?? '-' }}
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.riwayat-scan.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- ─── Info Scan ───────────────────────────────────────────────────────── --}}
    <div class="detail-card">
        <div class="detail-header">
            <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            <p class="detail-header-title">Informasi Scan</p>
        </div>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">Nama Siswa</span>
                <span class="detail-value" style="font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;">
                    {{ $riwayatScan->siswa->nama_lengkap ?? '—' }}
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">NIS</span>
                <span class="detail-value">{{ $riwayatScan->siswa->nis ?? '—' }}</span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Kelas</span>
                <span class="detail-value">{{ $riwayatScan->sesiQr->kelas->nama_kelas ?? '—' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Mata Pelajaran</span>
                <span class="detail-value">{{ $riwayatScan->sesiQr->mataPelajaran->nama_mapel ?? 'Tidak ditentukan' }}</span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Sesi QR</span>
                <span class="detail-value">
                    Sesi #{{ $riwayatScan->sesi_qr_id }}
                    <a href="{{ route('admin.sesi-qr.show', $riwayatScan->sesi_qr_id) }}"
                       style="font-size:12px;color:var(--brand);margin-left:6px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;text-decoration:none;">
                        Lihat →
                    </a>
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Hasil Scan</span>
                <span class="detail-value">
                    {{-- BUGFIX: badge & label sesuai enum hasil yang benar --}}
                    <span class="badge badge-{{ $riwayatScan->hasil }}">
                        <span class="badge-dot"></span>
                        @switch($riwayatScan->hasil)
                            @case('berhasil')         Berhasil @break
                            @case('gagal_kadaluarsa') Gagal – Kadaluarsa @break
                            @case('gagal_lokasi')     Gagal – Lokasi @break
                            @case('gagal_duplikat')   Gagal – Duplikat @break
                            @default {{ ucfirst($riwayatScan->hasil ?? '-') }}
                        @endswitch
                    </span>
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Tanggal</span>
                <span class="detail-value">{{ $riwayatScan->dipindai_pada?->translatedFormat('l, d F Y') ?? '—' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Waktu Dipindai</span>
                <span class="detail-value" style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:18px;color:var(--brand);">
                    {{ $riwayatScan->dipindai_pada?->format('H:i:s') ?? '—' }}
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">IP Address</span>
                <span class="detail-value">{{ $riwayatScan->ip_address ?? '—' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Dicatat Pada</span>
                <span class="detail-value">{{ $riwayatScan->created_at?->format('d F Y, H:i:s') ?? '—' }}</span>
            </div>

            @if($riwayatScan->info_perangkat)
            <div class="detail-item full">
                <span class="detail-label">Info Perangkat</span>
                <div class="device-box">{{ $riwayatScan->info_perangkat }}</div>
            </div>
            @endif
        </div>
    </div>

    {{-- ─── Lokasi GPS ──────────────────────────────────────────────────────── --}}
    @if($riwayatScan->latitude && $riwayatScan->longitude)
    <div class="detail-card">
        <div class="detail-header">
            <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="10" r="3"/><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
            <p class="detail-header-title">Lokasi GPS</p>
        </div>
        <div style="padding:20px 24px;">
            <div class="map-box">
                <p class="detail-label" style="margin-bottom:4px">Koordinat</p>
                <p class="map-coords">
                    Lat: {{ $riwayatScan->latitude }} &nbsp;|&nbsp; Lon: {{ $riwayatScan->longitude }}
                </p>
                <a href="https://www.google.com/maps?q={{ $riwayatScan->latitude }},{{ $riwayatScan->longitude }}"
                   target="_blank" class="map-link">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    Buka di Google Maps
                </a>
            </div>
        </div>
    </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif
</script>
</x-app-layout>