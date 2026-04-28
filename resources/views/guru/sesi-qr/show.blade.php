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
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}
    .btn-nonaktif{background:#fefce8;color:#a16207;border:1px solid #fde68a}
    .btn-nonaktif:hover{background:#fef9c3;filter:none}
    .btn-print{background:#faf5ff;color:#7c3aed;border:1px solid #e9d5ff}
    .btn-print:hover{background:#f3e8ff;filter:none}

    .layout{display:grid;grid-template-columns:1fr 300px;gap:16px;align-items:start}

    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .detail-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between;gap:8px}
    .detail-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .detail-card-body{padding:20px}

    .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:0}
    .info-row{display:flex;flex-direction:column;gap:3px;padding:12px 0;border-bottom:1px solid var(--surface3)}
    .info-row:last-child{border-bottom:none}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .info-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:600;color:var(--text)}
    .info-val.muted{color:var(--text3);font-weight:400}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-aktif  {background:#dcfce7;color:#15803d} .badge-aktif   .badge-dot{background:#15803d}
    .badge-expired{background:#fee2e2;color:#dc2626} .badge-expired .badge-dot{background:#dc2626}
    .badge-hadir{background:#dcfce7;color:#15803d} .badge-hadir .badge-dot{background:#15803d}
    .badge-telat{background:#fefce8;color:#a16207} .badge-telat .badge-dot{background:#a16207}
    .badge-alfa {background:#fee2e2;color:#dc2626} .badge-alfa  .badge-dot{background:#dc2626}

    .qr-display{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);padding:24px;text-align:center}
    .qr-code-text{font-family:'DM Sans',monospace;font-size:20px;font-weight:700;color:var(--text);letter-spacing:.08em;word-break:break-all;margin-bottom:8px}
    .qr-hint{font-size:12px;color:var(--text3)}

    .progress-bar-wrap{height:8px;background:var(--surface3);border-radius:99px;overflow:hidden;margin-top:8px}
    .progress-bar{height:100%;background:var(--brand-500);border-radius:99px;transition:width .4s}

    table{width:100%;border-collapse:collapse;font-size:13px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:9px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}

    .empty-state{padding:40px 20px;text-align:center}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--text);margin-bottom:4px}
    .empty-sub{font-size:12.5px;color:var(--text3)}

    @media(max-width:900px){.layout{grid-template-columns:1fr}}
    @media(max-width:640px){.page{padding:16px}.info-grid{grid-template-columns:1fr}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Sesi QR</h1>
            <p class="page-sub">{{ $sesiQr->kelas->nama_kelas ?? '—' }} — {{ \Carbon\Carbon::parse($sesiQr->tanggal)->format('d M Y') }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.sesi-qr.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('guru.sesi-qr.cetak-qr', $sesiQr->id) }}" target="_blank" class="btn btn-print">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Cetak QR
            </a>
            @php $isExpired = \Carbon\Carbon::parse($sesiQr->kadaluarsa_pada)->isPast() || !$sesiQr->is_active; @endphp
            @if(!$isExpired)
            <form action="{{ route('guru.sesi-qr.nonaktifkan', $sesiQr->id) }}" method="POST" style="display:inline">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-nonaktif">Nonaktifkan</button>
            </form>
            @endif
            <form action="{{ route('guru.sesi-qr.destroy', $sesiQr->id) }}" method="POST" id="delForm" style="display:inline">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">Hapus</button>
            </form>
        </div>
    </div>

    <div class="layout">
        {{-- Kiri --}}
        <div>
            {{-- Info Sesi --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">Informasi Sesi</span>
                    <span class="badge {{ $isExpired ? 'badge-expired' : 'badge-aktif' }}">
                        <span class="badge-dot"></span>{{ $isExpired ? 'Kedaluwarsa' : 'Aktif' }}
                    </span>
                </div>
                <div class="detail-card-body">
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Kelas</span>
                            <span class="info-val">{{ $sesiQr->kelas->nama_kelas ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Mata Pelajaran</span>
                            <span class="info-val {{ !$sesiQr->mataPelajaran ? 'muted' : '' }}">{{ $sesiQr->mataPelajaran->nama_mapel ?? 'Semua Mapel' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tanggal</span>
                            <span class="info-val">{{ \Carbon\Carbon::parse($sesiQr->tanggal)->format('d M Y') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Radius Lokasi</span>
                            <span class="info-val {{ !$sesiQr->radius_meter ? 'muted' : '' }}">{{ $sesiQr->radius_meter ? $sesiQr->radius_meter . ' meter' : 'Tidak dibatasi' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Berlaku Mulai</span>
                            <span class="info-val">{{ \Carbon\Carbon::parse($sesiQr->berlaku_mulai)->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Kadaluarsa Pada</span>
                            <span class="info-val {{ $isExpired ? '' : '' }}" style="{{ $isExpired ? 'color:#dc2626' : '' }}">{{ \Carbon\Carbon::parse($sesiQr->kadaluarsa_pada)->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Dibuat</span>
                            <span class="info-val">{{ $sesiQr->created_at ? $sesiQr->created_at->format('d M Y, H:i') : '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Total Scan</span>
                            <span class="info-val">{{ $sesiQr->riwayatScan->count() }} siswa</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Riwayat Scan --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">Riwayat Scan ({{ $sesiQr->riwayatScan->count() }})</span>
                </div>
                @if($sesiQr->riwayatScan->count() > 0)
                <div style="overflow-x:auto">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>Nama Siswa</th>
                                <th>Waktu Scan</th>
                                <th class="center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sesiQr->riwayatScan as $i => $scan)
                            <tr>
                                <td style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)">{{ $i + 1 }}</td>
                                <td>
                                    <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px">{{ $scan->siswa->nama_lengkap ?? '—' }}</p>
                                    <p style="font-size:11.5px;color:var(--text3)">{{ $scan->siswa->nis ?? '' }}</p>
                                </td>
                                <td style="font-size:12.5px;color:var(--text2)">{{ $scan->created_at ? $scan->created_at->format('H:i:s, d M Y') : '—' }}</td>
                                <td class="center">
                                    @if(isset($scan->status))
                                        <span class="badge badge-{{ $scan->status }}"><span class="badge-dot"></span>{{ ucfirst($scan->status) }}</span>
                                    @else
                                        <span class="badge badge-hadir"><span class="badge-dot"></span>Hadir</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="detail-card-body">
                    <div class="empty-state">
                        <div style="width:44px;height:44px;background:var(--surface2);border-radius:10px;display:flex;align-items:center;justify-content:center;margin:0 auto 10px">
                            <svg width="20" height="20" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        </div>
                        <p class="empty-title">Belum ada scan</p>
                        <p class="empty-sub">Siswa belum melakukan scan QR ini</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            {{-- Tampilkan Kode QR --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">Kode QR</span>
                </div>
                <div class="detail-card-body">
                    <div class="qr-display">
                        <div style="margin-bottom:12px">
                            <svg width="120" height="120" viewBox="0 0 120 120" style="margin:0 auto;display:block">
                                <rect width="120" height="120" fill="#f8fafc" rx="8"/>
                                <rect x="10" y="10" width="40" height="40" fill="none" stroke="#1f63db" stroke-width="4"/>
                                <rect x="18" y="18" width="24" height="24" fill="#1f63db" rx="2"/>
                                <rect x="70" y="10" width="40" height="40" fill="none" stroke="#1f63db" stroke-width="4"/>
                                <rect x="78" y="18" width="24" height="24" fill="#1f63db" rx="2"/>
                                <rect x="10" y="70" width="40" height="40" fill="none" stroke="#1f63db" stroke-width="4"/>
                                <rect x="18" y="78" width="24" height="24" fill="#1f63db" rx="2"/>
                                <g fill="#1f63db">
                                    <rect x="70" y="70" width="8" height="8"/>
                                    <rect x="82" y="70" width="8" height="8"/>
                                    <rect x="94" y="70" width="8" height="8"/>
                                    <rect x="70" y="82" width="8" height="8"/>
                                    <rect x="94" y="82" width="8" height="8"/>
                                    <rect x="70" y="94" width="8" height="8"/>
                                    <rect x="82" y="94" width="8" height="8"/>
                                    <rect x="94" y="94" width="8" height="8"/>
                                </g>
                            </svg>
                        </div>
                        <p class="qr-code-text">{{ $sesiQr->kode_qr ?? '—' }}</p>
                        <p class="qr-hint">Kode ini digenerate otomatis oleh sistem</p>
                    </div>

                    <div style="margin-top:12px;display:flex;flex-direction:column;gap:8px">
                        <a href="{{ route('guru.sesi-qr.cetak-qr', $sesiQr->id) }}" target="_blank" class="btn btn-print" style="width:100%;justify-content:center">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                            Cetak QR PDF
                        </a>
                        @if(!$isExpired)
                        <form action="{{ route('guru.sesi-qr.nonaktifkan', $sesiQr->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-nonaktif" style="width:100%;justify-content:center">
                                Nonaktifkan Sesi
                            </button>
                        </form>
                        @endif
                        <button type="button" class="btn btn-del" style="width:100%;justify-content:center" onclick="confirmDelete()">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                            Hapus Sesi
                        </button>
                    </div>
                </div>
            </div>

            {{-- Waktu --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">Waktu Berlaku</span>
                </div>
                <div class="detail-card-body" style="display:flex;flex-direction:column;gap:12px">
                    <div>
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;margin-bottom:4px">Mulai</p>
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text)">{{ \Carbon\Carbon::parse($sesiQr->berlaku_mulai)->format('H:i') }}</p>
                        <p style="font-size:12px;color:var(--text3)">{{ \Carbon\Carbon::parse($sesiQr->berlaku_mulai)->format('d M Y') }}</p>
                    </div>
                    <div style="height:1px;background:var(--border)"></div>
                    <div>
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;margin-bottom:4px">Kadaluarsa</p>
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:{{ $isExpired ? '#dc2626' : 'var(--text)' }}">{{ \Carbon\Carbon::parse($sesiQr->kadaluarsa_pada)->format('H:i') }}</p>
                        <p style="font-size:12px;color:var(--text3)">{{ \Carbon\Carbon::parse($sesiQr->kadaluarsa_pada)->format('d M Y') }}</p>
                    </div>
                    @if(!$isExpired)
                    @php $remaining = now()->diffForHumans(\Carbon\Carbon::parse($sesiQr->kadaluarsa_pada), ['syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE, 'parts' => 2]); @endphp
                    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:7px;padding:10px 12px;text-align:center">
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:#15803d">Sisa waktu: {{ $remaining }}</p>
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
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2800,showConfirmButton:false,toast:true,position:'top-end'});
@endif
function confirmDelete() {
    Swal.fire({
        title:'Hapus Sesi QR?',
        html:`Sesi QR kelas <strong>{{ addslashes($sesiQr->kelas->nama_kelas ?? '') }}</strong> dan seluruh riwayat scan akan dihapus permanen.`,
        icon:'warning',showCancelButton:true,
        confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
        confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal',
    }).then(r => { if(r.isConfirmed) document.getElementById('delForm').submit(); });
}
</script>
</x-app-layout>