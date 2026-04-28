<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --piket-700:#b45309;--piket-600:#d97706;--piket-100:#fef3c7;--piket-50:#fffbeb;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
        --green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fff0f0;--red-border:#fecaca;
    }
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    /* Info grid */
    .info-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:12px;margin-bottom:16px}
    .info-item{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 16px}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:5px}
    .info-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text)}
    .info-val.muted{font-weight:500;color:var(--text2);font-size:13px}

    /* Big time card */
    .time-hero{background:linear-gradient(135deg,var(--brand-600),var(--brand-700));border-radius:var(--radius);padding:22px 26px;color:#fff;margin-bottom:16px;display:flex;align-items:center;gap:24px;flex-wrap:wrap}
    .time-hero-hari{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;opacity:.75;letter-spacing:.06em;text-transform:uppercase;margin-bottom:6px}
    .time-hero-jam{font-family:'Plus Jakarta Sans',sans-serif;font-size:36px;font-weight:800;line-height:1}
    .time-hero-sep{font-size:20px;opacity:.5;margin:0 8px}
    .time-hero-right{display:flex;flex-direction:column;gap:6px}
    .time-chip{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.2)}
    .time-chip.active{background:rgba(16,185,129,.3);border-color:rgba(16,185,129,.4)}

    /* Panel */
    .panel{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .panel-header{display:flex;align-items:center;justify-content:space-between;padding:13px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .panel-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:7px}

    /* Riwayat log table */
    table.log-table{width:100%;border-collapse:collapse;font-size:13px}
    table.log-table thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    table.log-table thead th{padding:10px 16px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    table.log-table tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    table.log-table tbody tr:last-child{border-bottom:none}
    table.log-table tbody tr:hover{background:#fafbff}
    table.log-table td{padding:10px 16px;color:var(--text);vertical-align:middle}
    .log-masuk-td{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--green)}
    .log-keluar-td{color:var(--text2)}
    .log-dur-td{font-size:12px;color:var(--text3)}
    .checkout-warn{display:inline-flex;padding:2px 8px;border-radius:99px;font-size:11px;font-weight:700;background:var(--piket-50);color:var(--piket-700);border:1px solid var(--piket-100)}

    /* Badge */
    .badge-aktif{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-size:11.5px;font-weight:700;background:var(--green-bg);color:var(--green)}
    .badge-nonaktif{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-size:11.5px;font-weight:700;background:var(--surface3);color:var(--text3)}

    /* Pagination */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:8px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px}
    .pag-btn{height:30px;min-width:30px;padding:0 7px;border-radius:6px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:12px;padding:0 3px}

    .empty-inline{padding:28px;text-align:center;font-size:13px;color:var(--text3)}

    @media(max-width:640px){.page{padding:16px}.header-actions{width:100%}.time-hero{padding:16px 18px}}
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Jadwal Piket</h1>
            <p class="page-sub">{{ ucfirst($jadwal->hari) }} · {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('piket.jadwal.index') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('piket.log.checkin') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Check-In Piket
            </a>
        </div>
    </div>

    {{-- Big time hero --}}
    @php $isToday = $jadwal->hari === strtolower(\Carbon\Carbon::now()->locale('id')->isoFormat('dddd')); @endphp
    <div class="time-hero">
        <div>
            <p class="time-hero-hari">{{ ucfirst($jadwal->hari) }}</p>
            <div style="display:flex;align-items:center">
                <span class="time-hero-jam">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</span>
                <span class="time-hero-sep">–</span>
                <span class="time-hero-jam">{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</span>
            </div>
        </div>
        <div class="time-hero-right">
            @if($isToday)
                <span class="time-chip active">
                    <svg width="8" height="8" fill="#34d399" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5"/></svg>
                    Jadwal hari ini
                </span>
            @endif
            <span class="time-chip">
                {{ $jadwal->is_active ? '✓ Aktif' : '○ Nonaktif' }}
            </span>
            @if($jadwal->tahunAjaran)
            <span class="time-chip">
                TA {{ $jadwal->tahunAjaran->tahun ?? '—' }}
            </span>
            @endif
        </div>
    </div>

    {{-- Info grid --}}
    <div class="info-grid">
        <div class="info-item">
            <p class="info-label">Hari</p>
            <p class="info-val">{{ ucfirst($jadwal->hari) }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Jam Mulai</p>
            <p class="info-val">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Jam Selesai</p>
            <p class="info-val">{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Status</p>
            @if($jadwal->is_active)
                <span class="badge-aktif">● Aktif</span>
            @else
                <span class="badge-nonaktif">○ Nonaktif</span>
            @endif
        </div>
        <div class="info-item">
            <p class="info-label">Tahun Ajaran</p>
            <p class="info-val muted">
                {{ $jadwal->tahunAjaran->tahun ?? '—' }}
                {{ $jadwal->tahunAjaran ? '/ '.$jadwal->tahunAjaran->semester : '' }}
            </p>
        </div>
        <div class="info-item">
            <p class="info-label">Durasi</p>
            @php
                $durMnt = \Carbon\Carbon::parse($jadwal->jam_mulai)->diffInMinutes(\Carbon\Carbon::parse($jadwal->jam_selesai));
            @endphp
            <p class="info-val">{{ intdiv($durMnt,60) }}j {{ $durMnt%60 }}m</p>
        </div>
    </div>

    {{-- Catatan --}}
    @if($jadwal->catatan)
    <div class="panel">
        <div class="panel-header">
            <p class="panel-title">
                <svg width="14" height="14" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/></svg>
                Catatan
            </p>
        </div>
        <div style="padding:18px 20px">
            <p style="font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text2);line-height:1.7">{{ $jadwal->catatan }}</p>
        </div>
    </div>
    @endif

    {{-- Riwayat Log --}}
    {{--
        Controller memuat riwayat log 3 bulan terakhir milik guru yang sedang aktif
        (bukan difilter per jadwal/hari), sehingga kolom "Hari" ditampilkan
        agar konteks tanggal tetap jelas bagi pengguna.
    --}}
    <div class="panel">
        <div class="panel-header">
            <p class="panel-title">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Riwayat Check-In (3 Bulan Terakhir)
            </p>
            <span style="font-size:12px;color:var(--text3)">{{ $riwayatLog->total() }} log</span>
        </div>
        <div style="overflow-x:auto">
            <table class="log-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Durasi</th>
                        <th>Shift</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatLog as $index => $log)
                    @php
                        $durMnt = ($log->masuk_pada && $log->keluar_pada)
                            ? \Carbon\Carbon::parse($log->masuk_pada)->diffInMinutes(\Carbon\Carbon::parse($log->keluar_pada))
                            : null;
                    @endphp
                    <tr>
                        <td style="color:var(--text3);font-size:12.5px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">
                            {{ $riwayatLog->firstItem() + $index }}
                        </td>
                        <td>
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)">
                                {{ \Carbon\Carbon::parse($log->tanggal)->locale('id')->isoFormat('D MMM Y') }}
                            </p>
                            <p style="font-size:11.5px;color:var(--text3)">
                                {{ \Carbon\Carbon::parse($log->tanggal)->locale('id')->isoFormat('dddd') }}
                            </p>
                        </td>
                        <td class="log-masuk-td">
                            {{ $log->masuk_pada ? \Carbon\Carbon::parse($log->masuk_pada)->format('H:i') : '—' }}
                        </td>
                        <td class="log-keluar-td">
                            @if($log->keluar_pada)
                                {{ \Carbon\Carbon::parse($log->keluar_pada)->format('H:i') }}
                            @else
                                <span class="checkout-warn">Belum checkout</span>
                            @endif
                        </td>
                        <td class="log-dur-td">
                            {{ $durMnt ? intdiv($durMnt,60).'j '.($durMnt%60).'m' : '—' }}
                        </td>
                        <td>
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)">
                                {{ $log->shift ? ucfirst($log->shift) : '—' }}
                            </span>
                        </td>
                        <td style="font-size:12.5px;color:var(--text2);max-width:180px">
                            <p style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                                {{ $log->catatan ?? '—' }}
                            </p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-inline">Belum ada riwayat log dalam 3 bulan terakhir</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($riwayatLog->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $riwayatLog->firstItem() }}–{{ $riwayatLog->lastItem() }} dari {{ $riwayatLog->total() }}</p>
            <div class="pag-btns">
                @if($riwayatLog->onFirstPage())
                    <span class="pag-btn disabled"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $riwayatLog->previousPageUrl() }}" class="pag-btn"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($riwayatLog->getUrlRange(1,$riwayatLog->lastPage()) as $page => $url)
                    @if($page == $riwayatLog->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $riwayatLog->lastPage() || abs($page - $riwayatLog->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $riwayatLog->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($riwayatLog->hasMorePages())
                    <a href="{{ $riwayatLog->nextPageUrl() }}" class="pag-btn"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn disabled"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>
</x-app-layout>