{{-- resources/views/admin/sesi-qr/show.blade.php --}}
<x-app-layout>
<style>
    :root{--brand:#1f63db;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;
    --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;
    --text:#0f172a;--text2:#475569;--text3:#94a3b8;--red:#dc2626;--red-bg:#fee2e2;
    --red-border:#fecaca;--radius:10px;--radius-sm:7px;}
    .page{padding:28px 28px 60px;max-width:1400px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand)}
    .breadcrumb .sep{color:var(--border)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-print{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-del{background:#fff0f0;color:var(--red);border:1px solid var(--red-border)}
    .btn-off{background:#fefce8;color:#a16207;border:1px solid #fef08a}
    .grid{display:grid;grid-template-columns:1fr 340px;gap:16px;align-items:start}
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px}
    .card-title{font-size:13px;font-weight:700;color:var(--text)}
    .card-body{padding:20px}
    .dl-grid{display:grid;grid-template-columns:1fr 1fr;gap:0}
    .dl-item{padding:12px 0;border-bottom:1px solid var(--border)}
    .dl-item:nth-last-child(-n+2){border-bottom:none}
    .dl-full{grid-column:span 2}
    .dl-label{font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:4px}
    .dl-val{font-size:14px;color:var(--text);font-weight:500}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:99px;font-size:12px;font-weight:700}
    .badge-dot{width:6px;height:6px;border-radius:50%}
    .badge-aktif{background:#dcfce7;color:#15803d}.badge-aktif .badge-dot{background:#15803d}
    .badge-nonaktif{background:#fee2e2;color:#dc2626}.badge-nonaktif .badge-dot{background:#dc2626}
    .badge-kadaluarsa{background:#f1f5f9;color:#64748b}.badge-kadaluarsa .badge-dot{background:#64748b}
    /* QR Box */
    .qr-box{text-align:center;padding:24px}
    .qr-wrap{display:inline-block;padding:16px;background:#fff;border:2px solid var(--border);border-radius:12px;box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .qr-wrap svg{display:block}
    .qr-label{margin-top:14px;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.08em;text-transform:uppercase}
    .qr-kode{font-size:9px;color:#cbd5e1;margin-top:4px;word-break:break-all;max-width:220px;margin-inline:auto}
    .qr-timer{margin-top:12px;padding:8px 14px;background:var(--surface2);border-radius:8px;font-size:12px;font-weight:700;color:var(--text2);border:1px solid var(--border)}
    .qr-expired{background:#fee2e2;color:var(--red);border-color:var(--red-border)}
    /* Rekap scan */
    .scan-table{width:100%;border-collapse:collapse;font-size:13px}
    .scan-table th{padding:10px 12px;text-align:left;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;border-bottom:2px solid var(--border)}
    .scan-table td{padding:10px 12px;border-bottom:1px solid var(--border);color:var(--text)}
    .scan-table tr:last-child td{border-bottom:none}
    .scan-table tr:hover td{background:var(--surface2)}
    .hasil-berhasil{color:#15803d;font-weight:700}
    .hasil-gagal{color:var(--red);font-weight:700}
    @media(max-width:900px){.grid{grid-template-columns:1fr}.page{padding:16px 16px 40px}}
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
            <h1 class="page-title">Detail Sesi QR</h1>
            <p class="page-sub">
                {{ $sesiQr->kelas->nama_kelas ?? '—' }} —
                {{ $sesiQr->mataPelajaran->nama_mapel ?? 'Umum' }} —
                {{ $sesiQr->tanggal->format('d M Y') }}
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.sesi-qr.cetak-qr', $sesiQr) }}" class="btn btn-print" target="_blank">
                🖨 Cetak QR
            </a>
            @if($sesiQr->is_active && !$sesiQr->isKadaluarsa())
            <form method="POST" action="{{ route('admin.sesi-qr.nonaktifkan', $sesiQr) }}">
                @csrf
                <button class="btn btn-off">⏹ Nonaktifkan</button>
            </form>
            @endif
            <form method="POST" action="{{ route('admin.sesi-qr.destroy', $sesiQr) }}" id="delForm">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">🗑 Hapus</button>
            </form>
            <a href="{{ route('admin.sesi-qr.index') }}" class="btn btn-back">← Kembali</a>
        </div>
    </div>

    <div class="grid">
        {{-- Kiri: info + rekap --}}
        <div>
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Informasi Sesi</span>
                </div>
                <div class="card-body">
                    <div class="dl-grid">
                        <div class="dl-item">
                            <p class="dl-label">Kelas</p>
                            <p class="dl-val">{{ $sesiQr->kelas->nama_kelas ?? '—' }}</p>
                        </div>
                        <div class="dl-item">
                            <p class="dl-label">Mata Pelajaran</p>
                            <p class="dl-val">{{ $sesiQr->mataPelajaran->nama_mapel ?? 'Umum' }}</p>
                        </div>
                        <div class="dl-item">
                            <p class="dl-label">Tanggal</p>
                            <p class="dl-val">{{ $sesiQr->tanggal->format('d F Y') }}</p>
                        </div>
                        <div class="dl-item">
                            <p class="dl-label">Status</p>
                            <p class="dl-val">
                                @if($sesiQr->isKadaluarsa())
                                    <span class="badge badge-kadaluarsa"><span class="badge-dot"></span>Kadaluarsa</span>
                                @elseif($sesiQr->is_active)
                                    <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                                @else
                                    <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                                @endif
                            </p>
                        </div>
                        <div class="dl-item">
                            <p class="dl-label">Berlaku Mulai</p>
                            <p class="dl-val">{{ $sesiQr->berlaku_mulai->format('H:i, d M Y') }}</p>
                        </div>
                        <div class="dl-item">
                            <p class="dl-label">Kadaluarsa</p>
                            <p class="dl-val">{{ $sesiQr->kadaluarsa_pada->format('H:i, d M Y') }}</p>
                        </div>
                        <div class="dl-item">
                            <p class="dl-label">Radius GPS</p>
                            <p class="dl-val">{{ $sesiQr->radius_meter ? $sesiQr->radius_meter.' meter' : 'Tidak dibatasi' }}</p>
                        </div>
                        <div class="dl-item">
                            <p class="dl-label">Dibuat Oleh</p>
                            <p class="dl-val">{{ $sesiQr->dibuatOleh->name ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rekap Scan --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Riwayat Scan ({{ $sesiQr->riwayatScan->count() }})</span>
                </div>
                <div class="card-body" style="padding:0">
                    @if($sesiQr->riwayatScan->isEmpty())
                        <p style="padding:20px;color:var(--text3);font-size:13px;text-align:center">Belum ada scan.</p>
                    @else
                    <table class="scan-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Siswa</th>
                                <th>Waktu Scan</th>
                                <th>Hasil</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sesiQr->riwayatScan->sortByDesc('dipindai_pada') as $i => $scan)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $scan->siswa->nama_lengkap ?? '—' }}</td>
                                <td>{{ $scan->dipindai_pada->format('H:i:s') }}</td>
                                <td>
                                    <span class="hasil-{{ $scan->isberhasil() ? 'berhasil' : 'gagal' }}">
                                        {{ $scan->isberhasil() ? '✓ Berhasil' : '✗ Gagal' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kanan: QR Code --}}
        <div>
            <div class="card">
                <div class="card-header">
                    <span class="card-title">QR Code Absensi</span>
                </div>
                <div class="qr-box">
                    @if($sesiQr->is_active && !$sesiQr->isKadaluarsa())
                        <div class="qr-wrap">
                            {!! QrCode::format('svg')->size(220)->errorCorrection('H')->generate($sesiQr->kode_qr) !!}
                        </div>
                        <p class="qr-label">Scan untuk absen</p>
                        <p class="qr-kode">{{ $sesiQr->kode_qr }}</p>
                        <div class="qr-timer" id="qrTimer">
                            ⏱ Menghitung sisa waktu...
                        </div>
                    @else
                        <div class="qr-wrap" style="opacity:.4;filter:grayscale(1)">
                            {!! QrCode::format('svg')->size(220)->errorCorrection('H')->generate($sesiQr->kode_qr) !!}
                        </div>
                        <div class="qr-timer qr-expired">
                            ✗ Sesi {{ $sesiQr->isKadaluarsa() ? 'kadaluarsa' : 'dinonaktifkan' }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
    @endif

    // Countdown timer
    @if($sesiQr->is_active && !$sesiQr->isKadaluarsa())
    const exp = new Date("{{ $sesiQr->kadaluarsa_pada->toIso8601String() }}").getTime();
    const el  = document.getElementById('qrTimer');
    const tick = () => {
        const diff = exp - Date.now();
        if (diff <= 0) { el.textContent = '✗ Sesi kadaluarsa'; el.classList.add('qr-expired'); return; }
        const m = Math.floor(diff / 60000);
        const s = Math.floor((diff % 60000) / 1000);
        el.textContent = `⏱ Berlaku ${m}m ${s}s lagi`;
        setTimeout(tick, 1000);
    };
    tick();
    @endif

    function confirmDelete() {
        Swal.fire({title:'Hapus Sesi QR?',text:'Semua riwayat scan akan ikut terhapus.',icon:'warning',
            showCancelButton:true,confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal'
        }).then(r => { if(r.isConfirmed) document.getElementById('delForm').submit(); });
    }
</script>
</x-app-layout>