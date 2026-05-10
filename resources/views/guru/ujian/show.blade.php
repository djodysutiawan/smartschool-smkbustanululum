<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#15803d;--red:#dc2626;--purple:#7c3aed;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.3}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap}
    .breadcrumb{display:flex;align-items:center;gap:6px;margin-bottom:20px;font-size:12.5px;color:var(--text3);flex-wrap:wrap}
    .breadcrumb a{color:var(--text3);text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600}
    .breadcrumb a:hover{color:var(--text)}
    .breadcrumb-current{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text2)}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-hasil{background:#faf5ff;color:var(--purple);border:1px solid #e9d5ff}
    .btn-hasil:hover{background:#f3e8ff;filter:none}
    .btn-soal{background:var(--brand-600);color:#fff}
    .btn-soal:hover{background:var(--brand-700);filter:none}

    .stats-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;display:flex;align-items:center;gap:10px}
    .stat-icon{width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.blue{background:#eff6ff}
    .stat-icon.green{background:#f0fdf4}
    .stat-icon.purple{background:#faf5ff}
    .stat-icon.yellow{background:#fefce8}
    .stat-icon.red{background:#fff0f0}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.1}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    .detail-layout{display:grid;grid-template-columns:1fr 300px;gap:16px;align-items:start}
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card:last-child{margin-bottom:0}
    .card-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;background:var(--surface2)}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .card-body{padding:20px}

    .detail-list{display:flex;flex-direction:column}
    .detail-row{display:flex;align-items:flex-start;gap:12px;padding:11px 0;border-bottom:1px solid var(--surface3)}
    .detail-row:last-child{border-bottom:none}
    .detail-icon{width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .detail-icon.blue{background:#eff6ff}
    .detail-icon.green{background:#f0fdf4}
    .detail-icon.yellow{background:#fefce8}
    .detail-icon.purple{background:#faf5ff}
    .detail-icon.gray{background:var(--surface2)}
    .detail-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;margin-bottom:2px}
    .detail-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text)}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%}
    .badge-aktif{background:#dcfce7;color:var(--green)} .badge-aktif .badge-dot{background:var(--green)}
    .badge-nonaktif{background:#fee2e2;color:var(--red)} .badge-nonaktif .badge-dot{background:var(--red)}
    .badge-ya{background:#dcfce7;color:var(--green)}
    .badge-tidak{background:var(--surface3);color:var(--text2)}

    .toggle-item{display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--surface3)}
    .toggle-item:last-child{border-bottom:none}
    .toggle-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}

    .keterangan-box{background:var(--surface2);border-radius:var(--radius-sm);padding:14px;font-size:13px;color:var(--text2);line-height:1.6;border-left:3px solid var(--brand-500)}

    .soal-list{display:flex;flex-direction:column;gap:0}
    .soal-item{display:flex;align-items:flex-start;gap:12px;padding:12px 20px;border-bottom:1px solid var(--surface3);transition:background .1s}
    .soal-item:last-child{border-bottom:none}
    .soal-item:hover{background:var(--surface2)}
    .soal-no{width:28px;height:28px;background:var(--brand-50);color:var(--brand-700);border-radius:7px;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;flex-shrink:0;margin-top:1px}
    .soal-text{font-size:13px;color:var(--text);line-height:1.5;flex:1}
    .soal-meta{font-size:11.5px;color:var(--text3);margin-top:3px}
    .soal-bobot{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--brand-600);background:var(--brand-50);padding:2px 8px;border-radius:99px;white-space:nowrap;flex-shrink:0}

    .soal-empty{padding:32px 20px;text-align:center}
    .soal-empty-icon{width:48px;height:48px;background:var(--surface2);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px}
    .soal-empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--text);margin-bottom:5px}
    .soal-empty-sub{font-size:12.5px;color:var(--text3);margin-bottom:16px}

    .alert-banner{background:#fffbeb;border:1px solid #fde68a;border-radius:var(--radius-sm);padding:10px 14px;margin-bottom:14px;display:flex;gap:9px;align-items:center}
    .alert-banner p{font-size:12.5px;color:#92400e;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600}

    @media(max-width:900px){
        .detail-layout{grid-template-columns:1fr}
        .stats-strip{grid-template-columns:1fr 1fr}
        .page{padding:16px}
    }
    @media(max-width:480px){
        .stats-strip{grid-template-columns:1fr 1fr}
        .stat-val{font-size:17px}
    }
</style>

<div class="page">

    <div class="breadcrumb">
        <a href="{{ route('guru.ujian.index') }}">Kelola Ujian</a>
        <span>›</span>
        <span class="breadcrumb-current">Detail Ujian</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $ujian->judul }}</h1>
            <p class="page-sub">
                {{ $ujian->mataPelajaran->nama_mapel ?? '—' }} &middot;
                {{ $ujian->kelas->nama_kelas ?? '—' }} &middot;
                {{ \Carbon\Carbon::parse($ujian->tanggal)->translatedFormat('d F Y') }}
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.ujian.hasil', $ujian->id) }}" class="btn btn-hasil">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                Hasil
            </a>
            <a href="{{ route('guru.ujian.edit', $ujian->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <a href="{{ route('guru.ujian.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="15" height="15" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Soal</p>
                <p class="stat-val">{{ $stats['total_soal'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="15" height="15" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Bobot</p>
                <p class="stat-val">{{ $stats['total_bobot'] }}</p>
                @if($stats['total_bobot'] !== 100 && $stats['total_soal'] > 0)
                    <p class="stat-sub" style="color:#c2410c">≠ 100</p>
                @endif
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="15" height="15" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div>
                <p class="stat-label">Peserta Selesai</p>
                <p class="stat-val">{{ $stats['siswa_selesai'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="15" height="15" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Lulus</p>
                <p class="stat-val">{{ $stats['siswa_lulus'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="15" height="15" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            </div>
            <div>
                <p class="stat-label">Rata-rata</p>
                <p class="stat-val">{{ $stats['rata_nilai'] }}</p>
            </div>
        </div>
    </div>

    @if($stats['total_soal'] > 0 && $stats['total_bobot'] != 100)
    <div class="alert-banner" style="margin-bottom:16px">
        <svg width="15" height="15" fill="none" stroke="#92400e" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        <p>Total bobot soal saat ini adalah <strong>{{ $stats['total_bobot'] }}</strong>, bukan 100. Pastikan total bobot = 100 agar nilai siswa dihitung dengan benar.</p>
    </div>
    @endif

    <div class="detail-layout">

        <div>
            <div class="card">
                <div class="card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
                    <span class="card-title">Detail Ujian</span>
                </div>
                <div class="card-body">
                    <div class="detail-list">
                        <div class="detail-row">
                            <div class="detail-icon blue"><svg width="13" height="13" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></div>
                            <div>
                                <p class="detail-label">Mata Pelajaran</p>
                                <p class="detail-val">{{ $ujian->mataPelajaran->nama_mapel ?? '—' }}</p>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-icon yellow"><svg width="13" height="13" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                            <div>
                                <p class="detail-label">Kelas &amp; Tahun Ajaran</p>
                                <p class="detail-val">
                                    {{ $ujian->kelas->nama_kelas ?? '—' }}
                                    &middot; {{ $ujian->tahunAjaran->nama ?? ($ujian->tahunAjaran->tahun ?? '—') }}
                                </p>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-icon blue"><svg width="13" height="13" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                            <div>
                                <p class="detail-label">Waktu Pelaksanaan</p>
                                <p class="detail-val">
                                    {{ \Carbon\Carbon::parse($ujian->tanggal)->translatedFormat('d F Y') }}
                                    @if($ujian->jam_mulai)
                                        &middot; {{ \Carbon\Carbon::parse($ujian->jam_mulai)->format('H:i') }} WIB
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-icon purple"><svg width="13" height="13" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
                            <div>
                                <p class="detail-label">Durasi &amp; KKM</p>
                                <p class="detail-val">
                                    {{ $ujian->durasi_menit }} menit
                                    @if($ujian->nilai_kkm)
                                        &middot; KKM {{ $ujian->nilai_kkm }}
                                    @else
                                        &middot; <span style="color:var(--text3);font-weight:400;font-size:13px">KKM tidak diset</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        @if($ujian->maks_percobaan)
                        <div class="detail-row">
                            <div class="detail-icon green"><svg width="13" height="13" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.03"/></svg></div>
                            <div>
                                <p class="detail-label">Maks. Percobaan</p>
                                <p class="detail-val">{{ $ujian->maks_percobaan }}x</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($ujian->keterangan)
            <div class="card">
                <div class="card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg>
                    <span class="card-title">Keterangan / Instruksi</span>
                </div>
                <div class="card-body">
                    <div class="keterangan-box">{{ $ujian->keterangan }}</div>
                </div>
            </div>
            @endif

            {{-- Daftar Soal --}}
            <div class="card">
                <div class="card-header" style="justify-content:space-between">
                    <div style="display:flex;align-items:center;gap:8px">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span class="card-title">Daftar Soal</span>
                        @if($stats['total_soal'] > 0)
                            <span style="background:var(--brand-50);color:var(--brand-700);font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:800;padding:2px 8px;border-radius:99px">
                                {{ $stats['total_soal'] }} soal
                            </span>
                        @endif
                    </div>
                    {{-- ✅ DIPERBAIKI: route ke soal.index (halaman kelola soal lengkap) --}}
                    <a href="{{ route('guru.ujian.soal.index', $ujian) }}" class="btn btn-soal" style="font-size:12px;padding:6px 12px">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Kelola Soal
                    </a>
                </div>

                @if($ujian->soal->count() > 0)
                <div class="soal-list">
                    @foreach($ujian->soal as $soal)
                    <div class="soal-item">
                        <div class="soal-no">{{ $soal->nomor_soal }}</div>
                        <div style="flex:1;min-width:0">
                            <p class="soal-text">{{ Str::limit(strip_tags($soal->pertanyaan ?? ''), 120) }}</p>
                            <p class="soal-meta">
                                {{ ucwords(str_replace('_', ' ', $soal->jenis_soal ?? 'pilihan_ganda')) }}
                            </p>
                        </div>
                        <span class="soal-bobot">{{ $soal->bobot }} poin</span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="soal-empty">
                    <div class="soal-empty-icon">
                        <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </div>
                    <p class="soal-empty-title">Belum ada soal</p>
                    <p class="soal-empty-sub">Ujian ini belum memiliki soal. Tambahkan soal agar siswa bisa mengerjakan ujian.</p>
                    {{-- ✅ DIPERBAIKI: langsung ke create soal jika belum ada soal sama sekali --}}
                    <a href="{{ route('guru.ujian.soal.create', $ujian) }}" class="btn btn-soal">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah Soal Pertama
                    </a>
                </div>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            <div class="card">
                <div class="card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/></svg>
                    <span class="card-title">Status &amp; Pengaturan</span>
                </div>
                <div class="card-body" style="padding:16px">
                    <div style="text-align:center;margin-bottom:16px">
                        @if($ujian->is_active)
                            <span class="badge badge-aktif" style="font-size:13px;padding:7px 20px">
                                <span class="badge-dot" style="width:7px;height:7px"></span>Ujian Aktif
                            </span>
                        @else
                            <span class="badge badge-nonaktif" style="font-size:13px;padding:7px 20px">
                                <span class="badge-dot" style="width:7px;height:7px"></span>Ujian Nonaktif
                            </span>
                        @endif
                    </div>
                    <div class="toggle-item">
                        <span class="toggle-name">Jenis</span>
                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)">
                            {{ ucwords(str_replace('_', ' ', $ujian->jenis)) }}
                        </span>
                    </div>
                    <div class="toggle-item">
                        <span class="toggle-name">Acak Soal</span>
                        <span class="badge {{ $ujian->acak_soal ? 'badge-ya' : 'badge-tidak' }}">{{ $ujian->acak_soal ? 'Ya' : 'Tidak' }}</span>
                    </div>
                    <div class="toggle-item">
                        <span class="toggle-name">Acak Pilihan</span>
                        <span class="badge {{ $ujian->acak_pilihan ? 'badge-ya' : 'badge-tidak' }}">{{ $ujian->acak_pilihan ? 'Ya' : 'Tidak' }}</span>
                    </div>
                    <div class="toggle-item">
                        <span class="toggle-name">Tampilkan Nilai</span>
                        <span class="badge {{ $ujian->tampilkan_nilai ? 'badge-ya' : 'badge-tidak' }}">{{ $ujian->tampilkan_nilai ? 'Ya' : 'Tidak' }}</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-500)" stroke-width="2" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    <span class="card-title">Aksi Cepat</span>
                </div>
                <div class="card-body" style="padding:12px 16px;display:flex;flex-direction:column;gap:8px">
                    {{-- ✅ DIPERBAIKI: Tambah tombol Kelola Soal di sidebar --}}
                    <a href="{{ route('guru.ujian.soal.index', $ujian) }}" class="btn btn-soal" style="width:100%;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Kelola Soal
                    </a>
                    <a href="{{ route('guru.ujian.hasil', $ujian->id) }}" class="btn btn-hasil" style="width:100%;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        Lihat Hasil Ujian
                    </a>
                    <a href="{{ route('guru.ujian.edit', $ujian->id) }}" class="btn btn-edit" style="width:100%;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit Ujian
                    </a>
                    <form action="{{ route('guru.ujian.toggle-status', $ujian->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-secondary" style="width:100%;justify-content:center">
                            @if($ujian->is_active)
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                Nonaktifkan Ujian
                            @else
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                Aktifkan Ujian
                            @endif
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif
</script>
</x-app-layout>