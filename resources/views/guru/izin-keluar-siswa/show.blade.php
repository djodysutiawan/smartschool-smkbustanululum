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

    .page{padding:28px 28px 48px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    /* ── Layout Grid ── */
    .detail-grid{display:grid;grid-template-columns:1fr 340px;gap:16px;align-items:start}

    /* ── Card ── */
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card:last-child{margin-bottom:0}
    .card-header{display:flex;align-items:center;gap:10px;padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .card-body{padding:20px}

    /* ── Info rows ── */
    .info-table{width:100%;border-collapse:collapse}
    .info-table tr{border-bottom:1px solid var(--border)}
    .info-table tr:last-child{border-bottom:none}
    .info-table td{padding:10px 0;vertical-align:top}
    .info-table .lbl{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);width:150px;text-transform:uppercase;letter-spacing:.04em;padding-right:16px}
    .info-table .val{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text)}

    /* ── Student profile card ── */
    .profile-card{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius);padding:20px;margin-bottom:16px;display:flex;align-items:center;gap:16px}
    .profile-avatar{width:52px;height:52px;border-radius:50%;background:var(--brand-600);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:18px;color:#fff;flex-shrink:0}
    .profile-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text)}
    .profile-meta{font-size:12.5px;color:var(--text3);margin-top:2px}

    /* ── Status badge ── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-menunggu      {background:#fefce8;color:#a16207} .badge-menunggu  .badge-dot{background:#a16207}
    .badge-disetujui     {background:#dcfce7;color:#15803d} .badge-disetujui .badge-dot{background:#15803d}
    .badge-sudah_kembali {background:#eff6ff;color:#1d4ed8} .badge-sudah_kembali .badge-dot{background:#1d4ed8}
    .badge-ditolak       {background:#fee2e2;color:#dc2626} .badge-ditolak   .badge-dot{background:#dc2626}
    .badge-kategori      {background:var(--surface3);color:var(--text2);border:1px solid var(--border)}

    /* ── Status timeline ── */
    .timeline{display:flex;flex-direction:column;gap:0}
    .tl-item{display:flex;gap:14px;position:relative;padding-bottom:18px}
    .tl-item:last-child{padding-bottom:0}
    .tl-item:not(:last-child) .tl-line{position:absolute;left:13px;top:26px;bottom:0;width:1px;background:var(--border)}
    .tl-dot{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid var(--border);background:var(--surface2);z-index:1}
    .tl-dot.active{border-color:var(--brand-500);background:var(--brand-50)}
    .tl-dot.done-green{border-color:#15803d;background:#f0fdf4}
    .tl-dot.done-red{border-color:#dc2626;background:#fee2e2}
    .tl-dot.done-blue{border-color:#1d4ed8;background:#eff6ff}
    .tl-content{padding-top:4px;flex:1}
    .tl-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text)}
    .tl-time{font-size:11.5px;color:var(--text3);margin-top:1px}
    .tl-by{font-size:12px;color:var(--text2);margin-top:2px}

    /* ── Alert box ── */
    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:0;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600}
    .alert-warning{background:#fffbeb;border:1px solid #fde68a;color:#92400e}
    .alert-info   {background:#eff6ff;border:1px solid #bfdbfe;color:#1e40af}
    .alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#14532d}
    .alert-danger {background:#fff0f0;border:1px solid #fecaca;color:#991b1b}

    /* ── Duration pill ── */
    .duration-pill{display:inline-flex;align-items:center;gap:6px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:6px 14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text2)}

    /* ── Catatan kembali box ── */
    .catatan-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 16px;font-size:13px;color:var(--text2);line-height:1.6;margin-top:8px}

    @media(max-width:900px){
        .detail-grid{grid-template-columns:1fr}
    }
    @media(max-width:640px){
        .page{padding:16px}
        .header-actions{width:100%}
    }
</style>

<div class="page">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Izin Keluar Siswa</h1>
            <p class="page-sub">Informasi lengkap permohonan izin keluar</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.izin-keluar-siswa.index') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    {{-- ── Student Profile ── --}}
    @php
        $siswa  = $izin->siswa;
        $initials = collect(explode(' ', $siswa->nama_lengkap ?? 'S'))
            ->map(fn($w) => strtoupper(substr($w,0,1)))
            ->take(2)->join('');
    @endphp
    <div class="profile-card">
        <div class="profile-avatar">{{ $initials }}</div>
        <div>
            <p class="profile-name">{{ $siswa->nama_lengkap ?? '—' }}</p>
            <p class="profile-meta">NIS: {{ $siswa->nis ?? '—' }} &nbsp;·&nbsp; {{ $siswa->kelas->nama_kelas ?? '—' }}</p>
        </div>
        <div style="margin-left:auto;display:flex;align-items:center;gap:10px">
            @php
                $statusMap = [
                    'menunggu'      => 'Menunggu',
                    'disetujui'     => 'Disetujui',
                    'sudah_kembali' => 'Sudah Kembali',
                    'ditolak'       => 'Ditolak',
                ];
            @endphp
            <span class="badge badge-{{ $izin->status }}" style="font-size:13px;padding:5px 14px">
                <span class="badge-dot"></span>
                {{ $statusMap[$izin->status] ?? ucfirst($izin->status) }}
            </span>
        </div>
    </div>

    {{-- ── Main Grid ── --}}
    <div class="detail-grid">

        {{-- ── Left Column ── --}}
        <div>

            {{-- Detail Permohonan --}}
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    <span class="card-title">Detail Permohonan</span>
                </div>
                <div class="card-body">
                    <table class="info-table">
                        <tr>
                            <td class="lbl">Tanggal</td>
                            <td class="val" style="font-weight:700">
                                {{ \Carbon\Carbon::parse($izin->tanggal)->isoFormat('dddd, D MMMM Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="lbl">Kategori</td>
                            <td class="val">
                                <span class="badge badge-kategori">{{ ucfirst($izin->kategori) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="lbl">Jam Keluar</td>
                            <td class="val">
                                {{ $izin->jam_keluar ? \Carbon\Carbon::parse($izin->jam_keluar)->format('H:i') : '—' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="lbl">Est. Kembali</td>
                            <td class="val">
                                {{ $izin->estimasi_kembali ? \Carbon\Carbon::parse($izin->estimasi_kembali)->format('H:i') : '—' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="lbl">Jam Kembali</td>
                            <td class="val">
                                @if($izin->jam_kembali)
                                    <span style="font-weight:700;color:#15803d">
                                        {{ \Carbon\Carbon::parse($izin->jam_kembali)->format('H:i') }}
                                    </span>
                                @else
                                    <span style="color:var(--text3)">Belum kembali</span>
                                @endif
                            </td>
                        </tr>
                        @if($izin->jam_keluar && $izin->jam_kembali)
                        <tr>
                            <td class="lbl">Durasi</td>
                            <td class="val">
                                @php
                                    $keluar  = \Carbon\Carbon::parse($izin->jam_keluar);
                                    $kembali = \Carbon\Carbon::parse($izin->jam_kembali);
                                    $diff    = $keluar->diff($kembali);
                                    $durasi  = ($diff->h > 0 ? $diff->h . ' jam ' : '') . $diff->i . ' menit';
                                @endphp
                                <span class="duration-pill">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    {{ $durasi }}
                                </span>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td class="lbl">Tahun Ajaran</td>
                            <td class="val">{{ $izin->tahunAjaran->nama ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Dibuat</td>
                            <td class="val">{{ \Carbon\Carbon::parse($izin->created_at)->format('d M Y, H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Keperluan / Alasan --}}
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    <span class="card-title">Keperluan / Alasan</span>
                </div>
                <div class="card-body">
                    <p style="font-size:13.5px;color:var(--text);line-height:1.7">
                        {{ $izin->keperluan ?? '—' }}
                    </p>
                </div>
            </div>

            {{-- Catatan Kembali (tampil jika ada) --}}
            @if($izin->catatan_kembali)
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    <span class="card-title">Catatan Kepulangan</span>
                </div>
                <div class="card-body">
                    <div class="catatan-box">{{ $izin->catatan_kembali }}</div>
                    @if($izin->dicatatKembaliOleh)
                    <p style="font-size:12px;color:var(--text3);margin-top:8px">
                        Dicatat oleh <strong style="color:var(--text2)">{{ $izin->dicatatKembaliOleh->name }}</strong>
                        pada {{ \Carbon\Carbon::parse($izin->updated_at)->format('d M Y, H:i') }}
                    </p>
                    @endif
                </div>
            </div>
            @endif

            {{-- Catatan Penolakan (tampil jika ditolak) --}}
            @if($izin->status === 'ditolak' && $izin->alasan_penolakan)
            <div class="card" style="border-left:3px solid #dc2626">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    <span class="card-title" style="color:#dc2626">Alasan Penolakan</span>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger" style="margin:0">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $izin->alasan_penolakan }}
                    </div>
                </div>
            </div>
            @endif

        </div>

        {{-- ── Right Column ── --}}
        <div>

            {{-- Status & Proses --}}
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    <span class="card-title">Riwayat Status</span>
                </div>
                <div class="card-body">
                    <div class="timeline">

                        {{-- Pengajuan --}}
                        <div class="tl-item">
                            <div class="tl-line"></div>
                            <div class="tl-dot done-green">
                                <svg width="12" height="12" fill="none" stroke="#15803d" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <div class="tl-content">
                                <p class="tl-label">Permohonan Diajukan</p>
                                <p class="tl-time">{{ \Carbon\Carbon::parse($izin->created_at)->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        {{-- Proses / Persetujuan --}}
                        <div class="tl-item">
                            <div class="tl-line"></div>
                            @if(in_array($izin->status, ['disetujui', 'sudah_kembali', 'ditolak']))
                                <div class="tl-dot {{ $izin->status === 'ditolak' ? 'done-red' : 'done-green' }}">
                                    @if($izin->status === 'ditolak')
                                        <svg width="12" height="12" fill="none" stroke="#dc2626" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    @else
                                        <svg width="12" height="12" fill="none" stroke="#15803d" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                    @endif
                                </div>
                            @else
                                <div class="tl-dot active">
                                    <svg width="12" height="12" fill="none" stroke="var(--brand-500)" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                </div>
                            @endif
                            <div class="tl-content">
                                <p class="tl-label">
                                    @if($izin->status === 'menunggu')
                                        Menunggu Persetujuan
                                    @elseif($izin->status === 'ditolak')
                                        Permohonan Ditolak
                                    @else
                                        Permohonan Disetujui
                                    @endif
                                </p>
                                @if($izin->diprosesOleh)
                                <p class="tl-by">
                                    oleh <strong>{{ $izin->diprosesOleh->name }}</strong>
                                </p>
                                @elseif($izin->status === 'menunggu')
                                <p class="tl-time" style="color:#a16207">Menunggu tindakan</p>
                                @endif
                            </div>
                        </div>

                        {{-- Kembali --}}
                        <div class="tl-item">
                            @if($izin->status === 'sudah_kembali')
                                <div class="tl-dot done-blue">
                                    <svg width="12" height="12" fill="none" stroke="#1d4ed8" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                            @else
                                <div class="tl-dot">
                                    <svg width="12" height="12" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                                </div>
                            @endif
                            <div class="tl-content">
                                <p class="tl-label" style="{{ $izin->status !== 'sudah_kembali' ? 'color:var(--text3)' : '' }}">
                                    Siswa Sudah Kembali
                                </p>
                                @if($izin->jam_kembali)
                                <p class="tl-time">Pukul {{ \Carbon\Carbon::parse($izin->jam_kembali)->format('H:i') }}</p>
                                @endif
                                @if($izin->dicatatKembaliOleh)
                                <p class="tl-by">dicatat oleh <strong>{{ $izin->dicatatKembaliOleh->name }}</strong></p>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Info status ringkas --}}
            <div class="card">
                <div class="card-header">
                    <svg width="15" height="15" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span class="card-title">Informasi Tambahan</span>
                </div>
                <div class="card-body" style="display:flex;flex-direction:column;gap:8px">

                    @if($izin->status === 'menunggu')
                    <div class="alert alert-warning">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Permohonan ini masih menunggu persetujuan dari pihak yang berwenang.
                    </div>
                    @elseif($izin->status === 'disetujui')
                    <div class="alert alert-success">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Izin telah disetujui. Siswa diperbolehkan meninggalkan kelas.
                    </div>
                    @elseif($izin->status === 'sudah_kembali')
                    <div class="alert alert-info">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Siswa telah kembali ke kelas.
                    </div>
                    @elseif($izin->status === 'ditolak')
                    <div class="alert alert-danger">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        Permohonan izin ini telah ditolak.
                    </div>
                    @endif

                    {{-- Info prosesor --}}
                    @if($izin->diprosesOleh)
                    <table class="info-table" style="margin-top:4px">
                        <tr>
                            <td class="lbl">Diproses Oleh</td>
                            <td class="val">{{ $izin->diprosesOleh->name }}</td>
                        </tr>
                    </table>
                    @endif

                </div>
            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({
    icon: 'success', title: 'Berhasil!',
    text: @json(session('success')),
    timer: 2800, showConfirmButton: false,
    toast: true, position: 'top-end'
});
@endif
</script>
</x-app-layout>