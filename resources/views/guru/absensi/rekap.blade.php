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
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    .filter-panel{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:20px;margin-bottom:20px;border-left:3px solid var(--brand-500)}
    .filter-panel-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);margin-bottom:14px;display:flex;align-items:center;gap:8px}
    .filter-form-row{display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end}
    .field{display:flex;flex-direction:column;gap:4px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text2)}
    .field select,.field input{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .field select:focus,.field input:focus{border-color:var(--brand-500);background:#fff}
    .field .error{font-size:11.5px;color:#dc2626;margin-top:2px}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;align-self:flex-end}
    .btn-filter:hover{background:var(--brand-700)}

    .stats-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;text-align:center;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;font-weight:800;color:var(--text);line-height:1.1}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;margin-top:4px}
    .stat-pct{font-size:12px;color:var(--text3);margin-top:2px}
    .stat-card.hadir .stat-val{color:#15803d}
    .stat-card.telat .stat-val{color:#a16207}
    .stat-card.izin  .stat-val{color:#1d4ed8}
    .stat-card.sakit .stat-val{color:#7c3aed}
    .stat-card.alfa  .stat-val{color:#dc2626}

    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border)}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:11px 12px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:9px 12px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}

    .pct-bar-wrap{height:6px;background:var(--surface3);border-radius:99px;overflow:hidden;min-width:60px;display:inline-block;width:60px;vertical-align:middle;margin-left:6px}
    .pct-bar{height:100%;border-radius:99px}
    .pct-bar.hadir{background:#15803d}
    .pct-bar.telat {background:#a16207}
    .pct-bar.izin  {background:#3b82f6}
    .pct-bar.sakit {background:#a855f7}
    .pct-bar.alfa  {background:#dc2626}

    .val-chip{display:inline-flex;align-items:center;justify-content:center;min-width:28px;height:22px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;padding:0 6px}
    .val-chip.hadir{background:#dcfce7;color:#15803d}
    .val-chip.telat{background:#fefce8;color:#a16207}
    .val-chip.izin {background:#eff6ff;color:#1d4ed8}
    .val-chip.sakit{background:#fdf4ff;color:#7c3aed}
    .val-chip.alfa {background:#fee2e2;color:#dc2626}

    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    @media(max-width:768px){.stats-strip{grid-template-columns:1fr 1fr}}
    @media(max-width:640px){.page{padding:16px}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Rekap Kehadiran</h1>
            <p class="page-sub">Laporan kehadiran siswa per kelas dalam rentang waktu tertentu</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.absensi.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Filter Panel --}}
    <div class="filter-panel">
        <p class="filter-panel-title">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            Filter Rekap Absensi
        </p>
        <form action="{{ route('guru.absensi.rekap') }}" method="GET">
            <div class="filter-form-row">
                <div class="field">
                    <label>Kelas <span style="color:#dc2626">*</span></label>
                    <select name="kelas_id" required style="min-width:180px">
                        <option value="">— Pilih Kelas —</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    @error('kelas_id')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="field">
                    <label>Dari Tanggal <span style="color:#dc2626">*</span></label>
                    <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" required>
                    @error('tanggal_dari')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="field">
                    <label>Sampai Tanggal <span style="color:#dc2626">*</span></label>
                    <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" required>
                    @error('tanggal_sampai')<span class="error">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn-filter">Lihat Rekap</button>
            </div>
        </form>
    </div>

    @if($absensi !== null)
        @php
            $allAbsensi = $absensi->flatten();
            $totalHadir = $allAbsensi->whereIn('status', ['hadir','telat'])->count();
            $totalIzin  = $allAbsensi->where('status','izin')->count();
            $totalSakit = $allAbsensi->where('status','sakit')->count();
            $totalAlfa  = $allAbsensi->where('status','alfa')->count();
            $totalTelat = $allAbsensi->where('status','telat')->count();
            $totalAll   = $allAbsensi->count();
        @endphp

        {{-- Header Kelas --}}
        @if($kelas)
        <div style="background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px">
            <div style="display:flex;align-items:center;gap:10px">
                <div style="width:36px;height:36px;background:var(--brand-600);border-radius:9px;display:flex;align-items:center;justify-content:center">
                    <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--brand-700)">{{ $kelas->nama_kelas }}</p>
                    <p style="font-size:12px;color:var(--brand-600)">
                        {{ \Carbon\Carbon::parse(request('tanggal_dari'))->format('d M Y') }} — {{ \Carbon\Carbon::parse(request('tanggal_sampai'))->format('d M Y') }}
                        · {{ $absensi->count() }} siswa
                    </p>
                </div>
            </div>
        </div>
        @endif

        {{-- Ringkasan Stats --}}
        <div class="stats-strip">
            <div class="stat-card hadir">
                <p class="stat-val">{{ $totalHadir }}</p>
                <p class="stat-label">Hadir</p>
                <p class="stat-pct">{{ $totalAll > 0 ? round(($totalHadir / $totalAll) * 100) : 0 }}%</p>
            </div>
            <div class="stat-card telat">
                <p class="stat-val">{{ $totalTelat }}</p>
                <p class="stat-label">Telat</p>
                <p class="stat-pct">{{ $totalAll > 0 ? round(($totalTelat / $totalAll) * 100) : 0 }}%</p>
            </div>
            <div class="stat-card izin">
                <p class="stat-val">{{ $totalIzin }}</p>
                <p class="stat-label">Izin</p>
                <p class="stat-pct">{{ $totalAll > 0 ? round(($totalIzin / $totalAll) * 100) : 0 }}%</p>
            </div>
            <div class="stat-card sakit">
                <p class="stat-val">{{ $totalSakit }}</p>
                <p class="stat-label">Sakit</p>
                <p class="stat-pct">{{ $totalAll > 0 ? round(($totalSakit / $totalAll) * 100) : 0 }}%</p>
            </div>
            <div class="stat-card alfa">
                <p class="stat-val">{{ $totalAlfa }}</p>
                <p class="stat-label">Alfa</p>
                <p class="stat-pct">{{ $totalAll > 0 ? round(($totalAlfa / $totalAll) * 100) : 0 }}%</p>
            </div>
        </div>

        {{-- Tabel Rekap Per Siswa --}}
        <div class="table-card">
            <div class="table-topbar">
                <p class="table-info">Rekap Per Siswa <span style="font-weight:400;color:var(--text3);margin-left:6px">— {{ $absensi->count() }} siswa</span></p>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width:40px">#</th>
                            <th>Nama Siswa</th>
                            <th class="center">Hadir</th>
                            <th class="center">Telat</th>
                            <th class="center">Izin</th>
                            <th class="center">Sakit</th>
                            <th class="center">Alfa</th>
                            <th class="center">Total</th>
                            <th>% Hadir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensi as $siswaId => $records)
                        @php
                            $siswa   = $records->first()->siswa;
                            $hadir   = $records->where('status','hadir')->count();
                            $telat   = $records->where('status','telat')->count();
                            $izin    = $records->where('status','izin')->count();
                            $sakit   = $records->where('status','sakit')->count();
                            $alfa    = $records->where('status','alfa')->count();
                            $total   = $records->count();
                            $pctHadir = $total > 0 ? round((($hadir + $telat) / $total) * 100) : 0;
                        @endphp
                        <tr>
                            <td style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)">{{ $loop->iteration }}</td>
                            <td>
                                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px">{{ $siswa->nama_lengkap ?? '—' }}</p>
                                <p style="font-size:11.5px;color:var(--text3)">{{ $siswa->nis ?? '' }}</p>
                            </td>
                            <td class="center"><span class="val-chip hadir">{{ $hadir }}</span></td>
                            <td class="center"><span class="val-chip telat">{{ $telat }}</span></td>
                            <td class="center"><span class="val-chip izin">{{ $izin }}</span></td>
                            <td class="center"><span class="val-chip sakit">{{ $sakit }}</span></td>
                            <td class="center"><span class="val-chip alfa">{{ $alfa }}</span></td>
                            <td class="center" style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px">{{ $total }}</td>
                            <td>
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:{{ $pctHadir >= 75 ? '#15803d' : ($pctHadir >= 50 ? '#a16207' : '#dc2626') }}">{{ $pctHadir }}%</span>
                                <div class="pct-bar-wrap">
                                    <div class="pct-bar {{ $pctHadir >= 75 ? 'hadir' : ($pctHadir >= 50 ? 'telat' : 'alfa') }}" style="width:{{ $pctHadir }}%"></div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon"><svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                                <p class="empty-title">Tidak ada data absensi</p>
                                <p class="empty-sub">Tidak ada catatan kehadiran pada rentang waktu yang dipilih</p>
                            </div>
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    @else
        {{-- State awal: belum ada filter --}}
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:60px 20px;text-align:center">
            <div style="width:60px;height:60px;background:var(--brand-50);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                <svg width="28" height="28" fill="none" stroke="var(--brand-500)" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:6px">Pilih Kelas dan Rentang Tanggal</p>
            <p style="font-size:13px;color:var(--text3)">Isi filter di atas lalu klik "Lihat Rekap" untuk menampilkan data kehadiran</p>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2800,showConfirmButton:false,toast:true,position:'top-end'});
@endif
@if($errors->any())
Swal.fire({icon:'warning',title:'Perhatian!',html:`{!! implode('<br>', $errors->all()) !!}`,confirmButtonColor:'#1f63db'});
@endif
</script>
</x-app-layout>