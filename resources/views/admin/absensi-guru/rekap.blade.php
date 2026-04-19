<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--red:#dc2626;--radius:10px;--radius-sm:7px}
    .page{padding:28px 28px 60px;max-width:1400px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand)}.breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand);color:#fff}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}.btn-del:hover{background:#fee2e2;filter:none}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}.btn-back:hover{background:var(--surface3);filter:none}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:20px 24px;margin-bottom:20px}
    .filter-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);margin-bottom:14px}
    .filter-grid{display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:12px;align-items:end}
    .field{display:flex;flex-direction:column;gap:6px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
    .field input,.field select{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;box-sizing:border-box}
    .field input:focus,.field select:focus{border-color:var(--brand-h);background:#fff}
    .btn-filter{height:38px;padding:0 20px;background:var(--brand);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap}
    .result-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .result-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .result-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .result-title span{font-weight:400;color:var(--text3);margin-left:6px}
    .result-actions{display:flex;gap:8px}
    table{width:100%;border-collapse:collapse;font-size:13px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    td.muted{color:var(--text3);font-size:12.5px}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700}
    .badge-dot{width:4px;height:4px;border-radius:50%}
    .b-hadir{background:#dcfce7;color:#15803d}.b-hadir .badge-dot{background:#15803d}
    .b-telat{background:#fef9c3;color:#a16207}.b-telat .badge-dot{background:#a16207}
    .b-izin{background:#dbeafe;color:#1d4ed8}.b-izin .badge-dot{background:#1d4ed8}
    .b-sakit{background:#f3e8ff;color:#6d28d9}.b-sakit .badge-dot{background:#6d28d9}
    .b-alfa{background:#fee2e2;color:#dc2626}.b-alfa .badge-dot{background:#dc2626}
    .empty-state{padding:60px 20px;text-align:center}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}
    .prompt-box{padding:48px 20px;text-align:center}
    .prompt-icon{width:56px;height:56px;background:var(--brand-50);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px}
    .prompt-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:16px;color:var(--text);margin-bottom:6px}
    .prompt-sub{font-size:13px;color:var(--text3)}
    @media(max-width:768px){.filter-grid{grid-template-columns:1fr 1fr}.page{padding:16px}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a><span class="sep">›</span>
        <a href="{{ route('admin.absensi-guru.index') }}">Absensi Guru</a><span class="sep">›</span>
        <span class="current">Rekap per Guru</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Rekap Absensi per Guru</h1>
            <p class="page-sub">Lihat rangkuman kehadiran guru dalam rentang tanggal tertentu</p>
        </div>
        <a href="{{ route('admin.absensi-guru.index') }}" class="btn btn-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    <div class="filter-card">
        <p class="filter-title">Filter Rekap</p>
        <form method="GET" action="{{ route('admin.absensi-guru.rekap') }}">
            <div class="filter-grid">
                <div class="field">
                    <label>Guru (Opsional)</label>
                    <select name="guru_id">
                        <option value="">Semua Guru</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id }}" {{ $request->guru_id == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Dari Tanggal <span style="color:var(--brand)">*</span></label>
                    <input type="date" name="tanggal_dari" value="{{ $request->tanggal_dari }}" required>
                </div>
                <div class="field">
                    <label>Sampai Tanggal <span style="color:var(--brand)">*</span></label>
                    <input type="date" name="tanggal_sampai" value="{{ $request->tanggal_sampai }}" required>
                </div>
                <div>
                    <button type="submit" class="btn-filter">Tampilkan Rekap</button>
                </div>
            </div>
        </form>
    </div>

    @if(is_null($absensi))
    <div class="result-card">
        <div class="prompt-box">
            <div class="prompt-icon">
                <svg width="24" height="24" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/></svg>
            </div>
            <p class="prompt-title">Pilih Rentang Tanggal</p>
            <p class="prompt-sub">Tentukan periode dan guru untuk menampilkan rekap absensi</p>
        </div>
    </div>
    @else
    <div class="result-card">
        <div class="result-topbar">
            <p class="result-title">
                Rekap Absensi
                <span>— {{ $request->tanggal_dari }} s/d {{ $request->tanggal_sampai }}{{ $guru ? ' · '.$guru->nama_lengkap : '' }}</span>
            </p>
            <div class="result-actions">
                <a href="{{ route('admin.absensi-guru.export.rekap-pdf', $request->query()) }}" class="btn btn-sm btn-del" target="_blank">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
            </div>
        </div>

        @forelse($absensi as $guruId => $records)
        @php
            $namaGuru = $records->first()->guru->nama_lengkap ?? '—';
            $totalHadir = $records->whereIn('status', ['hadir','telat'])->count();
            $totalIzin  = $records->where('status','izin')->count();
            $totalSakit = $records->where('status','sakit')->count();
            $totalAlfa  = $records->where('status','alfa')->count();
        @endphp
        <div style="border-bottom:2px solid var(--border);padding:14px 20px;background:var(--surface2);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px">
            <div>
                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--text)">{{ $namaGuru }}</span>
                <span style="font-size:12px;color:var(--text3);margin-left:10px">{{ $records->count() }} data</span>
            </div>
            <div style="display:flex;gap:12px;font-size:12.5px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">
                <span style="color:#15803d">Hadir: {{ $totalHadir }}</span>
                <span style="color:#1d4ed8">Izin: {{ $totalIzin }}</span>
                <span style="color:#6d28d9">Sakit: {{ $totalSakit }}</span>
                <span style="color:#dc2626">Alfa: {{ $totalAlfa }}</span>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>#</th><th>Tanggal</th><th class="center">Jam Masuk</th><th class="center">Jam Keluar</th><th class="center">Status</th><th class="center">Metode</th><th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $i => $r)
                <tr>
                    <td class="muted">{{ $i + 1 }}</td>
                    <td style="font-weight:600;font-family:'Plus Jakarta Sans',sans-serif">{{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y') }}</td>
                    <td class="center muted">{{ $r->jam_masuk ?? '—' }}</td>
                    <td class="center muted">{{ $r->jam_keluar ?? '—' }}</td>
                    <td class="center">
                        @php $bc=['hadir'=>'b-hadir','telat'=>'b-telat','izin'=>'b-izin','sakit'=>'b-sakit','alfa'=>'b-alfa'][$r->status]??'b-alfa'; @endphp
                        <span class="badge {{ $bc }}"><span class="badge-dot"></span>{{ ucfirst($r->status) }}</span>
                    </td>
                    <td class="center muted">{{ ucfirst($r->metode) }}</td>
                    <td class="muted">{{ $r->keterangan ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @empty
        <div class="empty-state">
            <p class="empty-title">Tidak ada data absensi</p>
            <p class="empty-sub">Tidak ditemukan data pada rentang tanggal yang dipilih</p>
        </div>
        @endforelse
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});@endif
    @if(session('error'))Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});@endif
</script>
</x-app-layout>