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
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap}

    /* Breadcrumb */
    .breadcrumb{display:flex;align-items:center;gap:6px;margin-bottom:20px;flex-wrap:wrap}
    .breadcrumb a{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--brand-600);text-decoration:none}
    .breadcrumb a:hover{text-decoration:underline}
    .breadcrumb-sep{color:var(--text3);font-size:12px}
    .breadcrumb-cur{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3)}

    /* Buttons */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    /* Card */
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .card-body{padding:20px}

    /* Date hero */
    .date-banner{background:linear-gradient(135deg,var(--brand-600) 0%,var(--brand-700) 100%);border-radius:var(--radius);padding:20px 24px;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap}
    .date-banner-left .hari{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:rgba(255,255,255,.7);text-transform:uppercase;letter-spacing:.05em}
    .date-banner-left .tanggal{font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;font-weight:800;color:#fff;line-height:1.2;margin-top:2px}
    .date-banner-right{display:flex;gap:24px;flex-wrap:wrap}
    .date-stat{text-align:center}
    .date-stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;font-weight:800;color:#fff;line-height:1}
    .date-stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:rgba(255,255,255,.65);text-transform:uppercase;letter-spacing:.04em;margin-top:3px}

    /* Detail sections */
    .detail-section{margin-bottom:20px}
    .detail-section:last-child{margin-bottom:0}
    .detail-section-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.06em;text-transform:uppercase;margin-bottom:10px;padding-bottom:8px;border-bottom:1px solid var(--border)}
    .detail-content{font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text);line-height:1.7;white-space:pre-line}
    .detail-empty{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text3);font-style:italic}

    /* Izin keluar table */
    .izin-table{width:100%;border-collapse:collapse;font-size:13px;margin-top:10px}
    .izin-table thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    .izin-table thead th{padding:9px 12px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase}
    .izin-table tbody tr{border-bottom:1px solid #f1f5f9}
    .izin-table tbody tr:last-child{border-bottom:none}
    .izin-table td{padding:9px 12px;color:var(--text);vertical-align:middle}

    /* Status badges */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;white-space:nowrap}
    .badge-disetujui{background:#dcfce7;color:#15803d}
    .badge-ditolak{background:#fee2e2;color:#dc2626}
    .badge-menunggu{background:#fef9c3;color:#a16207}
    .badge-kembali{background:#eff6ff;color:#1d4ed8}

    /* Stat pills for izin summary */
    .izin-summary{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:14px}
    .izin-pill{display:flex;align-items:center;gap:6px;padding:6px 12px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;border:1px solid var(--border);background:var(--surface2)}
    .izin-pill .num{font-size:16px;font-weight:800}

    /* Meta footer */
    .meta-strip{display:flex;flex-wrap:wrap;gap:16px;padding:14px 20px;background:var(--surface2);border-top:1px solid var(--border)}
    .meta-item{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text2)}

    @media(max-width:640px){.page{padding:16px}}
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('piket.laporan.riwayat') }}">Riwayat Laporan</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-cur">{{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('d F Y') }}</span>
    </div>

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Laporan Harian</h1>
            <p class="page-sub">Dibuat oleh {{ $laporan->dibuatOleh->name ?? '—' }}</p>
        </div>
        <div class="header-actions">
            @if(\Carbon\Carbon::parse($laporan->tanggal)->isToday())
            <a href="{{ route('piket.laporan.harian') }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit Laporan
            </a>
            @endif
            <a href="{{ route('piket.laporan.riwayat') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Date banner with izin summary stats --}}
    <div class="date-banner">
        <div class="date-banner-left">
            <p class="hari">{{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('l') }}</p>
            <p class="tanggal">{{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('d F Y') }}</p>
        </div>
        <div class="date-banner-right">
            <div class="date-stat">
                <p class="date-stat-val">{{ $ringkasanIzin['total'] }}</p>
                <p class="date-stat-label">Total Izin</p>
            </div>
            <div class="date-stat">
                <p class="date-stat-val">{{ $ringkasanIzin['disetujui'] }}</p>
                <p class="date-stat-label">Disetujui</p>
            </div>
            <div class="date-stat">
                <p class="date-stat-val" style="{{ $ringkasanIzin['ditolak'] > 0 ? 'color:#fca5a5' : '' }}">{{ $ringkasanIzin['ditolak'] }}</p>
                <p class="date-stat-label">Ditolak</p>
            </div>
        </div>
    </div>

    {{-- Isi laporan --}}
    <div class="card">
        <div class="card-header">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            <span class="card-title">Isi Laporan</span>
        </div>
        <div class="card-body">

            {{-- Kondisi sekolah --}}
            <div class="detail-section">
                <p class="detail-section-title">Kondisi Sekolah</p>
                @if($laporan->kondisi_sekolah)
                    <p class="detail-content">{{ $laporan->kondisi_sekolah }}</p>
                @else
                    <p class="detail-empty">Tidak diisi</p>
                @endif
            </div>

            {{-- Catatan umum --}}
            <div class="detail-section">
                <p class="detail-section-title">Catatan Umum</p>
                @if($laporan->catatan_umum)
                    <p class="detail-content">{{ $laporan->catatan_umum }}</p>
                @else
                    <p class="detail-empty">Tidak ada catatan umum</p>
                @endif
            </div>

            {{-- Tamu penting --}}
            <div class="detail-section">
                <p class="detail-section-title">Tamu Penting</p>
                @if($laporan->tamu_penting)
                    <p class="detail-content">{{ $laporan->tamu_penting }}</p>
                @else
                    <p class="detail-empty">Tidak ada tamu penting yang dicatat</p>
                @endif
            </div>

            {{-- Kejadian khusus --}}
            <div class="detail-section">
                <p class="detail-section-title">Kejadian Khusus</p>
                @if($laporan->kejadian_khusus)
                    <p class="detail-content">{{ $laporan->kejadian_khusus }}</p>
                @else
                    <p class="detail-empty">Tidak ada kejadian khusus yang dicatat</p>
                @endif
            </div>

        </div>

        {{-- Meta footer --}}
        <div class="meta-strip">
            <div class="meta-item">
                <svg width="13" height="13" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                {{ $laporan->dibuatOleh->name ?? '—' }}
            </div>
            <div class="meta-item">
                <svg width="13" height="13" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Dibuat {{ \Carbon\Carbon::parse($laporan->created_at)->translatedFormat('d F Y, H:i') }}
            </div>
            @if($laporan->updated_at && $laporan->updated_at->ne($laporan->created_at))
            <div class="meta-item">
                <svg width="13" height="13" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Diperbarui {{ \Carbon\Carbon::parse($laporan->updated_at)->translatedFormat('d F Y, H:i') }}
            </div>
            @endif
        </div>
    </div>

    {{-- Izin keluar hari itu --}}
    @if($izinHariIni->count() > 0)
    <div class="card">
        <div class="card-header">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            <span class="card-title">Izin Keluar Siswa pada Hari Ini</span>
        </div>
        <div class="card-body" style="padding-bottom:0">
            <div class="table-wrap">
                <table class="izin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Jam Keluar</th>
                            <th>Keperluan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($izinHariIni as $i => $izin)
                        <tr>
                            <td style="color:var(--text3);font-size:12px;font-weight:700">{{ $i + 1 }}</td>
                            <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">{{ $izin->siswa->nama_lengkap ?? '—' }}</td>
                            <td style="color:var(--text3);font-size:12.5px">{{ $izin->siswa->kelas->nama_kelas ?? '—' }}</td>
                            <td style="font-size:13px">{{ $izin->jam_keluar ? \Carbon\Carbon::parse($izin->jam_keluar)->format('H:i') : '—' }}</td>
                            <td style="font-size:12.5px;color:var(--text2);max-width:180px">{{ $izin->keperluan ?? '—' }}</td>
                            <td>
                                @php
                                    $statusMap = [
                                        \App\Models\IzinKeluarSiswa::STATUS_DISETUJUI      => ['label' => 'Disetujui',      'class' => 'badge-disetujui'],
                                        \App\Models\IzinKeluarSiswa::STATUS_DITOLAK         => ['label' => 'Ditolak',         'class' => 'badge-ditolak'],
                                        \App\Models\IzinKeluarSiswa::STATUS_SUDAH_KEMBALI   => ['label' => 'Sudah Kembali',   'class' => 'badge-kembali'],
                                    ];
                                    $s = $statusMap[$izin->status] ?? ['label' => ucfirst($izin->status ?? 'Menunggu'), 'class' => 'badge-menunggu'];
                                @endphp
                                <span class="badge {{ $s['class'] }}">{{ $s['label'] }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text: @json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif
</script>
</x-app-layout>