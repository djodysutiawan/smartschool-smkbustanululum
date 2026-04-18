<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;--brand-100:#d9ebff;--brand-50:#eef6ff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand-600);}
    .breadcrumb .sep{color:var(--border2);}.breadcrumb .current{color:var(--text2);}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn-back{padding:8px 14px;font-size:13px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
    .btn-back:hover{background:var(--surface3);}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}
    .btn-edit:hover{background:var(--brand-100);filter:none;}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-del:hover{background:#fee2e2;filter:none;}
    .detail-grid{display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:16px;}
    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .card-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;background:var(--surface2);}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;}
    .card-body{padding:20px;}
    .info-row{display:flex;justify-content:space-between;align-items:flex-start;padding:10px 0;border-bottom:1px solid #f1f5f9;gap:12px;}
    .info-row:last-child{border-bottom:none;padding-bottom:0;}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);flex-shrink:0;min-width:120px;}
    .info-val{font-size:13.5px;color:var(--text);font-family:'DM Sans',sans-serif;text-align:right;}
    .nilai-summary{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:28px 20px;text-align:center;}
    .nilai-circle{width:100px;height:100px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-direction:column;margin-bottom:12px;border:4px solid;}
    .predikat-a{border-color:#15803d;background:#f0fdf4;color:#15803d;}
    .predikat-b{border-color:#2563eb;background:#eff6ff;color:#2563eb;}
    .predikat-c{border-color:#d97706;background:#fefce8;color:#d97706;}
    .predikat-d{border-color:#dc2626;background:#fee2e2;color:#dc2626;}
    .predikat-e{border-color:#9f1239;background:#fff1f2;color:#9f1239;}
    .circle-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;font-weight:800;line-height:1;}
    .circle-lbl{font-size:10px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;opacity:.7;margin-top:2px;}
    .pred-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;}
    .bar-wrap{margin-top:16px;width:100%;}
    .bar-row{display:flex;align-items:center;gap:8px;margin-bottom:10px;}
    .bar-label{font-size:11.5px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text3);width:55px;flex-shrink:0;}
    .bar-bg{flex:1;height:8px;border-radius:99px;background:var(--surface3);}
    .bar-fill{height:8px;border-radius:99px;background:var(--brand-600);}
    .bar-val{font-size:12px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text2);width:32px;text-align:right;flex-shrink:0;}
    .catatan-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 16px;font-size:13.5px;color:var(--text2);font-family:'DM Sans',sans-serif;line-height:1.6;}
    @media(max-width:768px){.detail-grid{grid-template-columns:1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.nilai.index') }}">Nilai Siswa</a>
        <span class="sep">›</span>
        <span class="current">Detail Nilai</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $nilai->siswa->nama_lengkap ?? 'Detail Nilai' }}</h1>
            <p class="page-sub">{{ $nilai->mataPelajaran->nama_mapel ?? '' }} · {{ $nilai->kelas->nama_kelas ?? '' }} · {{ $nilai->tahunAjaran->tahun ?? '' }}</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <a href="{{ route('admin.nilai.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.nilai.edit', $nilai->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.nilai.destroy', $nilai->id) }}" method="POST" id="deleteForm">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="detail-grid">
        <div style="display:flex;flex-direction:column;gap:16px">
            <div class="detail-card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    <p class="card-title">Informasi Siswa &amp; Mata Pelajaran</p>
                </div>
                <div class="card-body">
                    <div class="info-row"><span class="info-label">Nama Siswa</span><span class="info-val" style="font-weight:700">{{ $nilai->siswa->nama_lengkap ?? '-' }}</span></div>
                    <div class="info-row"><span class="info-label">Mata Pelajaran</span><span class="info-val">{{ $nilai->mataPelajaran->nama_mapel ?? '-' }}</span></div>
                    <div class="info-row"><span class="info-label">Guru</span><span class="info-val">{{ $nilai->guru->nama_lengkap ?? '-' }}</span></div>
                    <div class="info-row"><span class="info-label">Kelas</span><span class="info-val">{{ $nilai->kelas->nama_kelas ?? '-' }}</span></div>
                    <div class="info-row"><span class="info-label">Tahun Ajaran</span><span class="info-val">{{ $nilai->tahunAjaran->tahun ?? '-' }} - {{ ucfirst($nilai->tahunAjaran->semester ?? '') }}</span></div>
                    <div class="info-row"><span class="info-label">Dibuat</span><span class="info-val" style="color:var(--text3);font-size:12.5px">{{ $nilai->created_at->format('d M Y, H:i') }}</span></div>
                    <div class="info-row"><span class="info-label">Diperbarui</span><span class="info-val" style="color:var(--text3);font-size:12.5px">{{ $nilai->updated_at->format('d M Y, H:i') }}</span></div>
                </div>
            </div>

            <div class="detail-card">
                <div class="card-header">
                    <svg width="13" height="13" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    <p class="card-title">Rincian Nilai</p>
                </div>
                <div class="card-body">
                    <div class="info-row"><span class="info-label">Nilai Tugas</span><span class="info-val" style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">{{ $nilai->nilai_tugas ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Nilai Harian</span><span class="info-val" style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">{{ $nilai->nilai_harian ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Nilai UTS</span><span class="info-val" style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">{{ $nilai->nilai_uts ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Nilai UAS</span><span class="info-val" style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">{{ $nilai->nilai_uas ?? '—' }}</span></div>
                    <div class="info-row">
                        <span class="info-label">Nilai Akhir</span>
                        <span class="info-val" style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:16px;color:var(--brand-600)">
                            {{ $nilai->nilai_akhir !== null ? number_format($nilai->nilai_akhir, 2) : '—' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-card">
            <div class="card-header">
                <svg width="13" height="13" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                <p class="card-title">Rekap &amp; Predikat</p>
            </div>
            <div class="card-body">
                @php $pred = strtolower($nilai->predikat ?? 'e'); @endphp
                <div class="nilai-summary">
                    <div class="nilai-circle predikat-{{ $pred }}">
                        <span class="circle-num">{{ $nilai->nilai_akhir !== null ? number_format($nilai->nilai_akhir, 0) : '—' }}</span>
                        <span class="circle-lbl">NILAI AKHIR</span>
                    </div>
                    <p class="pred-text" style="color:{{ $pred==='a'?'#15803d':($pred==='b'?'#2563eb':($pred==='c'?'#d97706':($pred==='d'?'#dc2626':'#9f1239'))) }}">
                        Predikat {{ strtoupper($pred) }}
                    </p>
                </div>
                <div class="bar-wrap">
                    @foreach(['Tugas' => $nilai->nilai_tugas, 'Harian' => $nilai->nilai_harian, 'UTS' => $nilai->nilai_uts, 'UAS' => $nilai->nilai_uas] as $lbl => $val)
                    <div class="bar-row">
                        <span class="bar-label">{{ $lbl }}</span>
                        <div class="bar-bg"><div class="bar-fill" style="width:{{ $val ?? 0 }}%"></div></div>
                        <span class="bar-val">{{ $val ?? '—' }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @if($nilai->catatan)
    <div class="detail-card">
        <div class="card-header">
            <svg width="13" height="13" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <p class="card-title">Catatan</p>
        </div>
        <div class="card-body"><div class="catatan-box">{{ $nilai->catatan }}</div></div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
    @endif
    @if(session('error'))
    Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
    @endif
    function confirmDelete(){
        Swal.fire({
            title:'Hapus Nilai?',text:'Data nilai ini akan dihapus secara permanen.',icon:'warning',
            showCancelButton:true,confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal'
        }).then(r=>{if(r.isConfirmed)document.getElementById('deleteForm').submit();});
    }
</script>
</x-app-layout>