<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-h:#3582f0;--brand-700:#1750c0;--brand-100:#d9ebff;--brand-50:#eef6ff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--red:#dc2626;--red-bg:#fee2e2;--radius:10px;--radius-sm:7px;}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand);}
    .breadcrumb .sep{color:var(--border2);}.breadcrumb .current{color:var(--text2);}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border);padding:8px 14px;}
    .btn-back:hover{background:var(--surface3);filter:none;}
    .btn-nonaktif{background:#fefce8;color:#a16207;border:1px solid #fde68a;}
    .btn-nonaktif:hover{background:#fef9c3;filter:none;}
    .btn-del{background:#fff0f0;color:var(--red);border:1px solid #fecaca;}
    .btn-del:hover{background:#fee2e2;filter:none;}
    .btn-cetak{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}
    .btn-cetak:hover{background:var(--brand-100);filter:none;}
    .layout-grid{display:grid;grid-template-columns:360px 1fr;gap:20px;}
    .qr-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:20px;}
    .qr-card:last-child{margin-bottom:0;}
    .qr-header-bar{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;}
    .qr-header-bar-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:800;color:var(--text);}
    .qr-display{padding:24px;text-align:center;background:linear-gradient(135deg,var(--brand-50) 0%,#e0f0ff 100%);}
    .qr-wrapper{background:#fff;border-radius:16px;padding:20px;display:inline-block;box-shadow:0 4px 20px rgba(31,99,219,.15);border:2px solid var(--brand-100);}
    .qr-img{width:200px;height:200px;display:block;}
    .qr-token{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.12em;margin-top:12px;text-transform:uppercase;}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-aktif{background:#dcfce7;color:#15803d;}.badge-aktif .badge-dot{background:#15803d;}
    .badge-nonaktif{background:#fee2e2;color:#dc2626;}.badge-nonaktif .badge-dot{background:#dc2626;}
    .badge-kadaluarsa{background:#fef9c3;color:#a16207;}.badge-kadaluarsa .badge-dot{background:#a16207;}
    /* BUGFIX: enum hasil = berhasil|gagal_kadaluarsa|gagal_lokasi|gagal_duplikat */
    .badge-berhasil{background:#dcfce7;color:#15803d;}
    .badge-gagal_kadaluarsa{background:#fef9c3;color:#a16207;}
    .badge-gagal_lokasi{background:#fff0f0;color:#dc2626;}
    .badge-gagal_duplikat{background:#fdf4ff;color:#7c3aed;}
    .info-list{padding:0;list-style:none;}
    .info-list li{display:flex;align-items:flex-start;gap:10px;padding:11px 20px;border-bottom:1px solid var(--border);font-size:13px;}
    .info-list li:last-child{border-bottom:none;}
    .info-icon{width:16px;flex-shrink:0;margin-top:1px;color:var(--text3);}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;margin-bottom:2px;}
    .info-val{font-size:13.5px;color:var(--text);font-family:'DM Sans',sans-serif;}
    .card-actions{padding:16px 20px;border-top:1px solid var(--border);display:flex;gap:8px;flex-wrap:wrap;}
    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:20px;}
    .detail-card:last-child{margin-bottom:0;}
    .detail-topbar{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
    .detail-topbar-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px;}
    .icon-wrap{width:28px;height:28px;border-radius:7px;background:var(--brand-50);display:flex;align-items:center;justify-content:center;}
    table{width:100%;border-collapse:collapse;font-size:13px;}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:#fafbff;}
    td{padding:9px 14px;vertical-align:middle;color:var(--text);}
    .empty-box{padding:40px 20px;text-align:center;color:var(--text3);font-size:13.5px;font-family:'Plus Jakarta Sans',sans-serif;}
    .countdown-box{padding:16px 20px;border-top:1px solid var(--border);background:var(--surface2);text-align:center;}
    .countdown-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;}
    .countdown-time{font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;font-weight:800;color:var(--text);}
    @media(max-width:900px){.layout-grid{grid-template-columns:1fr;}.page{padding:16px 16px 40px;}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.sesi-qr.index') }}">Sesi QR</a>
        <span class="sep">›</span>
        <span class="current">Detail Sesi</span>
    </nav>
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Sesi QR Code</h1>
            <p class="page-sub">{{ $sesiQr->kelas->nama_kelas ?? '—' }} — {{ $sesiQr->mataPelajaran->nama_mapel ?? 'Tanpa Mata Pelajaran' }}</p>
        </div>
        <a href="{{ route('admin.sesi-qr.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    @php
        $now        = \Carbon\Carbon::now();
        // BUGFIX: pakai is_active (kolom migrasi), bukan ->nonaktif
        $aktif      = $sesiQr->is_active && $now->between($sesiQr->berlaku_mulai, $sesiQr->kadaluarsa_pada);
        $kadaluarsa = $now->gt($sesiQr->kadaluarsa_pada);

        // BUGFIX: enum hasil = berhasil|gagal_kadaluarsa|gagal_lokasi|gagal_duplikat
        // Hitung total gagal = semua yang bukan 'berhasil'
        $totalBerhasil = $sesiQr->riwayatScan->where('hasil', 'berhasil')->count();
        $totalGagal    = $sesiQr->riwayatScan->whereNotIn('hasil', ['berhasil'])->count();

        // Label badge untuk tiap nilai enum
        $hasilLabel = [
            'berhasil'         => 'Berhasil',
            'gagal_kadaluarsa' => 'Gagal – Kadaluarsa',
            'gagal_lokasi'     => 'Gagal – Lokasi',
            'gagal_duplikat'   => 'Gagal – Duplikat',
        ];
    @endphp

    <div class="layout-grid">
        {{-- ─── Left: QR Display + Info ──────────────────────────────────── --}}
        <div>
            <div class="qr-card">
                <div class="qr-header-bar">
                    <div style="flex:1">
                        <p class="qr-header-bar-title">QR Code Sesi</p>
                    </div>
                    @if(!$sesiQr->is_active)
                        <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                    @elseif($kadaluarsa)
                        <span class="badge badge-kadaluarsa"><span class="badge-dot"></span>Kadaluarsa</span>
                    @elseif($aktif)
                        <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                    @else
                        <span class="badge" style="background:var(--surface3);color:var(--text3)">Belum Dimulai</span>
                    @endif
                </div>

                <div class="qr-display">
                    <div class="qr-wrapper">
                        {{-- QR Code: encode kode_qr (UUID) yang disimpan di kolom kode_qr --}}
                        <img class="qr-img"
                             src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{ urlencode($sesiQr->kode_qr) }}&choe=UTF-8"
                             alt="QR Code Sesi">
                    </div>
                    <p class="qr-token">ID Sesi: #{{ str_pad($sesiQr->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>

                @if($aktif)
                <div class="countdown-box">
                    <p class="countdown-label">Sesi berakhir dalam</p>
                    <p class="countdown-time" id="countdown">—</p>
                </div>
                @endif

                <ul class="info-list">
                    <li>
                        <svg class="info-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        <div><p class="info-label">Kelas</p><p class="info-val">{{ $sesiQr->kelas->nama_kelas ?? '—' }}</p></div>
                    </li>
                    <li>
                        <svg class="info-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        <div><p class="info-label">Mata Pelajaran</p><p class="info-val">{{ $sesiQr->mataPelajaran->nama_mapel ?? 'Tidak ditentukan' }}</p></div>
                    </li>
                    <li>
                        <svg class="info-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <div><p class="info-label">Tanggal</p><p class="info-val">{{ \Carbon\Carbon::parse($sesiQr->tanggal)->isoFormat('dddd, D MMMM Y') }}</p></div>
                    </li>
                    <li>
                        <svg class="info-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <div>
                            <p class="info-label">Waktu Berlaku</p>
                            <p class="info-val">{{ \Carbon\Carbon::parse($sesiQr->berlaku_mulai)->format('H:i') }} — {{ \Carbon\Carbon::parse($sesiQr->kadaluarsa_pada)->format('H:i') }}</p>
                        </div>
                    </li>
                    @if($sesiQr->radius_meter)
                    <li>
                        <svg class="info-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <div><p class="info-label">Radius Lokasi</p><p class="info-val">{{ $sesiQr->radius_meter }} meter</p></div>
                    </li>
                    @endif
                    <li>
                        <svg class="info-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        <div><p class="info-label">Dibuat Oleh</p><p class="info-val">{{ $sesiQr->dibuatOleh->name ?? 'Sistem' }}</p></div>
                    </li>
                </ul>

                <div class="card-actions">
                    {{-- Tombol Cetak QR PDF — route admin.sesi-qr.cetak-qr --}}
                    <a href="{{ route('admin.sesi-qr.cetak-qr', $sesiQr->id) }}"
                       class="btn btn-cetak" target="_blank" style="flex:1;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                        Cetak QR PDF
                    </a>

                    @if($sesiQr->is_active && !$kadaluarsa)
                    <form action="{{ route('admin.sesi-qr.nonaktifkan', $sesiQr->id) }}" method="POST" id="nonaktifForm" style="flex:1">
                        @csrf @method('PATCH')
                        <button type="button" class="btn btn-nonaktif" style="width:100%;justify-content:center"
                            onclick="confirmNonaktif(document.getElementById('nonaktifForm'))">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                            Nonaktifkan
                        </button>
                    </form>
                    @endif

                    <form action="{{ route('admin.sesi-qr.destroy', $sesiQr->id) }}" method="POST" id="delForm">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-del"
                            onclick="confirmDelete(document.getElementById('delForm'))">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ─── Right: Riwayat Scan ─────────────────────────────────────────── --}}
        <div>
            <div class="detail-card">
                <div class="detail-topbar">
                    <p class="detail-topbar-title">
                        <span class="icon-wrap">
                            <svg width="14" height="14" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </span>
                        Riwayat Scan
                        <span style="font-size:12px;font-weight:600;color:var(--text3);margin-left:4px">({{ $sesiQr->riwayatScan->count() }} scan)</span>
                    </p>
                    <div style="display:flex;gap:8px">
                        {{-- BUGFIX: count berhasil & gagal sesuai enum --}}
                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:#15803d;background:#dcfce7;border:1px solid #bbf7d0;padding:3px 10px;border-radius:99px">
                            {{ $totalBerhasil }} berhasil
                        </span>
                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:#dc2626;background:#fee2e2;border:1px solid #fecaca;padding:3px 10px;border-radius:99px">
                            {{ $totalGagal }} gagal
                        </span>
                    </div>
                </div>

                @if($sesiQr->riwayatScan->isNotEmpty())
                <div style="overflow-x:auto">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:48px">#</th>
                                <th>Siswa</th>
                                <th>NIS</th>
                                <th>Dipindai Pada</th>
                                <th>Hasil</th>
                                <th>Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sesiQr->riwayatScan as $i => $rs)
                            <tr>
                                <td><span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)">{{ $i + 1 }}</span></td>
                                <td>
                                    <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px">{{ $rs->siswa->nama_lengkap ?? '—' }}</p>
                                </td>
                                <td style="font-size:12px;color:var(--text3)">{{ $rs->siswa->nis ?? '—' }}</td>
                                <td style="font-size:12.5px;color:var(--text2)">
                                    {{ \Carbon\Carbon::parse($rs->dipindai_pada)->isoFormat('D MMM Y, HH:mm:ss') }}
                                </td>
                                <td>
                                    {{-- BUGFIX: badge class sesuai enum, dengan label yang ramah --}}
                                    <span class="badge badge-{{ $rs->hasil }}">
                                        {{ $hasilLabel[$rs->hasil] ?? ucfirst($rs->hasil) }}
                                    </span>
                                </td>
                                <td style="font-size:12px;color:var(--text3)">
                                    @if($rs->latitude && $rs->longitude)
                                        {{ number_format($rs->latitude, 6) }}, {{ number_format($rs->longitude, 6) }}
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-box">
                    <svg width="32" height="32" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 8px;display:block"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Belum ada siswa yang scan QR Code ini
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
    @endif
    @if(session('error'))
    Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
    @endif

    function confirmNonaktif(form) {
        Swal.fire({title:'Nonaktifkan Sesi QR?',text:'Sesi ini tidak dapat digunakan lagi untuk scan oleh siswa.',icon:'warning',showCancelButton:true,confirmButtonColor:'#a16207',cancelButtonColor:'#64748b',confirmButtonText:'Ya, Nonaktifkan!',cancelButtonText:'Batal'})
            .then(r => { if (r.isConfirmed) form.submit(); });
    }
    function confirmDelete(form) {
        Swal.fire({title:'Hapus Sesi QR?',text:'Data sesi dan seluruh riwayat scan akan dihapus permanen.',icon:'warning',showCancelButton:true,confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal'})
            .then(r => { if (r.isConfirmed) form.submit(); });
    }

    // ─── Countdown timer ────────────────────────────────────────────────────
    @if($aktif)
    const expiry = new Date('{{ \Carbon\Carbon::parse($sesiQr->kadaluarsa_pada)->toIso8601String() }}');
    function updateCountdown() {
        const diff = expiry - new Date();
        if (diff <= 0) {
            document.getElementById('countdown').textContent = 'Sesi telah berakhir';
            return;
        }
        const m = Math.floor(diff / 60000);
        const s = Math.floor((diff % 60000) / 1000);
        document.getElementById('countdown').textContent = `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);
    @endif

    // ─── Auto-refresh riwayat scan tiap 15 detik jika sesi masih aktif ─────
    @if($aktif)
    setTimeout(() => location.reload(), 15000);
    @endif
</script>
</x-app-layout>