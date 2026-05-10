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
        --green-bg:#f0fdf4;--green-txt:#15803d;--green-border:#bbf7d0;
        --yellow-bg:#fefce8;--yellow-txt:#a16207;--yellow-border:#fde68a;
        --blue-bg:#eff6ff;--blue-txt:#1d4ed8;--blue-border:#bfdbfe;
        --red-bg:#fee2e2;--red-txt:#dc2626;--red-border:#fecaca;
    }

    /* ── Layout ── */
    .page{padding:28px 28px 48px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    /* ── Buttons ── */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    /* ── Profile Card ── */
    .profile-card{background:linear-gradient(135deg,var(--brand-50) 0%,#f8fbff 100%);border:1px solid var(--brand-100);border-radius:var(--radius);padding:20px 24px;margin-bottom:16px;display:flex;align-items:center;gap:18px;flex-wrap:wrap}
    .profile-avatar{width:52px;height:52px;border-radius:50%;background:var(--brand-600);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:18px;color:#fff;flex-shrink:0;box-shadow:0 4px 12px rgba(31,99,219,.25)}
    .profile-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text)}
    .profile-meta{font-size:12.5px;color:var(--text3);margin-top:3px}
    .profile-status{margin-left:auto}

    /* ── Layout Grid ── */
    .detail-grid{display:grid;grid-template-columns:1fr 340px;gap:16px;align-items:start}

    /* ── Card ── */
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card:last-child{margin-bottom:0}
    .card-header{display:flex;align-items:center;gap:10px;padding:13px 18px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .card-icon{width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;background:var(--brand-50);flex-shrink:0}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:800;color:var(--text);letter-spacing:.01em}
    .card-body{padding:18px 20px}

    /* ── Info Table ── */
    .info-table{width:100%;border-collapse:collapse}
    .info-table tr{border-bottom:1px solid #f1f5f9}
    .info-table tr:last-child{border-bottom:none}
    .info-table td{padding:9px 0;vertical-align:top}
    .info-table .lbl{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);width:145px;text-transform:uppercase;letter-spacing:.05em;padding-right:16px;white-space:nowrap;padding-top:11px}
    .info-table .val{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text)}

    /* ── Badges ── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-lg{padding:5px 14px;font-size:13px}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-menunggu      {background:var(--yellow-bg);color:var(--yellow-txt)} .badge-menunggu  .badge-dot{background:var(--yellow-txt)}
    .badge-disetujui     {background:var(--green-bg);color:var(--green-txt)}   .badge-disetujui .badge-dot{background:var(--green-txt)}
    .badge-sudah_kembali {background:var(--blue-bg);color:var(--blue-txt)}     .badge-sudah_kembali .badge-dot{background:var(--blue-txt)}
    .badge-ditolak       {background:var(--red-bg);color:var(--red-txt)}       .badge-ditolak   .badge-dot{background:var(--red-txt)}
    .badge-kategori      {background:var(--surface3);color:var(--text2);border:1px solid var(--border)}

    /* ── Duration Pill ── */
    .duration-pill{display:inline-flex;align-items:center;gap:6px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:5px 12px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text2)}

    /* ── Tujuan text ── */
    .tujuan-text{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);line-height:1.75}
    .keterangan-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 16px;font-size:13px;color:var(--text2);line-height:1.65;margin-top:12px}
    .keterangan-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px}

    /* ── Catatan piket box ── */
    .catatan-box{background:var(--blue-bg);border:1px solid var(--blue-border);border-radius:var(--radius-sm);padding:12px 16px;font-size:13px;color:var(--blue-txt);line-height:1.65}

    /* ── Timeline ── */
    .timeline{display:flex;flex-direction:column}
    .tl-item{display:flex;gap:14px;position:relative;padding-bottom:20px}
    .tl-item:last-child{padding-bottom:0}
    .tl-line{position:absolute;left:13px;top:28px;bottom:0;width:1px;background:var(--border)}
    .tl-dot{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid var(--border);background:var(--surface2);z-index:1;position:relative}
    .tl-dot.done-green{border-color:var(--green-txt);background:var(--green-bg)}
    .tl-dot.done-red  {border-color:var(--red-txt);background:var(--red-bg)}
    .tl-dot.done-blue {border-color:var(--blue-txt);background:var(--blue-bg)}
    .tl-dot.pending   {border-color:var(--yellow-txt);background:var(--yellow-bg)}
    .tl-content{padding-top:4px;flex:1;min-width:0}
    .tl-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .tl-label.dim{color:var(--text3)}
    .tl-time{font-size:11.5px;color:var(--text3);margin-top:2px}
    .tl-by  {font-size:12px;color:var(--text2);margin-top:2px}

    /* ── Alert ── */
    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 14px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;line-height:1.55}
    .alert svg{flex-shrink:0;margin-top:1px}
    .alert-warning{background:var(--yellow-bg);border:1px solid var(--yellow-border);color:#92400e}
    .alert-info   {background:var(--blue-bg);border:1px solid var(--blue-border);color:#1e40af}
    .alert-success{background:var(--green-bg);border:1px solid var(--green-border);color:#14532d}
    .alert-danger {background:var(--red-bg);border:1px solid var(--red-border);color:#991b1b}

    /* ── Divider ── */
    .divider{height:1px;background:var(--border);margin:14px 0}

    @media(max-width:900px){.detail-grid{grid-template-columns:1fr}}
    @media(max-width:640px){.page{padding:16px 16px 32px}.profile-status{margin-left:0}}
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
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    {{-- ── Student Profile ── --}}
    @php
        $siswa    = $izin->siswa;
        $initials = collect(explode(' ', $siswa->nama_lengkap ?? 'S'))
            ->map(fn($w) => strtoupper(substr($w, 0, 1)))
            ->take(2)->join('');
        $statusMap = \App\Models\IzinKeluarSiswa::STATUS_LIST;
    @endphp

    <div class="profile-card">
        <div class="profile-avatar">{{ $initials }}</div>
        <div>
            <p class="profile-name">{{ $siswa->nama_lengkap ?? '—' }}</p>
            <p class="profile-meta">
                NIS: {{ $siswa->nis ?? '—' }}
                &nbsp;·&nbsp;
                {{ $siswa->kelas->nama_kelas ?? '—' }}
            </p>
        </div>
        <div class="profile-status">
            <span class="badge badge-lg badge-{{ $izin->status }}">
                <span class="badge-dot"></span>
                {{ $statusMap[$izin->status] ?? ucfirst($izin->status) }}
            </span>
        </div>
    </div>

    {{-- ── Main Grid ── --}}
    <div class="detail-grid">

        {{-- ── LEFT COLUMN ── --}}
        <div>

            {{-- Detail Permohonan --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                    </div>
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
                                <span class="badge badge-kategori">
                                    {{ \App\Models\IzinKeluarSiswa::KATEGORI_LIST[$izin->kategori] ?? ucfirst($izin->kategori) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="lbl">Jam Keluar</td>
                            <td class="val" style="font-weight:600">
                                {{ $izin->jam_keluar ? substr($izin->jam_keluar, 0, 5) : '—' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="lbl">Est. Kembali</td>
                            <td class="val">
                                {{-- jam_kembali = estimasi yang diajukan saat izin --}}
                                {{ $izin->jam_kembali ? substr($izin->jam_kembali, 0, 5) : '—' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="lbl">Jam Kembali Aktual</td>
                            <td class="val">
                                @if($izin->jam_kembali_aktual)
                                    <span style="font-weight:700;color:var(--green-txt)">
                                        {{ substr($izin->jam_kembali_aktual, 0, 5) }}
                                    </span>
                                @else
                                    <span style="color:var(--text3)">Belum kembali</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Durasi — hanya tampil jika sudah kembali --}}
                        @if($izin->jam_keluar && $izin->jam_kembali_aktual)
                        <tr>
                            <td class="lbl">Durasi</td>
                            <td class="val">
                                <span class="duration-pill">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    {{ $izin->durasi_formatted }}
                                </span>
                            </td>
                        </tr>
                        @endif

                        @if($izin->nomor_surat)
                        <tr>
                            <td class="lbl">Nomor Surat</td>
                            <td class="val" style="font-family:'DM Sans',monospace;font-size:13px">
                                {{ $izin->nomor_surat }}
                            </td>
                        </tr>
                        @endif

                        <tr>
                            <td class="lbl">Tahun Ajaran</td>
                            <td class="val">{{ $izin->tahunAjaran->nama ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Dibuat</td>
                            <td class="val">{{ \Carbon\Carbon::parse($izin->created_at)->isoFormat('D MMM Y, HH:mm') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Tujuan / Keperluan --}}
            {{-- Kolom yang benar di model & fillable adalah 'tujuan' --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <span class="card-title">Tujuan / Keperluan</span>
                </div>
                <div class="card-body">
                    <p class="tujuan-text">{{ $izin->tujuan ?: '—' }}</p>

                    {{-- Keterangan tambahan jika ada --}}
                    @if($izin->keterangan)
                        <div class="keterangan-box">
                            <p class="keterangan-label">Keterangan Tambahan</p>
                            <p>{{ $izin->keterangan }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Catatan Piket — tampil jika ada & sudah kembali --}}
            @if($izin->catatan_piket)
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <svg width="14" height="14" fill="none" stroke="var(--blue-txt)" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </div>
                    <span class="card-title">Catatan Piket Kepulangan</span>
                </div>
                <div class="card-body">
                    <div class="catatan-box">{{ $izin->catatan_piket }}</div>

                    @if($izin->dicatatKembaliOleh && $izin->dicatat_kembali_pada)
                    <p style="font-size:12px;color:var(--text3);margin-top:10px">
                        Dicatat oleh
                        <strong style="color:var(--text2)">{{ $izin->dicatatKembaliOleh->name }}</strong>
                        pada {{ \Carbon\Carbon::parse($izin->dicatat_kembali_pada)->isoFormat('D MMM Y, HH:mm') }}
                    </p>
                    @endif
                </div>
            </div>
            @endif

        </div>

        {{-- ── RIGHT COLUMN ── --}}
        <div>

            {{-- Riwayat Status (Timeline) --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                        </svg>
                    </div>
                    <span class="card-title">Riwayat Status</span>
                </div>
                <div class="card-body">
                    <div class="timeline">

                        {{-- 1. Diajukan --}}
                        <div class="tl-item">
                            <div class="tl-line"></div>
                            <div class="tl-dot done-green">
                                <svg width="11" height="11" fill="none" stroke="var(--green-txt)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <div class="tl-content">
                                <p class="tl-label">Permohonan Diajukan</p>
                                <p class="tl-time">{{ \Carbon\Carbon::parse($izin->created_at)->isoFormat('D MMM Y, HH:mm') }}</p>
                            </div>
                        </div>

                        {{-- 2. Proses Persetujuan --}}
                        <div class="tl-item">
                            <div class="tl-line"></div>
                            @php
                                $approved  = in_array($izin->status, ['disetujui', 'sudah_kembali']);
                                $rejected  = $izin->status === 'ditolak';
                                $waiting   = $izin->status === 'menunggu';
                            @endphp
                            <div class="tl-dot {{ $approved ? 'done-green' : ($rejected ? 'done-red' : ($waiting ? 'pending' : '')) }}">
                                @if($approved)
                                    <svg width="11" height="11" fill="none" stroke="var(--green-txt)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                @elseif($rejected)
                                    <svg width="11" height="11" fill="none" stroke="var(--red-txt)" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                @else
                                    <svg width="11" height="11" fill="none" stroke="var(--yellow-txt)" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                @endif
                            </div>
                            <div class="tl-content">
                                <p class="tl-label {{ $waiting ? 'dim' : '' }}">
                                    @if($waiting)    Menunggu Persetujuan
                                    @elseif($rejected) Permohonan Ditolak
                                    @else             Permohonan Disetujui
                                    @endif
                                </p>
                                @if($izin->diprosesOleh && $izin->diproses_pada)
                                    <p class="tl-time">{{ \Carbon\Carbon::parse($izin->diproses_pada)->isoFormat('D MMM Y, HH:mm') }}</p>
                                    <p class="tl-by">oleh <strong>{{ $izin->diprosesOleh->name }}</strong></p>
                                @elseif($waiting)
                                    <p class="tl-time" style="color:var(--yellow-txt)">Menunggu tindakan</p>
                                @endif
                            </div>
                        </div>

                        {{-- 3. Kembali --}}
                        <div class="tl-item">
                            @php $returned = $izin->status === 'sudah_kembali'; @endphp
                            <div class="tl-dot {{ $returned ? 'done-blue' : '' }}">
                                @if($returned)
                                    <svg width="11" height="11" fill="none" stroke="var(--blue-txt)" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                @else
                                    <svg width="11" height="11" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                                @endif
                            </div>
                            <div class="tl-content">
                                <p class="tl-label {{ !$returned ? 'dim' : '' }}">Siswa Sudah Kembali</p>
                                @if($izin->jam_kembali_aktual)
                                    <p class="tl-time">Pukul {{ substr($izin->jam_kembali_aktual, 0, 5) }}</p>
                                @endif
                                @if($izin->dicatatKembaliOleh)
                                    <p class="tl-by">dicatat oleh <strong>{{ $izin->dicatatKembaliOleh->name }}</strong></p>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Informasi Tambahan --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <span class="card-title">Informasi Tambahan</span>
                </div>
                <div class="card-body" style="display:flex;flex-direction:column;gap:10px">

                    {{-- Alert sesuai status --}}
                    @if($izin->status === 'menunggu')
                    <div class="alert alert-warning">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Permohonan ini masih menunggu persetujuan dari pihak yang berwenang.
                    </div>
                    @elseif($izin->status === 'disetujui')
                    <div class="alert alert-success">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Izin disetujui. Siswa diperbolehkan meninggalkan kelas.
                    </div>
                    @elseif($izin->status === 'sudah_kembali')
                    <div class="alert alert-info">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Siswa telah kembali ke kelas.
                    </div>
                    @elseif($izin->status === 'ditolak')
                    <div class="alert alert-danger">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        Permohonan izin ini telah ditolak.
                    </div>
                    @endif

                    {{-- Info diproses oleh --}}
                    @if($izin->diprosesOleh || $izin->dicatatKembaliOleh || $izin->nomor_surat)
                    <div class="divider"></div>
                    <table class="info-table">
                        @if($izin->diprosesOleh)
                        <tr>
                            <td class="lbl">Diproses Oleh</td>
                            <td class="val" style="font-size:13px">{{ $izin->diprosesOleh->name }}</td>
                        </tr>
                        @endif
                        @if($izin->diproses_pada)
                        <tr>
                            <td class="lbl">Waktu Proses</td>
                            <td class="val" style="font-size:13px">
                                {{ \Carbon\Carbon::parse($izin->diproses_pada)->isoFormat('D MMM Y, HH:mm') }}
                            </td>
                        </tr>
                        @endif
                        @if($izin->nomor_surat)
                        <tr>
                            <td class="lbl">Nomor Surat</td>
                            <td class="val" style="font-size:12.5px;font-family:'DM Sans',monospace">
                                {{ $izin->nomor_surat }}
                            </td>
                        </tr>
                        @endif
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
    icon:'success', title:'Berhasil!',
    text: @json(session('success')),
    timer:2800, showConfirmButton:false,
    toast:true, position:'top-end'
});
@endif
</script>
</x-app-layout>