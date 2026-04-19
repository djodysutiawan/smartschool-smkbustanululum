<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;--red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;--amber:#a16207;--amber-bg:#fef9c3;--amber-border:#fde68a;--purple:#7c3aed;--purple-bg:#fdf4ff;--purple-border:#e9d5ff;--radius:10px;--radius-sm:7px}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand)}.breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-sm{padding:5px 12px;font-size:12px;border-radius:6px}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}.btn-back:hover{background:var(--surface3);filter:none}
    .btn-primary{background:var(--brand);color:#fff}
    .btn-purple{background:var(--purple-bg);color:var(--purple);border:1px solid var(--purple-border)}.btn-purple:hover{background:#f3e8ff;filter:none}
    .btn-yellow{background:var(--amber-bg);color:var(--amber);border:1px solid var(--amber-border)}.btn-yellow:hover{background:#fef08a;filter:none}
    .btn-del{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}.btn-del:hover{background:#fecaca;filter:none}
    .btn-green{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}.btn-green:hover{background:#dcfce7;filter:none}

    /* ── Grid ── */
    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}
    .grid-full{margin-bottom:16px}

    /* ── Card ── */
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .card-header{padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:10px}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px}
    .card-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0}
    .card-body{padding:16px 18px}

    /* ── Info rows ── */
    .info-list{display:flex;flex-direction:column;gap:0}
    .info-row{display:flex;align-items:baseline;gap:0;padding:10px 0;border-bottom:1px solid var(--surface3)}
    .info-row:last-child{border-bottom:none}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;width:160px;flex-shrink:0}
    .info-value{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);flex:1}
    .info-value strong{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700}

    /* ── Badge ── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%}
    .b-aktif{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}.b-aktif .badge-dot{background:var(--green)}
    .b-nonaktif{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}.b-nonaktif .badge-dot{background:var(--red)}
    .b-kadaluarsa{background:var(--amber-bg);color:var(--amber);border:1px solid var(--amber-border)}.b-kadaluarsa .badge-dot{background:var(--amber)}
    .b-berhasil{background:var(--green-bg);color:var(--green)}.b-berhasil .badge-dot{background:var(--green)}
    .b-gagal{background:var(--red-bg);color:var(--red)}.b-gagal .badge-dot{background:var(--red)}

    /* ── Scan stat boxes ── */
    .scan-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:16px}
    .scan-box{border-radius:9px;padding:14px 16px;text-align:center}
    .scan-box.total{background:var(--surface3);border:1px solid var(--border)}
    .scan-box.berhasil{background:var(--green-bg);border:1px solid var(--green-border)}
    .scan-box.gagal{background:var(--red-bg);border:1px solid var(--red-border)}
    .scan-box-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:28px;font-weight:800;line-height:1}
    .scan-box.total .scan-box-val{color:var(--text)}
    .scan-box.berhasil .scan-box-val{color:var(--green)}
    .scan-box.gagal .scan-box-val{color:var(--red)}
    .scan-box-label{font-size:11px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text3);margin-top:4px;text-transform:uppercase;letter-spacing:.04em}

    /* ── QR code display area ── */
    .qr-display{text-align:center;padding:20px 0}
    .qr-code-text{font-family:'DM Mono',monospace;font-size:11px;color:var(--text3);word-break:break-all;margin-top:10px;padding:8px 12px;background:var(--surface2);border-radius:6px;border:1px solid var(--border)}

    /* ── Table ── */
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:9px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    td.muted{color:var(--text3);font-size:12.5px}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}
    .empty{text-align:center;padding:40px 20px;color:var(--text3);font-size:13px;font-family:'DM Sans',sans-serif}

    @media(max-width:768px){.page{padding:16px}.grid-2{grid-template-columns:1fr}.scan-strip{grid-template-columns:1fr 1fr}}
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.sesi-qr-guru.index') }}">Sesi QR Guru</a>
        <span class="sep">›</span>
        <span class="current">Detail Sesi #{{ $sesiQrGuru->id }}</span>
    </nav>

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Sesi QR Guru</h1>
            <p class="page-sub">{{ \Carbon\Carbon::parse($sesiQrGuru->tanggal)->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.sesi-qr-guru.cetak-qr', $sesiQrGuru->id) }}" target="_blank"
               class="btn btn-purple">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Cetak QR
            </a>
            @if($sesiQrGuru->is_active && now()->lt($sesiQrGuru->kadaluarsa_pada))
            <form action="{{ route('admin.sesi-qr-guru.nonaktifkan', $sesiQrGuru->id) }}" method="POST"
                  id="nonaktifForm">
                @csrf
                <button type="button" class="btn btn-yellow"
                    onclick="confirmNonaktif()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                    Nonaktifkan
                </button>
            </form>
            @endif
            <form action="{{ route('admin.sesi-qr-guru.destroy', $sesiQrGuru->id) }}" method="POST"
                  id="deleteForm">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del"
                    onclick="confirmDelete()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    Hapus
                </button>
            </form>
            <a href="{{ route('admin.sesi-qr-guru.index') }}" class="btn btn-back">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Scan Stats --}}
    @php
        $totalScan    = $sesiQrGuru->riwayatScan->count();
        $berhasilScan = $sesiQrGuru->riwayatScan->where('hasil', 'berhasil')->count();
        $gagalScan    = $totalScan - $berhasilScan;
        $statusBadge  = $sesiQrGuru->is_active && now()->lt($sesiQrGuru->kadaluarsa_pada)
                        ? ['b-aktif', 'Aktif']
                        : ($sesiQrGuru->is_active ? ['b-kadaluarsa', 'Kadaluarsa'] : ['b-nonaktif', 'Nonaktif']);
    @endphp
    <div class="scan-strip">
        <div class="scan-box total">
            <p class="scan-box-val">{{ $totalScan }}</p>
            <p class="scan-box-label">Total Scan</p>
        </div>
        <div class="scan-box berhasil">
            <p class="scan-box-val">{{ $berhasilScan }}</p>
            <p class="scan-box-label">Berhasil</p>
        </div>
        <div class="scan-box gagal">
            <p class="scan-box-val">{{ $gagalScan }}</p>
            <p class="scan-box-label">Gagal</p>
        </div>
    </div>

    {{-- Grid atas: Info Sesi + QR Code --}}
    <div class="grid-2">

        {{-- Info Sesi --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">
                    <span class="card-dot" style="background:var(--brand)"></span>
                    Informasi Sesi
                </span>
                <span class="badge {{ $statusBadge[0] }}">
                    <span class="badge-dot"></span>{{ $statusBadge[1] }}
                </span>
            </div>
            <div class="card-body">
                <div class="info-list">
                    <div class="info-row">
                        <span class="info-label">Tanggal</span>
                        <span class="info-value">
                            <strong>{{ \Carbon\Carbon::parse($sesiQrGuru->tanggal)->translatedFormat('d F Y') }}</strong>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Berlaku Mulai</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($sesiQrGuru->berlaku_mulai)->format('H:i') }} WIB</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kadaluarsa</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($sesiQrGuru->kadaluarsa_pada)->format('H:i') }} WIB</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Durasi</span>
                        <span class="info-value">
                            @php
                                $mulai  = \Carbon\Carbon::parse($sesiQrGuru->berlaku_mulai);
                                $akhir  = \Carbon\Carbon::parse($sesiQrGuru->kadaluarsa_pada);
                                $dur    = $mulai->diffInMinutes($akhir);
                            @endphp
                            {{ $dur >= 60 ? floor($dur/60).' jam '.($dur%60 ? ($dur%60).' menit' : '') : $dur.' menit' }}
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Radius Lokasi</span>
                        <span class="info-value">
                            @if($sesiQrGuru->radius_meter)
                                {{ $sesiQrGuru->radius_meter }} meter
                            @else
                                <span style="color:var(--text3)">Tidak dibatasi</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Dibuat Oleh</span>
                        <span class="info-value">{{ $sesiQrGuru->pembuat->name ?? '—' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Dibuat Pada</span>
                        <span class="info-value">{{ $sesiQrGuru->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- QR Code --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">
                    <span class="card-dot" style="background:var(--purple)"></span>
                    QR Code
                </span>
                <a href="{{ route('admin.sesi-qr-guru.cetak-qr', $sesiQrGuru->id) }}"
                   target="_blank" class="btn btn-sm btn-purple">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Cetak PDF
                </a>
            </div>
            <div class="card-body">
                <div class="qr-display">
                    {{--
                        Render QR menggunakan salah satu opsi:

                        Opsi A — simplesoftwareio/simple-qrcode:
                        {!! QrCode::size(180)->errorCorrection('H')->generate($sesiQrGuru->kode_qr) !!}

                        Opsi B — endroid/qr-code (base64 PNG):
                        @php
                            $qr = \Endroid\QrCode\Builder\Builder::create()
                                ->data($sesiQrGuru->kode_qr)->size(300)->build();
                            $qrBase64 = base64_encode($qr->getString());
                        @endphp
                        <img src="data:image/png;base64,{{ $qrBase64 }}" width="180" height="180"
                             style="border:3px solid #1a1a2e;border-radius:8px" alt="QR Code">
                    --}}
                    <div style="width:180px;height:180px;border:3px dashed var(--border2);border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto;color:var(--text3);font-size:12px;text-align:center;padding:12px;line-height:1.5">
                        Integrasikan library QR<br>
                        (simplesoftwareio/<wbr>simple-qrcode)
                    </div>
                </div>
                <p class="qr-code-text">{{ $sesiQrGuru->kode_qr }}</p>
                <p style="text-align:center;margin-top:10px;font-size:11.5px;color:var(--text3);font-family:'DM Sans',sans-serif">
                    Tunjukkan atau cetak QR ini agar guru dapat melakukan scan absensi
                </p>
            </div>
        </div>
    </div>

    {{-- Riwayat Scan --}}
    <div class="card grid-full">
        <div class="card-header">
            <span class="card-title">
                <span class="card-dot" style="background:#15803d"></span>
                Riwayat Scan ({{ $totalScan }})
            </span>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Nama Guru</th>
                        <th>NIP</th>
                        <th class="center">Hasil</th>
                        <th>Dipindai Pada</th>
                        <th>IP Address</th>
                        <th>Perangkat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sesiQrGuru->riwayatScan->sortByDesc('dipindai_pada') as $i => $scan)
                    @php
                        $hasilBadge = $scan->hasil === 'berhasil' ? 'b-berhasil' : 'b-gagal';
                        $hasilLabel = match($scan->hasil) {
                            'berhasil'         => 'Berhasil',
                            'gagal_kadaluarsa' => 'Kadaluarsa',
                            'gagal_lokasi'     => 'Lokasi',
                            'gagal_duplikat'   => 'Duplikat',
                            default            => ucfirst($scan->hasil),
                        };
                    @endphp
                    <tr>
                        <td><span class="no-col">{{ $i + 1 }}</span></td>
                        <td>
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px">
                                {{ $scan->guru->nama_lengkap ?? '—' }}
                            </span>
                        </td>
                        <td class="muted">{{ $scan->guru->nip ?? '—' }}</td>
                        <td class="center">
                            <span class="badge {{ $hasilBadge }}">
                                <span class="badge-dot"></span>{{ $hasilLabel }}
                            </span>
                        </td>
                        <td class="muted">{{ $scan->dipindai_pada ? \Carbon\Carbon::parse($scan->dipindai_pada)->format('d M Y, H:i:s') : '—' }}</td>
                        <td class="muted">{{ $scan->ip_address ?? '—' }}</td>
                        <td class="muted" style="max-width:160px">
                            <p style="display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden;font-size:11.5px">
                                {{ $scan->info_perangkat ?? '—' }}
                            </p>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7">
                        <p class="empty">Belum ada riwayat scan untuk sesi ini</p>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
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

    function confirmNonaktif() {
        Swal.fire({
            title: 'Nonaktifkan Sesi QR?',
            text: 'Sesi ini tidak akan bisa diaktifkan kembali.',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#a16207', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Nonaktifkan', cancelButtonText: 'Batal'
        }).then(r => { if (r.isConfirmed) document.getElementById('nonaktifForm').submit(); });
    }

    function confirmDelete() {
        Swal.fire({
            title: 'Hapus Sesi QR?',
            html: 'Sesi QR tanggal <strong>{{ \Carbon\Carbon::parse($sesiQrGuru->tanggal)->format('d/m/Y') }}</strong> dan seluruh riwayat scannya akan dihapus permanen.',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
        }).then(r => { if (r.isConfirmed) document.getElementById('deleteForm').submit(); });
    }
</script>
</x-app-layout>