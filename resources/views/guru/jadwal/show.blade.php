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
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap}

    /* Breadcrumb */
    .breadcrumb{display:flex;align-items:center;gap:6px;margin-bottom:20px;font-size:12.5px;color:var(--text3);flex-wrap:wrap}
    .breadcrumb a{color:var(--text3);text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600}
    .breadcrumb a:hover{color:var(--text)}
    .breadcrumb-sep{color:var(--text3)}
    .breadcrumb-current{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text2)}

    /* Btn */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    /* Layout 2-col */
    .detail-layout{display:grid;grid-template-columns:1fr 320px;gap:16px;align-items:start}

    /* Card */
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card:last-child{margin-bottom:0}
    .card-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .card-body{padding:20px}

    /* Big time display */
    .time-hero{text-align:center;padding:24px 20px;background:linear-gradient(135deg,var(--brand-50) 0%,#e0f0ff 100%);border-bottom:1px solid var(--brand-100)}
    .time-hero-hari{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--brand-600);margin-bottom:6px}
    .time-hero-jam{font-family:'Plus Jakarta Sans',sans-serif;font-size:32px;font-weight:800;color:var(--text);letter-spacing:-1px}
    .time-hero-dur{font-size:12.5px;color:var(--text3);margin-top:4px}

    /* Detail list */
    .detail-list{display:flex;flex-direction:column;gap:0}
    .detail-row{display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid var(--surface3)}
    .detail-row:last-child{border-bottom:none}
    .detail-icon{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px}
    .detail-icon.blue{background:#eff6ff}
    .detail-icon.green{background:#f0fdf4}
    .detail-icon.yellow{background:#fefce8}
    .detail-icon.purple{background:#faf5ff}
    .detail-icon.gray{background:var(--surface2)}
    .detail-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:3px}
    .detail-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text)}
    .detail-sub{font-size:12px;color:var(--text3);margin-top:1px}

    /* Badges */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-aktif  {background:#dcfce7;color:#15803d} .badge-aktif  .badge-dot{background:#15803d}
    .badge-nonaktif{background:#fee2e2;color:#dc2626} .badge-nonaktif .badge-dot{background:#dc2626}

    /* Sidebar quick info */
    .quick-info{display:flex;flex-direction:column;gap:10px}
    .qi-item{background:var(--surface2);border-radius:var(--radius-sm);padding:12px 14px;display:flex;align-items:center;gap:10px}
    .qi-icon{width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .qi-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);margin-bottom:2px}
    .qi-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}

    /* Status hero pill */
    .status-hero{display:flex;align-items:center;justify-content:center;padding:16px;border-bottom:1px solid var(--border)}

    @media(max-width:900px){
        .detail-layout{grid-template-columns:1fr}
        .page{padding:16px}
    }
</style>

<div class="page">

    {{-- ── Breadcrumb ── --}}
    <div class="breadcrumb">
        <a href="{{ route('guru.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('guru.jadwal.index') }}">Jadwal Mengajar</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">Detail Jadwal</span>
    </div>

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $jadwal->mataPelajaran->nama_mapel ?? 'Detail Jadwal' }}</h1>
            <p class="page-sub">
                {{ $jadwal->kelas->nama_kelas ?? '—' }} &middot;
                {{ ucfirst($jadwal->hari) }} &middot;
                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.jadwal.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="detail-layout">

        {{-- ══ Kolom Kiri: Detail Utama ══ --}}
        <div>

            {{-- Waktu ── --}}
            <div class="card">
                <div class="time-hero">
                    <p class="time-hero-hari">{{ ucfirst($jadwal->hari) }}</p>
                    <p class="time-hero-jam">
                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                        <span style="color:var(--text3);font-weight:400;font-size:22px">–</span>
                        {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                    </p>
                    @php
                        $start    = \Carbon\Carbon::parse($jadwal->jam_mulai);
                        $end      = \Carbon\Carbon::parse($jadwal->jam_selesai);
                        $durasi   = $start->diffInMinutes($end);
                    @endphp
                    <p class="time-hero-dur">Durasi: {{ $durasi }} menit</p>
                </div>

                <div class="card-body">
                    <div class="detail-list">

                        {{-- Mata Pelajaran --}}
                        <div class="detail-row">
                            <div class="detail-icon blue">
                                <svg width="15" height="15" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                            </div>
                            <div>
                                <p class="detail-label">Mata Pelajaran</p>
                                <p class="detail-val">{{ $jadwal->mataPelajaran->nama_mapel ?? '—' }}</p>
                                @if($jadwal->mataPelajaran->kode_mapel ?? null)
                                    <p class="detail-sub">Kode: {{ $jadwal->mataPelajaran->kode_mapel }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Kelas --}}
                        <div class="detail-row">
                            <div class="detail-icon yellow">
                                <svg width="15" height="15" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            <div>
                                <p class="detail-label">Kelas</p>
                                <p class="detail-val">{{ $jadwal->kelas->nama_kelas ?? '—' }}</p>
                                @if($jadwal->kelas->tingkat ?? null)
                                    <p class="detail-sub">Tingkat: {{ $jadwal->kelas->tingkat }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Ruang --}}
                        <div class="detail-row">
                            <div class="detail-icon green">
                                <svg width="15" height="15" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            </div>
                            <div>
                                <p class="detail-label">Ruang / Lokasi</p>
                                <p class="detail-val">
                                    @if($jadwal->ruang)
                                        {{ is_object($jadwal->ruang) ? ($jadwal->ruang->nama_ruang ?? '—') : $jadwal->ruang }}
                                    @else
                                        <span style="color:var(--text3);font-weight:400">Tidak ditentukan</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        {{-- Guru --}}
                        <div class="detail-row">
                            <div class="detail-icon purple">
                                <svg width="15" height="15" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                            <div>
                                <p class="detail-label">Guru</p>
                                <p class="detail-val">{{ $jadwal->guru->nama_lengkap ?? (Auth::user()->name ?? '—') }}</p>
                                @if($jadwal->guru->nip ?? null)
                                    <p class="detail-sub">NIP: {{ $jadwal->guru->nip }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Tahun Ajaran --}}
                        <div class="detail-row">
                            <div class="detail-icon gray">
                                <svg width="15" height="15" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </div>
                            <div>
                                <p class="detail-label">Tahun Ajaran</p>
                                <p class="detail-val">
                                    {{ $jadwal->tahunAjaran->nama ?? ($jadwal->tahunAjaran->tahun ?? '—') }}
                                </p>
                                @if($jadwal->tahunAjaran->semester ?? null)
                                    <p class="detail-sub">Semester {{ $jadwal->tahunAjaran->semester }}</p>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        {{-- ══ Kolom Kanan: Sidebar ══ --}}
        <div>

            {{-- Status Card --}}
            <div class="card">
                <div class="status-hero">
                    @if($jadwal->is_active)
                        <span class="badge badge-aktif" style="font-size:13px;padding:6px 18px;gap:6px">
                            <span class="badge-dot" style="width:7px;height:7px"></span>
                            Jadwal Aktif
                        </span>
                    @else
                        <span class="badge badge-nonaktif" style="font-size:13px;padding:6px 18px;gap:6px">
                            <span class="badge-dot" style="width:7px;height:7px"></span>
                            Jadwal Nonaktif
                        </span>
                    @endif
                </div>
                <div class="card-body" style="padding:16px">
                    <div class="quick-info">
                        <div class="qi-item">
                            <div class="qi-icon" style="background:#eff6ff">
                                <svg width="14" height="14" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                            <div>
                                <p class="qi-label">Jam Mulai</p>
                                <p class="qi-val">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} WIB</p>
                            </div>
                        </div>
                        <div class="qi-item">
                            <div class="qi-icon" style="background:#f0fdf4">
                                <svg width="14" height="14" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                            <div>
                                <p class="qi-label">Jam Selesai</p>
                                <p class="qi-val">{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }} WIB</p>
                            </div>
                        </div>
                        <div class="qi-item">
                            <div class="qi-icon" style="background:#faf5ff">
                                <svg width="14" height="14" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            </div>
                            <div>
                                <p class="qi-label">Durasi</p>
                                <p class="qi-val">{{ $durasi }} menit</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Navigasi cepat --}}
            <div class="card">
                <div class="card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 8 8 12 12 16"/><line x1="16" y1="12" x2="8" y2="12"/></svg>
                    <span class="card-title">Navigasi</span>
                </div>
                <div class="card-body" style="padding:12px 16px;display:flex;flex-direction:column;gap:8px">
                    <a href="{{ route('guru.jadwal.index') }}" class="btn btn-secondary" style="width:100%;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Semua Jadwal
                    </a>
                    <a href="{{ route('guru.jurnal-mengajar.create') }}" class="btn" style="background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);width:100%;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Buat Jurnal Mengajar
                    </a>
                    <a href="{{ route('guru.absensi.create') }}" class="btn" style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;width:100%;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Catat Absensi
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
</x-app-layout>