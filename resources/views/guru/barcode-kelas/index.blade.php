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
        --purple:#7c3aed;--purple-bg:#faf5ff;--purple-border:#e9d5ff;
        --radius:10px;--radius-sm:7px;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    .page{padding:28px 28px 48px;font-family:'DM Sans',sans-serif}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap;line-height:1}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-print{background:var(--purple-bg);color:var(--purple);border:1px solid var(--purple-border)}
    .btn-print:hover{background:#ede9fe;filter:none}
    .btn-qr{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}
    .btn-qr:hover{background:#bbf7d0;filter:none}
    .btn-detail{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
    .btn-detail:hover{background:#dbeafe;filter:none}

    .alert{padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-size:13px;font-family:'DM Sans',sans-serif;display:flex;align-items:center;gap:8px}
    .alert-success{background:#f0fdf4;border:1px solid var(--green-border);color:#166534}
    .alert-error{background:var(--red-bg);border:1px solid var(--red-border);color:#991b1b}

    /* 2-col layout */
    .layout-cols{display:grid;grid-template-columns:340px 1fr;gap:20px;align-items:start}

    /* Guru barcode card */
    .guru-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .guru-card-top{height:5px;background:linear-gradient(90deg,var(--brand-500),#7c3aed)}
    .guru-card-body{padding:22px}
    .guru-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.06em;margin-bottom:14px;display:flex;align-items:center;gap:7px}
    .guru-avatar{width:56px;height:56px;border-radius:14px;background:linear-gradient(135deg,var(--brand-50),var(--brand-100));display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--brand-600)}
    .guru-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text);text-align:center}
    .guru-nip{font-size:12px;color:var(--text3);text-align:center;margin-top:3px}
    .qr-wrap{display:flex;justify-content:center;margin:18px 0;padding:14px;background:var(--surface2);border-radius:10px;border:1px solid var(--border)}
    .qr-wrap svg{max-width:100%;height:auto}
    .barcode-raw{font-family:'DM Mono',monospace;font-size:11px;color:var(--text3);text-align:center;background:var(--surface3);padding:6px 12px;border-radius:6px;letter-spacing:.08em;margin-bottom:14px}
    .guru-card-footer{padding:14px 22px;border-top:1px solid var(--surface3);display:flex;gap:8px}

    /* Jadwal hari ini */
    .section-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .section-head{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
    .section-head-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px}
    .section-head-badge{padding:3px 10px;background:var(--brand-50);color:var(--brand-600);border-radius:99px;font-size:11px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif}
    .jadwal-table{width:100%;border-collapse:collapse}
    .jadwal-table th{padding:10px 20px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid var(--border);background:var(--surface2)}
    .jadwal-table td{padding:12px 20px;border-bottom:1px solid var(--surface3);font-size:13px;color:var(--text2);vertical-align:middle}
    .jadwal-table tr:last-child td{border-bottom:none}
    .jadwal-table tr:hover td{background:var(--surface2)}
    .mapel-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text);font-size:13px}
    .kelas-badge{display:inline-flex;padding:2px 8px;background:var(--brand-50);color:var(--brand-600);border-radius:5px;font-size:11px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif}
    .time-range{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;margin-top:2px}
    .sesi-status{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif}
    .sesi-aktif{background:var(--green-bg);color:var(--green)}
    .sesi-none{background:var(--surface3);color:var(--text3)}
    .status-dot{width:5px;height:5px;border-radius:50%}
    .dot-green{background:var(--green)}
    .dot-gray{background:var(--text3)}
    .action-cell{display:flex;gap:6px;flex-wrap:wrap}

    /* Tab minggu */
    .tab-bar{display:flex;gap:2px;padding:12px 20px 0;border-bottom:1px solid var(--border);background:var(--surface2);overflow-x:auto}
    .tab-item{padding:7px 14px;border-radius:7px 7px 0 0;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;color:var(--text3);border:none;background:transparent;white-space:nowrap;transition:all .15s}
    .tab-item.active{background:var(--surface);color:var(--brand-600);border:1px solid var(--border);border-bottom:1px solid var(--surface)}
    .tab-item:hover:not(.active){color:var(--text2);background:rgba(0,0,0,.04)}
    .tab-content{display:none;padding:0}
    .tab-content.active{display:block}

    /* Weekly jadwal table rows */
    .jadwal-row-hari{padding:10px 20px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.06em;background:var(--surface2);border-bottom:1px solid var(--border)}

    /* Empty state */
    .empty-cell{padding:32px 20px;text-align:center;color:var(--text3);font-size:13px;font-family:'DM Sans',sans-serif}

    /* Barcode loading state */
    .barcode-loading{display:flex;align-items:center;justify-content:center;height:50px;color:var(--text3);font-size:12px;gap:6px}

    @media(max-width:900px){.layout-cols{grid-template-columns:1fr}}
    @media(max-width:640px){.page{padding:16px}.action-cell{flex-direction:column}}
</style>

{{-- Load JsBarcode dari CDN (menggantikan DNS1D PHP library) --}}
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Barcode & QR Kelas</h1>
            <p class="page-sub">Barcode identitas guru dan QR sesi absensi siswa per jadwal pelajaran</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.barcode-kelas.cetak-barcode-guru') }}" target="_blank" class="btn btn-print">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Cetak Barcode Guru
            </a>
            <a href="{{ route('guru.barcode-kelas.create-sesi') }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buat Sesi QR
            </a>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="layout-cols">

        {{-- Kiri: Barcode tetap guru --}}
        <div>
            <div class="guru-card">
                <div class="guru-card-top"></div>
                <div class="guru-card-body">
                    <div class="guru-card-title">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="3" height="10"/><rect x="7" y="5" width="2" height="14"/><rect x="11" y="7" width="3" height="10"/><rect x="16" y="4" width="2" height="16"/><rect x="20" y="7" width="2" height="10"/></svg>
                        Barcode Identitas Guru
                    </div>
                    <div class="guru-avatar">
                        {{ strtoupper(substr($guru->nama_lengkap ?? 'G', 0, 1)) }}
                    </div>
                    <p class="guru-name">{{ $guru->nama_lengkap ?? '—' }}</p>
                    <p class="guru-nip">NIP: {{ $guru->nip ?? '-' }}</p>

                    {{-- Barcode menggunakan JsBarcode (SVG), menggantikan DNS1D::getBarcodeHTML() --}}
                    <div class="qr-wrap">
                        <svg id="barcode-guru"></svg>
                    </div>

                    <div class="barcode-raw">{{ $barcodeGuru }}</div>

                    <p style="font-size:11.5px;color:var(--text3);text-align:center;line-height:1.6">
                        Barcode ini digunakan untuk absensi guru di pos piket.<br>Nilai tidak pernah berubah.
                    </p>
                </div>
                <div class="guru-card-footer">
                    <a href="{{ route('guru.barcode-kelas.cetak-barcode-guru') }}" target="_blank" class="btn btn-sm btn-print" style="flex:1;justify-content:center">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                        Cetak
                    </a>
                </div>
            </div>
        </div>

        {{-- Kanan: Jadwal & sesi QR --}}
        <div>

            {{-- Jadwal hari ini --}}
            <div class="section-card">
                <div class="section-head">
                    <div class="section-head-title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Jadwal Hari Ini
                        <span style="font-size:11px;color:var(--text3);font-weight:400;font-family:'DM Sans',sans-serif">({{ ucfirst($hariIni) }})</span>
                    </div>
                    @if($jadwalHariIni->count() > 0)
                    <span class="section-head-badge">{{ $jadwalHariIni->count() }} jadwal</span>
                    @endif
                </div>

                @if($jadwalHariIni->count() > 0)
                <table class="jadwal-table">
                    <thead>
                        <tr>
                            <th>Mata Pelajaran</th>
                            <th>Waktu</th>
                            <th>Status Sesi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwalHariIni as $jadwal)
                        @php $sesiAktif = $sesiPerJadwal[$jadwal->id] ?? null; @endphp
                        <tr>
                            <td>
                                <div class="mapel-name">{{ $jadwal->mataPelajaran->nama_mapel ?? '—' }}</div>
                                <div style="margin-top:3px">
                                    <span class="kelas-badge">{{ $jadwal->kelas->nama_kelas ?? '—' }}</span>
                                    @if($jadwal->ruang)
                                    <span style="font-size:11px;color:var(--text3);margin-left:5px">{{ $jadwal->ruang->nama_ruang }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text);font-size:13px">
                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                                </div>
                                <div class="time-range">s/d {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</div>
                            </td>
                            <td>
                                @if($sesiAktif)
                                <span class="sesi-status sesi-aktif">
                                    <span class="status-dot dot-green"></span>QR Aktif
                                </span>
                                @else
                                <span class="sesi-status sesi-none">
                                    <span class="status-dot dot-gray"></span>Belum ada
                                </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-cell">
                                    @if($sesiAktif)
                                    <a href="{{ route('guru.barcode-kelas.show-sesi', $sesiAktif) }}" class="btn btn-sm btn-qr">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                                        Tayangkan QR
                                    </a>
                                    @else
                                    <a href="{{ route('guru.barcode-kelas.create-sesi', ['jadwal_pelajaran_id' => $jadwal->id]) }}" class="btn btn-sm btn-primary">
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                        Buat QR
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-cell">
                    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 8px;display:block;opacity:.35"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Tidak ada jadwal hari ini ({{ ucfirst($hariIni) }})
                </div>
                @endif
            </div>

            {{-- Jadwal semua hari (tab) --}}
            <div class="section-card">
                <div class="section-head">
                    <div class="section-head-title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Jadwal Mingguan
                    </div>
                </div>

                <div class="tab-bar">
                    @foreach($hariList as $idx => $hari)
                    <button class="tab-item {{ $hari === $hariIni ? 'active' : '' }}"
                        onclick="switchTab('{{ $hari }}')">
                        {{ ucfirst($hari) }}
                        @if(isset($semuaJadwal[$hari]))
                        <span style="display:inline-flex;width:16px;height:16px;border-radius:50%;background:var(--brand-50);color:var(--brand-600);font-size:10px;align-items:center;justify-content:center;margin-left:3px">{{ $semuaJadwal[$hari]->count() }}</span>
                        @endif
                    </button>
                    @endforeach
                </div>

                @foreach($hariList as $hari)
                <div class="tab-content {{ $hari === $hariIni ? 'active' : '' }}" id="tab-{{ $hari }}">
                    @if(isset($semuaJadwal[$hari]) && $semuaJadwal[$hari]->count() > 0)
                    <table class="jadwal-table">
                        <thead>
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>Kelas</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semuaJadwal[$hari] as $jw)
                            <tr>
                                <td>
                                    <div class="mapel-name">{{ $jw->mataPelajaran->nama_mapel ?? '—' }}</div>
                                </td>
                                <td><span class="kelas-badge">{{ $jw->kelas->nama_kelas ?? '—' }}</span></td>
                                <td>
                                    <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)">
                                        {{ \Carbon\Carbon::parse($jw->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($jw->jam_selesai)->format('H:i') }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-cell">Tidak ada jadwal hari {{ ucfirst($hari) }}</div>
                    @endif
                </div>
                @endforeach
            </div>

        </div>
    </div>
</div>

<script>
// ── Tab mingguan ──────────────────────────────────────────────────────────────
function switchTab(hari) {
    document.querySelectorAll('.tab-item').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelector(`[onclick="switchTab('${hari}')"]`).classList.add('active');
    document.getElementById('tab-' + hari).classList.add('active');
}

// ── Render barcode guru menggunakan JsBarcode (menggantikan DNS1D) ────────────
// Nilai barcodeGuru di-pass dari controller: 'GURU-{user_id}'
document.addEventListener('DOMContentLoaded', function () {
    try {
        JsBarcode('#barcode-guru', '{{ $barcodeGuru }}', {
            format      : 'CODE128',   // setara C128 pada milon/barcode
            width       : 1.8,
            height      : 50,
            displayValue: false,       // nilai teks sudah tampil di .barcode-raw
            margin      : 0,
            background  : 'transparent',
            lineColor   : '#0f172a'    // --text
        });
    } catch (e) {
        // Fallback: tampilkan teks jika JsBarcode gagal load
        document.getElementById('barcode-guru').outerHTML =
            '<p style="color:#94a3b8;font-size:12px;text-align:center">Barcode tidak dapat ditampilkan</p>';
    }
});
</script>
</x-app-layout>