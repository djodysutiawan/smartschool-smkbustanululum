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
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}
    .btn-toggle-on{background:#fefce8;color:#a16207;border:1px solid #fde68a}
    .btn-toggle-off{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-nilai{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}

    .stats-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.blue{background:#eff6ff}
    .stat-icon.green{background:#f0fdf4}
    .stat-icon.purple{background:#faf5ff}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    .layout{display:grid;grid-template-columns:1fr 300px;gap:16px;align-items:start}

    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .detail-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .detail-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .detail-card-body{padding:20px}

    .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:0}
    .info-row{display:flex;flex-direction:column;gap:3px;padding:12px 0;border-bottom:1px solid var(--surface3)}
    .info-row:last-child{border-bottom:none}
    .info-row.full{grid-column:span 2}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .info-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:600;color:var(--text)}
    .info-val.muted{color:var(--text3);font-weight:400}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-publish{background:#dcfce7;color:#15803d} .badge-publish .badge-dot{background:#15803d}
    .badge-draft  {background:#f1f5f9;color:#64748b} .badge-draft   .badge-dot{background:#94a3b8}
    .badge-belum_dikumpulkan{background:#f1f5f9;color:#64748b}   .badge-belum_dikumpulkan .badge-dot{background:#94a3b8}
    .badge-dikumpulkan      {background:#dcfce7;color:#15803d}   .badge-dikumpulkan       .badge-dot{background:#15803d}
    .badge-terlambat        {background:#fefce8;color:#a16207}   .badge-terlambat         .badge-dot{background:#a16207}
    .badge-sudah_dinilai    {background:#eff6ff;color:#1d4ed8}   .badge-sudah_dinilai     .badge-dot{background:#3b82f6}
    .badge-expired{background:#fee2e2;color:#dc2626}             .badge-expired           .badge-dot{background:#dc2626}

    .progress-bar-wrap{height:8px;background:var(--surface3);border-radius:99px;overflow:hidden;margin-top:8px}
    .progress-bar{height:100%;background:var(--brand-500);border-radius:99px;transition:width .4s}

    table{width:100%;border-collapse:collapse;font-size:13px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    .action-group{display:flex;align-items:center;gap:5px;justify-content:center}

    .nilai-chip{display:inline-flex;align-items:center;justify-content:center;width:44px;height:26px;border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800}
    .nilai-high{background:#dcfce7;color:#15803d}
    .nilai-mid {background:#fefce8;color:#a16207}
    .nilai-low {background:#fee2e2;color:#dc2626}
    .nilai-none{background:var(--surface2);color:var(--text3)}

    .desc-box{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text2);line-height:1.7;white-space:pre-wrap}
    .file-row{display:flex;align-items:center;gap:10px;padding:10px 14px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm)}
    .file-row-icon{width:36px;height:36px;background:var(--brand-50);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .deadline-red{color:#dc2626;font-weight:700}

    {{-- Modal --}}
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:300;align-items:center;justify-content:center}
    .modal-overlay.active{display:flex}
    .modal{background:var(--surface);border-radius:var(--radius);width:420px;max-width:calc(100vw - 32px);box-shadow:0 20px 60px rgba(0,0,0,.15);overflow:hidden}
    .modal-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border)}
    .modal-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text)}
    .modal-close{width:28px;height:28px;display:flex;align-items:center;justify-content:center;border:none;background:var(--surface2);border-radius:6px;cursor:pointer;color:var(--text3)}
    .modal-close:hover{background:var(--surface3)}
    .modal-body{padding:20px}
    .modal-footer{display:flex;gap:8px;justify-content:flex-end;padding:14px 20px;border-top:1px solid var(--border);background:var(--surface2)}
    .field{display:flex;flex-direction:column;gap:5px;margin-bottom:14px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .field input,.field textarea{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;box-sizing:border-box}
    .field input:focus,.field textarea:focus{border-color:var(--brand-500);background:#fff}
    .field textarea{resize:vertical;min-height:80px}

    @media(max-width:900px){.layout{grid-template-columns:1fr}}
    @media(max-width:640px){.page{padding:16px}.stats-strip{grid-template-columns:1fr}.info-grid{grid-template-columns:1fr}.info-row.full{grid-column:span 1}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Tugas</h1>
            <p class="page-sub">{{ $tugas->judul }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.tugas.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('guru.tugas.edit', $tugas->id) }}" class="btn btn-edit">Edit</a>
            <form action="{{ route('guru.tugas.toggle-status', $tugas->id) }}" method="POST" style="display:inline">
                @csrf @method('PATCH')
                @if($tugas->dipublikasikan)
                    <button type="submit" class="btn btn-toggle-on">Sembunyikan</button>
                @else
                    <button type="submit" class="btn btn-toggle-off">Publikasikan</button>
                @endif
            </form>
            <form action="{{ route('guru.tugas.destroy', $tugas->id) }}" method="POST" id="delForm" style="display:inline">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">Hapus</button>
            </form>
        </div>
    </div>

    {{-- Progress Stats --}}
    @php
        $pct = $stats['total_siswa'] > 0 ? round(($stats['terkumpul'] / $stats['total_siswa']) * 100) : 0;
        $pctNilai = $stats['terkumpul'] > 0 ? round(($stats['sudah_dinilai'] / $stats['terkumpul']) * 100) : 0;
    @endphp
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div style="flex:1">
                <p class="stat-label">Total Siswa</p>
                <p class="stat-val">{{ $stats['total_siswa'] }}</p>
                <p class="stat-sub">di kelas ini</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div style="flex:1">
                <p class="stat-label">Terkumpul</p>
                <p class="stat-val">{{ $stats['terkumpul'] }} <span style="font-size:14px;font-weight:400;color:var(--text3)">/ {{ $stats['total_siswa'] }}</span></p>
                <div class="progress-bar-wrap"><div class="progress-bar" style="width:{{ $pct }}%"></div></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
            </div>
            <div style="flex:1">
                <p class="stat-label">Sudah Dinilai</p>
                <p class="stat-val">{{ $stats['sudah_dinilai'] }} <span style="font-size:14px;font-weight:400;color:var(--text3)">/ {{ $stats['terkumpul'] }}</span></p>
                <div class="progress-bar-wrap"><div class="progress-bar" style="width:{{ $pctNilai }}%;background:#a855f7"></div></div>
            </div>
        </div>
    </div>

    <div class="layout">
        {{-- Kiri --}}
        <div>
            {{-- Info Tugas --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span class="detail-card-title">Informasi Tugas</span>
                </div>
                <div class="detail-card-body">
                    <div class="info-grid">
                        <div class="info-row"><span class="info-label">Kelas</span><span class="info-val">{{ $tugas->kelas->nama_kelas ?? '—' }}</span></div>
                        <div class="info-row"><span class="info-label">Mata Pelajaran</span><span class="info-val">{{ $tugas->mataPelajaran->nama_mapel ?? '—' }}</span></div>
                        <div class="info-row"><span class="info-label">Tahun Ajaran</span><span class="info-val">{{ $tugas->tahunAjaran->tahun ?? '—' }}</span></div>
                        <div class="info-row"><span class="info-label">Jenis Pengumpulan</span><span class="info-val">{{ strtoupper($tugas->jenis_pengumpulan) }}</span></div>
                        <div class="info-row">
                            <span class="info-label">Batas Waktu</span>
                            @php $expired = \Carbon\Carbon::parse($tugas->batas_waktu)->isPast(); @endphp
                            <span class="info-val {{ $expired ? 'deadline-red' : '' }}">
                                {{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M Y, H:i') }}
                                @if($expired) <span class="badge badge-expired" style="margin-left:6px"><span class="badge-dot"></span>Kedaluwarsa</span>@endif
                            </span>
                        </div>
                        <div class="info-row"><span class="info-label">Nilai Maksimal</span><span class="info-val">{{ $tugas->nilai_maksimal ?? 100 }}</span></div>
                        <div class="info-row">
                            <span class="info-label">Status</span>
                            <span class="info-val">
                                @if($tugas->dipublikasikan)
                                    <span class="badge badge-publish"><span class="badge-dot"></span>Dipublikasikan</span>
                                @else
                                    <span class="badge badge-draft"><span class="badge-dot"></span>Draft</span>
                                @endif
                            </span>
                        </div>
                        <div class="info-row"><span class="info-label">Izin Terlambat</span><span class="info-val">{{ $tugas->izinkan_terlambat ? 'Ya' : 'Tidak' }}</span></div>
                    </div>
                </div>
            </div>

            @if($tugas->deskripsi)
            <div class="detail-card">
                <div class="detail-card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg>
                    <span class="detail-card-title">Deskripsi / Petunjuk</span>
                </div>
                <div class="detail-card-body"><p class="desc-box">{{ $tugas->deskripsi }}</p></div>
            </div>
            @endif

            @if($tugas->path_file_soal)
            <div class="detail-card">
                <div class="detail-card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <span class="detail-card-title">File Soal</span>
                </div>
                <div class="detail-card-body">
                    <div class="file-row">
                        <div class="file-row-icon"><svg width="16" height="16" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                        <div style="flex:1;overflow:hidden">
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ basename($tugas->path_file_soal) }}</p>
                            <p style="font-size:11.5px;color:var(--text3)">File soal tugas</p>
                        </div>
                        <a href="{{ Storage::url($tugas->path_file_soal) }}" target="_blank" class="btn btn-secondary btn-sm">Download</a>
                    </div>
                </div>
            </div>
            @endif

            {{-- Tabel Pengumpulan --}}
            <div class="detail-card">
                <div class="detail-card-header" style="justify-content:space-between">
                    <div style="display:flex;align-items:center;gap:8px">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        <span class="detail-card-title">Riwayat Pengumpulan ({{ $tugas->pengumpulan->count() }})</span>
                    </div>
                    <a href="{{ route('guru.pengumpulan-tugas.index', ['tugas_id' => $tugas->id]) }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
                </div>
                <div style="overflow-x:auto">
                    <table>
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Dikumpulkan</th>
                                <th class="center">Status</th>
                                <th class="center">Nilai</th>
                                <th class="center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tugas->pengumpulan->take(10) as $p)
                            <tr>
                                <td>
                                    <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px">{{ $p->siswa->nama_lengkap ?? '—' }}</p>
                                    <p style="font-size:11.5px;color:var(--text3)">{{ $p->siswa->nis ?? '' }}</p>
                                </td>
                                <td style="font-size:12.5px;color:var(--text2)">{{ $p->created_at ? $p->created_at->format('d M Y, H:i') : '—' }}</td>
                                <td class="center">
                                    <span class="badge badge-{{ $p->status }}">
                                        <span class="badge-dot"></span>{{ ucwords(str_replace('_',' ',$p->status)) }}
                                    </span>
                                </td>
                                <td class="center">
                                    @php
                                        $nc = 'nilai-none';
                                        if ($p->nilai !== null) { $nc = $p->nilai >= 75 ? 'nilai-high' : ($p->nilai >= 50 ? 'nilai-mid' : 'nilai-low'); }
                                    @endphp
                                    <span class="nilai-chip {{ $nc }}">{{ $p->nilai !== null ? $p->nilai : '—' }}</span>
                                </td>
                                <td class="center">
                                    <div class="action-group">
                                        <a href="{{ route('guru.pengumpulan-tugas.show', $p->id) }}" class="btn btn-sm btn-secondary">Detail</a>
                                        @if(in_array($p->status, ['dikumpulkan','terlambat','sudah_dinilai']))
                                            <button type="button" class="btn btn-sm btn-nilai"
                                                onclick="openNilai({{ $p->id }}, {{ $tugas->nilai_maksimal ?? 100 }}, {{ $p->nilai ?? 'null' }}, `{{ addslashes($p->umpan_balik ?? '') }}`)">
                                                Nilai
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" style="text-align:center;padding:32px;color:var(--text3);font-size:13px">Belum ada siswa yang mengumpulkan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            <div class="detail-card">
                <div class="detail-card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                    <span class="detail-card-title">Aksi Cepat</span>
                </div>
                <div class="detail-card-body" style="display:flex;flex-direction:column;gap:8px">
                    <a href="{{ route('guru.tugas.edit', $tugas->id) }}" class="btn btn-edit" style="width:100%;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit Tugas
                    </a>
                    <a href="{{ route('guru.pengumpulan-tugas.index', ['tugas_id' => $tugas->id]) }}" class="btn btn-primary" style="width:100%;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/></svg>
                        Kelola Pengumpulan
                    </a>
                    <form action="{{ route('guru.tugas.toggle-status', $tugas->id) }}" method="POST">
                        @csrf @method('PATCH')
                        @if($tugas->dipublikasikan)
                            <button type="submit" class="btn btn-toggle-on" style="width:100%;justify-content:center">Sembunyikan Tugas</button>
                        @else
                            <button type="submit" class="btn btn-toggle-off" style="width:100%;justify-content:center">Publikasikan Tugas</button>
                        @endif
                    </form>
                    <button type="button" class="btn btn-del" style="width:100%;justify-content:center" onclick="confirmDelete()">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                        Hapus Tugas
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Nilai --}}
<div class="modal-overlay" id="nilaiModal">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Beri Nilai</span>
            <button type="button" class="modal-close" onclick="closeNilai()">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="nilaiForm" method="POST">
            @csrf @method('PATCH')
            <div class="modal-body">
                <div class="field">
                    <label>Nilai <span style="color:#dc2626">*</span> <span id="nilaiHint" style="font-weight:400;color:var(--text3)"></span></label>
                    <input type="number" name="nilai" id="nilaiInput" min="0" step="0.5" required>
                </div>
                <div class="field">
                    <label>Umpan Balik <span style="font-weight:400;color:var(--text3)">(opsional)</span></label>
                    <textarea name="umpan_balik" id="umpanBalikInput" placeholder="Komentar untuk siswa…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeNilai()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Nilai</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif

function confirmDelete() {
    Swal.fire({
        title: 'Hapus Tugas?',
        html: `Tugas <strong>{{ addslashes($tugas->judul) }}</strong> dan semua pengumpulan siswa akan dihapus permanen.`,
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) document.getElementById('delForm').submit(); });
}

function openNilai(id, maks, nilaiVal, umpanVal) {
    document.getElementById('nilaiForm').action = `/guru/pengumpulan-tugas/${id}/beri-nilai`;
    document.getElementById('nilaiInput').max   = maks;
    document.getElementById('nilaiInput').value = nilaiVal !== null ? nilaiVal : '';
    document.getElementById('umpanBalikInput').value = umpanVal || '';
    document.getElementById('nilaiHint').textContent = `maks. ${maks}`;
    document.getElementById('nilaiModal').classList.add('active');
}
function closeNilai() { document.getElementById('nilaiModal').classList.remove('active'); }
document.getElementById('nilaiModal').addEventListener('click', e => { if(e.target===document.getElementById('nilaiModal')) closeNilai(); });
</script>
</x-app-layout>