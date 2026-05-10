<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#15803d;--green-bg:#dcfce7;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --yellow:#a16207;--yellow-bg:#fefce8;--yellow-border:#fde68a;
        --orange:#c2410c;--orange-bg:#fff7ed;--orange-border:#fed7aa;
        --purple:#7c3aed;--purple-bg:#faf5ff;--purple-border:#e9d5ff;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    .page{padding:28px 28px 48px;font-family:'DM Sans',sans-serif;max-width:800px}

    .page-header{display:flex;align-items:center;gap:12px;margin-bottom:24px;flex-wrap:wrap}
    .back-btn{display:inline-flex;align-items:center;gap:5px;padding:7px 13px;border-radius:var(--radius-sm);background:var(--surface2);border:1px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);text-decoration:none;transition:background .15s}
    .back-btn:hover{background:var(--surface3)}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:2px}

    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .detail-card-top{height:4px}
    .top-green{background:linear-gradient(90deg,var(--green),#22c55e)}
    .top-red{background:linear-gradient(90deg,var(--red),#f87171)}
    .top-orange{background:linear-gradient(90deg,var(--orange),#fb923c)}
    .top-yellow{background:linear-gradient(90deg,var(--yellow),#eab308)}
    .top-purple{background:linear-gradient(90deg,var(--purple),#a78bfa)}
    .top-gray{background:linear-gradient(90deg,var(--text3),var(--border2))}
    .top-blue{background:linear-gradient(90deg,var(--brand-600),var(--brand-500))}

    .detail-card-head{padding:16px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:9px}
    .detail-card-head-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .detail-body{padding:0}

    .detail-row{display:grid;grid-template-columns:180px 1fr;border-bottom:1px solid var(--surface3);padding:12px 22px;align-items:start}
    .detail-row:last-child{border-bottom:none}
    .detail-key{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;padding-top:1px}
    .detail-val{font-size:13.5px;color:var(--text);font-family:'DM Sans',sans-serif}
    .detail-val strong{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-size:11.5px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;white-space:nowrap}
    .badge-green{background:var(--green-bg);color:var(--green)}
    .badge-red{background:var(--red-bg);color:var(--red)}
    .badge-yellow{background:var(--yellow-bg);color:var(--yellow)}
    .badge-orange{background:var(--orange-bg);color:var(--orange)}
    .badge-gray{background:var(--surface3);color:var(--text3)}
    .badge-purple{background:var(--purple-bg);color:var(--purple)}
    .status-dot{width:5px;height:5px;border-radius:50%;display:inline-block;background:currentColor}

    .kelas-badge{display:inline-flex;padding:2px 9px;background:var(--brand-50);color:var(--brand-600);border-radius:5px;font-size:11.5px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif}

    .absensi-info{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 16px;margin-top:4px}
    .absensi-info-row{display:flex;align-items:center;justify-content:space-between;font-size:12.5px;color:var(--text2);padding:3px 0}
    .absensi-info-row:not(:last-child){border-bottom:1px solid var(--surface3);padding-bottom:6px;margin-bottom:6px}
    .absensi-key{color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.04em}

    .no-absensi{font-size:12.5px;color:var(--text3);font-style:italic;padding:10px 0}

    .map-link{display:inline-flex;align-items:center;gap:5px;font-size:12.5px;color:var(--brand-600);text-decoration:none;font-weight:600;margin-top:4px}
    .map-link:hover{text-decoration:underline}

    @media(max-width:640px){
        .page{padding:16px}
        .detail-row{grid-template-columns:1fr;gap:4px}
        .detail-key{font-size:10.5px}
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <a href="{{ route('guru.riwayat-scan.index') }}" class="back-btn">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali
        </a>
        <div>
            <h1 class="page-title">Detail Riwayat Scan</h1>
            <p class="page-sub">ID: #{{ $riwayat->id }}</p>
        </div>
    </div>

    @php
        $statusMap = [
            'valid'                 => ['class' => 'badge-green',  'label' => 'Valid',           'top' => 'top-green'],
            'ditolak_radius'        => ['class' => 'badge-orange', 'label' => 'Diluar Radius',   'top' => 'top-orange'],
            'ditolak_kadaluarsa'    => ['class' => 'badge-yellow', 'label' => 'Kadaluarsa',      'top' => 'top-yellow'],
            'ditolak_nonaktif'      => ['class' => 'badge-gray',   'label' => 'Sesi Nonaktif',   'top' => 'top-gray'],
            'ditolak_duplikat'      => ['class' => 'badge-purple', 'label' => 'Scan Duplikat',   'top' => 'top-purple'],
            'ditolak_bukan_anggota' => ['class' => 'badge-red',    'label' => 'Bukan Anggota',   'top' => 'top-red'],
        ];
        $st = $statusMap[$riwayat->status] ?? ['class' => 'badge-gray', 'label' => $riwayat->status, 'top' => 'top-gray'];
    @endphp

    {{-- Info Siswa --}}
    <div class="detail-card">
        <div class="detail-card-top top-blue"></div>
        <div class="detail-card-head">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <div class="detail-card-head-title">Data Siswa</div>
        </div>
        <div class="detail-body">
            <div class="detail-row">
                <div class="detail-key">Nama Lengkap</div>
                <div class="detail-val"><strong>{{ $riwayat->siswa->nama_lengkap ?? '—' }}</strong></div>
            </div>
            <div class="detail-row">
                <div class="detail-key">NIS</div>
                <div class="detail-val">{{ $riwayat->siswa->nis ?? '-' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-key">Kelas</div>
                <div class="detail-val">
                    <span class="kelas-badge">{{ $riwayat->sesiQr->kelas->nama_kelas ?? '—' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Info Sesi QR --}}
    <div class="detail-card">
        <div class="detail-card-top top-blue" style="background:linear-gradient(90deg,var(--purple),#a78bfa)"></div>
        <div class="detail-card-head">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            <div class="detail-card-head-title">Sesi QR</div>
        </div>
        <div class="detail-body">
            <div class="detail-row">
                <div class="detail-key">Mata Pelajaran</div>
                <div class="detail-val"><strong>{{ $riwayat->sesiQr->mataPelajaran->nama_mapel ?? '—' }}</strong></div>
            </div>
            <div class="detail-row">
                <div class="detail-key">Tanggal Sesi</div>
                <div class="detail-val">{{ optional($riwayat->sesiQr->tanggal)->translatedFormat('l, d F Y') ?? '—' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-key">Berlaku</div>
                <div class="detail-val">
                    {{ optional($riwayat->sesiQr->berlaku_mulai)->format('H:i') }} –
                    {{ optional($riwayat->sesiQr->kadaluarsa_pada)->format('H:i') }}
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-key">Status Sesi</div>
                <div class="detail-val">
                    @if($riwayat->sesiQr->is_active && !$riwayat->sesiQr->isKadaluarsa())
                        <span class="badge badge-green"><span class="status-dot"></span>Aktif</span>
                    @else
                        <span class="badge badge-gray"><span class="status-dot"></span>Tidak Aktif</span>
                    @endif
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-key">ID Sesi</div>
                <div class="detail-val" style="font-size:12px;color:var(--text3)">#{{ $riwayat->sesi_qr_id }}</div>
            </div>
        </div>
    </div>

    {{-- Hasil Scan --}}
    <div class="detail-card">
        <div class="detail-card-top {{ $st['top'] }}"></div>
        <div class="detail-card-head">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            <div class="detail-card-head-title">Hasil Scan</div>
        </div>
        <div class="detail-body">
            <div class="detail-row">
                <div class="detail-key">Status</div>
                <div class="detail-val">
                    <span class="badge {{ $st['class'] }}">
                        <span class="status-dot"></span>
                        {{ $st['label'] }}
                    </span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-key">Waktu Scan</div>
                <div class="detail-val">
                    <strong>{{ optional($riwayat->di_scan_pada)->format('H:i:s') ?? '—' }}</strong>
                    <span style="color:var(--text3);font-size:12.5px;margin-left:6px">
                        {{ optional($riwayat->di_scan_pada)->translatedFormat('d F Y') ?? '' }}
                    </span>
                </div>
            </div>

            {{-- Lokasi jika tersedia --}}
            @if($riwayat->latitude && $riwayat->longitude)
            <div class="detail-row">
                <div class="detail-key">Lokasi Scan</div>
                <div class="detail-val">
                    <div style="font-size:12.5px;color:var(--text2)">
                        {{ number_format($riwayat->latitude, 6) }}, {{ number_format($riwayat->longitude, 6) }}
                    </div>
                    @if($riwayat->jarak_meter !== null)
                    <div style="font-size:12px;color:var(--text3);margin-top:3px">
                        Jarak dari titik sesi: <strong style="color:var(--text2)">{{ $riwayat->jarak_meter }} m</strong>
                        (maks. {{ $riwayat->sesiQr->radius_meter }} m)
                    </div>
                    @endif
                    <a href="https://maps.google.com/?q={{ $riwayat->latitude }},{{ $riwayat->longitude }}"
                       target="_blank" class="map-link">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        Lihat di Google Maps
                    </a>
                </div>
            </div>
            @endif

            {{-- Keterangan / pesan penolakan --}}
            @if($riwayat->keterangan)
            <div class="detail-row">
                <div class="detail-key">Keterangan</div>
                <div class="detail-val" style="color:var(--text3)">{{ $riwayat->keterangan }}</div>
            </div>
            @endif
        </div>
    </div>

    {{-- Info Absensi yang tercatat (jika valid) --}}
    @if($riwayat->absensi)
    <div class="detail-card">
        <div class="detail-card-top top-green"></div>
        <div class="detail-card-head">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            <div class="detail-card-head-title">Absensi Tercatat</div>
        </div>
        <div class="detail-body">
            <div class="detail-row">
                <div class="detail-key">Status Absensi</div>
                <div class="detail-val">
                    @php
                        $absensiStatus = [
                            'hadir'  => 'badge-green',
                            'izin'   => 'badge-yellow',
                            'sakit'  => 'badge-orange',
                            'alpha'  => 'badge-red',
                        ];
                        $absBadge = $absensiStatus[$riwayat->absensi->status ?? ''] ?? 'badge-gray';
                    @endphp
                    <span class="badge {{ $absBadge }}">
                        <span class="status-dot"></span>
                        {{ ucfirst($riwayat->absensi->status ?? '—') }}
                    </span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-key">Jam Masuk</div>
                <div class="detail-val">{{ optional($riwayat->absensi->jam_masuk)->format('H:i:s') ?? '—' }}</div>
            </div>
            @if($riwayat->absensi->keterangan)
            <div class="detail-row">
                <div class="detail-key">Keterangan</div>
                <div class="detail-val">{{ $riwayat->absensi->keterangan }}</div>
            </div>
            @endif
        </div>
    </div>
    @elseif($riwayat->status === 'valid')
    <div class="detail-card">
        <div class="detail-card-top top-gray"></div>
        <div class="detail-card-head">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            <div class="detail-card-head-title">Absensi Tercatat</div>
        </div>
        <div class="detail-body">
            <div class="detail-row">
                <div class="detail-key"></div>
                <div class="detail-val no-absensi">Data absensi belum tersedia atau belum tersinkronisasi.</div>
            </div>
        </div>
    </div>
    @endif

</div>
</x-app-layout>